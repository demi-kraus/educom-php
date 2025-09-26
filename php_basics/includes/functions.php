<?php
// =========================
// style page 
// =========================
function stylePage($cssfile = '"css/style.css"'){
    echo "<head>
        <link rel=\"stylesheet\" href= $cssfile/>
    </head>";
}

// =========================
// show header
// =========================
function showHeader($title){

    echo "<header> 
            <h1> $title </h1>
          </header>";
}

// =========================
// show menu
// =========================
function showMenu($menu){
    echo "<ul class=\"menu\"> ";
    foreach ($menu as $item => $link){
        // $item = strtoupper($item);
       echo "<li> <a href= \"".$link."\">". $item . "</a> </li>";
    }
    echo "</ul>";
}

// =========================
// Login or Register
// =========================

//login
function login($email, $password){
    global $login, $page, $error;

    $conn = connectMysql();
    $result = findEmail($conn, $email);
    $row = $result->fetch_assoc();
    // check number if rows, if =1 than check password, otherwise invalid & check password
    if (($result->num_rows == 1) and (strcmp($password, $row['password']) == 0)){  
        // $login = true;
        $_SESSION['login'] = true;
        $_SESSION['username']  = $row['name'];
    } else {
        $error = 'Invalid Credentials';
        $page = $_POST['page'];
    }
    closeMysql($conn);
}
//register
function register($email, $username,$password, $repeat_password){
    global $page, $error;
    $conn = connectMysql();
    $result = findEmail($conn, $email);
    $row = $result->fetch_assoc();
    // check number if rows if 0 and passwords map add user. otherwise
    if ($result->num_rows > 0) {
        $error = 'E-mail is already registerd';
        $page = $_POST['page'];
    }elseif (($result->num_rows == 0) and (strcmp($password, $repeat_password) != 0)){  
        $error = 'Passwords do not match';
        $page = $_POST['page'];
    } elseif(($result->num_rows == 0) and (strcmp($password, $repeat_password) == 0)){
        // add data to table
        $stmt = $conn->prepare("INSERT INTO users (email, name, password) VALUES (?,?,?)");
        $stmt->bind_param('sss', $email, $username, $password);
        $stmt->execute();
        $stmt->close();
    }

    closeMysql($conn);

}

//find results where user email is in table
function findEmail($conn, $email){
    // find row where email = email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

// test input fields form
function testInputFields($fields){
    $error =  "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        foreach($fields as $fieldname => $fieldinfo){
          if (empty($_POST[$fieldname])) {
                    $error = "* All fields are required";
                    break;
            } 
            else{
                    $fields[$fieldname]['value'] = $_POST[$fieldname];
            }
        }   
    }
    return array($error, $fields);
}
// =========================
// Webshop
// =========================

function showItemList(){
    // Get webshop items from database
    $sql = 'SELECT * FROM webshop_items';
    $result = executeMysqlQuery($sql);

    $page = "index.php?page=webshop_item"; 

    // show webshop items
    while($row = $result->fetch_assoc()) {
        $item_page = $page.'&id='.$row['id']; // link for item page 
        // for each item show name, image, price
        // when logged in show order button !!!
        echo '<section class="webshop-item">';
        echo '<a href='.$item_page.'>'.ucfirst($row['name']).' </a>'; // name with link to item page
        echo '<img src= "images/'.$row['image'].'" alt = "webshopitem" width = 100 >'; // item image
        echo '<br><span> &euro; '.$row['price'].' </span>' ; //item price

        if ($_SESSION['login']){ //show only when logged in
            orderButton($row['id']);
            }
        echo '</section>';
        }
}

function ShowItemPage(){
        // get item properties from db
        $item_id = $_GET['id'];
        $sql = 'SELECT * FROM webshop_items WHERE id='.$item_id;
        $result = executeMysqlQuery($sql);

        //check if item exists
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
        } else{
            echo 'No item found';
        }

        // When order button is used -> add order to orderlist
        addOrder();

        //show item 
        echo '<section class="item-page">';
        echo '<h1>'.ucfirst($row['name']).'</h1>'; 
        echo '<span class="price"> &euro;'.$row['price'].'</span>';
        echo '<span>'.$row['description'].'</span>';
        echo '<img src= "images/'.$row['image'].'" alt = "webshopitem" width = 400 height = 400>';
        echo '</section>';

        if ($_SESSION['login']){ //show only when logged in
            orderButton($item_id);
        }
}

function ShowOrderList(){
    echo '<h2> Order list </h2>';

    // get order items and sort and count each value
    $order = $_SESSION['orders'];
    sort($order); 
    $order = array_count_values($order); // count unique values

    // find order ids in webshop_item table
    $total_price = 0;
    $conn = connectMysql(); // connect to database
    foreach ($order as $item_id => $count){
            $sql = 'SELECT * FROM webshop_items where id='.$item_id;
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $name =$row['name'];
            $item_price = $row['price'];
            $total_item_price = $count*$item_price;
            echo $name.' - price:&euro;'.$item_price.' - amount:'.$count.' - &euro;'.$total_item_price;
            echo '<br>';

            $total_price += $total_item_price;
        }

    echo 'Total: '.$total_price;
    closeMysql($conn); // close connection database

    orderButton(true, $type='checkout');
}
// When order button is used -> add order to orderlist
function addOrder(){
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = []; // Initialize only once, not on every request
    }elseif (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['item_id']))){
        $_SESSION['orders'][] = $_POST['item_id'];
    }
}

// order button and checkout button
function orderButton($value, $type='order'){
        switch($type){
            case 'order':
                $name = 'item_id';
                break;
            case 'checkout':
                $name = 'checkout';
                break;
        }
        echo '<form action="" method="POST">
                <input type="hidden" name="'.$name.'" value="'.$value.'" >
                <input class="order-button" type="submit" value= "'.$type.'">
              </form>';

}
// =========================
// Shopping cart
// ========================= 

function checkout(){
    // check for POST for checkout
    if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['checkout']))){
        $conn = connectMysql(); // connect to database

        // write orders to database
        $stmt = $conn->prepare("INSERT INTO orders ( name, price, amount, item_id) VALUES (?,?,?,?)");
        $stmt->bind_param("sdii", $name, $price, $amount, $item_id);

        $order = $_SESSION['orders'];
        sort($order); 
        $order = array_count_values($order); // count unique values
        foreach ($order as $item_id => $amount){
            $sql = 'SELECT * FROM webshop_items where id='.$item_id;
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $name =$row['name'];
            $price = $row['price'];
            $stmt->execute(); // write to database table
        }

        //close connection mysql
        $stmt->close();
        closeMysql($conn);
        session_unset();
    }
}

// =========================
// Mysql 
// =========================
//connect to mysql

function executeMysqlQuery($sql){
    $conn =connectMysql();
    $result = $conn->query($sql);
    closeMysql($conn);

    return $result;
}
function connectMysql(){
    $servername_mysql = "localhost";
    $username_mysql = "root";
    $password_mysql = "TrinaDePipa";
    $dbname = "mydb";

    // Create connection
    $conn = new mysqli($servername_mysql, $username_mysql, $password_mysql, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

//close mysql connection
function closeMysql($conn){
    $conn->close();
}

// =========================
// form
// =========================
function showForm($form_info){
    $page = $form_info['page'];
    $fields = $form_info['fields'];
    openForm($page);
    showFields($fields); 
    closeForm(); 
}


// =========================
// forms
// =========================
// open form
function openForm($page){
    echo '<form method="POST" action = "index.php" >
            <div class="form">
            <input type="hidden" name = "page" value="'.$page.'" />';
}

// show Form
function showFields($fields){
    foreach ($fields as $fieldname => $fieldinfo){
        echo '<label for='.$fieldname.'>'
            .$fieldinfo['label'].' </label>';
        
        switch($fieldinfo['type']){
            case 'textarea':
                echo '<textarea name='.$fieldname.
                        ' rows=4 required>'. $fieldinfo['value'] .'</textarea><br><br>';
                break;
            default:
                echo '<input type='.$fieldinfo['type'].
                        ' name='.$fieldname.
                        ' value= "'.$fieldinfo['value'].'" required ><br><br>';
        }
    }
}

//close form
function closeForm(){
    echo '<input type="submit" value="submit">
            </div>
            </form>';
}

// =========================
// show footer
// =========================
function showFooter(){
    echo "<footer> &copy 2010-".date('Y')."</footer>"; 
}

?>
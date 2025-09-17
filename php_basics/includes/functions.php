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
//connect to mysql
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

//find results email in table
function findEmail($conn, $email){
    // find row where email = email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
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

// test input fields
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

// open form
function openForm($page){
    echo '<form method="POST" action = "index.php" >
            <div class="form">
            <input type="hidden" name = "page" value="'.$page.'" />';
            // <span class= "error">'. $error.'</span><br>';
}

// show Form
function showFields($fields){
    foreach ($fields as $fieldname => $fieldinfo){
        echo '<label for='.$fieldname.'>'
            .$fieldinfo['label'].' </label>';
        
        switch($fieldinfo['type']){
            case 'textarea':
                echo '<textarea name='.$fieldname.
                        ' rows=4 required>'. $fieldinfo['value'] .'</textarea><br>';
                break;
            default:
                echo '<input type='.$fieldinfo['type'].
                        ' name='.$fieldname.
                        ' value= "'.$fieldinfo['value'].'" required ><br>';
        }
    }
}

//close form
function closeForm(){
    echo '</div>
            <input type="submit" value="submit">
            </form>';
}

// =========================
// show footer
// =========================
function showFooter(){
    echo "<footer> &copy 2010-".date('Y')."</footer>";
   
}

?>
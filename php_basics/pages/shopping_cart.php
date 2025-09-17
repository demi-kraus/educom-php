<?php
// check for POST
if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['checkout']))){
    $conn = connectMysql();

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
        $stmt->execute();
    }
    $stmt->close();
    closeMysql($conn);
    session_unset();
}


// get orders 
if (!empty($_SESSION['orders'])){
    echo '<h2> Order list </h2>';
    $order = $_SESSION['orders'];
    sort($order); 
    $order = array_count_values($order); // count unique values


    // find order ids in webshop_item table
    $total_price = 0;
    $conn = connectMysql();
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
    closeMysql($conn);

    echo '<form action="" method="POST">
            <input type="hidden" name="checkout" value="true" >
            <input type="submit" value= "checkout">
            </form>';
    }
else{ echo '<h2> Shopping cart is empty </h2>';}
?>
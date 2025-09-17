<?php
// get ti properties from db
$item_id = $_GET['id'];
$conn = connectMysql();

$sql = 'SELECT * FROM webshop_items WHERE id='.$item_id;
$result = $conn->query($sql);
closeMysql($conn);

if ($result->num_rows == 1){
    $row = $result->fetch_assoc();
} else{
    echo 'No item found';
}

// add order to orderlist
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = []; // Initialize only once, not on every request
}elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
  $_SESSION['orders'][] = $item_id;
}

print_r($_SESSION['orders']); // test order list

//show item
$name =$row['name'];
$image = $row['image'];
$price =$row['price'];
$description =$row['description'];
echo '<h1>'.$name.'</h1>';
echo '<img src= "images/'.$image.'" alt = "webshopitem" width = 400 height = 400> <br>';
echo  '&euro;'.$price;
echo '<p>'.$description.'</p>';

if ($_SESSION['login']){
    echo '<form action="" method="POST">
            <input type="submit" value= "Order">
            </form>';
 }

?>
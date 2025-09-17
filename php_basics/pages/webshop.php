<?php
// add order to orderlist
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = []; // Initialize only once, not on every request
}elseif (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['id_order']))){
  $_SESSION['orders'][] = $_POST['id_order'];
}

// connect to db
$conn = connectMysql();
$sql = 'SELECT * FROM webshop_items';
$result = $conn->query($sql);
$page = "index.php?page=webshop_item";
closeMysql($conn);

// show webshop items
while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $name =$row['name'];
    $image = $row['image'];
    $price =$row['price'];
    $description =$row['description'];
    $item_page = $page.'&id='.$id;

    // for each item show name, image, price
    // when logged in show order button !!!
    echo '<section class="webshop-item">';
    echo '<a href='.$item_page.'>'.$name.' </a>
            <img src= "images/'.$image.'" alt = "webshopitem" width = 100 height = 100>
          <br><span> &euro; '.$price.' </span>' ;

    if ($_SESSION['login']){
        echo '<form action="" method="POST">
                <input type="hidden" name="id_order" value="'.$id.'" >
                <input type="submit" value= "Order">
              </form>';
       }
   echo '</section>';
}


?>

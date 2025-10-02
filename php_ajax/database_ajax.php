<?php

require_once('models/DataBase.php');

// set up Database
$servername = "localhost"; 
$username = "root";
$password = "TrinaDePipa";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// create table
// $sql = "CREATE TABLE ratings(
//         id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//         product_id INT(6) NOT NULL,
//         rating TINYINT NOT NULL,
//         user_id INT(6) NOT NULL)";


// if ($conn->query($sql) === TRUE) {
//   echo "Table MyGuests created successfully";
// } else {
//   echo "Error creating table: " . $conn->error;
// }

// Save rating with item id and user id. If rating already exists, than update table with new rating
function saveRating($conn, $rating, $item_id, $user_id){

    $sql = 'SELECT * FROM ratings 
                WHERE product_id='.$item_id.' AND user_id='.$user_id ;

    $result = $conn->query($sql);

    // if not found add rating to table
    if ($result->num_rows==0){
        $sql = 'INSERT INTO ratings (product_id, rating, user_id) VALUES ('.$item_id.', '.$rating.', '.$user_id.')';
        echo 'rating is saved';
    } else {
        $sql = 'UPDATE ratings SET rating='.$rating.' WHERE product_id='.$item_id.' AND user_id='.$user_id ;
        echo 'rating is updated';
    }
    $conn->query($sql);
}

$rating = 2;
$item_id = 1;
$user_id = 2;
saveRating($conn, $rating, $item_id, $user_id);

//get average rating 
function getAverageRating($conn, $item_id){
    $sql = 'SELECT AVG(rating) FROM ratings WHERE product_id='.$item_id;
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();

    return $result['AVG(rating)'];
}

$item_id = 1;
$avg = getAverageRating($conn, $item_id);
s
?>
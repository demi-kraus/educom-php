<?php
include('includes/functions.php');

$conn = connectMysql();

// // sql to create table
// $sql = "CREATE TABLE orders(
// id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// name VARCHAR(30) NOT NULL,
// price DOUBLE(10,2),
// amount INT(6) UNSIGNED,
// item_id INT(6) UNSIGNED
// )";

// if ($conn->query($sql) === TRUE) {
//   echo "Table MyGuests created successfully";
// } else {
//   echo "Error creating table: " . $conn->error;
// }



closeMysql($conn)
?>
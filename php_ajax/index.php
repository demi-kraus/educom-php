<?php

session_start();
require_once('models/DataBase.php');
require_once('controllers/Controller.php');

// set up Database
$servername = "localhost"; 
$username = "root";
$password = "TrinaDePipa";
$dbname = "mydb";

$db = new DataBase($servername, $username, $password, $dbname);

// start controller
$controller = new Controller($db);
$controller->handleRequest();

?>

<?php 
echo '<h2> Form results:</h2>';
$name = $_POST["name"];  
$email = $_POST["email"];
$message = $_POST["message"];

echo 'Naam: '.$name;
echo "<br>";
echo 'E-mail: '.$email;
echo "<br>";
echo 'Bericht: '.$message;
echo "<br>";
?>


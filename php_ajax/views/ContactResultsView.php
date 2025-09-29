<?php
require_once('PageView.php');

class ContactResultsView extends PageView{

    function bodyContent(){
        echo '<h2> Form results:</h2>';

        echo 'Naam: '.$_POST["name"];
        echo "<br>";
        echo 'E-mail: '.$_POST["email"];
        echo "<br>";
        echo 'Bericht: '.$_POST["message"];
        echo "<br>";

    }
}
?>
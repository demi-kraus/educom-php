<?php

include('functions.php');

// style page
stylePage();

// header
$title = 'Welcom!';
showHeader($title);

// show Menu;
$menu = array("HOME" => "home.php", 
                "ABOUT" => "about.php",
                "CONTACT" => "contact.php");
showMenu($menu);        

// footer
showFooter();


?>  
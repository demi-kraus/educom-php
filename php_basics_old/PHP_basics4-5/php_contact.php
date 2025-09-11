<?php

include('functions.php');

// style page
stylePage();

// header
$title = 'Welcom!';
showHeader($title);

// show Menu;
$menu = array("HOME" => "php_home.php", 
                "ABOUT" => "php_about.php",
                "CONTACT" => "php_contact.php");
showMenu($menu);        

// show Form
$fields = [];
$fields['name'] = ['label' => 'Name' , 'type' => 'text', 'value'=>''];
$fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
$fields['message'] = ['label' => 'Bericht' , 'type' => 'textarea', 'value'=>''];


showForm($fields);

// footer
showFooter();


?>  
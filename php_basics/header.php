<?php
stylePage();
// header
$title = 'Welcome!';
showHeader($title);

// show Menu;
$menu = array("HOME" => "index.php?page=home", 
                "ABOUT" => "index.php?page=about",
                "CONTACT" => "index.php?page=contact");

                
// check if there is logged in
if ($login){
    $menu_str = 'LOGOUT: '.$username;
    $menu[$menu_str] = "index.php?page=home";
}  
else {
    $menu['LOG IN'] = "index.php?page=login";
    $menu['REGISTER'] = "index.php?page=register";
}

showMenu($menu);        

?>

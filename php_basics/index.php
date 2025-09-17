<?php
session_start();
include('includes/functions.php');

// page
$page = isset($_GET['page']) ? $_GET['page'] : "home";
//if logged out, reset session variables
if ($page == 'logout'){session_unset();}

// Chech if there is logged in
$_SESSION['login'] = isset($_SESSION['login'] ) ? $_SESSION['login'] : false;

// test POST 
include('includes/handlers.php');

// header
include('header.php');

// show error if necessary
if (isset($error)){
    echo '<span class="error">'.$error.'</span><br>';
    }

// page
switch($page){
    case 'about':
        include('pages/about.php');
        break;
    case 'contact':
        include('pages/contact.php');
        break;
    case 'form_results':
        include('pages/form_results.php');
        break;
    case 'login':
        include('pages/login.php');
        break;
    case 'register':
        include('pages/register.php');
        break; 
    case 'webshop':
        include('pages/webshop.php');
        break;
    case 'webshop_item':
        include('pages/webshop_item.php');
        break;
    case 'shopping_cart':
        include('pages/shopping_cart.php');
        break;
    default:
        include('pages/home.php');
}

// footer
include('footer.php')

?>
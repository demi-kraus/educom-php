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
if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['page']))){

    switch($_POST['page']){
        case 'form_results':
            $page = $_POST['page'];
            break;
            
        case 'login':
            // test login'
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            login($email, $password);
            break;

        case 'register':
            $email = trim($_POST['email']);
            $username = $_POST['name'];
            $password = trim($_POST['password']);
            $repeat_password = trim($_POST['repeat_password']);
            register($email, $username, $password, $repeat_password);
            break;
    }
}
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
<?php
include('includes/functions.php');
// page
$page = isset($_GET['page']) ? $_GET['page'] : "home";
$login = false;

// test POST 
include('includes/handlers.php');

// header
include('header.php');

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
    default:
        include('pages/home.php');
}

// footer
include('footer.php')
?>
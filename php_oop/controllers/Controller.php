<?php
class PageController{
    $db;
    $UserModel;
    $page;

    function __construct($db){
        $this->db = $db;
        require_once('../models/UserModel.php');
        $this->UserModel = new Usermodel($db);
    }

    function handleRequest(){
        //initiate $page
        $page = isset($_GET['page']) ? $_GET['page'] : "home";

        //if logged out, reset session variables
        if ($page == 'logout'){session_unset();}
        // Check if there is logged in
        $_SESSION['login'] = isset($_SESSION['login'] ) ? $_SESSION['login'] : false;

        // check post page
        if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['page']))){

            switch($_POST['page']){
                case 'form_results':
                    $this->page = $_POST['page'];
                    break;
                    
                case 'login':
                    // test login'
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $login = $this->UserModel->login($email, $password);
                    $this->page = $login['page'];
                    break;

                case 'register':
                    $email = trim($_POST['email']);
                    $username = $_POST['name'];
                    $password = trim($_POST['password']);
                    $repeat_password = trim($_POST['repeat_password']);
                    $register = $this->UserModel->register($email, $username, $password, $repeat_password);
                    $this->page = $login['page'];
                    break;
            }
        }

        // check post item_id for orders
        if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = []; // Initialize only once, not on every request
        } elseif (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['item_id']))){
        $_SESSION['orders'][] = $_POST['item_id'];
        }

        // check for POST for checkout
        if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['checkout']))){
            require_once('../models/ShoppingcartModel.php');
            $ShoppingcartModel = new ShoppingcartModel();
            $ShoppingcartModel->checkout()''
        }

        $this->DisplayPage()
  
    }

    private function DisplayPage(){
        // page
        switch($this->page){
            case 'about':
                require_once('views/AboutView.php');
                $pageView = new AboutView();
                $pageView->show();
                break;
            case 'contact':
                require_once('');
                break;
            // case 'form_results':
            //     require_once('');
            //     break;
            // case 'login':
            //     require_once('');
            //     break;
            // case 'register':
            //     require_once('');
            //     break;
            // case 'webshop':
            //     require_once('');
            //     break;
            // case 'webshop_item':
            //     require_once('');
            //     break;
            // case 'shopping_cart':
            //     require_once('');
            //     break;
            default:
                require_once('views/PageView.php');
                $pageView = new PageView();
                $pageView->show();
                break;

            }
        }       
}
?>
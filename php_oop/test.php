        
       <?php
       //initiate $page
        $this->page = $_GET['page'] ?? "home";

        //if logged out, reset session variables
        if ($this->page == 'logout'){session_unset();}
    
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
                    if ($login['login'] ==true){
                        $_SESSION['login'] = true;
                        $_SESSION['username']  =$login['username'];
                    } else{
                        $this->page = $_POST['page'];
                        $_POST['form_error'] =  'Invalid Credentials';
                    }
                    break;

                case 'register':
                    $email = trim($_POST['email']);
                    $username = $_POST['name'];
                    $password = trim($_POST['password']);
                    $repeat_password = trim($_POST['repeat_password']);
                    // $this->page = $this->UserModel->register($email, $username, $password, $repeat_password);
                    $register = $this->UserModel->register($email, $username, $password, $repeat_password);
                    if ((!$register[0]) && ($register(1)=='email_error')) {
                        $_POST['form_error'] = 'E-mail is already registered';
                        $this->page = $_POST['page'];
                    } elseif ((!$register[0]) && ($register(1)=='password_error')) {
                        $_POST['form_error'] = 'Passwords do not match';
                        $this->page = $_POST['page'];
                    } else {
                        $_POST['form_error'] = 'Registration succesfull!'
                    }

                    break;
                    break;
            }
        }

        // check post item_id for orders, if so add order to shoppingcart
        if (!isset($_SESSION['shoppingCart'])) {
            $_SESSION['shoppingCart'] = []; // Initialize only once, not on every request
        } elseif (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['item_id']))){
            // add order to shoppingcart
             $_SESSION['shoppingCart'][] = $_POST['item_id'];
        }

        // check for POST for checkout
        if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['checkout']))){
            require_once('../models/ShoppingcartModel.php');
            $ShoppingcartModel = new ShoppingcartModel();
            $ShoppingcartModel->checkout();
        }
        ?>




<?php 

      // ShoppingCart 
        // Initialize if not set
        $_SESSION['shoppingCart'] = $_SESSION['shoppingCart'] ??  [];
  
        if (($_SERVER["REQUEST_METHOD"] == "POST") and  (isset($_POST['item_id']))){
            $item =  $_POST['item_id'];
            if (isset($_SESSION['shoppingCart'][$item])) { // item already in shoppingcart
                $_SESSION['shoppingCart'][$item] += 1;
            } else{
                $_SESSION['shoppingCart'] += [$item => 1];
            }
        }

        // check for POST for checkout
        if (($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST['checkout']))){
            require_once('../models/ShoppingcartModel.php');
            $ShoppingcartModel = new ShoppingcartModel();
            $ShoppingcartModel->checkout();
        }
?>
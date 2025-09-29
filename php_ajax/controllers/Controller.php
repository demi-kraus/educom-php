<?php
class Controller{
    public $db;
    public $UserModel;
    public $page;

    function __construct($db){
        $this->db = $db;
        require_once('models/UserModel.php');
        $this->UserModel = new Usermodel($db->conn);
    }

    function handleRequest(){
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
                    $this->page= $this->UserModel->login($email, $password);
                    break;

                case 'register':
                    $email = trim($_POST['email']);
                    $username = $_POST['name'];
                    $password = trim($_POST['password']);
                    $repeat_password = trim($_POST['repeat_password']);
                    $this->page = $this->UserModel->register($email, $username, $password, $repeat_password);
                    echo 'Register';
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
            $ShoppingcartModel->checkout();
        }

        $this->DisplayPage();
  
    }

    private function DisplayPage(){
        // page
        $menu = $this->buildMenu();

        switch($this->page){
            case 'about':
                require_once('views/AboutView.php');
                $pageView = new AboutView($menu);
                $pageView->show();
                break;
            case 'contact':
                require_once('views/FormView.php');
                $form_info = $this->buildForm();
                $pageView = new FormView($menu, $form_info);
                $pageView->show();
                break;
            case 'form_results':
                require_once('views/ContactResultsView.php');
                $pageView = new ContactResultsView($menu);
                $pageView->show();
                break;
            case 'login':
                require_once('views/FormView.php');
                $form_info = $this->buildForm();
                $pageView = new FormView($menu, $form_info);
                $pageView->show();
                break;
            case 'register':
                require_once('views/FormView.php');
                $form_info = $this->buildForm();
                $pageView = new FormView($menu, $form_info);
                $pageView->show();
                break;
            case 'webshop':
                require_once('models/WebshopModel.php');
                $WebshopModel = new WebshopModel($this->db->conn);
                $webshop_items = $WebshopModel->getWebshopItems();

                require_once('views/WebshopView.php');
                $pageView = new WebshopView($menu, $webshop_items);//!!!!
                $pageView->show();
                break;
            case 'webshop_item':
                require_once('models/WebshopModel.php');
                $WebshopModel = new WebshopModel($this->db->conn);
                $webshop_item = $WebshopModel->getWebshopItems($_GET['id']);

                require_once('views/WebshopItemView.php');
                $pageView = new WebshopItemView($menu, $webshop_item);
                $pageView->show();
                break;
            case 'shopping_cart':
                require_once('models/ShoppingCartModel.php');
                $CartModel = new ShoppingCartModel($this->db->conn);
                $cart_items = $CartModel->getOrders();
 
                require_once('views/ShoppingCartView.php');
                $pageView = new ShoppingCartView($menu, $cart_items);
                $pageView->show();
                break;
            default:
                require_once('views/PageView.php');
                $pageView = new PageView($menu);
                $pageView->show();
                break;

            }
        }  
    
    function buildMenu(){
        // show Menu;
        $menu = array("HOME" => "index.php?page=home", 
                        "ABOUT" => "index.php?page=about",
                        "CONTACT" => "index.php?page=contact",
                        "WEBSHOP" => "index.php?page=webshop" );

                        
        // check if there is logged in
        if ($_SESSION['login'] ?? false){
            // shopping cart
            $menu['<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>'] = "index.php?page=shopping_cart";

            //log out
            $menu_str = 'LOGOUT: '.$_SESSION['username'];
            $menu[$menu_str] = "index.php?page=logout";

        }  
        else {
            $menu['LOG IN'] = "index.php?page=login";
            $menu['REGISTER'] = "index.php?page=register";
        }

        return $menu;
    }

    function buildForm(){
        switch($this->page){
            case 'contact':
                $fields['name'] = ['label' => 'Name' , 'type' => 'text', 'value'=>''];
                $fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
                $fields['message'] = ['label' => 'Bericht' , 'type' => 'textarea', 'value'=>''];
                $form_info['fields'] = $fields;
                $form_info['page'] = 'form_results';
                break;
            case 'login':      
                $login_info = [];
                $login_fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
                $login_fields['password'] = ['label' => 'Wachtwoord' , 'type' => 'text', 'value'=>''];

                $form_info['page'] = 'login';
                $form_info['fields'] = $login_fields;
                break;
            case 'register':
                $register_info = [];
                $register_fields['name'] = ['label' => 'Naam' , 'type' => 'text', 'value'=>''];
                $register_fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
                $register_fields['password'] = ['label' => 'Wachtwoord' , 'type' => 'text', 'value'=>''];
                $register_fields['repeat_password'] = ['label' => 'Herhaal Wachtwoord' , 'type' => 'text', 'value'=>''];

                $form_info['page'] = 'register';
                $form_info['fields'] = $register_fields;
                break;
        }

        return $form_info;
    }
}
?>
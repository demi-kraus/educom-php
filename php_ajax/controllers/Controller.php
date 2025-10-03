<?php

class Controller{

    public $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function handleRequest(){
        $request = $this->getRequest();
        $response = $this->validateRequest($request);
        // $this->showResponse($response);
    }

    private function getRequest(){
        // get request page/post/ajax
        $posted = ($_SERVER["REQUEST_METHOD"] == "POST");
        $page = $this->getVar("page", "home");  // check if post page exists to get page var, otherwise set page with get
        $isajax = $this->getVar("action") == "ajaxcall";

        return [ 'posted' => $posted,
                    'page' => $page,
                    'isajax' => $isajax];
    }

    private function showResponse($response){
        require_once('PageController.php');
        $PageController = new pageController($response['page'], $this->db->conn);
        $PageController->displayPage();
    }

    private function getVar($name, $default=false){
        return isset($_GET[$name])? $_GET[$name] : $default;
    }

    private function validateRequest($request){
        $response = $request;

        // logout 
        if ($request['page'] == 'logout')
            {session_unset(); 
             $request['page'] = 'home'; }

        // request afhandeling post and ajax
        if ($request['posted']){
            $response = $this->handlePostRequest($response);
            $this->showResponse($response);
        } elseif ($request['isajax']){
            $this->handleAjaxRequest($response);
        } else{
            $this->showResponse($response);
        }

    }


    private function handlePostRequest($response){
        if (isset($_POST['page'])){
            switch ($_POST['page']){
                case 'login':
                    require_once('UserController.php');
                    $UserController = new UserController($this->db->conn);
                    $UserController->login();
                    $response['page'] = $_SESSION['login'] ? 'home' : 'login' ;
                    break;
                case 'register':
                    require_once('UserController.php');
                    $UserController = new UserController($this->db->conn);
                    $UserController->register();
                    $response['page'] = $_POST['page'];
                    break;
                case 'form_results':
                    $response['page'] = $_POST['page'];
                    break;
                case 'cart':
                    require_once('CartController.php');
                    $CartController = new CartController($this->db->conn);
                    $CartController->handleRequest();
            }
        } 

        return $response;
    }

    private function handleAjaxRequest(){
        require_once('AjaxController.php');
        $AjaxController = new AjaxController($this->db->conn);
        $AjaxController->handleRequest();
        }

}
?>
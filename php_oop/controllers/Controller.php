<?php
class PageController{
    $db;
    $UserModel;
    function __construct($db){
        $this->db = $dbl

        require_once('../models/UserModel.php')
        $this->UserModel = new Usermodel($db);
            
    }

    function handleRequest(){

    }


    function getRequest(){

    }

    function DisplayPage(){
        // page
        switch($this->pageparameter){
            case 'about':
                require_once('');
                $pageView = new page();
                break;
            case 'contact':
                require_once('');
                break;
            case 'form_results':
                require_once('');
                break;
            case 'login':
                require_once('');
                break;
            case 'register':
                require_once('');
                break;
            case 'webshop':
                require_once('');
                break;
            case 'webshop_item':
                require_once('');
                break;
            case 'shopping_cart':
                require_once('');
                break;
            default:
                include('pages/home.php');

            }
        }       
}
?>
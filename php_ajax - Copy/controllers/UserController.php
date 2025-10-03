<?php

class UserController{

    function __construct($db){
        require_once('models/UserModel.php');
        $this->UserModel = new Usermodel($db->conn);
    }

    function login(){
        // test login'
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $login = $this->UserModel->login($email, $password);
        if ($login['login'] ==true){
            $_SESSION['login'] = true;
            $_SESSION['username']  =$login['username'];
        } else{
             $_SESSION['login'] = false;
            // $this->page = $_POST['page'];
            $_POST['form_error'] =  'Invalid Credentials';
        }
    }

    function register(){
        $email = trim($_POST['email']);
        $username = $_POST['name'];
        $password = trim($_POST['password']);
        $repeat_password = trim($_POST['repeat_password']);
        // $this->page = $this->UserModel->register($email, $username, $password, $repeat_password);
        $register = $this->UserModel->register($email, $username, $password, $repeat_password);
        echo '<br> register:::';
        echo $register['register'];
        echo '<br>';

        if ((!$register['register']) && ($register['message']=='email_error')) {
            $_POST['form_error'] = 'E-mail is already registered';
        } elseif ((!$register['register']) && ($register['message']=='password_error')) {
            $_POST['form_error'] = 'Passwords do not match';
        } else 
            {$_POST['form_error'] = 'Registration succesfull!';}
    
    }
}
?>
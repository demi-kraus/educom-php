<?php

class UserController{

    public function __construct($conn){
        require_once('models/UserModel.php');
        $this->UserModel = new Usermodel($conn);
    }

    public function login(){
        // test login'
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $login = $this->UserModel->login($email, $password);
        if ($login['login'] ==true){
            $_SESSION['login'] = true;
            $_SESSION['username']  =$login['username'];
        } else{
            $_SESSION['login'] = false;
            $_POST['form_error'] =  'Invalid Credentials';
        }
    }

    public function register(){
        $email = trim($_POST['email']);
        $username = $_POST['name'];
        $password = trim($_POST['password']);
        $repeat_password = trim($_POST['repeat_password']);
        $register = $this->UserModel->register($email, $username, $password, $repeat_password);
    
        if ((!$register['register']) && ($register['message']=='email_error')) {
            $_POST['form_error'] = 'E-mail is already registered';
        } elseif ((!$register['register']) && ($register['message']=='password_error')) {
            $_POST['form_error'] = 'Passwords do not match';
        } else 
            {$_POST['form_error'] = 'Registration succesfull!';}
    
    }
}
?>
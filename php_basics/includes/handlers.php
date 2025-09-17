<?php
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

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    switch($_POST['page']){
        case 'form_results':
            $page = $_POST['page'];
            break;
        case 'login':
            // test login'
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $user_file = fopen("users/users.txt", "r") ;
            $error = 'Invalid Credentials';

            while(!feof($user_file)) {
                $line_arr = explode("|", fgets($user_file));

                if  ((strcasecmp($email, trim($line_arr[0])) == 0)  
                    and (strcmp($password, trim($line_arr[2])) ==0)){
                    $username = $line_arr[1];
                    $login = true;
                    $error = '';
                    break; 
                    }
                }
            if (!$login){
                $page = $_POST['page'];
            }
            fclose($user_file);
            break;

        case 'register':

            $email = $_POST['email'];
            $username = $_POST['name'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
            $user_file = fopen("users/users.txt", "r") ;
            
            $register = true;
            $login = true;
            if (strcmp($repeat_password, $password) != 0){
                $register = false;
                $error = 'Passwords do not match';
                $login = false;
                $page = $_POST['page'];
            }
            while(!feof($user_file)) {
                $line_arr = explode("|", fgets($user_file));
                if (strcasecmp($email, $line_arr[0]) == 0){
                    $username = $line_arr[1];
                    $register = false;
                    $error = 'E-mail is already registered';
                    $page = $_POST['page'];
                    $login = false;
                    break;
                    }
                }

            
            break;
    }
}

?>
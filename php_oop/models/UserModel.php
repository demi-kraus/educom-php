<?php
class UserModel{
    protected $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
    }
    
    //login
    public function login($email, $password){
        $page = null;
        $result = $this->findEmail($email);
        $row = $result->fetch_assoc();
        // check number if rows, if =1 than check password, otherwise invalid & check password
        if (($result->num_rows == 1) and (strcmp($password, $row['password']) == 0)){  
            $login = true;
        } else {
            $login = false;
        }
        $login = ['login' => $login, 'username' => $row['name']?? null ];
        return $login;
    }

    //register
    public function register($email, $username, $password, $repeat_password){
        $result = $this->findEmail($email);
        $row = $result->fetch_assoc();
        $register = ['register'=>false, 'message'=>''];
        // check number if rows if 0 and passwords map add user. otherwise
        if ($result->num_rows > 0) {
            $register = ['register'=>false, 'message'=>'email_error'];
        }elseif (($result->num_rows == 0) and (strcmp($password, $repeat_password) != 0)){  
             $register = ['register'=>false, 'message'=>'password_error'];
        } elseif(($result->num_rows == 0) and (strcmp($password, $repeat_password) == 0)){
            // add data to table
            $stmt = $this->conn->prepare("INSERT INTO users (email, name, password) VALUES (?,?,?)");
            $stmt->bind_param('sss', $email, $username, $password);
            $stmt->execute();
            $stmt->close();
            $register = ['register'=>true, 'message'=>''];
        }
        return $register;
    }

    //find results where user email is in table
    private function findEmail($email){
        // find row where email = email
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}


?>
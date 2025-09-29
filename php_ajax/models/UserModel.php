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
            // $login = true;
            $_SESSION['login'] = true;
            $_SESSION['username']  = $row['name'];
        } else {
            $page = $_POST['page'];
            $_POST['form_error'] =  'Invalid Credentials';
        }
        return  $page;
    }

    //register
    public function register($email, $username, $password, $repeat_password){
        $page = null;
        $result = $this->findEmail($email);
        $row = $result->fetch_assoc();
        // check number if rows if 0 and passwords map add user. otherwise
        if ($result->num_rows > 0) {
            $_POST['form_error'] = 'E-mail is already registered';
            $page = $_POST['page'];
        }elseif (($result->num_rows == 0) and (strcmp($password, $repeat_password) != 0)){  
            $_POST['form_error'] = 'Passwords do not match';
            $page = $_POST['page'];
        } elseif(($result->num_rows == 0) and (strcmp($password, $repeat_password) == 0)){
            // add data to table
            $stmt = $this->conn->prepare("INSERT INTO users (email, name, password) VALUES (?,?,?)");
            $stmt->bind_param('sss', $email, $username, $password);
            $stmt->execute();
            $stmt->close();
        }
        return $page;
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
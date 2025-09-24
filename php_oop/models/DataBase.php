<?php
class DataBase{

    public $conn;

    function __construct($servername, $username, $password, $dbname){
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $this->conn;
    }

    public function getQueryResults($sql){
        $result = $this->conn->query($sql);
        return $result;
    }

    function __destruct(){
        $this->conn->close();
    }
}
?>
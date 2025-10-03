<?php

class AjaxController {
    
    public function __construct($conn){
        //initialize Shopping cart
        $this->conn = $conn;
    }

    private function getRequest(){

    }

    public function handleRequest(){
        $func = $this->getVar('func');   

        switch ($func){
            case 'setRating':
            $rating = $this->getVar('rating');
            $user_id = $this->getVar('user_id');
            $item_id = $this->getVar('item_id');
            require_once('models/RatingModel.php');
            $RatingModel = new RatingModel($this->conn, $user_id, $item_id);
            $RatingModel->handleRating($rating);
            break;
        default:
            echo 'no action defined';  
            }

    }

    private function getVar($name, $default=false){
        return isset($_GET[$name])? $_GET[$name] : $default;
    }


}
?>
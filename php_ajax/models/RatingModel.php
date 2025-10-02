<?php
class RatingModel{
    protected $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
        $this->item_id = $_GET['id'];
        $this->user_id = $_SESSION['user_id'];
    }

    public function handleRating($rating){
        $this->saveRating($rating);
        return $this->getAverageRating;
    }


    private function getAverageRating(){// model
        $sql = 'SELECT AVG(rating) FROM ratings WHERE product_id='.$this->item_id;
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        return $row['AVG(rating)'];
    }

    private function saveRating($rating){
        $sql = 'SELECT * FROM ratings // model
                    WHERE product_id='.$this->item_id.' AND user_id='.$this->user_id  ;
        $result = $this->conn->query($sql);
        // if not found add rating to table
        if ($result->num_rows==0){
            $sql = 'INSERT INTO ratings (product_id, rating, user_id) VALUES ('.$this->item_id.', '.$rating.', '.$this->user_id .')';
            // echo 'rating is saved';
        } else {
            $sql = 'UPDATE ratings SET rating='.$rating.' WHERE product_id='.$this->item_id.' AND user_id='.$this->user_id  ;
            // echo 'rating is updated';
        }
        $this->conn->query($sql);
    }
?>
<?php

class WebshopModel{
    protected $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
    }

    function getWebshopItems($item_id=''){
        $sql = 'SELECT * FROM webshop_items';

        // if item id is given only get row with item id;
        if (!empty($item_id)){$sql .= ' WHERE id='.$item_id;}
        
        $result = $this->conn->query($sql);
        // show webshop items
        while($row = $result->fetch_assoc()){
                $items[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'price' => $row['price'],
                    'description' => $row['description']];
        }
        return $items;
    }

}
?>
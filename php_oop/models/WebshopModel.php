<?php

class WebshopModel(){
    protected $db;
    
    private __construct($db){
        $this->db = $db
    }

    function getItemProperties($item_id){
        // get item properties from db
      
        $sql = 'SELECT * FROM webshop_items WHERE id='.$item_id;
        $result = $this->db->getQueryResults($sql);
        //check if item exists
        if ($result->num_rows > 0){
            $item = $result->fetch_assoc();
        } else{
            echo 'No item found';
        }
        return $item;
    }
}
?>
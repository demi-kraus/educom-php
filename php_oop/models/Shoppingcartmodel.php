<?php

class ShoppingcartModel{
    $db;

    function __construct($db){
        $this->$db = $db;
    }

    function getOrders(){
        // get order items and sort and count each value
        $order = $_SESSION['orders'];
        sort($order); 
        $order = array_count_values($order); // count unique values

        // find order ids in webshop_item table
        $total_price = 0;

        foreach ($order as $item_id => $count){
                $sql = 'SELECT * FROM webshop_items where id='.$item_id;
                $result = $db->getQueryResults($sql);
                $row = $result->fetch_assoc();

                $items[] = [
                    'id' => $item_id,
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'count' => $count,
                    'subtotal' => $count*$item_price];

                $total_price += $total_item_price;
            }
        return array('items'=> $items, 'total' => $total_price);
        }
}


?>
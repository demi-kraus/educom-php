<?php

class ShoppingcartModel{
    private $conn;

    function __construct($conn){
        $this->conn= $conn;
    }

    function getOrders(){
        // get cart items
        $cart = $_SESSION['shoppingCart'];
        // initiate 
        $cart_items = [];
        $total_price = 0;

        // 
        $stmt = $this->conn->prepare("SELECT * FROM webshop_items WHERE id = ?");
        $stmt->bind_param("i", $item_id); // "i" = integer

        foreach ($cart as $item_id => $qty){
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            $cart_items[] = [
                'id' => $item_id,
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => $qty,
                'subtotal' => $qty*$row['price']];

            $total_price += $qty*$row['price'];
        }
        $stmt->close();
        return array('items'=> $cart_items, 'total' => $total_price);
        }

    function checkout(){
         // write orders to database
        $stmt = $this->conn->prepare("INSERT INTO orders ( name, price, amount, item_id) VALUES (?,?,?,?)");
        $stmt->bind_param("sdii", $name, $price, $amount, $item_id);

        $cart_items = $this->getOrders();

        foreach ($cart_items['items'] as $item){
            $name = $item['name'];
            $price = $item['price'];
            $amount = $item['qty'];
            $item_id = $item['id'];
            $stmt->execute();
        }
        //close connection mysql
        $stmt->close();
        unset($_SESSION['shoppingCart']); 

    }
}

?>
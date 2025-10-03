<?php

class CartController {
    
    public function __construct($conn){
        //initialize Shopping cart
        $this->conn = $conn;
    }

    private function getRequest(){
        $addOrder = (isset($_POST['item_id']));
        $checkout = (isset($_POST['checkout']));
        return ['addOrder' => $addOrder, 'checkout' => $checkout];
    }

    public function handleRequest(){
        if (!isset($_SESSION['shoppingCart'])) {
            $_SESSION['shoppingCart'] = []; 
        } else{
            $result = $this->getRequest();
            if ($result['checkout']){
                $this->checkout();
            } elseif ($result['addOrder']){
                $this->addOrder();
            }
        }

    }

    private function addOrder(){
        $item =  $_POST['item_id'];
        if (isset($_SESSION['shoppingCart'][$item])) { // item already in shoppingcart
            $_SESSION['shoppingCart'][$item] += 1;
        } else{
            $_SESSION['shoppingCart'][$item] = 1;
        }
    }

    private function checkout(){
        require_once('models/ShoppingcartModel.php');
        $ShoppingcartModel = new ShoppingcartModel($this->conn);
        $ShoppingcartModel->checkout();
        echo 'checkout complete';
    }
}
?>
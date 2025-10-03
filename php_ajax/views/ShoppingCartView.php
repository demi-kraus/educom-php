<?php
require_once('PageView.php');

class ShoppingCartView extends PageView{
    private $cart;

    function __construct($menu, $cart){
        parent::__construct($menu);
        $this->cart = $cart;
    }

    function bodyContent(){
        if (empty($this->cart['items'])){
            echo '<h2> Shopping cart is empty </h2>';}
        else{$this->ShowOrderList();}
    }

    function ShowOrderList(){
        echo '<h2> Order list </h2>';

        foreach ($this->cart['items'] as $item){
            echo ucfirst($item['name']).' - price:&euro;
                '.number_format($item['price'],2).' - amount:'.$item['qty'].' - &euro;'
                .number_format($item['subtotal'],2);
            echo '<br>';   
        }
    
        echo '<br>';
        echo '<b>Total: &euro;'.number_format($this->cart['total'],2).'<b>';
        $this->checkoutButton(true);
    }

    function checkoutButton($value){
        echo '<form action="" method="POST">
                <input type="hidden" name="checkout" value="'.$value.'" >
                <input type="hidden" name="page" value="cart" >
                <input class="order-button" type="submit" value= "checkout">
            </form>';
    }

}

?>
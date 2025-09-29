<?php
require_once('PageView.php');

class ShoppingCartView extends PageView{
    private $cart_items;

    function __construct($menu, $cart_items){
        parent::__construct($menu);
        $this->cart_items = $cart_items;
    }

    function bodyContent(){
        if (empty($this->cart_items['items'])){
            echo '<h2> Shopping cart is empty </h2>';}
        else{$this->ShowOrderList();}
    }

    function ShowOrderList(){
        echo '<h2> Order list </h2>';

        foreach ($this->cart_items['items'] as $item){
            echo ucfirst($item['name']).' - price:&euro;
                '.number_format($item['price'],2).' - amount:'.$item['count'].' - &euro;'
                .number_format($item['subtotal'],2);
            echo '<br>';   
        }
    
        echo '<br>';
        echo '<b>Total: &euro;'.number_format($this->cart_items['total'],2).'<b>';
        $this->checkoutButton(true);
    }

    function checkoutButton($value){
        echo '<form action="" method="POST">
                <input type="hidden" name="checkout" value="'.$value.'" >
                <input class="order-button" type="submit" value= "checkout">
            </form>';
    }

}

?>
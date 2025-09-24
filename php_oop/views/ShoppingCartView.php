<?php
require_once('PageView.php');

class ShoppingCartView extends PageView{
    private $cart_items;

    function __construct($menu, $cart_items){
        // parent::__construct($menu);
        $this->cart_items = $cart_items;
    }

    function bodyContent(){
        if (empty($this->cart_items)){
            echo '<h2> Shopping cart is empty </h2>';}
        else{$this->ShowOrderList();}
    }

    function ShowOrderList(){
        echo '<h2> Order list </h2>';

        foreach ($this->cart_items['items'] as $item){
            echo $item['name'].' - price:&euro;
                '.$item['price'].' - amount:'.$item['count'].' - &euro;'.$item['subtotal'];
            echo '<br>';   
        }
    
        echo '<br>';
        echo 'Total: '.$this->cart_items['total_price'];

        $this->orderButton(true, $type='checkout');
    }

    function orderButton($value, $type='order'){
        switch($type){
            case 'order':
                $name = 'item_id';
                break;
            case 'checkout':
                $name = 'checkout';
                break;
        }
        echo '<form action="" method="POST">
                <input type="hidden" name="'.$name.'" value="'.$value.'" >
                <input class="order-button" type="submit" value= "'.$type.'">
            </form>';

    }

}
?>
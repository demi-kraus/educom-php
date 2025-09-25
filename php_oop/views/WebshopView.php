<?php
  // !!!!!!!!!!!!!!!!!!!!!!!MOET NOG gesplists worden model/view/controller
require_once('PageView.php');

class WebshopView extends PageView{
    protected $db;
    protected $items;
    
    function __construct($menu, $items){
        parent::__construct($menu);
        $this->items = $items;
    }

    function bodyContent(){
        $this->showItemList();
    }

    function showItemList(){
        foreach ($this->items as $item){
            $item_page = 'index.php?page=webshop_item&id='.$item['id']; // link for item page 
            echo '<section class="webshop-item">';
            echo '<a href='.$item_page.'>'.ucfirst($item['name']).' </a>'; // name with link to item page
            echo '<img src= "images/'.$item['image'].'" alt = "webshopitem" width = 100 >'; // item image
            echo '<br><span> &euro; '.$item['price'].' </span>' ; //item price

            if ($_SESSION['login']){ //show only when logged in
                $this->orderButton($item['id'] );
                }
            echo '</section>';
        }
    }

    function orderButton($value){
        echo '<form action="" method="POST">
                <input type="hidden" name= "item_id" value="'.$value.'" >
                <input class="order-button" type="submit" value= "Order">
              </form>';
    }
}
?>
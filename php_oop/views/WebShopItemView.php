<?php
require_once('PageView.php');

class WebshopItemView extends PageView{
    private $item;
    function __construct($menu, $item){
        parent::__construct($menu);
        $this->item = $item[0];
    }

    function bodyContent(){
        $this->showItemPage();
    }

    function ShowItemPage(){

        //show item 
        echo '<section class="item-page">';
        echo '<h1>'.ucfirst($this->item['name']).'</h1>'; 
        echo '<span class="price"> &euro;'.$this->item['price'].'</span>';
        echo '<span>'.$this->item['description'].'</span>';
        echo '<img src= "images/'.$this->item['image'].'" alt = "webshopitem"';
        if ($_SESSION['login']?? false) { //show only when logged in
            $this->orderButton($this->item['id']);
            echo $this->item['id'];
        echo '</section>';
    }

   function orderButton($value){
        echo '<form action="" method="POST">
                <input type="hidden" name= "item_id" value="'.$value.'" >
                <input class="order-button" type="submit" value= "Order">
              </form>';
    }
    
}
?>
<?php
require_once('PageView.php');

class WebshopitemView extends PageView{
    $item;
    function __construct(){
        $this->$item;
    }

    function bodyContent(){
        $this->showItemPage();
    }

    function ShowItemPage($item){

        //show item 
        echo '<section class="item-page">';
        echo '<h1>'.ucfirst($item['name']).'</h1>'; 
        echo '<span class="price"> &euro;'.$item['price'].'</span>';
        echo '<span>'.$item['description'].'</span>';
        echo '<img src= "images/'.$item['image'].'" alt = "webshopitem" width = 400 height = 400>';
        echo '</section>';

        if ($_SESSION['login']){ //show only when logged in
            $this->orderButton($item['id']);
        }
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
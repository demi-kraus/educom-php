<?php
  // !!!!!!!!!!!!!!!!!!!!!!!MOET NOG gesplists worden model/view/controller
require_once('PageView.php');

class WebshopView extends PageView{
    protected $db;
    function __construct($menu, $db){
        parent::__construct($menu);
        $this->db = $db;
    }
    function bodyContent(){
        echo 'work in progress...';
        // $this->showItemList();
    }

    function showItemList(){
        // !!!!!!!!!!!!!!!!!!!!!!!MOET NOG NAAR MODEL
        // Get webshop items from database
        $result = $this->db->qetQueryResults('SELECT * FROM webshop_items');

        $page = "index.php?page=webshop_item"; 

        // show webshop items
        while($row = $result->fetch_assoc()) {
            $item_page = $page.'&id='.$row['id']; // link for item page 
            // for each item show name, image, price
            // when logged in show order button !!!
            echo '<section class="webshop-item">';
            echo '<a href='.$item_page.'>'.ucfirst($row['name']).' </a>'; // name with link to item page
            echo '<img src= "images/'.$row['image'].'" alt = "webshopitem" width = 100 >'; // item image
            echo '<br><span> &euro; '.$row['price'].' </span>' ; //item price

            if ($_SESSION['login']){ //show only when logged in
                $this->orderButton($row['id'], );
                }
            echo '</section>';
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
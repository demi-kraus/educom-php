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
        $this->showRating();
        // show rating only when logged in
        // if ($_SESSION['login'] ?? false){
        //     $this->showRating();
        // }
    }

    function ShowItemPage(){

        //show item 
        echo '<section class="item-page">';
        echo '<h1>'.ucfirst($this->item['name']).'</h1>'; 
        echo '<span class="price"> &euro;'.$this->item['price'].'</span>';
        echo '<span>'.$this->item['description'].'</span>';
        echo '<img src= "images/'.$this->item['image'].'" alt = "webshopitem">';
        
        if ($_SESSION['login']?? false) { //show only when logged in
            $this->orderButton($this->item['id']);

        }
        echo '</section>';
    }

   function orderButton($item_id){
        echo '<form action="" method="POST">
                <input type="hidden" name= "item_id" value="'.$item_id.'" >
                <input class="order-button" type="submit" value= "Order">
              </form>';
    }

    function showRating(){
          echo '<html lang="en">
                <head>   
                    <link rel="stylesheet" href="css/style.css"/>
                    <script src="js/jquery.js"></script>
                    <script src = "js/rating.js"> </script>
                </head>

                <body>
                    
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                    <span id="avgRating"></span>
                </body>
                </html>';
    }
}   
?>
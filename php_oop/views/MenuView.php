<?php

class MenuView {
    private $menu;

    function __construct($menu){
        $this->menu = $menu;
    }

    function showMenu(){
    echo "<ul class=\"menu\"> ";
    foreach ($this->menu as $item => $link){
        // $item = strtoupper($item);
        echo "<li> <a href= \"".$link."\">". $item . "</a> </li>";
    }
    echo "</ul>";
    }
}
?>
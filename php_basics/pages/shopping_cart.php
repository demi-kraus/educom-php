<?php
// check for POST for checkout
checkout(); // if Post then checkout is executed

// get orders 

if (!empty($_SESSION['orders'])){
    showOrderList();
    }
else{ echo '<h2> Shopping cart is empty </h2>';}
?>
<!DOCTYPE html>
<html>
    <!--begin header-->
    <head>
        <h1> Welcome!</h1>
    </head>
    <!--end header-->


    <!--begin body-->
    <body>
        <!--list--> 
        <a href="php_home.php"> HOME </a> <br>
        <a href="php_about.php"> ABOUT </a> <br>
        <a href="php_contact.php"> CONTACT </a> <br>
        <br>

        <!--form-->
        <form>
        <label for="name"> Name </label><br>
        <input type="text" id="name" name="name"> <br>

        <label for="email"> E-mail </label><br>
        <input type="text" id="email" name="email"> <br>

        <label for="message"> Bericht </label> <br>
        <textarea id="message" name="message" rows="4" cols="50"> </textarea> <br>

        <input type="submit" value="submit">

        <br>
        </form>
        <br>
    </body>
    <!--end body-->


    <!--begin footer-->
    <footer>
        &copy
        2010-<?php echo date("Y");?>
    </footer>
    <!--end footer-->


</html>
<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.css"/>
    </head>


    <body>

        <!--begin header-->
        <header>
            <h1> Welcome!</h1>
        </header>
        <!--end header-->

        <!--begin section--> 
        <section>
            <!--list--> 
            <ul class="menu"> 
                <li> <a href="php_home.php"> HOME </a> </li>
                <li> <a href="php_about.php"> ABOUT </a> </li>
                <li> <a href="php_contact.php"> CONTACT </a> </li>
                </ul>
            <br>

            <!--form-->
            <div class="text">
            <form>
                <div class="form">
                    <label for="name"> Name </label>
                    <input type="text" id="name" name="name"><br>

                    <label for="email"> E-mail </label>
                    <input type="text" id="email" name="email"><br>

                    <label for="message"> Bericht </label> 
                    <textarea id="message" name="message" rows="4" cols="50"> </textarea> <br>
                </div>
                <input type="submit" value="submit">
        
             </form>
            </div>
        </section>

        <!--begin footer-->
        <footer>
            &copy 2010-<?php echo date("Y");?>
        </footer>
        <!--end footer-->

    </body>
</html>
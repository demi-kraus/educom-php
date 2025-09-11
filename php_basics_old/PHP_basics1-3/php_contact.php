<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../style.css"/>
    </head>


    <body>

        <!--begin header-->
        <header>
            <h1> Welcome!</h1>
        </header>
        <!--end header-->

        <!--begin section--> 
        <section>
            <!-- begin list--> 
            <ul class="menu"> 
                <li> <a href="php_home.php"> HOME </a> </li>
                <li> <a href="php_about.php"> ABOUT </a> </li>
                <li> <a href="php_contact.php"> CONTACT </a> </li>
                </ul>
            <!--end ist--> 

            <!--begin form-->
            <?php 
            $name = $email = $message = "";
            $error =  "";
            $action = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if (empty($_POST["name"])) {
                    $error = "* All fields are required";
                } else{
                    $name = $_POST["name"];
                }
                if (empty($_POST["email"])) {
                        $error = "* All fields are required";
                    } else{
                        $email = $_POST["email"];
                    }
                if (empty($_POST["message"])) {
                        $error = "* All fields are required";
                    } else{
                        $message = $_POST["message"];
                    }
            
                if (empty($error)){
                    $action = "form_results.php";
            }
            }
            
            ?>
                <form method="POST" action= "<?php echo $action; ?>" >
                    <div class="form">
                        <span class="error"> <?php echo $error; ?></span><br>

                        <label for="name"> Name </label>
                        <input type="text" id="name" name="name" value="<?php echo $name; ?>" > <br>

                        <label for="email"> E-mail </label>
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>"><br>

                        <label for="message"> Bericht </label> 
                        <textarea id="message" name="message" rows="4"><?php echo $message; ?></textarea><br>
                    </div>
                        <input type="submit" value="submit">
                </form>
             <!--end form-->
        </section>

        <!--begin footer-->
        <footer>
            &copy 2010-<?php echo date("Y");?>
        </footer>
        <!--end footer-->

    </body>
</html>
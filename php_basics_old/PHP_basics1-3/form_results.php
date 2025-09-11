<html>
    <body>
        <h1> Input </h1>
        <?php 
        $name = $_POST["name"];  
        $email = $_POST["email"];
        $message = $_POST["message"];

        echo $name;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $message;
        echo "<br>";
        ?>

    </body>
</html>
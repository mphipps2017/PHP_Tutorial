<?php
    // MySQLi, he recommends learning PDO approach but used MySQLi since its easier for the sake of the tutorial
    // Connect to DB
    $conn = mysqli_connect('localhost', 'matthew', 'test1234', 'ninja_pizza');

    // check connection (if not connected)
    if(!$conn){
        echo "Connection error: ". mysqli_connect_error();
    }
?>
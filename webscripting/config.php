<?php
    //database configuration information
    $dbusername = "aimeel_exec";
    $dbpassword = "gbMa+OcNa1ea";
    $hostname = "localhost";
    $database = "aimeel_lincsenergy_database";
    
    //singular link to database information
    $connection = mysqli_connect($hostname, $dbusername, $dbpassword, $database);
    
    //outputs error message if connection fails
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL" , mysqli_connect_error();
    }

?>
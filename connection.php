<?php
    // connect to database
    $svname = "localhost:8080";
    $user_svname = "root"; // Default XAMPP username
    $sv_password = ""; // Default XAMPP password
    $sv_dbname = "mycvdatabase";

    // Create connection
    $conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
<?php
    include("connection.php");


    #$page = $_GET['page']
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    $allowedPages = ['login', 'home', 'Formcv', 'product'];


    $starter = 0;
    $skip = 2; // number item per page

    $records = $conn->query("SELECT * FROM template");
    $total_rows = $records->num_rows;

    // calculate number of pages, ceil for round up
    $total_pages = ceil($total_rows/$skip);

    // get the current page number
    $page_number = 1;
    if (isset($_GET['page_number'])) {
        $page_number=$_GET['page_number'];
        $starter=($page_number-1)*$skip;
    }


    if (in_array($page, $allowedPages)) {
        if ($page == 'login'){
            include("$page.php");
        } else {
            include("$page.php");
        }

    } else {
        include("404.html");
    }
?>
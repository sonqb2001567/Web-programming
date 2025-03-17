<?php
    #$page = $_GET['page']
    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

    $allowedPages = ['login', 'home', 'Formcv', 'product'];

    if (in_array($page, $allowedPages)) {
        include("$page.html");
    } else {
        include("404.html");
    }
?>
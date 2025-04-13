<?php
    include("connection.php");


    #$page = $_GET['page']
    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    
</body>
</html>
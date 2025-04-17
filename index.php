<?php
    session_start();
    
    include("connection.php");



    #$page = $_GET['page']
    // lay page type
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    $allowedPages = ['login', 'logout', 'home', 'Formcv', 'product', 'submitionForm'];

    $starter = 0;
    $skip = 2; // number item per page

    $records = $conn->query("SELECT * FROM template");
    $total_rows = $records->num_rows;

    // calculate number of pages, ceil for round up
    $total_pages = ceil($total_rows/$skip);
    
    if (isset($_GET['cv_id'])){
        $cv_id = $_GET['cv_id'];
        echo "<script> window.location.href = 'http://localhost/Web-programming/CV_" . $cv_id. ".php'; <script>";
        exit();
    }
    
    // get the current page number
    $page_number = 1;
    if (isset($_GET['page_number'])) {
        $page_number=$_GET['page_number'];
        $starter=($page_number-1)*$skip;
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
    <link href="style.css" rel="stylesheet">

</head>
<body>
    
    <?php
        

        if (in_array($page, $allowedPages)) {
            include("$page.php");            
        } else {
            include("404.html");
        }
    
    ?>



</body>
</html>
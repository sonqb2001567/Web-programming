<?php
    include("connection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_content = isset($_POST['page_content']) ? $_POST['page_content'] : 'Fail to add Content';
        $name = $_POST['cv_name'] ?? 'Untitled CV';
        $template_id = $_POST['template_id'] ?? 1; // Example default
        $user_id = $_POST['user_id'] ?? 1;         // Example default (should come from session ideally)
        $date_cv = date('Y-m-d'); // current date
        
        $cvInsertSql = "INSERT INTO cv (name, DATE_CV, template_id, user_id)
                        VALUES ('$name','$date_cv', '$template_id', '$user_id')";
        $result = $conn->query($cvInsertSql);

        $header ='<!DOCTYPE html>
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

                    </head>';
        $page_content = $header . $page_content;
        if ($result) {
            $last_id = $conn->insert_id;
            $filename = "CV_" . $last_id . ".php"; // unique filename
        }

        if (file_put_contents($filename, $page_content)) {
            echo "Page saved as $filename";
        } else {
            echo "Failed to save the file.";
        }

        echo "<script>
          alert('Finish Saving CV');
          window.location.href = 'http://localhost:8080/Web-programming/index.php?page=home';
        </script>";
    } else {
        echo "<script>
        alert('Submit failed!');
        window.location.href = 'http://localhost:8080/Web-programming/index.php?page=submitionForm';
      </script>";
    }


?>
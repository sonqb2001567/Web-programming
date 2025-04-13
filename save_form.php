<?php
    include("connection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_content = $_POST['page_content'] ?? '';
        $name = $_POST['cv_name'] ?? 'Untitled CV';
        $template_id = $_POST['template_id'] ?? 1; // Example default
        $user_id = $_POST['user_id'] ?? 1;         // Example default (should come from session ideally)
        $date_cv = date('Y-m-d'); // current date
        
        $cvInsertSql = "INSERT INTO cv (name, DATE_CV, template_id, user_id)
                        VALUES ('$name','$date_cv', '$template_id', '$user_id')";
        $conn->query($cvInsertSql);

        if ($result) {
            $last_id = $conn->insert_id;
            $filename = "CV_" . $last_id . ".php"; // unique filename
        }
        
        if (file_put_contents($filename, $html)) {
            echo "Page saved as $filename";
        } else {
            echo "Failed to save the file.";
        }
    } else {
        echo "Invalid request.";
    }
?>
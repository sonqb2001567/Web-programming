<?php
@session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_content = isset($_POST['page_content']) ? $_POST['page_content'] : 'Fail to add Content';
    $cv_id = isset($_POST['cv_id']) ? (int)$_POST['cv_id'] : 0;
    $template_id = isset($_POST['template_id']) ? (int)$_POST['template_id'] : 1;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0; // Default to 0 instead of 1
    $date_cv = date('Y-m-d'); // Current date: 2025-04-14

    // Validate user_id: Check if it exists in the User table
    if ($user_id == 0 || !isset($_SESSION['user_id'])) {
        echo "<script>
            alert('Invalid user ID. Please log in again.');
            window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=login';
        </script>";
        exit();
    }

    // Double-check that the user_id exists in the User table
    $sql_check_user = "SELECT user_id FROM User WHERE user_id = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    $stmt_check_user->bind_param("i", $user_id);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();

    if ($result_check_user->num_rows == 0) {
        echo "<script>
            alert('User does not exist. Please log in with a valid account.');
            window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=login';
        </script>";
        $stmt_check_user->close();
        exit();
    }
    $stmt_check_user->close();

    // Check the number of CVs for the user (only for new CV creation)
    if ($cv_id == 0) {
        $sql_count = "SELECT COUNT(*) as cv_count FROM cv WHERE user_id = ?";
        $stmt_count = $conn->prepare($sql_count);
        $stmt_count->bind_param("i", $user_id);
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        $row_count = $result_count->fetch_assoc();
        $cv_count = $row_count['cv_count'];
        $stmt_count->close();

        // If the user already has 3 CVs, deny the creation
        if ($cv_count >= 3) {
            echo "<script>
                alert('Đã hết số lượng CV được tạo');
                window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=home';
            </script>";
            exit();
        }
    }

    // Proceed with saving or updating the CV
    if ($cv_id > 0) {
        // Update existing CV
        $sql = "UPDATE cv SET DATE_CV = ?, template_id = ?, user_id = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siii", $date_cv, $template_id, $user_id, $cv_id);
        $stmt->execute();
        $last_id = $cv_id;
        $stmt->close();
    } else {
        // Insert new CV
        $name = "Untitled CV"; // Temporary name
        $cvInsertSql = "INSERT INTO cv (Name, DATE_CV, template_id, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($cvInsertSql);
        $stmt->bind_param("ssii", $name, $date_cv, $template_id, $user_id);
        $stmt->execute();
        $last_id = $conn->insert_id;

        // Update the name to "cvX"
        $new_name = "cv" . $last_id;
        $updateSql = "UPDATE cv SET Name = ? WHERE ID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $new_name, $last_id);
        $stmt->execute();
        $stmt->close();
    }

    $header ='<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="style.css">
                </head>';
    $page_content = $header . $page_content;

    $filename = "CV_" . $last_id . ".php";
    if (file_put_contents($filename, $page_content)) {
        echo "Page saved as $filename";
    } else {
        echo "Failed to save the file.";
    }

    echo "<script>
      alert('Finish Saving CV');
      window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=home';
    </script>";
} else {
    echo "<script>
    alert('Submit failed!');
    window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=submitionForm';
  </script>";
}
?>
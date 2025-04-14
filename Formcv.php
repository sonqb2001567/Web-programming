<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #cv-form {
            width: 60%;
            min-height: 900px;
            min-width: 500px;
        }

        #cv-element {
            margin: 0;
            padding: 10px;
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #5e5e5e;
            margin: 1em 0;
            padding: 0;
        }

        #templates-holder {
            background-color: #737373;
            width: 200px;
            height: 100vh;
        }
    </style>
</head>

<body id="cv-content" class="bg-light d-flex justify-content-center position-relative">
    <?php include('templateHolder.php'); ?>
    <?php 
    @session_start();

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli("localhost:3308", "root", "", "mycvdatabase");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy cv_id từ URL, nếu không có thì mặc định là 0
    $cv_id = isset($_GET['cv_id']) ? (int)$_GET['cv_id'] : 0;
    $cv_content_id = 0; // Khởi tạo cv_content_id
    $template_id = 1; // Mặc định template_id là 1

    // Nếu có cv_id (chỉnh sửa CV), lấy template_id và cv_content_id
    if ($cv_id > 0) {
        // Lấy template_id từ bảng cv
        $sql = "SELECT template_id FROM cv WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cv_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $template_id = $row['template_id'];
        }
        $stmt->close();

        // Lấy cv_content_id từ bảng cv_content dựa trên cv_id
        $sql = "SELECT cv_content_id FROM cv_content WHERE cv_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cv_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cv_content_id = $row['cv_content_id'];
        } else {
            // Nếu không tìm thấy cv_content_id, có thể chuyển hướng hoặc hiển thị thông báo lỗi
            echo "<script>
                alert('Không tìm thấy nội dung CV cho cv_id = $cv_id');
                window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=home';
            </script>";
            exit();
        }
        $stmt->close();
    } else {
        // Nếu không có cv_id, lấy cv_content_id và template_id từ URL (trường hợp tạo CV mới từ mẫu)
        $cv_content_id = isset($_GET['cv_content_id']) ? (int)$_GET['cv_content_id'] : 1;
        $template_id = isset($_GET['template_id']) ? (int)$_GET['template_id'] : 1;
    }

    $conn->close();

    // Bao gồm template dựa trên template_id
    if ($template_id == 1) {
        include('cvtemplate_1.php');
    } elseif ($template_id == 2) {
        include('cvtemplate_2.php'); // Giả sử bạn có cvtemplate_2.php
    } elseif ($template_id == 3) {
        include('cvtemplate_3.php'); // Giả sử bạn có cvtemplate_3.php
    } else {
        // Mặc định sử dụng cvtemplate_1.php nếu template_id không hợp lệ
        include('cvtemplate_1.php');
    }
    ?>
            
    <form id="save-form" method="POST" action="save_page.php" class="d-none">
        <textarea id="page_content" name="page_content" class="d-none"></textarea>
        <input type="hidden" name="cv_id" value="<?php echo $cv_id; ?>">
        <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; ?>">
    </form>
    <div class="position-fixed d-flex flex-column bottom-0 end-0 m-3">
        <div class="btn btn-success bottom-0 end-0 m-3" onclick="submitClick()">Gửi</div>
        <div class="btn btn-success bottom-0 end-0 m-3" onclick="copyLinkClick()">Sao chép liên kết</div> 
    </div >
    
</body>

<script>
    function hoverAdd(x) {
        const btnActionAdd = x.querySelector('#btn-action-add');
        const btnActionRemove = x.querySelector('#btn-action-remove');

        x.style.borderStyle = 'dashed';

        if (btnActionAdd) {
            btnActionAdd.style.display = 'block';
        }

        if (btnActionRemove) {
            btnActionRemove.style.display = 'block';
        }
    }

    function outAdd(x) {
        const btnActionAdd = x.querySelector('#btn-action-add');
        const btnActionRemove = x.querySelector('#btn-action-remove');

        x.style.borderStyle = 'hidden';

        if (btnActionAdd) {
            btnActionAdd.style.display = 'none';
        }

        if (btnActionRemove) {
            btnActionRemove.style.display = 'none';
        }
    }

    function tempPlateButtonClick() {
        let templateHolder = document.getElementById("templates-holder");
        let b = document.getElementById("openholder-btn");

        if (b.style.display === "block") {
            b.style.display = "none";
        }

        if (templateHolder.style.display === "none") {
            templateHolder.style.display = "block";
        } 
    }

    function tempPlateCloseButtonClick() {
        let x = document.getElementById("templates-holder");
        let b = document.getElementById("openholder-btn");

        if (b.style.display === "none") {
            b.style.display = "block";
        }
        if (x.style.display === "block") {
            x.style.display = "none";
        } 
    }

    function submitClick() {
        const content = document.getElementById("cv-content").outerHTML;
        document.getElementById("page_content").value = content;
        document.getElementById("save-form").submit();
    }

    function copyLinkClick() {
        const link = window.location.href; 
        navigator.clipboard.writeText(link);
    }
</script>
</html>
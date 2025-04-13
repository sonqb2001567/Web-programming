<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #cv-form{
            width: 60%;
            min-height: 900px;
            min-width: 500px;
        }

        #cv-element{
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

        #templates-holder{
            background-color: #737373;
            width: 200px;
            height: 100vh;
        }
    </style>
</head>

<body id="cv-content" class="bg-light d-flex justify-content-center position-relative">
    <?php include('templateHolder.php');?> 
    <?php 
    @session_start();

    // Lấy cv_content_id và template_id từ URL
    $cv_content_id = isset($_GET['cv_content_id']) ? (int)$_GET['cv_content_id'] : 4;
    $template_id = isset($_GET['template_id']) ? (int)$_GET['template_id'] : 1; // Mặc định là 1 nếu không có
    $cv_id = isset($_GET['cv_id']) ? (int)$_GET['cv_id'] : 0; // Nếu có cv_id thì đang chỉnh sửa CV

    // Nếu có cv_id (chỉnh sửa CV), lấy template_id từ bảng cv
    if ($cv_id > 0) {
        $conn = new mysqli("localhost:3308", "root", "", "mycvdatabase");
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }
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
        $conn->close();
    }

    // Luôn sử dụng cvtemplate_1.php cho tất cả template 1-6
    include('cvtemplate_1.php');
    ?>
            
    <form id="save-form" method="POST" action="save_page.php" class="d-none">
        <textarea id="page_content" name="page_content" class="d-none"></textarea>
        <input type="hidden" name="cv_id" value="<?php echo $cv_id; ?>">
        <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; ?>">
    </form>
    <div class="position-fixed d-flex flex-column bottom-0 end-0 m-3">
        <div class="btn btn-success bottom-0 end-0 m-3" onclick="submitClick()"> Submit</div>
        <div class="btn btn-success bottom-0 end-0 m-3" onclick="copyLinkClick()"> Copy link</div> 
    </div >
    
</body>

<script>
    function hoverAdd(x){
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

    function outAdd(x){
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

        if (b.style.display === "block"){
            b.style.display = "none"
        }

        if (templateHolder.style.display === "none") {
            templateHolder.style.display = "block";
        } 
    }

    function tempPlateCloseButtonClick(){
        let x = document.getElementById("templates-holder");
        let b = document.getElementById("openholder-btn");

        if (b.style.display === "none"){
            b.style.display = "block"
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
        navigator.clipboard.writeText(link)
    }
</script>
</html>
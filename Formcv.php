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
    <div class="d-flex flex-column w-100 justify-content-center m-0 p-0 ">
        <div class="name-input-container w-25 align-self-center">
            <div class="mb-3 mt-3">
                <input type="text" class="form-control" id="cv-name-input" placeholder="Enter your CV name">
            </div>
        </div>
        
        <?php 
        // Lấy cv_content_id từ URL
            $cv_content_id = isset($_GET['cv_content_id']) ? (int)$_GET['cv_content_id'] : 2; // Mặc định là 2 nếu không có
        ?>
        
        <?php $link ='cvtemplate_'.$_GET['template_id'].'.php';  include($link);?>

        <form id="save-form" method="POST" action="save_page.php" class="d-none">
            <input id="cv_name" nameid="cv_name" class="d-none">
            <input id="template_id" nameid="template_id" class="d-none" value="<?php echo isset($_GET["template_id"]) ? $_GET["template_id"] : 1;?>">
            <textarea id="page_content" name="page_content" class="d-none"></textarea>
        </form>
        <div class="position-fixed d-flex flex-column bottom-0 end-0 m-3">
            <div class="btn btn-success bottom-0 end-0 m-3" onclick="submitClick()"> Submit</div>
            <div class="btn btn-success bottom-0 end-0 m-3" onclick="copyLinkClick()"> Copy link</div> 
        </div >
    </div>    
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
        const cvName = document.getElementById("cv-name-input").value;
    
    // Set the value to the hidden input
        document.getElementById("cv_name").value = cvName;
        document.getElementById("page_content").value = content;
        document.getElementById("save-form").submit();
    }

    function copyLinkClick() {
        const link = window.location.href; 
        navigator.clipboard.writeText(link)
    }
</script>
</html>
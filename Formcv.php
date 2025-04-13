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

<body id="cv-content" class="bg-light d-flex justify-content-center position-relative" > <!--back-ground-->
    <?php include('templateHolder.php');?> 
    <?php include('cvtemplate_1.php');?>
            
    <form id="save-form" method="POST" action="save_page.php" class="d-none">
        <textarea id="page_content" name="page_content" class="d-none"></textarea>
    </form>
    <div class="btn btn-success position-fixed bottom-0 end-0 m-3" onclick="submitClick()"> Submit</div>
    <div class="btn btn-success position-fixed bottom-0 end-0 m-3" onclick="copyLinkClick(<?php echo isset($_POST[''])?>)"> Share link</div>
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
        const link = "http://localhost:8080/Web-programming/CV_" + ".php"; 
    navigator.clipboard.writeText(link)
    }
</script>
</html>

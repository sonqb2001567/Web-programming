<?php 
    include('connection.php');
    $templateSql = "SELECT * FROM template";
    $templates = $conn->query($templateSql);
?>

<style>
    #scroll-templates-view::-webkit-scrollbar {
        width: 0 !important;
        height: 0 !important;
        display: none;
    }
</style>

<div id="position-fixed template-holder-container" class="position-absolute top-0 start-0">
    <div id='openholder-btn' class="btn position-fixed" style="display: block;" onclick="tempPlateButtonClick()">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-person-fill" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0m2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755"/>
        </svg>
    </div>

    <div id="templates-holder" class="position-fixed top-0 start-0" style="display: none; z-index: 100;height: 100vh" >
        <div class="btn position-fixed" onclick="tempPlateCloseButtonClick()">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left" style="color: white;" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
        </div>
        <div id="scroll-templates-view" style="overflow-y: auto; overflow-x: hidden; height: 100vh">
            <div class="d-flex flex-column pt-5" >
                <?php
                    if ($templates && $templates->num_rows > 0) {
                        while ($row = $templates->fetch_assoc()) {
                            echo '<img class="my-3 ms-5" src="'. htmlspecialchars($row["picture"]) . '" alt="'. htmlspecialchars($row["name"]) .' loading="lazy" style="height: auto; width: 75px;">';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
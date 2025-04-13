<?php
    include("connection.php");
    $cv_id =  isset($_GET['cvId']) ? (int)$_GET['cvId'] : 1;
    $cvContentSql = "SELECT * FROM cv_content WHERE CV_id = $cv_id";
    $cvContent = $conn->query($cvContentSql)->fetch_assoc();
    if (empty($cvContent)) {
        die("query Error: " . $conn->connect_error);
    }

    $cvContent_name = $cvContent["name"];
    $cvContent_picture = $cvContent["picture"];
    $cvContent_email = $cvContent["email"];
    $cvContent_phone_number = $cvContent["phone_number"];
    $cvContent_introduction = $cvContent["introduction"];
    $cvContent_career_goal = $cvContent["career_goal"];
    $cvContent_experience = $cvContent["experience"];
    $cvContent_education = $cvContent["education"];
    $cvContent_skills = $cvContent["skills"];
    $cvContent_certificates = $cvContent["certificates"];
    $cvContent_awards = $cvContent["awards"];
    $cvContent_additional_info = $cvContent["additional_info"];
    $cvContent_reference_person = $cvContent["reference_person"];

?>

<div id="cv-form" class="mt-4 mb-4 bg-white d-flex flex-row"> <!--cv-form-->
    <div class="bg-secondary text-white w-50">  <!--Additional infor-->
        
        <img class="mt-2 ms-5" src=<?php echo $cvContent_picture?> alt="ava photo" width="150px" height="150px" style="border-radius: 50%;">
        
        <div id="cv-element" class="mt-2">
            <strong>CONTACT</strong>
            <div class="d-flex flex-column">
                <div id="cv-element" class="d-flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    <p class="mb-0 ms-2" contenteditable="true" aria-placeholder="address">
                       Address 
                    </p>
                </div>
                <div id="cv-element" class="d-flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone align-self-center" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                    </svg>
                    <p class="mb-0 ms-2" contenteditable="true" aria-placeholder="phone number">
                        <?php echo $cvContent_phone_number; ?>
                    </p>
                </div>
                <div id="cv-element" class="d-flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope align-self-center " viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                    </svg>
                    <p class="mb-0 ms-2" contenteditable="true" aria-placeholder="gmail">
                        <?php echo $cvContent_email; ?>
                    </p>
                </div>
            </div>
        </div>
        <div id="cv-element">
            <strong>CERTIFICATIONS</strong>
            <div id="section">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick="duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none; " onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-item" class="d-flex flex-column">
                        <strong contenteditable="true"><?php echo $cvContent_certificates;?></strong>
                        <p contenteditable="true">
                            - 7.0 (2019)
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="cv-element">
            <strong>ADDITIONAL INFORMATION</strong>
            <div id="section">
                <div id="section-item" class="d-flex flex-column">
                    <p contenteditable="true">
                        <?php echo $cvContent_additional_info?>
                    </p>
                </div>
            </div>
        </div>
        <div id="cv-element">
            <strong>SKILL</strong>
            <div id="section">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick= "duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none;" onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-item" class="d-flex flex-column">
                        <strong contenteditable="true">Programing skill</strong>
                        <p contenteditable="true">
                            <?php echo $cvContent_skills?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="cv-element">
            <strong>STRENGTH AND WEAKNESSES</strong>
            <div id="section">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick= "duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none;" onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-item" class="d-flex flex-column">
                        <strong>Strength</strong>
                        <p contenteditable="true">
                            Positive
                        </p>
                        <strong>Weaknesses</strong>
                        <p contenteditable="true">
                            Dont know anything
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-black w-100 d-flex flex-column"> <!--main infor-->
        <div id="cv-element" class="fs-4">
            <strong contenteditable="true"><?php echo $cvContent_name;?></strong>
        </div>
        <div id="cv-element" class="fs-4">
            <strong contenteditable="true">Developer Fresher</strong>
        </div>
        <hr/>
        <div id="cv-element">
            <strong class="text-warning fs-5">EDUCATION</strong>
            <div id="section" class="">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick="duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none;" onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-title" class="d-flex flex-row flex-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard align-self-center" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z"/>
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z"/>
                        </svg>
                        <strong class="ms-2 fs-5" contenteditable="true"><?php echo $cvContent_education;?></strong>
                        <div id="date" class="d-flex flex-row align-self-center">
                            <div class="mx-2">from:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                            <div class="mx-2">to:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                        </div>
                    </div>
                    <div id="section-item">
                        <div class="mt-2">
                            <strong class="fs-6" contenteditable="true">Khoa Khoa Học - Kỹ Thuật Máy Tính</strong>
                            <p contenteditable="true">
    
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div id="cv-element">
            <strong class="text-warning fs-5">WORK EXPERIENCE</strong>
            <div id="section" class="">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick= "duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none;" onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-title" class="d-flex flex-row flex-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase align-self-center" viewBox="0 0 16 16">
                            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5m1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0M1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        <strong class="ms-2 fs-5" contenteditable="true"><?php echo $cvContent_experience;?></strong>
                        <div id="date" class="d-flex flex-row align-self-center">
                            <div class="mx-2">from:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                            <div class="mx-2">to:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                        </div>
                    </div>
                    <div id="section-item">
                        <div class="mt-2">
                            <strong class="fs-6" contenteditable="true">Khoa Khoa Học - Kỹ Thuật Máy Tính</strong>
                            <p contenteditable="true">
    
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div id="cv-element">
            <strong class="text-warning fs-5">PROJECTS</strong>
            <div id="section" class="">
                <div id="wrapper-popup-action" class="position-relative" style=" border-width: 0.5px; border-style: none; border-color: #c8c8c8;"  onmouseover="hoverAdd(this)" onmouseout="outAdd(this)">
                    <div id="button-holder" class="position-absolute top-0 end-0 d-flex flex-column ps-3"> 
                        <div id="btn-action-add" class="btn btn-success m-1 btn-sm" style="display: none;" onclick= "duplicateSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <span style="font-size: 12px;">Thêm</span>
                        </div>
                        <div id="btn-action-remove" class="btn btn-danger m-1 btn-sm" style="display: none;" onclick="removeSection(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            <span style="font-size: 12px;">Xóa</span>
                        </div>
                    </div>
                    <div id="section-title" class="d-flex flex-row flex-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square align-self-center" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        <strong class="ms-2 fs-5" contenteditable="true">Bách Khoa University</strong>
                        <div id="date" class="d-flex flex-row align-self-center">
                            <div class="mx-2">from:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                            <div class="mx-2">to:</div>
                            <div contenteditable="true">
                                2025
                            </div>
                        </div>
                    </div>
                    <div id="section-item">
                        <div class="mt-2">
                            <strong class="fs-6" contenteditable="true">Khoa Khoa Học - Kỹ Thuật Máy Tính</strong>
                            <p contenteditable="true">
    
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>        
    function duplicateSection(button) {
        const wrapper = button.closest('#wrapper-popup-action');
        const clone = wrapper.cloneNode(true);
        
        // Reset any unique IDs in the clone to prevent duplicates
        clone.querySelectorAll('[id]').forEach(el => {
            el.id = el.id + '_' + Date.now();
        });
        
        // Insert the clone after the current wrapper
        wrapper.parentNode.insertBefore(clone, wrapper.nextSibling);
        
        // Reattach event listeners to the new clone
        clone.setAttribute('onmouseover', 'hoverAdd(this)');
        clone.setAttribute('onmouseout', 'outAdd(this)');
        clone.querySelector('#btn-action-add').setAttribute('onclick', 'duplicateSection(this)');
        clone.querySelector('#btn-action-remove').setAttribute('onclick', 'removeSection(this)');
    }

    function removeSection(button) {
        const wrapper = button.closest('#wrapper-popup-action');
        wrapper.remove();
    }

</script>

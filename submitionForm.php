<?php
  // session_start();
    include('connection.php');

    if (isset($_POST['submit_cv_button'])) {

      
      if(!isset($_POST['cv_content_name']) || $_POST['cv_content_name'] == '') {
        echo "<script>
          alert('Username not exists');
          window.location.href = 'http://localhost/btl/submitionForm.php';
        </script>";
        die;
      } 

      // submit thanh cong

      $cv_content_name = isset($_POST['cv_content_name']) ? $_POST['cv_content_name'] : ''; 
      // picture
      $cv_content_email = isset($_POST['cv_content_email']) ? $_POST['cv_content_email'] : '';
      $cv_content_phone_number = isset($_POST['cv_content_phone_number']) ? $_POST['cv_content_phone_number'] : '';
      $cv_content_introduction = isset($_POST['cv_content_introduction']) ? $_POST['cv_content_introduction'] : '';
      $cv_content_career_goal = isset($_POST['cv_content_career_goal']) ? $_POST['cv_content_career_goal'] : '';
      $cv_content_experience = isset($_POST['cv_content_experience']) ? $_POST['cv_content_experience'] : '';
      $cv_content_education = isset($_POST['cv_content_education']) ? $_POST['cv_content_education'] : '';
      $cv_content_skills = isset($_POST['cv_content_skills']) ? $_POST['cv_content_skills'] : '';
      $cv_content_certificates = isset($_POST['cv_content_certificates']) ? $_POST['cv_content_certificates'] : '';
      $cv_content_awards = isset($_POST['cv_content_awards']) ? $_POST['cv_content_awards'] : '';
      $cv_content_additional_info = isset($_POST['cv_content_additional_info']) ? $_POST['cv_content_additional_info'] : '';
      $cv_content_reference_person = isset($_POST['cv_content_reference_person']) ? $_POST['cv_content_reference_person'] : '';
      
      // save to db
      $sql = "
        INSERT INTO cv_content (name, email, phone_number, introduction, career_goal, experience, education, skills, certificates, awards, additional_info, reference_person)
        VALUES ('$cv_content_name', '$cv_content_email', '$cv_content_phone_number', '$cv_content_introduction', '$cv_content_career_goal', '$cv_content_experience', '$cv_content_education', '$cv_content_skills', '$cv_content_certificates', '$cv_content_awards', '$cv_content_additional_info', '$cv_content_reference_person')
      ";
      $result = $conn->query($sql);
      if ($result) {
        echo "<script>
          alert('Submit successfully!');
          window.location.href = 'http://localhost/btl/submitionForm.php';
        </script>";
      } else {
        echo "<script>
          alert('Submit failed!');
          window.location.href = 'http://localhost/btl/submitionForm.php';
        </script>";
      }
      

      // Process the content as needed (e.g., save to database, etc.)
      // echo "<h2>Submitted Content:</h2>";
      // echo $_SESSION['cv_content_name'];

      // if($_POST['cv_content_introduction'] == '') {
      //   echo "<script>
      //     alert('Introduction not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_experience'] == '') {
      //   echo "<script>
      //     alert('Username not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_education'] == '') {
      //   echo "<script>
      //     alert('Education not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_skills'] == '') {
      //   echo "<script>
      //     alert('Content skill not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_certificates'] == '') {
      //   echo "<script>
      //     alert('Content certificates not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_awards'] == '') {
      //   echo "<script>
      //     alert('Awards not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }
      // if($_POST['cv_content_reference_person'] == '') {
      //   echo "<script>
      //     alert('Reference person not exists');
      //     window.location.href = 'http://localhost/btl/submitionForm.php';
      //   </script>";
      //   die;
      // }


      // Process the content as needed (e.g., save to database, etc.)
        // echo "<h2>Submitted Content:</h2>";
        // echo "<div>$content</div>";
        // echo $content;
    }





















  ?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Place the first <script> tag in your HTML's <head> -->
      <script src="https://cdn.tiny.cloud/1/7n0t0g6ls9kxnjxouyoayortf25o46sn4pivnibdunr57hmz/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"></script> -->
</head>
<body class="container d-flex flex-wrap">
  <h1>Create your CV</h1>

  <!-- <div class="container d-flex align-content-center " style="background-color:rgb(255, 255, 255);"> -->
    <form action="submitionForm.php" method="POST">
      <!-- name -->
      <div class="mt-4">
        <h3>Name:</h3>
          <textarea class="tinymce" id="cv_content_name" name="cv_content_name" placeholder="Enter your name here.">
            <?php
              if (isset($cv_content_name)){
                echo $cv_content_name;
              }
            ?>
            
          </textarea>
      </div>
          <!-- picture NULL -->
      <div class="mt-4">
        <h3>Email:</h3>
          <textarea class="tinymce" id="cv_content_email" name="cv_content_email" placeholder="Enter your email here.">
            <?php
              if (isset($cv_content_email)){
                echo $cv_content_email;
              }
            ?>
            
          </textarea>
      </div>
      <!-- phone number NULL -->
      <div class="mt-4">
        <h3>Phone number:</h3>
          <textarea class="tinymce" id="cv_content_phone_number" name="cv_content_phone_number" placeholder="Enter your phone number here.">
            <?php
              if (isset($cv_content_phone_number)){
                echo $cv_content_phone_number;
              }
            ?>
            
          </textarea>
      </div>

      <!-- introduction NULL -->
      <div class="mt-4">
        <h3>Introduction:</h3>
          <textarea class="tinymce" id="cv_content_introduction" name="cv_content_introduction" placeholder="Enter your introduction here.">
            <?php
              if (isset($cv_content_introduction)){
                echo $cv_content_introduction;
              }
            ?>
            
          </textarea>
      </div>
      <!-- career goal NULL -->
      <div class="mt-4">
        <h3>Career goal:</h3>
          <textarea class="tinymce" id="cv_content_career_goal" name="cv_content_career_goal" placeholder="Enter your career goal here.">
            <?php
              if (isset($cv_content_career_goal)){
                echo $cv_content_career_goal;
              }
            ?>
            
          </textarea>
      </div>
      <!-- experience NULL -->
      <div class="mt-4">
        <h3>Experience:</h3>
          <textarea class="tinymce" id="cv_content_experience" name="cv_content_experience" placeholder="Enter your experience here.">
            <?php
              if (isset($cv_content_experience)){
                echo $cv_content_experience;
              }
            ?>
            
          </textarea>
      </div>
      <!-- education NULL -->
      <div class="mt-4">
        <h3>Education:</h3>
          <textarea class="tinymce" id="cv_content_education" name="cv_content_education" placeholder="Enter your education here.">
            <?php
              if (isset($cv_content_education)){
                echo $cv_content_education;
              }
            ?>
            
          </textarea>
      </div>
      <!-- skills NULL -->
      <div class="mt-4">
        <h3>Skills:</h3>
          <textarea class="tinymce" id="cv_content_skills" name="cv_content_skills" placeholder="Enter your skills here.">
            <?php
              if (isset($cv_content_skills)){
                echo $cv_content_skills;
              }
            ?>
            
          </textarea>
      </div>
      <!-- certificates NULL -->
      <div class="mt-4">
        <h3>Certificates:</h3>
          <textarea class="tinymce" id="cv_content_certificates" name="cv_content_certificates" placeholder="Enter your certificates here.">
            <?php
              if (isset($cv_content_certificates)){
                echo $cv_content_certificates;
              }
            ?>
            
          </textarea>
      </div>
      <!-- awards NULL -->
      <div class="mt-4">
        <h3>Awards:</h3>
          <textarea class="tinymce" id="cv_content_awards" name="cv_content_awards" placeholder="Enter your awards here.">
            <?php
              if (isset($cv_content_awards)){
                echo $cv_content_awards;
              }
            ?>
            
          </textarea>
      </div>
      <!-- additional info NULL -->
      <div class="mt-4">
        <h3>Additional info:</h3>
          <textarea class="tinymce" id="cv_content_additional_info" name="cv_content_additional_info" placeholder="Enter your additional info here.">
            <?php
              if (isset($cv_content_additional_info)){
                echo $cv_content_additional_info;
              }
            ?>
            
          </textarea>
      </div>
      <!-- reference person NULL -->
      <div class="mt-4">
        <h3>Reference person:</h3>
          <textarea class="tinymce" id="cv_content_reference_person" name="cv_content_reference_person" placeholder="Enter your reference person here.">
            <?php
              if (isset($cv_content_reference_person)){
                echo $cv_content_reference_person;
              }
            ?>
            
          </textarea>
      </div>
  
  
      <button type="submit" name="submit_cv_button" value="submit_cv_button" class="btn btn-success mt-4">Submit</button>
  
    </form>
    <!-- </div> -->








  

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: '.tinymce',
    plugins: [
      // Core editing features
      // 'image',
      'autoresize',
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons',  'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Apr 26, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });

  // document.getElementById('cvForm').addEventListener('submit', function(event) {
  //     // Get the content of the TinyMCE editor
  //     const content = tinymce.get('cv_content_name').getContent({ format: 'text' }); // Retrieves plain text
  //     if (content.trim() === '') {
  //         event.preventDefault(); // Prevent form submission
  //         alert('The CV content cannot be empty!'); // Alert message
  //     }
  // });

</script>
</body>
</html>
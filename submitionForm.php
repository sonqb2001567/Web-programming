<?php
@session_start();
include('connection.php');

// Kiểm tra và lấy user_id từ session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
        alert('Vui lòng đăng nhập để tạo CV!');
        window.location.href = 'http://localhost:8080/Web-programming-1/login.php';
    </script>";
    die;
}

if (isset($_POST['submit_cv_button'])) {
    // Kiểm tra trường name không được rỗng
    if (!isset($_POST['cv_content_name']) || trim($_POST['cv_content_name']) == '') {
        echo "<script>
            alert('Tên không được để trống!');
            window.location.href = 'http://localhost:8080/Web-programming-1/submitionForm.php';
        </script>";
        die;
    }

    // Lấy dữ liệu từ form
    $cv_content_name = isset($_POST['cv_content_name']) ? trim($_POST['cv_content_name']) : '';
    $cv_content_email = isset($_POST['cv_content_email']) ? trim($_POST['cv_content_email']) : '';
    $cv_content_phone_number = isset($_POST['cv_content_phone_number']) ? trim($_POST['cv_content_phone_number']) : '';
    $cv_content_introduction = isset($_POST['cv_content_introduction']) ? trim($_POST['cv_content_introduction']) : '';
    $cv_content_career_goal = isset($_POST['cv_content_career_goal']) ? trim($_POST['cv_content_career_goal']) : '';
    $cv_content_experience = isset($_POST['cv_content_experience']) ? trim($_POST['cv_content_experience']) : '';
    $cv_content_education = isset($_POST['cv_content_education']) ? trim($_POST['cv_content_education']) : '';
    $cv_content_skills = isset($_POST['cv_content_skills']) ? trim($_POST['cv_content_skills']) : '';
    $cv_content_certificates = isset($_POST['cv_content_certificates']) ? trim($_POST['cv_content_certificates']) : '';
    $cv_content_awards = isset($_POST['cv_content_awards']) ? trim($_POST['cv_content_awards']) : '';
    $cv_content_additional_info = isset($_POST['cv_content_additional_info']) ? trim($_POST['cv_content_additional_info']) : '';
    $cv_content_reference_person = isset($_POST['cv_content_reference_person']) ? trim($_POST['cv_content_reference_person']) : '';

    // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
    $conn->begin_transaction();

    try {
        // Tạo một bản ghi mới trong bảng CV
        $cv_name = "CV mặc định của user id $user_id"; // Tên CV mặc định, có thể thay đổi nếu cần
        $template_id = 1; // Mặc định template_id là 1, có thể thay đổi nếu cần
        $sql_insert_cv = "
            INSERT INTO CV (Name, DATE_CV, template_id, user_id)
            VALUES (?, CURDATE(), ?, ?)
        ";
        $stmt_insert_cv = $conn->prepare($sql_insert_cv);
        $stmt_insert_cv->bind_param("sii", $cv_name, $template_id, $user_id);
        $stmt_insert_cv->execute();
        $cv_id = $conn->insert_id; // Lấy ID của CV vừa tạo
        $stmt_insert_cv->close();

        // Chèn bản ghi vào bảng cv_content với cv_id
        $sql_insert_cv_content = "
            INSERT INTO cv_content (cv_id, name, email, phone_number, introduction, career_goal, experience, education, skills, certificates, awards, additional_info, reference_person)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt_insert_cv_content = $conn->prepare($sql_insert_cv_content);
        $stmt_insert_cv_content->bind_param("issssssssssss", $cv_id, $cv_content_name, $cv_content_email, $cv_content_phone_number, $cv_content_introduction, $cv_content_career_goal, $cv_content_experience, $cv_content_education, $cv_content_skills, $cv_content_certificates, $cv_content_awards, $cv_content_additional_info, $cv_content_reference_person);
        $stmt_insert_cv_content->execute();
        $cv_content_id = $conn->insert_id; // Lấy cv_content_id để sử dụng nếu cần
        $stmt_insert_cv_content->close();

        // Cập nhật user_defaultcv trong bảng User bằng cv_id (không phải cv_content_id)
        $sql_update_user = "
            UPDATE User
            SET user_defaultcv = ?
            WHERE user_id = ?
        ";
        $stmt_update_user = $conn->prepare($sql_update_user);
        $stmt_update_user->bind_param("ii", $cv_id, $user_id);
        $stmt_update_user->execute();
        $stmt_update_user->close();

        // Commit giao dịch
        $conn->commit();

        echo "<script>
            alert('Gửi thành công!');
            window.location.href = 'http://localhost:8080/Web-programming-1/index.php?page=home';
        </script>";
    } catch (Exception $e) {
        // Rollback giao dịch nếu có lỗi
        $conn->rollback();
        echo "<script>
            alert('Gửi thất bại! Lỗi: " . addslashes($e->getMessage()) . "');
            window.location.href = 'http://localhost:8080/Web-programming-1/submitionForm.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo CV của bạn</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/7n0t0g6ls9kxnjxouyoayortf25o46sn4pivnibdunr57hmz/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container d-flex flex-wrap">
    <h1>Tạo CV của bạn</h1>

    <form action="submitionForm.php" method="POST">
        <!-- Tên -->
        <div class="mt-4">
            <h3>Tên:</h3>
            <textarea class="tinymce" id="cv_content_name" name="cv_content_name" placeholder="Nhập tên của bạn tại đây.">
                <?php if (isset($cv_content_name)) { echo htmlspecialchars($cv_content_name); } ?>
            </textarea>
        </div>
        <!-- Email -->
        <div class="mt-4">
            <h3>Email:</h3>
            <textarea class="tinymce" id="cv_content_email" name="cv_content_email" placeholder="Nhập email của bạn tại đây.">
                <?php if (isset($cv_content_email)) { echo htmlspecialchars($cv_content_email); } ?>
            </textarea>
        </div>
        <!-- Số điện thoại -->
        <div class="mt-4">
            <h3>Số điện thoại:</h3>
            <textarea class="tinymce" id="cv_content_phone_number" name="cv_content_phone_number" placeholder="Nhập số điện thoại của bạn tại đây.">
                <?php if (isset($cv_content_phone_number)) { echo htmlspecialchars($cv_content_phone_number); } ?>
            </textarea>
        </div>
        <!-- Giới thiệu -->
        <div class="mt-4">
            <h3>Giới thiệu:</h3>
            <textarea class="tinymce" id="cv_content_introduction" name="cv_content_introduction" placeholder="Nhập phần giới thiệu của bạn tại đây.">
                <?php if (isset($cv_content_introduction)) { echo htmlspecialchars($cv_content_introduction); } ?>
            </textarea>
        </div>
        <!-- Mục tiêu nghề nghiệp -->
        <div class="mt-4">
            <h3>Mục tiêu nghề nghiệp:</h3>
            <textarea class="tinymce" id="cv_content_career_goal" name="cv_content_career_goal" placeholder="Nhập mục tiêu nghề nghiệp của bạn tại đây.">
                <?php if (isset($cv_content_career_goal)) { echo htmlspecialchars($cv_content_career_goal); } ?>
            </textarea>
        </div>
        <!-- Kinh nghiệm -->
        <div class="mt-4">
            <h3>Kinh nghiệm:</h3>
            <textarea class="tinymce" id="cv_content_experience" name="cv_content_experience" placeholder="Nhập kinh nghiệm của bạn tại đây.">
                <?php if (isset($cv_content_experience)) { echo htmlspecialchars($cv_content_experience); } ?>
            </textarea>
        </div>
        <!-- Học vấn -->
        <div class="mt-4">
            <h3>Học vấn:</h3>
            <textarea class="tinymce" id="cv_content_education" name="cv_content_education" placeholder="Nhập học vấn của bạn tại đây.">
                <?php if (isset($cv_content_education)) { echo htmlspecialchars($cv_content_education); } ?>
            </textarea>
        </div>
        <!-- Kỹ năng -->
        <div class="mt-4">
            <h3>Kỹ năng:</h3>
            <textarea class="tinymce" id="cv_content_skills" name="cv_content_skills" placeholder="Nhập kỹ năng của bạn tại đây.">
                <?php if (isset($cv_content_skills)) { echo htmlspecialchars($cv_content_skills); } ?>
            </textarea>
        </div>
        <!-- Chứng chỉ -->
        <div class="mt-4">
            <h3>Chứng chỉ:</h3>
            <textarea class="tinymce" id="cv_content_certificates" name="cv_content_certificates" placeholder="Nhập chứng chỉ của bạn tại đây.">
                <?php if (isset($cv_content_certificates)) { echo htmlspecialchars($cv_content_certificates); } ?>
            </textarea>
        </div>
        <!-- Giải thưởng -->
        <div class="mt-4">
            <h3>Giải thưởng:</h3>
            <textarea class="tinymce" id="cv_content_awards" name="cv_content_awards" placeholder="Nhập giải thưởng của bạn tại đây.">
                <?php if (isset($cv_content_awards)) { echo htmlspecialchars($cv_content_awards); } ?>
            </textarea>
        </div>
        <!-- Thông tin bổ sung -->
        <div class="mt-4">
            <h3>Thông tin bổ sung:</h3>
            <textarea class="tinymce" id="cv_content_additional_info" name="cv_content_additional_info" placeholder="Nhập thông tin bổ sung của bạn tại đây.">
                <?php if (isset($cv_content_additional_info)) { echo htmlspecialchars($cv_content_additional_info); } ?>
            </textarea>
        </div>
        <!-- Người tham chiếu -->
        <div class="mt-4">
            <h3>Người tham chiếu:</h3>
            <textarea class="tinymce" id="cv_content_reference_person" name="cv_content_reference_person" placeholder="Nhập thông tin người tham chiếu của bạn tại đây.">
                <?php if (isset($cv_content_reference_person)) { echo htmlspecialchars($cv_content_reference_person); } ?>
            </textarea>
        </div>

        <button type="submit" name="submit_cv_button" value="submit_cv_button" class="btn btn-success my-4">Gửi</button>
    </form>

    <script>
        tinymce.init({
            selector: '.tinymce',
            plugins: [
                'autoresize',
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ychecker typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Tác giả',
            mergetags_list: [
                { value: 'First.Name', title: 'Tên' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('Xem tài liệu để triển khai AI Assistant')),
        });
    </script>
</body>
</html>
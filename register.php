<?php
@session_start();

// Kết nối cơ sở dữ liệu
$svname = "localhost:3308";
$user_svname = "root";
$sv_password = "";
$sv_dbname = "MyCVDatabase"; // Updated to match DBCreation.db

$conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate password length (minimum 8 characters)
    if (strlen($password) < 8) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra xem email đã tồn tại chưa
        $query_check = "SELECT * FROM User WHERE email = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Email đã tồn tại
            $error = "Email đã tồn tại, vui lòng đăng ký email khác.";
        } else {
            // Thêm người dùng mới vào bảng User, ban đầu để user_defaultcv là NULL
            $query_insert = "INSERT INTO User (name, email, pass, admin_id, user_defaultcv) VALUES (?, ?, ?, NULL, NULL)";
            $stmt_insert = $conn->prepare($query_insert);
            $stmt_insert->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt_insert->execute()) {
                // Lấy user_id của bản ghi vừa chèn
                $user_id = $conn->insert_id;

                // Cập nhật cột user_defaultcv bằng user_id
                $query_update = "UPDATE User SET user_defaultcv = ? WHERE user_id = ?";
                $stmt_update = $conn->prepare($query_update);
                $stmt_update->bind_param("ii", $user_id, $user_id);
                
                if ($stmt_update->execute()) {
                    // Đăng ký thành công, chuyển hướng về trang đăng nhập
                    header("Location: login.php?success=Đăng ký thành công! Vui lòng đăng nhập.");
                    exit();
                } else {
                    $error = "Cập nhật user_defaultcv thất bại. Vui lòng thử lại.";
                }
                $stmt_update->close();
            } else {
                $error = "Đăng ký thất bại. Vui lòng thử lại.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="POST">
            <h2>Đăng ký</h2>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <div class="input-field">
                <input type="text" id="name" name="name" required>
                <label for="name">Nhập tên của bạn</label>
            </div>
            <div class="input-field">
                <input type="email" id="email" name="email" required>
                <label for="email">Nhập email của bạn</label>
            </div>
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Nhập mật khẩu của bạn (tối thiểu 8 ký tự)</label>
            </div>
            <button type="submit" name="register">Gửi</button>
            <div class="register">
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</body>
</html>
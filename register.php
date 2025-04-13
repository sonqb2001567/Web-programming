<?php
@session_start();

// Kết nối cơ sở dữ liệu
$svname = "localhost:3308";
$user_svname = "root";
$sv_password = "";
$sv_dbname = "mycvdatabase";

$conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    // Kiểm tra xem email đã tồn tại chưa
    $query_check = "SELECT * FROM user WHERE email = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Email đã tồn tại
        $error = "Email đã tồn tại, vui lòng đăng ký email khác.";
    } else {
        // Thêm người dùng mới vào bảng user
        $query_insert = "INSERT INTO user (name, email, pass, admin_id, user_defaultcv) VALUES (?, ?, ?, NULL, NULL)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bind_param("sss", $name, $email, $password);
        
        if ($stmt_insert->execute()) {
            // Đăng ký thành công, chuyển hướng về trang đăng nhập
            header("Location: login.php?success=Đăng ký thành công! Vui lòng đăng nhập.");
            exit();
        } else {
            $error = "Đăng ký thất bại. Vui lòng thử lại.";
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="POST">
            <h2>Register</h2>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <div class="input-field">
                <input type="text" id="name" name="name" required>
                <label for="name">Enter your name</label>
            </div>
            <div class="input-field">
                <input type="email" id="email" name="email" required>
                <label for="email">Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Enter your password</label>
            </div>
            <button type="submit" name="register">Send</button>
            <div class="register">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
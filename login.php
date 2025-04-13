<?php
@session_start();

// Kết nối cơ sở dữ liệu

$svname = "localhost:3306"; // Cổng MySQL (thử 8080 hoặc 3306 nếu không hoạt động)
$user_svname = "root";
$sv_password = "";
$sv_dbname = "mycvdatabase";

$conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra trong bảng admin
    $query_admin = "SELECT * FROM admin WHERE email = ? AND pass = ?";
    $stmt_admin = $conn->prepare($query_admin);
    $stmt_admin->bind_param("ss", $email, $password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $admin = $result_admin->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['user_type'] = 'admin'; // Lưu loại tài khoản
        header("Location: index.php?page=home");
        exit();
    }

    // Kiểm tra trong bảng user
    $query_user = "SELECT * FROM user WHERE email = ? AND pass = ?";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bind_param("ss", $email, $password);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_type'] = 'user'; // Lưu loại tài khoản
        header("Location: index.php?page=home");
        exit();
    }

    // Nếu không tìm thấy tài khoản
    $error = "Email hoặc mật khẩu không đúng.";

    $stmt_admin->close();
    $stmt_user->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h2>Login</h2>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <div class="input-field">
                <input type="email" id="email" name="email" required>
                <label for="email">Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Enter your password</label>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit">Log in</button>
            <div class="register">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
<?php
@session_start(); // Khởi động session

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

    // Truy vấn kiểm tra email và mật khẩu
    $query = "SELECT * FROM admin WHERE email = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: index.php?page=home"); // Chuyển hướng đến trang home
        exit();
    } else {
        $error = "Email hoặc mật khẩu không đúng.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Liên kết file CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h2>Login</h2>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <!-- Input Field for Email -->
            <div class="input-field">
                <label for="email">Enter your email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <!-- Input Field for Password -->
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Enter your password</label>
            </div>
            <!-- Remember Me & Forgot Password -->
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <!-- Submit Button -->
        <form action="index.php" method="get">        
            <button type="submit">Log in</button>
            <input type="hidden" name="page_type" value="home">
        
            <!-- Register Link -->
            <div class="register">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
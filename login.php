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
        <!-- <form action="index.php" method="get"> -->
            <h2>Login</h2>
            <!-- Input Field for Account -->
            <div class="input-field">
                <label for="account">Enter your account</label>
                <input type="text" id="account" required>
            </div>
            <!-- Input Field for Password -->
            <div class="input-field">
                <input type="password" id="password" required>
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
        </form>
            <!-- Register Link -->
            <div class="register">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
    </div>
    <script src="login.js"></script>
</body>
</html>

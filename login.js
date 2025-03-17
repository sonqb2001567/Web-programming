const accountInput = document.getElementById('account');
const passwordInput = document.getElementById('password');
const loginButton = document.querySelector("button[type='submit']");

// Thêm sự kiện click để xử lý khi người dùng nhấn nút
loginButton.addEventListener("click", function (e) {
    // Ngăn chặn hành động mặc định của form (submit làm reload trang)
    e.preventDefault();

    // Lấy giá trị người dùng nhập
    const username = accountInput.value.trim();
    const password = passwordInput.value.trim();

    if (!username || !password) {
        alert("Please fill in both username and password.");
        return;
    }

    // Kiểm tra thông tin đăng nhập
    if (username === "1" && password === "1") {
        // Nếu đúng, chuyển hướng đến trang home.html với tham số truy vấn
        window.location.href = `http://localhost:8080/Web-programming/?page=home`;
    } else {
        // Nếu sai, hiển thị thông báo lỗi
        alert("Invalid username or password. Please try again.");
    }
});

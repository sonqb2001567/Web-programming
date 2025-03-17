const accountInput = document.getElementById('account');
const passwordInput = document.getElementById('password');
const loginButton = document.querySelector("button[type='submit']");

// Thêm sự kiện click để xử lý khi người dùng nhấn nút
loginButton.addEventListener("click", function (e) {
    // Ngăn chặn hành động mặc định của form (submit làm reload trang)
    e.preventDefault();

    // Lấy giá trị người dùng nhập
    const username = accountInput.value;
    const password = passwordInput.value;

    // Kiểm tra thông tin đăng nhập
    if (username === "0379997425" && password === "1234") {
        // Nếu đúng, chuyển hướng đến trang lab2.html
        window.location.href = "../lab2.html";
    } else {
        // Nếu sai, hiển thị thông báo lỗi
        alert("Invalid username or password. Please try again.");
    }
});

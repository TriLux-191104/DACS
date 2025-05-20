<?php
class CartController {
    public function index() {
        // Giả sử bạn lưu giỏ hàng trong session
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        // Chuyển dữ liệu sang view
        $data = [
            'cartItems' => $cartItems,
            'errors' => [] // Nếu có lỗi thì thêm vào đây
        ];
        
        // Load view
        require_once 'app/views/Product/cart.php';
    }

    // Thêm phương thức update nếu cần
    public function update() {
        // Xử lý khi submit form cập nhật giỏ hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cập nhật số lượng từ $_POST['quantity']
            // Xử lý các sản phẩm được chọn từ $_POST['selected']
        }
    }
}
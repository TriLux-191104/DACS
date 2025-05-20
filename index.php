
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Hoặc múi giờ phù hợp (+07:00)
session_start();

// Import các file cần thiết
require_once 'app/models/ProductModel.php';


// Lấy và xử lý URL
$url = $_GET['url'] ?? ''; // Lấy tham số 'url' từ query string (nếu có)
$url = rtrim($url, '/'); // Loại bỏ dấu '/' ở cuối chuỗi (nếu có)
$url = filter_var($url, FILTER_SANITIZE_URL); // Lọc URL để tránh mã độc
$url = explode('/', $url); // Tách URL thành mảng các phần

// Xác định controller từ phần đầu tiên của URL
$controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// Xác định action từ phần thứ hai của URL
$action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

// Kiểm tra xem file controller có tồn tại không
$controllerPath = 'app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerPath)) {
    die('Controller not found'); // Thông báo lỗi nếu không tìm thấy controller
}

require_once $controllerPath; // Import file controller
$controller = new $controllerName(); // Khởi tạo controller

// Kiểm tra xem action có tồn tại trong controller không
if (!method_exists($controller, $action)) {
    die('Action not found'); // Thông báo lỗi nếu không tìm thấy action
}

// Gọi action và truyền các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));




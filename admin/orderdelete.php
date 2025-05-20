<?php
include "./class/order_class.php";
$order = new Order();

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // ép kiểu an toàn
    $order->deleteOrder($order_id);
    header("Location: orderlist.php");
    exit();
} else {
    // Có thể chuyển hướng hoặc thông báo lỗi nếu thiếu ID
    echo "Thiếu mã đơn hàng cần xoá.";
}
?>

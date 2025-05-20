<?php
include "./class/order_class.php";
$order = new Order();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $data = $order->getOrderById($order_id);
    $order_data = mysqli_fetch_assoc($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $order->updateOrderStatus($order_id, $status);
    header("Location: orderlist.php");
}
?>

<?php include "slider.php"; ?>
<?php include "header.php"; ?>

<h3>Sửa trạng thái đơn hàng</h3>
<form action="" method="POST">
    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="Chờ xử lý" <?= $order_data['status'] == "Chờ xử lý" ? "selected" : "" ?>>Chờ xử lý</option>
            <option value="Đã thanh toán" <?= $order_data['status'] == "Đã thanh toán" ? "selected" : "" ?>>Đã thanh toán</option>
            <option value="Đã gửi hàng" <?= $order_data['status'] == "Đã gửi hàng" ? "selected" : "" ?>>Đã gửi hàng</option>
            <option value="Đã giao" <?= $order_data['status'] == "Đã giao" ? "selected" : "" ?>>Đã giao</option>
            <option value="Đã huỷ" <?= $order_data['status'] == "Đã huỷ" ? "selected" : "" ?>>Đã huỷ</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>

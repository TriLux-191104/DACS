<?php
include "session.php";
include "class/voucher_class.php";

Session::checkSession();
$voucher = new Voucher();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $voucher_id = intval($_GET['id']);
    $adminId = Session::get('admin_id');
    if (!$adminId) {
        header("Location: voucherlist.php?error=Phiên đăng nhập không hợp lệ");
        exit;
    }
    $result = $voucher->deleteVoucher($voucher_id, $adminId);
    if ($result) {
        header("Location: voucherlist.php?success=Xóa voucher thành công");
    } else {
        header("Location: voucherlist.php?error=Xóa voucher thất bại hoặc voucher không tồn tại");
    }
    exit;
} else {
    header("Location: voucherlist.php?error=Thiếu mã voucher cần xóa");
    exit;
}
?>
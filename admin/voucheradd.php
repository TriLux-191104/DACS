<?php
include "session.php";
include "class/voucher_class.php";

Session::checkSession();
$voucher = new Voucher();

// Tạo CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $data = [
        'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING),
        'discount_type' => filter_input(INPUT_POST, 'discount_type', FILTER_SANITIZE_STRING),
        'discount_value' => filter_input(INPUT_POST, 'discount_value', FILTER_VALIDATE_FLOAT),
        'min_order_amount' => filter_input(INPUT_POST, 'min_order_amount', FILTER_VALIDATE_FLOAT) ?: 0,
        'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
        'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
        'usage_limit' => filter_input(INPUT_POST, 'usage_limit', FILTER_VALIDATE_INT) ?: 0,
        'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING)
    ];

    if (empty($data['code']) || strlen($data['code']) > 50) {
        $errors[] = "Mã voucher không hợp lệ (tối đa 50 ký tự).";
    }
    if (!in_array($data['discount_type'], ['percentage', 'fixed'])) {
        $errors[] = "Loại giảm giá không hợp lệ.";
    }
    if ($data['discount_value'] <= 0) {
        $errors[] = "Giá trị giảm giá phải lớn hơn 0.";
    }
    if ($data['min_order_amount'] < 0) {
        $errors[] = "Giá trị đơn hàng tối thiểu không được âm.";
    }
    if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
        $errors[] = "Ngày kết thúc phải sau ngày bắt đầu.";
    }

    if (empty($errors)) {
        $adminId = Session::get('admin_id');
        if (!$adminId) {
            $errors[] = "Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.";
        } else {
            $result = $voucher->createVoucher($data, $adminId);
            if ($result) {
                $success = true;
                header("Location: voucherlist.php?success=Thêm voucher thành công");
                exit;
            } else {
                $errors[] = "Thêm voucher thất bại: " . htmlspecialchars($voucher->db->error);
            }
        }
    }
}
?>

<?php include "slider.php"; ?>
<?php include "header.php"; ?>

<div class="container-fluid">
    <h3 class="mb-4">Thêm Voucher Mới</h3>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-light p-3 rounded" onsubmit="return validateForm()">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Mã Voucher</label>
                <input type="text" name="code" class="form-control" required maxlength="50">
            </div>
            <div class="col-md-6">
                <label class="form-label">Loại giảm giá</label>
                <select name="discount_type" class="form-select" required>
                    <option value="percentage">Phần trăm (%)</option>
                    <option value="fixed">Giá trị cố định (đ)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Giá trị giảm giá</label>
                <input type="number" name="discount_value" class="form-control" step="0.01" min="0.01" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Giá trị đơn hàng tối thiểu (đ)</label>
                <input type="number" name="min_order_amount" class="form-control" step="1000" min="0" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ngày bắt đầu</label>
                <input type="datetime-local" name="start_date" class="form-control" 
                       value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ngày kết thúc</label>
                <input type="datetime-local" name="end_date" class="form-control" 
                       value="<?php echo date('Y-m-d\TH:i', strtotime('+7 days')); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Giới hạn sử dụng (0 = không giới hạn)</label>
                <input type="number" name="usage_limit" class="form-control" min="0" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Thêm Voucher</button>
                <a href="voucherlist.php" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
</div>

<script>
function validateForm() {
    const code = document.querySelector('[name="code"]').value;
    const discountValue = document.querySelector('[name="discount_value"]').value;
    const startDate = document.querySelector('[name="start_date"]').value;
    const endDate = document.querySelector('[name="end_date"]').value;

    if (code.length > 50) {
        alert('Mã voucher không được vượt quá 50 ký tự.');
        return false;
    }
    if (discountValue <= 0) {
        alert('Giá trị giảm giá phải lớn hơn 0.');
        return false;
    }
    if (new Date(endDate) <= new Date(startDate)) {
        alert('Ngày kết thúc phải sau ngày bắt đầu.');
        return false;
    }
    return true;
}
</script>

<?php include "footer.php"; ?>
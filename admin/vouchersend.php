<?php
include_once "session.php";
include_once "class/voucher_class.php";
include_once "class/account_class.php";

Session::checkSession();
$voucher = new Voucher();
$account = new Account();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: voucherlist.php?error=Thiếu mã voucher");
    exit;
}

$voucher_id = intval($_GET['id']);
$voucher_data = $voucher->getVoucherById($voucher_id);

if (!$voucher_data) {
    header("Location: voucherlist.php?error=Không tìm thấy voucher");
    exit;
}

// Tạo CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $adminId = Session::get('admin_id');
    if (!$adminId) {
        $errors[] = "Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.";
    } else {
        if (isset($_POST['send_all']) && $_POST['send_all'] == '1') {
            $result = $voucher->sendVoucherToAllUsers($voucher_id, $adminId);
            if ($result > 0) {
                $success = "Gửi voucher thành công cho $result người dùng.";
            } else {
                $errors[] = "Gửi voucher thất bại hoặc không có người dùng nào nhận được.";
            }
        } elseif (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
            $user_id = intval($_POST['user_id']);
            $result = $voucher->sendVoucherToUser($voucher_id, $user_id, $adminId);
            if ($result) {
                $success = "Gửi voucher thành công cho người dùng.";
            } else {
                $errors[] = "Gửi voucher thất bại: " . htmlspecialchars($voucher->db->error);
            }
        } else {
            $errors[] = "Vui lòng chọn người dùng hoặc gửi cho tất cả.";
        }
    }
}

$users = $account->getAllUsers();
?>

<?php include_once "slider.php"; ?>
<?php include_once "header.php"; ?>

<div class="container-fluid">
    <h3 class="mb-4">Gửi Voucher</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thông tin Voucher</h5>
                </div>
                <div class="card-body">
                    <p><strong>Mã:</strong> <?php echo htmlspecialchars($voucher_data['code']); ?></p>
                    <p><strong>Giá trị:</strong> 
                        <?php 
                        echo $voucher_data['discount_type'] == 'percentage' 
                            ? $voucher_data['discount_value'] . '%' 
                            : number_format($voucher_data['discount_value'], 0, ',', '.') . '₫';
                        ?>
                    </p>
                    <p><strong>Thời hạn:</strong> 
                        <?php echo date('d/m/Y H:i', strtotime($voucher_data['start_date'])); ?> - 
                        <?php echo date('d/m/Y H:i', strtotime($voucher_data['end_date'])); ?>
                    </p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge <?php echo $voucher_data['status'] == 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                            <?php echo $voucher_data['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Gửi đến người dùng</h5>
                </div>
                <div class="card-body">
                    <form method="POST" onsubmit="return confirm('Xác nhận gửi voucher này?')">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Chọn người dùng</label>
                            <select name="user_id" class="form-select">
                                <option value="">-- Chọn người dùng --</option>
                                <?php if ($users && mysqli_num_rows($users) > 0): ?>
                                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                        <option value="<?php echo $user['id']; ?>">
                                            <?php echo htmlspecialchars($user['fullname'] . ' (' . $user['email'] . ')'); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option value="">Không có người dùng nào</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="send_all" name="send_all" value="1">
                                <label class="form-check-label" for="send_all">Gửi cho tất cả người dùng</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Gửi Voucher</button>
                        <a href="voucherlist.php" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


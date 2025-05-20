<?php

if (!isset($_SESSION['register_temp']['email'])) {
    header('Location: /webdr/account/register');
    exit;
}
include 'app/views/shares/header.php';
?>

<div class="container protagonists-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">XÁC NHẬN OTP</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <p class="text-center">Chúng tôi đã gửi mã OTP đến email <strong><?= htmlspecialchars($_SESSION['register_temp']['email']) ?></strong>. Vui lòng kiểm tra và nhập mã bên dưới.</p>
                    
                    <form action="/webdr/account/verify_otp" method="post">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Mã OTP (6 chữ số)</label>
                            <input type="text" name="otp" id="otp" class="form-control" required maxlength="6" pattern="\d{6}">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Xác nhận</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <form action="/webdr/account/verify_otp" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="resend_otp">
                            <button type="submit" class="btn btn-link text-decoration-none">Gửi lại OTP</button>
                        </form>
                        <br>
                        <a href="/webdr/account/register" class="text-decoration-none">← Quay lại đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
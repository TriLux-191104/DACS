<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-4">
          <h2 class="text-center mb-4">ĐẶT LẠI MẬT KHẨU</h2>
          
          <?php if (isset($_SESSION['password_error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['password_error']) ?></div>
            <?php unset($_SESSION['password_error']); ?>
          <?php endif; ?>

          <?php if (empty($_SESSION['verified_email'])): ?>
            <div class="alert alert-danger">Vui lòng xác minh OTP trước khi đặt lại mật khẩu!</div>
            <div class="text-center">
              <a href="/webdr/account/forgot" class="btn btn-secondary">Quay lại</a>
            </div>
          <?php else: ?>
            <form action="/webdr/account/processreset" method="post">
              <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['verified_email']) ?>">
              <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
              </div>
              <button type="submit" class="btn btn-dark w-100">Đặt lại mật khẩu</button>
            </form>
          <?php endif; ?>
          <div class="text-center mt-3">
            <a href="/webdr/account/log">Quay lại đăng nhập</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
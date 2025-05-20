<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-4">
          <h2 class="text-center mb-4">QUÊN MẬT KHẨU</h2>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          
          <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>

          <form action="/webdr/account/forgot" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Gửi OTP</button>
          </form>
          <div class="text-center mt-3">
            <a href="/webdr/account/log">Quay lại đăng nhập</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
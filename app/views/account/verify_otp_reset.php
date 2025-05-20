<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-4">
          <h2 class="text-center mb-4">XÁC MINH OTP</h2>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form action="/webdr/account/verify_otp_reset" method="post">
            <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['reset_email'] ?? '') ?>">
            <div class="mb-3">
              <label for="otp" class="form-label">Mã OTP</label>
              <input type="text" name="otp" id="otp" class="form-control" required maxlength="6">
            </div>
            <button type="submit" class="btn btn-dark w-100">Xác minh</button>
          </form>
          <div class="text-center mt-3">
            <a href="/webdr/account/forgot">Gửi lại OTP</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
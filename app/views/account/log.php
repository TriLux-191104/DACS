<?php include 'app/views/shares/header.php'; ?>

<style>
  .btn-custom-dark {
    background-color: #4a4a4a;
    border-color: #4a4a4a;
    color: white;
  }
  .btn-custom-dark:hover {
    background-color: #5e5e5e;
    border-color: #5e5e5e;
    color: white;
  }
</style>

<div class="container my-5">
  <div class="row">
    <!-- Đăng nhập -->
    <div class="col-md-6 mb-5">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title mb-4">ĐĂNG NHẬP</h2>
          <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <form action="/webdr/account/checklogin" method="post">
            <div class="form-group mb-3">
              <input type="email" name="email" placeholder="Email của bạn" required class="form-control">
            </div>
            <div class="form-group mb-3">
              <input type="password" name="password" placeholder="Nhập mật khẩu" required class="form-control">
            </div>
            <input type="hidden" name="login" value="1">
            <button type="submit" class="btn btn-custom-dark btn-block">Đăng nhập</button>
            <a href="/webdr/account/forgot" class="d-block mt-3 text-center">Quên mật khẩu?</a>
          </form>
        </div>
      </div>
    </div>

    <!-- Đăng ký -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title mb-4">ĐĂNG KÝ THÀNH VIÊN MỚI</h2>
          <?php if (isset($errors)): ?>
            <div class='alert alert-danger'>
              <ul class='mb-0'>
                <?php foreach ($errors as $err): ?>
                  <li><?= $err ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="/webdr/account/save" method="post">
            <div class="form-group mb-3">
              <input type="text" name="fullname" placeholder="Họ và tên" required class="form-control">
            </div>
            
            <div class="form-group mb-3">
              <input type="email" name="email" placeholder="Email" required class="form-control">
            </div>
            <div class="form-group mb-3">
              <input type="tel" name="phone" placeholder="Số điện thoại" required class="form-control">
            </div>
            <div class="form-group mb-3">
              <input type="password" name="password" placeholder="Mật khẩu" required class="form-control">
            </div>
            <div class="form-group mb-3">
              <input type="password" name="confirmpassword" placeholder="Xác nhận mật khẩu" required class="form-control">
            </div>
            <button type="submit" class="btn btn-custom-dark btn-block">Đăng ký</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
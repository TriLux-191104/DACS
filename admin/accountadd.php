<?php
include "./class/account_class.php";
$account = new account();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $account->insert_account($email, $password, $fullname, $phone, $role);
}
?>

<?php include 'slider.php'; ?>
<?php include 'header.php'; ?>
<h2>Thêm tài khoản mới</h2>
<form method="post" style="max-width:500px">
  <div class="mb-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Mật khẩu:</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Họ tên:</label>
    <input type="text" name="fullname" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>SĐT:</label>
    <input type="text" name="phone" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Vai trò:</label>
    <select name="role" class="form-control">
      <option value="admin">Admin</option>
      <option value="user">User</option>
    </select>
  </div>
  <button type="submit" class="btn btn-success">Thêm tài khoản</button>
</form>

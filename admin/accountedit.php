<?php
include "./class/account_class.php";
$account = new account();

if (!isset($_GET['id'])) {
    header("Location: accountlist.php");
    exit();
}

$id = $_GET['id'];
$get_account = $account->get_account($id)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $account->update_account($email, $password, $fullname, $phone, $role, $id);
}
?>

<?php include 'slider.php'; ?>
<?php include 'header.php'; ?>
<h2>Chỉnh sửa tài khoản</h2>
<form method="post" style="max-width:500px">
  <div class="mb-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="<?= $get_account['email'] ?>" required>
  </div>
  <div class="mb-3">
    <label>Mật khẩu:</label>
    <input type="text" name="password" class="form-control" value="<?= $get_account['password'] ?>" required>
  </div>
  <div class="mb-3">
    <label>Họ tên:</label>
    <input type="text" name="fullname" class="form-control" value="<?= $get_account['fullname'] ?>" required>
  </div>
  <div class="mb-3">
    <label>SĐT:</label>
    <input type="text" name="phone" class="form-control" value="<?= $get_account['phone'] ?>" required>
  </div>
  <div class="mb-3">
    <label>Vai trò:</label>
    <select name="role" class="form-control">
      <option value="admin" <?= $get_account['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
      <option value="user" <?= $get_account['role'] === 'user' ? 'selected' : '' ?>>User</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>

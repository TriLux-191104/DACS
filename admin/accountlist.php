<?php
include "./class/account_class.php";
$account = new account();

if (isset($_GET['delete'])) {
    $account->delete_account($_GET['delete']);
}
$accounts = $account->show_account();
?>

<?php include 'slider.php'; ?>
<?php include 'header.php'; ?>
<h2>Danh sách tài khoản</h2>
<a href="accountadd.php" class="btn btn-success mb-3">+ Thêm tài khoản</a>

<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Email</th>
      <th>Họ tên</th>
      <th>SĐT</th>
      <th>Vai trò</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($accounts): ?>
      <?php while ($row = $accounts->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['fullname'] ?></td>
          <td><?= $row['phone'] ?></td>
          <td><?= $row['role'] ?></td>
          <td>
            <a href="accountedit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">Không có tài khoản nào.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

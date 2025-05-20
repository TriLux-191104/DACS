<?php
include "session.php";
include "dtb.php";

Session::checkLogin();
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $query = "SELECT id, username, password, fullname FROM loginadmin WHERE username = ?";
    $result = $db->select($query, [$username]);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            Session::init();
            Session::set('login', true);
            Session::set('admin_id', $admin['id']);
            Session::set('admin_name', $admin['fullname']);
            Session::set('admin_username', $admin['username']);
            $db->update("UPDATE loginadmin SET last_login = NOW() WHERE id = ?", [$admin['id']]);
            header("Location: index.php");
            exit;
        } else {
            $error = "Sai mật khẩu";
        }
    } else {
        $error = "Tài khoản không tồn tại";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Đăng nhập Admin</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" class="mt-3">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
<!-- slider.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DROPPY - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
      <div class="sidebar-header">
        <h3>DROPPY</h3>
      </div>
      <div class="sidebar-menu">
        <a href="indexx.php" class="menu-item" id="btn-home">
          <i class="fas fa-home"></i>
          <span>Trang chủ</span>
        </a>
        <a href="cartegorylist.php" class="menu-item">
          <i class="fas fa-layer-group"></i>
          <span>Danh mục</span>
        </a>
        <a href="brandlist.php" class="menu-item">
          <i class="fas fa-tags"></i>
          <span>Thương hiệu</span>
        </a>
        <a href="productlist.php" class="menu-item">
          <i class="fas fa-shopping-bag"></i>
          <span>Sản phẩm</span>
        </a>
        <a href="accountlist.php" class="menu-item">
          <i class="fas fa-users"></i>
          <span>Tài khoản</span>
        </a>
        <a href="orderlist.php" class="menu-item">
          <i class="fas fa-box"></i>
          <span>Đơn hàng</span>
        </a>
        <a href="voucherlist.php" class="menu-item">
          <i class="fas fa-box"></i>
          <span>Vouchers</span>
        </a>
        <a href="chietietthongke.php" class="menu-item">
          <i class="fas fa-chart-bar"></i>
          <span>Thống kê</span>
        </a>
        <div class="menu-logout">
          <a href="adminlogout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
          </a>
        </div>
      </div>
    </nav>
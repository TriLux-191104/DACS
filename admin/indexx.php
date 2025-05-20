<?php
include "class/thongke_class.php";

$thongke = new ThongKe();
$orderCount = $thongke->getOrderCount();
$productCount = $thongke->getProductCount();
$customerCount = $thongke->getCustomerCount();
$revenue = $thongke->getRevenue();
$topProducts = $thongke->getTopProducts();


include "slider.php";
include "header.php";
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DROPPY - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --main-bg: #131722;
      --sidebar-bg: #1c2030;
      --card-bg: #222736;
      --text-primary: #e0e0e0;
      --text-secondary: #a0a0a0;
      --accent-blue: #3861fb;
      --accent-green: #16c784;
      --accent-yellow: #f7931a;
      --accent-red: #ea3943;
      --accent-purple: #8a63d2;
      --border-color: #2a2e39;
      --hover-bg: #2a2e39;
    }
    
    body {
      min-height: 100vh;
      background-color: var(--main-bg);
      color: var(--text-primary);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .wrapper {
      display: flex;
    }
    
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: var(--sidebar-bg);
      position: fixed;
      transition: all 0.3s;
      box-shadow: 2px 0px 10px rgba(0,0,0,0.3);
      z-index: 100;
    }
    
    .sidebar-header {
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid var(--border-color);
    }
    
    .sidebar-header h3 {
      margin: 0;
      font-weight: 700;
      letter-spacing: 1px;
    }
    
    .sidebar-menu {
      padding: 20px 0;
    }
    
    .menu-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      color: var(--text-secondary);
      text-decoration: none;
      transition: all 0.3s;
      margin: 4px 8px;
      border-radius: 8px;
    }
    
    .menu-item:hover, .menu-item.active {
      background-color: var(--hover-bg);
      color: var(--text-primary);
    }
    
    .menu-item i {
      margin-right: 12px;
      font-size: 18px;
      width: 24px;
      text-align: center;
    }
    
    .menu-logout {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid var(--border-color);
    }
    
    .main-content {
      flex: 1;
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s;
    }
    
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
      margin-bottom: 25px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .header h2 {
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }
    
    .admin-info {
      display: flex;
      align-items: center;
    }
    
    .admin-avatar {
      width: 40px;
      height: 40px;
      background-color: var(--accent-blue);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      font-weight: bold;
    }
    
    .dashboard-stats {
      margin-bottom: 30px;
    }
    
    .stat-card {
      background-color: var(--card-bg);
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      border: 1px solid var(--border-color);
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
    }
    
    .stat-card .card-title {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--text-primary);
    }
    
    .stat-card .icon-wrapper {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }
    
    .stat-card .icon-wrapper i {
      font-size: 24px;
    }
    
    .stat-card .btn {
      border-radius: 8px;
      padding: 8px 15px;
      font-weight: 500;
      margin-top: 10px;
      transition: all 0.3s;
    }
    
    .bg-blue {
      background-color: rgba(56, 97, 251, 0.2);
      color: var(--accent-blue);
    }
    
    .bg-green {
      background-color: rgba(22, 199, 132, 0.2);
      color: var(--accent-green);
    }
    
    .bg-yellow {
      background-color: rgba(247, 147, 26, 0.2);
      color: var(--accent-yellow);
    }
    
    .bg-red {
      background-color: rgba(234, 57, 67, 0.2);
      color: var(--accent-red);
    }
    
    .bg-purple {
      background-color: rgba(138, 99, 210, 0.2);
      color: var(--accent-purple);
    }
    
    .btn-blue {
      background-color: var(--accent-blue);
      color: white;
      border: none;
    }
    
    .btn-blue:hover {
      background-color: #2d51d1;
      color: white;
    }
    
    .btn-outline {
      background-color: transparent;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
    }
    
    .btn-outline:hover {
      background-color: var(--hover-bg);
      color: var(--text-primary);
    }
    
    @media (max-width: 992px) {
      .sidebar {
        width: 70px;
        text-align: center;
      }
      
      .sidebar-header h3 {
        display: none;
      }
      
      .menu-item span {
        display: none;
      }
      
      .menu-item i {
        margin-right: 0;
      }
      
      .main-content {
        margin-left: 70px;
      }
    }
  </style>
</head>
<body>
 <!-- Nội dung chính -->
<div id="home-section">
    <div class="row dashboard-stats">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="icon-wrapper bg-blue">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h5 class="card-title">Quản lý danh mục</h5>
  
                <a href="cartegorylist.php" class="btn btn-outline w-100">Xem danh mục</a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="icon-wrapper bg-green">
                    <i class="fas fa-tags"></i>
                </div>
                <h5 class="card-title">Quản lý thương hiệu</h5>

                <a href="brandlist.php" class="btn btn-outline w-100">Xem thương hiệu</a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="icon-wrapper bg-yellow">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h5 class="card-title">Quản lý sản phẩm</h5>

                <a href="productlist.php" class="btn btn-outline w-100">Xem sản phẩm</a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="icon-wrapper bg-red">
                    <i class="fas fa-box"></i>
                </div>
                <h5 class="card-title">Đơn hàng</h5>

                <a href="orderlist.php" class="btn btn-outline w-100">Xem đơn hàng</a>
            </div>
        </div>
    </div>

    <!-- Main Cards -->
    <div class="row">
        <div class="col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title m-0">Tài khoản người dùng</h5>
                    <div class="icon-wrapper bg-purple" style="width: 40px; height: 40px; margin: 0">
                        <i class="fas fa-users" style="font-size: 18px"></i>
                    </div>
                </div>
                <p>Quản lý và theo dõi thông tin tài khoản người dùng</p>
                <div class="d-flex justify-content-between mt-4">
                    <a href="accountlist.php" class="btn btn-outline">Xem tài khoản</a>
                    <a href="accountadd.php" class="btn btn-blue">+ Thêm mới</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title m-0">Thống kê</h5>
                    <div class="icon-wrapper bg-blue" style="width: 40px; height: 40px; margin: 0">
                        <i class="fas fa-chart-bar" style="font-size: 18px"></i>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-4">
                    <h3><?php echo $orderCount['total_orders']; ?></h3>
                        <p>Đơn hàng</p>
                    </div>
                    <div class="col-4">
                    <h3><?php echo $productCount['total_products']; ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="col-4">
                    <h3><?php echo $customerCount['total_customers']; ?></h3>
                        <p>Khách hàng</p>
                    </div>
                </div>
                <a href="chietietthongke.php" class="btn btn-outline w-100 mt-3">Xem chi tiết</a>
            </div>
        </div>
    </div>
</div>


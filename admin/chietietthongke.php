<?php
include "header.php";
include "slider.php";
include "class/thongke_class.php";

$thongke = new ThongKe();
$orderCount = $thongke->getOrderCount();
$productCount = $thongke->getProductCount();
$customerCount = $thongke->getCustomerCount();
$revenue = $thongke->getRevenue();
$topProducts = $thongke->getTopProducts();
$topCustomers = $thongke->getTopCustomers();
$topValueOrders = $thongke->getTopValueOrders();

// Xử lý form thống kê theo thời gian
$timeFilter = $_GET['time_filter'] ?? 'month';
$selectedDate = $_GET['selected_date'] ?? date('Y-m-d');
$selectedMonth = $_GET['selected_month'] ?? date('Y-m');
$selectedYear = $_GET['selected_year'] ?? date('Y');
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');

$revenueByTime = [];
switch ($timeFilter) {
    case 'day':
        $revenueByTime = $thongke->getRevenueByDate($selectedDate);
        break;
    case 'month':
        list($year, $month) = explode('-', $selectedMonth);
        $revenueByTime = $thongke->getRevenueByMonth($year, $month);
        break;
    case 'year':
        $revenueByTime = $thongke->getRevenueByYear($selectedYear);
        break;
    case 'range':
        $revenueByTime = $thongke->getRevenueByDateRange($startDate, $endDate);
        break;
}
?>

<div class="admin-content-right">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Thống kê chi tiết</h2>
    </div>

    <div class="row text-center">
      <div class="col-md-3 stat-box">
        <div class="stat-info">
          <h5>Đơn hàng</h5>
          <h3><?= $orderCount['total_orders'] ?></h3>
        </div>
      </div>
      <div class="col-md-3 stat-box">
        <div class="stat-info">
          <h5>Sản phẩm</h5>
          <h3><?= $productCount['total_products'] ?></h3>
        </div>
      </div>
      <div class="col-md-3 stat-box">
        <div class="stat-info">
          <h5>Khách hàng</h5>
          <h3><?= $customerCount['total_customers'] ?></h3>
        </div>
      </div>
      <div class="col-md-3 stat-box">
        <div class="stat-info">
          <h5>Doanh thu</h5>
          <h3><?= number_format($revenue['total_revenue'], 0, ',', '.') . ' ₫' ?></h3>
        </div>
      </div>
    </div>

    <!-- Form lọc thời gian -->
    <div class="time-filter-form">
      <form method="get" action="">
        <div class="form-group">
          <label>Chọn kiểu thống kê:</label>
          <select name="time_filter" id="time_filter" class="form-select" onchange="updateTimeFilter()">
            <option value="day" <?= $timeFilter == 'day' ? 'selected' : '' ?>>Theo ngày</option>
            <option value="month" <?= $timeFilter == 'month' ? 'selected' : '' ?>>Theo tháng</option>
            <option value="year" <?= $timeFilter == 'year' ? 'selected' : '' ?>>Theo năm</option>
            <option value="range" <?= $timeFilter == 'range' ? 'selected' : '' ?>>Khoảng thời gian</option>
          </select>
        </div>
        
        <div id="day_filter" class="form-group" style="display: <?= $timeFilter == 'day' ? 'block' : 'none' ?>">
          <label>Chọn ngày:</label>
          <input type="date" name="selected_date" value="<?= $selectedDate ?>" class="form-control">
        </div>
        
        <div id="month_filter" class="form-group" style="display: <?= $timeFilter == 'month' ? 'block' : 'none' ?>">
          <label>Chọn tháng:</label>
          <input type="month" name="selected_month" value="<?= $selectedMonth ?>" class="form-control">
        </div>
        
        <div id="year_filter" class="form-group" style="display: <?= $timeFilter == 'year' ? 'block' : 'none' ?>">
          <label>Chọn năm:</label>
          <select name="selected_year" class="form-select">
            <?php for($y = date('Y'); $y >= 2020; $y--): ?>
              <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
        
        <div id="range_filter" class="form-group" style="display: <?= $timeFilter == 'range' ? 'block' : 'none' ?>">
          <div class="row">
            <div class="col-md-6">
              <label>Từ ngày:</label>
              <input type="date" name="start_date" value="<?= $startDate ?>" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Đến ngày:</label>
              <input type="date" name="end_date" value="<?= $endDate ?>" class="form-control">
            </div>
          </div>
        </div>
        
        <button type="submit" class="btn btn-green mt-3">Xem thống kê</button>
      </form>
      
      <?php if(!empty($revenueByTime)): ?>
        <div class="mt-3">
          <h4>
            <?php 
              switch($timeFilter) {
                case 'day': echo "Doanh thu ngày " . date('d/m/Y', strtotime($selectedDate)); break;
                case 'month': 
                  list($year, $month) = explode('-', $selectedMonth);
                  echo "Doanh thu tháng $month/$year"; 
                  break;
                case 'year': echo "Doanh thu năm $selectedYear"; break;
                case 'range': echo "Doanh thu từ " . date('d/m/Y', strtotime($startDate)) . " đến " . date('d/m/Y', strtotime($endDate)); break;
              }
            ?>:
            <span class="text-success">
              <?= number_format($revenueByTime[array_key_first($revenueByTime)], 0, ',', '.') ?> ₫
            </span>
          </h4>
        </div>
      <?php endif; ?>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <div class="stat-card">
          <h4>Top khách hàng mua nhiều nhất</h4>
          <div class="table-responsive">
            <table class="table table-dark table-striped mt-3">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tên khách hàng</th>
                  <th>Số đơn</th>
                  <th>Tổng chi tiêu</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 0;
                while ($row = $topCustomers->fetch_assoc()) {
                  $i++;
                  echo "<tr>
                    <td>$i</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['order_count']}</td>
                    <td>" . number_format($row['total_spent'], 0, ',', '.') . " ₫</td>
                  </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="stat-card">
          <h4>Top đơn hàng giá trị nhất</h4>
          <div class="table-responsive">
            <table class="table table-dark table-striped mt-3">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Khách hàng</th>
                  <th>Giá trị</th>
                  <th>Ngày đặt</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 0;
                while ($row = $topValueOrders->fetch_assoc()) {
                  $i++;
                  echo "<tr>
                    <td>$i</td>
                    <td>{$row['customer_name']}</td>
                    <td>" . number_format($row['total'], 0, ',', '.') . " ₫</td>
                    <td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>
                    <td>{$row['status']}</td>
                  </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="stat-card mt-4">
      <h4>Sản phẩm bán chạy</h4>
      <div class="table-responsive">
        <table class="table table-dark table-striped mt-3">
          <thead>
            <tr>
              <th>#</th>
              <th>Sản phẩm</th>
              <th>Số lượng đã bán</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i = 0;
            while ($row = $topProducts->fetch_assoc()) {
              $i++;
              echo "<tr>
                <td>$i</td>
                <td>{$row['product_name']}</td>
                <td>{$row['total_sold']}</td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function updateTimeFilter() {
  var filter = document.getElementById('time_filter').value;
  
  document.getElementById('day_filter').style.display = 'none';
  document.getElementById('month_filter').style.display = 'none';
  document.getElementById('year_filter').style.display = 'none';
  document.getElementById('range_filter').style.display = 'none';
  
  if(filter === 'day') {
    document.getElementById('day_filter').style.display = 'block';
  } else if(filter === 'month') {
    document.getElementById('month_filter').style.display = 'block';
  } else if(filter === 'year') {
    document.getElementById('year_filter').style.display = 'block';
  } else if(filter === 'range') {
    document.getElementById('range_filter').style.display = 'block';
  }
}
</script>


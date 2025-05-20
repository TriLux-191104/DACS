<?php
include "./class/order_class.php";
$order = new Order();

// Lấy tham số lọc từ URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$month = isset($_GET['month']) ? (int)$_GET['month'] : 0;
$day = isset($_GET['day']) ? (int)$_GET['day'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Lấy danh sách đơn hàng đã lọc
$orderList = $order->getFilteredOrders($search, $month, $day, $sort, $status);
?>

<?php include "slider.php"; ?>
<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Danh sách đơn hàng</h3>

            <!-- Form lọc và tìm kiếm -->
            <form method="GET" class="mb-4 bg-light p-3 rounded">
                <div class="row g-3 align-items-end">
                    <!-- Ô tìm kiếm -->
                    <div class="col-md-3">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="ID, tên, SĐT..." value="<?= htmlspecialchars($search) ?>">
                    </div>

                    <!-- Lọc theo tháng -->
                    <div class="col-md-2">
                        <label class="form-label">Tháng</label>
                        <select name="month" class="form-select">
                            <option value="0">Tất cả tháng</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $month == $i ? 'selected' : '' ?>>
                                    Tháng <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Lọc theo ngày -->
                    <div class="col-md-2">
                        <label class="form-label">Ngày</label>
                        <select name="day" class="form-select">
                            <option value="0">Tất cả ngày</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <option value="<?= $i ?>" <?= $day == $i ? 'selected' : '' ?>>
                                    Ngày <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Lọc theo trạng thái -->
                    <div class="col-md-2">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="Chờ xử lý" <?= $status == 'Chờ xử lý' ? 'selected' : '' ?>>Chờ xử lý</option>
                            <option value="Đã thanh toán" <?= $status == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                            <option value="Đã gửi hàng" <?= $status == 'Đã gửi hàng' ? 'selected' : '' ?>>Đã gửi hàng</option>
                            <option value="Đã giao" <?= $status == 'Đã giao' ? 'selected' : '' ?>>Đã giao</option>
                            <option value="Đã huỷ" <?= $status == 'Đã huỷ' ? 'selected' : '' ?>>Đã huỷ</option>
                        </select>
                    </div>

                    <!-- Sắp xếp -->
                    <div class="col-md-2">
                        <label class="form-label">Sắp xếp</label>
                        <select name="sort" class="form-select">
                            <option value="date_desc" <?= $sort == 'date_desc' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="date_asc" <?= $sort == 'date_asc' ? 'selected' : '' ?>>Cũ nhất</option>
                            <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá cao nhất</option>
                            <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá thấp nhất</option>
                        </select>
                    </div>

                    <!-- Nút lọc và reset -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                    </div>
                    <div class="col-md-1">
                        <a href="orderlist.php" class="btn btn-secondary w-100">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Bảng danh sách đơn hàng -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Khách hàng</th>
                            <th width="10%">Ngày đặt</th>
                            <th width="15%">Địa chỉ</th>
                            <th width="10%">Số điện thoại</th>
                            <th width="10%">Tổng tiền</th>
                            <th width="10%">Trạng thái</th>
                            <th width="15%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orderList && mysqli_num_rows($orderList) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($orderList)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td>
                                        <?= $row['fullname'] ?? '<i>Khách vãng lai</i>' ?>
                                        <?php if ($row['id_account']): ?>
                                            <br><small class="text-muted">ID: <?= $row['id_account'] ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td class="text-end"><?= number_format($row['total']) ?>₫</td>
                                    <td>
                                        <span class="badge 
                                            <?= $row['status'] == 'Đã thanh toán' ? 'bg-success' : '' ?>
                                            <?= $row['status'] == 'Chờ xử lý' ? 'bg-warning text-dark' : '' ?>
                                            <?= $row['status'] == 'Đã gửi hàng' ? 'bg-info' : '' ?>
                                            <?= $row['status'] == 'Đã giao' ? 'bg-primary' : '' ?>
                                            <?= $row['status'] == 'Đã huỷ' ? 'bg-danger' : '' ?>">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="orderdetail.php?order_id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-info me-1"
                                           title="Xem chi tiết">
                                           <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="orderedit.php?order_id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-warning me-1"
                                           title="Sửa">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="orderdelete.php?order_id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           title="Xoá"
                                           onclick="return confirm('Xác nhận xoá đơn hàng #<?= $row['id'] ?>?')">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-box-open fa-2x mb-3"></i>
                                        <p>Không tìm thấy đơn hàng nào phù hợp</p>
                                        <a href="orderlist.php" class="btn btn-sm btn-outline-primary">Xem tất cả đơn hàng</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang (có thể thêm sau) -->
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


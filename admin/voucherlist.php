<?php
include "session.php";
include "class/voucher_class.php";

Session::checkSession();
$voucher = new Voucher();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

$voucherList = $voucher->getFilteredVouchers($search, $status, $sort);

$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<?php include "slider.php"; ?>
<?php include "header.php"; ?>

<div class="container-fluid">
    <h3 class="mb-4">Danh sách Voucher</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Form lọc và tìm kiếm -->
    <form method="GET" class="mb-4 bg-light p-3 rounded">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Mã hoặc mô tả..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="active" <?php echo $status == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                    <option value="inactive" <?php echo $status == 'inactive' ? 'selected' : ''; ?>>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Sắp xếp</label>
                <select name="sort" class="form-select">
                    <option value="date_desc" <?php echo $sort == 'date_desc' ? 'selected' : ''; ?>>Mới nhất</option>
                    <option value="date_asc" <?php echo $sort == 'date_asc' ? 'selected' : ''; ?>>Cũ nhất</option>
                    <option value="code_asc" <?php echo $sort == 'code_asc' ? 'selected' : ''; ?>>Mã A-Z</option>
                    <option value="code_desc" <?php echo $sort == 'code_desc' ? 'selected' : ''; ?>>Mã Z-A</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </div>
            <div class="col-md-1">
                <a href="voucherlist.php" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Bảng danh sách voucher -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">Mã Voucher</th>
                    <th width="10%">Loại giảm giá</th>
                    <th width="10%">Giá trị</th>
                    <th width="15%">Thời hạn</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Đã sử dụng</th>
                    <th width="15%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($voucherList && mysqli_num_rows($voucherList) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($voucherList)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['code']); ?></td>
                            <td><?php echo $row['discount_type'] == 'percentage' ? 'Phần trăm' : 'Cố định'; ?></td>
                            <td>
                                <?php 
                                echo $row['discount_type'] == 'percentage' 
                                    ? $row['discount_value'] . '%' 
                                    : number_format($row['discount_value'], 0, ',', '.') . '₫';
                                ?>
                            </td>
                            <td>
                                <?php echo date('d/m/Y H:i', strtotime($row['start_date'])); ?> - 
                                <?php echo date('d/m/Y H:i', strtotime($row['end_date'])); ?>
                            </td>
                            <td>
                                <span class="badge <?php echo $row['status'] == 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                    <?php echo $row['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $row['used_count']; ?>
                                <?php if ($row['usage_limit']): ?>
                                    /<?php echo $row['usage_limit']; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="voucheredit.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-warning me-1" title="Sửa">
                                   <i class="fas fa-edit"></i>
                                </a>
                                <a href="vouchersend.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-info me-1" title="Gửi">
                                   <i class="fas fa-paper-plane"></i>
                                </a>
                                <a href="voucherdelete.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-danger" title="Xóa"
                                   onclick="return confirm('Xác nhận xóa voucher #<?php echo $row['code']; ?>?')">
                                   <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-ticket-alt fa-2x mb-3"></i>
                                <p>Không tìm thấy voucher nào phù hợp</p>
                                <a href="voucherlist.php" class="btn btn-sm btn-outline-primary">Xem tất cả voucher</a>
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


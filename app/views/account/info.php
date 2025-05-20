<?php include 'app/views/shares/header.php'; ?>

<!-- Nội dung chính của trang thông tin tài khoản -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h4 mb-0">THÔNG TIN TÀI KHOẢN</h1>
                            <p class="mb-0">Xin chào, <?php echo htmlspecialchars($user['fullname']); ?></p>
                        </div>
                        <div class="text-end">
                            <p class="mb-1">Tài khoản của tôi</p>
                            
                            <p class="mb-1"><a href="#" class="text-primary">Sổ địa chỉ (0)</a></p>
                            <a href="/webdr/account/logout" class="btn btn-danger btn-sm">Đăng xuất</a>
                        </div>
                    </div>

                    <h3 class="h5 mb-3">Đơn hàng gần nhất</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Đơn hàng #</th>
                                    <th>Ngày</th>
                                    <th>Chuyển đến</th>
                                    <th>Giá trị đơn hàng</th>
                                    <th>Tình trạng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-muted text-center">Không có đơn hàng nào.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                            <a href="/webdr/account/orderDetails/<?php echo $order['id']; ?>">
        <?php echo htmlspecialchars($order['id']); ?>
    </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                                            <td><?php echo number_format($order['total'], 0, ',', '.') . ' VNĐ'; ?></td>
                                            <!-- Phần hiển thị trạng thái đơn hàng -->
<td>
    <?php 
    // Hiển thị trạng thái đã được chuẩn hóa
    echo htmlspecialchars($order['status_display']); 
    
    // Hiển thị giá trị gốc trong tooltip (cho debug)
    if ($order['status_display'] != $order['status']) {
        echo ' <i class="fas fa-info-circle text-muted" title="Giá trị gốc: '.htmlspecialchars($order['status']).'"></i>';
    }
    ?>
</td>
                                            <td>
                                                <?php if (in_array($order['status'], ['Chờ xử lý', 'Đã thanh toán'])): ?>
                                                    <a href="/webdr/account/cancelOrder/<?php echo $order['id']; ?>" 
                                                       class="text-danger" 
                                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                                        Hủy
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>


                                        
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                        <!-- Thêm vào sau phần đơn hàng -->
                                        <div class="card shadow-sm mt-4">
    <div class="card-body">
        <h3 class="h5 mb-3">Voucher của tôi</h3>
        <div class="row">
            <?php 
            $vouchers = $this->accountModel->getAccountVouchers($account->id);
            if (empty($vouchers)): ?>
                <div class="col-12 text-muted text-center">Bạn chưa có voucher nào.</div>
            <?php else: ?>
                <?php foreach ($vouchers as $voucher): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success"><?php echo htmlspecialchars($voucher->voucher_code); ?></h5>
                                <p class="card-text">
                                    Giảm <?php echo $voucher->discount_value; ?>
                                    <?php echo $voucher->discount_type === 'percent' ? '%' : 'k'; ?>
                                </p>
                                <p class="small text-muted">
                                    HSD: <?php echo date('d/m/Y', strtotime($voucher->end_date)); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
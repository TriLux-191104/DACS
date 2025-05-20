<?php include 'app/views/shares/header.php'; ?>

<!-- Nội dung chính của trang chi tiết đơn hàng -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">CHI TIẾT ĐƠN HÀNG #<?php echo htmlspecialchars($order['id']); ?></h1>

                    <!-- Thông tin đơn hàng -->
                    <div class="mb-4">
                        <h3 class="h5 mb-3">Thông tin đơn hàng</h3>
                        <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
                        <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                        <p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                        <p><strong>Tổng giá trị:</strong> <?php echo number_format($order['total'], 0, ',', '.') . ' VNĐ'; ?></p>
                        <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                    </div>

                    <!-- Danh sách sản phẩm trong đơn hàng -->
                    <h3 class="h5 mb-3">Sản phẩm trong đơn hàng</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($order_details)): ?>
                                    <tr>
                                        <td colspan="5" class="text-muted text-center">Không có sản phẩm nào trong đơn hàng này.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($order_details as $detail): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                                            <td>
                                                <img src="/webdr/uploads/<?php echo htmlspecialchars($detail['product_img']); ?>" 
                                                     alt="<?php echo htmlspecialchars($detail['product_name']); ?>" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                                            <td><?php echo number_format($detail['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                            <td><?php echo number_format($detail['quantity'] * $detail['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Nút quay lại -->
                    <a href="/webdr/account/info" class="btn btn-secondary mt-3">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
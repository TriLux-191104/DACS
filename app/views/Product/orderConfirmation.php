<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow">
                <div class="card-body p-5">
                    <!-- Biểu tượng thành công -->
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-success mb-3">Đặt hàng thành công!</h1>
                    <p class="lead mb-4">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đang được xử lý.</p>
                    
                    <?php if (isset($account_id)): ?>
                        <div class="alert alert-info mb-4">
                            <p class="mb-1">Mã đơn hàng: <?= htmlspecialchars($order_id ?? 'Đang cập nhật') ?></p>
                            <p class="mb-0">Bạn có thể xem chi tiết đơn hàng trong <a href="/webdr/account/info" class="font-weight-bold">tài khoản của bạn</a></p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-4">
                            <p>Bạn đã đặt hàng với tư cách khách. Vui lòng <a href="/webdr/account/log" class="font-weight-bold">đăng nhập</a> để theo dõi đơn hàng.</p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-5 pt-4 border-top">
                        <a href="/webdr/Product/home" class="btn btn-outline-primary px-4 py-2">
                            <i class="fas fa-shopping-bag mr-2"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
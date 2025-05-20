<?php include 'app/views/shares/header.php'; ?>

<style>
    .checkout-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        font-family: 'Helvetica Neue', sans-serif;
    }

    .checkout-title {
        font-size: 36px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 1px;
    }

    .checkout-form label {
        font-weight: 600;
        margin-top: 15px;
        display: block;
    }

    .checkout-form input, 
    .checkout-form textarea {
        border-radius: 20px;
        border: 1px solid #ccc;
        padding: 12px 20px;
        width: 100%;
        margin-top: 5px;
        font-size: 16px;
    }

    .checkout-form button {
        background: #000;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 30px;
        font-size: 18px;
        margin-top: 25px;
        transition: 0.3s;
    }

    .checkout-form button:hover {
        background: #444;
    }

    .order-summary {
        background: #f9f9f9;
        border-radius: 20px;
        padding: 25px;
        margin-top: 20px;
    }

    .order-summary h3 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .list-group-item {
        border: none;
        font-size: 16px;
    }

    .list-group-item strong {
        font-weight: 600;
    }

    .text-right {
        text-align: right;
    }

    .btn-back {
        display: inline-block;
        margin-top: 20px;
        background: #000;
        color: #fff;
        border-radius: 30px;
        padding: 10px 25px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #444;
    }

    .voucher-section {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .voucher-input {
        display: flex;
        gap: 10px;
    }
    
    .voucher-input input {
        flex: 1;
        border-radius: 20px;
        padding: 12px 15px;
    }
    
    .voucher-input button {
        border-radius: 20px;
        padding: 0 20px;
        background: #000;
        color: white;
        border: none;
    }
    
    .voucher-list {
        margin-top: 15px;
    }
    
    .voucher-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        margin-bottom: 8px;
        background: white;
        border-radius: 8px;
        align-items: center;
    }
    
    .voucher-code {
        font-weight: bold;
        color: #28a745;
    }
    
    .voucher-value {
        font-weight: bold;
    }
    
    .voucher-apply {
        color: #007bff;
        cursor: pointer;
        text-decoration: underline;
    }
    
    .discount-row {
        color: #28a745;
        font-weight: bold;
    }
    
    .voucher-alert {
        margin-bottom: 15px;
    }

    /* Thêm CSS cho phương thức thanh toán */
    .payment-methods {
        margin-top: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .payment-methods h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .payment-methods label {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .payment-methods input[type="radio"] {
        margin-right: 10px;
        width: auto;
    }
</style>

<div class="checkout-container">
    <h1 class="checkout-title">💳 Thanh Toán Đơn Hàng</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning text-center">🛒 Giỏ hàng trống! Không thể thanh toán.</div>
        <div class="text-center">
            <a href="/webdr/Product/home" class="btn-back">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="/webdr/Product/processCheckout" class="checkout-form">
                    <label>👤 Họ và tên:</label>
                    <input type="text" name="name" value="<?= isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : '' ?>" required>

                    <label>📞 Số điện thoại:</label>
                    <input type="tel" name="phone" value="<?= isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : '' ?>" required>

                    <label>🏠 Địa chỉ giao hàng:</label>
                    <textarea name="address" rows="4" required><?= isset($_SESSION['form_data']['address']) ? htmlspecialchars($_SESSION['form_data']['address']) : '' ?></textarea>

                    <!-- Thêm phần chọn phương thức thanh toán -->
                    <div class="payment-methods">
                        <h3>💵 Phương thức thanh toán</h3>
                        <label>
                            <input type="radio" name="payment_method" value="COD" checked> Thanh toán khi nhận hàng (COD)
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="MOMO_QR"> Thanh toán qua MoMo QR
                        </label>
                    </div>

                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token'] ?? '') ?>">
                    <button type="submit" name="submit_checkout">THANH TOÁN</button>
                </form>
            </div>

            <div class="col-md-6">
                <div class="order-summary">
                    <h3>🧾 Đơn hàng của bạn</h3>
                    <ul class="list-group">
                        <?php 
                        $total = 0;
                        $discount = 0;
                        $discountType = '';
                        $discountCode = '';
                        
                        foreach ($_SESSION['cart'] as $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
                                <span><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                            </li>
                        <?php endforeach; ?>
                        
                        <?php if (isset($_SESSION['voucher_applied'])): 
                            $discount = $_SESSION['voucher_applied']['discount'];
                            $discountType = $_SESSION['voucher_applied']['type'];
                            $discountCode = $_SESSION['voucher_applied']['code'];
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center discount-row">
                                <span>Giảm giá (<?= htmlspecialchars($discountCode) ?>):</span>
                                <span>-<?= number_format($discount, 0, ',', '.') ?> ₫</span>
                            </li>
                        <?php endif; ?>
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Tổng cộng:</strong>
                            <strong><?= number_format($total - $discount, 0, ',', '.') ?> ₫</strong>
                        </li>
                    </ul>

                    <div class="voucher-section">
                        <h5>🎫 Mã giảm giá</h5>
                        
                        <?php if (isset($_SESSION['voucher_applied'])): ?>
                            <div class="alert alert-success">
                                Đã áp dụng voucher: <strong><?= htmlspecialchars($_SESSION['voucher_applied']['code']) ?></strong>
                                (Giảm <?= number_format($_SESSION['voucher_applied']['discount'], 0, ',', '.') ?> ₫)
                            </div>
                            <a href="/webdr/Product/clearVoucher" class="btn btn-sm btn-danger">Xóa voucher</a>
                        <?php else: ?>
                            <div class="voucher-input">
                                <input type="text" id="voucher-code" placeholder="Nhập mã giảm giá">
                                <button id="apply-voucher">Áp dụng</button>
                            </div>
                            
                            <?php if (!empty($vouchers)): ?>
                                <div class="voucher-list">
                                    <h6>Voucher của bạn:</h6>
                                    <?php foreach ($vouchers as $voucher): ?>
                                        <?php if (!$voucher->is_used): ?>
                                            <div class="voucher-item">
                                                <span class="voucher-code"><?= htmlspecialchars($voucher->voucher_code) ?></span>
                                                <span class="voucher-value">
                                                    Giảm <?= $voucher->discount_value ?>
                                                    <?= $voucher->discount_type === 'percent' ? '%' : 'k' ?>
                                                </span>
                                                <span class="voucher-apply" data-code="<?= htmlspecialchars($voucher->voucher_code) ?>">Áp dụng</span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    $('#apply-voucher').click(function() {
        const voucherCode = $('#voucher-code').val().trim();
        if (!voucherCode) {
            alert('Vui lòng nhập mã giảm giá');
            return;
        }
        
        applyVoucher(voucherCode);
    });
    
    $(document).on('click', '.voucher-apply', function() {
        const voucherCode = $(this).data('code');
        $('#voucher-code').val(voucherCode);
        applyVoucher(voucherCode);
    });
    
    function applyVoucher(code) {
        $.ajax({
            url: '/webdr/Product/applyVoucher',
            type: 'POST',
            data: { voucher_code: code },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi áp dụng voucher');
            }
        });
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
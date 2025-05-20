<?php include 'app/views/shares/header.php'; ?>

<style>
    .qr-container {
        max-width: 600px;
        margin: 40px auto;
        text-align: center;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        font-family: 'Helvetica Neue', sans-serif;
    }

    .qr-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .qr-image img {
        max-width: 250px;
        height: auto;
        border: 2px solid #ddd;
        border-radius: 10px;
    }

    .qr-instructions {
        margin: 20px 0;
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }

    .qr-instructions p {
        margin: 8px 0;
    }

    .qr-instructions strong {
        color: #e91e63;
    }

    .confirm-button {
        margin-top: 25px;
        background: #28a745;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 18px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .confirm-button:hover {
        background: #218838;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="qr-container">
    <h2 class="qr-title">Thanh toán qua MoMo</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="qr-image">
        <!-- Thay bằng QR code thực tế của bạn -->
        <img src="/uploads/momo_qr.jpg" alt="MoMo QR Code">
    </div>
    <div class="qr-instructions">
        <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($data['order_id']) ?></p>
        <p><strong>Số tiền cần chuyển:</strong> <?= number_format($data['total'], 0, ',', '.') ?> ₫</p>
        <p><strong>Nội dung chuyển khoản:</strong> <?= htmlspecialchars($data['order_id']) ?></p>
        <p><strong>Tài khoản MoMo:</strong> 0909123456 - Nguyễn Văn A</p>
        <p>📱 Vui lòng làm theo các bước sau:</p>
        <p>1. Mở ứng dụng MoMo và quét mã QR trên.</p>
        <p>2. Nhập số tiền chính xác: <strong><?= number_format($data['total'], 0, ',', '.') ?> ₫</strong></p>
        <p>3. Nhập nội dung chuyển khoản: <strong><?= htmlspecialchars($data['order_id']) ?></strong></p>
        <p>4. Hoàn tất chuyển khoản và nhấn nút xác nhận bên dưới.</p>
    </div>
    <form action="/webdr/Product/confirmPayment" method="POST">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($data['order_id']) ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">
        <button type="submit" name="confirm_payment" class="confirm-button">✅ Tôi đã thanh toán</button>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
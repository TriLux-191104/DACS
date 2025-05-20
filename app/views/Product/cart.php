<?php include 'app/views/shares/header.php'; ?>

<!-- CSS tùy chỉnh cho trang giỏ hàng -->
<style>
    body {
        background-color: #fff;
    }

    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .cart-header {
        font-size: 1.5rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 1.5rem;
    }

    .cart-empty {
        text-align: center;
        padding: 3rem;
        background: #fff;
        border-radius: 10px;
    }

    .cart-empty i {
        font-size: 3rem;
        color: #000;
        margin-bottom: 1rem;
    }

    .cart-empty p {
        font-size: 1.1rem;
        color: #000;
    }

    .cart-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #000;
    }

    .cart-table {
        background: #fff;
    }

    .cart-table thead {
        background: transparent;
    }

    .cart-table th {
        font-weight: 700;
        color: #000;
        padding: 0.5rem 1rem;
        border: none;
        border-bottom: 1px solid #ddd;
    }

    .cart-table td {
        vertical-align: middle;
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #ddd;
    }

    .cart-table img {
        max-width: 60px;
        border-radius: 5px;
    }

    .cart-table .product-name {
        font-weight: 500;
        color: #000;
        text-decoration: none;
    }

    .cart-table .product-name:hover {
        color: #000;
        text-decoration: underline;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-control button {
        background: #fff;
        border: 1px solid #ddd;
        padding: 0.2rem 0.5rem;
        font-size: 1rem;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.3s ease;
    }

    .quantity-control button:hover {
        border-color: #000;
    }

    .quantity-control input {
        width: 40px;
        text-align: center;
        border: none;
        padding: 0.3rem;
        font-size: 0.9rem;
    }

    .subtotal {
        font-weight: 700;
        color: #000;
    }

    .remove-item {
        background: transparent;
        border: none;
        color: #000;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .remove-item:hover {
        color: #666;
    }

    .cart-summary {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    .cart-summary .total {
        font-size: 1.2rem;
        font-weight: 700;
        color: #000;
    }

    .btn-checkout {
        background: #000;
        color: #fff;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .btn-checkout:hover {
        background: #333;
    }

    .btn-continue {
        background: #000;
        color: #fff;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        transition: background 0.3s ease;
        margin-top: 1rem;
        display: block;
        text-align: center;
        width: fit-content;
    }

    .btn-continue:hover {
        background: #333;
    }

    /* Toast thông báo */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }

    .toast {
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .cart-table th, .cart-table td {
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .cart-table img {
            max-width: 50px;
        }

        .quantity-control input {
            width: 30px;
        }

        .cart-summary .total {
            font-size: 1rem;
        }

        .btn-checkout, .btn-continue {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Giao diện chính của trang giỏ hàng -->
<div class="cart-container">
    <h1 class="cart-header">GIỎ HÀNG</h1>

    <!-- Kiểm tra nếu giỏ hàng trống -->
    <?php if (empty($_SESSION['cart'])): ?>
        <!-- Hiển thị thông báo giỏ hàng trống -->
        <div class="cart-empty">
            <i class="fas fa-shopping-cart"></i>
            <p>Giỏ hàng của bạn đang trống! Hãy thêm sản phẩm ngay.</p>
            <a href="/webdr/Product/" class="btn btn-continue">
                TIẾP TỤC MUA SẮM
            </a>
        </div>
    <?php else: ?>
        <!-- Hiển thị thông tin giỏ hàng -->
        <div class="cart-info">
            <span>Số sản phẩm: <?= count($_SESSION['cart']) ?> (lượng)</span>
        </div>

        <!-- Bảng hiển thị sản phẩm -->
        <div class="cart-table">
            <table class="table table-hover text-center mb-0">
                <thead>
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Kích thước</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr data-id="<?= $id ?>">
                        <!-- Hình ảnh và tên sản phẩm -->
                        <td class="text-left">
                            <div class="d-flex align-items-center">
                                <a href="/webdr/Product/show/<?= $id ?>">
                                    <img src="/webdr/uploads/<?= htmlspecialchars($item['image']) ?>" 
                                         alt="<?= htmlspecialchars($item['name']) ?>">
                                </a>
                                <div class="ms-3">
                                    <a href="/webdr/Product/show/<?= $id ?>" class="product-name">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <!-- Kích thước (giả lập) -->
                        <td>S</td>
                        <!-- Số lượng sản phẩm -->
                        <td>
                            <div class="quantity-control">
                                <button class="decrease">-</button>
                                <input type="number" min="1" max="99" value="<?= $item['quantity'] ?>" 
                                       class="quantity" readonly>
                                <button class="increase">+</button>
                            </div>
                        </td>
                        <!-- Giá sản phẩm -->
                        <td class="price"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                        <!-- Thành tiền -->
                        <td class="subtotal"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                        <!-- Nút xóa sản phẩm -->
                        <td>
                            <button class="remove-item" title="Xóa sản phẩm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tổng tiền và nút thanh toán -->
        <div class="cart-summary">
            <div>
                <h4 class="mb-0">TỔNG TIỀN: <span id="total" class="total">
                    <?= number_format($total, 0, ',', '.') ?>đ
                </span></h4>
            </div>
            <a href="/webdr/Product/checkout" class="btn btn-checkout ms-3">
                THANH TOÁN
            </a>
        </div>

        <!-- Nút tiếp tục mua sắm -->
        <a href="/webdr/Product/" class="btn btn-continue">
            TIẾP TỤC MUA SẮM
        </a>
    <?php endif; ?>
</div>

<!-- Toast container -->
<div class="toast-container"></div>

<!-- Script xử lý -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const formatNumber = num => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Hàm hiển thị toast thông báo
    const showToast = (message, type = 'success') => {
        const toast = document.createElement('div');
        toast.classList.add('toast', `bg-${type}`, 'text-white');
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="toast-body">
                ${message}
            </div>
        `;
        document.querySelector('.toast-container').appendChild(toast);
        const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    };

    const updateTotal = () => {
        let total = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const price = parseInt(row.querySelector('.price').textContent.replace(/[^\d]/g, ''));
            const quantity = parseInt(row.querySelector('.quantity').value);
            total += price * quantity;
        });
        const totalElement = document.getElementById('total');
        totalElement.textContent = formatNumber(total) + 'đ';
    };

    // Xử lý tăng/giảm số lượng
    document.querySelector('tbody').addEventListener('click', (event) => {
        const btn = event.target;
        if (btn.classList.contains('increase') || btn.classList.contains('decrease')) {
            const row = btn.closest('tr');
            const input = row.querySelector('.quantity');
            let quantity = parseInt(input.value);
            quantity = btn.classList.contains('increase') ? quantity + 1 : quantity - 1;
            quantity = Math.max(1, Math.min(99, quantity));
            input.value = quantity;

            const id = row.dataset.id;
            const price = parseInt(row.querySelector('.price').textContent.replace(/[^\d]/g, ''));
            row.querySelector('.subtotal').textContent = formatNumber(price * quantity) + 'đ';
            updateTotal();

            // Gửi yêu cầu cập nhật số lượng lên server
            fetch(`/webdr/Product/updateCart/${id}/${quantity}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Cập nhật số lượng thành công!', 'success');
                    } else {
                        showToast(data.message || 'Không thể cập nhật số lượng.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật số lượng:', error);
                    showToast('Đã xảy ra lỗi. Vui lòng thử lại.', 'danger');
                });
        }
    });

    // Xóa sản phẩm
    document.querySelector('tbody').addEventListener('click', (event) => {
        const btn = event.target.closest('.remove-item');
        if (btn) {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                const row = btn.closest('tr');
                const productId = row.dataset.id;

                fetch(`/webdr/Product/removeFromCart/${productId}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            updateTotal();
                            if (!document.querySelector('tbody tr')) {
                                location.reload();
                            }
                            showToast('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
                        } else {
                            showToast('Không thể xóa sản phẩm.', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi xóa sản phẩm:', error);
                        showToast('Đã xảy ra lỗi. Vui lòng thử lại.', 'danger');
                    });
            }
        }
    });

    updateTotal();
});
</script>

<!-- Thêm Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php include 'app/views/shares/footer.php'; ?>
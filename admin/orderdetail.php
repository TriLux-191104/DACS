<?php
include "./class/order_class.php";
include "slider.php";
include "header.php";

$order = new Order();

if (!isset($_GET['order_id'])) {
    header("Location: orderlist.php");
    exit;
}

$order_id = intval($_GET['order_id']);
$orderData = $order->getOrderDetails($order_id);

if (!$orderData) {
    echo "<div class='alert alert-danger'>Không tìm thấy đơn hàng</div>";
    include "footer.php";
    exit;
}

$orderInfo = $orderData['order'];
$orderDetails = $orderData['details'];
?>

<!-- Chi tiết sản phẩm -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="15%">Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th width="12%">Đơn giá</th>
                        <th width="10%">Số lượng</th>
                        <th width="15%">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($orderDetails) > 0): ?>
                        <?php 
                        $i = 1;
                        $subTotal = 0;
                        while ($item = mysqli_fetch_assoc($orderDetails)): 
                            $itemTotal = $item['price'] * $item['quantity'];
                            $subTotal += $itemTotal;
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <a href="/webdr/Product/show/<?= $item['product_id'] ?>" target="_blank">
                                        <?php if (!empty($item['product_img'])): ?>
                                            <img src="/webdr/uploads/<?= $item['product_img'] ?>" 
                                                 class="img-thumbnail" 
                                                 style="width:80px;height:80px;object-fit:cover"
                                                 alt="<?= htmlspecialchars($item['product_name']) ?>">
                                        <?php else: ?>
                                            <div class="img-thumbnail d-flex align-items-center justify-content-center" 
                                                 style="width:80px;height:80px;background:#f8f9fa">
                                                <i class="fas fa-image fa-lg text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="/webdr/Product/show/<?= $item['product_id'] ?>" target="_blank" 
                                       class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($item['product_name']) ?>
                                    </a>
                                    <?php if (!empty($item['brand_name'])): ?>
                                        <div class="text-muted small mt-1">
                                            <i class="fas fa-tag"></i> <?= htmlspecialchars($item['brand_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right"><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                <td class="text-center"><?= $item['quantity'] ?></td>
                                <td class="text-right font-weight-bold text-primary">
                                    <?= number_format($itemTotal, 0, ',', '.') ?>₫
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        
                        <!-- Dòng tổng cộng -->
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold">Tạm tính:</td>
                            <td class="text-right font-weight-bold"><?= number_format($subTotal, 0, ',', '.') ?>₫</td>
                        </tr>
                        
                        <?php if (!empty($orderInfo['discount'])): ?>
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold text-danger">Giảm giá:</td>
                            <td class="text-right font-weight-bold text-danger">
                                -<?= number_format($orderInfo['discount'], 0, ',', '.') ?>₫
                            </td>
                        </tr>
                        <?php endif; ?>
                        
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold">Phí vận chuyển:</td>
                            <td class="text-right font-weight-bold">
                                <?= number_format($orderInfo['shipping_fee'] ?? 0, 0, ',', '.') ?>₫
                            </td>
                        </tr>
                        
                        <tr class="bg-light">
                            <td colspan="5" class="text-right font-weight-bold h5">Tổng cộng:</td>
                            <td class="text-right font-weight-bold h5 text-danger">
                                <?= number_format($orderInfo['total'], 0, ',', '.') ?>₫
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                                <p>Không có sản phẩm nào trong đơn hàng</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
// Thêm các hàm hỗ trợ hiển thị trạng thái
function getStatusText($status) {
    $statusMap = [
        'pending' => 'Chờ xử lý',
        'Cho xở lý' => 'Chờ xử lý',
        'toán' => 'Đã thanh toán',
        'Dã thanh toán' => 'Đã thanh toán',
        'Dã gửi hàng' => 'Đang giao hàng',
        'Dã giao' => 'Đã giao hàng',
        'Dã huỷ' => 'Đã hủy'
    ];
    return $statusMap[$status] ?? $status;
}

function getStatusBadgeClass($status) {
    $classMap = [
        'pending' => 'badge-warning',
        'Cho xở lý' => 'badge-warning',
        'toán' => 'badge-info',
        'Dã thanh toán' => 'badge-info',
        'Dã gửi hàng' => 'badge-primary',
        'Dã giao' => 'badge-success',
        'Dã huỷ' => 'badge-danger'
    ];
    return $classMap[$status] ?? 'badge-secondary';
}
?>


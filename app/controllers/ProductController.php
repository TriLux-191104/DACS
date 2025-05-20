<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/BrandModel.php');
require_once('app/models/AccountModel.php');
require_once('app/models/VoucherModel.php');
require_once('app/models/TransactionModel.php');

class ProductController
{
    private $productModel;
    private $brandModel;
    private $accountModel;
    private $categoryModel;
    private $voucherModel;
    private $transactionModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->brandModel = new BrandModel($this->db);
        $this->accountModel = new AccountModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
        $this->voucherModel = new VoucherModel($this->db);
        $this->transactionModel = new TransactionModel($this->db);
    }

    public function index()
    {
        $brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;
        
        if ($brand_id) {
            $products = $this->productModel->getProductsByBrand($brand_id);
            $brand = $this->brandModel->getBrandById($brand_id);
            $brand_name = $brand ? $brand->brand_name : 'Không xác định';
        } else {
            $products = $this->productModel->getProducts();
            $brand_name = '';
        }

        require_once 'app/views/product/list.php';
    }

    public function home()
    {
        $category_id = 24;
        $products = $this->productModel->getProductsByCategory($category_id);
        $category = $this->categoryModel->getCategoryById($category_id);
        $category_name = $category ? $category->cartegory_name : 'Sản phẩm nổi bật';
        require_once 'app/views/product/home.php';
    }

    public function contact()
    {
        require_once 'app/views/product/contact.php';
    }

    public function tintuc()
    {
        require_once 'app/views/product/tintuc.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $desc_images = $this->productModel->get_product_images($id);
            $related_products = $this->productModel->getProductsByCategory($product->cartegory_id);
            $related_products = array_filter($related_products, function($p) use ($product) {
                return $p->product_id != $product->product_id;
            });
            $related_products = array_slice($related_products, 0, 4);
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    //Giỏ hàng
    public function addToCart($product_id)
    {
        $product = $this->productModel->getProductById($product_id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $action = isset($_POST['action']) ? $_POST['action'] : 'add_to_cart';

        $stock = isset($product->stock) ? $product->stock : 10;
        if ($quantity > $stock) {
            echo "Số lượng vượt quá tồn kho.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product->product_name,
                'price' => $product->product_price,
                'quantity' => $quantity,
                'image' => $product->product_img
            ];
        }

        error_log("Action received: " . $action);

        if ($action === 'buy_now') {
            header('Location: /webdr/Product/checkout');
        } else {
            header('Location: /webdr/Product/cart');
        }
    }

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
        }
        exit;
    }

    public function clearCart()
    {
        unset($_SESSION['cart']);
        echo json_encode(['success' => true]);
        exit;
    }

    public function updateCart($id, $quantity)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
        }
        exit;
    }
    

    //Tìm kiếm sản phẩm
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $products = $this->productModel->searchProducts($keyword);
        include 'app/views/product/search.php';
    }

    public function orderConfirmation()
    {
        if (!isset($_SESSION['order_success'])) {
            header('Location: /webdr/Product/home');
            exit;
        }

        unset($_SESSION['order_success']);

        $account_id = null;
        $order_id = null;
        if (isset($_SESSION['user']['email'])) {
            $account = $this->accountModel->getAccountByEmail($_SESSION['user']['email']);
            $account_id = $account ? $account->id : null;
            // Lấy order_id mới nhất
            $stmt = $this->db->prepare("SELECT id FROM orders WHERE id_account = :id_account ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([':id_account' => $account_id]);
            $order_id = $stmt->fetchColumn();
        }

        $data = ['account_id' => $account_id, 'order_id' => $order_id];
        include 'app/views/product/orderConfirmation.php';
    }

    
    //Vouchers
    public function applyVoucher()
    {
        header('Content-Type: application/json');
        
        $voucher_code = isset($_POST['voucher_code']) ? trim($_POST['voucher_code']) : '';
        if (empty($voucher_code)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá']);
            exit;
        }

        $voucher = $this->voucherModel->getVoucherByCode($voucher_code);
        if (!$voucher) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá không hợp lệ']);
            exit;
        }

        if ($voucher->status !== 'active' || strtotime($voucher->start_date) > time() || strtotime($voucher->end_date) < time()) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá đã hết hạn hoặc không hoạt động']);
            exit;
        }

        if ($voucher->used_count >= $voucher->usage_limit) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá đã được sử dụng hết']);
            exit;
        }

        $total = array_reduce($_SESSION['cart'], function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        if ($total < $voucher->min_order_amount) {
            echo json_encode(['success' => false, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' ₫']);
            exit;
        }

        $user_id = null;
        if (isset($_SESSION['user']['email'])) {
            $account = $this->accountModel->getAccountByEmail($_SESSION['user']['email']);
            $user_id = $account ? $account->id : null;
        }

        if ($user_id) {
            $user_voucher = $this->voucherModel->checkUserVoucher($voucher->id, $user_id);
            if (!$user_voucher) {
                echo json_encode(['success' => false, 'message' => 'Bạn không có quyền sử dụng mã giảm giá này']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để sử dụng mã giảm giá']);
            exit;
        }

        $discount = $voucher->discount_type === 'percentage' 
            ? ($total * $voucher->discount_value / 100) 
            : $voucher->discount_value;

        $_SESSION['voucher_applied'] = [
            'code' => $voucher->code,
            'discount' => $discount,
            'type' => $voucher->discount_type
        ];

        echo json_encode(['success' => true, 'message' => 'Áp dụng mã giảm giá thành công']);
        exit;
    }

    public function clearVoucher()
    {
        unset($_SESSION['voucher_applied']);
        header('Location: /webdr/Product/checkout');
        exit;
    }


    //Thanh toán
    public function checkout()
{
    if (empty($_SESSION['cart'])) {
        $_SESSION['error'] = 'Giỏ hàng của bạn đang trống!';
        header('Location: /webdr/Product/cart');
        exit;
    }

    $vouchers = [];
    if (isset($_SESSION['user']['email'])) {
        $account = $this->accountModel->getAccountByEmail($_SESSION['user']['email']);
        if ($account) {
            $vouchers = $this->voucherModel->getAccountVouchers($account->id);
        }
    }
    $appliedVoucher = $_SESSION['voucher_applied'] ?? null;

    // Tạo CSRF token để bảo vệ form
    $csrf_token = $this->generateCsrfToken();
    $data = ['csrf_token' => $csrf_token, 'vouchers' => $vouchers, 'appliedVoucher' => $appliedVoucher];

    include 'app/views/product/checkout.php';
}
    


    
public function processCheckout()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $_SESSION['error'] = 'Giỏ hàng của bạn đang trống!';
        header('Location: /webdr/Product/cart');
        exit;
    }

    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $payment_method = htmlspecialchars(trim($_POST['payment_method'] ?? 'COD'));

    if (empty($name) || empty($phone) || empty($address)) {
        $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin giao hàng';
        $_SESSION['form_data'] = $_POST;
        header('Location: /webdr/Product/checkout');
        exit;
    }

    $total = array_reduce($_SESSION['cart'], function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    $discount = 0;
    $voucherCode = null;
    if (isset($_SESSION['voucher_applied'])) {
        $discount = $_SESSION['voucher_applied']['discount'];
        $voucherCode = $_SESSION['voucher_applied']['code'];
        if (isset($_SESSION['user']['email'])) {
            $account = $this->accountModel->getAccountByEmail($_SESSION['user']['email']);
            $this->voucherModel->markVoucherUsed($account->id, $voucherCode, true);
        }
    }

    $finalTotal = $total - $discount;

    $id_account = null;
    if (isset($_SESSION['user']['email'])) {
        $account = $this->accountModel->getAccountByEmail($_SESSION['user']['email']);
        $id_account = $account ? $account->id : null;
    }

    $this->db->beginTransaction();
    try {
        // Thêm đơn hàng
        // Thay đổi ở đây: Trạng thái ban đầu cho MoMo là "Chờ chuyển khoản"
        $defaultStatus = ($payment_method === 'MOMO_QR') ? 'Chờ chuyển khoản' : 'Chờ xử lý'; 
        $stmt = $this->db->prepare("INSERT INTO orders 
                                  (id_account, name, phone, address, total, discount, voucher_code, status, payment_method, created_at) 
                                  VALUES (:id_account, :name, :phone, :address, :total, :discount, :voucher_code, :status, :payment_method, NOW())");
        $stmt->execute([
            ':id_account' => $id_account,
            ':name' => $name,
            ':phone' => $phone,
            ':address' => $address,
            ':total' => $finalTotal,
            ':discount' => $discount,
            ':voucher_code' => $voucherCode,
            ':status' => $defaultStatus,
            ':payment_method' => $payment_method
        ]);

        $order_id = $this->db->lastInsertId();

        // Thêm chi tiết đơn hàng và cập nhật kho
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $stockCheck = $this->db->prepare("SELECT stock FROM tbl_product WHERE product_id = ? FOR UPDATE");
            $stockCheck->execute([$product_id]);
            $stock = $stockCheck->fetchColumn();

            if ($stock < $item['quantity']) {
                throw new Exception("Sản phẩm {$item['name']} chỉ còn {$stock} sản phẩm trong kho");
            }

            $stmtDetail = $this->db->prepare("INSERT INTO order_details 
                                            (order_id, product_id, quantity, price) 
                                            VALUES (?, ?, ?, ?)");
            $stmtDetail->execute([$order_id, $product_id, $item['quantity'], $item['price']]);

            $stmtUpdate = $this->db->prepare("UPDATE tbl_product 
                                            SET sold = sold + ?, stock = stock - ? 
                                            WHERE product_id = ?");
            $stmtUpdate->execute([$item['quantity'], $item['quantity'], $product_id]);
        }

        // Nếu thanh toán bằng MoMo QR, lưu thông tin đơn hàng vào session
        if ($payment_method === 'MOMO_QR') {
            $_SESSION['momo_order'] = [
                'order_id' => $order_id,
                'total' => $finalTotal
            ];
            
            $this->db->commit();
            header('Location: /webdr/Product/showQrPayment');
            exit;
        }

        $this->db->commit();
        unset($_SESSION['cart']);
        $_SESSION['order_success'] = true;
        header('Location: /webdr/Product/orderConfirmation');
        exit;
    } catch (Exception $e) {
        $this->db->rollBack();
        $_SESSION['error'] = 'Lỗi khi xử lý đơn hàng: '. $e->getMessage();
        header('Location: /webdr/Product/checkout');
        exit;
    }
}

public function showQrPayment() {
    if (!isset($_SESSION['momo_order'])) {
        $_SESSION['error'] = 'Không tìm thấy thông tin đơn hàng';
        header('Location: /webdr/Product/checkout');
        exit;
    }

    $order_id = $_SESSION['momo_order']['id'];
    $stmt = $this->db->prepare("SELECT m.order_id, m.total FROM momo_payments m JOIN orders o ON m.order_id = o.id WHERE m.order_id = ? AND m.status = 'PENDING' AND (o.status = 'Chờ xử lý' OR o.status = 'Chờ xác nhận')");
    $stmt->execute([$order_id]);
    $payment = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$payment) {
        $_SESSION['error'] = 'Đơn hàng không tồn tại hoặc đã được xử lý';
        header('Location: /webdr/Product/checkout');
        exit;
    }

    $data = [
        'order_id' => $payment->order_id,
        'total' => $payment->total,
        'csrf_token' => $this->generateCsrfToken()
    ];
    include 'app/views/product/qr_payment.php';
}

public function confirmPayment() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['confirm_payment']) || !isset($_POST['order_id'])) {
        $_SESSION['error'] = 'Yêu cầu không hợp lệ';
        header('Location: /webdr/Product/checkout');
        exit;
    }

    if (!$this->verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['error'] = 'Lỗi bảo mật: Token không hợp lệ';
        header('Location: /webdr/Product/showQrPayment');
        exit;
    }

    $order_id = (int)$_POST['order_id'];
    if (!isset($_SESSION['momo_order']) || $_SESSION['momo_order']['id'] != $order_id) {
        $_SESSION['error'] = 'Thông tin đơn hàng không hợp lệ';
        header('Location: /webdr/Product/checkout');
        exit;
    }

    $this->db->beginTransaction();
    try {
        // Khóa bản ghi đơn hàng
        $stmt = $this->db->prepare("SELECT total, status FROM orders WHERE id = ? AND (status = 'Chờ xử lý' OR status = 'Chờ xác nhận') FOR UPDATE");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$order) {
            throw new Exception('Đơn hàng không tồn tại hoặc đã được xử lý');
        }

        // Cập nhật trạng thái đơn hàng
        $stmt = $this->db->prepare("UPDATE orders SET status = 'Đã thanh toán' WHERE id = ?");
        $stmt->execute([$order_id]);

        // Cập nhật trạng thái thanh toán MoMo
        $stmt = $this->db->prepare("UPDATE momo_payments SET status = 'PAID', updated_at = NOW() WHERE order_id = ?");
        $stmt->execute([$order_id]);

        // Lưu giao dịch
        $transactionData = [
            'order_id' => $order_id,
            'vnp_transaction_id' => 'MOMO_' . time(), // Tạo ID tạm thời
            'amount' => $order->total,
            'status' => 'PAID',
            'vnp_response_code' => '00',
            'vnp_transaction_date' => date('Y-m-d H:i:s')
        ];
        $this->transactionModel->saveTransaction($transactionData);

        $this->db->commit();
        unset($_SESSION['momo_order']);
        unset($_SESSION['cart']);
        $_SESSION['order_success'] = true;
        header('Location: /webdr/Product/orderConfirmation');
        exit;
    } catch (Exception $e) {
        $this->db->rollBack();
        $_SESSION['error'] = 'Lỗi khi xác nhận thanh toán: ' . $e->getMessage();
        header('Location: /webdr/Product/showQrPayment');
        exit;
    }
}

private function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

private function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
}
?>
<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/config/mailer.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function log() {
        if (isset($_SESSION['user'])) {
            header("Location: /webdr/account/info");
            exit();
        }
        include_once 'app/views/account/log.php';
    }

    public function reset() {

        include_once 'app/views/account/reset.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        header('Location: /webdr/product/home');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByEmail($email);

            if ($account && password_verify($password, $account->password)) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'email' => $account->email,
                    'fullname' => $account->fullname,
                    'role' => $account->role
                ];
                header('Location: /webdr/account/info');
                exit;
            } else {
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
                include_once 'app/views/account/log.php';
                exit;
            }
        }
    }

    public function save() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $fullName = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmpassword'] ?? '';

        $errors = [];
        // Validate input (giữ nguyên)

        if (count($errors) > 0) {
            include_once 'app/views/account/register.php';
            return;
        }

        $otp = sprintf("%06d", mt_rand(100000, 999999));
        $otp_expires = date('Y-m-d H:i:s', strtotime('+5 minutes')); // Hợp lệ 5 phút

        if ($this->accountModel->saveTempRegister($email, $fullName, $phone, $password, $otp)) {
            $mail = getMailer();
            if ($mail) {
                try {
                    $mail->addAddress($email, $fullName);
                    $mail->isHTML(true);
                    $mail->Subject = 'Xác minh OTP đăng ký tài khoản';
                    $mail->Body = "
                        <h2>Xác minh tài khoản Droppy Shop</h2>
                        <p>Mã OTP của bạn là: <strong>$otp</strong></p>
                        <p>Vui lòng nhập mã này để hoàn tất đăng ký. Mã có hiệu lực trong 5 phút.</p>
                    ";
                    $mail->send();

                    $_SESSION['register_temp'] = [
                        'email' => $email,
                        'fullname' => $fullName,
                        'phone' => $phone,
                        'password' => $password,
                        'otp' => $otp,
                        'otp_expires' => strtotime($otp_expires)
                    ];
                    header('Location: /webdr/account/verify_otp');
                    exit;
                } catch (Exception $e) {
                    $errors['mail'] = "Không thể gửi email OTP: {$mail->ErrorInfo}";
                    include_once 'app/views/account/log.php';
                    return;
                }
            } else {
                $errors['mail'] = "Lỗi cấu hình email. Vui lòng thử lại!";
                include_once 'app/views/account/log.php';
                return;
            }
        } else {
            $errors['register'] = "Đã có lỗi xảy ra khi đăng ký. Vui lòng thử lại!";
            include_once 'app/views/account/log.php';
            return;
        }
    }
}

    public function verify_otp() {
        if (!isset($_SESSION['register_temp']['email'])) {
            header('Location: /webdr/account/register');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'resend_otp') {
                // Handle resend OTP
                $email = $_SESSION['register_temp']['email'];
                $otp = sprintf("%06d", mt_rand(0, 999999));
                $otp_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                if ($this->accountModel->updateOTP($email, $otp, $otp_expires)) {
                    // Send new OTP email
                    $mail = getMailer();
                    if ($mail) {
                        try {
                            $tempUser = $this->accountModel->getTempUser($email);
                            $mail->addAddress($email, $tempUser->user_name);
                            $mail->Subject = 'Mã OTP Mới Xác Nhận Đăng Ký';
                            $mail->Body = "Mã OTP mới của bạn là: <strong>$otp</strong>. Mã này có hiệu lực trong 10 phút.";
                            $mail->AltBody = "Mã OTP mới của bạn là: $otp. Mã này có hiệu lực trong 10 phút.";
                            $mail->send();
                            $_SESSION['register_temp']['otp_expires'] = strtotime($otp_expires);
                            $_SESSION['success'] = "Mã OTP mới đã được gửi đến email của bạn!";
                        } catch (Exception $e) {
                            $_SESSION['error'] = "Không thể gửi email OTP: {$mail->ErrorInfo}";
                        }
                    } else {
                        $_SESSION['error'] = "Lỗi cấu hình email!";
                    }
                } else {
                    $_SESSION['error'] = "Đã có lỗi khi cập nhật OTP!";
                }
                include_once 'app/views/account/verify_otp.php';
                return;
            }

            // Handle OTP verification
            $otp = $_POST['otp'] ?? '';
            $email = $_SESSION['register_temp']['email'] ?? '';

            if (time() > ($_SESSION['register_temp']['otp_expires'] ?? 0)) {
                $error = "Mã OTP đã hết hạn! Vui lòng yêu cầu gửi lại mã.";
                include_once 'app/views/account/verify_otp.php';
                return;
            }

            if (empty($otp) || !preg_match('/^\d{6}$/', $otp)) {
                $error = "Mã OTP không hợp lệ!";
                include_once 'app/views/account/verify_otp.php';
                return;
            }

            $user = $this->accountModel->verifyOTP($email, $otp);
            if ($user) {
                if ($this->accountModel->activateAccount($email)) {
                    if ($this->accountModel->moveToAccount($email)) {
                        unset($_SESSION['register_temp']);
                        $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                        header('Location: /webdr/account/log');
                        exit;
                    } else {
                        $error = "Tên đầy đủ đã được sử dụng. Vui lòng quay lại và chọn tên khác!";
                        include_once 'app/views/account/verify_otp.php';
                        return;
                    }
                } else {
                    $error = "Đã có lỗi khi kích hoạt tài khoản!";
                    include_once 'app/views/account/verify_otp.php';
                    return;
                }
            } else {
                $error = "Mã OTP không đúng!";
                include_once 'app/views/account/verify_otp.php';
                return;
            }
        }
        include_once 'app/views/account/verify_otp.php';
    }

    public function info() {
        if (!isset($_SESSION['user'])) {
            header('Location: /webdr/account/log');
            exit;
        }

        $user = $_SESSION['user'];
        $account = $this->accountModel->getAccountByEmail($user['email']);
        
        if (!$account) {
            $_SESSION['error'] = 'Tài khoản không tồn tại';
            header('Location: /webdr/account/log');
            exit;
        }

        $statusMapping = [
            'Đã thanh toán' => 'Đã thanh toán',
            'Chờ xử lý' => 'Chờ xử lý',
            'Đã gửi hàng' => 'Đã gửi hàng',
            'Đã giao' => 'Đã giao',
            'Đã huỷ' => 'Đã huỷ',
            'NULL' => 'Không xác định'
        ];

        $query = "SELECT o.* FROM orders o WHERE o.id_account = :account_id ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $account->id, PDO::PARAM_INT);
        $stmt->execute();
        
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($orders as &$order) {
            $rawStatus = trim($order['status'] ?? '');
            $order['status_display'] = $statusMapping[$rawStatus] ?? 'Không xác định';
            
            $detailQuery = "SELECT p.product_name, p.product_img, od.quantity, od.price 
                           FROM order_details od
                           JOIN tbl_product p ON od.product_id = p.product_id
                           WHERE od.order_id = :order_id";
            $detailStmt = $this->db->prepare($detailQuery);
            $detailStmt->bindParam(':order_id', $order['id'], PDO::PARAM_INT);
            $detailStmt->execute();
            $order['details'] = $detailStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        unset($order);

        $data = [
            'user' => [
                'fullname' => $account->fullname,
                'email' => $account->email,
                'phone' => $account->phone
            ],
            'orders' => $orders
        ];

        include_once 'app/views/account/info.php';
    }

    public function cancelOrder($order_id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /webdr/account/log');
            exit;
        }

        $user = $_SESSION['user'];
        $account = $this->accountModel->getAccountByEmail($user['email']);
        $id_account = $account ? $account->id : null;

        if (!$id_account) {
            header('Location: /webdr/account/info');
            exit;
        }

        $query = "SELECT * FROM orders WHERE id = :order_id AND id_account = :id_account AND status IN ('Chờ xử lý', 'Đã gửi hàng')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_account', $id_account, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $query = "UPDATE orders SET status = 'Đã huỷ' WHERE id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        header('Location: /webdr/account/info');
        exit;
    }

    

    public function orderDetails($order_id) {
        $order = $this->accountModel->getOrderById($order_id);
        $order_details = $this->accountModel->getOrderDetails($order_id);

        if (!$order) {
            echo "Đơn hàng không tồn tại.";
            return;
        }

        include 'app/views/account/chitietdonhang.php';
    }


    public function forgot() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
                include_once 'app/views/account/forgot.php';
                return;
            }

            $user = $this->accountModel->getAccountByEmail($email);
            if (!$user) {
                $error = "Email không tồn tại trong hệ thống!";
                include_once 'app/views/account/forgot.php';
                return;
            }

            $otp = sprintf("%06d", mt_rand(100000, 999999));
            $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $token = md5(uniqid());

            if ($this->accountModel->savePasswordReset($email, $token, $otp, $expires_at)) {
                $mail = getMailer();
                if ($mail) {
                    try {
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Yêu cầu đặt lại mật khẩu';
                        $mail->Body = "
                            <h2>Đặt lại mật khẩu Droppy Shop</h2>
                            <p>Mã OTP của bạn là: <strong>$otp</strong></p>
                            <p>Vui lòng nhập mã này để đặt lại mật khẩu. Mã có hiệu lực trong 5 phút.</p>
                        ";
                        $mail->send();

                        $_SESSION['reset_email'] = $email;
                        $success = "OTP đã được gửi đến email của bạn!";
                        include_once 'app/views/account/verify_otp_reset.php';
                        return;
                    } catch (Exception $e) {
                        $error = "Không thể gửi email OTP: {$mail->ErrorInfo}";
                        include_once 'app/views/account/forgot.php';
                        return;
                    }
                } else {
                    $error = "Lỗi cấu hình email. Vui lòng thử lại!";
                    include_once 'app/views/account/forgot.php';
                    return;
                }
            } else {
                $error = "Đã có lỗi xảy ra. Vui lòng thử lại!";
                include_once 'app/views/account/forgot.php';
                return;
            }
        } else {
            include_once 'app/views/account/forgot.php';
        }
    }

    public function verify_otp_reset() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $otp = $_POST['otp'] ?? '';
            $otp = preg_replace('/[^0-9]/', '', $otp);

            if (empty($email) || empty($otp)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
                include_once 'app/views/account/verify_otp_reset.php';
                return;
            }

            $reset = $this->accountModel->verifyPasswordResetOTP($email, $otp);
            if ($reset && strtotime($reset->expires_at) > time()) {
                $_SESSION['verified_email'] = $email;
                header('Location: /webdr/account/reset');
                exit;
            } else {
                $error = "Mã OTP không đúng hoặc đã hết hạn!";
                include_once 'app/views/account/verify_otp_reset.php';
                return;
            }
        } else {
            if (empty($_SESSION['reset_email'])) {
                header('Location: /webdr/account/forgot');
                exit;
            }
            include_once 'app/views/account/verify_otp_reset.php';
        }
    }

    public function processreset() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($_SESSION['verified_email']) || $_SESSION['verified_email'] !== $email) {
                $_SESSION['password_error'] = "Phiên xác minh không hợp lệ!";
                header('Location: /webdr/account/forgot');
                exit;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['password_error'] = "Mật khẩu xác nhận không khớp!";
                header('Location: /webdr/account/reset');
                exit;
            }

            if (strlen($new_password) < 6) {
                $_SESSION['password_error'] = "Mật khẩu phải có ít nhất 6 ký tự!";
                header('Location: /webdr/account/reset');
                exit;
            }

            $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
            if ($this->accountModel->updatePassword($email, $hashedPassword)) {
                $this->accountModel->deletePasswordReset($email);
                unset($_SESSION['verified_email']);
                unset($_SESSION['reset_email']);
                $_SESSION['success'] = "Đặt lại mật khẩu thành công! Vui lòng đăng nhập.";
                header('Location: /webdr/account/log');
                exit;
            } else {
                $_SESSION['password_error'] = "Đã có lỗi khi cập nhật mật khẩu!";
                header('Location: /webdr/account/reset');
                exit;
            }
        } else {
            if (empty($_SESSION['verified_email'])) {
                header('Location: /webdr/account/forgot');
                exit;
            }
            include_once 'app/views/account/reset.php';
        }
    }

    

    
}
?>
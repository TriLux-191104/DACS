<?php
class AccountModel {
    private $conn;
    private $table_name = "account";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveTempRegister($email, $fullName, $phone, $password, $otp) {
        $query = "INSERT INTO register_user 
                  (user_name, user_email, phone, user_password, user_activation_code, user_email_status, user_otp, user_avatar, otp, otp_expires) 
                  VALUES (:user_name, :user_email, :phone, :user_password, :user_activation_code, 'not verified', :user_otp, '', :otp, :otp_expires)";
        $stmt = $this->conn->prepare($query);

        $fullName = htmlspecialchars(strip_tags($fullName));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $activation_code = md5(uniqid());
        $otp = htmlspecialchars(strip_tags($otp));
        $otp_expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $stmt->bindParam(":user_name", $fullName);
        $stmt->bindParam(":user_email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":user_password", $password);
        $stmt->bindParam(":user_activation_code", $activation_code);
        $stmt->bindParam(":user_otp", $otp);
        $stmt->bindParam(":otp", $otp);
        $stmt->bindParam(":otp_expires", $otp_expires);

        return $stmt->execute();
    }

    public function verifyOTP($email, $otp) {
        $query = "SELECT * FROM register_user 
                  WHERE user_email = :email 
                  AND otp = :otp 
                  AND user_email_status = 'not verified' 
                  AND otp_expires > NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function activateAccount($email) {
        $query = "UPDATE register_user SET user_email_status = 'verified' WHERE user_email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function moveToAccount($email) {
        $tempUser = $this->getTempUser($email);
        if (!$tempUser) return false;

        $query = "INSERT INTO account (email, fullname, phone, password, role) 
                  VALUES (:email, :fullname, :phone, :password, 'user')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $tempUser->user_email);
        $stmt->bindParam(":fullname", $tempUser->user_name);
        $stmt->bindParam(":phone", $tempUser->phone);
        $stmt->bindParam(":password", $tempUser->user_password);
        $success = $stmt->execute();

        if ($success) {
            $query = "DELETE FROM register_user WHERE user_email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
        }
        return $success;
    }

    public function updateOTP($email, $otp, $otp_expires) {
        $query = "UPDATE register_user SET otp = :otp, otp_expires = :otp_expires 
                  WHERE user_email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":otp", $otp);
        $stmt->bindParam(":otp_expires", $otp_expires);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function getTempUser($email) {
        $query = "SELECT * FROM register_user WHERE user_email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    


    

    public function getOrderDetails($orderId) {
        $query = "SELECT p.product_name, p.product_img, od.quantity, od.price 
                  FROM order_details od
                  JOIN tbl_product p ON od.product_id = p.product_id
                  WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId) {
        $query = "SELECT * FROM orders WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }






  

    /**
     * Lấy danh sách voucher của tài khoản
     * @param int $account_id - ID tài khoản
     * @return array - Danh sách voucher
     */
    public function getAccountVouchers($account_id)
    {
        $query = "SELECT v.code AS voucher_code, v.discount_type, v.discount_value, v.min_order_amount, 
                         v.start_date, v.end_date, uv.is_used
                  FROM user_vouchers uv
                  JOIN vouchers v ON uv.voucher_id = v.id
                  WHERE uv.user_id = :account_id AND v.status = 'active'
                  AND v.start_date <= NOW() AND v.end_date >= NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account_id', $account_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Đánh dấu voucher đã sử dụng
     * @param int $account_id - ID tài khoản
     * @param string $voucher_code - Mã voucher
     * @return bool - Thành công hay không
     */
    public function markVoucherUsed($account_id, $voucher_code)
    {
        $voucherModel = new VoucherModel($this->conn);
        return $voucherModel->markVoucherUsed($account_id, $voucher_code);
    }































    
  //PasswordPassword
    public function savePasswordReset($email, $token, $otp, $expires_at) {
        $query = "INSERT INTO password_resets (email, token, otp_code, expires_at) 
                  VALUES (:email, :token, :otp, :expires_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":otp", $otp);
        $stmt->bindParam(":expires_at", $expires_at);
        return $stmt->execute();
    }

    public function verifyPasswordResetOTP($email, $otp) {
        $query = "SELECT * FROM password_resets 
                  WHERE email = :email AND otp_code = :otp 
                  ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function deletePasswordReset($email) {
        $query = "DELETE FROM password_resets WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function getAccountByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updatePassword($email, $hashedPassword) {
        $query = "UPDATE account SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }




}
?>
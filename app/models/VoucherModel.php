<?php
class VoucherModel
{
    private $conn;
    private $table_name = "vouchers";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy thông tin voucher theo mã
     * @param string $code - Mã voucher
     * @return object|null - Thông tin voucher hoặc null nếu không tìm thấy
     */
    public function getVoucherByCode($code)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE code = :code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Kiểm tra xem người dùng có quyền sử dụng voucher không
     * @param int $voucher_id - ID voucher
     * @param int $user_id - ID người dùng
     * @return object|null - Thông tin user_voucher hoặc null nếu không hợp lệ
     */
    public function checkUserVoucher($voucher_id, $user_id)
    {
        $query = "SELECT * FROM user_vouchers WHERE voucher_id = :voucher_id AND user_id = :user_id AND is_used = 0 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':voucher_id', $voucher_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountVouchers($account_id)
    {
        $query = "
            SELECT v.*, uv.is_used 
            FROM vouchers v 
            INNER JOIN user_vouchers uv ON v.id = uv.voucher_id 
            WHERE uv.user_id = :user_id AND v.status = 'active' AND v.end_date > NOW()
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $account_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function markVoucherUsed($user_id, $voucher_code, $useTransaction = true)
    {
        // Chỉ mở giao dịch nếu được yêu cầu và không có giao dịch đang hoạt động
        if ($useTransaction && !$this->conn->inTransaction()) {
            $this->conn->beginTransaction();
        }

        try {
            // Lấy voucher_id
            $voucher = $this->getVoucherByCode($voucher_code);
            if (!$voucher) {
                throw new Exception("Voucher không tồn tại");
            }

            // Cập nhật user_vouchers
            $query = "UPDATE user_vouchers SET is_used = 1, used_at = NOW() 
                      WHERE voucher_id = :voucher_id AND user_id = :user_id AND is_used = 0";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':voucher_id', $voucher->id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Tăng used_count trong vouchers
            $query = "UPDATE " . $this->table_name . " SET used_count = used_count + 1 WHERE id = :voucher_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':voucher_id', $voucher->id, PDO::PARAM_INT);
            $stmt->execute();

            // Chỉ commit nếu mở giao dịch ở đây
            if ($useTransaction && $this->conn->inTransaction()) {
                $this->conn->commit();
            }
            return true;
        } catch (Exception $e) {
            // Chỉ rollback nếu mở giao dịch ở đây
            if ($useTransaction && $this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            // Ném lại ngoại lệ để gọi hàm xử lý
            throw $e;
        }
    }
    
}
?>
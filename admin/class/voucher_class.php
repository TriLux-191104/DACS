<?php
include_once "dtb.php";

class Voucher {
    public $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createVoucher($data, $adminId) {
        $query = "INSERT INTO vouchers (code, discount_type, discount_value, min_order_amount, start_date, end_date, usage_limit, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['code'],
            $data['discount_type'],
            $data['discount_value'],
            $data['min_order_amount'],
            $data['start_date'],
            $data['end_date'],
            $data['usage_limit'],
            $data['description']
        ];

        $result = $this->db->insert($query, $params);
        if ($result) {
            $this->logAction($result, $adminId, 'create', "Created voucher: {$data['code']}");
        }
        return $result;
    }

    public function updateVoucher($id, $data, $adminId) {
        $query = "UPDATE vouchers SET 
                  code = ?, discount_type = ?, discount_value = ?, 
                  min_order_amount = ?, start_date = ?, end_date = ?, 
                  usage_limit = ?, status = ?, description = ?
                  WHERE id = ?";
        $params = [
            $data['code'],
            $data['discount_type'],
            $data['discount_value'],
            $data['min_order_amount'],
            $data['start_date'],
            $data['end_date'],
            $data['usage_limit'],
            $data['status'],
            $data['description'],
            $id
        ];

        $result = $this->db->update($query, $params);
        if ($result !== false) {
            $this->logAction($id, $adminId, 'update', "Updated voucher: {$data['code']}");
        }
        return $result;
    }

    public function deleteVoucher($id, $adminId) {
        $voucher = $this->getVoucherById($id);
        if (!$voucher) {
            return false;
        }
        // Ghi nhật ký trước khi xóa
        $this->logAction($id, $adminId, 'delete', "Deleted voucher: {$voucher['code']}");
        // Xóa voucher
        $query = "DELETE FROM vouchers WHERE id = ?";
        return $this->db->delete($query, [$id]);
    }

    public function getAllVouchers() {
        $query = "SELECT * FROM vouchers ORDER BY created_at DESC";
        return $this->db->select($query);
    }

    public function getVoucherById($id) {
        $query = "SELECT * FROM vouchers WHERE id = ?";
        $result = $this->db->select($query, [$id]);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getFilteredVouchers($search = '', $status = '', $sort = 'date_desc') {
        $query = "SELECT * FROM vouchers WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND (code LIKE ? OR description LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
        }

        if (!empty($status)) {
            $query .= " AND status = ?";
            $params[] = $status;
        }

        switch ($sort) {
            case 'code_asc':
                $query .= " ORDER BY code ASC";
                break;
            case 'code_desc':
                $query .= " ORDER BY code DESC";
                break;
            case 'date_asc':
                $query .= " ORDER BY created_at ASC";
                break;
            default: // date_desc
                $query .= " ORDER BY created_at DESC";
                break;
        }

        return $this->db->select($query, $params);
    }

    public function sendVoucherToUser($voucherId, $userId, $adminId) {
        $query = "INSERT INTO user_vouchers (voucher_id, user_id) VALUES (?, ?)";
        $result = $this->db->insert($query, [$voucherId, $userId]);
        if ($result) {
            $voucher = $this->getVoucherById($voucherId);
            $this->logAction($voucherId, $adminId, 'send', "Sent voucher {$voucher['code']} to user ID: $userId");
        }
        return $result;
    }

    public function sendVoucherToAllUsers($voucherId, $adminId) {
        $query = "SELECT id FROM account WHERE role = 'user'";
        $users = $this->db->select($query);
        $successCount = 0;
        if ($users) {
            while ($user = $users->fetch_assoc()) {
                $check = $this->db->select("SELECT id FROM user_vouchers WHERE voucher_id = ? AND user_id = ?", [$voucherId, $user['id']]);
                if (!$check || $check->num_rows == 0) {
                    if ($this->sendVoucherToUser($voucherId, $user['id'], $adminId)) {
                        $successCount++;
                    }
                }
            }
        }
        return $successCount;
    }

    private function logAction($voucherId, $adminId, $action, $details) {
        $query = "INSERT INTO voucher_logs (voucher_id, admin_id, action, details) VALUES (?, ?, ?, ?)";
        $this->db->insert($query, [$voucherId, $adminId, $action, $details]);
    }
}
?>
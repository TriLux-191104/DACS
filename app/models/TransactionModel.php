<?php
class TransactionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function saveTransaction($data) {
    $stmt = $this->db->prepare("
        INSERT INTO transactions 
        (order_id, vnp_transaction_id, amount, status, vnp_response_code, vnp_transaction_date, created_at) 
        VALUES (:order_id, :vnp_transaction_id, :amount, :status, :vnp_response_code, :vnp_transaction_date, NOW())
    ");
    
    $stmt->execute([
        ':order_id' => $data['order_id'],
        ':vnp_transaction_id' => $data['vnp_transaction_id'],
        ':amount' => $data['amount'],
        ':status' => $data['status'],
        ':vnp_response_code' => $data['vnp_response_code'],
        ':vnp_transaction_date' => $data['vnp_transaction_date']
    ]);

    return $this->db->lastInsertId();
}

    public function getTransactionByOrderId($order_id) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateTransactionStatus($transaction_id, $status, $response_code) {
        $stmt = $this->db->prepare("
            UPDATE transactions 
            SET status = :status, vnp_response_code = :vnp_response_code 
            WHERE id = :id
        ");
        $stmt->execute([
            ':status' => $status,
            ':vnp_response_code' => $response_code,
            ':id' => $transaction_id
        ]);
        return $stmt->rowCount();
    }
}
?>
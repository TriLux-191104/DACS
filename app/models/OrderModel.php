<?php
class OrderModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function updateStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':id' => $order_id
        ]);
    }

    public function getOrderById($order_id) {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>


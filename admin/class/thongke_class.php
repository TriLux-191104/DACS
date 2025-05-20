<?php
include "dtb.php"; 
class ThongKe {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getOrderCount() {
        $query = "SELECT COUNT(*) AS total_orders FROM orders";
        return $this->db->select($query)->fetch_assoc();
    }

    public function getProductCount() {
        $query = "SELECT COUNT(*) AS total_products FROM tbl_product";
        return $this->db->select($query)->fetch_assoc();
    }

    public function getCustomerCount() {
        $query = "SELECT COUNT(*) AS total_customers FROM account WHERE role = 'user'";
        return $this->db->select($query)->fetch_assoc();
    }

    public function getRevenue() {
        $query = "SELECT SUM(total) AS total_revenue FROM orders WHERE status = 'Đã thanh toán'";
        return $this->db->select($query)->fetch_assoc();
    }

    public function getTopProducts($limit = 5) {
        $query = "SELECT p.product_name, SUM(od.quantity) AS total_sold 
                  FROM order_details od 
                  JOIN tbl_product p ON od.product_id = p.product_id 
                  GROUP BY od.product_id 
                  ORDER BY total_sold DESC 
                  LIMIT $limit";
        return $this->db->select($query);
    }
    // Thêm các phương thức sau vào class ThongKe
public function getTopCustomers($limit = 5) {
    $query = "SELECT a.fullname, a.email, COUNT(o.id) AS order_count, SUM(o.total) AS total_spent 
              FROM orders o 
              JOIN account a ON o.id_account = a.id 
              WHERE a.role = 'user'
              GROUP BY o.id_account 
              ORDER BY total_spent DESC 
              LIMIT $limit";
    return $this->db->select($query);
}

public function getTopValueOrders($limit = 5) {
    $query = "SELECT o.id, o.name AS customer_name, o.total, o.created_at, o.status 
              FROM orders o 
              ORDER BY o.total DESC 
              LIMIT $limit";
    return $this->db->select($query);
}

public function getRevenueByDate($date) {
    $query = "SELECT SUM(total) AS daily_revenue 
              FROM orders 
              WHERE DATE(created_at) = '$date' AND status = 'Đã thanh toán'";
    return $this->db->select($query)->fetch_assoc();
}

public function getRevenueByMonth($year, $month) {
    $query = "SELECT SUM(total) AS monthly_revenue 
              FROM orders 
              WHERE YEAR(created_at) = $year AND MONTH(created_at) = $month AND status = 'Đã thanh toán'";
    return $this->db->select($query)->fetch_assoc();
}

public function getRevenueByYear($year) {
    $query = "SELECT SUM(total) AS yearly_revenue 
              FROM orders 
              WHERE YEAR(created_at) = $year AND status = 'Đã thanh toán'";
    return $this->db->select($query)->fetch_assoc();
}

public function getRevenueByDateRange($start_date, $end_date) {
    $query = "SELECT SUM(total) AS range_revenue 
              FROM orders 
              WHERE created_at BETWEEN '$start_date' AND '$end_date' AND status = 'Đã thanh toán'";
    return $this->db->select($query)->fetch_assoc();
}
}
?>

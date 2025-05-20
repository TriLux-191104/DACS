<?php
include "dtb.php";

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // PHƯƠNG THỨC CŨ (GIỮ NGUYÊN)
    public function getAllOrders()
    {
        $query = "SELECT o.*, a.fullname 
              FROM orders o 
              LEFT JOIN account a ON o.id_account = a.id 
              ORDER BY o.created_at DESC";
        return $this->db->select($query);
    }

    // PHƯƠNG THỨC CŨ (GIỮ NGUYÊN)
    public function getOrderById($order_id)
    {
        $order_id = intval($order_id);
        $query = "SELECT * FROM orders WHERE id = '$order_id'";
        return $this->db->select($query);
    }

    // PHƯƠNG THỨC CŨ (GIỮ NGUYÊN)
    public function deleteOrder($order_id)
    {
        $order_id = intval($order_id);
        $query1 = "DELETE FROM order_details WHERE order_id = '$order_id'";
        $this->db->delete($query1);
        $query2 = "DELETE FROM orders WHERE id = '$order_id'";
        return $this->db->delete($query2);
    }

    // PHƯƠNG THỨC CŨ (GIỮ NGUYÊN)
    public function updateOrderStatus($order_id, $status)
    {
        $order_id = intval($order_id);
        $status = addslashes($status);
        $query = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
        return $this->db->update($query);
    }

    // PHƯƠNG THỨC CŨ (GIỮ NGUYÊN)
    public function getOrderDetails($order_id)
    {
        $order_id = intval($order_id);
        $orderQuery = "SELECT o.*, a.fullname, a.email, a.phone 
                      FROM orders o 
                      LEFT JOIN account a ON o.id_account = a.id 
                      WHERE o.id = '$order_id'";
        $order = $this->db->select($orderQuery);
        
        if (!$order) return null;
        
        $detailsQuery = "SELECT od.*, p.product_name, p.product_img, b.brand_name 
                        FROM order_details od
                        JOIN tbl_product p ON od.product_id = p.product_id
                        LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id
                        WHERE od.order_id = '$order_id'";
        $details = $this->db->select($detailsQuery);
        
        return [
            'order' => mysqli_fetch_assoc($order),
            'details' => $details
        ];
    }

    // PHƯƠNG THỨC MỚI THÊM (Lọc và sắp xếp)
    public function getFilteredOrders($search = '', $month = 0, $day = 0, $sort = 'date_desc')
    {
        $query = "SELECT o.*, a.fullname 
                  FROM orders o 
                  LEFT JOIN account a ON o.id_account = a.id 
                  WHERE 1=1";

        if (!empty($search)) {
            $search = addslashes($search);
            $query .= " AND (o.id LIKE '%$search%' 
                          OR o.name LIKE '%$search%' 
                          OR o.phone LIKE '%$search%' 
                          OR a.fullname LIKE '%$search%')";
        }

        if ($month > 0 && $month <= 12) {
            $query .= " AND MONTH(o.created_at) = $month";
        }

        if ($day > 0 && $day <= 31) {
            $query .= " AND DAY(o.created_at) = $day";
        }

        switch ($sort) {
            case 'price_asc':
                $query .= " ORDER BY o.total ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY o.total DESC";
                break;
            case 'date_asc':
                $query .= " ORDER BY o.created_at ASC";
                break;
            default: // date_desc
                $query .= " ORDER BY o.created_at DESC";
                break;
        }

        return $this->db->select($query);
    }
}
?>
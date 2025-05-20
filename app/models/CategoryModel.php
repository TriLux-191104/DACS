<?php
class CategoryModel
{
    private $conn; // Biến lưu trữ kết nối đến cơ sở dữ liệu
    private $table_name = "tbl_cartegory"; // Tên bảng trong cơ sở dữ liệu

    /**
     * Hàm khởi tạo, nhận đối tượng kết nối database
     * @param PDO $db - Đối tượng kết nối database
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách tất cả danh mục từ database
     * @return array - Trả về một mảng chứa các đối tượng danh mục
     */
    public function getCategories()
    {
        // Câu truy vấn SQL để lấy danh sách danh mục
        $query = "SELECT cartegory_id, cartegory_name FROM " . $this->table_name;
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($query);
        
        // Thực thi truy vấn
        $stmt->execute();
        
        // Lấy tất cả dữ liệu dưới dạng mảng các đối tượng
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        // Trả về kết quả
        return $result;
    }
    /**
 * Lấy thông tin danh mục theo ID
 * @param int $id - ID của danh mục
 * @return object - Trả về đối tượng danh mục
 *//**
 * Lấy thông tin danh mục theo ID
 * @param int $id - ID của danh mục
 * @return object - Trả về đối tượng danh mục
 */
public function getCategoryById($id) {
    $query = "SELECT * FROM tbl_cartegory WHERE cartegory_id = ? LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}


}
?>

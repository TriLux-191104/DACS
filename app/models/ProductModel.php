<?php
class ProductModel
{
    private $conn; // Biến lưu trữ kết nối đến cơ sở dữ liệu
    private $table_name = "tbl_product"; // Tên bảng trong cơ sở dữ liệu

    /**
     * Hàm khởi tạo, nhận đối tượng kết nối database
     * @param PDO $db - Đối tượng kết nối database
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách tất cả sản phẩm, bao gồm cả tên danh mục
     * @return array - Trả về một mảng chứa các đối tượng sản phẩm
     */
    public function getProducts()
    {
        // Câu truy vấn lấy danh sách sản phẩm cùng với tên danh mục
        $query = "SELECT p.product_id, p.product_name, p.product_desc, p.product_price, p.product_img, p.sold,
                         c.cartegory_name, b.brand_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN tbl_cartegory c ON p.cartegory_id = c.cartegory_id
                  LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Trả về danh sách sản phẩm dưới dạng mảng đối tượng
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Lấy thông tin chi tiết của một sản phẩm theo ID

     */
    public function getProductById($id)
{
    $query = "SELECT p.product_id, p.product_name, p.product_desc, p.product_price, p.product_img, p.sold, p.stock, p.cartegory_id,
                     c.cartegory_name, b.brand_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN tbl_cartegory c ON p.cartegory_id = c.cartegory_id
              LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id
              WHERE p.product_id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function getProductsByBrand($brand_id) {
        $query = "SELECT p.*, c.cartegory_name, b.brand_name 
                  FROM tbl_product p 
                  LEFT JOIN tbl_cartegory c ON p.cartegory_id = c.cartegory_id 
                  LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id 
                  WHERE p.brand_id = :brand_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /**
 * Lấy danh sách sản phẩm theo danh mục (category)
 * @param int $cartegory_id - ID của danh mục
 * @return array - Trả về mảng chứa các đối tượng sản phẩm thuộc danh mục
 */

    /**
 * Lấy danh sách sản phẩm theo danh mục (category)
 * @param int $cartegory_id - ID của danh mục
 * @return array - Trả về mảng chứa các đối tượng sản phẩm thuộc danh mục
 */
public function getProductsByCategory($cartegory_id) {
    $query = "SELECT p.*, c.cartegory_name, b.brand_name 
              FROM tbl_product p 
              LEFT JOIN tbl_cartegory c ON p.cartegory_id = c.cartegory_id 
              LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id 
              WHERE p.cartegory_id = :cartegory_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':cartegory_id', $cartegory_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
    
public function get_product_images($product_id) {
    $query = "SELECT product_img_desc FROM tbl_product_img_desc WHERE product_id = :product_id LIMIT 4";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
/**
 * Tìm kiếm sản phẩm theo từ khóa
 * @param string $keyword - Từ khóa tìm kiếm
 * @return array - Danh sách sản phẩm khớp với từ khóa
 */
public function searchProducts($keyword)
{
    $query = "SELECT p.product_id, p.product_name, p.product_desc, p.product_price, p.product_img, p.sold,
                     c.cartegory_name, b.brand_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN tbl_cartegory c ON p.cartegory_id = c.cartegory_id
              LEFT JOIN tbl_brand b ON p.brand_id = b.brand_id
              WHERE p.product_name LIKE :keyword OR p.product_desc LIKE :keyword";
    
    $stmt = $this->conn->prepare($query);
    $searchTerm = "%" . $keyword . "%"; // Thêm ký tự % để tìm kiếm gần đúng
    $stmt->bindParam(':keyword', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
}

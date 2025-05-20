<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');  // Kết nối tới cơ sở dữ liệu.
require_once('app/models/CategoryModel.php');  // Mô hình Category (dành cho việc truy xuất dữ liệu về danh mục).

class CategoryController
{
    private $categoryModel;  // Biến lưu đối tượng CategoryModel để tương tác với dữ liệu danh mục.
    private $db;  // Biến lưu kết nối đến cơ sở dữ liệu.

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu bằng Database và gán cho biến $db.
        $this->db = (new Database())->getConnection();
        
        // Khởi tạo đối tượng CategoryModel và truyền kết nối cơ sở dữ liệu vào.
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Phương thức hiển thị danh sách các danh mục.
    public function list()
    {
        // Lấy tất cả các danh mục từ cơ sở dữ liệu thông qua CategoryModel.
        $categories = $this->categoryModel->getCategories();

        // Gọi view list.php để hiển thị danh sách danh mục.
        include 'app/views/category/list.php';
        include 'app/views/category/header.php';
    }
}
?>

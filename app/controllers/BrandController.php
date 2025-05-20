<?php
require_once('app/config/database.php');         // Kết nối CSDL
require_once('app/models/BrandModel.php');       // Model của Brand
require_once('app/models/CategoryModel.php');    // Để lấy danh mục liên quan

class BrandController
{
    private $brandModel;
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->brandModel = new BrandModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Hiển thị danh sách brand
    public function list()
    {
        $brands = $this->brandModel->getBrand(); // Có cả tên danh mục
        include 'app/views/brand/list.php';
        include 'app/views/brand/header.php';
    }

    // Hiển thị form thêm brand
    public function add()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/brand/add.php';
    }

    // Xử lý lưu brand mới
    public function save()
    {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];

        $this->brandModel->addBrand($name, $category_id);
        header('Location: /webbanhang/Brand/list');
    }

    // Xóa brand
    public function delete($id)
    {
        $this->brandModel->deleteBrand($id);
        header('Location: /webbanhang/Brand/list');
    }

    // Form sửa
    public function edit($id)
    {
        $brand = $this->brandModel->getBrandById($id);
        $categories = $this->categoryModel->getCategories();
        include 'app/views/brand/edit.php';
    }

    // Cập nhật brand
    public function update($id)
    {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];

        $this->brandModel->updateBrand($id, $name, $category_id);
        header('Location: /webbanhang/Brand/list');
    }
}
?>

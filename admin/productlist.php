<?php
include "./class/product_class.php";


// Khởi tạo đối tượng product
$product = new product();

// Xử lý xóa sản phẩm
if (isset($_GET['delete_id'])) {
    $product->delete_product($_GET['delete_id']);
    header('Location: productlist.php');
    exit();
}

// Bao gồm slider.php (sidebar)
include "slider.php";

// Lấy danh sách sản phẩm
$products = $product->show_product();
?>

<!-- Bao gồm header.php -->
<?php include "header.php"; ?>

<!-- Nội dung chính -->
<div class="admin-content-right">
    <div class="admin-content-right-product_list">
        <h1>PRODUCT LIST</h1>
        <a href="productadd.php" class="btn btn-success">+ Add Product</a>
    
        <table class="product-table">
            <thead>
            <br>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Thương hiệu</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Ảnh mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($products && $products->num_rows > 0) { 
                    while ($row = $products->fetch_assoc()) { 
                        $desc_images = $product->get_product_images($row['product_id']);
                ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['cartegory_name']; ?></td>
                    <td><?php echo $row['brand_name']; ?></td>
                    <td><?php echo number_format($row['product_price'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['product_desc']; ?></td>
                    <td><img src="../uploads/<?php echo $row['product_img']; ?>" alt="Product Image" class="product-img"></td>
                    <td class="desc-images">
                        <?php 
                        if ($desc_images && $desc_images->num_rows > 0) {
                            while ($img = $desc_images->fetch_assoc()) {
                                echo '<img src="../uploads/' . $img['product_img_desc'] . '" alt="Description Image" class="desc-img">';
                            }
                        } else {
                            echo "Không có ảnh mô tả";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="productedit.php?id=<?php echo $row['product_id']; ?>" class="btn btn-edit">Sửa</a>
                        <a href="?delete_id=<?php echo $row['product_id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                    </td>
                </tr>
                <?php }} else { ?>
                <tr>
                    <td colspan="9" class="no-data">Không có sản phẩm nào</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Đóng thẻ main-content từ header.php và wrapper từ slider.php -->
</div>
</div>
</body>
</html>

<!-- CSS tùy chỉnh -->
<style>

    h1{
        font-size: 40px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
        text-align: left;
    }
.admin-content-right {
    padding: 20px;
    color: var(--text-primary);
}

.admin-content-right-product_list h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
    text-align: left;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
}

.product-table th, .product-table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid var(--border-color);
}

.product-table th {
    background-color: var(--hover-bg);
    color: var(--text-primary);
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
}

.product-table td {
    color: var(--text-secondary);
    font-size: 14px;
}

.product-table tr:hover {
    background-color: var(--hover-bg);
}

.product-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}

.desc-images {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.desc-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
}

.no-data {
    text-align: center;
    color: var(--text-secondary);
    padding: 20px;
    font-style: italic;
}

.btn {
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s;
    display: inline-block;
    margin: 0 5px;
}

.btn-edit {
    background-color: #4a90e2;
    color: white;
}

.btn-edit:hover {
    background-color: #357abd;
}

.btn-delete {
    background-color: #e94e77;
    color: white;
}

.btn-delete:hover {
    background-color: #c0392b;
}

@media (max-width: 768px) {
    .product-table th, .product-table td {
        padding: 8px 10px;
        font-size: 12px;
    }

    .product-img {
        width: 80px;
        height: 80px;
    }

    .desc-img {
        width: 40px;
        height: 40px;
    }

    .btn {
        padding: 6px 10px;
        font-size: 12px;
    }
}
</style>
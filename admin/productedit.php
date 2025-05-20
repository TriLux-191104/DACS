<?php
ob_start();

include "./class/product_class.php";

$product = new Product();
$product_id = $_GET['id'];

// Bao gồm slider.php (sidebar)
include "slider.php";

// Lấy danh sách sản 


 include "header.php";


// Xử lý xóa ảnh mô tả
if (isset($_GET['delete_img'])) {
    $image_name = $_GET['delete_img'];
    $product->delete_product_image($product_id, $image_name);
    header("Location: productedit.php?id=$product_id");
}

$product_info = $product->get_product($product_id)->fetch_assoc();
$desc_images = $product->get_product_images($product_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product->update_product($product_id);
    header('Location: productlist.php');
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-product_add">
        <h1>Sửa Sản Phẩm</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Nhập tên sản phẩm <span style="color: red">*</span></label>
            <input name="product_name" required value="<?php echo $product_info['product_name']; ?>" type="text" />
            
            <label>Chọn danh mục <span style="color: red">*</span></label>
            <select name="cartegory_id" id="">
                <?php
                $show_cartegory = $product->show_cartegory();
                if ($show_cartegory) {
                    while ($result = $show_cartegory->fetch_assoc()) {
                ?>
                <option value="<?php echo $result['cartegory_id'] ?>" 
                        <?php if($result['cartegory_id'] == $product_info['cartegory_id']) echo 'selected'; ?>>
                    <?php echo $result['cartegory_name'] ?>
                </option>
                <?php }} ?>
            </select>

            <label>Chọn loại sản phẩm <span style="color: red">*</span></label>
            <select name="brand_id" id="">
                <?php
                $show_brand = $product->show_brand();
                if ($show_brand) {
                    while ($result = $show_brand->fetch_assoc()) {
                ?>
                <option value="<?php echo $result['brand_id'] ?>" 
                        <?php if($result['brand_id'] == $product_info['brand_id']) echo 'selected'; ?>>
                    <?php echo $result['brand_name'] ?>
                </option>
                <?php }} ?>
            </select>

            <label>Giá sản phẩm <span style="color: red">*</span></label>
            <input name="product_price" required value="<?php echo $product_info['product_price']; ?>" type="text" />

            <label>Mô tả sản phẩm <span style="color: red">*</span></label>
            <textarea required name="product_desc" cols="30" rows="10"><?php echo $product_info['product_desc']; ?></textarea>

            <label>Ảnh sản phẩm hiện tại</label>
            <img src="../Uploads/<?php echo $product_info['product_img']; ?>" width="100" alt="Product Image">
            <label>Thay ảnh mới (nếu cần)</label>
            <input name="product_img" type="file" />

            <label>Ảnh mô tả hiện tại</label>
            <div class="desc-images">
                <?php 
                if ($desc_images && $desc_images->num_rows > 0) {
                    while ($img = $desc_images->fetch_assoc()) {
                        echo '<div class="desc-image-item">';
                        echo '<img src="../Uploads/' . $img['product_img_desc'] . '" width="100" alt="Description Image">';
                        echo '<a href="productedit.php?id=' . $product_id . '&delete_img=' . $img['product_img_desc'] . '" 
                              class="delete-img" 
                              onclick="return confirm(\'Bạn có chắc muốn xóa ảnh này?\');">Xóa</a>';
                        echo '</div>';
                    }
                } else {
                    echo "Không có ảnh mô tả";
                }
                ?>
            </div>

            <label>Thêm ảnh mô tả mới (nếu cần)</label>
            <input name="product_img_desc[]" type="file" multiple />

            <button type="submit">Cập nhật</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
<?php
ob_end_flush();
?>

<style>
  /*-------Product Edit--------*/

 h1 {
  margin-bottom: 20px;
}

input,
select {
  width: 200px;
  height: 30px;
  display: block;
  margin: 6px 12px;
  padding-left: 12px;
}
 textarea {
  display: block;
  width: 500px;
  height: 200px;
  margin-bottom: 12px;
  padding: 12px;
}

 button {
  display: block;
  margin-top: 10px;
  height: 30px;
  width: 100px;
  cursor: pointer;
  background-color: brown;
  border: none;
  color: white;
}
 button:hover {
  background-color: transparent;
  border: 1px solid brown;
  color: brown;
}

</style>

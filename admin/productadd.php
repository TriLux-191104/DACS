<?php
ob_start();
include "header.php";
include "slider.php";
include "class/product_class.php";

?>

<?php
$product= new Product();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //echo '<pre>';
    //echo print_r($_FILES['product_img_desc']['name']);
    //echo '</pre>';
    $insert_product= $product->insert_product($_POST,$_FILES);

}

?>


<div class="admin-content-right">
<div class="admin-content-right-product_add">
          <h1>Them San Pham</h1>
          <form action="" method="POST" enctype="multipart/form-data">
            <label for=""
              >Nhap ten san pham <span style="color: red">*</span></label
            >
            <input name="product_name" require type="text" />

                 
            
            <label for=""
              >Chon danh muc <span style="color: red">*</span></label
            >
            <select name="cartegory_id" id="">
             <option value="">--Chon</option>
              <?php
              $show_cartegory = $product->show_cartegory();
              if ($show_cartegory) {
                while ($result = $show_cartegory->fetch_assoc()) {


              ?>
              <option value="<?php echo $result['cartegory_id'] ?> "><?php echo $result['cartegory_name'] ?></option>
              <?php
                }}
              ?>
            </select>




            <label for=""
              >Chon loai san pham <span style="color: red">*</span></label
            >
            <select name="brand_id" id="">
              <option value="">--Chon</option>
              <?php
              $show_brand = $product->show_brand();
              if ($show_brand) {
                while ($result = $show_brand ->fetch_assoc()) {


              ?>
              <option value="<?php echo $result['brand_id'] ?> "><?php echo $result['brand_name'] ?></option>
              <?php
                }}
              ?>
            </select>



            <label for="">Gia san pham<span style="color: red">*</span></label>
            <input name="product_price" require type="text" />

            <label for=""
              >Mo ta san pham<span style="color: red">*</span></label
            >
            <textarea require name="product_desc" id="" cols="30" rows="10"></textarea>

            <label for="">Anh san pham<span style="color: red">*</span></label>
            <input name = "product_img" require type="file" />
            <label for="">Anh mo ta<span style="color: red">*</span></label>
            <input name = "product_img_desc[]" require multiple type="file" />
            <button type="submit">Them</button>
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

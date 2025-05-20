<?php
ob_start();
include "header.php";
include "slider.php";
include "./class/cartegory_class.php";

$cartegory = new Cartegory();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cartegory_name = $_POST['cartegory_name'];
  $insert_cartegory = $cartegory->insert_cartegory($cartegory_name);
}
?>

<div class="admin-content-right">
  <div class="admin-content-right-cartegory_add">
    <h1>Add Category</h1>
    <form action="" method="POST">
      <input required name="cartegory_name" type="text" placeholder="Enter category name" class="form-control mb-2"/>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
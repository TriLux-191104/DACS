<?php
ob_start();
include "header.php";
include "slider.php";
include "./class/cartegory_class.php";

$cartegory = new Cartegory();

if (!isset($_GET['cartegory_id']) || $_GET['cartegory_id'] == NULL) {
  echo "<script>window.location = 'categorylist.php'</script>";
} else {
  $cartegory_id = $_GET['cartegory_id'];
}

$get_cartegory = $cartegory->get_cartegory($cartegory_id);
if ($get_cartegory) {
  $result = $get_cartegory->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cartegory_name = $_POST['cartegory_name'];
  $update_cartegory = $cartegory->update_cartegory($cartegory_name, $cartegory_id);
  echo "<script>window.location = 'categorylist.php'</script>";
}
?>

<div class="admin-content-right">
  <div class="admin-content-right-cartegory_add">
    <h1>Edit Category</h1>
    <form action="" method="POST">
      <input required name="cartegory_name" type="text" placeholder="Enter category name"
        value="<?= $result['cartegory_name'] ?>" class="form-control mb-2"/>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
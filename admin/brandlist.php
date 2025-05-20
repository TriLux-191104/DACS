<?php
include "slider.php";
include "header.php";
include "./class/brand_class.php";

$brand = new Brand();
$show_brand = $brand->show_brand();
?>

<div class="admin-content-right">
  <div class="admin-content-right-cartegory_list">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Brand List</h1>
      <a href="brandadd.php" class="btn btn-success">+ Add Brand</a>
    </div>
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>Category</th>
          <th>Brand Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($show_brand) {
          $i = 0;
          while ($result = $show_brand->fetch_assoc()) {
            $i++;
        ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $result['brand_id'] ?></td>
            <td><?= $result['cartegory_name'] ?></td>
            <td><?= $result['brand_name'] ?></td>
            <td>
              <a href="brandedit.php?brand_id=<?= $result['brand_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="branddelete.php?brand_id=<?= $result['brand_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this brand?')">Delete</a>
            </td>
          </tr>
        <?php }} ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

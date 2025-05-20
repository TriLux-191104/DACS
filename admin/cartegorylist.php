<?php

include "slider.php";
include "header.php";
include "./class/cartegory_class.php";

$cartegory = new Cartegory();
$show_cartegory = $cartegory->show_cartegory();
?>

<div class="admin-content-right">
  <div class="admin-content-right-cartegory_list">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Category List</h1>
      <a href="cartegoryadd.php" class="btn btn-success">+ Add Category</a>
    </div>
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>Category Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($show_cartegory) {
          $i = 0;
          while ($result = $show_cartegory->fetch_assoc()) {
            $i++;
        ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $result['cartegory_id'] ?></td>
            <td><?= $result['cartegory_name'] ?></td>
            <td>
              <a href="cartegoryedit.php?cartegory_id=<?= $result['cartegory_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="cartegorydelete.php?cartegory_id=<?= $result['cartegory_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this category?')">Delete</a>
            </td>
          </tr>
        <?php }} ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

<?php
session_start();

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

// Bao gồm slider.php (sidebar)
include "indexx.php";
?>
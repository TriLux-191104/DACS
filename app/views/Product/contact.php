<?php include 'app/views/shares/header.php'; ?>
<style>
    /* Breadcrumb */
.breadcrumb {
    background-color: transparent;
    padding: 0.5rem 0;
    font-size: 1 rem;
    margin-left: 200px;
}

.breadcrumb-item a {
    color: #6c757d;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item.active {
    
    color: #333;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding: 0 0.5rem;
    color: #6c757d;
}
</style>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/webdr/product/home" class="text-decoration-none">
                <i class="fas fa-home"></i> <!-- Biểu tượng trang chủ -->
            </a>
        </li>
        <li class="breadcrumb-item">
        <a href="">Contact</a>
    </li>

    </ol>
</nav>

<div class="container mt-5 mb-5">
  <div class="row">
    <!-- Thông tin liên hệ -->
    <div class="col-md-6">
      <h4>Thông Tin Liên Hệ</h4>
      <p><i class="fas fa-map-marker-alt me-2"></i> 160 Nguyễn Cư Trinh, Quận 1, TP. HCM</p>
      <p><i class="fas fa-phone-alt me-2"></i> (+84) 965 306 692</p>
      <p><i class="fas fa-envelope me-2"></i> support@droppy.vn</p>
      <p><i class="fas fa-clock me-2"></i> 8:00 - 22:00, Thứ 2 - Chủ Nhật</p>

      <h5 class="mt-4">Theo Dõi Chúng Tôi</h5>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f me-3"></i></a>
        <a href="#"><i class="fab fa-instagram me-3"></i></a>
        <a href="#"><i class="fab fa-twitter me-3"></i></a>
        <a href="#"><i class="fab fa-youtube me-3"></i></a>
      </div>
    </div>

    
  </div>
</div>
<?php

?>
<?php include 'app/views/shares/chatbot.php'; ?>

<?php include 'app/views/shares/footer.php'; ?>

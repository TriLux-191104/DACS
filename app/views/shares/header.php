<?php
require_once 'app/helpers/language_helper.php';
// Lấy danh sách danh mục và sản phẩm để lấy thương hiệu
require_once('app/models/CategoryModel.php');
require_once('app/models/ProductModel.php');
require_once('app/models/BrandModel.php');
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Droppy</title>
    <!-- Bootstrap CSS -->
<link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="/webdr/app/views/css/style.css">
    
  </head>
  <body>
    <!-- Header -->
    <nav
      class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top shadow-sm"
    >
      <div class="container">
        <a class="navbar-brand" href="/webdr/Product/home">
          <h1>DROPPY</h1>
          <p>MADE IN VIETNAM</p>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
    <li class="nav-item">
        <a class="nav-link px-3" href="/webdr/Product/home"><?php echo trans('home'); ?></a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle px-3" href="#" id="banBidaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo trans('ban_bida'); ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="banBidaDropdown">
            <li><a class="dropdown-item" href="/webdr/Product/index?brand_id=39">Bàn bida lỗ</a></li>
            <li><a class="dropdown-item" href="/webdr/Product/index?brand_id=40">Bàn bida phăng</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle px-3" href="#" id="coBidaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo trans('co_bida'); ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="coBidaDropdown">
            <li><a class="dropdown-item" href="/webdr/Product/index?brand_id=37">Cơ Mộc</a></li>
            <li><a class="dropdown-item" href="/webdr/Product/index?brand_id=38">Cơ Carbon</a></li>
            <li><a class="dropdown-item" href="/webdr/Product/index?brand_id=41">Cơ Phá Nhảy</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle px-3" href="#" id="phuKienDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo trans('phu_kien'); ?>
        </a>
        <ul class="dropdown-menu" aria-labelledby="phuKienDropdown">
            <li><a class="dropdown-item" href="http://localhost/webdr/Product/index?brand_id=35">Bao cơ</a></li>
            <li><a class="dropdown-item" href="http://localhost/webdr/Product/index?brand_id=36">Lơ đánh cơ</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link px-3" href="/webdr/Product/contact"><?php echo trans('contact'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-3" href="/webdr/Product/tintuc"><?php echo trans('news'); ?></a>
    </li>
</ul>
<div class="navbar-icons">
    <ul class="navbar-nav">
        <li class="nav-item">
            <form class="d-flex" action="/webdr/Product/search" method="GET">
                <input class="form-control me-2" type="search" name="keyword" placeholder="<?php echo trans('search'); ?>..." aria-label="Search" style="width: 200px;">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/webdr/Account/log" title="<?php echo trans('account'); ?>">
                <i class="fas fa-user"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/webdr/Product/cart" title="<?php echo trans('cart'); ?>">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/webdr/language" title="<?php echo trans('language'); ?>">
                <i class="fas fa-globe"></i>
            </a>
        </li>
    </ul>
</div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Banner -->
    <!-- <section class="banner">
      <img
        src="../uploads/babber.jpeg"
        alt="DirtyCoins Banner"
        class="img-fluid w-100"
      />
    </section> -->

    

    

    

    
  </body>
</html>

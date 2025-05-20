<?php include 'app/views/shares/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - Droppy</title>
    
  </head>
  <body>
        <!-- Banner Carousel -->
        <div class="banner-container">
      <div id="bannerCarousel" class="carousel slide banner" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/webdr/uploads/slide2.jpg" class="d-block w-100" alt="Allin Cue Event">
          </div>
          <div class="carousel-item">
            <img src="/webdr/uploads/slide1.jpg" class="d-block w-100" alt="Bida Banner">
          </div>
          <div class="carousel-item">
            <img src="/webdr/uploads/slide4.jpg" class="d-block w-100" alt="Banner 3">
          </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
   
     <!-- Danh mục sản phẩm -->
     <section class="category-section">
     <h2>DANH MỤC PHỔ BIẾN</h2>
     <hr />
     <br>
     <br>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=37" class="text-decoration-none">
              <img src="/webdr/uploads/peri.jpg" alt="Cơ Mộc" />
              <p>CƠ MỘC</p>
            </a>
          </div>
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=38" class="text-decoration-none">
              <img src="/webdr/uploads/carbon.webp" alt="Cơ Carbon" />
              <p>CƠ CARBON</p>
            </a>
          </div>
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=39" class="text-decoration-none">
              <img src="/webdr/uploads/mrsung.webp" alt="Bida Lỗ" />
              <p>BÀN BIDA LỖ</p>
            </a>
          </div>
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=40" class="text-decoration-none">
              <img src="/webdr/uploads/phang.webp" alt="Bida Phăng" />
              <p>BÀN BIDA PHĂNG</p>
            </a>
          </div>
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=35" class="text-decoration-none">
              <img src="/webdr/uploads/baoco.jpg" alt="Bao Cơ" />
              <p>BAO CƠ</p>
            </a>
          </div>
          <div class="col-6 col-md-2 category-item">
            <a href="/webdr/Product/index?brand_id=36" class="text-decoration-none">
              <img src="/webdr/uploads/lo.webp" alt="Lơ Bida" />
              <p>LƠ BIDA</p>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Sản phẩm nổi bật -->
    <section class="featured-products">
      <div class="container">
        <h2>SẢN PHẨM NỔI BẬT</h2>
        <hr />
        <section class="featured-products">
       <div class="container">

    <div class="row">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <?php include 'app/views/product/product_item.php'; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-warning">Không có sản phẩm nào trong danh mục này.</div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
      </div>
    </section>



    <?php include 'app/views/product/tintucc.php'; ?>

    <!-- Include Contact Widget -->
    <?php include 'app/views/shares/contact_widget.php'; ?>
    
  
    <!-- Include Footer -->
    <?php include 'app/views/shares/footer.php'; ?>
  </body>
</html>
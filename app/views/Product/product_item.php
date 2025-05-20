<div class="col-lg-3 col-md-6 mb-4">
    <div class="product-card h-100">
        <div class="product-image">
            <img src="/webdr/uploads/<?= $product->product_img ?>" 
                 class="img-fluid w-100" 
                 alt="<?= $product->product_name ?>" 
                 style="height: 250px; object-fit: cover;">

            <div class="sold-badge">
                <i class="fas fa-check-circle me-1"></i> Đã bán: <?= $product->sold ?>
            </div>
        </div>

        <div class="product-info">
            <h5 class="product-name mb-2"><?= $product->product_name ?></h5>

            <?php if (isset($product->brand_name)): ?>
                <p class="brand-name mb-1">
                    <i class="fas fa-tag me-1"></i> <?= $product->brand_name ?>
                </p>
            <?php endif; ?>

            <?php if (isset($product->category_name)): ?>
                <p class="brand-name mb-1">
                    <i class="fas fa-folder me-1"></i> <?= $product->category_name ?>
                </p>
            <?php endif; ?>

            <p class="product-desc small text-muted mb-2">
                <?= substr($product->product_desc, 0, 60) ?>...
            </p>

            <h4 class="product-price mb-3">
                <?= number_format($product->product_price, 0, ',', '.') ?> VNĐ
            </h4>

            <div class="d-flex justify-content-between">
                <a href="/webdr/Product/show/<?= $product->product_id ?>" 
                   class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-eye me-1"></i> Xem chi tiết
                </a>
                <form action="/webdr/Product/addToCart/<?= $product->product_id ?>" method="post">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-dark btn-sm">
                        <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
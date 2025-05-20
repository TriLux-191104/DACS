<?php include 'app/views/shares/header.php'; ?>

<?php
if (!isset($product)) {
    die("Không tìm thấy sản phẩm.");
}
$stock = isset($product->stock) ? $product->stock : 10;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product->product_name); ?> - Droppy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css">
    <style>
        :root {
            --primary-color: #6c757d;
            --secondary-color: #495057;
            --accent-color: #5f6c72;
            --light-gray: #e9ecef;
            --medium-gray: #dee2e6;
            --dark-gray: #343a40;
            --text-color: #212529;
            --text-light: #6c757d;
            --white: #ffffff;
        }

        body {
            background-color: #f8f9fa;
            color: var(--text-color);
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 1rem 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--text-light);
            transition: color 0.2s;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--secondary-color);
        }

        .breadcrumb-item.active {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            padding: 0 0.5rem;
            color: var(--medium-gray);
        }

        /* Product Container */
        .product-detail-container {
            padding: 2rem 0;
        }

        .product-main {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid var(--light-gray);
        }

        /* Product Gallery */
        .product-gallery {
            padding: 2rem;
            border-right: 1px solid var(--light-gray);
            position: relative;
        }

        .main-image-container {
            position: relative;
            margin-bottom: 1.5rem;
            cursor: zoom-in;
            overflow: hidden;
            border-radius: 6px;
            background: var(--light-gray);
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .main-image.zoomed {
            transform: scale(1.5);
            cursor: zoom-out;
        }

        /* Slider */
        .thumbnail-slider {
            margin-top: 1.5rem;
        }

        .thumbnail-slider .slick-slide {
            padding: 0 5px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background: var(--light-gray);
        }

        .thumbnail:hover,
        .slick-current .thumbnail {
            border: 2px solid var(--accent-color);
        }

        .slick-arrow {
            width: 30px;
            height: 30px;
            z-index: 1;
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .slick-arrow:hover {
            background: var(--accent-color);
        }

        .slick-prev {
            left: 5px;
        }

        .slick-next {
            right: 5px;
        }

        .slick-arrow:before {
            font-size: 16px;
            color: var(--white);
        }

        /* Product Info */
        .product-info {
            padding: 2rem;
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-gray);
        }

        .product-meta {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            color: var(--text-light);
        }

        .product-rating {
            color: #ffc107;
            margin-right: 1rem;
        }

        .product-sold {
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
        }

        .product-description {
            line-height: 1.7;
            color: var(--text-color);
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--light-gray);
        }

        /* Product Actions */
        .product-actions {
            margin-bottom: 2rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .quantity-label {
            margin-right: 1rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            padding: 0.5rem;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            background: var(--white);
            color: var(--text-color);
        }

        .stock-status {
            display: flex;
            align-items: center;
            color: var(--success-color);
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .stock-status i {
            margin-right: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
        }

        .btn-outline:hover {
            background-color: rgba(108, 117, 125, 0.1);
        }

        /* Related Products */
        .related-products {
            max-width: 1200px;
            margin: 3rem auto;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-gray);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-main {
                flex-direction: column;
            }

            .product-gallery {
                border-right: none;
                border-bottom: 1px solid var(--light-gray);
            }

            .main-image {
                height: 300px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .thumbnail {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="product-detail-container">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/webdr/Product/home"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/webdr/Product">Sản phẩm</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->product_name) ?></li>
                </ol>
            </nav>

            <div class="product-main row">
                <div class="product-gallery col-md-6">
                    <div class="main-image-container" id="main-image-container">
                        <img src="/webdr/uploads/<?= htmlspecialchars($product->product_img) ?>" 
                             class="main-image" 
                             id="main-image"
                             alt="<?= htmlspecialchars($product->product_name) ?>">
                    </div>

                    <!-- Thumbnail Slider for Description Images -->
                    <?php if (!empty($desc_images)): ?>
                        <div class="thumbnail-slider" id="thumbnail-slider">
                            <?php foreach ($desc_images as $index => $desc_image): ?>
                                <div>
                                    <img src="/webdr/uploads/<?= htmlspecialchars($desc_image->product_img_desc) ?>" 
                                         class="thumbnail" 
                                         alt="Mô tả <?= $index + 1 ?>"
                                         data-full="/webdr/uploads/<?= htmlspecialchars($desc_image->product_img_desc) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-info col-md-6">
                    <h1 class="product-title"><?= htmlspecialchars($product->product_name) ?></h1>

                    <div class="product-meta">
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="product-sold">
                            <i class="fas fa-check-circle"></i> Đã bán: <?= $product->sold ?? 0 ?>
                        </div>
                    </div>

                    <div class="product-price">
                        <?= number_format($product->product_price, 0, ',', '.') ?>₫
                    </div>

                    <div class="product-description">
                        <?= nl2br(htmlspecialchars($product->product_desc ?: 'Sản phẩm chất lượng cao, thiết kế tinh xảo')) ?>
                    </div>

                    <form id="product-form" method="POST" action="/webdr/Product/addToCart/<?= $product->product_id ?>">
                        <div class="product-actions">
                            <div class="quantity-selector">
                                <span class="quantity-label">Số lượng:</span>
                                <input type="number" 
                                       class="quantity-input" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="<?= $stock ?>"
                                       required>
                            </div>

                            <div class="stock-status">
                                <i class="fas fa-<?= $stock > 0 ? 'check' : 'times' ?>"></i>
                                <?= $stock > 0 ? "Còn hàng ($stock sản phẩm)" : 'Tạm hết hàng' ?>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" 
                                    name="action" 
                                    value="add_to_cart" 
                                    class="btn btn-primary"
                                    <?= $stock <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                            <button type="submit" 
                                    name="action" 
                                    value="buy_now" 
                                    class="btn btn-outline"
                                    <?= $stock <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-bolt"></i> Mua ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm tương tự -->
    <section class="related-products">
        <div class="container">
            <h2 class="section-title">SẢN PHẨM TƯƠNG TỰ</h2>
            <div class="row">
                <?php if (!empty($related_products)): ?>
                    <?php foreach ($related_products as $related): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="/webdr/uploads/<?= htmlspecialchars($related->product_img) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($related->product_name) ?>"
                                     style="height: 200px; object-fit: contain; background: var(--light-gray); padding: 1rem;">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 1rem;"><?= htmlspecialchars($related->product_name) ?></h5>
                                    <p class="card-text text-muted small">Đã bán: <?= htmlspecialchars($related->sold) ?></p>
                                    <p class="card-text text-dark fw-bold">
                                        <?= number_format($related->product_price, 0, ',', '.') ?>₫
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between">
                                    <a href="/webdr/Product/show/<?= $related->product_id ?>" 
                                       class="btn btn-sm btn-outline-secondary">Xem chi tiết</a>
                                    <form action="/webdr/Product/addToCart/<?= $related->product_id ?>" 
                                          method="post" 
                                          class="d-inline">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-dark">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-secondary">Không có sản phẩm tương tự.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize thumbnail slider
            $('#thumbnail-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });

            // Change main image when thumbnail is clicked
            $('.thumbnail').on('click', function() {
                const newSrc = $(this).attr('src');
                $('#main-image').attr('src', newSrc);
                $('#thumbnail-slider .slick-slide').removeClass('slick-current');
                $(this).closest('.slick-slide').addClass('slick-current');
            });

            // Image zoom functionality
            $('#main-image-container').on('click', function() {
                $('#main-image').toggleClass('zoomed');
            });

            // Lightgallery for fullscreen view
            $('#main-image-container').on('click', function() {
                const items = [];
                
                // Add main image
                items.push({
                    src: $('#main-image').attr('src'),
                    thumb: $('#main-image').attr('src')
                });
                
                // Add description images if available
                $('.thumbnail').each(function() {
                    items.push({
                        src: $(this).data('full') || $(this).attr('src'),
                        thumb: $(this).attr('src')
                    });
                });
                
                // Open gallery
                const dynamicGallery = lightGallery(document.getElementById('main-image-container'), {
                    dynamic: true,
                    dynamicEl: items,
                    download: false,
                    zoom: true
                });
                
                dynamicGallery.openGallery(0);
            });
        });
    </script>

    <!-- Include Contact Widget -->
    <?php include 'app/views/shares/contact_widget.php'; ?>
    <?php include 'app/views/shares/footer.php'; ?>
</body>
</html>
<?php include 'app/views/shares/header.php'; ?>

<style>
/* Breadcrumb */
.breadcrumb {
    background-color: transparent;
    padding: 0.5rem 0;
    font-size: 1rem;
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

/* Tiêu đề */
.page-title {
    font-size: 1.8rem; /* nhỏ hơn */
    margin-bottom: 1.5rem; /* thay vì mb-5 */
    margin-top: -2.5rem; /* thụt lên */
    font-weight: 700;
    text-transform: uppercase;
}
</style>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/webdr"><i class="fas fa-home"></i></a>
    </li>
    <li class="breadcrumb-item">
        <a href=""><?= isset($brand_name) ? $brand_name : 'DANH SÁCH SẢN PHẨM' ?></a>
    </li>
</ol>

<div class="container py-5">
    <!-- Tiêu đề trang -->
    <div class="text-center mb-4">
        <h1 class="page-title"><?= isset($brand_name) ? $brand_name : 'DANH SÁCH SẢN PHẨM' ?></h1>
        <!-- Bỏ divider -->
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php include 'app/views/product/product_item.php'; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào</h5>
                    <p class="mb-0">Vui lòng thử lại với bộ lọc khác</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/contact_widget.php'; ?>
<?php include 'app/views/shares/footer.php'; ?>

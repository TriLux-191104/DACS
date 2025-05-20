<?php include 'app/views/shares/header.php'; ?>

<!-- Nội dung chính của trang kết quả tìm kiếm -->
<section class="search-results">
    <div class="container">
    <br><br>
        <h2>KẾT QUẢ TÌM KIẾM CHO: "<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>"</h2>
        <hr />
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php include 'app/views/product/product_item.php'; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">Không tìm thấy sản phẩm nào khớp với từ khóa.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <br>
</section>

<?php include 'app/views/shares/footer.php'; ?>
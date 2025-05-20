<?php include 'app/views/shares/header.php'; ?>

<!-- Nội dung chính của trang chọn ngôn ngữ -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1 class="h4 mb-4"><?php echo trans('choose_language'); ?></h1>
                    <p><?php echo trans('select_language'); ?></p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/webdr/language/setLanguage/vi" class="btn btn-outline-primary">
                            <i class="fas fa-flag"></i> <?php echo trans('vietnamese'); ?>
                        </a>
                        <a href="/webdr/language/setLanguage/en" class="btn btn-outline-primary">
                            <i class="fas fa-flag"></i> <?php echo trans('english'); ?>
                        </a>
                    </div>
                    <a href="/webdr/Product/home" class="btn btn-secondary mt-4"><?php echo trans('back'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>


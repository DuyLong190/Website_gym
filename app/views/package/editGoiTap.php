<?php
if (!isset($goiTap) || !is_object($goiTap)) {
    $goiTap = (object)[
        'MaGoiTap' => '',
        'TenGoiTap' => '',
        'GiaTien' => '',
        'ThoiHan' => '',
        'MoTa' => ''
    ];
}
?>
<?php include_once __DIR__ . '/../share/header.php'; ?>

<!-- Thêm Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<div class="container mt-5">
    <h1 class="mb-4">Sửa gói tập</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/gym/goitap/update" onsubmit="return validateForm()">
        <input type="hidden" name="MaGoiTap" value="<?php echo $goiTap->MaGoiTap; ?>">
        <div class="form-group mb-3">
            <label for="TenGoiTap">Tên gói tập:</label>
            <input type="text" name="TenGoiTap" id="TenGoiTap" class="form-control" value="<?php 
            echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="gia">Giá:</label>
            <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="0.01" value="<?php 
            echo htmlspecialchars($goiTap->GiaTien); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="thoi_gian">Thời hạn:</label>
            <input type="text" name="ThoiHan" id="ThoiHan" class="form-control" value="<?php 
            echo htmlspecialchars($goiTap->ThoiHan); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="mo_ta">Mô tả:</label>
            <textarea name="MoTa" id="MoTa" class="form-control"><?php echo htmlspecialchars($goiTap->MoTa ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/gym/goitap" class="btn btn-secondary">Quay lại danh sách gói tập</a>
    </form>
</div>
<?php include_once __DIR__ . '/../share/footer.php'; ?>
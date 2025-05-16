<?php include_once __DIR__ . '/../share/header.php'; ?>

<h1>Sửa gói tập</h1>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($error as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/package/update" onsubmit="return validateForm()">
    <input type="hidden" name="MaGoiTap" value="<?php echo $goiTap->MaGoiTap; ?>">
    <div class="form-group">
        <label for="ten_goi">Tên gói tập:</label>
        <input type="text" name="TenGoiTap" id="TenGoiTap" class="form-control" value="<?php 
        echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="gia">Giá:</label>
        <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="0.01" value="<?php 
        echo htmlspecialchars($goiTap->GiaTien); ?>" required>
    </div>
    <div class="form-group">
        <label for="thoi_gian">Thời gian:</label>
        <input type="text" name="ThoiHan" id="ThoiHan" class="form-control" value="<?php 
        echo htmlspecialchars($goiTap->ThoiHan); ?>" required>
    </div>
    <div class="form-group">
        <label for="mo_ta">Mô tả:</label>
        <textarea name="MoTa" id="MoTa" class="form-control"><?php echo htmlspecialchars($goiTap->MoTa ?? ''); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật gói tập</button>
</form>
<?php include_once __DIR__ . '/../share/footer.php'; ?>
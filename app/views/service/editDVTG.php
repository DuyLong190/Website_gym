<?php
if (!isset($DVTG) || !is_object($DVTG)) {
    $DVTG = (object)[
        'id' => '',
        'TenTG' => '',
        'GiaTG' => '',
        'ThoiGianTG' => '',
        'MoTaTG' => ''
    ];
}
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="mb-4">Sửa dịch vụ</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/gym/DvThuGian/update" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?php echo $DVTG->id; ?>">
        <div class="form-group mb-3">
            <label for="TenTG">Tên dịch vụ:</label>
            <input type="text" name="TenTG" id="TenTG" class="form-control" value="<?php
            echo htmlspecialchars($DVTG->TenTG, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="GiaTG">Giá:</label>
            <input type="number" name="GiaTG" id="GiaTG" class="form-control" step="0.01" value="<?php
            echo htmlspecialchars($DVTG->GiaTG); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="ThoiGianTG">Thời gian sử dụng (phút):</label>
            <input type="text" name="ThoiGianTG" id="ThoiGianTG" class="form-control" value="<?php
            echo htmlspecialchars($DVTG->ThoiGianTG); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="MoTaTG">Mô tả:</label>
            <textarea name="MoTaTG" id="MoTaTG" class="form-control"><?php echo htmlspecialchars($DVTG->MoTaTG ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/gym/DvThuGian" class="btn btn-secondary">Quay lại danh sách dịch vụ</a>
    </form>
</div>
<?php
if (!isset($DVTL) || !is_object($DVTL)) {
    $DVTL = (object)[
        'id' => '',
        'TenTL' => '',
        'GiaTL' => '',
        'ThoiGianTL' => '',
        'MoTaTL' => ''
    ];
}
?>
<?php include_once __DIR__ . '/../share/header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="container mt-4">
                            <h1 class="text-center mb-4">Sửa dịch vụ</h1>
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="/gym/DvTapLuyen/update" onsubmit="return validateForm()">
                                <input type="hidden" name="id" value="<?php echo $DVTL->id; ?>">
                                <div class="form-group mb-3">
                                    <label for="TenTL">Tên dịch vụ:</label>
                                    <input type="text" name="TenTL" id="TenTL" class="form-control" value="<?php
                                                                                                            echo htmlspecialchars($DVTL->TenTL, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="GiaTL">Giá:</label>
                                    <input type="number" name="GiaTL" id="GiaTL" class="form-control" step="0.01" value="<?php
                                                                                                                            echo htmlspecialchars($DVTL->GiaTL); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ThoiGianTL">Thời gian sử dụng (phút):</label>
                                    <input type="text" name="ThoiGianTL" id="ThoiGianTL" class="form-control" value="<?php
                                                                                                                        echo htmlspecialchars($DVTL->ThoiGianTL); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="MoTaTL">Mô tả:</label>
                                    <textarea name="MoTaTL" id="MoTaTL" class="form-control"><?php
                                                                                                echo htmlspecialchars($DVTL->MoTaTL ?? ''); ?></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="/gym/DvTapLuyen" class="btn btn-secondary">Quay lại</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
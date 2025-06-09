<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Gói Tập</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="container mt-4">
                            <h1 class="text-center mb-4">Cập nhật gói tập</h1>
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="/gym/admin/goitap/updateGoiTap" onsubmit="return validateForm()">
                                <input type="hidden" name="MaGoiTap" value="<?php echo $goiTap->MaGoiTap; ?>">
                                <div class="form-group mb-3">
                                    <label for="TenGoiTap">Tên gói tập:</label>
                                    <input type="text" name="TenGoiTap" id="TenGoiTap" class="form-control" value="<?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="GiaTien">Giá tiền:</label>
                                    <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="0.01" value="<?php echo htmlspecialchars($goiTap->GiaTien); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ThoiHan">Thời hạn:</label>
                                    <input type="number" name="ThoiHan" id="ThoiHan" class="form-control" value="<?php echo htmlspecialchars($goiTap->ThoiHan); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="MoTa">Mô tả:</label>
                                    <textarea name="MoTa" id="MoTa" class="form-control"><?php echo htmlspecialchars($goiTap->MoTa ?? ''); ?></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Cập nhật
                                        <i class="fa-solid fa-save ms-2"></i>
                                    </button>
                                    <a href="/gym/admin/goitap" class="btn btn-secondary ms-2">
                                        <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>

</html>
<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php include_once __DIR__ . '/../share/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Dịch vụ thư giãn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Thêm Dịch vụ thư giãn mới</h1>
                        <form method="POST" action="/gym/DvThuGian/save" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="TenTG" class="form-label">Tên dịch vụ thư giãn:</label>
                                <input type="text" name="TenTG" id="TenTG" class="form-control"
                                    placeholder="Nhập tên dịch vụ thư giãn" required>
                            </div>
                            <div class="mb-3">
                                <label for="GiaTG" class="form-label">Giá tiền:</label>
                                <input type="number" name="GiaTG" id="GiaTG" class="form-control" step="0.01" min="0"
                                    placeholder="Nhập giá tiền" required>
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianTG" class="form-label">Thời gian sử dụng (phút):</label>
                                <input type="number" name="ThoiGianTG" id="ThoiGianTG" class="form-control" min="1"
                                    placeholder="Nhập thời gian sử dụng" required>
                            </div>
                            <div class="mb-3">
                                <label for="MoTaTG" class="form-label">Mô tả:</label>
                                <textarea name="MoTaTG" id="MoTaTG" class="form-control"
                                    placeholder="Nhập mô tả" required></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" id="submit" name="submit">Thêm</button>
                                <a href="/gym/DvThuGian" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>

</html>
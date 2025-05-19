<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Dịch vụ tập luyện</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Thêm Dịch vụ tập luyện mới</h1>
                        <form method="POST" action="/gym/DvTapLuyen/save" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="TenTL" class="form-label">Tên dịch vụ tập luyện:</label>
                                <input type="text" name="TenTL" id="TenTL" class="form-control"
                                    placeholder="Nhập tên dịch vụ tập luyện" required>
                            </div>
                            <div class="mb-3">
                                <label for="GiaTL" class="form-label">Giá tiền:</label>
                                <input type="number" name="GiaTL" id="GiaTL" class="form-control" step="0.01" min="0"
                                    placeholder="Nhập giá tiền" required>
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianTL" class="form-label">Thời gian sử dụng (phút):</label>
                                <input type="number" name="ThoiGianTL" id="ThoiGianTL" class="form-control" min="1"
                                    placeholder="Nhập thời gian sử dụng" required>
                            </div>
                            <div class="mb-3">
                                <label for="MoTaTL" class="form-label">Mô tả:</label>
                                <textarea name="MoTaTL" id="MoTaTL" class="form-control"
                                    placeholder="Nhập mô tả" required></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" id="submit" name="submit">Thêm dịch vụ tập luyện</button>
                                <a href="/gym/DvTapLuyen" class="btn btn-secondary">Quay lại danh sách dịch vụ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
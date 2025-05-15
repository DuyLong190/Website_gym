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
    <title>Thêm Gói Tập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Thêm Gói Tập Mới</h1>
                        <form method="POST" action="/gym/package/save" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="ten_goi" class="form-label">Tên gói tập:</label>
                                <input type="text" name="ten_goi" id="ten_goi" class="form-control" placeholder="Nhập tên gói tập" required>
                            </div>
                            <div class="mb-3">
                                <label for="gia" class="form-label">Giá:</label>
                                <input type="number" name="gia" id="gia" class="form-control" step="0.01" placeholder="Nhập giá" required>
                            </div>
                            <div class=" mb-3">
                                <label for="thoi_gian" class="form-label">Thời hạn:</label>
                                <input type="text" name="thoi_gian" id="thoi_gian" class="form-control" placeholder="Nhập thời hạn" required>
                            </div>
                            <div class="mb-3">
                                <label for="mo_ta" class="form-label">Mô tả:</label>
                                <textarea name="mo_ta" id="mo_ta" class="form-control" placeholder="Nhập mô tả"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" id="submit" name="submit">Thêm gói tập</button>
                                <a href="" class="btn btn-secondary">Quay lại danh sách gói tập</a>
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
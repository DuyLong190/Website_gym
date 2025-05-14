
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Gói Tập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Thêm Gói Tập Mới</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($error as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="app/views/package/listGoiTap.php" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="ten_goi" class="form-label">Tên gói tập:</label>
            <input type="text" name="ten_goi" id="ten_goi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="gia" class="form-label">Giá:</label>
            <input type="number" name="gia" id="gia" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="thoi_gian" class="form-label">Thời gian:</label>
            <input type="text" name="thoi_gian" id="thoi_gian" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả:</label>
            <textarea name="mo_ta" id="mo_ta" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm gói tập</button>
        <a href="app/views/package/listGoiTap.php" class="btn btn-secondary ms-2">Quay lại danh sách gói tập</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

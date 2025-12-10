<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hội viên mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --success-color: #10b981;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            margin-left: 8.5rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 2rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
            max-width: 900px;
            margin: 0 auto;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            background: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            box-shadow: var(--card-shadow);
            color: white;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .page-header h1 i {
            font-size: 2.2rem;
        }

        .admin-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-header i {
            margin-right: 0.5rem;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #c7d2fe;
        }

        .text-danger {
            color: #ef4444 !important;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--success-color);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            border-top: 2px solid #f3f4f6;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <i class="fa-solid fa-user-plus"></i>
                Thêm hội viên mới
            </h1>
        </div>
        <div class="card admin-card">
            <div class="card-header">
                <i class="fas fa-user-plus"></i>
                Thông tin hội viên
            </div>
            <div class="card-body">
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger">
                                        <?= htmlspecialchars($_SESSION['error']) ?>
                                        <?php unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['success'])): ?>
                                    <div class="alert alert-success">
                                        <?= htmlspecialchars($_SESSION['success']) ?>
                                        <?php unset($_SESSION['success']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach ($errors as $error): ?>
                                                <li><?= htmlspecialchars($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <form action="/gym/admin/user/saveUser" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="image" class="form-label">
                                                <i class="fas fa-image me-1"></i>
                                                Ảnh đại diện
                                            </label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <small class="text-muted">Chọn file: JPG, PNG, GIF (tối đa 5MB)</small>
                                            <div class="mt-2" id="image_preview" style="display: none;">
                                                <img id="image_preview_img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="HoTen" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="HoTen" name="HoTen" required value="<?= htmlspecialchars($_POST['HoTen'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="NgaySinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required maxlength.year= value="<?= htmlspecialchars($_POST['NgaySinh'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="GioiTinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                                            <select class="form-select" id="GioiTinh" name="GioiTinh" required>
                                                <option value="">Chọn giới tính</option>
                                                <option value="Nam" <?= (($_POST['GioiTinh'] ?? '') == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                                <option value="Nữ" <?= (($_POST['GioiTinh'] ?? '') == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                                <option value="Khác" <?= (($_POST['GioiTinh'] ?? '') == 'Khác') ? 'selected' : '' ?>>Khác</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="SDT" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="SDT" name="SDT" required maxlength="10" value="<?= htmlspecialchars($_POST['SDT'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="Email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($_POST['Email'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="MaGoiTap" class="form-label">Gói tập <span class="text-danger">*</span></label>
                                            <select class="form-select" id="MaGoiTap" name="MaGoiTap">
                                                <option value="">Chọn gói tập</option>
                                                <?php foreach ($goiTap as $goitap): ?>
                                                    <option value="<?= $goitap['MaGoiTap'] ?>" <?= (($_POST['MaGoiTap'] ?? '') == $goitap['MaGoiTap']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($goitap['TenGoiTap']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DiaChi" class="form-label">Địa chỉ</label>
                                        <textarea class="form-control" id="DiaChi" name="DiaChi" rows="3"><?= htmlspecialchars($_POST['DiaChi'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                        </button>
                                        <a href="/gym/admin/user" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>
                                        </a>
                                    </div>
                                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview image before upload
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image_preview');
                    const previewImg = document.getElementById('image_preview_img');
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('image_preview').style.display = 'none';
            }
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hội viên mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
        }

        .admin-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: none;
            background: #fff;
        }

        .admin-title {
            color: #6366f1;
            font-weight: 800;
            font-size: 2rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            border: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="mb-4 admin-title text-center">
                    <i class="fa-solid fa-user-plus me-2"></i>Thêm hội viên mới
                </h1>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card admin-card mb-4">
                            <div class="card-header bg-white border-0 fw-bold">
                                <i class="fas fa-user-plus me-1"></i>
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
                                <form action="/gym/admin/user/saveUser" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="HoTen" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="HoTen" name="HoTen" required value="<?= htmlspecialchars($_POST['HoTen'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="NgaySinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required value="<?= htmlspecialchars($_POST['NgaySinh'] ?? '') ?>">
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
                                            <input type="tel" class="form-control" id="SDT" name="SDT" required value="<?= htmlspecialchars($_POST['SDT'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="Email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($_POST['Email'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="MaGoiTap" class="form-label">Gói tập <span class="text-danger">*</span></label>
                                            <select class="form-select" id="MaGoiTap" name="MaGoiTap" required>
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
                                    <div class="d-flex justify-content-between">
                                        <a href="/gym/admin/user" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
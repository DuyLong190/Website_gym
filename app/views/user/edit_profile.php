<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin-left: 15%;
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
        }

        .edit-header {
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .edit-form {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #666;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
        }

        .btn-save {
            background: linear-gradient(90deg, #6366f1 0%, #a21caf 100%);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background: linear-gradient(90deg, #a21caf 0%, #6366f1 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #666;
            border: 1px solid #ddd;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #e9ecef;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="edit-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Chỉnh sửa thông tin cá nhân</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="edit-form">
                    <form action="/gym/user/update_profile" method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="<?php echo htmlspecialchars($hoiVien->HoTen ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="NgaySinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required 
                                value="<?php echo htmlspecialchars($hoiVien->NgaySinh ?? ''); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="GioiTinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <select class="form-select" id="GioiTinh" name="GioiTinh" required>
                                <option value="">Chọn giới tính</option>
                                <option value="Nam" <?php echo ($hoiVien->GioiTinh === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?php echo ($hoiVien->GioiTinh === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                <option value="Khác" <?php echo ($hoiVien->GioiTinh === 'Khác') ? 'selected' : ''; ?>>Khác</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="SDT" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="SDT" name="SDT"
                                value="<?php echo htmlspecialchars($hoiVien->SDT ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="Email"
                                value="<?php echo htmlspecialchars($hoiVien->Email ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="DiaChi" rows="3"><?php echo htmlspecialchars($hoiVien->DiaChi ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="/gym/user/profile" class="btn btn-cancel">Hủy</a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
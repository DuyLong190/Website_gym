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
            background: #f8f9fa;
            min-height: 100vh;
            padding: 0;
            margin-top: -6rem;
            margin-left: 15%;
            
        }

        .edit-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .edit-form {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn-save {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            color: #4f46e5;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="edit-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="mb-0">Chỉnh sửa thông tin cá nhân</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="edit-form">
                    <form action="/gym/user/update_profile" method="POST">
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-user me-2"></i>Thông tin cơ bản
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="fullname" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        value="<?php echo htmlspecialchars($hoiVien->HoTen ?? ''); ?>">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="NgaySinh" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                                        value="<?php echo htmlspecialchars($hoiVien->NgaySinh ?? ''); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="GioiTinh" class="form-label">Giới tính</label>
                                    <select class="form-select" id="GioiTinh" name="GioiTinh">
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam" <?php echo ($hoiVien->GioiTinh === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo ($hoiVien->GioiTinh === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                        <option value="Khác" <?php echo ($hoiVien->GioiTinh === 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="SDT" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="SDT" name="SDT"
                                        value="<?php echo htmlspecialchars($hoiVien->SDT ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-chart-line me-2"></i>Thông tin thể chất
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="ChieuCao" class="form-label">Chiều cao (cm)</label>
                                    <input type="number" class="form-control" id="ChieuCao" name="ChieuCao"
                                        value="<?php echo htmlspecialchars($hoiVien->ChieuCao ?? ''); ?>">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="CanNang" class="form-label">Cân nặng (kg)</label>
                                    <input type="number" class="form-control" id="CanNang" name="CanNang"
                                        value="<?php echo htmlspecialchars($hoiVien->CanNang ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-address-card me-2"></i>Thông tin liên hệ
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="Email"
                                    value="<?php echo htmlspecialchars($hoiVien->Email ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control" id="address" name="DiaChi" rows="3"><?php echo htmlspecialchars($hoiVien->DiaChi ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="/gym/user/profile" class="btn btn-cancel">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
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
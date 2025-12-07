<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin huấn luyện viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e1b4b);
            min-height: 100vh;
            color: #e2e8f0;
        }

        .pt-wrapper {
            margin-left: calc(5.5rem + 2rem);
            padding: 2rem 2rem;
            min-height: 100vh;
        }

        .card-form {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 25px 50px rgba(15, 23, 42, 0.5);
            padding: 30px;
        }

        .card-form h2 {
            font-weight: 600;
            letter-spacing: 1px;
        }

        .form-label {
            color: #94a3b8;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f97316;
            box-shadow: none;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #f97316, #e11d48);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        @media (max-width: 991px) {
            .pt-wrapper {
                margin-left: 0;
                padding: 8rem 1rem 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="pt-wrapper">
        <div class="container-fluid">
            <div class="card-form">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1 text-white"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Cập nhật thông tin</h2>
                        <p class="text-white-50 mb-0">Cập nhật hồ sơ để học viên luôn có thông tin chính xác</p>
                    </div>
                    <a href="/gym/pt" class="btn btn-outline-light rounded-pill"><i class="fa-solid fa-arrow-left-long me-2"></i>Quay về hồ sơ</a>
                </div>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="/gym/pt/update" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="HoTen" class="form-control" value="<?= htmlspecialchars($pt->HoTen ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="NgaySinh" class="form-control" value="<?= !empty($pt->NgaySinh) ? date('Y-m-d', strtotime($pt->NgaySinh)) : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giới tính</label>
                        <select name="GioiTinh" class="form-select">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" <?= ($pt->GioiTinh ?? '') === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?= ($pt->GioiTinh ?? '') === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?= ($pt->GioiTinh ?? '') === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($pt->SDT ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($pt->Email ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars($pt->DiaChi ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chuyên môn</label>
                        <input type="text" name="ChuyenMon" class="form-control" value="<?= htmlspecialchars($pt->ChuyenMon ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kinh nghiệm (năm)</label>
                        <input type="number" min="0" name="KinhNghiem" class="form-control" value="<?= htmlspecialchars($pt->KinhNghiem ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Lương mong muốn (VNĐ)</label>
                        <input type="number" min="0" step="100000" name="Luong" class="form-control" value="<?= htmlspecialchars($pt->Luong ?? ''); ?>">
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <button type="submit" class="btn btn-gradient"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

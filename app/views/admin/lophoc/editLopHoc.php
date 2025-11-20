<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            margin-left: 15%;
        }

        .admin-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: none;
            background: #fff;
            padding: 2rem;
        }

        .admin-title {
            color: #6366f1;
            font-weight: 800;
            font-size: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 100%);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #64748b;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        @media (max-width: 768px) {
            .admin-title {
                font-size: 1.3rem;
            }

            body {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="admin-card">
                    <h1 class="text-center mb-4 admin-title">
                        <i class="fa-solid fa-dumbbell me-2"></i>Sửa lớp học
                    </h1>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php
                    $ngayBatDauValue = '';
                    if (!empty($lophoc->NgayBatDau)) {
                        $ts = strtotime($lophoc->NgayBatDau);
                        if ($ts) {
                            $ngayBatDauValue = date('Y-m-d\TH:i', $ts);
                        }
                    }

                    $ngayKetThucValue = '';
                    if (!empty($lophoc->NgayKetThuc)) {
                        $ts2 = strtotime($lophoc->NgayKetThuc);
                        if ($ts2) {
                            $ngayKetThucValue = date('Y-m-d\TH:i', $ts2);
                        }
                    }
                    ?>
                    <form method="POST" action="/gym/admin/lophoc/updateLopHoc">

                        <input type="hidden" name="MaLop" value="<?php echo htmlspecialchars($lophoc->MaLop, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-4">
                            <label for="TenLop" class="form-label">Tên lớp học</label>
                            <input type="text" name="TenLop" id="TenLop" class="form-control" value="<?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="GiaTien" class="form-label">Giá</label>
                            <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="0.01" value="<?php echo htmlspecialchars($lophoc->GiaTien); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="NgayBatDau" class="form-label">Ngày Bắt đầu</label>
                            <input type="datetime-local" name="NgayBatDau" id="NgayBatDau" class="form-control" value="<?php echo $ngayBatDauValue; ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="NgayKetThuc" class="form-label">Ngày Kết thúc</label>
                            <input type="datetime-local" name="NgayKetThuc" id="NgayKetThuc" class="form-control" value="<?php echo $ngayKetThucValue; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="MoTa" class="form-label">Mô tả</label>
                            <textarea name="MoTa" id="MoTa" class="form-control" rows="4"><?php echo htmlspecialchars($lophoc->MoTa ?? ''); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between mt-5">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                            <a href="/gym/admin/lophoc" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa dịch vụ thư giãn</title>
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
                        <i class="fa-solid fa-spa me-2"></i>Sửa dịch vụ thư giãn
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
                    <form method="POST" action="/gym/admin/DvThuGian/updateDVTG" onsubmit="return validateForm()">
                        <input type="hidden" name="id" value="<?php echo $DVTG->id; ?>">
                        <div class="mb-4">
                            <label for="TenTG" class="form-label">Tên dịch vụ</label>
                            <input type="text" name="TenTG" id="TenTG" class="form-control" value="<?php echo htmlspecialchars($DVTG->TenTG, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="GiaTG" class="form-label">Giá</label>
                            <input type="number" name="GiaTG" id="GiaTG" class="form-control" step="0.01" value="<?php echo htmlspecialchars($DVTG->GiaTG); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="ThoiGianTG" class="form-label">Thời gian sử dụng (phút)</label>
                            <input type="text" name="ThoiGianTG" id="ThoiGianTG" class="form-control" value="<?php echo htmlspecialchars($DVTG->ThoiGianTG); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="MoTaTG" class="form-label">Mô tả</label>
                            <textarea name="MoTaTG" id="MoTaTG" class="form-control" rows="4"><?php echo htmlspecialchars($DVTG->MoTaTG ?? ''); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between mt-5">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                            <a href="/gym/admin/DvThuGian" class="btn btn-secondary">
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
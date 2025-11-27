<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5, #2563eb);
            --surface: #ffffff;
            --surface-muted: #f4f6fb;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --accent: #22c55e;
        }

        body {
            margin-left: 240px;
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at top right, #eef2ff, #e0e7ff 42%, #fff);
            color: var(--text-primary);
        }

        .page-wrapper {
            padding: 2.5rem 3rem 3rem;
        }

        .card-wrapper {
            background: var(--surface);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 25px 50px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-header p {
            margin: 0;
            color: var(--text-secondary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
            gap: 0.25rem;
        }

        .btn-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.85rem 1.6rem;
            font-weight: 600;
        }

        .btn-secondary {
            background: #0f172a;
            border: none;
            color: #fff;
            padding: 0.85rem 1.6rem;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.2);
        }

        .alert {
            border-radius: 16px;
            border: none;
            box-shadow: none;
            background: rgba(248, 113, 113, 0.15);
            color: #b91c1c;
        }

        @media (max-width: 960px) {
            body {
                margin-left: 0;
            }

            .page-wrapper {
                padding: 1.5rem;
            }

            .card-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="card-wrapper">
            <div class="page-header">
                <div>
                    <h1>
                        <i class="fas fa-edit"></i>
                        Sửa lớp học
                    </h1>
                    <p>Điều chỉnh thông tin lớp học và trạng thái hiển thị trong hệ thống.</p>
                </div>
                <?php if (!empty($lophoc->TrangThai)): ?>
                    <span class="status-pill <?php echo $lophoc->TrangThai === 'Đang mở' ? 'text-white' : ''; ?>" style="background: rgba(59, 130, 246, 0.15); color: var(--text-primary);">
                        <i class="fas fa-circle me-1" style="font-size:0.6rem"></i>
                        <?php echo htmlspecialchars($lophoc->TrangThai); ?>
                    </span>
                <?php endif; ?>
            </div>
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
                    $ngayBatDauValue = date('Y-m-d', $ts);
                }
            }

            $ngayKetThucValue = '';
            if (!empty($lophoc->NgayKetThuc)) {
                $ts2 = strtotime($lophoc->NgayKetThuc);
                if ($ts2) {
                    $ngayKetThucValue = date('Y-m-d', $ts2);
                }
            }
            ?>
            <form method="POST" action="/gym/admin/lophoc/updateLopHoc">
                <input type="hidden" name="MaLop" value="<?php echo htmlspecialchars($lophoc->MaLop, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-grid">
                    <div>
                        <label for="TenLop" class="form-label">Tên lớp học</label>
                        <input type="text" name="TenLop" id="TenLop" class="form-control" value="<?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div>
                        <label for="GiaTien" class="form-label">Giá</label>
                        <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="100000" value="<?php echo htmlspecialchars($lophoc->GiaTien); ?>" required>
                    </div>
                    <div>
                        <label for="NgayBatDau" class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="NgayBatDau" id="NgayBatDau" class="form-control" value="<?php echo $ngayBatDauValue; ?>" required>
                    </div>
                    <div>
                        <label for="NgayKetThuc" class="form-label">Ngày kết thúc</label>
                        <input type="date" name="NgayKetThuc" id="NgayKetThuc" class="form-control" value="<?php echo $ngayKetThucValue; ?>" required>
                    </div>
                    <div>
                        <label for="SoLuongToiDa" class="form-label">Số lượng tối đa</label>
                        <input type="number" name="SoLuongToiDa" id="SoLuongToiDa" class="form-control" value="<?php echo htmlspecialchars($lophoc->SoLuongToiDa); ?>" required>
                    </div>
                    <div>
                        <label for="TrangThai" class="form-label">Trạng thái</label>
                        <select class="form-select" id="TrangThai" name="TrangThai" required>
                            <option value="Đang mở" <?php echo ($lophoc->TrangThai ?? '') === 'Đang mở' ? 'selected' : '' ?>>Đang mở</option>
                            <option value="Đã kết thúc" <?php echo ($lophoc->TrangThai ?? '') === 'Đã kết thúc' ? 'selected' : '' ?>>Đã kết thúc</option>
                            <option value="Tạm ngưng" <?php echo ($lophoc->TrangThai ?? '') === 'Tạm ngưng' ? 'selected' : '' ?>>Tạm ngưng</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="MoTa" class="form-label">Mô tả</label>
                    <textarea name="MoTa" id="MoTa" class="form-control" rows="4"><?php echo htmlspecialchars($lophoc->MoTa ?? ''); ?></textarea>
                </div>
                <div class="btn-panel">
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
</body>

</html>
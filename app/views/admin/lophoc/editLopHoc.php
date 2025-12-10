<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa lớp học</title>
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
            --input-focus-color: #667eea;
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
            padding: 0.5rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
            max-width: 1000px;
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
            padding: 0.75rem 1.5rem;
            margin: 0 auto 0.75rem auto;
            box-shadow: var(--card-shadow);
            width: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .page-header h1 .icon-wrapper {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 i {
            font-size: 1.5rem;
            color: white;
        }

        .page-header h1 .title-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .page-header h1 .title-main {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
        }

        .admin-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            position: relative;
        }

        .card-header i {
            margin-right: 0.5rem;
            font-size: 1.3rem;
        }

        .card-body {
            padding: 1rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group.textarea-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group.textarea-group .form-label {
            min-width: auto;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
            min-width: 150px;
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .input-group-icon {
            position: relative;
            flex: 1;
        }

        .input-group-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .input-group-icon .form-control,
        .input-group-icon .form-select {
            padding-left: 2.75rem;
        }

        .input-group-icon .form-control:focus + i,
        .input-group-icon .form-select:focus + i {
            color: var(--primary-color);
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.5rem 0.875rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: #fafafa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--input-focus-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            background: #ffffff;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #c7d2fe;
            background: #ffffff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .form-group textarea.form-control {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .text-danger {
            color: #ef4444 !important;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .form-section {
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.25rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-title i {
            font-size: 1.2rem;
        }

        .btn-primary {
            background: var(--success-color);
            border: none;
            padding: 0.375rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            background: #059669;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.375rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 2px solid #f3f4f6;
        }

        .required-field {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 0.5rem 0.875rem;
            margin-bottom: 0.75rem;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 0.5rem;
            }

            .page-header {
                padding: 0.5rem 0.75rem;
                width: 100%;
            }

            .page-header h1 {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .page-header h1 .title-main {
                font-size: 1.25rem;
                white-space: normal;
                text-align: center;
            }

            .page-header h1 .icon-wrapper {
                width: 44px;
                height: 44px;
            }

            .page-header h1 .icon-wrapper i {
                font-size: 1.25rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-label {
                min-width: auto;
                margin-bottom: 0.5rem;
                width: 100%;
            }

            .input-group-icon {
                width: 100%;
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
                <div class="icon-wrapper">
                    <i class="fas fa-people-roof"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Sửa thông tin lớp học</span>
                </div>
            </h1>
        </div>
        <div class="card admin-card">
            <div class="card-header">
                <i class="fas fa-edit"></i>
                Thông tin lớp học
            </div>
            <div class="card-body">
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
                    
                    <!-- Thông tin cơ bản -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin cơ bản
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="TenLop" class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Tên lớp học <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <input type="text" name="TenLop" id="TenLop" class="form-control" value="<?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="Nhập tên lớp học">
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="GiaTien" class="form-label">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Giá (VNĐ) <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <input type="number" name="GiaTien" id="GiaTien" class="form-control" step="100000" value="<?php echo htmlspecialchars($lophoc->GiaTien); ?>" required placeholder="Nhập giá tiền">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin thời gian -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-calendar-alt"></i>
                            Thông tin thời gian
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="NgayBatDau" class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    Ngày bắt đầu <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <input type="date" name="NgayBatDau" id="NgayBatDau" class="form-control" value="<?php echo $ngayBatDauValue; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="NgayKetThuc" class="form-label">
                                    <i class="fas fa-calendar-times"></i>
                                    Ngày kết thúc <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <input type="date" name="NgayKetThuc" id="NgayKetThuc" class="form-control" value="<?php echo $ngayKetThucValue; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin khác -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-cog"></i>
                            Thông tin khác
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="SoLuongToiDa" class="form-label">
                                    <i class="fas fa-users"></i>
                                    Số lượng tối đa <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <input type="number" name="SoLuongToiDa" id="SoLuongToiDa" class="form-control" value="<?php echo htmlspecialchars($lophoc->SoLuongToiDa); ?>" required placeholder="Nhập số lượng tối đa">
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="TrangThai" class="form-label">
                                    <i class="fas fa-toggle-on"></i>
                                    Trạng thái <span class="required-field">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <select class="form-select" id="TrangThai" name="TrangThai" required>
                                        <option value="Đang mở" <?php echo ($lophoc->TrangThai ?? '') === 'Đang mở' ? 'selected' : '' ?>>Đang mở</option>
                                        <option value="Đã kết thúc" <?php echo ($lophoc->TrangThai ?? '') === 'Đã kết thúc' ? 'selected' : '' ?>>Đã kết thúc</option>
                                        <option value="Tạm ngưng" <?php echo ($lophoc->TrangThai ?? '') === 'Tạm ngưng' ? 'selected' : '' ?>>Tạm ngưng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group textarea-group">
                                    <label for="MoTa" class="form-label">
                                        <i class="fas fa-align-left"></i>
                                        Mô tả
                                    </label>
                                    <textarea name="MoTa" id="MoTa" class="form-control" rows="4" placeholder="Nhập mô tả lớp học"><?php echo htmlspecialchars($lophoc->MoTa ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="/gym/admin/lophoc" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validate ngày kết thúc phải lớn hơn ngày bắt đầu
        document.addEventListener('DOMContentLoaded', function() {
            var startInput = document.getElementById('NgayBatDau');
            var endInput = document.getElementById('NgayKetThuc');
            var form = document.querySelector('form');

            function validateDates() {
                if (!startInput.value || !endInput.value) {
                    endInput.setCustomValidity('');
                    return;
                }

                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                if (endDate <= startDate) {
                    endInput.setCustomValidity('Ngày kết thúc phải lớn hơn ngày bắt đầu');
                } else {
                    endInput.setCustomValidity('');
                }
            }

            startInput.addEventListener('change', validateDates);
            endInput.addEventListener('change', validateDates);

            form.addEventListener('submit', function(e) {
                validateDates();
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });
    </script>
</body>

</html>

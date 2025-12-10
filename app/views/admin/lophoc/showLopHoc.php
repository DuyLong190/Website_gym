<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --success-color: #10b981;
            --info-color: #3b82f6;
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
            padding: 0.5rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
            max-width: 1100px;
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
            gap: 0.75rem;
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

        .user-detail-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .user-detail-header {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.25rem;
            border: none;
        }

        .user-detail-header h4 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.3rem;
        }

        .user-detail-header h4 i {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .info-section {
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.15rem;
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
            font-size: 1.3rem;
        }

        .info-item {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: #fafafa;
            border-radius: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
            min-width: 150px;
        }

        .info-label i {
            color: var(--primary-color);
            font-size: 0.9rem;
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

        .info-value {
            color: #1f2937;
            font-size: 1.15rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-align: right;
            flex: 1;
            justify-content: flex-end;
        }

        .info-value i {
            color: #9ca3af;
            font-size: 1rem;
        }

        .status-badge {
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pause {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancel {
            background: #fee2e2;
            color: #991b1b;
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

        .action-buttons {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 2px solid #f3f4f6;
        }

        .empty-value {
            color: #9ca3af;
            font-style: italic;
        }

        .progress-bar-container {
            margin-top: 0.75rem;
            background: #e5e7eb;
            border-radius: 10px;
            height: 12px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--success-color);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .page-header {
                padding: 0.75rem 1rem;
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

            .info-item {
                padding: 0.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 0.5rem;
            }

            .info-value {
                text-align: left;
                justify-content: flex-start;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <?php
            $soDangKy = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
            $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
            $remaining = ($max > 0) ? max($max - $soDangKy, 0) : null;
            $fillPercent = ($max > 0) ? min(100, (int)round(($soDangKy / $max) * 100)) : 0;
            $startDate = $lophoc->NgayBatDau ? new DateTimeImmutable($lophoc->NgayBatDau) : null;
            $endDate = $lophoc->NgayKetThuc ? new DateTimeImmutable($lophoc->NgayKetThuc) : null;
            $statusText = $lophoc->TrangThai ?? 'Chưa xác định';
            $statusClassMap = [
                'Đang mở' => 'status-active',
                'Đã kết thúc' => 'status-cancel',
                'Tạm ngưng' => 'status-pause',
            ];
            $statusClass = $statusClassMap[$statusText] ?? 'status-cancel';
            $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có PT';
            ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-people-roof"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Chi tiết lớp học</span>
                    </div>
                </h1>
            </div>
            <div class="card user-detail-card">
                <div class="user-detail-header">
                    <h4>
                        <i class="fas fa-people-roof"></i>
                        Thông tin lớp học
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin cơ bản -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin cơ bản
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-tag"></i>
                                        Tên lớp học
                                    </div>
                                    <div class="info-value">
                                        <?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Giá
                                    </div>
                                    <div class="info-value">
                                        <?php echo number_format($lophoc->GiaTien, 0, ',', '.'); ?> VNĐ
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-user-tie"></i>
                                        PT phụ trách
                                    </div>
                                    <div class="info-value">
                                        <?php echo htmlspecialchars($tenPT, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-toggle-on"></i>
                                        Trạng thái
                                    </div>
                                    <div class="info-value">
                                        <span class="status-badge <?php echo $statusClass; ?>">
                                            <i class="fas fa-circle"></i>
                                            <?php echo htmlspecialchars($statusText, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin thời gian -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-calendar-alt"></i>
                            Thông tin thời gian
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-calendar-check"></i>
                                        Ngày bắt đầu
                                    </div>
                                    <div class="info-value">
                                        <?php echo $startDate ? $startDate->format('d/m/Y') : '<span class="empty-value">Chưa cập nhật</span>'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-calendar-times"></i>
                                        Ngày kết thúc
                                    </div>
                                    <div class="info-value">
                                        <?php echo $endDate ? $endDate->format('d/m/Y') : '<span class="empty-value">Chưa cập nhật</span>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin sĩ số -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-users"></i>
                            Thông tin sĩ số
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-user-check"></i>
                                        Đã đăng ký
                                    </div>
                                    <div class="info-value">
                                        <?php echo htmlspecialchars((string)$soDangKy, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-user-slash"></i>
                                        Còn trống
                                    </div>
                                    <div class="info-value">
                                        <?php echo $remaining === null ? '<span class="empty-value">-</span>' : htmlspecialchars((string)$remaining, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-users-cog"></i>
                                        Sĩ số tối đa
                                    </div>
                                    <div class="info-value">
                                        <?php echo $max ? htmlspecialchars((string)$max, ENT_QUOTES, 'UTF-8') : '<span class="empty-value">Chưa cập nhật</span>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($max > 0): ?>
                            <div class="progress-bar-container mt-3">
                                <div class="progress-bar-fill" style="width: <?php echo $fillPercent; ?>%;"></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Mô tả -->
                    <?php if (!empty($lophoc->MoTa)): ?>
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-align-left"></i>
                                Mô tả
                            </div>
                            <div class="info-item">
                                <div class="info-value" style="text-align: left; justify-content: flex-start; width: 100%;">
                                    <?php echo nl2br(htmlspecialchars($lophoc->MoTa, ENT_QUOTES, 'UTF-8')); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <a href="/gym/admin/lophoc" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Không tìm thấy lớp học</span>
                    </div>
                </h1>
            </div>
            <div class="card user-detail-card">
                <div class="card-body">
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-exclamation-circle fa-3x mb-2"></i>
                        <p>Vui lòng quay lại danh sách để chọn lớp học khác.</p>
                        <a href="/gym/admin/lophoc" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

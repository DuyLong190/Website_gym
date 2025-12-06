<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết Hội viên</title>
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
            padding: 1rem;
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
            padding: 1rem 2rem;
            margin: 0 auto 1rem auto;
            box-shadow: var(--card-shadow);
            width: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.1);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
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

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .user-detail-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
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
            gap: 0.75rem;
            font-size: 1.3rem;
        }

        .user-detail-header h4 i {
            font-size: 1.5rem;
        }

        .info-section {
            border-bottom: 2px solid #f3f4f6;
        }

        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-item {
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            background: #fafafa;
            border-radius: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
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

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .badge i {
            font-size: 0.85rem;
        }

        .btn-primary {
            background: var(--info-color);
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
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
                padding: 1rem;
            }

            .info-item {
                padding: 0.75rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 0.5rem;
            }

            .info-value {
                text-align: right;
                justify-content: flex-start;
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
                    <i class="fas fa-user"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Thông tin hội viên</span>
                </div>
            </h1>
        </div>
        <div class="card user-detail-card">
            <div class="user-detail-header">
                <h4>
                    <i class="fas fa-user-circle"></i>
                    Thông tin cá nhân
                </h4>
            </div>
            <div class="card-body">
                <!-- Thông tin cá nhân -->
                <div class="info-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user"></i>
                                    Họ và tên: 
                                </div>
                                <div class="info-value">
                                    <?= htmlspecialchars($hoiVien->HoTen) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Ngày sinh: 
                                </div>
                                <div class="info-value">
                                    <?php
                                    $ngaySinh = $hoiVien->NgaySinh ?? '';
                                    echo $ngaySinh ? date('d/m/Y', strtotime($ngaySinh)) : '<span class="empty-value">Chưa cập nhật</span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Giới tính: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->GioiTinh) ? htmlspecialchars((string)$hoiVien->GioiTinh) : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>
                                    Số điện thoại: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->SDT) ? htmlspecialchars((string)$hoiVien->SDT) : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin thể chất -->
                <div class="info-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-ruler-vertical"></i>
                                    Chiều cao: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->ChieuCao) ? htmlspecialchars((string)$hoiVien->ChieuCao) . ' cm' : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-weight"></i>
                                    Cân nặng: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->CanNang) ? htmlspecialchars((string)$hoiVien->CanNang) . ' kg' : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin liên hệ -->
                <div class="info-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope"></i>
                                    Email: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->Email) ? htmlspecialchars((string)$hoiVien->Email) : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Địa chỉ: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->DiaChi) ? htmlspecialchars((string)$hoiVien->DiaChi) : '<span class="empty-value">Chưa cập nhật</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin gói tập & Trạng thái -->
                <div class="info-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-ticket-alt"></i>
                                    Gói tập: 
                                </div>
                                <div class="info-value">
                                    <?= !empty($hoiVien->TenGoiTap) ? htmlspecialchars($hoiVien->TenGoiTap) : '<span class="empty-value">Chưa đăng ký</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-toggle-on"></i>
                                    Trạng thái: 
                                </div>
                                <div class="info-value">
                                    <span class="status-badge <?= $hoiVien->TrangThai === 'Đang hoạt động' ? 'status-active' : ($hoiVien->TrangThai === 'Tạm ngưng' ? 'status-pause' : 'status-cancel') ?>">
                                        <i class="fas fa-circle"></i>
                                        <?= htmlspecialchars($hoiVien->TrangThai) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($currentCtgt) && is_array($currentCtgt)): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-info-circle"></i>
                                        Trạng thái gói tập: 
                                    </div>
                                    <div class="info-value">
                                        <?= !empty($currentCtgt['TrangThai']) ? htmlspecialchars((string)$currentCtgt['TrangThai']) : '<span class="empty-value">Chưa có thông tin</span>' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Thanh toán: 
                                    </div>
                                    <div class="info-value">
                                        <?php
                                        $daThanhToan = (int)($currentCtgt['DaThanhToan'] ?? 0);
                                        $trangThaiCt = $currentCtgt['TrangThai'] ?? '';
                                        if ($daThanhToan === 1) {
                                            echo '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Đã thanh toán</span>';
                                        } else {
                                            // Hiển thị badge trạng thái hiện tại
                                            if ($trangThaiCt === 'Chờ xác minh') {
                                                echo '<span class="badge bg-warning text-dark me-2"><i class="fas fa-clock"></i> Chờ xác minh</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary me-2"><i class="fas fa-times-circle"></i> Chưa thanh toán</span>';
                                            }

                                            // Luôn hiển thị nút xác minh cho admin khi chưa thanh toán
                                            $id_ctgt = $currentCtgt['id_ctgt'] ?? null;
                                            if ($id_ctgt !== null): ?>
                                                <form method="post" action="/gym/admin/user/verifyPayment/<?= htmlspecialchars((string)$id_ctgt) ?>" style="display:inline-block; margin-top: 0.5rem;">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-check me-1"></i>Xác minh thanh toán
                                                    </button>
                                                </form>
                                            <?php endif;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar-check"></i>
                                    Ngày đăng ký: 
                                </div>
                                <div class="info-value">
                                    <?= date('d/m/Y H:i', strtotime($hoiVien->NgayDangKy)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="/gym/admin/user" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
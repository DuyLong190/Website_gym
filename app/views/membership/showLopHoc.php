<?php include_once __DIR__ . '/../share/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #d8e1eb;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem 0;
        }

        .page-header {
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease-out;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .detail-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: none;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
        }

        .detail-card-header {
            background: linear-gradient(135deg, #0f4c75 0%, #3282b8 100%);
            padding: 1.5rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .detail-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 1rem 0;
            position: relative;
            z-index: 1;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .card-title i {
            font-size: 1.8rem;
            margin-right: 0.75rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .instructor-info {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.95);
            margin-top: 0.5rem;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .instructor-info i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .price-section {
            background: linear-gradient(135deg, #3282b8 0%, #0f4c75 100%);
            padding: 1.25rem;
            border-radius: 15px;
            margin: 1.5rem 0;
            text-align: center;
            box-shadow: 0 10px 30px rgba(15, 76, 117, 0.3);
            position: relative;
            overflow: hidden;
        }

        .price-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
        }

        .price-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        .price-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .detail-item {
            margin-bottom: 1.25rem;
            padding: 1rem;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            border-radius: 12px;
            border-left: 4px solid #3282b8;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(50, 130, 184, 0.2);
            border-left-width: 6px;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: #3282b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .detail-label i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #2d3748;
            line-height: 1.8;
            font-weight: 500;
        }

        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .date-item {
            background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid #3282b8;
            transition: all 0.3s ease;
            text-align: center;
        }

        .date-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(50, 130, 184, 0.2);
            border-color: #0f4c75;
        }

        .date-item .small {
            font-size: 0.85rem;
            color: #3282b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .date-item .fw-medium {
            font-size: 1.1rem;
            color: #0f4c75;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            flex: 1;
            min-width: 120px;
            font-weight: 600;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 767px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .price-value {
                font-size: 2rem;
            }

            .detail-card-body {
                padding: 1rem;
            }

            .date-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="page-header text-center">
            <h1>Chi tiết lớp học</h1>
        </div>

        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9">
                    <div class="card detail-card">
                        <div class="detail-card-header">
                            <h2 class="card-title">
                                <i class="fas fa-people-roof me-2 text-primary"></i>
                                <?= htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>
                            <div class="instructor-info">
                                <i class="fas fa-user-tie me-1"></i>
                                Huấn luyện viên: <?= htmlspecialchars($lophoc->TenPT ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                        <div class="detail-card-body">
                            <div class="price-section">
                                <div class="price-label">Giá lớp học</div>
                                <div class="price-value">
                                    <?= number_format($lophoc->GiaTien, 0, ',', '.'); ?> VNĐ
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar me-1"></i>Thời gian
                                </div>
                                <div class="date-row">
                                    <div class="date-item">
                                        <div class="small text-muted mb-1">Ngày bắt đầu</div>
                                        <div class="fw-medium"><?= htmlspecialchars($lophoc->NgayBatDau, ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                    <div class="date-item">
                                        <div class="small text-muted mb-1">Ngày kết thúc</div>
                                        <div class="fw-medium"><?= htmlspecialchars($lophoc->NgayKetThuc, ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($lophoc->MoTa)): ?>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-info-circle me-1"></i>Mô tả
                                    </div>
                                    <div class="detail-value">
                                        <?= nl2br(htmlspecialchars($lophoc->MoTa, ENT_QUOTES, 'UTF-8')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($lophoc->SoLuongToiDa)): ?>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-users me-1"></i>Số lượng học viên
                                    </div>
                                    <div class="detail-value">
                                        <?php
                                        $soLuongHienTai = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                        $soLuongToiDa = (int)$lophoc->SoLuongToiDa;
                                        $conLai = max($soLuongToiDa - $soLuongHienTai, 0);
                                        ?>
                                        <div class="mb-2">
                                            <strong>Đã đăng ký:</strong> <?= $soLuongHienTai; ?> / <?= $soLuongToiDa; ?> học viên
                                        </div>
                                        <?php if ($conLai > 0): ?>
                                            <div class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                <strong>Còn lại:</strong> <?= $conLai; ?> chỗ trống
                                            </div>
                                        <?php else: ?>
                                            <div class="text-danger">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                <strong>Đã đầy</strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end mt-4 pt-4 border-top">
                                <div class="action-buttons">
                                    <a href="/gym/lophoc" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Không tìm thấy thông tin lớp học.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function registerClass(maLop) {
            try {
                const response = await fetch('/gym/api/dangkylophoc', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        MaLop: maLop
                    })
                });
                let result = {};
                try {
                    result = await response.json();
                } catch (e) {
                    result = {};
                }
                if (response.status === 401) {
                    alert(result.message || 'Vui lòng đăng nhập để đăng ký lớp học');
                    window.location.href = '/gym/account/login';
                    return;
                }
                if (response.ok && result.success) {
                    alert(result.message || 'Đăng ký thành công');
                    window.location.href = '/gym/user/lichlophoc?MaLop=' + encodeURIComponent(maLop);
                    return;
                }
                if (result.errors) {
                    if (result.errors.exists) {
                        alert(result.errors.exists);
                        return;
                    }
                    if (result.errors.full) {
                        alert(result.errors.full);
                        return;
                    }
                }
                alert(result.message || 'Đăng ký lớp học thất bại');
            } catch (e) {
                alert('Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    </script>
</body>

</html>
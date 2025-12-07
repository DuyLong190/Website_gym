<?php include_once __DIR__ . '/../share/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #bdbdbd;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .card-title i {
            font-size: 1.8rem;
            margin-right: 0.75rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .price-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 1.25rem;
            border-radius: 15px;
            margin: 1.5rem 0;
            text-align: center;
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
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
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
            border-left-width: 6px;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
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

        .btn-back {
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
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

        @media (max-width: 768px) {
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
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="page-header text-center">
            <h1>Chi tiết gói tập</h1>
        </div>

        <?php if (isset($goiTap) && is_object($goiTap)): ?>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card detail-card">
                        <div class="detail-card-header">
                            <h2 class="card-title">
                                <i class="fas fa-ticket-alt me-2 text-primary"></i>
                                <?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>
                        </div>
                        <div class="detail-card-body">
                            <div class="price-section">
                                <div class="price-label">Giá gói tập</div>
                                <div class="price-value">
                                    <?php echo number_format($goiTap->GiaTien, 0, ',', '.'); ?> VNĐ
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Thời hạn
                                </div>
                                <div class="detail-value">
                                    <?php echo htmlspecialchars($goiTap->ThoiHan, ENT_QUOTES, 'UTF-8'); ?> ngày
                                </div>
                            </div>

                            <?php if (!empty($goiTap->MoTa)): ?>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-info-circle me-1"></i>Mô tả
                                    </div>
                                    <div class="detail-value">
                                        <?php echo nl2br(htmlspecialchars($goiTap->MoTa, ENT_QUOTES, 'UTF-8')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end mt-4 pt-4 border-top">
                                <a href="/gym/goitap" class="btn btn-outline-secondary btn-back">
                                    <i class="fas fa-arrow-left me-2"></i> Quay lại
                                </a>
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
                        Không tìm thấy thông tin gói tập.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
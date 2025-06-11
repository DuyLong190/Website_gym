<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #22c55e;
            --background-color: #f8fafc;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #475569;
        }

        body {
            background: linear-gradient(135deg, var(--background-color) 0%, #dbeafe 100%);
            font-family: 'Segoe UI', sans-serif;
            margin-left: 15%;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .container {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .package-detail-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background-color: var(--card-background);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .package-detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .price-badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 2rem;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .price-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 1.5rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-label i {
            color: var(--primary-color);
        }

        .detail-value {
            color: var(--text-secondary);
            white-space: pre-line;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 8px;
            margin-top: 0.5rem;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .btn-back {
            min-width: 140px;
            font-weight: 600;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #475569 100%);
            border: none;
            color: white;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(71, 85, 105, 0.3);
            color: white;
        }

        h1.title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin: 2rem auto;
            max-width: 600px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .package-detail-card {
                margin: 0 1rem;
            }

            h1.title {
                font-size: 2rem;
            }

            .card-title {
                font-size: 1.75rem;
            }

            .price-badge {
                font-size: 1.1rem;
                padding: 0.8rem 1.5rem;
            }

            .detail-value {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h1 class="text-center mb-4 title">
            <i class="fas fa-dumbbell me-2"></i>Chi tiết gói tập
        </h1>

        <?php if (isset($goiTap) && is_object($goiTap)): ?>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="package-detail-card">
                        <div class="card-body p-4">
                            <h2 class="card-title">
                                <i class="fas fa-box-open me-2 text-success"></i>
                                <?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>

                            <div class="price-badge">
                                <i class="fas fa-money-check me-2"></i>
                                <?php echo number_format($goiTap->GiaTien, 0, ',', '.'); ?> VNĐ
                            </div>

                            <div class="detail-label">
                                <i class="fas fa-calendar-alt"></i>
                                Thời hạn
                            </div>
                            <div class="detail-value">
                                <?php echo htmlspecialchars($goiTap->ThoiHan, ENT_QUOTES, 'UTF-8'); ?> tháng
                            </div>

                            <div class="detail-label">
                                <i class="fas fa-info-circle"></i>
                                Mô tả
                            </div>
                            <div class="detail-value">
                                <?php echo nl2br(htmlspecialchars($goiTap->MoTa ?? '', ENT_QUOTES, 'UTF-8')); ?>
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="/gym/admin/goitap" class="btn btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Không tìm thấy thông tin gói tập.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
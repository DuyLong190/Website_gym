<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .package-detail-card {
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
            background-color: #fff;
            padding: 2rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
        }

        .price-badge {
            background: linear-gradient(90deg, #0d6efd, #0dcaf0);
            color: white;
            font-weight: bold;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 1.2rem;
            font-size: 1.1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #0f172a;
            margin-top: 1rem;
        }

        .detail-value {
            color: #334155;
            white-space: pre-line;
        }

        .btn-back {
            min-width: 120px;
            font-weight: 500;
        }

        h1.title {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <h1 class="text-center mb-4 title">
            <i class="fas fa-dumbbell me-2"></i>Chi tiết gói tập
        </h1>

        <?php if (isset($goiTap) && is_object($goiTap)): ?>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card package-detail-card">
                        <div class="card-body">
                            <h2 class="card-title mb-3">
                                <i class="fas fa-box-open me-2 text-success"></i>
                                <?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>

                            <div class="price-badge mb-3">
                                <i class="fas fa-money-check me-1"></i>
                                <?php echo number_format($goiTap->GiaTien, 0, ',', '.'); ?> VNĐ
                            </div>

                            <div class="detail-label">
                                <i class="fas fa-calendar-alt me-1"></i>Thời hạn:
                            </div>
                            <div class="detail-value">
                                <?php echo htmlspecialchars($goiTap->ThoiHan, ENT_QUOTES, 'UTF-8'); ?> ngày
                            </div>

                            <div class="detail-label">
                                <i class="fas fa-info-circle me-1"></i>Mô tả:
                            </div>
                            <div class="detail-value">
                                <?php echo nl2br(htmlspecialchars($goiTap->MoTa ?? '', ENT_QUOTES, 'UTF-8')); ?>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="/gym/admin/goitap" class="btn btn-outline-primary btn-back">
                                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không tìm thấy thông tin gói tập.</div>
        <?php endif; ?>
    </div>
</body>

</html>
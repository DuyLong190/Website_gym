<?php include_once __DIR__ . '/../share/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #c7f5d6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .detail-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .detail-card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .price-section {
            background-color: #f8f9fa;
            padding: 1rem 1.25rem;
            border-radius: 6px;
            margin: 1.5rem 0;
        }

        .price-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .price-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #28a745;
        }

        .detail-item {
            margin-bottom: 1.5rem;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #212529;
            line-height: 1.6;
        }

        .btn-back {
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="page-header text-center">
            <h1>Chi tiết dịch vụ</h1>
        </div>

        <?php if (isset($DVTG) && is_object($DVTG)): ?>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card detail-card">
                        <div class="detail-card-header">
                            <h2 class="card-title">
                                <i class="fas fa-clover me-2 text-primary"></i>
                                <?php echo htmlspecialchars($DVTG->TenTG, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>
                        </div>
                        <div class="detail-card-body">
                            <div class="price-section">
                                <div class="price-label">Giá dịch vụ</div>
                                <div class="price-value">
                                    <?php echo number_format($DVTG->GiaTG, 0, ',', '.'); ?> VNĐ
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-clock me-1"></i>Thời hạn
                                </div>
                                <div class="detail-value">
                                    <?php echo htmlspecialchars($DVTG->ThoiGianTG, ENT_QUOTES, 'UTF-8'); ?> ngày
                                </div>
                            </div>

                            <?php if (!empty($DVTG->MoTaTG)): ?>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-info-circle me-1"></i>Mô tả
                                    </div>
                                    <div class="detail-value">
                                        <?php echo nl2br(htmlspecialchars($DVTG->MoTaTG, ENT_QUOTES, 'UTF-8')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <a href="/gym/dichvu" class="btn btn-outline-secondary btn-back">
                                    <i class="fas fa-arrow-left me-1"></i>
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
                        Không tìm thấy thông tin dịch vụ.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .package-detail-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(31, 38, 135, 0.08);
            border: none;
            padding: 2rem;
        }

        .price-badge {
            font-size: 1.2rem;
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5em 1.2em;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .detail-label {
            font-weight: 600;
            color: #2d3748;
        }

        .detail-value {
            color: #374151;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.8rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5 fw-bold text-primary">Chi tiết dịch vụ</h1>
        <?php if (isset($DVTG) && is_object($DVTG)): ?>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card package-detail-card">
                        <div class="card-body">
                            <h2 class="card-title mb-4">
                                <?php echo htmlspecialchars($DVTG->TenTG, ENT_QUOTES, 'UTF-8'); ?>
                            </h2>
                            <div class="price-badge">
                                <?php echo number_format($DVTG->GiaTG); ?> VNĐ
                            </div>
                            <div class="detail-label">Thời hạn:</div>
                            <div class="detail-value">
                                <?php echo htmlspecialchars($DVTG->ThoiGianTG, ENT_QUOTES, 'UTF-8'); ?> ngày
                            </div>
                            <div class="detail-label">Mô tả:</div>
                            <div class="detail-value">
                                <?php echo nl2br(htmlspecialchars($DVTG->MoTaTG ?? '', ENT_QUOTES, 'UTF-8')); ?>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="/gym/admin/DvThuGian" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không tìm thấy thông tin dịch vụ.</div>
        <?php endif; ?>
    </div>
</body>

</html>
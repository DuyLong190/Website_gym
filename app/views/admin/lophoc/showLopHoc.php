<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            margin-left: 15%;
        }

        .admin-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: none;
            background: #fff;
            padding: 2rem;
        }

        .admin-title {
            color: #6366f1;
            font-weight: 800;
            font-size: 2rem;
        }

        .price-badge {
            font-size: 1.2rem;
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
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
            margin-bottom: 0.5rem;
        }

        .detail-value {
            color: #374151;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 100%);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .admin-title {
                font-size: 1.3rem;
            }

            body {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-5 admin-title">
            <i class="fa-solid fa-dumbbell me-2"></i>Chi tiết lớp học
        </h1>
        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="admin-card">
                        <h2 class="card-title mb-4">
                            <?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>
                        </h2>
                        <div class="price-badge">
                            <?php echo number_format($lophoc->GiaTien); ?> VNĐ
                        </div>
                        <div class="detail-label">Ngày bắt đầu:</div>
                        <div class="detail-value">
                            <?php $NgayBD = $lophoc->NgayBatDau ?? '';
                            echo $NgayBD ? date('d/m/Y', strtotime($NgayBD)) : '';
                            ?>
                        </div>
                        <div class="detail-label">Ngày kết thúc:</div>
                        <div class="detail-value">
                            <?php $NgayKT = $lophoc->NgayKetThuc ?? '';
                            echo $NgayKT ? date('d/m/Y', strtotime($NgayKT)) : '';
                            ?>
                        </div>
                        <div class="detail-label">Mô tả:</div>
                        <div class="detail-value">
                            <?php echo nl2br(htmlspecialchars($lophoc->MoTa ?? '', ENT_QUOTES, 'UTF-8')); ?>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="/gym/admin/lophoc" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không tìm thấy thông tin lớp học.</div>
        <?php endif; ?>
    </div>
</body>

</html>
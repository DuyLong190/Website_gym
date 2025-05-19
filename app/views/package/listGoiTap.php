<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách gói tập</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .package-card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 24px;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(31, 38, 135, 0.08);
            border: none;
        }

        .package-card:hover {
            transform: translateY(-7px) scale(1.02);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }

        .price-badge {
            font-size: 1.1rem;
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.4em 1em;
            margin-bottom: 1em;
            display: inline-block;
        }

        .card-title {
            font-weight: 700;
            color: #2d3748;
        }

        .card-text {
            color: #374151;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-5 fw-bold text-primary">Danh sách gói tập</h1>
        <div class="mb-4 d-flex justify-content-end">
            <a href="goitap/add" class="btn btn-success btn-lg">
                <i class="fa fa-plus"></i> Thêm gói tập
            </a>
        </div>
        <?php if (!empty($goiTaps)): ?>
            <div class="row">
                <?php foreach ($goiTaps as $goiTap): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill">
                            <div class="card-body">
                                <h5 class="card-title mb-2"><?php echo htmlspecialchars($goiTap->TenGoiTap); ?></h5>
                                <span class="price-badge"><?php echo number_format($goiTap->GiaTien); ?> VNĐ</span>
                                <p class="card-text mb-1"><strong>Thời hạn:</strong> <?php echo htmlspecialchars($goiTap->ThoiHan); ?> ngày</p>
                                <p class="card-text mb-3"><?php echo htmlspecialchars($goiTap->MoTa); ?></p>
                                <a href="goitap/show/<?php echo $goiTap->MaGoiTap; ?>" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fa fa-info-circle"></i> Chi tiết
                                </a>
                                <div class="d-flex gap-2">
                                    <a href="/gym/goitap/edit/<?php echo $goiTap->MaGoiTap; ?>" class="btn btn-warning flex-fill">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <a href="/gym/goitap/delete/<?php echo $goiTap->MaGoiTap; ?>" class="btn btn-danger flex-fill"
                                        onclick="return confirm('Bạn có chắc muốn xóa gói tập này?');">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không có gói tập nào.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
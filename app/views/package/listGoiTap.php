<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách gói tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .package-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .price {
            font-size: 1.5rem;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Danh sách gói tập</h1>
        <?php if (!empty($goiTaps)): ?>
            <div class="row">
                <?php foreach ($goiTaps as $goiTap): ?>
                    <div class="col-md-4">
                        <div class="card package-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($goiTap->TenGoiTap); ?></h5>
                                <p class="price"><?php echo number_format($goiTap->GiaTien); ?> VNĐ</p>
                                <p class="card-text"><strong>Thời hạn:</strong> <?php echo htmlspecialchars($goiTap->ThoiHan); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($goiTap->MoTa); ?></p>
                                <a href="package/show/<?php echo $goiTap->MaGoiTap; ?>" class="btn btn-primary">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Không có gói tập nào.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
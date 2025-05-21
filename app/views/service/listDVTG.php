<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các dịch vụ thư giãn</title>

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

        .hero-section {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            position: relative;
            background-image: url('/Gym/public/images/banner.png');
            background-size: cover;
            background-position: center;
            width: 100vw;
            min-height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            border: 5px solid transparent;
            border-image: linear-gradient(deg, #ff4500, #ff8c00, #ff4500) 1;
            box-shadow:
                0 0 10px rgb(243, 73, 11),
                0 0 30px rgb(233, 124, 85),
                0 0 50px #ff8c00,
                0 0 70px rgb(235, 177, 107);
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class=" text-center">DỊCH VỤ THƯ GIÃN</h1>
            </div>
        </section>
        <div class="mb-4 d-flex justify-content-end">
            <a href="DvThuGian/add" class="btn btn-success btn-lg">
                <i class="fa fa-plus"></i> Thêm dịch vụ thư giãn
            </a>
        </div>
        <?php if (!empty($DVTGs)): ?>
            <div class="row">
                <?php foreach ($DVTGs as $DVTG): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill">
                            <div class="card-body">
                                <h5 class="card-title mb-2"><?php echo htmlspecialchars($DVTG->TenTG); ?></h5>
                                <span class="price-badge"><?php echo number_format($DVTG->GiaTG); ?> VNĐ</span>
                                <p class="card-text mb-1"><strong>Thời gian sử dụng:</strong> <?php echo htmlspecialchars($DVTG->ThoiGianTG); ?> phút</p>
                                <p class="card-text mb-3"><strong>Mô tả: </strong><?php echo htmlspecialchars($DVTG->MoTaTG); ?></p>
                                <a href="DvThuGian/show/<?php echo $DVTG->id; ?>" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fa fa-info-circle"></i> Chi tiết
                                </a>
                                <div class="d-flex gap-2">
                                    <a href="/gym/DvThuGian/edit/<?php echo $DVTG->id; ?>" class="btn btn-warning flex-fill">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <a href="/gym/DvThuGian/delete/<?php echo $DVTG->id; ?>" class="btn btn-danger flex-fill"
                                        onclick="return confirm('Bạn có chắc muốn xóa dịch vụ này?');">
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
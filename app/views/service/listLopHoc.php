<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lớp học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .package-card {
            padding: 25px;
            background: linear-gradient(135deg, rgba(45, 4, 0, 0.88), rgba(47, 45, 45, 0.96));
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 24px;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(31, 38, 135, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
        }

        .package-card:hover {
            transform: translateY(-7px) scale(1.02);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }

        .class-name {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #8f2121, #d94444);
            color: #fff;
            font-weight: 700;
            border-radius: 8px;
            padding: 0.6em 1em;
            margin-bottom: 1em;
            display: inline-block;
            text-align: center;
        }

        .class-price {
            font-size: 2rem;
            font-weight: bold;
            color: #ffb700;
            text-align: center;
            margin-bottom: 1rem;
        }

        .currency-symbol {
            font-size: 1rem;
            vertical-align: super;
        }

        .card-text {
            color: rgb(255, 255, 255);
            font-size: 0.95rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            gap: 8px;
        }

        .info-row i {
            color: #ffb700;
            width: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35em 0.7em;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .status-open {
            background-color: #28a745;
            color: white;
        }

        .status-closed {
            background-color: #dc3545;
            color: white;
        }

        .status-cancelled {
            background-color: #6c757d;
            color: white;
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
            box-shadow: 0 0 10px rgb(255, 255, 255), 0 0 30px rgb(253, 253, 253);
            border-radius: 10px;
        }

        .line-custom {
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 1rem 0;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
        }

        .btn-custom {
            flex: 1;
            padding: 0.6rem 0.8rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .btn-register {
            background-color: #ffb700;
            color: #000;
        }

        .btn-register:hover {
            background-color: #ffc922;
            color: #000;
        }

        .btn-detail {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid #fff;
        }

        .btn-detail:hover {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class="text-center"><i class="fas fa-chalkboard-user me-3"></i>LỚP HỌC</h1>
            </div>
        </section>

        <?php if (!empty($lophocs)): ?>
            <div class="row">
                <?php foreach ($lophocs as $lophoc): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <!-- Tên lớp học -->
                                <div class="class-name">
                                    <?php echo htmlspecialchars($lophoc->TenLop); ?>
                                </div>

                                <!-- Giá tiền -->
                                <div class="class-price">
                                    <?php echo number_format($lophoc->GiaTien); ?>
                                    <span class="currency-symbol">Đ</span>
                                </div>

                                <hr class="line-custom">

                                <!-- Thời gian khoá học -->
                                <div class="info-row">
                                    <i class="fas fa-calendar-days"></i>
                                    <span class="card-text">
                                        <strong>Bắt đầu:</strong>
                                        <?php echo date('d/m/Y', strtotime($lophoc->NgayBatDau)); ?>
                                    </span>
                                </div>

                                <div class="info-row">
                                    <i class="fas fa-calendar-check"></i>
                                    <span class="card-text">
                                        <strong>Kết thúc:</strong>
                                        <?php echo date('d/m/Y', strtotime($lophoc->NgayKetThuc)); ?>
                                    </span>
                                </div>

                                <!-- PT phụ trách -->
                                <div class="info-row">
                                    <i class="fas fa-user-tie"></i>
                                    <span class="card-text">
                                        <strong>Huấn luyện viên:</strong>
                                        <?php
                                        $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có';
                                        echo htmlspecialchars($tenPT);
                                        ?>
                                    </span>
                                </div>

                                <!-- Số lượng tối đa -->
                                <div class="info-row">
                                    <i class="fas fa-users"></i>
                                    <span class="card-text">
                                        <strong>Sỹ số tối đa:</strong>
                                        <?php echo isset($lophoc->SoLuongToiDa) ? htmlspecialchars($lophoc->SoLuongToiDa) : 'Không xác định'; ?>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <i class="fas fa-user-check"></i>
                                    <span class="card-text">
                                        <strong>Còn trống:</strong>
                                        <?php
                                        $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
                                        $reg = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                        $remaining = ($max > 0) ? max($max - $reg, 0) : null;
                                        if ($remaining === null) {
                                            echo '';
                                        } else {
                                            echo htmlspecialchars((string)$remaining);
                                        }
                                        ?>
                                    </span>

                                </div>

                                <!-- Mô tả -->
                                <?php if (!empty($lophoc->MoTa)): ?>
                                    <div class="info-row">
                                        <span class="card-text">
                                            <strong><i class="fas fa-note-sticky me-2"></i>Mô tả:</strong><br>
                                            <?php
                                            $moTa = htmlspecialchars($lophoc->MoTa);
                                            $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                            foreach ($cauArr as $cau) {
                                                if (!empty($cau)) {
                                                    echo '• ' . $cau . '.<br>';
                                                }
                                            }
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <hr class="line-custom">

                                <!-- Action buttons -->
                                <div class="action-buttons">
                                    <a href="javascript:void(0)" class="btn-custom btn-register" onclick="registerClass(<?php echo $lophoc->MaLop; ?>)">
                                        <i class="fas fa-pen-to-square me-1"></i>Đăng ký
                                    </a>
                                    <a href="/gym/lophoc/show/<?php echo $lophoc->MaLop; ?>" class="btn-custom btn-detail">
                                        <i class="fas fa-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center py-4">
                <i class="fas fa-inbox me-2"></i>Không có lớp học nào.
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
                    if (typeof result.remaining_slots === 'number') {
                        alert((result.message || 'Đăng ký lớp học thành công') + "\nSố chỗ còn lại: " + result.remaining_slots);
                    } else {
                        alert(result.message || 'Đăng ký lớp học thành công');
                    }
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
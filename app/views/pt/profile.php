<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin huấn luyện viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #0f172a, #111827);
            min-height: 100vh;
            color: #e2e8f0;
        }

        .pt-wrapper {
            margin-left: 18%;
            padding: 40px 30px;
        }

        .pt-card {
            background: #1e293b;
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.4);
            overflow: hidden;
        }

        .pt-card-header {
            background: linear-gradient(135deg, #f97316, #e11d48);
            padding: 40px 30px 70px;
            position: relative;
        }

        .pt-avatar {
            width: 140px;
            height: 140px;
            border-radius: 999px;
            border: 5px solid #1e293b;
            position: absolute;
            bottom: -70px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e11d48;
            font-size: 64px;
        }

        .pt-info {
            padding: 100px 30px 40px;
        }

        .info-box {
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(148, 163, 184, 0.3);
            padding: 18px;
            margin-bottom: 18px;
        }

        .info-label {
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 1.1rem;
            color: #f8fafc;
            font-weight: 500;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #f97316, #e11d48);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 999px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 25px rgba(225, 29, 72, 0.35);
        }

        .alert-custom {
            border-radius: 14px;
            border: none;
            font-weight: 500;
        }

        @media (max-width: 991px) {
            .pt-wrapper {
                margin-left: 0;
                padding: 120px 16px 40px;
            }
        }
    </style>
</head>

<body>
    <div class="pt-wrapper">
        <div class="container-fluid">
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-custom">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <?= htmlspecialchars($_SESSION['success']); ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-custom">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    <?= htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="pt-card">
                <div class="pt-card-header text-center">
                    <h1 class="h3 text-white mb-2">Hồ sơ huấn luyện viên</h1>
                    <p class="text-white-50 mb-0">Theo dõi và cập nhật thông tin cá nhân để học viên dễ dàng liên hệ</p>
                    <div class="pt-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </div>

                <div class="pt-info">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Họ và tên</div>
                                <div class="info-value"><?= htmlspecialchars($pt->HoTen ?? ''); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Ngày sinh</div>
                                <div class="info-value">
                                    <?php
                                    if (!empty($pt->NgaySinh)) {
                                        echo date('d/m/Y', strtotime($pt->NgaySinh));
                                    } else {
                                        echo 'Chưa cập nhật';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Giới tính</div>
                                <div class="info-value"><?= htmlspecialchars($pt->GioiTinh ?? 'Chưa cập nhật'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Số điện thoại</div>
                                <div class="info-value"><?= htmlspecialchars($pt->SDT ?? 'Chưa cập nhật'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Email</div>
                                <div class="info-value"><?= htmlspecialchars($pt->Email ?? 'Chưa cập nhật'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Địa chỉ</div>
                                <div class="info-value"><?= htmlspecialchars($pt->DiaChi ?? 'Chưa cập nhật'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Chuyên môn</div>
                                <div class="info-value"><?= htmlspecialchars($pt->ChuyenMon ?? 'Chưa cập nhật'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Kinh nghiệm</div>
                                <div class="info-value">
                                    <?= isset($pt->KinhNghiem) && $pt->KinhNghiem !== '' ? htmlspecialchars($pt->KinhNghiem . ' năm') : 'Chưa cập nhật'; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">Mức lương dự kiến</div>
                                <div class="info-value">
                                    <?php
                                    if (isset($pt->Luong) && $pt->Luong !== '') {
                                        echo number_format((float)$pt->Luong, 0, ',', '.') . ' VNĐ';
                                    } else {
                                        echo 'Chưa cập nhật';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="actions mt-4 justify-content-center">
                        <a href="/gym/pt/edit" class="btn btn-gradient"><i class="fa-solid fa-pen-to-square me-2"></i>Chỉnh sửa thông tin</a>
                        <a href="/gym" class="btn btn-outline-light px-4 rounded-pill"><i class="fa-solid fa-house me-2"></i>Trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

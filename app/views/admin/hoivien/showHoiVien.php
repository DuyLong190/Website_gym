<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            margin-left: 15%;
        }

        .user-detail-card {
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: none;
            background: #fff;
        }

        .user-detail-header {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .user-detail-title {
            color: #1e40af;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #4b5563;
        }

        .info-value {
            color: #1f2937;
            padding: 0.5rem 0;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pause {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-cancel {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="user-detail-container">
        <div class="container">
            <h1 class="user-detail-title">
                <i class="fas fa-user me-2"></i>Thông tin chi tiết hội viên
            </h1>
            <div class="card user-detail-card mb-4">
                <div class="user-detail-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Thông tin cá nhân
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Họ và tên</div>
                            <div class="info-value"><?= htmlspecialchars($hoiVien->HoTen) ?></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Ngày sinh</div>
                            <div class="info-value">
                                <?php
                                $ngaySinh = $hoiVien->NgaySinh ?? '';
                                echo $ngaySinh ? date('d/m/Y', strtotime($ngaySinh)) : '';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Giới tính</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->GioiTinh ?? '')) ?></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Số điện thoại</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->SDT ?? '')) ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Chiều cao</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->ChieuCao ?? '')) ?> cm</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Cân nặng</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->CanNang ?? '')) ?> kg</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->Email ?? '')) ?></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Địa chỉ</div>
                            <div class="info-value"><?= htmlspecialchars((string)($hoiVien->DiaChi ?? '')) ?></div>
                        </div>
                    </div>

                    <?php if (isset($currentCtgt) && is_array($currentCtgt)): ?>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-label">Trạng thái gói tập</div>
                                <div class="info-value">
                                    <?= htmlspecialchars((string)($currentCtgt['TrangThai'] ?? '')) ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-label">Thanh toán</div>
                                <div class="info-value">
                                    <?php
                                    $daThanhToan = (int)($currentCtgt['DaThanhToan'] ?? 0);
                                    $trangThaiCt = $currentCtgt['TrangThai'] ?? '';
                                    if ($daThanhToan === 1) {
                                        echo '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã thanh toán</span>';
                                    } else {
                                        // Hiển thị badge trạng thái hiện tại
                                        if ($trangThaiCt === 'Chờ xác minh') {
                                            echo '<span class="badge bg-warning text-dark me-2"><i class="fas fa-clock me-1"></i>Chờ xác minh</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary me-2">Chưa thanh toán</span>';
                                        }

                                        // Luôn hiển thị nút xác minh cho admin khi chưa thanh toán
                                        $id_ctgt = $currentCtgt['id_ctgt'] ?? null;
                                        if ($id_ctgt !== null): ?>
                                            <form method="post" action="/gym/admin/user/verifyPayment/<?= htmlspecialchars((string)$id_ctgt) ?>" style="display:inline-block;">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-check me-1"></i>Xác minh thanh toán
                                                </button>
                                            </form>
                                        <?php endif;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Gói tập</div>
                            <div class="info-value">
                                <?= !empty($hoiVien->TenGoiTap) ? htmlspecialchars($hoiVien->TenGoiTap) : '' ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Trạng thái</div>
                            <div class="info-value">
                                <span class="status-badge <?= $hoiVien->TrangThai === 'Đang hoạt động' ? 'status-active' : ($hoiVien->TrangThai === 'Tạm ngưng' ? 'status-pause' : 'status-cancel') ?>">
                                    <?= htmlspecialchars($hoiVien->TrangThai) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Ngày đăng ký</div>
                            <div class="info-value"><?= date('d/m/Y H:i', strtotime($hoiVien->NgayDangKy)) ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/gym/admin/user" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    </head>
</body>
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
                            <div class="info-value"><?= date('d/m/Y', strtotime($hoiVien->NgaySinh)) ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Giới tính</div>
                            <div class="info-value"><?= htmlspecialchars($hoiVien->GioiTinh) ?></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Số điện thoại</div>
                            <div class="info-value"><?= htmlspecialchars($hoiVien->SDT) ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= htmlspecialchars($hoiVien->Email) ?></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-label">Địa chỉ</div>
                            <div class="info-value"><?= htmlspecialchars($hoiVien->DiaChi) ?></div>
                        </div>
                    </div>

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
                        <div>
                            <a href="/gym/admin/user/edit/<?= $hoiVien->MaHV ?>" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa
                            </a>
                            <a href="/gym/admin/user/delete/<?= $hoiVien->MaHV ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa hội viên này?')">
                                <i class="fas fa-trash me-2"></i>Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    </head>
</body>
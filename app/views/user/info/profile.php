<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin-left: 15%;
        }

        .profile-header {
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            margin-top: -6rem;
        }

        .profile-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .profile-label {
            font-weight: 600;
            color: #666;
        }

        .profile-value {
            color: #333;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
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
    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Thông tin tài khoản</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="profile-card p-4">
                    <?php if (isset($hoiVien) && $hoiVien): ?>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Họ và tên:</div>
                            <div class="col-md-8 profile-value"><?= htmlspecialchars((string)($hoiVien->HoTen ?? '')); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Ngày sinh:</div>
                            <div class="col-md-8 profile-value">
                                <?php
                                $ngaySinh = $hoiVien->NgaySinh ?? '';
                                echo $ngaySinh ? date('d/m/Y', strtotime($ngaySinh)) : 'Chưa cập nhật';
                                ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Giới tính:</div>
                            <div class="col-md-8 profile-value">
                                <?php $gioiTinh = $hoiVien->GioiTinh ?? '';
                                echo $gioiTinh ? htmlspecialchars($gioiTinh) : 'Chưa cập nhật';
                                ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Số điện thoại:</div>
                            <div class="col-md-8 profile-value">
                                <?php $SDT = $hoiVien->SDT ?? '';
                                echo $SDT ? htmlspecialchars((string)($hoiVien->SDT)) : 'Chưa cập nhật'; ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Chiều cao:</div>
                            <div class="col-md-8 profile-value">
                                <?php $ChieuCao = $hoiVien->ChieuCao ?? '';
                                echo $SDT ? htmlspecialchars((string)($hoiVien->ChieuCao)) : 'Chưa cập nhật'; ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Cân nặng:</div>
                            <div class="col-md-8 profile-value">
                                <?php $CanNang = $hoiVien->CanNang ?? '';
                                echo $CanNang ? htmlspecialchars((string)($hoiVien->CanNang)) : 'Chưa cập nhật'; ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Email:</div>
                            <div class="col-md-8 profile-value">
                                <?php $Email = $hoiVien->Email ?? '';
                                echo $Email ? htmlspecialchars((string)($hoiVien->Email)) : 'Chưa cập nhật'; ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Địa chỉ:</div>
                            <div class="col-md-8 profile-value">
                                <?php $DiaChi = $hoiVien->DiaChi ?? '';
                                echo $DiaChi ? htmlspecialchars((string)($hoiVien->DiaChi)) : 'Chưa cập nhật'; ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Gói tập:</div>
                            <div class="col-md-8 profile-value">
                                <?php $TenGoiTap = $hoiVien->TenGoiTap ?? '';
                                echo $TenGoiTap ? htmlspecialchars((string)($hoiVien->TenGoiTap)) : 'Chưa đăng ký' ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Trạng thái:</div>
                            <div class="col-md-8">
                                <span class="status-badge 
                                <?php echo $hoiVien->TrangThai === 'Đang hoạt động' ? 'status-active' : ((string)($hoiVien->TrangThai === 'Tạm ngưng' ? 'status-pause' : 'status-cancel')); ?>">
                                    <?= htmlspecialchars((string)($hoiVien->TrangThai)); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Ngày đăng ký hội viên:</div>
                            <div class="col-md-8 profile-value">
                                <?php
                                $ngayDangKy = $hoiVien->NgayDangKy ?? '';
                                echo $ngayDangKy ? date('d/m/Y H:i', strtotime($ngayDangKy)) : 'Chưa cập nhật';
                                ?>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="/gym/user/edit_profile" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Không tìm thấy thông tin người dùng.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
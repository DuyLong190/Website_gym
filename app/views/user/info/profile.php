<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            background: linear-gradient(135deg, #8f2121 0%, #aa3a0eff 50%, #f07863ff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 119, 198, 0.3), transparent 50%);
            pointer-events: none;
        }

        .card {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: stretch;
            border-radius: 30px;
            padding: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 1200px;
            min-height: 500px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .left-container {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            flex: 1;
            max-width: 32%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 470px;
            padding: 30px 20px;
            margin: 15px;
            border-radius: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .left-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .right-container {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            flex: 1;
            max-width: 68%;
            min-height: 470px;
            padding: 25px;
            margin: 15px;
            border-radius: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
        }

        .profile-img-wrapper {
            position: relative;
            margin-bottom: 20px;
            z-index: 2;
        }

        .profile-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 0 0 4px rgba(255, 255, 255, 0.1);
            border: 3px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .profile-img-placeholder {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 70px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 0 0 4px rgba(255, 255, 255, 0.1);
            border: 3px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
            animation: pulse 3s ease-in-out infinite;
        }


        h2 {
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        h3 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
            position: relative;
        }

        .gradienttext {
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info-title {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding: 15px 0;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .info-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #8f2121, transparent);
            border-radius: 2px;
        }

        .info-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #8f2121, transparent);
            border-radius: 2px;
        }

        .info-title i {
            margin-right: 10px;
            color: #d4a02fff;
            font-size: 22px;
        }

        .specialty {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
            font-weight: 400;
            position: relative;
            z-index: 2;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .info-table {
            display: flex;
            flex-direction: column;
            width: 100%;
            flex: 1;
            gap: 10px;
        }

        .info-row {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 15px 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInRight 0.6s ease backwards;
        }

        .info-row:nth-child(1) {
            animation-delay: 0.1s;
        }

        .info-row:nth-child(2) {
            animation-delay: 0.2s;
        }

        .info-row:nth-child(3) {
            animation-delay: 0.3s;
        }

        .info-row:nth-child(4) {
            animation-delay: 0.4s;
        }

        .info-row:nth-child(5) {
            animation-delay: 0.5s;
        }

        .info-row:nth-child(6) {
            animation-delay: 0.6s;
        }

        .info-row:nth-child(7) {
            animation-delay: 0.7s;
        }

        .info-row:nth-child(8) {
            animation-delay: 0.8s;
        }

        .info-row:nth-child(9) {
            animation-delay: 0.9s;
        }

        .info-row:nth-child(10) {
            animation-delay: 1.0s;
        }

        .info-row:nth-child(11) {
            animation-delay: 1.1s;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .info-label {
            font-weight: 600;
            min-width: 160px;
            color: #df1f1fff;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }

        .info-label i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .info-value {
            flex: 1;
            color: rgba(255, 255, 255, 0.95);
            font-size: 15px;
            font-weight: 400;
        }

        .info-value a {
            color: rgba(255, 255, 255, 0.95);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: linear-gradient(135deg, #00b894, #00cec9);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 184, 148, 0.4);
        }

        .status-pause {
            background: linear-gradient(135deg, #fdcb6e, #e17055);
            color: white;
            box-shadow: 0 4px 15px rgba(253, 203, 110, 0.4);
        }

        .status-cancel {
            background: linear-gradient(135deg, #636e72, #2d3436);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 110, 114, 0.4);
        }

        .empty-value {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
        }

        .edit-btn {
            margin-top: 25px;
            text-align: center;
        }

        .edit-btn a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 25px;
            background: linear-gradient(135deg, #8f2121 0%, #b82e2e 100%);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 5px 20px rgba(143, 33, 33, 0.4);
            transition: all 0.3s ease;
        }

        .edit-btn a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(143, 33, 33, 0.5);
        }

        @media only screen and (max-width: 992px) {
            .card {
                flex-direction: column;
                width: 95%;
            }

            .left-container {
                max-width: 100%;
                min-height: auto;
                margin: 10px;
            }

            .right-container {
                max-width: 100%;
                min-height: auto;
                margin: 10px;
            }

            .profile-img,
            .profile-img-placeholder {
                width: 150px;
                height: 150px;
            }
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .card {
                width: 100%;
                padding: 10px;
            }

            .left-container,
            .right-container {
                margin: 10px;
                padding: 20px;
            }

            .profile-img,
            .profile-img-placeholder {
                width: 120px;
                height: 120px;
            }

            h2 {
                font-size: 22px;
            }

            h3 {
                font-size: 24px;
            }

            .info-title {
                font-size: 20px;
                margin-bottom: 20px;
                padding: 12px 0;
            }

            .info-title i {
                font-size: 18px;
            }

            .info-label {
                min-width: 130px;
                font-size: 14px;
            }

            .info-value {
                font-size: 14px;
            }

            .info-row {
                padding: 12px 15px;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($hoiVien) && $hoiVien): ?>
        <div class="card">
            <!-- Left Container - Avatar & Basic Info -->
            <div class="left-container">
                <h3 class="info-title">
                    <i class="fas fa-user-circle"></i>
                    Thông tin cá nhân
                </h3>
                <div class="profile-img-wrapper">
                    <?php
                    $imageUrl = !empty($hoiVien->image ?? '') ? '/gym/' . ($hoiVien->image ?? '') : '/Gym/public/images/user.png';
                    ?>
                    <?php if (!empty($hoiVien->image ?? '')): ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                            alt="<?php echo htmlspecialchars($hoiVien->HoTen ?? 'Người dùng'); ?>"
                            class="profile-img"
                            onerror="this.style.display='none'; this.parentElement.innerHTML+='<div class=\'profile-img-placeholder\'><i class=\'fa-solid fa-user\'></i></div>';">
                    <?php else: ?>
                        <div class="profile-img-placeholder">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h2 class="gradienttext"><?php echo htmlspecialchars($hoiVien->HoTen ?? 'N/A'); ?></h2>
                <div class="specialty">
                    <?php
                    $trangThai = $hoiVien->TrangThai ?? 'N/A';
                    $trangThaiLower = strtolower($trangThai);
                    $statusClass = 'status-cancel';
                    if (strpos($trangThaiLower, 'đang hoạt động') !== false || strpos($trangThaiLower, 'active') !== false || strpos($trangThaiLower, 'hoạt động') !== false) {
                        $statusClass = 'status-active';
                    } elseif (strpos($trangThaiLower, 'tạm ngưng') !== false || strpos($trangThaiLower, 'pause') !== false) {
                        $statusClass = 'status-pause';
                    }
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>" style="font-size: 14px; padding: 8px 20px;">
                        <i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>
                        <?php echo htmlspecialchars($trangThai); ?>
                    </span>
                </div>
            </div>

            <!-- Right Container - Detailed Info -->
            <div class="right-container">
                <div class="info-table">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-id-card"></i>
                            <span>Họ và tên:</span>
                        </div>
                        <div class="info-value"><?php echo !empty($hoiVien->HoTen ?? '') ? htmlspecialchars($hoiVien->HoTen) : '<span class="empty-value">N/A</span>'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-venus-mars"></i>
                            <span>Giới tính:</span>
                        </div>
                        <div class="info-value"><?php echo !empty($hoiVien->GioiTinh ?? '') ? htmlspecialchars($hoiVien->GioiTinh) : '<span class="empty-value">Chưa cập nhật</span>'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-birthday-cake"></i>
                            <span>Ngày sinh:</span>
                        </div>
                        <div class="info-value">
                            <?php 
                            $ngaySinh = $hoiVien->NgaySinh ?? '';
                            echo !empty($ngaySinh) ? date('d/m/Y', strtotime($ngaySinh)) : '<span class="empty-value">Chưa cập nhật</span>'; 
                            ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            <span>Số điện thoại:</span>
                        </div>
                        <div class="info-value">
                            <?php if (!empty($hoiVien->SDT ?? '')): ?>
                                <a href="tel:<?php echo htmlspecialchars($hoiVien->SDT); ?>">
                                    <?php echo htmlspecialchars($hoiVien->SDT); ?>
                                </a>
                            <?php else: ?>
                                <span class="empty-value">Chưa cập nhật</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            <span>Email:</span>
                        </div>
                        <div class="info-value">
                            <?php if (!empty($hoiVien->Email ?? '')): ?>
                                <a href="mailto:<?php echo htmlspecialchars($hoiVien->Email); ?>">
                                    <?php echo htmlspecialchars($hoiVien->Email); ?>
                                </a>
                            <?php else: ?>
                                <span class="empty-value">Chưa cập nhật</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Địa chỉ:</span>
                        </div>
                        <div class="info-value"><?php echo !empty($hoiVien->DiaChi ?? '') ? htmlspecialchars($hoiVien->DiaChi) : '<span class="empty-value">Chưa cập nhật</span>'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-ruler-vertical"></i>
                            <span>Chiều cao:</span>
                        </div>
                        <div class="info-value">
                            <?php
                            if (!empty($hoiVien->ChieuCao ?? '')) {
                                echo htmlspecialchars($hoiVien->ChieuCao) . ' cm';
                            } else {
                                echo '<span class="empty-value">Chưa cập nhật</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-weight"></i>
                            <span>Cân nặng:</span>
                        </div>
                        <div class="info-value">
                            <?php
                            if (!empty($hoiVien->CanNang ?? '')) {
                                echo htmlspecialchars($hoiVien->CanNang) . ' kg';
                            } else {
                                echo '<span class="empty-value">Chưa cập nhật</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Gói tập:</span>
                        </div>
                        <div class="info-value">
                            <?php echo !empty($hoiVien->TenGoiTap ?? '') ? htmlspecialchars($hoiVien->TenGoiTap) : '<span class="empty-value">Chưa đăng ký</span>'; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            <span>Ngày đăng ký:</span>
                        </div>
                        <div class="info-value">
                            <?php 
                            $ngayDangKy = $hoiVien->NgayDangKy ?? '';
                            echo !empty($ngayDangKy) ? date('d/m/Y H:i', strtotime($ngayDangKy)) : '<span class="empty-value">Chưa cập nhật</span>'; 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="edit-btn">
                    <a href="/gym/user/edit_profile">
                        <i class="fas fa-edit"></i>
                        Cập nhật
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="right-container" style="max-width: 100%;">
                <div class="alert alert-warning" style="background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.5); color: #fff; padding: 20px; border-radius: 15px;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Không tìm thấy thông tin người dùng.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

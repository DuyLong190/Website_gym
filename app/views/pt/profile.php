<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin huấn luyện viên</title>
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
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
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
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(96, 165, 250, 0.3), transparent 50%);
            pointer-events: none;
        }

        .card {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: stretch;
            border-radius: 15px;
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
            border-radius: 12px;
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
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
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
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .right-column {
            display: flex;
            flex-direction: column;
        }

        .expertise-section {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(59, 130, 246, 0.3) 100%);
            border: 2px solid rgba(37, 99, 235, 0.5);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            animation: glow 3s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            50% {
                box-shadow: 0 8px 35px rgba(37, 99, 235, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
        }

        .expertise-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
        }

        .expertise-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .expertise-title i {
            color: #60a5fa;
            font-size: 24px;
        }

        .expertise-content {
            position: relative;
            z-index: 2;
        }

        .expertise-name {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .expertise-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .expertise-detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .expertise-detail-item i {
            width: 20px;
            color: #60a5fa;
        }

        .stats-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .stats-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stats-title i {
            color: #60a5fa;
            font-size: 22px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (min-width: 600px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #3b82f6;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .stat-icon {
            font-size: 24px;
            color: #60a5fa;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 0 0 4px rgba(59, 130, 246, 0.2);
            border: 3px solid rgba(59, 130, 246, 0.3);
            position: relative;
            z-index: 2;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
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
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            font-size: 70px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 0 0 4px rgba(59, 130, 246, 0.2);
            border: 3px solid rgba(59, 130, 246, 0.3);
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
            background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
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
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
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
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
            border-radius: 2px;
        }

        .info-title i {
            margin-right: 10px;
            color: #60a5fa;
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
            background: rgba(59, 130, 246, 0.2);
            border-radius: 10px;
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
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInRight 0.6s ease backwards;
        }

        .info-row:nth-child(1) { animation-delay: 0.1s; }
        .info-row:nth-child(2) { animation-delay: 0.2s; }
        .info-row:nth-child(3) { animation-delay: 0.3s; }
        .info-row:nth-child(4) { animation-delay: 0.4s; }
        .info-row:nth-child(5) { animation-delay: 0.5s; }
        .info-row:nth-child(6) { animation-delay: 0.6s; }
        .info-row:nth-child(7) { animation-delay: 0.7s; }
        .info-row:nth-child(8) { animation-delay: 0.8s; }
        .info-row:nth-child(9) { animation-delay: 0.9s; }
        .info-row:nth-child(10) { animation-delay: 1.0s; }
        .info-row:nth-child(11) { animation-delay: 1.1s; }

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
            color: #60a5fa;
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
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }

        .edit-btn a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
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
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .profile-img,
            .profile-img-placeholder {
                width: 150px;
                height: 150px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
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

            .expertise-section {
                padding: 20px;
            }

            .expertise-name {
                font-size: 22px;
            }

            .expertise-title {
                font-size: 18px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-value {
                font-size: 20px;
            }

            .stat-icon {
                font-size: 20px;
            }

            .stats-title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($pt) && $pt): ?>
        <div class="card">
            <!-- Left Container - Avatar & Basic Info -->
            <div class="left-container">
                <h3 class="info-title">
                    <i class="fas fa-user-tie"></i>
                    Thông tin cá nhân
                </h3>
                <div class="profile-img-wrapper">
                    <?php
                    $imageUrl = !empty($pt->image ?? '') ? '/gym/' . ($pt->image ?? '') : '/Gym/public/images/user.png';
                    ?>
                    <?php if (!empty($pt->image ?? '')): ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                            alt="<?php echo htmlspecialchars($pt->HoTen ?? 'Huấn luyện viên'); ?>"
                            class="profile-img"
                            onerror="this.style.display='none'; this.parentElement.innerHTML+='<div class=\'profile-img-placeholder\'><i class=\'fa-solid fa-user-tie\'></i></div>';">
                    <?php else: ?>
                        <div class="profile-img-placeholder">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h2 class="gradienttext"><?php echo htmlspecialchars($pt->HoTen ?? 'N/A'); ?></h2>
                <div class="specialty">
                    <i class="fas fa-dumbbell"></i>
                    <?php echo !empty($pt->ChuyenMon ?? '') ? htmlspecialchars($pt->ChuyenMon) : 'Huấn luyện viên'; ?>
                </div>
            </div>

            <!-- Right Container - Detailed Info -->
            <div class="right-container">
                <!-- Left Column -->
                <div class="right-column">
                    <!-- Expertise Section - Highlighted -->
                    <div class="expertise-section">
                        <div class="expertise-title">
                            <i class="fas fa-star"></i>
                            Chuyên môn & Kinh nghiệm
                        </div>
                        <div class="expertise-content">
                            <div class="expertise-name">
                                <?php echo !empty($pt->ChuyenMon ?? '') ? htmlspecialchars($pt->ChuyenMon) : 'Chưa cập nhật'; ?>
                            </div>
                            <div class="expertise-details">
                                <?php if (!empty($pt->KinhNghiem ?? '')): ?>
                                    <div class="expertise-detail-item">
                                        <i class="fas fa-briefcase"></i>
                                        <span>Kinh nghiệm: <?php echo htmlspecialchars($pt->KinhNghiem); ?> năm</span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($pt->Luong ?? '')): ?>
                                    <div class="expertise-detail-item">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Mức lương: <?php echo number_format((float)$pt->Luong, 0, ',', '.'); ?> VNĐ</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="stats-section">
                        <div class="stats-title">
                            <i class="fas fa-chart-line"></i>
                            Thống kê
                        </div>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="stat-value">
                                    <?php echo isset($pt->SoLopDangKy) ? (int)$pt->SoLopDangKy : 0; ?>
                                </div>
                                <div class="stat-label">Lớp đang đăng ký</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div class="stat-value">
                                    <?php echo isset($pt->SoBuoiTapDaDay) ? (int)$pt->SoBuoiTapDaDay : 0; ?>
                                </div>
                                <div class="stat-label">Buổi tập đã dạy</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <div class="info-table">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-venus-mars"></i>
                                <span>Giới tính:</span>
                            </div>
                            <div class="info-value"><?php echo !empty($pt->GioiTinh ?? '') ? htmlspecialchars($pt->GioiTinh) : '<span class="empty-value">Chưa cập nhật</span>'; ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-birthday-cake"></i>
                                <span>Ngày sinh:</span>
                            </div>
                            <div class="info-value">
                                <?php 
                                $ngaySinh = $pt->NgaySinh ?? '';
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
                                <?php if (!empty($pt->SDT ?? '')): ?>
                                    <a href="tel:<?php echo htmlspecialchars($pt->SDT); ?>">
                                        <?php echo htmlspecialchars($pt->SDT); ?>
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
                                <?php if (!empty($pt->Email ?? '')): ?>
                                    <a href="mailto:<?php echo htmlspecialchars($pt->Email); ?>">
                                        <?php echo htmlspecialchars($pt->Email); ?>
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
                            <div class="info-value"><?php echo !empty($pt->DiaChi ?? '') ? htmlspecialchars($pt->DiaChi) : '<span class="empty-value">Chưa cập nhật</span>'; ?></div>
                        </div>
                    </div>
                    <div class="edit-btn">
                        <a href="/gym/pt/edit">
                            <i class="fas fa-edit"></i>
                            Cập nhật
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="right-container" style="max-width: 100%;">
                <div class="alert alert-warning" style="background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.5); color: #fff; padding: 20px; border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Không tìm thấy thông tin huấn luyện viên.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin</title>
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
            padding: 10px;
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

        .edit-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 1000px;
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .edit-header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
        }

        .edit-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .edit-header h2 i {
            color: #d4a02fff;
        }

        .edit-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #8f2121, transparent);
            border-radius: 2px;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInRight 0.6s ease backwards;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(143, 33, 33, 0.3);
        }

        .form-section:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-section:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-section:nth-child(3) {
            animation-delay: 0.3s;
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

        .form-section-title {
            color: #fff;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(143, 33, 33, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-section-title i {
            font-size: 22px;
            color: #d4a02fff;
        }

        .form-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .form-label i {
            font-size: 14px;
            color: #d4a02fff;
            width: 18px;
            text-align: center;
        }

        .form-control,
        .form-select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 8px 12px;
            color: #fff;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #8f2121;
            box-shadow: 0 0 0 3px rgba(143, 33, 33, 0.3);
            color: #fff;
            outline: none;
            transform: translateY(-1px);
        }

        .form-control option {
            background: #fff;
            color: #000;
        }

        .form-select option {
            background: #fff;
            color: #000;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .btn-save {
            background: linear-gradient(135deg, #8f2121 0%, #b82e2e 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(143, 33, 33, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #7a1c1c 0%, #a02525 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(143, 33, 33, 0.5);
            color: white;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .alert {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #fff;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 15px;
            backdrop-filter: blur(10px);
        }

        .btn-close {
            filter: invert(1);
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        @media only screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .edit-card {
                width: 100%;
                padding: 15px 12px;
                border-radius: 12px;
            }

            .edit-header h2 {
                font-size: 22px;
                flex-direction: column;
                gap: 8px;
            }

            .form-section {
                padding: 15px;
                border-radius: 8px;
            }

            .form-section-title {
                font-size: 18px;
            }

            .button-group {
                flex-direction: column;
                gap: 10px;
            }

            .btn-save,
            .btn-cancel {
                width: 100%;
                justify-content: center;
            }

            .form-control,
            .form-select {
                padding: 8px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="edit-card">
        <div class="edit-header">
            <h2>
                <i class="fas fa-edit"></i>
                <span>Chỉnh sửa thông tin cá nhân</span>
            </h2>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/gym/user/update_profile" method="POST">
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-user"></i>
                    <span>Thông tin cơ bản</span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="fullname" class="form-label">
                            <i class="fas fa-id-card"></i>
                            <span>Họ và tên</span>
                        </label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="<?php echo htmlspecialchars($hoiVien->HoTen ?? ''); ?>"
                            placeholder="Nhập họ và tên">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="NgaySinh" class="form-label">
                            <i class="fas fa-birthday-cake"></i>
                            <span>Ngày sinh</span>
                        </label>
                        <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                            value="<?php echo htmlspecialchars($hoiVien->NgaySinh ?? ''); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="GioiTinh" class="form-label">
                            <i class="fas fa-venus-mars"></i>
                            <span>Giới tính</span>
                        </label>
                        <select class="form-select" id="GioiTinh" name="GioiTinh">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" <?php echo ($hoiVien->GioiTinh === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($hoiVien->GioiTinh === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?php echo ($hoiVien->GioiTinh === 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="SDT" class="form-label">
                            <i class="fas fa-phone"></i>
                            <span>Số điện thoại</span>
                        </label>
                        <input type="tel" class="form-control" id="SDT" name="SDT"
                            value="<?php echo htmlspecialchars($hoiVien->SDT ?? ''); ?>"
                            placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-chart-line"></i>
                    <span>Thông tin thể chất</span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ChieuCao" class="form-label">
                            <i class="fas fa-ruler-vertical"></i>
                            <span>Chiều cao (cm)</span>
                        </label>
                        <input type="number" class="form-control" id="ChieuCao" name="ChieuCao"
                            value="<?php echo htmlspecialchars($hoiVien->ChieuCao ?? ''); ?>"
                            placeholder="Nhập chiều cao">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="CanNang" class="form-label">
                            <i class="fas fa-weight"></i>
                            <span>Cân nặng (kg)</span>
                        </label>
                        <input type="number" class="form-control" id="CanNang" name="CanNang"
                            value="<?php echo htmlspecialchars($hoiVien->CanNang ?? ''); ?>"
                            placeholder="Nhập cân nặng">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-address-card"></i>
                    <span>Thông tin liên hệ</span>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </label>
                    <input type="email" class="form-control" id="email" name="Email"
                        value="<?php echo htmlspecialchars($hoiVien->Email ?? ''); ?>"
                        placeholder="Nhập email">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa chỉ</span>
                    </label>
                    <textarea class="form-control" id="address" name="DiaChi" rows="3"
                        placeholder="Nhập địa chỉ"><?php echo htmlspecialchars($hoiVien->DiaChi ?? ''); ?></textarea>
                </div>
            </div>

            <div class="button-group">
                <a href="/gym/user/profile" class="btn btn-cancel">
                    <i class="fas fa-times"></i>
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

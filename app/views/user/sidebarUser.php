<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Gym/public/css/sidebar.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar__link {
            text-decoration: none !important;
        }
        
        .navbar__link i,
        .navbar__link svg {
            text-decoration: none !important;
        }
        
        .navbar__link .fa-clover,
        .navbar__link .fa-people-roof,
        .navbar__link .fa-clipboard-user,
        .navbar__link .fa-ticket,
        .navbar__link .fa-clock-rotate-left,
        .navbar__link .fa-arrow-right-from-bracket {
            font-size: 1.5rem !important;
            width: 1.75rem;
            height: 1.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
        }
        
        .user-info-container {
            position: fixed;
            top: 1rem;
            left: 1rem;
            width: 5.5rem;
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem 0.75rem;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.03);
            z-index: 1031;
            margin-bottom: 0.5rem;
        }
        
        .user-info-container .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #8f2121;
            display: block;
            margin: 0 auto 0.75rem;
            box-shadow: 0 2px 8px rgba(143, 33, 33, 0.2);
            transition: transform 0.3s ease;
        }
        
        .user-info-container .user-avatar:hover {
            transform: scale(1.05);
        }
        
        .user-info-container .user-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: #333;
            text-align: center;
            line-height: 1.3;
            padding: 0 0.25rem;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            max-height: 2.6em;
        }
        
        .user-info-container .user-name:hover {
            color: #8f2121;
        }
        
        /* Điều chỉnh vị trí navbar để không bị che bởi container */
        .navbar {
            top: 8.5rem !important;
            height: calc(100vh - 10rem) !important;
        }
    </style>
</head>

<body>
    <?php
    // Lấy thông tin người dùng từ database
    $userImage = '/Gym/public/images/user.png';
    $userName = 'Tài khoản';
    
    if (isset($_SESSION['username'])) {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../../models/HoiVienModel.php';
        
        $db = (new Database())->getConnection();
        $hoivienModel = new HoiVienModel($db);
        $hoiVien = $hoivienModel->getHoiVienByUsername($_SESSION['username']);
        
        if ($hoiVien) {
            $userName = !empty($hoiVien->HoTen) ? htmlspecialchars($hoiVien->HoTen) : 'Tài khoản';
            $userImage = !empty($hoiVien->image) ? '/gym/' . htmlspecialchars($hoiVien->image) : '/Gym/public/images/user.png';
        }
    }
    ?>
    <div class="user-info-container">
        <img
            src="<?php echo $userImage; ?>"
            alt="Avatar"
            class="user-avatar"
            onerror="this.src='/Gym/public/images/user.png'">
        <div class="user-name" title="<?php echo htmlspecialchars($userName); ?>">
            <?php echo $userName; ?>
        </div>
    </div>
    <nav class="navbar">
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="/gym/user/profile" class="navbar__link"><i data-feather="user"></i><span>Thông tin cá nhân</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/user/chitiet_goitap" class="navbar__link"><i class="fas fa-ticket"></i><span>Gói tập</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/user/lichlophoc" class="navbar__link"><i data-feather="calendar"></i><span>Lịch tập</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/user/lophoc" class="navbar__link"><i class="fas fa-people-roof "></i><span>Lớp học</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/user/lichsuhoatdong" class="navbar__link"><i class="fas fa-clock-rotate-left "></i><span>Lịch sử hoạt động</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/user/dichvu" class="navbar__link"><i class="fas fa-spa"></i><span>Dịch vụ</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym" class="navbar__link"><i data-feather="home"></i><span>Trang chủ</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/account/logout" class="navbar__link"><i class="fas fa-arrow-right-from-bracket "></i><span>Đăng xuất</span></a>
            </li>
        </ul>
    </nav>
    <script>
        feather.replace();
    </script>
</body>

</html>
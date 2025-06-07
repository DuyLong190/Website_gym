<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gym & Fitness</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="public/css/header.css">
    <style>
        body {
            background-color: rgba(2, 16, 23, 0.92) !important;
            color: #fff !important;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 5px 0;
            text-align: left;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 5px 15px;
            display: inline-block;
            margin-right: 15px;
            font-size: 1.1em;
        }

        .navbar img {
            margin-right: 10px;
        }

        /* vừa thêm đoạn style này */
        .nav-link.dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link.dropdown-toggle img {
            display: inline-block;
            vertical-align: middle;
        }

        .nav-link.dropdown-toggle span {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <header class="bg-gradient-to-r from-gray-900 to-black text-white py-3 px-6 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <!-- Menu trái -->
        <nav class="flex items-center flex-1">
            <ul class="flex space-x-4 text-lg font-medium">
                <li><a href="/gym/" class="hover:text-red-500 transition duration-300">Trang chủ</a></li>
                <li><a href="/gym/goitap" class="hover:text-red-500 transition duration-300">Gói Tập</a></li>
                <li class="dropdown">
                    <a class="hover:text-red-500 transition duration-300 dropdown-toggle" href="#" id="dichvuDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Dịch vụ
                    </a>
                    <ul class="dropdown-menu absolute bg-gray-800 text-white rounded-lg mt-2" aria-labelledby="dichvuDropdown">
                        <li><a class="dropdown-item" href="/gym/DvThuGian">Dịch vụ thư giãn</a></li>
                        <li><a class="dropdown-item" href="/gym/DvTapLuyen">Dịch vụ tập luyện</a></li>
                    </ul>
                </li>
                <li><a href="#" class="hover:text-red-500 transition duration-300">Ưu đãi</a></li>
            </ul>
        </nav>
        <!-- Logo và tên ở giữa -->
        <div class="flex items-center">
            <img src="/Gym/public/images/logo.png" alt="LD Gym Logo" class="h-14 mb-1">
            <h1 class="text-3xl font-extrabold tracking-tight">LD Gym & Fitness</h1>
        </div>
        <!-- Menu phải -->
        <nav class="flex items-center flex-1 justify-end">
            <ul class="flex space-x-4">
                <?php if (SessionHelper::isLoggedIn()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle flex items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/Gym/public/images/user.png" class="h-10 inline-block align-middle" alt="<?php echo $_SESSION['username']; ?>">
                            <span class="inline-block align-middle"><?php echo $_SESSION['username']; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-gray-800 text-white" aria-labelledby="userDropdown">
                            <?php if (SessionHelper::isAdmin()): ?>
                                <li><a class="dropdown-item hover:bg-gray-700 !important" href="app/views/admin/sidebarQL.php">Quản lý</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item hover:bg-gray-7 00" href="app/views/sidebar/sidebarInfo.php">Thông tin cá nhân</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item hover:bg-gray-700" href="/gym/account/logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/gym/account/login">Tài khoản</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
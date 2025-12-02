<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gym & Fitness</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Gym/public/css/header.css">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-dark">
    <header class="navbar bg-gradient-to-r from-gray-900 to-black text-white py-3 px-6 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <div class="navbar_container">
            <button class="navbar__toggle" id="navbarToggle" aria-label="Toggle navigation" aria-controls="navbarMenu" aria-expanded="false">
                <span class="bar"></span><span class="bar"></span><span class="bar"></span>
            </button>
            <nav id="navbarMenu" class="navbar__menu" role="navigation" aria-labelledby="navbarToggle">
                <ul class="navbar__list flex space-x-4 text-lg font-medium text-white">
                    <li class="navbar__item"><a href="/gym/" class="navbar__link transition duration-300">Trang chủ</a></li>
                    <li class="navbar__item"><a href="/gym/goitap" class="navbar__link transition duration-300">Gói Tập</a></li>
                    <li class="navbar__item dropdown">
                        <a class="navbar__link transition duration-300 dropdown-toggle " href="#" id="dichvuDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Dịch vụ
                        </a>
                        <ul class="dropdown-menu absolute bg-gray-800 text-white rounded-lg mt-2" aria-labelledby="dichvuDropdown">
                            <li><a class="dropdown-item" href="/gym/DvThuGian">Thư giãn</a></li>
                            <li><a class="dropdown-item" href="/gym/lophoc">Lớp học</a></li>
                        </ul>
                    </li>
                    <li class="navbar__item"><a href="#" class="navbar__link transition duration-300">Ưu đãi</a></li>
                </ul>
            </nav>
        </div>

        <div class="flex justify-center items-center mx-auto absolute left-1/2 transform -translate-x-1/2 ">
            <img src="/Gym/public/images/logo.png" alt="LD Gym Logo" class="h-14 mb-1 mr-5">
            <h1 class="text-3xl font-extrabold tracking-tight whitespace-nowrap">LD Gym & Fitness</h1>
        </div>

        <nav class="flex items-center justify-center flex-1">
            <ul class="flex space-x-4 text-lg ml-auto">
                <?php if (SessionHelper::isLoggedIn()): ?>
                    <li class="nav-item dropdown text-lg">
                        <a class="nav-link dropdown-toggle flex items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/Gym/public/images/user.png" class="h-10 inline-block align-middle" alt="<?php echo $_SESSION['HoTen'] ?? $_SESSION['username']; ?>">
                            <span class="inline-block align-middle">
                                <?php
                                if (SessionHelper::isAdmin()) {
                                    echo 'admin';
                                } else {
                                    echo $_SESSION['HoTen'] ?? 'Tài khoản';
                                }
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-gray-800 text-white" aria-labelledby="userDropdown">
                            <?php if (SessionHelper::isAdmin()): ?>
                                <li><a class="dropdown-item hover:bg-gray-700" href="/gym/admin">Quản lý</a></li>
                            <?php elseif (SessionHelper::isPT()): ?>
                                <li><a class="dropdown-item hover:bg-gray-700" href="/gym/pt/lichday">Xem lịch dạy</a></li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item hover:bg-gray-700" href="<?php echo SessionHelper::isPT() ? '/gym/pt' : '/gym/user'; ?>">Thông tin cá nhân</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item hover:bg-gray-700" href="/gym/account/logout">Đăng xuất</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="navbar__item navbar__item--cta">
                        <a class="navbar__link navbar__link--cta" href="/gym/account/login">Tài khoản</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbarToggle = document.getElementById('navbarToggle');
                const navbarMenu = document.getElementById('navbarMenu');
                if (navbarToggle && navbarMenu) {
                    navbarToggle.addEventListener('click', function() {
                        navbarToggle.classList.toggle('is-active');
                        navbarMenu.classList.toggle('is-active');
                        const isExpanded = navbarToggle.getAttribute('aria-expanded') === 'true';
                        navbarToggle.setAttribute('aria-expanded', !isExpanded);
                    });
                }
            });
        </script>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <main>
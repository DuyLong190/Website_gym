<?php
$pageTitle = isset($pageTitle) && $pageTitle !== '' ? $pageTitle : 'LD Gym & Fitness';
$additionalHeadContent = $additionalHeadContent ?? '';
$htmlClassAttr = isset($htmlClass) && $htmlClass !== ''
    ? ' class="' . htmlspecialchars($htmlClass, ENT_QUOTES, 'UTF-8') . '"'
    : '';
$bodyClassAttr = isset($bodyClass) && $bodyClass !== ''
    ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"'
    : '';
?>
<!DOCTYPE html>
<html lang="vi" <?= $htmlClassAttr; ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if (!empty($additionalHeadContent)): ?>
        <?= $additionalHeadContent ?>
    <?php endif; ?>
    <link rel="stylesheet" href="/Gym/public/css/header.css">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body<?= $bodyClassAttr; ?>>
    <div id="site-header">
        <header class="navbar bg-gradient-to-r from-gray-900 to-black text-white py-3 px-6 flex justify-between items-center shadow-lg sticky top-0 z-20">
            <div class="navbar_container">
                <button class="navbar__toggle" id="navbarToggle" aria-label="Toggle navigation" aria-controls="navbarMenu" aria-expanded="false">
                    <span class="bar"></span><span class="bar"></span><span class="bar"></span>
                </button>
                <nav id="navbarMenu" class="navbar__menu" role="navigation" aria-labelledby="navbarToggle">
                    <ul class="navbar__list flex space-x-4 text-lg font-medium text-white">
                        <li class="navbar__item"><a href="/gym/" class="navbar__link transition duration-300">Trang chủ</a></li>
                        <li class="navbar__item"><a href="/gym/goitap" class="navbar__link transition duration-300">Gói Tập</a></li>
                        <li class="navbar__item dropdown dichvu-dropdown">
                            <a class="navbar__link transition duration-300 dropdown-toggle dichvu-link" href="#" id="dichvuDropdown" role="button"
                                aria-expanded="false">Dịch vụ
                            </a>
                            <ul class="dichvu-dropdown-menu" aria-labelledby="dichvuDropdown">
                                <li><a class="dichvu-dropdown-item" href="/gym/DvThuGian">Thư giãn</a></li>
                                <li><a class="dichvu-dropdown-item" href="/gym/lophoc">Lớp học</a></li>
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
                        <li class="nav-item dropdown text-lg user-dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown-link flex items-center gap-2" href="#" id="userDropdown" role="button" aria-expanded="false">
                                <img src="/Gym/public/images/user.png" class="h-10 inline-block align-middle user-avatar" alt="<?php echo $_SESSION['HoTen'] ?? $_SESSION['username']; ?>">
                                <span class="inline-block align-middle user-name">
                                    <?php
                                    if (SessionHelper::isAdmin()) {
                                        echo 'admin';
                                    } else {
                                        echo $_SESSION['HoTen'] ?? 'Tài khoản';
                                    }
                                    ?>
                                </span>
                            </a>
                            <ul class="user-dropdown-menu" aria-labelledby="userDropdown">
                                <?php if (SessionHelper::isAdmin()): ?>
                                    <li><a class="user-dropdown-item" href="/gym/admin">Quản lý</a></li>
                                <?php elseif (SessionHelper::isPT()): ?>
                                    <li><a class="user-dropdown-item" href="/gym/pt/lichday">Xem lịch dạy</a></li>
                                <?php endif; ?>
                                <li>
                                    <a class="user-dropdown-item" href="<?php echo SessionHelper::isPT() ? '/gym/pt' : '/gym/user'; ?>">Thông tin cá nhân</a>
                                </li>
                                <li>
                                    <hr class="user-dropdown-divider">
                                </li>
                                <li>
                                    <a class="user-dropdown-item user-dropdown-item--logout" href="/gym/account/logout">Đăng xuất</a>
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

                    // Handle dropdown menu for "Dịch vụ" on mobile
                    const dichvuDropdown = document.querySelector('.dichvu-dropdown');
                    const dichvuLink = document.querySelector('.dichvu-link');
                    if (dichvuDropdown && dichvuLink) {
                        // Toggle dropdown on click (for mobile) and prevent default link behavior
                        dichvuLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            dichvuDropdown.classList.toggle('active');
                            const isExpanded = dichvuLink.getAttribute('aria-expanded') === 'true';
                            dichvuLink.setAttribute('aria-expanded', !isExpanded);
                        });

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!dichvuDropdown.contains(e.target)) {
                                dichvuDropdown.classList.remove('active');
                                dichvuLink.setAttribute('aria-expanded', 'false');
                            }
                        });
                    }

                    // Handle dropdown menu for user on mobile
                    const userDropdown = document.querySelector('.user-dropdown');
                    const userDropdownLink = document.querySelector('.user-dropdown-link');
                    if (userDropdown && userDropdownLink) {
                        // Toggle dropdown on click (for mobile) and prevent default link behavior
                        userDropdownLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            userDropdown.classList.toggle('active');
                            const isExpanded = userDropdownLink.getAttribute('aria-expanded') === 'true';
                            userDropdownLink.setAttribute('aria-expanded', !isExpanded);
                        });

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!userDropdown.contains(e.target)) {
                                userDropdown.classList.remove('active');
                                userDropdownLink.setAttribute('aria-expanded', 'false');
                            }
                        });
                    }
                });
            </script>
        </header>
    </div>
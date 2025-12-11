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
    </style>
</head>

<body>
    <nav class="navbar">
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="/gym/admin/statistics" class="navbar__link"><i data-feather="bar-chart-2"></i><span>Thống kê</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/user" class="navbar__link"><i data-feather="users"></i><span>Hội viên</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/goitap" class="navbar__link"><i data-feather="layers"></i><span>Gói tập</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/dichvu" class="navbar__link"><i class="fas fa-clover"></i><span>Dịch vụ</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/lophoc" class="navbar__link"><i class="fas fa-people-roof"></i><span>Lớp học</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/pt" class="navbar__link"><i data-feather="user"></i><span>Huấn luyện viên</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/account" class="navbar__link"><i class="fas fa-clipboard-user"></i><span>Tài khoản</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/lichlophoc" class="navbar__link"><i data-feather="calendar"></i><span>Lịch lớp học</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/dangky" class="navbar__link"><i data-feather="clipboard"></i><span>Buổi học</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/yeucau" class="navbar__link"><i data-feather="check-circle"></i><span>Yêu cầu xác nhận</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym/admin/dangky_dichvu" class="navbar__link"><i class="fas fa-spa"></i><span>Đăng ký dịch vụ</span></a>
            </li>
            <li class="navbar__item">
                <a href="/gym" class="navbar__link"><i data-feather="home"></i><span>Về trang chủ</span></a>
            </li>
        </ul>
    </nav>
    <script>
        feather.replace();
    </script>
</body>

</html>
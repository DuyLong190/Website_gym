<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gym & Fitness</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="public/css/header.css">
</head>
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
        font-size: 0.9em;
    }
</style>

<body>

    <header class="bg-gradient-to-r from-gray-900 to-black text-white py-3 px-6 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <div class="flex items-center">
            <img src="/Gym/public/images/logo.png" alt="LD Gym Logo" class="h-14 mr-4">
            <h1 class="text-3xl font-extrabold tracking-tight">LD Gym & Fitness</h1>
        </div>
        <nav class="flex items-center">
            <ul class="flex space-x-8 text-lg font-medium">
                <li><a href="/gym/" class="hover:text-red-500 transition duration-300">Trang chủ</a></li>
                <li><a href="/gym/goitap" class="hover:text-red-500 transition duration-300">Gói Tập</a></li>

                <li class="dropdown">
                    <a class="hover:text-red-500 transition duration-300 dropdown-toggle" href="#" id="dichvuDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Dịch vụ
                    </a>
                    <ul class="dropdown-menu absolute bg-gray-800 text-white rounded-lg mt-2" aria-labelledby="dichvuDropdown">
                        <li><a class="dropdown-item" href="DvThuGian">Dịch vụ thư giãn</a></li>
                        <li><a class="dropdown-item" href="#">Dịch vụ tập luyện</a></li>

                    </ul>
                </li>
                <li><a class="hover:text-red-500 transition duration-300" href="/gym/app/views/account/login.php">Đăng Nhập</a></li>
                <li><a class="nav-link hover:text-red-500 transition duration-300" href="/app/views/account/logout">Đăng Xuất</a></li>
                <li><a href="#" class="hover:text-red-500 transition duration-300">Liên hệ</a></li>
            </ul>
        </nav>
    </header>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
<?php
// Xử lý đăng nhập
$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Giả lập kiểm tra username và password (đây chỉ là ví dụ)
    if ($username === 'admin' && $password === '123456') {
        $loginMessage = "Đăng nhập thành công! Xin chào $username.";
    } else {
        $loginMessage = "Sai tên đăng nhập hoặc mật khẩu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gym & Fitness</title>
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

    .message {
        text-align: center;
        margin: 20px;
        color: red;
        font-weight: bold;
    }

    .hero-section {
        background-image: url('/Gym/public/images/bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        background-color: rgba(0, 0, 0, 0.5);
        width: 100vw;
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    .hero-section h1,
    .hero-section p {
        color: #fff;
        /* Đảm bảo nội dung nổi bật trên nền */
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        /* Thêm bóng để đọc rõ hơn */
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
                <li><a href="/Gym/" class="hover:text-red-500 transition duration-300">Trang chủ</a></li>
                <li><a href="/Gym/app/views/package/showGoiTap.php" class="hover:text-red-500 transition duration-300">Gói Tập</a></li>
                <li><a href="#" class="hover:text-red-500 transition duration-300">Dịch vụ</a></li>
                <li>
                    <?php if (SessionHelper::isLoggedIn()) : ?>
                        <a class="nav-link"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <?php else: ?>
                        <a class="hover:text-red-500 transition duration-300" href="/gym/app/views/account/login.php">Đăng Nhập</a>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if (SessionHelper::isLoggedIn()) : ?>
                        <a class="nav-link hover:text-red-500 transition duration-300" href="/Gym/app/controllers/AccountController.php?action=logout">Đăng Xuất</a>
                    <?php endif; ?>
                </li>
                <li><a href="#" class="hover:text-red-500 transition duration-300">Liên hệ</a></li>
            </ul>
        </nav>
    </header>
    <main class="container mx-px">
        <section class="hero-section text-white py-8">
            <div class="container mx-auto px-4">
                <h1 class="text-5xl font-bold mb-4 text-left">Giới thiệu về L&D CENTER</h1>
                <p class="text-lg text-left">Tìm hiểu thêm về chúng tôi và sứ mệnh xây dựng cộng đồng khỏe mạnh</p>
            </div>
        </section>
        <section class="hero bg-gray-200 text-gray-800 text-center rounded-lg py-10 px-4 mt-20">
            <h1 class="text-3xl font-bold mb-4 font-poppins">
                Mạnh mẽ từ bên trong - Khỏe đẹp từ bên ngoài
            </h1>
            <p class="text-lg font-poppins max-w-2xl mx-auto mb-4">
                Rèn luyện không chỉ giúp bạn nâng cao thể lực mà còn rèn giũa ý chí, giúp bạn sẵn sàng đối mặt với mọi thử thách. Mỗi bước tiến là một cơ hội để vượt qua giới hạn, bứt phá và vươn tới phiên bản tốt nhất của chính mình.
            </p>
            <p class="text-lg max-w-2xl mx-auto mb-4 font-poppins">
                Hãy cùng chúng tôi khám phá những gói tập đa dạng và phong phú, được thiết kế riêng cho bạn. Từ những bài tập cơ bản đến những chương trình huấn luyện chuyên sâu, chúng tôi cam kết mang đến cho bạn trải nghiệm tập luyện tuyệt vời nhất.
        </section>
    </main>
    <div class="container mx-auto px-4 mt-8">
        <div id="carouselExampleCaptions" class="carousel slide rounded-lg shadow-lg overflow-hidden">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="public/images/equip1.webp" class="d-block w-100 carousel-img" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Chào mừng bạn đến với LD Fitness</h5>
                        <p>LD Fitness tin rằng mọi người, ở mọi nơi, đều nên được tiếp cận với hoạt động thể chất và những lợi ích tuyệt vời về thể chất, tinh thần và cảm xúc mà nó mang lại.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/images/equip2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Trang thiết bị hiện đại</h5>
                        <p>Chúng tôi đầu tư vào các thiết bị tập luyện hiện đại nhất, đảm bảo trải nghiệm tập luyện tốt nhất cho bạn..</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/images/equip3.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Trải nghiệm các dịch vụ</h5>
                        <p>Chúng tôi cung cấp những dịch vụ thư giản như xông hơi, massage, giãn cơ..., giúp bạn thư giãn sau những giờ tập năng động</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/images/equip4.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Huấn luyện viên luôn đồng hành cùng bạn</h5>
                        <p>Đội ngũ huấn luyện viên của chúng tôi được chứng nhận và có nhiều năm kinh nghiệm, sẵn sàng hỗ trợ bạn đạt được mục tiêu.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/images/equip5.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Cộng đồng tập luyện và truyền cảm hứng</h5>
                        <p>Cùng hàng ngàn hội viên lan toả lối sống lành mạnh ngay hôm nay! Đã đến lúc bạn nên thử những điều mới mẻ, hướng tới cuộc sống hứng khởi và tự tin toả sáng.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <?php if ($loginMessage): ?>
        <div class="message"><?= htmlspecialchars($loginMessage) ?></div>
    <?php endif; ?>

    <div class="overlay" id="overlay">
        <div class="form-container">
            <button class="close-btn" id="closeFormBtn">&times;</button>
            <h2 class="login-title" style="font-size: 2em;">Đăng Nhập</h2>
            <form action="" method=" POST">
                <div class="input-box">
                    <input type="text" name="username" placeholder="Nhập tài khoản" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="pass black-text">Quên mật khẩu?</div>
                <input type="submit" value="Đăng nhập">
                <div class="signup_link black-text">
                    Bạn chưa có tài khoản? <a href="/Gym/app/views/account/signup.php" class="black-text">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const openLoginFormBtn = document.getElementById('openLoginFormBtn');
        const closeFormBtn = document.getElementById('closeFormBtn');
        const overlay = document.getElementById('overlay');

        openLoginFormBtn.addEventListener('click', function() {
            overlay.style.display = 'flex';
        });

        closeFormBtn.addEventListener('click', function() {
            overlay.style.display = 'none';
        });
    </script>
</body>

</html>
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        width: 350px;
        text-align: center;
        position: relative;
    }

    .form-container input {
        width: 80%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .form-container input[type="submit"] {
        background-color: rgb(143, 33, 33);
        color: white;
        border: none;
        cursor: pointer;
    }

    .login-title,
    .pass.black-text,
    .signup_link.black-text,
    .signup_link.black-text a {
        color: #000 !important;
    }
</style>
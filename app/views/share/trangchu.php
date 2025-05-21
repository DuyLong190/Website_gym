<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gym & Fitness</title>
    <link rel="stylesheet" href="/public/css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
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

    .hero-section p {
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .carousel-item img {
        width: 100%;
        height: 85vh;
        object-fit: cover;
    }

    .carousel-caption {
        background: rgba(115, 110, 110, 0.7);
        border-radius: 10px;
        padding: 20px;
        bottom: 30px;
    }

    .carousel-caption h5 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .carousel-caption p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
</style>

<body>
    <main class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class="display-4 fw-bold mb-3 text-left">Giới thiệu về L&D CENTER</h1>
                <p class="lead text-left">THÂN KHỎE / TRÍ SÁNG / TÂM AN</p>
            </div>
        </section>
        <section class="bg-light text-dark text-center rounded-4 py-5 px-4 mt-5 shadow">
            <h1 class="h2 fw-bold mb-4">
                Mạnh mẽ từ bên trong - Khỏe đẹp từ bên ngoài
            </h1>
            <p class="fs-5 mx-auto mb-3" style="max-width: 700px;">
                Rèn luyện không chỉ giúp bạn nâng cao thể lực mà còn rèn giũa ý chí, giúp bạn sẵn sàng đối mặt với mọi thử thách. Mỗi bước tiến là một cơ hội để vượt qua giới hạn, bứt phá và vươn tới phiên bản tốt nhất của chính mình.
            </p>
            <p class="fs-5 mx-auto mb-3" style="max-width: 700px;">
                Hãy cùng chúng tôi khám phá những gói tập đa dạng và phong phú, được thiết kế riêng cho bạn. Từ những bài tập cơ bản đến những chương trình huấn luyện chuyên sâu, chúng tôi cam kết mang đến cho bạn trải nghiệm tập luyện tuyệt vời nhất.
            </p>
        </section>
        <div class="container py-5 mb-5">
            <div id="carouselExampleCaptions" class="carousel slide rounded-4 shadow-lg overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/Gym/public/images/equip1.webp" class="d-block w-100 carousel-img" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Chào mừng bạn đến với LD Fitness</h5>
                            <p>LD Fitness tin rằng mọi người, ở mọi nơi, đều nên được tiếp cận với hoạt động thể chất <br>
                                và những lợi ích tuyệt vời về thể chất, tinh thần và cảm xúc mà nó mang lại.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/Gym/public/images/equip2.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Trang thiết bị hiện đại</h5>
                            <p>Chúng tôi đầu tư vào các thiết bị tập luyện hiện đại nhất, đảm bảo trải nghiệm tập luyện tốt nhất cho bạn..</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/Gym/public/images/equip3.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Trải nghiệm các dịch vụ</h5>
                            <p>Chúng tôi cung cấp những dịch vụ thư giản như xông hơi, massage, giãn cơ..., <br>
                                giúp bạn thư giãn sau những giờ tập năng động</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/Gym/public/images/equip4.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Huấn luyện viên luôn đồng hành cùng bạn</h5>
                            <p>Đội ngũ huấn luyện viên của chúng tôi được chứng nhận và có nhiều năm kinh nghiệm,<br>
                                sẵn sàng hỗ trợ bạn đạt được mục tiêu.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/Gym/public/images/equip5.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Cộng đồng tập luyện và truyền cảm hứng</h5>
                            <p>Cùng hàng ngàn hội viên lan toả lối sống lành mạnh ngay hôm nay! <br>
                                Đã đến lúc bạn nên thử những điều mới mẻ, hướng tới cuộc sống hứng khởi và tự tin toả sáng.</p>
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
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
</style>
<link rel="stylesheet" href="/gym/public/css/trangchu.css">
<link rel="stylesheet" href="/Gym/public/css/carousel.css">
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: "#dc2626",
                    "background-light": "#f8fafc",
                    "background-dark": "#1e293b",
                    "surface-light": "#ffffff",
                    "surface-dark": "#334155",
                    "text-light-primary": "#1e293b",
                    "text-dark-primary": "#f8fafc",
                    "text-light-secondary": "#64748b",
                    "text-dark-secondary": "#cbd5e1",
                },
                fontFamily: {
                    display: ["'Be Vietnam Pro'", "sans-serif"],
                },
                borderRadius: {
                    DEFAULT: "1rem",
                },
            },
        },
    };
</script>
<main class="relative min-h-screen">

    <section class="hero-bg h-[60vh] md:h-[70vh] flex items-center justify-center text-center text-white pt-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        <div class="max-w-4xl px-4 relative z-10 animate-fade-in">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-4 drop-shadow-2xl transform hover:scale-105 transition-transform duration-300">
                Giới thiệu về L&amp;D CENTER
            </h1>
            <p class="mt-4 text-lg md:text-xl text-slate-200 uppercase tracking-widest font-medium drop-shadow-lg">
                THÂN KHỎE / TRÍ SÁNG / TÂM AN
            </p>
        </div>
    </section>
    <section class="py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="max-w-4xl mx-auto bg-surface-dark dark:bg-surface-dark p-8 sm:p-12 lg:p-16 rounded-2xl shadow-2xl -mt-32 md:-mt-48 relative z-10 border border-white/10 backdrop-blur-sm hover:shadow-3xl transition-all duration-300">
                <h2
                    class="text-3xl md:text-4xl font-bold text-center text-text-light-primary dark:text-text-dark-primary mb-4">
                    Mạnh mẽ từ bên trong - Khỏe đẹp từ bên ngoài</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary/60 mx-auto my-6 rounded-full"></div>
                <p
                    class="text-base md:text-lg text-center text-text-light-secondary dark:text-text-dark-secondary mb-4">
                    Rèn luyện không chỉ giúp bạn nâng cao thể lực mà còn rèn giũa ý chí, giúp bạn sẵn sàng đối mặt
                    với mọi thử thách. Mỗi bước tiến là một cơ hội để vượt qua giới hạn, bứt phá và vươn tới phiên
                    bản tốt nhất của chính mình.
                </p>
                <p
                    class="text-base md:text-lg text-center text-text-light-secondary dark:text-text-dark-secondary">
                    Hãy cùng chúng tôi khám phá những gói tập đa dạng và phong phú, được thiết kế riêng cho bạn. Từ
                    những bài tập cơ bản đến những chương trình huấn luyện chuyên sâu, chúng tôi cam kết mang đến cho
                    bạn trải nghiệm tập luyện tuyệt vời nhất.
                </p>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="py-8 sm:py-12">
        <div class="carousel-container">
            <div class="slide">
                <div class="item" style="background-image: url('/Gym/public/images/equip1.png');">
                    <div class="content">
                        <div class="name">Chào mừng đến với LD Fitness</div>
                        <div class="des">
                            LD Fitness tin rằng mọi người, ở mọi nơi, đều nên được tiếp cận với hoạt động thể chất và những lợi ích tuyệt vời về thể chất, tinh thần và cảm xúc mà nó mang lại.
                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url('/Gym/public/images/equip2.jpg');">
                    <div class="content">
                        <div class="name">Trang thiết bị hiện đại</div>
                        <div class="des">
                            Chúng tôi đầu tư vào các thiết bị tập luyện hiện đại nhất, đảm bảo trải nghiệm tập luyện tốt nhất cho bạn.
                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url('/Gym/public/images/equip3.jpg');">
                    <div class="content">
                        <div class="name">Trải nghiệm các dịch vụ</div>
                        <div class="des">
                            Chúng tôi cung cấp những dịch vụ thư giãn như xông hơi, massage, giãn cơ..., giúp bạn thư giãn sau những giờ tập năng động.
                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url('/Gym/public/images/equip4.jpg');">
                    <div class="content">
                        <div class="name">Huấn luyện viên chuyên nghiệp</div>
                        <div class="des">
                            Đội ngũ huấn luyện viên của chúng tôi được chứng nhận và có nhiều năm kinh nghiệm, sẵn sàng hỗ trợ bạn đạt được mục tiêu.
                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url('/Gym/public/images/equip5.jpg');">
                    <div class="content">
                        <div class="name">Cộng đồng tập luyện</div>
                        <div class="des">
                            Cùng hàng ngàn hội viên lan toả lối sống lành mạnh ngay hôm nay! Đã đến lúc bạn nên thử những điều mới mẻ, hướng tới cuộc sống hứng khởi và tự tin toả sáng.
                        </div>
                    </div>
                </div>
            </div>
            <div class="button">
                <button class="prev">◁</button>
                <button class="next">▷</button>
            </div>
        </div>
    </section>

    <section class="py-8 sm:py-12 bg-background-light dark:bg-slate-900/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-text-light-primary dark:text-text-dark-primary">
                    Lý do chọn chúng tôi</h3>
                <p class="mt-2 text-lg text-text-light-secondary dark:text-text-dark-secondary">Cam kết mang lại
                    trải nghiệm tốt nhất cho hội viên.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">sell</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Giá tốt nhất</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">299k 1 tháng lẻ,
                        897k 4 tháng</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">description</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Không hợp đồng</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">Không phí quản lý,
                        không ràng buộc</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">schedule</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Mở cửa 24/7</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">(sau 22h, trước
                        6h nhấn chuông)</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">groups</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Chào đón PT Freelancer</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">Cấm chào kéo</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">all_inclusive</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Hệ thống toàn diện</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">Tập toàn hệ thống
                        không phụ phí</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">local_drink</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Tiện ích miễn phí</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">FREE: Nước, giữ
                        xe, khăn tập</p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">ac_unit</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Không gian thoải mái</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">Máy lạnh mát mẻ
                    </p>
                </div>
                <div class="text-center flex flex-col items-center  p-3 rounded-xl ">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110">
                        <span class="material-icons-outlined text-primary text-4xl">cleaning_services</span>
                    </div>
                    <h4 class="font-semibold text-lg mb-1 text-text-light-primary dark:text-text-dark-primary group-hover:text-primary transition-colors">
                        Luôn sạch sẽ</h4>
                    <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">Phòng tập sạch
                        sẽ, thoáng đãng</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Cơ sở vật chất -->
    <section class="py-8 sm:py-12 bg-gradient-to-b from-background-light to-slate-50 dark:from-slate-900 dark:to-slate-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-4xl md:text-5xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                    Cơ sở vật chất hiện đại
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary/60 mx-auto my-6 rounded-full"></div>
                <p class="text-lg text-text-light-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
                    Đầu tư trang thiết bị hàng đầu, không gian rộng rãi và tiện nghi để mang đến trải nghiệm tập luyện tốt nhất
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-8">
                <!-- Thiết bị tập luyện -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="/Gym/public/images/Thietbitapluyen.jpg" alt="Thiết bị tập luyện" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-2xl font-bold text-white mb-2">Thiết bị tập luyện đẳng cấp</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3 text-text-light-secondary dark:text-text-dark-secondary">
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">fitness_center</span>
                                <span>Hệ thống máy tập đa năng từ các thương hiệu hàng đầu thế giới</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">sports_gymnastics</span>
                                <span>Khu vực tập tự do với tạ đơn, tạ đĩa đầy đủ kích cỡ</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">directions_run</span>
                                <span>Máy chạy bộ, xe đạp tập hiện đại với màn hình cảm ứng</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">update</span>
                                <span>Thiết bị được bảo trì và nâng cấp thường xuyên</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Không gian tập luyện -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="/Gym/public/images/khonggian.jpg" alt="Không gian tập luyện" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-2xl font-bold text-white mb-2">Không gian rộng rãi, thoáng mát</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3 text-text-light-secondary dark:text-text-dark-secondary">
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">square_foot</span>
                                <span>Diện tích hơn 500m² với trần cao, không gian thoáng đãng</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">ac_unit</span>
                                <span>Hệ thống điều hòa không khí hiện đại, nhiệt độ lý tưởng</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">light_mode</span>
                                <span>Ánh sáng tự nhiên và đèn LED tiết kiệm năng lượng</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons-outlined text-primary mr-3 mt-1">air</span>
                                <span>Hệ thống thông gió và lọc không khí chất lượng cao</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gallery ảnh cơ sở vật chất -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="relative h-48 rounded-xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/csvc1.jpg" alt="Cơ sở vật chất 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                </div>
                <div class="relative h-48 rounded-xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/csvc2.jpg" alt="Cơ sở vật chất 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                </div>
                <div class="relative h-48 rounded-xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/csvc3.jpg" alt="Cơ sở vật chất 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                </div>
                <div class="relative h-48 rounded-xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/csvc4.jpg" alt="Cơ sở vật chất 4" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Chất lượng tập luyện -->
    <section class="py-8 sm:py-12 bg-background-light dark:bg-slate-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-4xl md:text-5xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                    Chất lượng tập luyện hàng đầu
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary/60 mx-auto my-6 rounded-full"></div>
                <p class="text-lg text-text-light-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
                    Cam kết mang đến chương trình tập luyện chuyên nghiệp, hiệu quả và phù hợp với từng mục tiêu của bạn
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Chương trình đa dạng -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 text-center group">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-icons-outlined text-primary text-5xl">sports_martial_arts</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                        Chương trình đa dạng
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary mb-4">
                        Từ tập luyện cơ bản đến nâng cao, từ cardio đến strength training, chúng tôi có đầy đủ chương trình phù hợp với mọi nhu cầu
                    </p>
                    <div class="relative h-48 rounded-xl overflow-hidden mt-6">
                        <img src="/Gym/public/images/chuongtrinhtapluyen.jpg" alt="Chương trình tập luyện" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>

                <!-- Huấn luyện viên chuyên nghiệp -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 text-center group">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-icons-outlined text-primary text-5xl">person</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                        Huấn luyện viên chuyên nghiệp
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary mb-4">
                        Đội ngũ PT được chứng nhận quốc tế, giàu kinh nghiệm, luôn sẵn sàng tư vấn và hỗ trợ bạn đạt mục tiêu
                    </p>
                    <div class="relative h-48 rounded-xl overflow-hidden mt-6">
                        <img src="/Gym/public/images/hlv.jpg" alt="Huấn luyện viên" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>

                <!-- Phương pháp khoa học -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 text-center group">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-icons-outlined text-primary text-5xl">science</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                        Phương pháp khoa học
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary mb-4">
                        Áp dụng các phương pháp tập luyện được nghiên cứu và chứng minh hiệu quả, đảm bảo an toàn và tối ưu kết quả
                    </p>
                    <div class="relative h-48 rounded-xl overflow-hidden mt-6">
                        <img src="/Gym/public/images/phuongphaptapluyen.jpg" alt="Phương pháp tập luyện" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
            </div>

            <!-- Thống kê chất lượng -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                <div class="text-center bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg">
                    <div class="text-4xl md:text-5xl font-bold text-primary mb-2">1000+</div>
                    <div class="text-text-light-secondary dark:text-text-dark-secondary">Hội viên hài lòng</div>
                </div>
                <div class="text-center bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg">
                    <div class="text-4xl md:text-5xl font-bold text-primary mb-2">50+</div>
                    <div class="text-text-light-secondary dark:text-text-dark-secondary">Thiết bị hiện đại</div>
                </div>
                <div class="text-center bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg">
                    <div class="text-4xl md:text-5xl font-bold text-primary mb-2">15+</div>
                    <div class="text-text-light-secondary dark:text-text-dark-secondary">Huấn luyện viên</div>
                </div>
                <div class="text-center bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg">
                    <div class="text-4xl md:text-5xl font-bold text-primary mb-2">24/7</div>
                    <div class="text-text-light-secondary dark:text-text-dark-secondary">Mở cửa phục vụ</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Tiện ích và dịch vụ -->
    <section class="py-8 sm:py-12 bg-gradient-to-b from-slate-50 to-background-light dark:from-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-4xl md:text-5xl font-bold text-text-light-primary dark:text-text-dark-primary mb-4">
                    Tiện ích & Dịch vụ
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary/60 mx-auto my-6 rounded-full"></div>
                <p class="text-lg text-text-light-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
                    Những tiện ích miễn phí và dịch vụ chất lượng để nâng cao trải nghiệm tập luyện của bạn
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">local_drink</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">Nước uống miễn phí</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Hệ thống nước lọc tinh khiết, luôn sẵn sàng phục vụ bạn</p>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">local_parking</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">Giữ xe miễn phí</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Bãi đỗ xe rộng rãi, an toàn và miễn phí cho hội viên</p>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">dry_cleaning</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">Khăn tập miễn phí</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Khăn sạch sẽ, được giặt và thay mới hàng ngày</p>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">shower</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">Phòng tắm & thay đồ</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Phòng tắm sạch sẽ, đầy đủ tiện nghi, tủ đồ cá nhân</p>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">wifi</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">WiFi miễn phí</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Kết nối internet tốc độ cao, phủ sóng toàn bộ phòng tập</p>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <span class="material-icons-outlined text-primary text-3xl">security</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-text-light-primary dark:text-text-dark-primary mb-2">An ninh 24/7</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary">Hệ thống camera giám sát, bảo vệ an toàn cho hội viên</p>
                    </div>
                </div>
            </div>

            <!-- Ảnh tiện ích -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative h-64 rounded-2xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/tienich1.webp" alt="Tiện ích 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h4 class="text-2xl font-bold text-white mb-2">Không gian thư giãn</h4>
                        <p class="text-white/90">Khu vực nghỉ ngơi, thư giãn sau tập luyện</p>
                    </div>
                </div>
                <div class="relative h-64 rounded-2xl overflow-hidden group cursor-pointer">
                    <img src="/Gym/public/images/tienich2.jpg" alt="Tiện ích 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h4 class="text-2xl font-bold text-white mb-2">Phòng thay đồ hiện đại</h4>
                        <p class="text-white/90">Tủ đồ cá nhân, phòng tắm tiện nghi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

</main>
<script src="/Gym/public/js/carousel.js"></script>
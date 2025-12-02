<style>
    body {
        margin-left: 15%;
        background-color: #fbfbfb;
    }

    @media (min-width: 991.98px) {
        main {
            padding-left: 240px;
        }
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        padding: 58px 0 0;
        /* Height of navbar */
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
        width: 240px;
        z-index: 600;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            width: 100%;
        }
    }

    .sidebar .active {
        border-radius: 5px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto;
        /* Scrollable contents if viewport is shorter than content. */
    }
</style>
<title>Thông tin cá nhân</title>
<!--Main Navigation-->
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="text-center mb-4">
                <img
                    src="/Gym/public/images/user.png"
                    alt="Avatar"
                    class="rounded-circle"
                    style="width: 90px; height: 90px; object-fit: cover; border: 3px solid #eee; margin-top: 10px;">
                <div class="fw-bold mt-2" style="font-size: 1.1rem;">
                    <?php echo isset($_SESSION['HoTen']) ? htmlspecialchars($_SESSION['HoTen']) : 'Tài khoản'; ?>
                </div>
            </div>
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/gym/user/profile" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-user fa-fw me-3"></i>
                    <span>Thông tin cá nhân</span>
                </a>
                <a href="/gym/user/chitiet_goitap" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-dumbbell fa-fw me-3"></i>
                    <span>Gói tập của tôi</span>
                </a>
                <a href="/gym/user/lichlophoc" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-calendar fa-fw me-3"></i>
                    <span>Lịch tập</span>
                </a>
                <a href="/gym/user/lophoc" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-list-check fa-fw me-3"></i>
                    <span>Lớp học</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-clock-rotate-left fa-fw me-3"></i>
                    <span>Lịch sử hoạt động</span>
                </a>
                <a href="/gym" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-home fa-fw me-3"></i>
                    <span>Về trang chủ</span>
                </a>
                <a href="/gym/account/logout" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-arrow-right-from-bracket fa-fw me-3"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px;">
    <div class="container pt-4"></div>
</main>
<!--Main layout-->
<!-- Bootstrap JS (bundle includes Popper) -->

<!-- Font Awesome (nếu chưa có) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
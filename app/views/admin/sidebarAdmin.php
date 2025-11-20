<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #fbfbfb;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 240px;
            padding: 58px 0 0;
            background: #fff;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            z-index: 600;
            transition: width 0.2s;
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 58px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                padding: 0;
            }

            main {
                padding-left: 0 !important;
            }
        }

        main {
            padding-left: 240px;
            margin-top: 58px;
            transition: padding-left 0.2s;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-sticky">
            <div class="text-center mb-4">
                <img
                    src="/Gym/public/images/user.png"
                    alt="Avatar"
                    class="rounded-circle"
                    style="width: 90px; height: 90px; object-fit: cover; border: 3px solid #eee; margin-top: 10px;">
                <div class="fw-bold mt-2" style="font-size: 1.1rem;">
                    <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>
                </div>
            </div>
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/gym/admin/statistics" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i>
                    <span>Thống kê</span>
                </a>
                <a href="/gym/admin/user" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-users fa-fw me-3"></i>
                    <span>Hội viên</span>
                </a>
                <a href="/gym/admin/goitap" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-bar fa-fw me-3"></i>
                    <span>Gói tập</span>
                </a>
                <a href="/gym/admin/DvThuGian" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-heart fa-fw me-3"></i>
                    <span>Dịch vụ thư giãn</span>
                </a>
                <a href="/gym/admin/lophoc" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-hand-fist fa-fw me-3"></i>
                    <span>Lớp học</span>
                </a>
                <a href="/gym/admin/pt" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-user-tie fa-fw me-3"></i>
                    <span>Huấn luyện viên</span>
                </a>
                <a href="/gym/admin/account" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-user-shield fa-fw me-3"></i>
                    <span>Quản lý tài khoản</span>
                </a>
                <a href="/gym/admin/lichlophoc" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-calendar fa-fw me-3"></i>
                    <span>Lịch lớp học</span>
                </a>
                <a href="/gym/admin/yeucau" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-code-pull-request fa-fw me-3"></i>
                    <span>Yêu cầu xác nhận</span>
                </a>
                <a href="/gym" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-home fa-fw me-3"></i>
                    <span>Về trang chủ</span>
                </a>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Main content -->
    <main>
        <div class="container pt-4">
            <!-- Nội dung chính sẽ được include ở đây -->
        </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
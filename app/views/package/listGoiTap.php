<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách gói tập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gym/public/css/style.css">
    <!-- Thêm SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .package-card {
            padding-left: 25px;
            padding-right: 25px;
            background: linear-gradient(rgba(45, 4, 0, 0.88), rgba(47, 45, 45, 0.96));
            /* Đổi màu nền ở đây */
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 24px;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(31, 38, 135, 0.08);
            border: none;
        }

        .package-card:hover {
            transform: translateY(-7px) scale(1.02);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }

        .package-badge {
            font-size: 1.1rem;
            background: #8f2121;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.4em 1em;
            margin-bottom: 1em;
            display: inline-flex;
            text-align: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .package-price {
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
            text-align: center;
        }

        .currency-symbol {
            font-size: 1rem;
            vertical-align: super;
        }

        .card-text {

            color: rgb(255, 255, 255);
        }

        .hero-section {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            position: relative;
            background-image: url('/Gym/public/images/banner.png');
            background-size: cover;
            background-position: center;
            width: 100vw;
            min-height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            box-shadow:
                0 0 10px rgb(255, 255, 255),
                0 0 30px rgb(253, 253, 253);
            border-radius: 10px;
        }

        .line-custom {
            border: 1px solid #fff !important;
            margin: 10px 0;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class=" text-center">GÓI TẬP</h1>
            </div>
        </section>
        <?php if (!empty($goiTaps)): ?>
            <div class="row">
                <?php foreach ($goiTaps as $goiTap): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <h5 class="package-badge card-text mb-2">
                                    <?php echo htmlspecialchars($goiTap['TenGoiTap'] ?? ''); ?>
                                </h5>
                                <span class="package-price ">
                                    <?php
                                    $giaTien = $goiTap['GiaTien'] ?? 0;
                                    echo $giaTien ? number_format((float)$giaTien) : '';
                                    ?>
                                    <?php if ($giaTien): ?>
                                        <span class="currency-symbol">Đ</span>
                                    <?php endif; ?>
                                </span>
                                <hr class="line-custom">
                                <p class="card-text mb-1"><strong>Thời hạn:</strong>
                                    <?php
                                    $thoiHan = $goiTap['ThoiHan'] ?? '';
                                    echo $thoiHan ? htmlspecialchars($thoiHan) . ' tháng' : '';
                                    ?>
                                </p>
                                <p class="card-text mb-3"><br>
                                    <?php
                                    $moTa = $goiTap['MoTa'] ?? '';
                                    $moTa = htmlspecialchars($moTa);
                                    $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                    foreach ($cauArr as $cau) {
                                        echo '• ' . $cau . '.<br>';
                                    }
                                    ?>
                                </p>
                                <hr class="line-custom">
                                <div class="mt-auto gap-2 d-flex ">
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <?php
                                        $username = $_SESSION['username'];
                                        $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);
                                        if (empty($hoiVien->MaGoiTap)):
                                        ?>
                                            <a href="/gym/goitap/select/<?php echo $goiTap['MaGoiTap']; ?>" class="btn btn-outline-warning flex-fill">
                                                <i class="fa fa-edit"></i> Đăng ký
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-outline-warning flex-fill" onclick="showAlreadyRegisteredAlert()">
                                                <i class="fa fa-edit"></i> Đăng ký
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="/gym/account/login" class="btn btn-outline-warning flex-fill">
                                            <i class="fa fa-sign-in"></i> Đăng nhập để đăng ký
                                        </a>
                                    <?php endif; ?>
                                    <a href="/gym/goitap/show/<?php echo $goiTap['MaGoiTap']; ?>" class="btn btn-outline-info flex-fill">
                                        <i class="fa fa-info-circle"></i> Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không có gói tập nào.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Thêm SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        function showAlreadyRegisteredAlert() {
            Swal.fire({
                title: 'Thông báo',
                text: 'Bạn đang có gói tập khác',
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>
</body>

</html>
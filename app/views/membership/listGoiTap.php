<div class="container">
    <section class="hero-section text-white py-5 mb-5">
        <div class="container px-4">
            <h1 class="text-center">GÓI TẬP</h1>
        </div>
    </section>
    <?php if (!empty($goiTaps)): ?>
        <div class="row">
            <?php foreach ($goiTaps as $goiTap): ?>
                <div class="col-md-6 col-lg-4 d-flex">
                    <ul class="product-plans">
                        <li class="product-plan">
                            <div class="title"><?php echo htmlspecialchars($goiTap['TenGoiTap'] ?? ''); ?></div>
                            <div class="price"><?php echo number_format($goiTap['GiaTien']); ?>
                                <span class="currency-symbol">Đ</span>
                            </div>
                            <div class="duration-info">
                                <i class="fa fa-calendar-alt"></i>
                                <span class="duration-label">Thời hạn:</span>
                                <span class="duration-value"><?php
                                                                $thoiHan = $goiTap['ThoiHan'] ?? '';
                                                                echo $thoiHan ? htmlspecialchars($thoiHan) . ' tháng' : '';
                                                                ?></span>
                            </div>
                            <div class="description-section">
                                
                                <div class="description-content">
                                    <?php
                                    $moTa = $goiTap['MoTa'] ?? '';
                                    $moTa = htmlspecialchars($moTa);
                                    $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                    foreach ($cauArr as $cau) {
                                        echo '<div class="description-item">' . htmlspecialchars($cau) . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-auto gap-2 d-flex ">
                                <?php if (isset($_SESSION['username']) && $hoiVien): ?>
                                    <?php
                                    if (empty($hoiVien->MaGoiTap)):
                                    ?>
                                        <a href="/gym/goitap/select/<?php echo $goiTap['MaGoiTap']; ?>" class="btn ">Chọn
                                        </a>
                                    <?php else: ?>
                                        <button class="btn" onclick="showAlreadyRegisteredAlert()">Chọn
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="/gym/account/login" class="btn btn-outline-warning ">
                                        <i class=""></i> Đăng ký
                                    </a>
                                <?php endif; ?>
                                <a href="/gym/goitap/show/<?php echo $goiTap['MaGoiTap']; ?>" class="btn-detail">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Không có gói tập nào.</div>
    <?php endif; ?>
</div>

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
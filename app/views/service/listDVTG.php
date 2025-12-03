    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class="text-center">DỊCH VỤ THƯ GIÃN</h1>
            </div>
        </section>
        <?php if (!empty($DVTGs)): ?>
            <div class="row">
                <?php foreach ($DVTGs as $DVTG): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <h5 class="package-badge card-text mb-2">
                                    <?php echo htmlspecialchars($DVTG->TenTG); ?>
                                </h5>
                                <span class="package-price">
                                    <?php echo number_format($DVTG->GiaTG); ?>
                                    <span class="currency-symbol">Đ</span>
                                </span>
                                <hr class="line-custom">
                                <p class="card-text mb-1"><strong>Thời gian sử dụng:</strong>
                                    <?php echo htmlspecialchars($DVTG->ThoiGianTG); ?> phút
                                </p>
                                <p class="card-text mb-3 py-3">
                                    <?php $moTa = htmlspecialchars($DVTG->MoTaTG);
                                    $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                    foreach ($cauArr as $cau) {
                                        echo '• ' . $cau . '.<br>';
                                    } ?>
                                </p>
                                <hr class="line-custom">
                                <div class="mt-auto gap-2 d-flex">
                                    <a href="#" class="btn btn-outline-warning flex-fill">
                                        <i class="fa fa-edit"></i> Đăng ký
                                    </a>
                                    <a href="/gym/DvThuGian/show/<?php echo $DVTG->id; ?>" class="btn btn-outline-info flex-fill">
                                        <i class="fa fa-info-circle"></i> Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không có dịch vụ thư giãn nào.</div>
        <?php endif; ?>
    </div>
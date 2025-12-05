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
                    <ul class="product-plans">
                        <li class="product-plan">
                            <div class="title">
                                <?php echo htmlspecialchars($DVTG->TenTG); ?>
                            </div>
                            <div class="price">
                                <?php echo number_format($DVTG->GiaTG); ?>
                                <span class="currency-symbol">Đ</span>
                            </div>
                            <div class="duration-info">
                                <i class="fa fa-calendar-alt"></i>
                                <span class="duration-label">Thời gian sử dụng:</span>
                                <span class="duration-value"><?php echo htmlspecialchars($DVTG->ThoiGianTG); ?> phút</span>
                            </div>
                            <div class="description-content">
                                <?php $moTa = htmlspecialchars($DVTG->MoTaTG);
                                $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                foreach ($cauArr as $cau) {
                                    echo '<div class="description-item">' . $cau . '.</div>';
                                } ?>
                            </div>
                            <div class="mt-auto gap-2 d-flex">
                                <a href="#" class="btn ">
                                    <i class=""></i> Chọn
                                </a>
                                <a href="/gym/DvThuGian/show/<?php echo $DVTG->id; ?>" class="btn-detail">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Không có dịch vụ thư giãn nào.</div>
    <?php endif; ?>
</div>
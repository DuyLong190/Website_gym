    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class="text-center"><i></i>LỚP HỌC</h1>
            </div>
        </section>

        <?php if (!empty($lophocs)): ?>
            <div class="row">
                <?php foreach ($lophocs as $lophoc): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card package-card flex-fill d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <!-- Tên lớp học -->
                                <div class="class-name">
                                    <?php echo htmlspecialchars($lophoc->TenLop); ?>
                                </div>

                                <!-- Giá tiền -->
                                <div class="class-price">
                                    <?php echo number_format($lophoc->GiaTien); ?>
                                    <span class="currency-symbol">Đ</span>
                                </div>

                                <hr class="line-custom">

                                <!-- Thời gian khoá học -->
                                <div class="info-row">
                                    <i class="fas fa-calendar-days"></i>
                                    <span class="card-text">
                                        <strong>Bắt đầu:</strong>
                                        <?php echo date('d/m/Y', strtotime($lophoc->NgayBatDau)); ?>
                                    </span>
                                </div>

                                <div class="info-row">
                                    <i class="fas fa-calendar-check"></i>
                                    <span class="card-text">
                                        <strong>Kết thúc:</strong>
                                        <?php echo date('d/m/Y', strtotime($lophoc->NgayKetThuc)); ?>
                                    </span>
                                </div>

                                <!-- PT phụ trách -->
                                <div class="info-row">
                                    <i class="fas fa-user-tie"></i>
                                    <span class="card-text">
                                        <strong>Huấn luyện viên:</strong>
                                        <?php
                                        $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có';
                                        echo htmlspecialchars($tenPT);
                                        ?>
                                    </span>
                                </div>

                                <!-- Số lượng tối đa -->
                                <div class="info-row">
                                    <i class="fas fa-users"></i>
                                    <span class="card-text">
                                        <strong>Sỹ số tối đa:</strong>
                                        <?php echo isset($lophoc->SoLuongToiDa) ? htmlspecialchars($lophoc->SoLuongToiDa) : 'Không xác định'; ?>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <i class="fas fa-user-check"></i>
                                    <span class="card-text">
                                        <strong>Còn trống:</strong>
                                        <?php
                                        $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
                                        $reg = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                        $remaining = ($max > 0) ? max($max - $reg, 0) : null;
                                        if ($remaining === null) {
                                            echo '';
                                        } else {
                                            echo htmlspecialchars((string)$remaining);
                                        }
                                        ?>
                                    </span>

                                </div>

                                <!-- Mô tả -->
                                <?php if (!empty($lophoc->MoTa)): ?>
                                    <div class="info-row">
                                        <span class="card-text">
                                            <strong><i class="fas fa-note-sticky me-2"></i>Mô tả:</strong><br>
                                            <?php
                                            $moTa = htmlspecialchars($lophoc->MoTa);
                                            $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                            foreach ($cauArr as $cau) {
                                                if (!empty($cau)) {
                                                    echo '• ' . $cau . '.<br>';
                                                }
                                            }
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <hr class="line-custom">

                                <!-- Action buttons -->
                                <div class="action-buttons">
                                    <a href="javascript:void(0)" class="btn-custom btn-register" onclick="registerClass(<?php echo $lophoc->MaLop; ?>)">
                                        <i class="fas fa-pen-to-square me-1"></i>Đăng ký
                                    </a>
                                    <a href="/gym/lophoc/show/<?php echo $lophoc->MaLop; ?>" class="btn-custom btn-detail">
                                        <i class="fas fa-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center py-4">
                <i class="fas fa-inbox me-2"></i>Không có lớp học nào.
            </div>
        <?php endif; ?>
    </div>

    <script>
        async function registerClass(maLop) {
            try {
                const response = await fetch('/gym/api/dangkylophoc', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        MaLop: maLop
                    })
                });

                let result = {};
                try {
                    result = await response.json();
                } catch (e) {
                    result = {};
                }

                if (response.status === 401) {
                    alert(result.message || 'Vui lòng đăng nhập để đăng ký lớp học');
                    window.location.href = '/gym/account/login';
                    return;
                }

                if (response.ok && result.success) {
                    if (typeof result.remaining_slots === 'number') {
                        alert((result.message || 'Đăng ký lớp học thành công') + "\nSố chỗ còn lại: " + result.remaining_slots);
                    } else {
                        alert(result.message || 'Đăng ký lớp học thành công');
                    }
                    window.location.href = '/gym/user/lichlophoc?MaLop=' + encodeURIComponent(maLop);
                    return;
                }

                if (result.errors) {
                    if (result.errors.exists) {
                        alert(result.errors.exists);
                        return;
                    }
                    if (result.errors.full) {
                        alert(result.errors.full);
                        return;
                    }
                }

                alert(result.message || 'Đăng ký lớp học thất bại');
            } catch (e) {
                alert('Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    </script>
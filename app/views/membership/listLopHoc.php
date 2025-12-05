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
                    <ul class="product-plans">
                        <li class="product-plan">
                            <div class="title">
                                <?php echo htmlspecialchars($lophoc->TenLop); ?>
                            </div>
                            <div class="price">
                                <?php echo number_format($lophoc->GiaTien); ?>
                                <span class="currency-symbol">Đ</span>
                            </div>
                            <div class="duration-info">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="duration-label">Bắt đầu: </span>
                                <span class="duration-value"> <?php echo date('d/m/Y', strtotime($lophoc->NgayBatDau)); ?></span>

                            </div>
                            <div class="duration-info">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="duration-label">Kết thúc: </span>
                                <span class="duration-value"> <?php echo date('d/m/Y', strtotime($lophoc->NgayKetThuc)); ?></span>
                            </div>
                            
                            <!-- Mô tả -->
                            <div class=description-content>
                                <?php
                                $moTa = htmlspecialchars($lophoc->MoTa);
                                $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                foreach ($cauArr as $cau) {
                                    echo '<div class="description-item"> ' . $cau . '.</div>';
                                } ?>
                            </div>
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

                            <!-- Thông tin số lượng học viên -->
                            <div class="capacity-info">
                                <?php
                                $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
                                $reg = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                $remaining = ($max > 0) ? max($max - $reg, 0) : null;
                                $percentage = ($max > 0) ? min(($reg / $max) * 100, 100) : 0;
                                
                                // Xác định màu sắc và trạng thái
                                $statusClass = 'status-available';
                                $statusText = 'Còn chỗ';
                                if ($max === 0) {
                                    $statusClass = 'status-unknown';
                                    $statusText = 'Không xác định';
                                } elseif ($remaining === 0) {
                                    $statusClass = 'status-full';
                                    $statusText = 'Đã đầy';
                                } elseif ($percentage >= 80) {
                                    $statusClass = 'status-warning';
                                    $statusText = 'Gần đầy';
                                }
                                ?>
                                <div class="capacity-header">
                                    <div class="capacity-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="capacity-stats">
                                        <div class="capacity-numbers">
                                            <span class="capacity-registered"><?php echo $reg; ?></span>
                                            <span class="capacity-separator">/</span>
                                            <span class="capacity-max"><?php echo $max > 0 ? $max : '?'; ?></span>
                                        </div>
                                        <div class="capacity-label">Học viên</div>
                                    </div>
                                    <div class="capacity-status <?php echo $statusClass; ?>">
                                        <span class="status-badge"><?php echo $statusText; ?></span>
                                    </div>
                                </div>
                                <?php if ($max > 0): ?>
                                <div class="capacity-progress">
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-bar-fill <?php echo $statusClass; ?>" 
                                             style="width: <?php echo $percentage; ?>%">
                                        </div>
                                    </div>
                                    <div class="capacity-details">
                                        <span class="detail-item">
                                            <i class="fas fa-user-check"></i>
                                            <span>Đã đăng ký: <strong><?php echo $reg; ?></strong></span>
                                        </span>
                                        <?php if ($remaining !== null): ?>
                                        <span class="detail-item">
                                            <i class="fas fa-user-clock"></i>
                                            <span>Còn trống: <strong><?php echo $remaining; ?></strong></span>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <!-- Action buttons -->
                            <div class="action-buttons">
                                <a href="javascript:void(0)" class="btn" onclick="registerClass(<?php echo $lophoc->MaLop; ?>)">
                                    <i class=""></i>Chọn
                                </a>
                                <a href="/gym/lophoc/show/<?php echo $lophoc->MaLop; ?>" class="btn-detail">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
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
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký dịch vụ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a;
            color: #e5e7eb;
            margin: 0;
            padding: 0;
        }
        .user-wrapper {
            margin-left: 120px;
            padding: 40px 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 991px) {
            .user-wrapper {
                margin-left: 0;
                padding: 100px 16px 40px;
            }
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .user-wrapper {
                margin-left: 100px;
            }
        }
        .card-services {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
            margin-bottom: 24px;
        }
        .service-card {
            background: #1e293b;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 20px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            border-color: #8f2121;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(143, 33, 33, 0.3);
        }
        .status-badge {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-cho-xac-nhan {
            background-color: #f59e0b;
            color: #022c22;
        }
        .status-da-xac-nhan {
            background-color: #22c55e;
            color: #022c22;
        }
        .status-da-huy {
            background-color: #4b5563;
            color: #e5e7eb;
        }
        .status-da-hoan-thanh {
            background-color: #6366f1;
            color: #e5e7eb;
        }
        .btn-register {
            background: linear-gradient(135deg, #8f2121, #aa3a0e);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #aa3a0e, #8f2121);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(143, 33, 33, 0.4);
            color: white;
        }
        .modal-content {
            background: #1e293b;
            color: #e5e7eb;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }
        .form-control, .form-select {
            background: #0f172a;
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: #e5e7eb;
        }
        .form-control:focus, .form-select:focus {
            background: #0f172a;
            border-color: #8f2121;
            color: #e5e7eb;
            box-shadow: 0 0 0 0.2rem rgba(143, 33, 33, 0.25);
        }
        .form-label {
            color: #cbd5e1;
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>
<body>
<div class="user-wrapper">
    <div class="container-fluid">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Danh sách dịch vụ -->
        <div class="card-services">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-spa me-2 text-warning"></i>Dịch vụ thư giãn</h2>
                    <p class="mb-0 text-secondary">Đăng ký dịch vụ thư giãn tại phòng gym</p>
                </div>
            </div>

            <?php if (!empty($dichVus)): ?>
                <div class="row">
                    <?php foreach ($dichVus as $dv): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="service-card">
                                <h5 class="text-white mb-2">
                                    <i class="fas fa-spa me-2 text-warning"></i>
                                    <?= htmlspecialchars($dv->TenTG ?? 'N/A') ?>
                                </h5>
                                <p class="text-secondary small mb-2">
                                    <i class="fas fa-clock me-1"></i>
                                    Thời gian: <?= htmlspecialchars($dv->ThoiGianTG ?? 0) ?> phút
                                </p>
                                <p class="text-warning mb-3 fw-bold">
                                    <i class="fas fa-money-bill me-1"></i>
                                    <?= number_format($dv->GiaTG ?? 0, 0, ',', '.') ?> đ
                                </p>
                                <?php if (!empty($dv->MoTaTG)): ?>
                                    <p class="text-muted small mb-3">
                                        <?= htmlspecialchars($dv->MoTaTG) ?>
                                    </p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-register w-100" onclick="openRegisterModal(<?= htmlspecialchars($dv->id) ?>, '<?= htmlspecialchars($dv->TenTG ?? '') ?>')">
                                    <i class="fas fa-calendar-plus me-1"></i>Đăng ký
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-secondary py-4">
                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                    <p>Hiện tại chưa có dịch vụ nào.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Danh sách đăng ký của tôi -->
        <div class="card-services">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-list-check me-2 text-warning"></i>Đăng ký của tôi</h2>
                    <p class="mb-0 text-secondary">Danh sách các dịch vụ bạn đã đăng ký</p>
                </div>
            </div>

            <?php if (!empty($dangKys)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Dịch vụ</th>
                            <th>Ngày sử dụng</th>
                            <th>Giờ sử dụng</th>
                            <th>Giá</th>
                            <th>Ngày đăng ký</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dangKys as $dk): ?>
                            <?php
                            $trangThai = $dk->TrangThai ?? '';
                            $statusClass = 'status-cho-xac-nhan';
                            $statusText = 'Chờ xác nhận';
                            
                            if ($trangThai === 'Đã xác nhận') {
                                $statusClass = 'status-da-xac-nhan';
                                $statusText = 'Đã xác nhận';
                            } elseif ($trangThai === 'Đã hủy') {
                                $statusClass = 'status-da-huy';
                                $statusText = 'Đã hủy';
                            } elseif ($trangThai === 'Đã hoàn thành') {
                                $statusClass = 'status-da-hoan-thanh';
                                $statusText = 'Đã hoàn thành';
                            }
                            
                            $ngaySuDung = $dk->NgaySuDung ?? '';
                            $formattedNgaySuDung = '';
                            if (!empty($ngaySuDung)) {
                                try {
                                    $dateObj = new DateTime($ngaySuDung);
                                    $formattedNgaySuDung = $dateObj->format('d/m/Y');
                                } catch (Exception $e) {
                                    $formattedNgaySuDung = $ngaySuDung;
                                }
                            }
                            
                            $ngayDangKy = $dk->NgayDangKy ?? '';
                            $formattedNgayDangKy = '';
                            if (!empty($ngayDangKy)) {
                                try {
                                    $dateObj = new DateTime($ngayDangKy);
                                    $formattedNgayDangKy = $dateObj->format('d/m/Y H:i');
                                } catch (Exception $e) {
                                    $formattedNgayDangKy = $ngayDangKy;
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($dk->TenTG ?? 'N/A') ?></strong>
                                </td>
                                <td><?= $formattedNgaySuDung ?: 'N/A' ?></td>
                                <td><?= htmlspecialchars($dk->GioSuDung ?? 'N/A') ?></td>
                                <td class="text-warning fw-bold">
                                    <?= number_format($dk->GiaTG ?? 0, 0, ',', '.') ?> đ
                                </td>
                                <td class="text-secondary small"><?= $formattedNgayDangKy ?: 'N/A' ?></td>
                                <td>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= htmlspecialchars($statusText) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <?php 
                                        $daThanhToan = isset($dk->DaThanhToan) ? (int)$dk->DaThanhToan : 0;
                                        if ($daThanhToan === 0 && isset($dk->id) && ($trangThai === 'Chờ xác nhận' || $trangThai === 'Đã xác nhận')): ?>
                                            <form method="post" action="/gym/ThanhToanHoaDon/confirm_momo" style="display:inline-block;">
                                                <input type="hidden" name="loai" value="DichVu">
                                                <input type="hidden" name="id_dangky" value="<?= htmlspecialchars((string)$dk->id) ?>">
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-money-bill-wave me-1"></i>Thanh toán
                                                </button>
                                            </form>
                                        <?php elseif ($daThanhToan === 1): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Đã thanh toán
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (($trangThai === 'Chờ xác nhận' || $trangThai === 'Đã xác nhận') && isset($dk->id)): ?>
                                            <form method="post" action="/gym/user/dichvu/huy_dangky_dichvu/<?= htmlspecialchars((string)$dk->id) ?>" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đăng ký dịch vụ này?');">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-xmark me-1"></i>Hủy
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-secondary py-3">
                    Bạn chưa đăng ký dịch vụ nào.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="fas fa-calendar-plus me-2 text-warning"></i>
                    Đăng ký dịch vụ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/gym/user/dichvu/dangky_dichvu" id="registerForm">
                <div class="modal-body">
                    <input type="hidden" name="id_dv" id="serviceId">
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Dịch vụ</label>
                        <input type="text" class="form-control" id="serviceName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="NgaySuDung" class="form-label">Ngày sử dụng <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="NgaySuDung" name="NgaySuDung" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="GioSuDung" class="form-label">Giờ sử dụng <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="GioSuDung" name="GioSuDung" required>
                    </div>
                    <div class="mb-3">
                        <label for="GhiChu" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-check me-1"></i>Xác nhận đăng ký
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openRegisterModal(id, name) {
        document.getElementById('serviceId').value = id;
        document.getElementById('serviceName').value = name;
        const modal = new bootstrap.Modal(document.getElementById('registerModal'));
        modal.show();
    }

    // Set min date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('NgaySuDung').setAttribute('min', today);
    });
</script>
</body>
</html>


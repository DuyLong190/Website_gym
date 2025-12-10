<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử hoạt động</title>
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
        .card-history {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
        }
        .status-badge {
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-cancelled {
            background-color: #dc2626;
            color: #ffffff;
        }
        .status-expired {
            background-color: #6b7280;
            color: #ffffff;
        }
        .package-card-item {
            background: rgba(148, 163, 184, 0.05);
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .package-card-item:hover {
            background: rgba(148, 163, 184, 0.1);
            border-color: rgba(148, 163, 184, 0.3);
            transform: translateY(-2px);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
<div class="user-wrapper">
    <div class="container-fluid">
        <div class="card-history">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1 text-white">
                        <i class="fas fa-clock-rotate-left me-2 text-warning"></i>Lịch sử hoạt động
                    </h2>
                    <p class="mb-0 text-secondary">Danh sách các gói tập đã bị hủy</p>
                </div>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($canceledPackages)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Gói tập</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Ngày hủy</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($canceledPackages as $package): ?>
                            <?php
                            $id_ctgt = (int)($package['id_ctgt'] ?? 0);
                            $tenGoiTap = htmlspecialchars($package['TenGoiTap'] ?? 'N/A');
                            $ngayBatDau = !empty($package['NgayBatDau']) ? date('d/m/Y', strtotime($package['NgayBatDau'])) : '-';
                            $ngayKetThuc = !empty($package['NgayKetThuc']) ? date('d/m/Y', strtotime($package['NgayKetThuc'])) : '-';
                            $ngayHuy = !empty($package['updated_at']) ? date('d/m/Y H:i', strtotime($package['updated_at'])) : '-';
                            $trangThai = $package['TrangThai'] ?? '';
                            $daThanhToan = (int)($package['DaThanhToan'] ?? 0);
                            $isCancelled = ($trangThai === 'Đã hủy');
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= $tenGoiTap; ?></div>
                                    <?php if (!empty($package['GhiChu'])): ?>
                                        <small class="text-secondary"><?= htmlspecialchars($package['GhiChu']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= $ngayBatDau; ?></td>
                                <td><?= $ngayKetThuc; ?></td>
                                <td><?= $ngayHuy; ?></td>
                                <td>
                                    <span class="status-badge <?= $isCancelled ? 'status-cancelled' : 'status-expired'; ?>">
                                        <?= htmlspecialchars($trangThai); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($daThanhToan === 1): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Đã thanh toán
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>Chưa thanh toán
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($id_ctgt > 0): ?>
                                        <a href="/gym/user/chitiet_goitap/<?= $id_ctgt; ?>" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                    <?php else: ?>
                                        <span class="text-secondary small">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5 class="text-white mb-2">Chưa có gói tập nào bị hủy</h5>
                    <p class="mb-0">Bạn chưa có gói tập nào trong lịch sử hủy.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


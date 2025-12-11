<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử thanh toán</title>
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
        .card-hoadon {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
            margin-bottom: 24px;
        }
        .hoadon-card {
            background: #1e293b;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 20px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .hoadon-card:hover {
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
        .status-cho-duyet {
            background-color: #f59e0b;
            color: #022c22;
        }
        .status-thanh-cong {
            background-color: #22c55e;
            color: #022c22;
        }
        .status-that-bai {
            background-color: #ef4444;
            color: #ffffff;
        }
        .loai-badge {
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .loai-dichvu {
            background-color: #6366f1;
            color: #ffffff;
        }
        .loai-lophoc {
            background-color: #8b5cf6;
            color: #ffffff;
        }
        .amount-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fbbf24;
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

        <!-- Danh sách hóa đơn -->
        <div class="card-hoadon">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1 text-white">
                        <i class="fa-solid fa-receipt me-2 text-warning"></i>
                        Lịch sử thanh toán
                    </h2>
                    <p class="mb-0 text-secondary">Xem lịch sử thanh toán dịch vụ và lớp học của bạn</p>
                </div>
            </div>

            <?php if (!empty($hoaDons)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Loại</th>
                                <th>Tên dịch vụ/Lớp học</th>
                                <th>Số tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Mã đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hoaDons as $hd): ?>
                                <?php
                                $loai = $hd['Loai'] ?? '';
                                $momoStatus = $hd['momo_status'] ?? '';
                                
                                $statusClass = 'status-cho-duyet';
                                $statusText = 'Chờ duyệt';
                                
                                if ($momoStatus === 'Thành công') {
                                    $statusClass = 'status-thanh-cong';
                                    $statusText = 'Thành công';
                                } elseif ($momoStatus === 'Thất bại') {
                                    $statusClass = 'status-that-bai';
                                    $statusText = 'Thất bại';
                                }
                                
                                $loaiClass = $loai === 'DichVu' ? 'loai-dichvu' : 'loai-lophoc';
                                $loaiText = $loai === 'DichVu' ? 'Dịch vụ' : 'Lớp học';
                                
                                $createdAt = $hd['created_at'] ?? '';
                                $formattedDate = '';
                                if (!empty($createdAt)) {
                                    try {
                                        $dateObj = new DateTime($createdAt);
                                        $formattedDate = $dateObj->format('d/m/Y H:i');
                                    } catch (Exception $e) {
                                        $formattedDate = $createdAt;
                                    }
                                }
                                
                                // Lấy tên dịch vụ/lớp học từ thông tin chi tiết
                                $tenItem = $hd['TenItem'] ?? 'N/A';
                                ?>
                                <tr>
                                    <td>
                                        <span class="loai-badge <?= $loaiClass ?>">
                                            <?= htmlspecialchars($loaiText) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($tenItem) ?></strong>
                                    </td>
                                    <td>
                                        <span class="amount-text">
                                            <?= number_format($hd['amount'] ?? 0, 0, ',', '.') ?> đ
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <?= htmlspecialchars($statusText) ?>
                                        </span>
                                    </td>
                                    <td class="text-secondary small">
                                        <?= $formattedDate ?: 'N/A' ?>
                                    </td>
                                    <td class="text-secondary small">
                                        <?= htmlspecialchars($hd['order_id'] ?? 'N/A') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-secondary py-5">
                    <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                    <h5>Chưa có hóa đơn nào</h5>
                    <p>Bạn chưa có lịch sử thanh toán nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


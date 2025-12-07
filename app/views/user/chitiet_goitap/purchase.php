<?php
    // View trang thanh toán chi tiết gói tập
    // Biến $item được lấy từ ChiTiet_Goitap_Controller::purchase
    ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán gói tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .payment-card {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
            max-width: 900px;
            margin: 0 auto;
        }
        .payment-hero {
            background: linear-gradient(120deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .info-value {
            color: #e5e7eb;
        }
    </style>
</head>
<body>
<div class="user-wrapper">
    <div class="container-fluid">
        <div class="payment-card">
            <div class="payment-hero">
                <h2 class="h4 mb-1"><i class="fas fa-credit-card me-2"></i>Thanh toán gói tập</h2>
                <p class="mb-0 opacity-75">Xác nhận thanh toán cho gói tập của bạn</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($item)): ?>
                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-4"><i class="fas fa-info-circle me-2 text-info"></i>Thông tin gói tập</h5>
                        <div class="info-item">
                            <div class="info-label">ID chi tiết</div>
                            <div class="info-value"><?= htmlspecialchars((string)($item['id_ctgt'] ?? '')); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Mã gói tập</div>
                            <div class="info-value"><?= htmlspecialchars((string)($item['MaGoiTap'] ?? '')); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tên gói tập</div>
                            <div class="info-value"><?= htmlspecialchars((string)($item['TenGoiTap'] ?? 'N/A')); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Trạng thái hiện tại</div>
                            <div class="info-value">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>Chờ thanh toán
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" class="card bg-dark border-secondary p-4">
                    <h5 class="text-white mb-3"><i class="fas fa-check-double me-2 text-success"></i>Xác nhận thanh toán</h5>
                    <div class="alert alert-info bg-info bg-opacity-10 border-info text-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Nhấn nút <strong>"Xác nhận đã thanh toán"</strong> sau khi bạn đã thu tiền từ hội viên.
                        Hệ thống sẽ tự động cập nhật <strong>Ngày bắt đầu</strong>, <strong>Ngày kết thúc</strong> và trạng thái
                        gói tập sang <strong>"Đang hoạt động"</strong>.
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-2"></i>Xác nhận đã thanh toán
                        </button>
                        <a href="/gym/user/chitiet_goitap/<?= htmlspecialchars((string)($item['id_ctgt'] ?? '')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại chi tiết gói tập
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning bg-warning bg-opacity-10 border-warning text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Không tìm thấy thông tin chi tiết gói tập để thanh toán.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

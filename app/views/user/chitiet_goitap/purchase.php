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
</head>
<body>
<div class="container" style="margin-top: 80px; margin-left: 15%; max-width: 900px;">
    <h2 class="mb-4">Thanh toán gói tập</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($item)): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p><strong>ID chi tiết:</strong> <?= htmlspecialchars((string)($item['id_ctgt'] ?? '')); ?></p>
                <p><strong>Mã gói tập:</strong> <?= htmlspecialchars((string)($item['MaGoiTap'] ?? '')); ?></p>
                <p><strong>Trạng thái hiện tại:</strong>
                    <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                </p>
            </div>
        </div>

        <form method="post" class="card shadow-sm p-4">
            <h5 class="mb-3">Xác nhận thanh toán</h5>
            <p class="text-muted mb-3">
                Nhấn nút <strong>"Xác nhận đã thanh toán"</strong> sau khi bạn đã thu tiền từ hội viên.
                Hệ thống sẽ tự động cập nhật <strong>Ngày bắt đầu</strong>, <strong>Ngày kết thúc</strong> và trạng thái
                gói tập sang <strong>"Đang hoạt động"</strong>.
            </p>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle me-2"></i>Xác nhận đã thanh toán
            </button>
            <a href="/gym/user/chitiet_goitap/<?= htmlspecialchars((string)($item['id_ctgt'] ?? '')); ?>" class="btn btn-outline-secondary ms-2">
                Quay lại chi tiết gói tập
            </a>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">
            Không tìm thấy thông tin chi tiết gói tập để thanh toán.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

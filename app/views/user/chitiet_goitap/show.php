<?php
// $chiTiet được truyền từ ChiTiet_Goitap_Controller::index_ctgt
// Dữ liệu là mảng, lấy phần tử đầu tiên để hiển thị chi tiết
$item = null;
if (isset($chiTiet) && is_array($chiTiet) && count($chiTiet) > 0) {
    $item = $chiTiet[0];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết gói tập</title>
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

        .package-hero {
            background: linear-gradient(120deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            padding: 26px 20px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .package-card {
            max-width: 980px;
            margin: 48px auto;
        }

        .package-card .card {
            background: #020617;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
        }

        .package-card .card-body {
            color: #e5e7eb;
        }

        .package-card .list-group-item {
            background-color: transparent;
            border-color: rgba(148, 163, 184, 0.2);
            color: #e5e7eb;
        }

        .pkg-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            background: rgba(148, 163, 184, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        .meta-label {
            color: #94a3b8;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 24px;
            opacity: 0.5;
            color: #64748b;
        }

        .empty-state h4 {
            color: #e5e7eb;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 1rem;
            margin-bottom: 24px;
        }

        .empty-state .btn {
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
        }

        @media (max-width:576px) {
            .pkg-image {
                height: 120px;
            }
            .empty-state {
                padding: 60px 20px;
            }
            .empty-state i {
                font-size: 4rem;
            }
        }
    </style>
</head>

<body>
    <div class="user-wrapper">
        <div class="container package-card">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0"></ol>
            </nav>

            <div class="package-hero d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-1"><i class="fas fa-dumbbell me-2"></i>Gói tập đang đăng ký</h3>
                    <div class="small opacity-75">Chi tiết & thông tin thanh toán</div>
                </div>
                <?php if ($item): ?>
                    <div class="text-end">
                        <?php $trangThai = $item['TrangThai'] ?? ''; ?>
                        <div class="mt-2">
                            <span class="badge rounded-pill
                            <?php
                            if ($trangThai === 'Đang hoạt động') echo 'bg-success';
                            elseif ($trangThai === 'Hết hạn') echo 'bg-secondary';
                            elseif ($trangThai === 'Đã hủy') echo 'bg-danger';
                            else echo 'bg-warning text-dark';
                            ?>
                        ">
                                <?= htmlspecialchars((string)$trangThai); ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($item): ?>
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

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="pkg-image">
                                    <div class="text-center">
                                        <i class="fas fa-ticket fa-3x text-muted"></i>
                                        <div class="mt-2 fw-semibold"><?= htmlspecialchars((string)($item['TenGoiTap'] ?? ($item['MaGoiTap'] ?? 'Gói tập'))); ?></div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item d-flex justify-content-between"><span class="meta-label">Ngày bắt đầu</span><span>
                                            <?php $ngayBD = $item['NgayBatDau'] ?? '';
                                            echo $ngayBD ? date('d/m/Y', strtotime($ngayBD)) : '-'; ?>
                                        </span></li>
                                    <li class="list-group-item d-flex justify-content-between"><span class="meta-label">Ngày kết thúc</span><span>
                                            <?php 
                                            $ngayKT = $item['NgayKetThuc'] ?? '';
                                            // Tính lại ngày kết thúc dựa trên ngày bắt đầu + thời hạn (tháng) nếu có
                                            if (!empty($ngayBD) && !empty($item['ThoiHan'])) {
                                                $thoiHan = (int)($item['ThoiHan'] ?? 0);
                                                if ($thoiHan > 0) {
                                                    // Tính lại ngày kết thúc: ngày bắt đầu + thời hạn (tháng)
                                                    $ngayBatDauObj = new DateTime($ngayBD);
                                                    $ngayBatDauObj->modify('+' . $thoiHan . ' months');
                                                    $ngayKT = $ngayBatDauObj->format('Y-m-d');
                                                }
                                            }
                                            echo $ngayKT ? date('d/m/Y', strtotime($ngayKT)) : '-'; ?>
                                        </span></li>
                                </ul>
                            </div>

                            <div class="col-md-8">
                                <h5 class="mb-3">Thông tin gói</h5>
                                <div class="mb-3 row">
                                    <div class="col-4 meta-label">Ghi chú</div>
                                    <div class="col-8"><?= nl2br(htmlspecialchars((string)($item['GhiChu'] ?? 'Không có'))); ?></div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-4 meta-label">Thanh toán</div>
                                    <div class="col-8">
                                        <?php $daThanhToan = $item['DaThanhToan'] ?? 0;
                                        if ((int)$daThanhToan === 1): ?>
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã thanh toán</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark me-2"><i class="fas fa-clock me-1"></i>Chưa thanh toán</span>
                                            <?php $id_ctgt = $item['id_ctgt'] ?? null;
                                            if ($id_ctgt !== null): ?>
                                                <a href="<?= htmlspecialchars('/gym/user/chitiet_goitap/purchase/' . urlencode((string)$id_ctgt), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">Thanh toán ngay</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="small meta-label">Ngày gửi yêu cầu</div>
                                        <div class="fw-medium">
                                            <?php $created = $item['created_at'] ?? '';
                                            echo $created ? date('d/m/Y H:i', strtotime($created)) : '-'; ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="small meta-label">Ngày chấp nhận</div>
                                        <div class="fw-medium">
                                            <?php $updated = $item['updated_at'] ?? '';
                                            echo $updated ? date('d/m/Y H:i', strtotime($updated)) : '-'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="/gym/user/profile" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
                        <div>
                            <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-file-invoice me-1"></i>In biên nhận</a>

                            <?php if ((int)($item['DaThanhToan'] ?? 0) !== 1 && ($item['id_ctgt'] ?? null) !== null): ?>
                                
                                <form action="/gym/ThanhToanGoiTap/confirm_momo" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_ctgt" value="<?= htmlspecialchars((string)($item['id_ctgt'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-qrcode me-1"></i>Thanh toán MOMO
                                    </button>
                                </form>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
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

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>Chưa có gói tập</h4>
                            <p>Bạn chưa đăng ký gói tập nào hoặc gói tập không tồn tại.</p>
                            <a href="/gym/goitap" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Đăng ký gói tập ngay
                            </a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-start">
                        <a href="/gym/user/profile" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
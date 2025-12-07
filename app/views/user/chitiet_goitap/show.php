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
        .package-hero {
            background: linear-gradient(120deg,#1e3c72 0%,#2a5298 100%);
            color: #fff;
            padding: 26px 20px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .package-card { max-width: 980px; margin: 48px auto; }
        .pkg-image { width:100%; height:160px; object-fit:cover; border-radius:8px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; }
        .meta-label { color:#6b7280; font-weight:600; }
        @media (max-width:576px){ .pkg-image{height:120px;} }
    </style>
</head>

<body>
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
                                    <?php $ngayBD = $item['NgayBatDau'] ?? ''; echo $ngayBD ? date('d/m/Y', strtotime($ngayBD)) : '-'; ?>
                                </span></li>
                                <li class="list-group-item d-flex justify-content-between"><span class="meta-label">Ngày kết thúc</span><span>
                                    <?php $ngayKT = $item['NgayKetThuc'] ?? ''; echo $ngayKT ? date('d/m/Y', strtotime($ngayKT)) : '-'; ?>
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
                                    <?php $daThanhToan = $item['DaThanhToan'] ?? 0; if ((int)$daThanhToan === 1): ?>
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã thanh toán</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark me-2"><i class="fas fa-clock me-1"></i>Chưa thanh toán</span>
                                        <?php $id_ctgt = $item['id_ctgt'] ?? null; if ($id_ctgt !== null): ?>
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
                                        <?php $created = $item['created_at'] ?? ''; echo $created ? date('d/m/Y H:i', strtotime($created)) : '-'; ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="small meta-label">Ngày chấp nhận</div>
                                    <div class="fw-medium">
                                        <?php $updated = $item['updated_at'] ?? ''; echo $updated ? date('d/m/Y H:i', strtotime($updated)) : '-'; ?>
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
                            <a href="<?= htmlspecialchars('/gym/user/chitiet_goitap/purchase/' . urlencode((string)$item['id_ctgt']), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">Thanh toán</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>Không tìm thấy thông tin chi tiết gói tập.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


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
    <title>Chi tiết gói tập đang đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="container" style="margin-top: 80px; margin-left: 15%; max-width: 900px;">
        <h2 class="mb-4">Gói tập đang đăng ký</h2>

        <?php if ($item): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-dumbbell me-2"></i>Chi tiết gói tập</span>
                    <span class="badge bg-light text-primary">
                        ID chi tiết: <?= htmlspecialchars((string)($item['id_ctgt'] ?? '')); ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Tên gói tập:</div>
                        <div class="col-md-8">
                            <?= htmlspecialchars((string)($item['TenGoiTap'] ?? ($item['MaGoiTap'] ?? ''))); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Ngày bắt đầu:</div>
                        <div class="col-md-8">
                            <?php
                            $ngayBD = $item['NgayBatDau'] ?? '';
                            echo $ngayBD ? date('d/m/Y', strtotime($ngayBD)) : 'Chưa cập nhật';
                            ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Ngày kết thúc:</div>
                        <div class="col-md-8">
                            <?php
                            $ngayKT = $item['NgayKetThuc'] ?? '';
                            echo $ngayKT ? date('d/m/Y', strtotime($ngayKT)) : 'Chưa cập nhật';
                            ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Trạng thái:</div>
                        <div class="col-md-8">
                            <?php $trangThai = $item['TrangThai'] ?? ''; ?>
                            <span class="badge
                                <?php
                                if ($trangThai === 'Đang hoạt động') {
                                    echo ' bg-success';
                                } elseif ($trangThai === 'Hết hạn') {
                                    echo ' bg-secondary';
                                } elseif ($trangThai === 'Đã hủy') {
                                    echo ' bg-danger';
                                } else {
                                    echo ' bg-warning text-dark';
                                }
                                ?>
                            ">
                                <?= htmlspecialchars((string)$trangThai); ?>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Ghi chú:</div>
                        <div class="col-md-8">
                            <?= htmlspecialchars((string)($item['GhiChu'] ?? '')); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-muted">Thanh toán:</div>
                        <div class="col-md-8">
                            <?php
                            $daThanhToan = $item['DaThanhToan'] ?? 0;
                            if ((int)$daThanhToan === 1) {
                                echo '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã thanh toán</span>';
                            } else {
                                echo '<span class="badge bg-warning text-dark me-2"><i class="fas fa-clock me-1"></i>Chưa thanh toán</span>';
                                $id_ctgt = $item['id_ctgt'] ?? null;
                                if ($id_ctgt !== null) {
                                    $urlThanhToan = '/gym/user/chitiet_goitap/purchase/' . urlencode((string)$id_ctgt);
                                    echo '<a href="' . htmlspecialchars($urlThanhToan, ENT_QUOTES, 'UTF-8') . '" class="btn btn-sm btn-primary">Đã thanh toán</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold text-muted">Ngày tạo:</div>
                        <div class="col-md-8">
                            <?php
                            $created = $item['created_at'] ?? '';
                            echo $created ? date('d/m/Y H:i', strtotime($created)) : 'Không có dữ liệu';
                            ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold text-muted">Ngày cập nhật:</div>
                        <div class="col-md-8">
                            <?php
                            $updated = $item['updated_at'] ?? '';
                            echo $updated ? date('d/m/Y H:i', strtotime($updated)) : 'Không có dữ liệu';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="/gym/user/profile" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại thông tin cá nhân
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Không tìm thấy thông tin chi tiết gói tập.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


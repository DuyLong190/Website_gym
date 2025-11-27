<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lớp học đã đăng ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a;
            color: #e5e7eb;
        }
        .user-wrapper {
            margin-left: 18%;
            padding: 40px 30px;
        }
        @media (max-width: 991px) {
            .user-wrapper {
                margin-left: 0;
                padding: 120px 16px 40px;
            }
        }
        .card-classes {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
        }
        .status-badge {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }
        .status-active {
            background-color: #22c55e;
            color: #022c22;
        }
        .status-cancelled {
            background-color: #4b5563;
            color: #e5e7eb;
        }
    </style>
</head>
<body>
<div class="user-wrapper">
    <div class="container-fluid">
        <div class="card-classes">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-calendar-days me-2 text-warning"></i>Lớp học đã đăng ký</h2>
                    <p class="mb-0 text-secondary">Danh sách các lớp mà bạn đã đăng ký tham gia</p>
                </div>
                <a href="/gym/lophoc" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="fa-solid fa-plus me-1"></i>Xem thêm lớp học
                </a>
            </div>

            <?php if (!empty($dangKys)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Lớp học</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $stt = 1; foreach ($dangKys as $row): ?>
                            <?php
                            $id = (int)($row['id'] ?? 0);
                            $maLop = (int)($row['MaLop'] ?? 0);
                            $tenLop = $row['TenLop'] ?? '';
                            $ngayBd = !empty($row['NgayBatDau']) ? date('d/m/Y', strtotime($row['NgayBatDau'])) : '';
                            $ngayKt = !empty($row['NgayKetThuc']) ? date('d/m/Y', strtotime($row['NgayKetThuc'])) : '';
                            $gia = isset($row['GiaTien']) ? number_format((float)$row['GiaTien'], 0, ',', '.') . ' đ' : '';
                            $trangThai = $row['TrangThai'] ?? '';
                            $isActive = ($trangThai === 'DangKy');
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($tenLop); ?></td>
                                <td><?= $ngayBd; ?></td>
                                <td><?= $ngayKt; ?></td>
                                <td><?= $gia; ?></td>
                                <td>
                                    <span class="status-badge <?= $isActive ? 'status-active' : 'status-cancelled'; ?>">
                                        <?= $isActive ? 'Đang đăng ký' : 'Đã hủy'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($isActive && $id > 0): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="cancelRegisterClass(<?= $id; ?>)">
                                            <i class="fa-solid fa-xmark me-1"></i>Hủy đăng ký
                                        </button>
                                        <?php if ($maLop > 0): ?>
                                            <a href="/gym/user/lichlophoc?MaLop=<?= $maLop; ?>" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-calendar-days me-1"></i>Chi tiết
                                            </a>
                                        <?php endif; ?>
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
                <div class="text-center text-secondary py-3">
                    Bạn chưa đăng ký lớp học nào.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    async function cancelRegisterClass(id) {
        if (!confirm('Bạn có chắc chắn muốn hủy đăng ký lớp học này?')) {
            return;
        }
        try {
            const response = await fetch('/gym/api/dangkylophoc/' + id, {
                method: 'DELETE'
            });
            let result = {};
            try {
                result = await response.json();
            } catch (e) {
                result = {};
            }

            if (response.status === 401) {
                alert(result.message || 'Vui lòng đăng nhập lại');
                window.location.href = '/gym/account/login';
                return;
            }

            if (response.ok && result.success) {
                alert(result.message || 'Đã hủy đăng ký lớp học');
                window.location.reload();
                return;
            }

            alert(result.message || 'Không thể hủy đăng ký lớp học');
        } catch (e) {
            alert('Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
</script>
</body>
</html>

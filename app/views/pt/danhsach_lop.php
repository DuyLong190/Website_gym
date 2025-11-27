<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hội viên lớp <?php echo htmlspecialchars($lop->TenLop ?? ''); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #0f172a, #111827);
            min-height: 100vh;
            color: #e2e8f0;
        }

        .pt-wrapper {
            margin-left: 18%;
            padding: 40px 30px;
        }

        .card-main {
            background: #0f172a;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.6);
        }

        .badge-status-hv {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }

        .badge-active-hv {
            background-color: #22c55e;
            color: #022c22;
        }

        .badge-inactive-hv {
            background-color: #4b5563;
            color: #e5e7eb;
        }

        @media (max-width: 991px) {
            .pt-wrapper {
                margin-left: 0;
                padding: 120px 16px 40px;
            }
        }
    </style>
</head>
<body>
<div class="pt-wrapper">
    <div class="container-fluid">
        <div class="card card-main mb-4">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h2 class="h4 mb-1 text-white">
                        <i class="fa-solid fa-users me-2 text-emerald-400"></i>
                        Hội viên lớp: <?php echo htmlspecialchars($lop->TenLop ?? ''); ?>
                    </h2>
                    <div class="text-secondary small">
                        <?php if (!empty($lop->NgayBatDau) || !empty($lop->NgayKetThuc)): ?>
                            <span class="mx-2">•</span>
                            Thời gian:
                            <?php echo !empty($lop->NgayBatDau) ? date('d/m/Y', strtotime($lop->NgayBatDau)) : ''; ?>
                            -
                            <?php echo !empty($lop->NgayKetThuc) ? date('d/m/Y', strtotime($lop->NgayKetThuc)) : ''; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="/gym/pt/lophoc" class="btn btn-outline-light btn-sm rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i>Quay lại danh sách lớp
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card card-main h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white"><i class="fa-solid fa-id-card me-2 text-sky-400"></i>Danh sách hội viên</h5>
                        <span class="text-secondary small">
                            Tổng hội viên: <?php echo is_array($members) ? count($members) : 0; ?> 
                        </span>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($members)): ?>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Gói tập</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $stt = 1; foreach ($members as $row): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['HoTen'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['SDT'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['Email'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['TenGoiTap'] ?? ''); ?></td>
                                            <?php
                                            $trangThaiHv = $row['TrangThaiHoiVien'] ?? '';
                                            $isActiveHv = ($trangThaiHv === 'HoatDong' || $trangThaiHv === 'Đang hoạt động');
                                            ?>
                                            <td>
                                                <span class="badge-status-hv <?php echo $isActiveHv ? 'badge-active-hv' : 'badge-inactive-hv'; ?>">
                                                    <?php echo $isActiveHv ? 'Hoạt động' : 'Không hoạt động'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-secondary small">
                                Chưa có hội viên nào đăng ký lớp này.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card card-main h-100">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0 text-white"><i class="fa-regular fa-calendar-days me-2 text-amber-400"></i>Lịch học của lớp</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($lichLop)): ?>
                            <div class="table-responsive">
                                <table class="table table-dark table-sm align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Giờ</th>
                                        <th>Phòng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $stt2 = 1; foreach ($lichLop as $item): ?>
                                        <?php
                                        $ngay = !empty($item['NgayHoc']) ? date('d/m/Y', strtotime($item['NgayHoc'])) : '';
                                        $gioBd = !empty($item['GioBatDau']) ? substr($item['GioBatDau'], 0, 5) : '';
                                        $gioKt = !empty($item['GioKetThuc']) ? substr($item['GioKetThuc'], 0, 5) : '';
                                        ?>
                                        <tr>
                                            <td><?php echo $ngay; ?></td>
                                            <td><?php echo $gioBd . ' - ' . $gioKt; ?></td>
                                            <td><?php echo htmlspecialchars($item['PhongHoc'] ?? ''); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-secondary small">
                                Lớp này chưa được sắp lịch học.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

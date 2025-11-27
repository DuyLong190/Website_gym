<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử lớp phụ trách</title>
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

        .badge-status-class {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }

        .badge-class-active {
            background-color: #22c55e;
            color: #022c22;
        }

        .badge-class-cancel {
            background-color: #f97316;
            color: #111827;
        }

        .badge-class-other {
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
        <div class="card card-main">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="h4 mb-1 text-white">
                            <i class="fa-solid fa-clock-rotate-left me-2 text-amber-400"></i>
                            Lịch sử lớp đã/đang phụ trách
                        </h2>
                        <p class="mb-0 text-secondary small">Xem lại các lớp bạn đã đăng ký đứng, kèm số buổi và số hội viên đang tham gia.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/gym/pt/lophoc" class="btn btn-outline-light btn-sm rounded-pill">
                            <i class="fa-solid fa-calendar-days me-1"></i>Lớp hiện tại
                        </a>
                        <a href="/gym/pt/lichday" class="btn btn-outline-info btn-sm rounded-pill">
                            <i class="fa-regular fa-calendar-check me-1"></i>Lịch dạy
                        </a>
                    </div>
                </div>

                <?php if (!empty($classHistory)): ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Lớp học</th>
                                <th>Thời gian lớp</th>
                                <th>Trạng thái PT</th>
                                <th>Số buổi học</th>
                                <th>Hội viên tham gia</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $stt = 1; foreach ($classHistory as $item): ?>
                                <?php
                                $lop = $item['lop'] ?? null;
                                $maLop = $item['MaLop'] ?? 0;
                                $tenLop = $lop ? ($lop->TenLop ?? ('Lớp #' . $maLop)) : ('Lớp #' . $maLop);
                                $ngayBd = $lop && !empty($lop->NgayBatDau) ? date('d/m/Y', strtotime($lop->NgayBatDau)) : '';
                                $ngayKt = $lop && !empty($lop->NgayKetThuc) ? date('d/m/Y', strtotime($lop->NgayKetThuc)) : '';
                                $trangThai = $item['TrangThai'] ?? '';

                                $badgeClass = 'badge-class-other';
                                $labelTrangThai = $trangThai;
                                if ($trangThai === 'Đăng ký') {
                                    $badgeClass = 'badge-class-active';
                                    $labelTrangThai = 'Đang phụ trách';
                                } elseif ($trangThai === 'Hủy') {
                                    $badgeClass = 'badge-class-cancel';
                                    $labelTrangThai = 'Đã hủy';
                                }

                                $soBuoi = (int)($item['SoBuoi'] ?? 0);
                                $soHv = (int)($item['SoHoiVienDangKy'] ?? 0);
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-white"><?php echo htmlspecialchars($tenLop); ?></div>
                                        <div class="text-secondary small">Mã lớp: <?php echo (int)$maLop; ?></div>
                                    </td>
                                    <td class="text-secondary small">
                                        <?php if ($ngayBd || $ngayKt): ?>
                                            <?php echo $ngayBd ?: 'N/A'; ?> - <?php echo $ngayKt ?: 'N/A'; ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge-status-class <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($labelTrangThai); ?></span>
                                    </td>
                                    <td><?php echo $soBuoi; ?></td>
                                    <td><?php echo $soHv; ?></td>
                                    <td class="text-end">
                                        <?php if ($maLop > 0): ?>
                                            <a href="/gym/pt/danhsach_lop?MaLop=<?php echo (int)$maLop; ?>" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-users me-1"></i>Chi tiết lớp
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-secondary small">
                        Bạn chưa có lịch sử lớp nào. Hãy đăng ký đứng lớp để bắt đầu.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

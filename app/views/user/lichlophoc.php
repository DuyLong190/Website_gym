<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch lớp của tôi</title>
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
        .card-schedule {
            background: #020617;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
            padding: 24px;
        }
        .badge-class {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }
        .badge-class-main {
            background-color: #22c55e;
            color: #022c22;
        }
    </style>
</head>
<body>
<div class="user-wrapper">
    <div class="container-fluid">
        <div class="card-schedule">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-calendar-days me-2 text-warning"></i>Lịch lớp của tôi</h2>
                    <p class="mb-0 text-secondary">Thời khóa biểu các lớp mà bạn đã đăng ký tham gia</p>
                </div>
                <a href="/gym/lophoc" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="fa-solid fa-plus me-1"></i>Đăng ký thêm lớp
                </a>
            </div>

            <?php if (!empty($lichLops)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Lớp học</th>
                            <th>Ngày học</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                            <th>Phòng học</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $stt = 1; foreach ($lichLops as $row): ?>
                            <?php
                            $tenLop = isset($row['TenLop']) ? $row['TenLop'] : '';
                            $ngayHoc = !empty($row['NgayHoc']) ? date('d/m/Y', strtotime($row['NgayHoc'])) : '';
                            $gioBatDau = !empty($row['GioBatDau']) ? substr($row['GioBatDau'], 0, 5) : '';
                            $gioKetThuc = !empty($row['GioKetThuc']) ? substr($row['GioKetThuc'], 0, 5) : '';
                            $phongHoc = isset($row['PhongHoc']) ? $row['PhongHoc'] : '';
                            ?>
                            <tr>
                                <td>
                                    <span class="badge-class badge-class-main">
                                        <?= htmlspecialchars($tenLop); ?>
                                    </span>
                                </td>
                                <td><?= $ngayHoc; ?></td>
                                <td><?= $gioBatDau; ?></td>
                                <td><?= $gioKetThuc; ?></td>
                                <td><?= htmlspecialchars($phongHoc); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-secondary py-3">
                    Hiện chưa có lịch cho các lớp bạn đã đăng ký.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

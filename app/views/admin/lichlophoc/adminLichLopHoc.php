<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lịch lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .container-fluid {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-admin {
            border-radius: 18px;
            border: none;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.12);
            background: #ffffff;
        }

        .table thead {
            background: #1d4ed8;
            color: #ffffff;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #f3f4f6;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        }

        .badge-day {
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
        }

        .time-text {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2 mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Quản lý lịch lớp học
                    </h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLichLopHocModal">
                        <i class="fas fa-plus me-2"></i>Thêm lịch học
                    </button>
                </div>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($_SESSION['errors'] as $field => $message): ?>
                                <li><?php echo htmlspecialchars($message); ?></li>
                            <?php endforeach; unset($_SESSION['errors']); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php
                $lopMap = [];
                if (!empty($lophocs)) {
                    foreach ($lophocs as $lop) {
                        $lopMap[$lop->MaLop] = $lop->TenLop;
                    }
                }
                ?>

                <div class="card card-admin">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold"><i class="fas fa-list-ul me-2"></i>Danh sách lịch học</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 18%;">Lớp học</th>
                                        <th style="width: 14%;">Ngày học</th>
                                        <th style="width: 14%;">Giờ bắt đầu</th>
                                        <th style="width: 14%;">Giờ kết thúc</th>
                                        <th>Phòng học</th>
                                        <th style="width: 14%;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lichLopHocs)): ?>
                                        <?php foreach ($lichLopHocs as $item): ?>
                                            <tr>
                                                <td><?php echo (int)($item['id'] ?? 0); ?></td>
                                                <td>
                                                    <?php
                                                    $maLop = $item['MaLop'] ?? null;
                                                    echo htmlspecialchars($lopMap[$maLop] ?? ('Lớp #' . $maLop));
                                                    ?>
                                                    <div class="text-muted small">Mã: <?php echo htmlspecialchars($maLop); ?></div>
                                                </td>
                                                <td>
                                                    <span class="badge-day">
                                                        <?php echo htmlspecialchars($item['NgayHoc'] ?? ''); ?>
                                                    </span>
                                                </td>
                                                <td class="time-text"><?php echo htmlspecialchars(substr($item['GioBatDau'] ?? '', 0, 5)); ?></td>
                                                <td class="time-text"><?php echo htmlspecialchars(substr($item['GioKetThuc'] ?? '', 0, 5)); ?></td>
                                                <td><?php echo htmlspecialchars($item['PhongHoc'] ?? ''); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info me-1"
                                                        onclick="openEditModal(
                                                            '<?php echo (int)($item['id'] ?? 0); ?>',
                                                            '<?php echo htmlspecialchars($item['MaLop'] ?? '', ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($item['NgayHoc'] ?? '', ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars(substr($item['GioBatDau'] ?? '', 0, 5), ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars(substr($item['GioKetThuc'] ?? '', 0, 5), ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($item['PhongHoc'] ?? '', ENT_QUOTES); ?>'
                                                        )">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteLichLopHoc(<?php echo (int)($item['id'] ?? 0); ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Chưa có lịch lớp học nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal thêm lịch lớp học -->
    <div class="modal fade" id="addLichLopHocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Thêm lịch học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lichlophoc/saveLichLopHoc" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Lớp học</label>
                            <select name="MaLop" id="add-MaLop" class="form-select" required>
                                <option value="">-- Chọn lớp học --</option>
                                <?php if (!empty($lophocs)): ?>
                                    <?php foreach ($lophocs as $lop): ?>
                                        <?php
                                        $ngayBatDau = !empty($lop->NgayBatDau) ? substr($lop->NgayBatDau, 0, 10) : '';
                                        $ngayKetThuc = !empty($lop->NgayKetThuc) ? substr($lop->NgayKetThuc, 0, 10) : '';
                                        ?>
                                        <option value="<?php echo (int)$lop->MaLop; ?>" data-ngay-bat-dau="<?php echo htmlspecialchars($ngayBatDau); ?>" data-ngay-ket-thuc="<?php echo htmlspecialchars($ngayKetThuc); ?>">
                                            <?php echo htmlspecialchars($lop->TenLop); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text" id="add-lop-date-range"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày học</label>
                            <input type="date" name="NgayHoc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ bắt đầu</label>
                            <input type="time" name="GioBatDau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ kết thúc</label>
                            <input type="time" name="GioKetThuc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phòng học</label>
                            <input type="text" name="PhongHoc" class="form-control" placeholder="VD: Phòng Yoga 1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal sửa lịch lớp học -->
    <div class="modal fade" id="editLichLopHocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật lịch lớp học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lichlophoc/updateLichLopHoc" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label class="form-label">Lớp học</label>
                            <select name="MaLop" id="edit-MaLop" class="form-select" required>
                                <option value="">-- Chọn lớp học --</option>
                                <?php if (!empty($lophocs)): ?>
                                    <?php foreach ($lophocs as $lop): ?>
                                        <option value="<?php echo (int)$lop->MaLop; ?>">
                                            <?php echo htmlspecialchars($lop->TenLop); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày học</label>
                            <input type="date" name="NgayHoc" id="edit-NgayHoc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ bắt đầu</label>
                            <input type="time" name="GioBatDau" id="edit-GioBatDau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ kết thúc</label>
                            <input type="time" name="GioKetThuc" id="edit-GioKetThuc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phòng học</label>
                            <input type="text" name="PhongHoc" id="edit-PhongHoc" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditModal(id, maLop, ngayHoc, gioBatDau, gioKetThuc, phongHoc) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-MaLop').value = maLop;
            document.getElementById('edit-NgayHoc').value = ngayHoc;
            document.getElementById('edit-GioBatDau').value = gioBatDau;
            document.getElementById('edit-GioKetThuc').value = gioKetThuc;
            document.getElementById('edit-PhongHoc').value = phongHoc;

            var modal = new bootstrap.Modal(document.getElementById('editLichLopHocModal'));
            modal.show();
        }

        function deleteLichLopHoc(id) {
            if (confirm('Bạn có chắc chắn muốn xóa lịch lớp học này?')) {
                window.location.href = '/gym/admin/lichlophoc/deleteLichLopHoc/' + id;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var selectLop = document.getElementById('add-MaLop');
            var infoEl = document.getElementById('add-lop-date-range');
            if (!selectLop || !infoEl) {
                return;
            }

            function updateDateRange() {
                var selectedOption = selectLop.options[selectLop.selectedIndex];
                if (!selectedOption) {
                    infoEl.textContent = '';
                    return;
                }

                var start = selectedOption.getAttribute('data-ngay-bat-dau') || '';
                var end = selectedOption.getAttribute('data-ngay-ket-thuc') || '';

                if (start && end) {
                    infoEl.textContent = 'Ngày bắt đầu: ' + start + ' | Ngày kết thúc: ' + end;
                } else if (start || end) {
                    infoEl.textContent = start ? 'Ngày bắt đầu: ' + start : 'Ngày kết thúc: ' + end;
                } else {
                    infoEl.textContent = '';
                }
            }

            selectLop.addEventListener('change', updateDateRange);
            updateDateRange();
        });
    </script>
</body>

</html>

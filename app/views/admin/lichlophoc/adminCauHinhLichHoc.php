<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cấu hình lịch học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
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

        .badge-day {
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2 mb-0">
                        <i class="fas fa-sliders-h me-2"></i>Cấu hình lịch lớp học
                    </h1>
                    <a href="/gym/admin/lichlophoc" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Quay về lịch lớp
                    </a>
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

                <div class="card card-admin mb-4">
                    <div class="card-header bg-white border-0">
                        <span class="fw-semibold"><i class="fas fa-plus-circle me-2"></i>Thêm cấu hình mới</span>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="/gym/admin/cauhinhlichhoc/saveCauhinhlichhoc" method="POST">
                            <div class="col-md-4">
                                <label class="form-label">Lớp học</label>
                                <select name="MaLop" class="form-select" required>
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
                            <div class="col-md-2">
                                <label class="form-label">Thứ</label>
                                <select name="ThuTrongTuan" class="form-select" required>
                                    <option value="">-- Chọn thứ --</option>
                                    <option value="2">Thứ 2</option>
                                    <option value="3">Thứ 3</option>
                                    <option value="4">Thứ 4</option>
                                    <option value="5">Thứ 5</option>
                                    <option value="6">Thứ 6</option>
                                    <option value="7">Thứ 7</option>
                                    <option value="8">Chủ nhật</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Giờ bắt đầu</label>
                                <input type="time" name="GioBatDau" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Giờ kết thúc</label>
                                <input type="time" name="GioKetThuc" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Phòng</label>
                                <input type="text" name="PhongHocMacDinh" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Lưu cấu hình
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                $thuMap = [
                    2 => 'Thứ 2',
                    3 => 'Thứ 3',
                    4 => 'Thứ 4',
                    5 => 'Thứ 5',
                    6 => 'Thứ 6',
                    7 => 'Thứ 7',
                    8 => 'Chủ nhật',
                ];
                ?>

                <div class="card card-admin">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold"><i class="fas fa-list-ul me-2"></i>Danh sách cấu hình lịch học</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Lớp học</th>
                                        <th>Thứ</th>
                                        <th>Giờ bắt đầu</th>
                                        <th>Giờ kết thúc</th>
                                        <th>Phòng</th>
                                        <th class="text-center" style="width: 14%;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($cauhinhs)): ?>
                                        <?php foreach ($cauhinhs as $item): ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlspecialchars($item['TenLop'] ?? ('Lớp #' . $item['MaLop'])); ?>
                                                </td>
                                                <td>
                                                    <span class="badge-day">
                                                        <?php
                                                        $thu = (int)($item['ThuTrongTuan'] ?? 0);
                                                        echo htmlspecialchars($thuMap[$thu] ?? ('Thứ ' . $thu));
                                                        ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars(substr($item['GioBatDau'] ?? '', 0, 5)); ?></td>
                                                <td><?php echo htmlspecialchars(substr($item['GioKetThuc'] ?? '', 0, 5)); ?></td>
                                                <td><?php echo htmlspecialchars($item['PhongHocMacDinh'] ?? ''); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info me-1"
                                                        onclick="openEditCauHinhModal(
                                                            '<?php echo (int)$item['id']; ?>',
                                                            '<?php echo htmlspecialchars($item['MaLop'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($item['ThuTrongTuan'], ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars(substr($item['GioBatDau'] ?? '', 0, 5), ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars(substr($item['GioKetThuc'] ?? '', 0, 5), ENT_QUOTES); ?>',
                                                            '<?php echo htmlspecialchars($item['PhongHocMacDinh'] ?? '', ENT_QUOTES); ?>'
                                                        )">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteCauHinh(<?php echo (int)$item['id']; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Chưa có cấu hình lịch học nào.</td>
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

    <!-- Modal sửa cấu hình lịch học -->
    <div class="modal fade" id="editCauHinhModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật cấu hình lịch học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/cauhinhlichhoc/updateCauhinhlichhoc" method="POST">
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
                            <label class="form-label">Thứ</label>
                            <select name="ThuTrongTuan" id="edit-ThuTrongTuan" class="form-select" required>
                                <option value="2">Thứ 2</option>
                                <option value="3">Thứ 3</option>
                                <option value="4">Thứ 4</option>
                                <option value="5">Thứ 5</option>
                                <option value="6">Thứ 6</option>
                                <option value="7">Thứ 7</option>
                                <option value="8">Chủ nhật</option>
                            </select>
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
                            <label class="form-label">Phòng</label>
                            <input type="text" name="PhongHocMacDinh" id="edit-PhongHocMacDinh" class="form-control">
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
        function openEditCauHinhModal(id, maLop, thu, gioBatDau, gioKetThuc, phongHoc) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-MaLop').value = maLop;
            document.getElementById('edit-ThuTrongTuan').value = thu;
            document.getElementById('edit-GioBatDau').value = gioBatDau;
            document.getElementById('edit-GioKetThuc').value = gioKetThuc;
            document.getElementById('edit-PhongHocMacDinh').value = phongHoc;

            var modal = new bootstrap.Modal(document.getElementById('editCauHinhModal'));
            modal.show();
        }

        function deleteCauHinh(id) {
            if (confirm('Bạn có chắc chắn muốn xóa cấu hình lịch học này?')) {
                window.location.href = '/gym/admin/cauhinhlichhoc/deleteCauhinhlichhoc/' + id;
            }
        }
    </script>
</body>

</html>

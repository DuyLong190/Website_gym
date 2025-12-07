<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cấu hình lịch học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #8f2121;
            --success-color: #12a84c;
            --info-color: #1c3be6ff;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            margin-left: 8.5rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 2rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            background: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            margin: 0 auto 1rem auto;
            box-shadow: var(--card-shadow);
            width: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .page-header h1 .icon-wrapper {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 i {
            font-size: 1.5rem;
            color: white;
        }

        .page-header h1 .title-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .page-header h1 .title-main {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
        }

        .admin-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-header .fw-semibold {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--success-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #6b7280;
            color: #6b7280;
            background: transparent;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #6b7280;
            color: white;
            transform: translateY(-2px);
        }

        .btn-info {
            background: var(--info-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-danger {
            background: var(--secondary-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .card-body {
            padding: 2rem;
        }

        .table {
            margin: 0;
        }

        .table thead {
            background: var(--primary-color);
            color: #fff;
        }

        .table thead th {
            border: none;
            padding: 1.25rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f8fafc;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9 !important;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .badge-day {
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        /* Modal Styling */
        .modal {
            backdrop-filter: blur(5px);
        }

        .modal-dialog {
            margin: 2rem auto;
            max-width: 600px;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .modal-title i {
            font-size: 1.75rem;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 1;
            padding: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 1.5rem;
            background: #fafafa;
        }

        .modal-body .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .modal-body .form-control,
        .modal-body .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: white;
        }

        .modal-body .form-control:focus,
        .modal-body .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 2px solid #f3f4f6;
            background: white;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .modal-footer .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-secondary {
            background: #6b7280;
            border: none;
            color: white;
        }

        .modal-footer .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .modal-footer .btn-primary {
            background: var(--success-color);
            border: none;
            color: white;
        }

        .modal-footer .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .page-header {
                padding: 0.75rem 1rem;
                width: 100%;
            }

            .page-header h1 {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .page-header h1 .title-main {
                font-size: 1.25rem;
                white-space: normal;
                text-align: center;
            }

            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/../../admin/sidebarAdmin.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <div class="icon-wrapper">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Cấu hình lịch lớp học</span>
                </div>
                    </h1>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="/gym/admin/lichlophoc" class="btn btn-outline-secondary">
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

        <div class="admin-card">
            <div class="card-header">
                <div class="fw-semibold">
                    <i class="fas fa-plus-circle"></i>
                    Thêm cấu hình mới
                </div>
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

        <div class="admin-card">
            <div class="card-header">
                <div class="fw-semibold">
                    <i class="fas fa-list-ul"></i>
                    Danh sách cấu hình lịch học
                </div>
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
                                    <td colspan="6" class="text-center text-muted">Chưa có cấu hình lịch học nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
    </div>

    <!-- Modal sửa cấu hình lịch học -->
    <div class="modal fade" id="editCauHinhModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật cấu hình lịch học</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

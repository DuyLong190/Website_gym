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
            --primary-color: #8f2121;
            --primary-dark: #5568d3;
            --secondary-color: #dc2626;
            --success-color: #10b981;
            --info-color: #3b82f6;
            --danger-color: #ef4444;
            --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-light: #f9fafb;
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
            padding: 1rem;
        }

        .main-content {
            animation: fadeInUp 0.4s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .admin-card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            background: #ffffff;
            overflow: hidden;
            transition: all 0.2s ease;
            margin-bottom: 1.25rem;
        }

        .admin-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 0.875rem 1.25rem;
            border: none;
            border-bottom: 2px solid var(--primary-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .card-header .fw-semibold {
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--success-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-outline-secondary {
            border: 1px solid #6b7280;
            color: #6b7280;
            background: transparent;
            border-radius: 8px;
            padding: 0.4rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-outline-secondary:hover {
            background: #6b7280;
            color: white;
            transform: translateY(-1px);
        }

        .btn-info {
            background: var(--info-color);
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .card-body {
            padding: 1.25rem;
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
            padding: 0.75rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .table tbody td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            border-color: #f3f4f6;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f9fafb;
        }

        .table tbody tr {
            transition: all 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: var(--bg-light) !important;
        }

        .badge-day {
            background: #dbeafe;
            color: #1e40af;
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid #bfdbfe;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .alert {
            border-radius: 8px;
            border: 1px solid transparent;
            padding: 0.6rem 0.875rem;
            margin-bottom: 0.875rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
            font-size: 0.875rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .search-filter-bar {
            padding: 0.75rem 1.25rem;
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-badge {
            padding: 0.35rem 0.75rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-badge:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .filter-badge.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Modal Styling */
        .modal {
            backdrop-filter: blur(3px);
        }

        .modal-dialog {
            margin: 1.5rem auto;
            max-width: 600px;
        }

        .modal-content {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 0.875rem 1.25rem;
            border: none;
            border-bottom: 2px solid var(--primary-dark);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .modal-title i {
            font-size: 1.4rem;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 1;
            padding: 0.4rem;
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 1.25rem;
            background: white;
        }

        .modal-body .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
            font-size: 0.875rem;
        }

        .modal-body .form-control,
        .modal-body .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            background: white;
        }

        .modal-body .form-control:focus,
        .modal-body .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modal-footer {
            padding: 0.875rem 1.25rem;
            border-top: 1px solid var(--border-color);
            background: var(--bg-light);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .modal-footer .btn {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .modal-footer .btn-secondary {
            background: #6b7280;
            border: none;
            color: white;
        }

        .modal-footer .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);
        }

        .modal-footer .btn-primary {
            background: var(--success-color);
            border: none;
            color: white;
        }

        .modal-footer .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .empty-state {
            padding: 2rem 1rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.4;
        }

        .empty-state p {
            font-size: 0.95rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 0.75rem;
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
        <div class="d-flex justify-content-end mb-2">
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
                                    <i class="fas fa-save me-1"></i>
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
            <div class="search-filter-bar">
                <input type="text" id="searchCauHinh" class="search-input" placeholder="🔍 Tìm kiếm theo lớp học, thứ, phòng...">
                <div class="filter-badge active" data-filter="all">Tất cả</div>
                <?php foreach ($thuMap as $thuNum => $thuName): ?>
                    <div class="filter-badge" data-filter="thu-<?= $thuNum ?>"><?= htmlspecialchars($thuName) ?></div>
                <?php endforeach; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0" id="tableCauHinh">
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
                                    <?php
                                    $thu = (int)($item['ThuTrongTuan'] ?? 0);
                                    $tenLop = htmlspecialchars($item['TenLop'] ?? ('Lớp #' . $item['MaLop']));
                                    $phong = htmlspecialchars($item['PhongHocMacDinh'] ?? '');
                                    ?>
                                    <tr data-class="<?= strtolower($tenLop) ?>" data-thu="<?= $thu ?>" data-phong="<?= strtolower($phong) ?>">
                                        <td>
                                            <span class="fw-medium"><?= $tenLop ?></span>
                                        </td>
                                        <td>
                                            <span class="badge-day">
                                                <?= htmlspecialchars($thuMap[$thu] ?? ('Thứ ' . $thu)) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <i class="far fa-clock me-1 text-muted"></i>
                                            <?= htmlspecialchars(substr($item['GioBatDau'] ?? '', 0, 5)) ?>
                                        </td>
                                        <td>
                                            <i class="far fa-clock me-1 text-muted"></i>
                                            <?= htmlspecialchars(substr($item['GioKetThuc'] ?? '', 0, 5)) ?>
                                        </td>
                                        <td><?= $phong ?: '<span class="text-muted">-</span>' ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info me-1" 
                                                title="Chỉnh sửa"
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
                                            <button class="btn btn-sm btn-danger" 
                                                title="Xóa"
                                                onclick="deleteCauHinh(<?php echo (int)$item['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Chưa có cấu hình lịch học nào</p>
                                    </td>
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

        // Search functionality
        const searchCauHinh = document.getElementById('searchCauHinh');
        const tableCauHinh = document.getElementById('tableCauHinh');
        const rowsCauHinh = tableCauHinh ? tableCauHinh.querySelectorAll('tbody tr') : [];

        if (searchCauHinh) {
            searchCauHinh.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                filterTable();
            });
        }

        // Filter functionality
        const filterBadges = document.querySelectorAll('.filter-badge[data-filter]');
        let currentFilter = 'all';

        filterBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                // Update active state
                filterBadges.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                currentFilter = this.getAttribute('data-filter');
                filterTable();
            });
        });

        function filterTable() {
            const searchTerm = searchCauHinh ? searchCauHinh.value.toLowerCase().trim() : '';
            
            rowsCauHinh.forEach(row => {
                const className = row.getAttribute('data-class') || '';
                const phong = row.getAttribute('data-phong') || '';
                const thu = row.getAttribute('data-thu') || '';
                
                // Search filter
                const matchesSearch = !searchTerm || 
                    className.includes(searchTerm) || 
                    phong.includes(searchTerm) ||
                    row.textContent.toLowerCase().includes(searchTerm);
                
                // Day filter
                let matchesFilter = true;
                if (currentFilter !== 'all') {
                    const filterThu = currentFilter.replace('thu-', '');
                    matchesFilter = thu === filterThu;
                }
                
                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>

</html>

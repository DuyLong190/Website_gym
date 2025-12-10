<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hội viên - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8f2121;
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

        .card-header .fw-bold {
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

        .btn-add-user {
            background: #000000;
            border: none;
            width: 48px;
            height: 48px;
            padding: 0;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .btn-add-user:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            color: white;
        }

        .btn-add-user i {
            margin: 0;
        }

        .total-count-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .total-count-badge i {
            font-size: 1rem;
        }

        .total-count-badge strong {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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

        .status-badge {
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pause {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancel {
            background: #fee2e2;
            color: #991b1b;
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

        .profile-value {
            color: #1f2937;
            font-weight: 500;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .profile-img-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 20px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        /* DataTables pagination icons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border: 1px solid var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border: 1px solid var(--primary-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button i {
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Modal Delete Confirmation */
        .delete-modal .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .delete-modal .modal-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #c53030 100%);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .delete-modal .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .delete-modal .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .delete-modal .modal-title i {
            font-size: 1.75rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .delete-modal .modal-body {
            padding: 1.5rem;
            background: #fafafa;
        }

        .delete-modal .warning-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .delete-modal .warning-icon i {
            font-size: 2.5rem;
            color: #d97706;
        }

        .delete-modal .warning-text {
            text-align: center;
            color: #1f2937;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .delete-modal .account-info {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1.5rem 0;
            border: 2px solid #fee2e2;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .delete-modal .account-info-label {
            font-size: 0.85rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .delete-modal .account-info-value {
            font-size: 1.1rem;
            color: #1f2937;
            font-weight: 600;
        }

        .delete-modal .modal-footer {
            padding: 1rem 1.5rem;
            border: none;
            background: #f9fafb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .delete-modal .btn-cancel {
            background: #6b7280;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .delete-modal .btn-cancel:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
            color: white;
        }

        .delete-modal .btn-delete {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #c53030 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .delete-modal .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
            color: white;
        }

        .alert-container {
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

            .page-header h1 .icon-wrapper {
                width: 44px;
                height: 44px;
            }

            .page-header h1 .icon-wrapper i {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="alert-container" style="margin-bottom: 1.5rem;">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="page-header">
            <h1>
                <div class="icon-wrapper">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Quản lý hội viên</span>
                </div>
            </h1>
        </div>
        <div class="card admin-card">
            <div class="card-header">
                <div class="fw-bold">
                    <i class="fas fa-table"></i>
                    Danh sách hội viên
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="total-count-badge">
                        <i class="fas fa-user me-2"></i>
                        <span>Tổng: <strong><?php echo count($hoiVien ?? []); ?></strong></span>
                    </div>
                    <a href="/gym/admin/user/addUser" class="btn btn-add-user" title="Thêm hội viên">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="hoiVienTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Ảnh đại diện</th>
                                <th class="text-center">Họ và tên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">SĐT</th>
                                <th class="text-center">Gói tập</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hoiVien as $hv): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php
                                        $imageUrl = !empty($hv->image) ? '/gym/' . $hv->image : '/gym/public/images/user.png';
                                        ?>
                                        <?php if (!empty($hv->image)): ?>
                                            <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                                                alt="<?php echo htmlspecialchars($hv->HoTen ?? 'Hội viên'); ?>"
                                                class="profile-img"
                                                onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'profile-img-placeholder\'><i class=\'fa-solid fa-user\'></i></div>';">
                                        <?php else: ?>
                                            <div class="profile-img-placeholder">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="profile-value"><?= htmlspecialchars($hv->HoTen) ?></td>
                                    <td class="profile-value">
                                        <?= $hv->NgaySinh ? date('d/m/Y', strtotime($hv->NgaySinh)) : '' ?>
                                    </td>
                                    <td class="profile-value">
                                        <?= $hv->GioiTinh ? htmlspecialchars($hv->GioiTinh) : '' ?>
                                    </td>
                                    <td class="profile-value">
                                        <?= $hv->SDT ? htmlspecialchars($hv->SDT) : '' ?>
                                    </td>
                                    <td class="profile-value">
                                        <?php 
                                        // Chỉ hiển thị tên gói tập nếu đã thanh toán
                                        $daThanhToan = isset($hv->DaThanhToan) ? (int)$hv->DaThanhToan : 0;
                                        if ($daThanhToan === 1 && !empty($hv->TenGoiTap)) {
                                            echo htmlspecialchars($hv->TenGoiTap);
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="status-badge 
                                                        <?php
                                                        if ($hv->TrangThai === 'Đang hoạt động') echo 'status-active';
                                                        elseif ($hv->TrangThai === 'Tạm ngưng') echo 'status-pause';
                                                        else echo 'status-cancel';
                                                        ?>">
                                            <?= htmlspecialchars($hv->TrangThai) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/gym/admin/user/showUser/<?= $hv->MaHV ?>"
                                            class="btn btn-sm btn-success me-1" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/gym/admin/user/editUser/<?= $hv->MaHV ?>"
                                            class="btn btn-sm btn-info me-1" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDeleteHoiVien(<?= $hv->MaHV; ?>, '<?php echo htmlspecialchars($hv->HoTen ?? 'N/A', ENT_QUOTES); ?>')"
                                            class="btn btn-sm btn-danger me-1" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($hoiVien)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Không có hội viên nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Xác nhận Xóa -->
    <div class="modal fade delete-modal" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Xác nhận xóa hội viên</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="warning-text">
                        Bạn có chắc chắn muốn xóa hội viên này?<br>
                        <strong class="text-danger">Thao tác này không thể hoàn tác!</strong>
                    </div>
                    <div class="account-info">
                        <div class="account-info-label">Họ và tên</div>
                        <div class="account-info-value" id="deleteHoiVienName"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                    </button>
                    <button type="button" class="btn btn-delete" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hoiVienTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json',
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
                },
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Tất cả"]
                ],
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [0, 7] // Disable sorting for image and action columns
                }]
            });
        });

        let hoiVienIdToDelete = null;

        function confirmDeleteHoiVien(id, name) {
            hoiVienIdToDelete = id;

            // Cập nhật thông tin hội viên trong modal
            document.getElementById('deleteHoiVienName').textContent = name;

            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        // Xử lý khi click nút xác nhận xóa
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (hoiVienIdToDelete) {
                window.location.href = '/gym/admin/user/deleteUser/' + hoiVienIdToDelete;
            }
        });

        // Reset khi modal đóng
        document.getElementById('deleteConfirmModal').addEventListener('hidden.bs.modal', function() {
            hoiVienIdToDelete = null;
        });
    </script>
</body>

</html>
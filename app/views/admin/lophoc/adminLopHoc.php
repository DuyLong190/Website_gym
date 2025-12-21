<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
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
            padding: 1rem rem;
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
            padding-bottom: 0rem;
            background: #fafafa;
        }

        .modal-body .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-body .form-label i {
            color: var(--primary-color);
            font-size: 1rem;
            width: 20px;
        }

        .modal-body .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: white;
        }

        .modal-body .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modal-body .form-control:hover {
            border-color: #c7d2fe;
        }

        .modal-body textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            padding-top: 0rem;
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .form-group-enhanced {
            position: relative;
            margin-bottom: 1rem;
        }

        .modal-body .mb-3 {
            margin-bottom: 1rem !important;
        }

        .form-group-enhanced .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
            pointer-events: none;
        }

        .form-group-enhanced .form-control {
            padding-left: 3rem;
        }

        .form-group-enhanced .form-control:focus+.input-icon {
            color: var(--primary-color);
        }

        .text-danger.small {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .text-danger.small::before {
            content: '⚠';
            font-size: 1rem;
        }

        .form-control.is-valid {
            border-color: var(--success-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2312a84c' d='m2.3 6.73.98-.98-.98-.98-.98.98.98.98zm5.4-5.4.98-.98-.98-.98-.98.98.98.98z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.4.4.4-.4m0 4.8-.4-.4-.4.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .alert-danger {
            border-radius: 12px;
            border: none;
            background: #fee2e2;
            color: #991b1b;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .alert-danger i {
            color: #ef4444;
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
            0%, 100% {
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

            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }

            .modal-body {
                padding: 1.5rem;
            }

            .modal-footer {
                padding: 1rem 1.5rem;
                flex-direction: column;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    $errorsAdd = $_SESSION['errors_lophoc_add'] ?? [];
    $oldAdd = $_SESSION['old_lophoc_add'] ?? [];
    $hasErrorsAdd = !empty($errorsAdd);
    unset($_SESSION['errors_lophoc_add'], $_SESSION['old_lophoc_add']);
    ?>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <div class="icon-wrapper">
                    <i class="fas fa-people-roof"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Quản lý lớp học</span>
                </div>
            </h1>
        </div>
        <div class="card admin-card">
            <div class="card-header">
                <div class="fw-bold">
                    <i class="fas fa-table"></i>
                    Danh sách lớp học
                </div>
                <button class="btn btn-add-user" data-bs-toggle="modal" data-bs-target="#addLopHocModal" title="Thêm lớp học">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="lopHocTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Tên lớp học</th>
                                <th class="text-center">PT phụ trách</th>
                                <th class="text-center">Giá</th>
                                <th class="text-center">Bắt đầu</th>
                                <th class="text-center">Kết thúc</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lophocs)): ?>
                                <?php foreach ($lophocs as $lophoc): ?>
                                    <tr>
                                        <td class="profile-value"><?php echo htmlspecialchars($lophoc->TenLop) ?></td>
                                        <td class="profile-value">
                                            <?php
                                            $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có';
                                            echo htmlspecialchars($tenPT);
                                            ?>
                                        </td>
                                        <td class="profile-value"><?php echo number_format($lophoc->GiaTien, 0, ',', '.'); ?> VNĐ</td>
                                        <td class="profile-value"><?= $lophoc->NgayBatDau ? date('d/m/Y', strtotime($lophoc->NgayBatDau)) : ''; ?></td>
                                        <td class="profile-value"><?= $lophoc->NgayKetThuc ? date('d/m/Y', strtotime($lophoc->NgayKetThuc)) : ''; ?></td>
                                        <td class="profile-value">
                                            <?php
                                            $soDangKy = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                            $soLuongToiDa = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
                                            if ($soLuongToiDa > 0) {
                                                echo '<span class="badge bg-info">' . $soDangKy . ' / ' . $soLuongToiDa . '</span>';
                                            } else {
                                                echo '<span class="text-muted">' . $soDangKy . ' / Không giới hạn</span>';
                                            }
                                            ?>
                                        </td>
                                        
                                        <td>
                                            <?php
                                            $status = $lophoc->TrangThai ?? 'Chưa xác định';
                                            if ($status === 'Đang mở') {
                                                $statusClass = 'status-active';
                                            } elseif ($status === 'Tạm ngưng') {
                                                $statusClass = 'status-pause';
                                            } else {
                                                $statusClass = 'status-cancel';
                                            }
                                            ?>
                                            <span class="status-badge <?php echo htmlspecialchars($statusClass); ?>">
                                                <?= htmlspecialchars($status); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success me-1" onclick="showLopHoc(<?php echo $lophoc->MaLop ?>)" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info me-1" onclick="editLopHoc(<?php echo $lophoc->MaLop ?>)" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="confirmDeleteLopHoc(<?php echo $lophoc->MaLop; ?>, '<?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES); ?>')" 
                                                    class="btn btn-sm btn-danger me-1" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Không có lớp học nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLopHocModal" tabindex="-1" aria-labelledby="addLopHocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLopHocModalLabel">
                        <i class="fas fa-people-roof"></i>
                        Thêm Lớp học mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/gym/admin/lophoc/saveLopHoc" method="POST" id="addLopHocForm">
                    <div class="modal-body">
                        <div class="form-group-enhanced">
                            <label class="form-label">
                                <i class="fas fa-tag"></i>
                                Tên Lớp Học
                            </label>
                            <input type="text" class="form-control" name="TenLop" required
                                value="<?php echo htmlspecialchars($oldAdd['TenLop'] ?? ''); ?>" placeholder="Nhập tên lớp học">
                            <?php if (!empty($errorsAdd['TenLop'])): ?>
                                <div class="text-danger small"><?php echo htmlspecialchars($errorsAdd['TenLop']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group-enhanced">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Giá (VNĐ)
                            </label>
                            <input type="number" class="form-control" name="GiaTien" required min="50000"
                                value="<?php echo htmlspecialchars($oldAdd['GiaTien'] ?? ''); ?>" placeholder="Nhập giá tiền">
                            <?php if (!empty($errorsAdd['GiaTien'])): ?>
                                <div class="text-danger small"><?php echo htmlspecialchars($errorsAdd['GiaTien']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group-enhanced">
                            <label class="form-label">
                                <i class="fas fa-calendar-check"></i>
                                Ngày bắt đầu
                            </label>
                            <input type="date" class="form-control" name="NgayBatDau" required
                                value="<?php echo htmlspecialchars($oldAdd['NgayBatDau'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['NgayBatDau'])): ?>
                                <div class="text-danger small"><?php echo htmlspecialchars($errorsAdd['NgayBatDau']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group-enhanced">
                            <label class="form-label">
                                <i class="fas fa-calendar-times"></i>
                                Ngày kết thúc
                            </label>
                            <input type="date" class="form-control" name="NgayKetThuc" required
                                value="<?php echo htmlspecialchars($oldAdd['NgayKetThuc'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['NgayKetThuc'])): ?>
                                <div class="text-danger small"><?php echo htmlspecialchars($errorsAdd['NgayKetThuc']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group-enhanced">
                            <label class="form-label">
                                <i class="fas fa-users"></i>
                                Số lượng tối đa
                            </label>
                            <input type="number" class="form-control" name="SoLuongToiDa" min="1"
                                value="<?php echo htmlspecialchars($oldAdd['SoLuongToiDa'] ?? ''); ?>" placeholder="Nhập số lượng">
                            <?php if (!empty($errorsAdd['SoLuongToiDa'])): ?>
                                <div class="text-danger small"><?php echo htmlspecialchars($errorsAdd['SoLuongToiDa']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                Mô Tả
                            </label>
                            <textarea class="form-control" name="MoTa" rows="4" placeholder="Nhập mô tả"><?php echo htmlspecialchars($oldAdd['MoTa'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="me-auto btn btn-primary">
                            <i class="fas fa-save"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </form>
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
                        <span>Xác nhận xóa lớp học</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="warning-text">
                        Bạn có chắc chắn muốn xóa lớp học này?<br>
                        <strong class="text-danger">Thao tác này không thể hoàn tác!</strong>
                    </div>
                    <div class="account-info">
                        <div class="account-info-label">Tên lớp học</div>
                        <div class="account-info-value" id="deleteLopHocName"></div>
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
            $('#lopHocTable').DataTable({
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
                    [0, 'asc']
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    } // Disable sorting for action column
                ]
            });
        });

        function showLopHoc(id) {
            window.location.href = `/gym/admin/lophoc/showLopHoc/${id}`;
        }

        function editLopHoc(id) {
            window.location.href = `/gym/admin/lophoc/editLopHoc/${id}`;
        }

        let lopHocIdToDelete = null;

        function confirmDeleteLopHoc(id, name) {
            lopHocIdToDelete = id;
            
            // Cập nhật thông tin lớp học trong modal
            document.getElementById('deleteLopHocName').textContent = name;
            
            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        // Xử lý khi click nút xác nhận xóa
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (lopHocIdToDelete) {
                window.location.href = '/gym/admin/lophoc/deleteLopHoc/' + lopHocIdToDelete;
            }
        });

        // Reset khi modal đóng
        document.getElementById('deleteConfirmModal').addEventListener('hidden.bs.modal', function() {
            lopHocIdToDelete = null;
        });

        // Validate quan hệ ngày bắt đầu / kết thúc cho form thêm mới
        document.addEventListener('DOMContentLoaded', function() {
            var startInput = document.querySelector('#addLopHocModal input[name="NgayBatDau"]');
            var endInput = document.querySelector('#addLopHocModal input[name="NgayKetThuc"]');
            var formAdd = document.querySelector('#addLopHocModal form');

            if (!startInput || !endInput || !formAdd) return;

            function validateDates() {
                if (!startInput.value || !endInput.value) {
                    endInput.setCustomValidity('');
                    return;
                }

                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                if (endDate <= startDate) {
                    endInput.setCustomValidity('Ngày kết thúc phải lớn hơn ngày bắt đầu');
                } else {
                    endInput.setCustomValidity('');
                }
            }

            startInput.addEventListener('change', validateDates);
            endInput.addEventListener('change', validateDates);

            formAdd.addEventListener('submit', function(e) {
                validateDates();
                if (!formAdd.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });

        // Modal enhancement
        $(document).ready(function() {
            // Reset form when modal is closed
            $('#addLopHocModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('.form-control').removeClass('is-invalid is-valid');
                $(this).find('.text-danger.small').remove();
            });

            // Form validation with visual feedback
            $('#addLopHocForm').on('submit', function(e) {
                let isValid = true;
                $(this).find('input[required], textarea[required]').each(function() {
                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid').removeClass('is-valid');
                        isValid = false;
                    } else {
                        $(this).addClass('is-valid').removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    if ($('.alert-danger').length === 0) {
                        $('.modal-body').prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle me-2"></i>Vui lòng điền đầy đủ thông tin bắt buộc.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                }
            });

            // Real-time validation
            $('#addLopHocForm input[required], #addLopHocForm textarea[required]').on('blur', function() {
                if ($(this).val().trim()) {
                    $(this).addClass('is-valid').removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                }
            });
        });

        <?php if ($hasErrorsAdd): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var addModal = new bootstrap.Modal(document.getElementById('addLopHocModal'));
                addModal.show();
            });
        <?php endif; ?>
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đăng ký lớp học - Admin</title>
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

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
            color: white;
        }

        .btn-success {
            background: var(--success-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
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

        .info-badge {
            background: #e0e7ff;
            color: #3730a3;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-badge i {
            font-size: 1rem;
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
        }
    </style>
</head>

<body>
    <div class="main-content">
        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Danh sách đăng ký lớp học</span>
                    </div>
                </h1>
            </div>
            <div class="card admin-card">
                <div class="card-header">
                    <div class="fw-bold">
                        <i class="fas fa-table"></i>
                        <?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="info-badge">
                            <i class="fas fa-user-check"></i>
                            Tổng số: <?php echo count($danhSachDangKy ?? []); ?> người
                        </span>
                        <?php if (!empty($danhSachDangKy)): ?>
                        <a href="/gym/admin/lophoc/exportExcelDangKy/<?php echo $lophoc->MaLop; ?>" class="btn btn-success" style="background: var(--success-color); border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-file-excel"></i>
                            Xuất Excel
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($danhSachDangKy)): ?>
                        <div class="table-responsive">
                            <table id="dangKyTable" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Họ tên</th>
                                        <th class="text-center">Số điện thoại</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Địa chỉ</th>
                                        <th class="text-center">Ngày đăng ký</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($danhSachDangKy as $index => $dangKy): ?>
                                        <tr>
                                            <td class="text-center profile-value"><?php echo $index + 1; ?></td>
                                            <td class="profile-value"><?php echo htmlspecialchars($dangKy['HoTen'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="profile-value"><?php echo htmlspecialchars($dangKy['SDT'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="profile-value"><?php echo htmlspecialchars($dangKy['Email'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="profile-value"><?php echo htmlspecialchars($dangKy['DiaChi'] ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="text-center profile-value">
                                                <?php 
                                                if (!empty($dangKy['created_at'])) {
                                                    $date = new DateTime($dangKy['created_at']);
                                                    echo $date->format('d/m/Y H:i');
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có người đăng ký lớp học này.</p>
                        </div>
                    <?php endif; ?>
                    <div class="mt-3">
                        <a href="/gym/admin/lophoc" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Không tìm thấy lớp học</span>
                    </div>
                </h1>
            </div>
            <div class="card admin-card">
                <div class="card-body">
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-exclamation-circle fa-3x mb-2"></i>
                        <p>Vui lòng quay lại danh sách để chọn lớp học khác.</p>
                        <a href="/gym/admin/lophoc" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dangKyTable').DataTable({
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
                ]
            });
        });
    </script>
</body>

</html>

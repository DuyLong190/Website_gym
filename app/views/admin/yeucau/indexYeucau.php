<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu cầu thanh toán - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8f2121;
            --secondary-color: #8f2121;
            --success-color: #12a84c;
            --warning-color: #f59e0b;
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
            max-width: 1400px;
            margin: 0 auto;
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
            padding: 1.5rem 2rem;
            margin: 0 auto 2rem auto;
            box-shadow: var(--card-shadow);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .page-header h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .page-header h1 i {
            font-size: 1.5rem;
        }

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            position: relative;
            z-index: 1;
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
            background: linear-gradient(135deg, var(--primary-color) 0%, #aa3a0e 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header i {
            font-size: 1.3rem;
        }

        .card-body {
            padding: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
        }

        .table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .table thead th {
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            color: #334155;
            font-size: 0.95rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .status-confirmed {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(18, 168, 76, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(18, 168, 76, 0.4);
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
        }

        .btn-success:active {
            transform: translateY(0);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            color: #cbd5e1;
        }

        .empty-state h4 {
            color: #475569;
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
        }

        .package-name {
            color: var(--primary-color);
            font-weight: 600;
        }

        .date-text {
            color: #64748b;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .page-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .table-container {
                overflow-x: scroll;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <i class="fas fa-money-bill-wave"></i>
                <span>Danh sách yêu cầu thanh toán</span>
            </h1>
            <?php if (!empty($yeuCaus)): ?>
                <div class="stats-badge">
                    <i class="fas fa-list-check me-2"></i>
                    Tổng: <?= count($yeuCaus) ?> yêu cầu
                </div>
            <?php endif; ?>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-clipboard-list"></i>
                <span>Quản lý yêu cầu thanh toán</span>
            </div>
            <div class="card-body">
                <?php if (!empty($yeuCaus)): ?>
                    <div class="table-container">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hội viên</th>
                                    <th>Loại</th>
                                    <th>Tên dịch vụ/Gói tập/Lớp học</th>
                                    <th>Số tiền</th>
                                    <th>Ngày yêu cầu</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($yeuCaus as $index => $yc): ?>
                                    <?php
                                    $trangThai = $yc['TrangThai'] ?? '';
                                    $isPending = ($trangThai === 'Chờ xác nhận');
                                    $isConfirmed = ($trangThai === 'Đã xác nhận');
                                    $isRejected = ($trangThai === 'Từ chối');
                                    
                                    $statusClass = 'status-pending';
                                    if ($isConfirmed) {
                                        $statusClass = 'status-confirmed';
                                    } elseif ($isRejected) {
                                        $statusClass = 'status-rejected';
                                    }
                                    
                                    $ngayYeuCau = $yc['NgayYeuCau'] ?? '';
                                    $formattedDate = '';
                                    if (!empty($ngayYeuCau)) {
                                        try {
                                            $dateObj = new DateTime($ngayYeuCau);
                                            $formattedDate = $dateObj->format('d/m/Y H:i');
                                        } catch (Exception $e) {
                                            $formattedDate = $ngayYeuCau;
                                        }
                                    }

                                    // Xác định loại và tên hiển thị
                                    $loai = $yc['Loai'] ?? 'GoiTap';
                                    $tenHienThi = 'N/A';
                                    $loaiText = 'Gói tập';
                                    $loaiIcon = 'fa-ticket-alt';
                                    $loaiColor = 'text-primary';

                                    if ($loai === 'GoiTap') {
                                        $tenHienThi = $yc['TenGoiTap'] ?? 'N/A';
                                        $loaiText = 'Gói tập';
                                        $loaiIcon = 'fa-ticket-alt';
                                        $loaiColor = 'text-primary';
                                    } elseif ($loai === 'DichVu') {
                                        $tenHienThi = $yc['TenDichVu'] ?? 'N/A';
                                        $loaiText = 'Dịch vụ';
                                        $loaiIcon = 'fa-spa';
                                        $loaiColor = 'text-success';
                                    } elseif ($loai === 'LopHoc') {
                                        $tenHienThi = $yc['TenLop'] ?? 'N/A';
                                        $loaiText = 'Lớp học';
                                        $loaiIcon = 'fa-chalkboard-teacher';
                                        $loaiColor = 'text-info';
                                    }

                                    $soTien = isset($yc['SoTien']) ? number_format((float)$yc['SoTien'], 0, ',', '.') : '0';
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-secondary"><?= $index + 1 ?></span>
                                        </td>
                                        <td>
                                            <span class="user-name">
                                                <i class="fas fa-user me-2 text-primary"></i>
                                                <?= htmlspecialchars($yc['HoTen'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?= $loaiColor ?>">
                                                <i class="fas <?= $loaiIcon ?> me-2"></i>
                                                <?= htmlspecialchars($loaiText) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="package-name">
                                                <i class="fas fa-tag me-2"></i>
                                                <?= htmlspecialchars($tenHienThi) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-danger">
                                                <?= $soTien ?> đ
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-text">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <?= $formattedDate ?: 'N/A' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <i class="fas fa-<?= $isPending ? 'clock' : ($isConfirmed ? 'check-circle' : 'times-circle') ?> me-1"></i>
                                                <?= htmlspecialchars($trangThai) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($isPending): ?>
                                                <form method="post" action="/gym/admin/yeucau/confirmYeuCau/<?= htmlspecialchars((string)($yc['id'] ?? '')) ?>" style="display:inline-block;">
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có chắc chắn muốn xác nhận yêu cầu thanh toán này?');">
                                                        <i class="fas fa-check me-1"></i>Xác nhận
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-check-double me-1"></i>Đã xử lý
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h4>Chưa có yêu cầu thanh toán</h4>
                        <p>Hiện tại chưa có yêu cầu thanh toán nào trong hệ thống.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đăng ký dịch vụ - Admin</title>
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

        .stats-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .status-cho-xac-nhan {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .status-da-xac-nhan {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-da-huy {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .status-da-hoan-thanh {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
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

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
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

        .service-name {
            color: var(--primary-color);
            font-weight: 600;
        }

        .date-text {
            color: #64748b;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
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
                <i class="fas fa-spa"></i>
                <span>Quản lý đăng ký dịch vụ</span>
            </h1>
            <div class="stats-container">
                <div class="stats-badge">
                    <i class="fas fa-clock"></i>
                    Chờ xác nhận: <?= $countChoXacNhan ?? 0 ?>
                </div>
                <div class="stats-badge">
                    <i class="fas fa-check-circle"></i>
                    Đã xác nhận: <?= $countDaXacNhan ?? 0 ?>
                </div>
                <div class="stats-badge">
                    <i class="fas fa-times-circle"></i>
                    Đã hủy: <?= $countDaHuy ?? 0 ?>
                </div>
                <div class="stats-badge">
                    <i class="fas fa-check-double"></i>
                    Đã hoàn thành: <?= $countDaHoanThanh ?? 0 ?>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-clipboard-list"></i>
                <span>Danh sách đăng ký dịch vụ</span>
            </div>
            <div class="card-body">
                <?php if (!empty($dangKys)): ?>
                    <div class="table-container">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Hội viên</th>
                                    <th>Dịch vụ</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Giờ sử dụng</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dangKys as $index => $dk): ?>
                                    <?php
                                    $trangThai = $dk->TrangThai ?? '';
                                    $statusClass = 'status-cho-xac-nhan';
                                    $statusIcon = 'clock';
                                    
                                    if ($trangThai === 'Đã xác nhận') {
                                        $statusClass = 'status-da-xac-nhan';
                                        $statusIcon = 'check-circle';
                                    } elseif ($trangThai === 'Đã hủy') {
                                        $statusClass = 'status-da-huy';
                                        $statusIcon = 'times-circle';
                                    } elseif ($trangThai === 'Đã hoàn thành') {
                                        $statusClass = 'status-da-hoan-thanh';
                                        $statusIcon = 'check-double';
                                    }
                                    
                                    $ngaySuDung = $dk->NgaySuDung ?? '';
                                    $formattedNgaySuDung = '';
                                    if (!empty($ngaySuDung)) {
                                        try {
                                            $dateObj = new DateTime($ngaySuDung);
                                            $formattedNgaySuDung = $dateObj->format('d/m/Y');
                                        } catch (Exception $e) {
                                            $formattedNgaySuDung = $ngaySuDung;
                                        }
                                    }
                                    
                                    $ngayDangKy = $dk->NgayDangKy ?? '';
                                    $formattedNgayDangKy = '';
                                    if (!empty($ngayDangKy)) {
                                        try {
                                            $dateObj = new DateTime($ngayDangKy);
                                            $formattedNgayDangKy = $dateObj->format('d/m/Y H:i');
                                        } catch (Exception $e) {
                                            $formattedNgayDangKy = $ngayDangKy;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="user-name">
                                                <?= htmlspecialchars($dk->HoTen ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="service-name">
                                                <?= htmlspecialchars($dk->TenTG ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-text">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <?= $formattedNgaySuDung ?: 'N/A' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-text">
                                                <i class="fas fa-clock me-2"></i>
                                                <?= htmlspecialchars($dk->GioSuDung ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-text">
                                                <i class="fas fa-calendar-check me-2"></i>
                                                <?= $formattedNgayDangKy ?: 'N/A' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <i class="fas fa-<?= $statusIcon ?> me-1"></i>
                                                <?= htmlspecialchars($trangThai) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= !empty($dk->GhiChu) ? htmlspecialchars($dk->GhiChu) : '-' ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <?php if ($trangThai === 'Chờ xác nhận'): ?>
                                                    <form method="post" action="/gym/admin/dangky_dichvu/confirmDangky_dichvu/<?= htmlspecialchars((string)($dk->id ?? '')) ?>" style="display:inline-block;">
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xác nhận đăng ký dịch vụ này?');">
                                                            <i class="fas fa-check me-1"></i>Xác nhận
                                                        </button>
                                                    </form>
                                                    <form method="post" action="/gym/admin/dangky_dichvu/cancelDangky_dichvu/<?= htmlspecialchars((string)($dk->id ?? '')) ?>" style="display:inline-block;">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký dịch vụ này?');">
                                                            <i class="fas fa-times me-1"></i>Hủy
                                                        </button>
                                                    </form>
                                                <?php elseif ($trangThai === 'Đã xác nhận'): ?>
                                                    <form method="post" action="/gym/admin/dangky_dichvu/completeDangky_dichvu/<?= htmlspecialchars((string)($dk->id ?? '')) ?>" style="display:inline-block;">
                                                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Bạn có chắc chắn muốn đánh dấu hoàn thành dịch vụ này?');">
                                                            <i class="fas fa-check-double me-1"></i>Hoàn thành
                                                        </button>
                                                    </form>
                                                    <form method="post" action="/gym/admin/dangky_dichvu/cancelDangky_dichvu/<?= htmlspecialchars((string)($dk->id ?? '')) ?>" style="display:inline-block;">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký dịch vụ này?');">
                                                            <i class="fas fa-times me-1"></i>Hủy
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">
                                                        <i class="fas fa-check-double me-1"></i>Đã xử lý
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h4>Chưa có đăng ký dịch vụ</h4>
                        <p>Hiện tại chưa có đăng ký dịch vụ nào trong hệ thống.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.js"></script>
</body>
</html>


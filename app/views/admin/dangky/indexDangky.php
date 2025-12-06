<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch Vụ Thư Giãn - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: #eaeef6;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 8.5rem;
            margin-top: 1rem;
            margin-right: 1rem;
            padding: 2rem;
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
            background: var(--primary-gradient);
            border-radius: 20px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stats-icon.primary {
            background: var(--primary-gradient);
        }

        .stats-icon.success {
            background: var(--success-gradient);
        }

        .stats-icon.info {
            background: var(--info-gradient);
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stats-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .content-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .card-header-custom.pt-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .card-header-custom h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header-custom .subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .table-wrapper {
            padding: 1.5rem 2rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
            border-top: none;
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge.active {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-badge.cancelled {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .status-badge.pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .btn-action {
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin: 0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.75rem;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 1rem;
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.75rem;
            }

            .table-wrapper {
                padding: 1rem;
            }

            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-clipboard-list me-3"></i>Quản lý đăng ký lớp học</h1>
            <p>Theo dõi và quản lý đăng ký lớp của hội viên và huấn luyện viên trong hệ thống</p>
        </div>

        <!-- Statistics Cards -->
        <?php
        $totalHv = count($dangkyHv ?? []);
        $activeHv = count(array_filter($dangkyHv ?? [], function ($r) {
            return trim($r['TrangThai'] ?? '') === 'DangKy';
        }));
        $ptFiltered = [];
        if (!empty($dangkyPt)) {
            foreach ($dangkyPt as $ptRow) {
                $statusRaw = $ptRow['TrangThai'] ?? '';
                if (trim($statusRaw) === 'Đăng ký') {
                    $ptFiltered[] = $ptRow;
                }
            }
        }
        $totalPt = count($ptFiltered);
        ?>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number"><?= $totalHv ?></div>
                    <div class="stats-label">Tổng đăng ký hội viên</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number"><?= $activeHv ?></div>
                    <div class="stats-label">Đang đăng ký</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon info">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stats-number"><?= $totalPt ?></div>
                    <div class="stats-label">PT đăng ký đứng lớp</div>
                </div>
            </div>
        </div>

        <!-- Đăng ký lớp của hội viên -->
        <div class="content-card">
            <div class="card-header-custom">
                <h3>
                    <i class="fas fa-users"></i>
                    Đăng ký lớp của hội viên
                </h3>
                <div class="subtitle">Danh sách hội viên đang tham gia hoặc đã hủy các lớp học</div>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Hội viên</th>
                                <th>Lớp học</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Ngày đăng ký</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dangkyHv)): ?>
                                <?php foreach ($dangkyHv as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar">
                                                    <?= strtoupper(substr($row['TenHV'] ?? 'U', 0, 1)) ?>
                                                </div>
                                                <span class="fw-semibold"><?= htmlspecialchars($row['TenHV'] ?? ''); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium"><?= htmlspecialchars($row['TenLop'] ?? ''); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php $status = trim($row['TrangThai'] ?? ''); ?>
                                            <?php if ($status !== ''): ?>
                                                <?php
                                                $badgeClass = 'pending';
                                                $badgeText = $status;
                                                if ($status === 'DangKy') {
                                                    $badgeClass = 'active';
                                                    $badgeText = 'Đang đăng ký';
                                                } elseif ($status === 'Huy') {
                                                    $badgeClass = 'cancelled';
                                                    $badgeText = 'Đã hủy';
                                                }
                                                ?>
                                                <span class="status-badge <?= $badgeClass ?>">
                                                    <i class="fas fa-<?= $status === 'DangKy' ? 'check' : ($status === 'Huy' ? 'times' : 'clock') ?>"></i>
                                                    <?= htmlspecialchars($badgeText); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-muted">
                                            <i class="far fa-calendar me-2"></i>
                                            <?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($row['id']) && trim($row['TrangThai'] ?? '') === 'DangKy'): ?>
                                                <form method="post" action="/gym/admin/dangky" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lớp học này của hội viên?');">
                                                    <input type="hidden" name="deleteId" value="<?= (int)$row['id']; ?>">
                                                    <button type="submit" class="btn btn-action btn-cancel">
                                                        <i class="fas fa-times me-1"></i>Hủy
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Chưa có đăng ký lớp nào của hội viên</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Đăng ký đứng lớp của PT -->
        <div class="content-card">
            <div class="card-header-custom pt-header">
                <h3>
                    <i class="fas fa-user-tie"></i>
                    Đăng ký đứng lớp của PT
                </h3>
                <div class="subtitle">Danh sách huấn luyện viên đang đăng ký đứng lớp</div>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Huấn luyện viên</th>
                                <th>Lớp học</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Ngày đăng ký</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ptFiltered)): ?>
                                <?php foreach ($ptFiltered as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                                    <?= strtoupper(substr($row['TenPT'] ?? 'P', 0, 1)) ?>
                                                </div>
                                                <span class="fw-semibold"><?= htmlspecialchars($row['TenPT'] ?? ''); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium"><?= htmlspecialchars($row['TenLop'] ?? ''); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php $statusPt = trim($row['TrangThai'] ?? ''); ?>
                                            <?php if ($statusPt !== ''): ?>
                                                <span class="status-badge active">
                                                    <i class="fas fa-check"></i>
                                                    <?= htmlspecialchars($statusPt); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-muted">
                                            <i class="far fa-calendar me-2"></i>
                                            <?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Chưa có đăng ký đứng lớp nào của PT</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
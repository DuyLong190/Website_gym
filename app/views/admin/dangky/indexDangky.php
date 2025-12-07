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
            --primary-color: #667eea;
            --primary-dark: #5568d3;
            --success-color: #10b981;
            --success-light: #d1fae5;
            --info-color: #3b82f6;
            --info-light: #dbeafe;
            --danger-color: #ef4444;
            --danger-light: #fee2e2;
            --warning-color: #f59e0b;
            --warning-light: #fef3c7;
            --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-light: #f9fafb;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 8.5rem;
            margin-top: 0.75rem;
            margin-right: 0.75rem;
            padding: 1rem;
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

        .page-header {
            background: var(--primary-color);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            color: white;
            margin-bottom: 1.25rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary-dark);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-header p {
            font-size: 0.9rem;
            opacity: 0.95;
            margin: 0;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: var(--card-shadow);
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
            height: 100%;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-hover-shadow);
            border-left-color: var(--primary-color);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .stats-icon.primary {
            background: var(--primary-color);
        }

        .stats-icon.success {
            background: var(--success-color);
        }

        .stats-icon.info {
            background: var(--info-color);
        }

        .stats-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stats-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.15rem;
            line-height: 1.2;
        }

        .stats-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            line-height: 1.3;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 1.25rem;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .content-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.25rem;
            border: none;
            border-bottom: 2px solid var(--primary-dark);
        }

        .card-header-custom.pt-header {
            background: var(--success-color);
            border-bottom-color: #059669;
        }

        .card-header-custom h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-header-custom .subtitle {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 0.35rem;
        }

        .table-wrapper {
            padding: 1rem 1.25rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--bg-light);
            color: var(--text-primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid var(--border-color);
            border-top: none;
        }

        .table tbody td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table tbody tr {
            transition: all 0.15s ease;
        }

        .table tbody tr:hover {
            background: var(--bg-light);
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid transparent;
        }

        .status-badge.active {
            background: var(--success-light);
            color: #065f46;
            border-color: #a7f3d0;
        }

        .status-badge.cancelled {
            background: var(--danger-light);
            color: #991b1b;
            border-color: #fecaca;
        }

        .status-badge.pending {
            background: var(--warning-light);
            color: #92400e;
            border-color: #fde68a;
        }

        .btn-action {
            padding: 0.4rem 0.875rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-cancel {
            background: var(--danger-color);
            color: white;
        }

        .btn-cancel:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .btn-cancel:active {
            transform: translateY(0);
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

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            margin-right: 0.6rem;
            flex-shrink: 0;
        }

        .user-avatar.pt-avatar {
            background: var(--success-color);
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

        @media (max-width: 768px) {
            .main-content {
                margin-left: 1rem;
                padding: 0.75rem;
            }

            .page-header {
                padding: 1rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .table-wrapper {
                padding: 0.75rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.6rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-clipboard-list me-3"></i>Quản lý đăng ký lớp học</h1>
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
                    <div class="stats-content">
                        <div class="stats-number"><?= $totalHv ?></div>
                        <div class="stats-label">Tổng hội viên đăng ký</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number"><?= $activeHv ?></div>
                        <div class="stats-label">Đang đăng ký</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon info">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number"><?= $totalPt ?></div>
                        <div class="stats-label">PT đăng ký dạy</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đăng ký lớp của hội viên -->
        <div class="content-card">
            <div class="card-header-custom">
                <h3>
                    <i class="fas fa-users"></i>
                    Hội viên đăng ký lớp
                </h3>
            </div>
            <div class="search-filter-bar">
                <input type="text" id="searchHv" class="search-input" placeholder="🔍 Tìm kiếm theo tên hội viên hoặc lớp học...">
                <div class="filter-badge active" data-filter="all">Tất cả</div>
                <div class="filter-badge" data-filter="DangKy">Đang đăng ký</div>
                <div class="filter-badge" data-filter="Huy">Đã hủy</div>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableHv">
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
                                    <?php $status = trim($row['TrangThai'] ?? ''); ?>
                                    <tr data-status="<?= htmlspecialchars($status); ?>" data-name="<?= htmlspecialchars(strtolower($row['TenHV'] ?? '')); ?>" data-class="<?= htmlspecialchars(strtolower($row['TenLop'] ?? '')); ?>">
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
                                            <small><?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?></small>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($row['id']) && trim($row['TrangThai'] ?? '') === 'DangKy'): ?>
                                                <form method="post" action="/gym/admin/dangky" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lớp học này của hội viên?');">
                                                    <input type="hidden" name="deleteId" value="<?= (int)$row['id']; ?>">
                                                    <button type="submit" class="btn btn-action btn-cancel" title="Hủy đăng ký">
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
                    Huấn luyện viên đăng ký dạy
                </h3>
            </div>
            <div class="search-filter-bar">
                <input type="text" id="searchPt" class="search-input" placeholder="🔍 Tìm kiếm theo tên PT hoặc lớp học...">
            </div>
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablePt">
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
                                    <tr data-name="<?= htmlspecialchars(strtolower($row['TenPT'] ?? '')); ?>" data-class="<?= htmlspecialchars(strtolower($row['TenLop'] ?? '')); ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar pt-avatar">
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
                                            <small><?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?></small>
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
    <script>
        // Search functionality for Hội viên table
        const searchHv = document.getElementById('searchHv');
        const tableHv = document.getElementById('tableHv');
        const rowsHv = tableHv ? tableHv.querySelectorAll('tbody tr') : [];

        if (searchHv) {
            searchHv.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                rowsHv.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const className = row.getAttribute('data-class') || '';
                    if (name.includes(searchTerm) || className.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Filter functionality for Hội viên table
        const filterBadges = document.querySelectorAll('.filter-badge[data-filter]');
        filterBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                // Update active state
                filterBadges.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                rowsHv.forEach(row => {
                    const status = row.getAttribute('data-status') || '';
                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Search functionality for PT table
        const searchPt = document.getElementById('searchPt');
        const tablePt = document.getElementById('tablePt');
        const rowsPt = tablePt ? tablePt.querySelectorAll('tbody tr') : [];

        if (searchPt) {
            searchPt.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                rowsPt.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const className = row.getAttribute('data-class') || '';
                    if (name.includes(searchTerm) || className.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
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
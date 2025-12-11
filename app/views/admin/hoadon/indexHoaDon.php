<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hóa đơn - Admin</title>
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
            color: #475569;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-cho-duyet {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-thanh-cong {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-that-bai {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .loai-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .loai-dichvu {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .loai-lophoc {
            background-color: #f3e8ff;
            color: #6b21a8;
        }

        .amount-text {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state h4 {
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .btn-confirm {
            background: var(--success-color);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-confirm:hover {
            background: #0f8a3d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(18, 168, 76, 0.3);
            color: white;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../admin/sidebarAdmin.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>
                <i class="fas fa-receipt"></i>
                Quản lý hóa đơn
            </h1>
            <div class="stats-badge">
                <i class="fas fa-clock me-1"></i>
                <?= count($hoaDons ?? []) ?> hóa đơn chờ xác nhận
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-clipboard-list"></i>
                <span>Danh sách hóa đơn chờ xác nhận</span>
            </div>
            <div class="card-body">
                <?php if (!empty($hoaDons)): ?>
                    <div class="table-container">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hội viên</th>
                                    <th>Loại</th>
                                    <th>Tên dịch vụ/Lớp học</th>
                                    <th>Số tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hoaDons as $index => $hd): ?>
                                    <?php
                                    $loai = $hd['Loai'] ?? '';
                                    $momoStatus = $hd['momo_status'] ?? '';
                                    
                                    $statusClass = 'status-cho-duyet';
                                    $statusText = 'Chờ duyệt';
                                    
                                    if ($momoStatus === 'Thành công') {
                                        $statusClass = 'status-thanh-cong';
                                        $statusText = 'Thành công';
                                    } elseif ($momoStatus === 'Thất bại') {
                                        $statusClass = 'status-that-bai';
                                        $statusText = 'Thất bại';
                                    }
                                    
                                    $loaiClass = $loai === 'DichVu' ? 'loai-dichvu' : 'loai-lophoc';
                                    $loaiText = $loai === 'DichVu' ? 'Dịch vụ' : 'Lớp học';
                                    
                                    $createdAt = $hd['created_at'] ?? '';
                                    $formattedDate = '';
                                    if (!empty($createdAt)) {
                                        try {
                                            $dateObj = new DateTime($createdAt);
                                            $formattedDate = $dateObj->format('d/m/Y H:i');
                                        } catch (Exception $e) {
                                            $formattedDate = $createdAt;
                                        }
                                    }
                                    
                                    $tenItem = $hd['TenItem'] ?? 'N/A';
                                    $isPending = ($momoStatus === 'Thành công');
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($hd['HoTen'] ?? 'N/A') ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($hd['SDT'] ?? '') ?></small>
                                        </td>
                                        <td>
                                            <span class="loai-badge <?= $loaiClass ?>">
                                                <?= htmlspecialchars($loaiText) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($tenItem) ?></strong>
                                        </td>
                                        <td>
                                            <span class="amount-text">
                                                <?= number_format($hd['amount'] ?? 0, 0, ',', '.') ?> đ
                                            </span>
                                        </td>
                                        <td class="text-secondary small">
                                            <?= $formattedDate ?: 'N/A' ?>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <?= htmlspecialchars($statusText) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($isPending): ?>
                                                <form method="post" action="/gym/admin/hoadon/confirmPayment/<?= htmlspecialchars((string)($hd['id'] ?? '')) ?>" style="display:inline-block;">
                                                    <button type="submit" class="btn btn-confirm" onclick="return confirm('Bạn có chắc chắn muốn xác nhận thanh toán này?');">
                                                        <i class="fas fa-check me-1"></i>Xác nhận
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-info-circle me-1"></i>Không thể xác nhận
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
                        <h4>Chưa có hóa đơn chờ xác nhận</h4>
                        <p>Hiện tại chưa có hóa đơn nào cần xác nhận trong hệ thống.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.js"></script>
</body>
</html>


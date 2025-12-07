<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
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

        .admin-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.25rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .card-header-custom h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body-custom {
            padding: 1rem;
        }

        /* Giữ nguyên style của bảng */
        .table-dark {
            background-color: #16213e;
        }

        .btn-custom {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .alert-container {
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .summary-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 1rem 1.25rem;
            box-shadow: var(--card-shadow);
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .summary-section i {
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .summary-section strong {
            color: #1f2937;
            font-weight: 600;
        }

        .summary-section .count {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.1rem;
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
    </style>
</head>

<body>
    <div class="main-content">
        <div class="alert-container">
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

        <div class="admin-card">
            <div class="card-header-custom">
                <h3>
                    <i class="fas fa-table"></i>
                    <span>Danh sách tài khoản</span>
                </h3>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">Tên đăng nhập</th>
                                <th scope="col">Họ và tên</th>
                                <th scope="col" class="text-center">Vai trò</th>
                                <th scope="col" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($accounts)): ?>
                                <?php foreach ($accounts as $account): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($account->username); ?></td>
                                        <td><?php echo htmlspecialchars($account->HoTen ?? 'N/A'); ?></td>
                                        <td class="text-center">
                                            <?php
                                            $roleClass = '';
                                            $roleName = '';
                                            switch ($account->role_id) {
                                                case 0:
                                                    $roleClass = 'bg-danger';
                                                    $roleName = 'Admin';
                                                    break;
                                                case 1:
                                                    $roleClass = 'bg-primary';
                                                    $roleName = 'User';
                                                    break;
                                                case 2:
                                                    $roleClass = 'bg-success';
                                                    $roleName = 'PT';
                                                    break;
                                                default:
                                                    $roleClass = 'bg-secondary';
                                                    $roleName = htmlspecialchars($account->role_name);
                                            }
                                            ?>
                                            <span class="badge <?php echo $roleClass; ?> px-3 py-2">
                                                <?php echo $roleName; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="/gym/admin/account/editAccount/<?php echo $account->id; ?>"
                                                class="btn btn-warning btn-sm btn-custom me-2">
                                                <i class="bi bi-pencil"></i> Phân quyền
                                            </a>
                                            <?php if ($account->username != $_SESSION['username'] ?? ''): ?>
                                                <button onclick="confirmDelete(<?php echo $account->id; ?>, '<?php echo htmlspecialchars($account->username, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($account->HoTen ?? 'N/A', ENT_QUOTES); ?>')"
                                                    class="btn btn-danger btn-sm btn-custom">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <em>Không có tài khoản nào trong hệ thống.</em>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="summary-section">
            <div>
                <strong>Tổng số tài khoản:</strong>
                <span class="count"><?php echo count($accounts ?? []); ?></span>
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
                        <span>Xác nhận xóa tài khoản</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="warning-text">
                        Bạn có chắc chắn muốn xóa tài khoản này?<br>
                        <strong class="text-danger">Thao tác này không thể hoàn tác!</strong>
                    </div>
                    <div class="account-info">
                        <div class="account-info-label">Tên đăng nhập</div>
                        <div class="account-info-value" id="deleteAccountUsername"></div>
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

    <script>
        let accountIdToDelete = null;

        function confirmDelete(accountId, username, fullName) {
            accountIdToDelete = accountId;

            // Cập nhật thông tin tài khoản trong modal
            document.getElementById('deleteAccountUsername').textContent = username;

            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        // Xử lý khi click nút xác nhận xóa
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (accountIdToDelete) {
                window.location.href = '/gym/admin/account/deleteAccount/' + accountIdToDelete;
            }
        });

        // Reset khi modal đóng
        document.getElementById('deleteConfirmModal').addEventListener('hidden.bs.modal', function() {
            accountIdToDelete = null;
        });
    </script>
</body>

</html>
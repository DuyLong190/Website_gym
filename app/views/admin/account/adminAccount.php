<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #fff;
        }
        .table-dark {
            background-color: #16213e;
        }
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-2 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white fw-bold">Quản Lý Tài Khoản & Phân Quyền</h2>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card bg-dark text-white shadow-lg">
                    <div class="card-body">
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
                                                        switch($account->role_id) {
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
                                                        <button onclick="confirmDelete(<?php echo $account->id; ?>)" 
                                                                class="btn btn-danger btn-sm btn-custom">
                                                            <i class="bi bi-trash"></i> Xóa
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <em>Không có tài khoản nào trong hệ thống.</em>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-muted">
                        <strong>Tổng số tài khoản:</strong> <?php echo count($accounts ?? []); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script>
        function confirmDelete(accountId) {
            if (confirm('Bạn có chắc chắn muốn xóa tài khoản này?\n\nLưu ý: Thao tác này không thể hoàn tác!')) {
                window.location.href = '/gym/admin/account/deleteAccount/' + accountId;
            }
        }
    </script>
</body>
</html>

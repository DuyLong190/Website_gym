<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Quyền Tài Khoản - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #fff;
        }
        .form-card {
            background-color: #16213e;
            border-radius: 10px;
            padding: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #f0f0f0;
        }
        .form-control, .form-select {
            background-color: #0f3460;
            color: #fff;
            border: 1px solid #16213e;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0f3460;
            color: #fff;
            border-color: #e94560;
            box-shadow: 0 0 0 0.2rem rgba(233, 69, 96, 0.25);
        }
        .form-control:disabled {
            background-color: #0a2540;
            color: #888;
        }
        .role-info {
            background-color: #0f3460;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white fw-bold">Phân Quyền Tài Khoản</h2>
                    <a href="/gym/admin/account" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>

                <div class="form-card shadow-lg">
                    <div class="role-info">
                        <h5 class="text-warning mb-3">
                            <i class="bi bi-info-circle"></i> Thông tin vai trò
                        </h5>
                        <ul class="mb-0">
                            <li><strong class="text-danger">Admin (0):</strong> Toàn quyền quản lý hệ thống</li>
                            <li><strong class="text-primary">User (1):</strong> Người dùng thông thường</li>
                            <li><strong class="text-success">PT (2):</strong> Huấn luyện viên cá nhân</li>
                        </ul>
                    </div>

                    <form action="/gym/admin/account/updateAccount" method="POST">
                        <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($account->id); ?>">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" 
                                   value="<?php echo htmlspecialchars($account->username); ?>" 
                                   disabled>
                        </div>

                        <div class="mb-3">
                            <label for="HoTen" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="HoTen" 
                                   value="<?php echo htmlspecialchars($account->HoTen ?? 'N/A'); ?>" 
                                   disabled>
                        </div>

                        <div class="mb-3">
                            <label for="current_role" class="form-label">Vai trò hiện tại</label>
                            <input type="text" class="form-control" id="current_role" 
                                   value="<?php 
                                       switch($account->role_id) {
                                           case 0: echo 'Admin'; break;
                                           case 1: echo 'User'; break;
                                           case 2: echo 'PT'; break;
                                           default: echo htmlspecialchars($account->role_name);
                                       }
                                   ?>" 
                                   disabled>
                        </div>

                        <div class="mb-4">
                            <label for="role_id" class="form-label">Chọn vai trò mới <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" id="role_id" name="role_id" required>
                                <?php if (!empty($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role->role_id; ?>" 
                                                <?php echo ($role->role_id == $account->role_id) ? 'selected' : ''; ?>>
                                            <?php 
                                                switch($role->role_id) {
                                                    case 0: echo 'Admin - Quản trị viên'; break;
                                                    case 1: echo 'User - Người dùng'; break;
                                                    case 2: echo 'PT - Huấn luyện viên'; break;
                                                    default: echo htmlspecialchars($role->role_name);
                                                }
                                            ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text text-muted mt-2">
                                Lưu ý: Thay đổi vai trò sẽ ảnh hưởng đến quyền truy cập của tài khoản này.
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/gym/admin/account" class="btn btn-secondary btn-lg px-5">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-check-circle"></i> Cập nhật quyền
                            </button>
                        </div>
                    </form>
                </div>

                <div class="alert alert-warning mt-4" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Cảnh báo:</strong> Việc thay đổi quyền của tài khoản có thể ảnh hưởng đến khả năng truy cập hệ thống. 
                    Vui lòng kiểm tra kỹ trước khi thực hiện.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>

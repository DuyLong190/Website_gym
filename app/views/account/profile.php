<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Thông tin tài khoản</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($user)): ?>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Họ và tên:</div>
                                <div class="col-md-8"><?php echo htmlspecialchars($user['fullname'] ?? ''); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Email:</div>
                                <div class="col-md-8"><?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Số điện thoại:</div>
                                <div class="col-md-8"><?php echo htmlspecialchars($user['phone'] ?? ''); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Địa chỉ:</div>
                                <div class="col-md-8"><?php echo htmlspecialchars($user['address'] ?? ''); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Ngày tham gia:</div>
                                <div class="col-md-8"><?php echo isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : ''; ?></div>
                            </div>
                            <div class="text-center mt-4">
                                <a href="/account/edit" class="btn btn-primary">Chỉnh sửa thông tin</a>
                                <a href="/account/change-password" class="btn btn-secondary">Đổi mật khẩu</a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Không tìm thấy thông tin người dùng.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu cầu thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top: 80px; margin-left: 15%; max-width: 1000px;">
    <h2 class="mb-4">Danh sách yêu cầu thanh toán</h2>

    <?php if (!empty($yeuCaus)): ?>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Hội viên</th>
                <th>Gói tập</th>
                <th>Ngày yêu cầu</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($yeuCaus as $index => $yc): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($yc['HoTen'] ?? '') ?></td>
                    <td><?= htmlspecialchars($yc['TenGoiTap'] ?? '') ?></td>
                    <td><?= htmlspecialchars($yc['NgayYeuCau'] ?? '') ?></td>
                    <td><?= htmlspecialchars($yc['TrangThai'] ?? '') ?></td>
                    <td>
                        <?php if (($yc['TrangThai'] ?? '') === 'Chờ xác nhận'): ?>
                            <form method="post" action="/gym/admin/yeucau/confirmYeuCau/<?= htmlspecialchars((string)($yc['id'] ?? '')) ?>" style="display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check me-1"></i>Xác nhận
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Hiện chưa có yêu cầu thanh toán nào.</div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

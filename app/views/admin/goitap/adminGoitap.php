<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Gói Tập - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản lý Gói Tập</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoiTapModal">
                        <i class="fas fa-plus"></i> Thêm Gói Tập Mới
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <?php
                    // Debug
                    if (empty($goiTaps)) {
                        echo '<div class="alert alert-warning">Không có dữ liệu gói tập. Vui lòng kiểm tra kết nối database.</div>';
                    }
                    ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã Gói</th>
                                <th>Tên Gói</th>
                                <th>Giá</th>
                                <th>Thời Hạn</th>
                                <th>Mô Tả</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($goiTaps)): ?>
                                <?php foreach ($goiTaps as $goiTap): ?>
                                <tr>
                                    <td><?php echo $goiTap->MaGoiTap; ?></td>
                                    <td><?php echo $goiTap->TenGoiTap; ?></td>
                                    <td><?php echo number_format($goiTap->GiaTien, 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo $goiTap->ThoiHan; ?> ngày</td>
                                    <td><?php echo $goiTap->MoTa; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editGoiTap(<?php echo $goiTap->MaGoiTap; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteGoiTap(<?php echo $goiTap->MaGoiTap; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có gói tập nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add GoiTap Modal -->
    <div class="modal fade" id="addGoiTapModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Gói Tập Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/goitap/save" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Gói</label>
                            <input type="text" class="form-control" name="TenGoiTap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="GiaTien" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời Hạn (ngày)</label>
                            <input type="number" class="form-control" name="ThoiHan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" name="MoTa" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editGoiTap(id) {
            window.location.href = `/gym/admin/goitap/edit/${id}`;
        }

        function deleteGoiTap(id) {
            if (confirm('Bạn có chắc chắn muốn xóa gói tập này?')) {
                window.location.href = `/gym/admin/goitap/delete/${id}`;
            }
        }
    </script>
</body>

</html>
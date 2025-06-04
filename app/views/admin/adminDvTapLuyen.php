<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch Vụ Tập Luyện - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'app/views/sidebar/adminSidebar.php'; ?>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản lý Dịch Vụ Tập Luyện</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDvTapLuyenModal">
                        <i class="fas fa-plus"></i> Thêm Dịch Vụ Mới
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Dịch Vụ</th>
                                <th>Giá</th>
                                <th>Thời Gian</th>
                                <th>Huấn Luyện Viên</th>
                                <th>Mô Tả</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dvTapLuyens as $dv): ?>
                            <tr>
                                <td><?php echo $dv['id']; ?></td>
                                <td><?php echo $dv['ten_dich_vu']; ?></td>
                                <td><?php echo number_format($dv['gia'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo $dv['thoi_gian']; ?> phút</td>
                                <td><?php echo $dv['huan_luyen_vien']; ?></td>
                                <td><?php echo $dv['mo_ta']; ?></td>
                                <td>
                                    <span class="badge <?php echo $dv['trang_thai'] ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $dv['trang_thai'] ? 'Hoạt động' : 'Không hoạt động'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editDvTapLuyen(<?php echo $dv['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteDvTapLuyen(<?php echo $dv['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add DvTapLuyen Modal -->
    <div class="modal fade" id="addDvTapLuyenModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Dịch Vụ Tập Luyện Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/dvtapluyen/add" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Dịch Vụ</label>
                            <input type="text" class="form-control" name="ten_dich_vu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="gia" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời Gian (phút)</label>
                            <input type="number" class="form-control" name="thoi_gian" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Huấn Luyện Viên</label>
                            <select class="form-select" name="huan_luyen_vien" required>
                                <?php foreach ($huanLuyenViens as $hlv): ?>
                                <option value="<?php echo $hlv['id']; ?>"><?php echo $hlv['ten']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" name="mo_ta" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select class="form-select" name="trang_thai">
                                <option value="1">Hoạt động</option>
                                <option value="0">Không hoạt động</option>
                            </select>
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
        function editDvTapLuyen(id) {
            window.location.href = `/admin/dvtapluyen/edit/${id}`;
        }

        function deleteDvTapLuyen(id) {
            if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
                window.location.href = `/admin/dvtapluyen/delete/${id}`;
            }
        }
    </script>
</body>
</html> 
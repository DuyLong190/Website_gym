<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản lý lớp học</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDvTapLuyenModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã lớp học</th>
                                <th>Tên lớp học</th>
                                <th>Giá</th>
                                <th>Thời Gian</th>
                                <th>Mô Tả</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lophocs as $lh): ?>
                                <tr>
                                    <td><?php echo $lh->id ?></td>
                                    <td><?php echo $lh->TenTL ?></td>
                                    <td><?php echo number_format($lh->GiaTL, 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo $lh->ThoiGianTL; ?> phút</td>
                                    <td><?php echo $lh->MoTaTL ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="showLopHoc(<?php echo $lh->id ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="editLopHoc(<?php echo $lh->id ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteLopHoc(<?php echo $lh->id ?>)">
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
                    <h5 class="modal-title">Thêm Lớp Học Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lophoc/saveLopHoc" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Lớp Học</label>
                            <input type="text" class="form-control" name="TenTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="GiaTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời Gian (phút)</label>
                            <input type="number" class="form-control" name="ThoiGianTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" name="MoTaTL" rows="3"></textarea>
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
        function showLopHoc(id) {
            window.location.href = `/gym/admin/lophoc/showLopHoc/${id}`;
        }

        function editLopHoc(id) {
            window.location.href = `/gym/admin/lophoc/editLopHoc/${id}`;
        }

        function deleteLopHoc(id) {
            if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
                window.location.href = `/gym/admin/lophoc/deleteLopHoc/${id}`;
            }
        }
    </script>
</body>

</html>
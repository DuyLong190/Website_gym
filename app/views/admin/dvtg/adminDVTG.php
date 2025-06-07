<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch Vụ Thư Giãn - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản lý dịch vụ</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDvThuGianModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã dịch vụ</th>
                                <th>Tên dịch vụ</th>
                                <th>Giá</th>
                                <th>Thời gian</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($DVTGs)): ?>
                                <?php foreach ($DVTGs as $dv): ?>
                                    <tr>
                                        <td><?php echo $dv->id ?></td>
                                        <td><?php echo htmlspecialchars($dv->TenTG) ?></td>
                                        <td><?php echo number_format($dv->GiaTG, 0, ',', '.'); ?> VNĐ</td>
                                        <td><?php echo $dv->ThoiGianTG ?> phút</td>
                                        <td><?php echo htmlspecialchars($dv->MoTaTG); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="showDvThuGian(<?php echo $dv->id ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info" onclick="editDvThuGian(<?php echo $dv->id ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteDvThuGian(<?php echo $dv->id ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có dịch vụ nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addDvThuGianModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm dịch vụ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/dvtg/saveDVTG" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Dịch Vụ</label>
                            <input type="text" class="form-control" name="TenTG" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="GiaTG" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời Gian (phút)</label>
                            <input type="number" class="form-control" name="ThoiGianTG" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea class="form-control" name="MoTaTG" rows="3"></textarea>
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
        function showDvThuGian(id) {
            window.location.href = `/gym/admin/dvtg/showDVTG/${id}`;
        }

        function editDvThuGian(id) {
            window.location.href = `/gym/admin/dvtg/editDVTG/${id}`;
        }

        function deleteDvThuGian(id) {
            if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
                window.location.href = `/gym/admin/dvtg/deleteDVTG/${id}`;
            }
        }
    </script>
</body>

</html>
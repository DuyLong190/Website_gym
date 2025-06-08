<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Gói Tập - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
        }

        .admin-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: none;
            background: #fff;
        }

        .admin-title {
            color: #6366f1;
            font-weight: 800;
            font-size: 2rem;
        }

        .btn-primary,
        .btn-success,
        .btn-warning,
        .btn-danger {
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 100%);
        }

        .table thead {
            background: #6366f1;
            color: #fff;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f3f4f6;
        }

        @media (max-width: 768px) {
            .admin-title {
                font-size: 1.3rem;
            }

            .table-responsive {
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="mb-4 admin-title text-center">
                        <i class="fa-solid fa-dumbbell me-2"></i>Quản lý gói tập
                    </h1>
                </div>
                <div class="container-fluid px-4 py-4">
                    <div class="card mb-4 admin-card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center bg-white border-0">
                            <div class="mb-2 mb-md-0">
                                <i class="fas fa-table me-1"></i>
                                <span class="fw-bold">Danh sách gói tập</span>
                            </div>
                            <div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoiTapModal">
                                    <i class="fas fa-plus"></i> Thêm gói tập
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                if (empty($goiTaps)) {
                                    echo '<div class="alert alert-warning">Không có dữ liệu gói tập. Vui lòng kiểm tra kết nối database.</div>';
                                }
                                ?>
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Mã gói tập</th>
                                            <th>Tên gói tập</th>
                                            <th>Giá</th>
                                            <th>Thời hạn</th>
                                            <th>Mô tả</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($goiTaps)): ?>
                                            <?php foreach ($goiTaps as $goiTap): ?>
                                                <tr>
                                                    <td><?php echo $goiTap['MaGoiTap']; ?></td>
                                                    <td><?php echo $goiTap['TenGoiTap']; ?></td>
                                                    <td><?php echo number_format($goiTap['GiaTien'], 0, ',', '.'); ?> VNĐ</td>
                                                    <td><?php echo $goiTap['ThoiHan']; ?> ngày</td>
                                                    <td><?php echo $goiTap['MoTa']; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-success me-1" onclick="showGoiTap(<?php echo $goiTap['MaGoiTap']; ?>)" title="Xem chi tiết">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info me-1" onclick="editGoiTap(<?php echo $goiTap['MaGoiTap']; ?>)" title="Sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger me-1" onclick="deleteGoiTap(<?php echo $goiTap['MaGoiTap']; ?>)" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Không có gói tập nào.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Thêm Gói Tập -->
    <div class="modal fade" id="addGoiTapModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Gói Tập Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/goitap/saveGoiTap" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên Gói Tập</label>
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
                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showGoiTap(id) {
            window.location.href = `/gym/admin/goitap/showGoiTap/${id}`;
        }

        function editGoiTap(id) {
            window.location.href = `/gym/admin/goitap/editGoiTap/${id}`;
        }

        function deleteGoiTap(id) {
            if (confirm('Bạn có chắc chắn muốn xóa gói tập này?')) {
                window.location.href = `/gym/admin/goitap/deleteGoiTap/${id}`;
            }
        }
    </script>
</body>

</html>
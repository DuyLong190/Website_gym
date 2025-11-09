<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --background-color: #f8fafc;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #475569;
        }

        body {
            background: linear-gradient(135deg, var(--background-color) 0%, #dbeafe 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .container-fluid {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-responsive {
            background: var(--card-background);
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            color: var(--text-primary);
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: var(--text-secondary);
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #16a34a 100%);
            border: none;
        }

        .btn-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border: none;
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        h1.h2 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        @media (max-width: 768px) {
            .table-responsive {
                padding: 1rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
            }

            .modal-dialog {
                margin: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-home-user me-2"></i>Quản lý lớp học
                    </h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDvTapLuyenModal">
                        <i class="fas fa-plus me-2"></i>Thêm mới
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Tên lớp học</th>
                                <th style="width: 8%;">Giá</th>
                                <th style="width: 8%;">Thời Gian</th>
                                <th>Mô Tả</th>
                                <th style="width: 13%;">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lophocs)): ?>
                                <?php foreach ($lophocs as $lh): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($lh->TenTL) ?></td>
                                        <td><?php echo number_format($lh->GiaTL, 0, ',', '.'); ?> VNĐ</td>
                                        <td><?php echo $lh->ThoiGianTL; ?> phút</td>
                                        <td><?php echo htmlspecialchars($lh->MoTaTL) ?></td>
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
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có lớp học nào</td>
                                </tr>
                            <?php endif; ?>
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
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Thêm Lớp Học Mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lophoc/saveLopHoc" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-tag me-2"></i>Tên Lớp Học
                            </label>
                            <input type="text" class="form-control" name="TenTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Giá
                            </label>
                            <input type="number" class="form-control" name="GiaTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock me-2"></i>Thời Gian (phút)
                            </label>
                            <input type="number" class="form-control" name="ThoiGianTL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left me-2"></i>Mô Tả
                            </label>
                            <textarea class="form-control" name="MoTaTL" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Đóng
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Thêm
                        </button>
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
            if (confirm('Bạn có chắc chắn muốn xóa lớp học này?')) {
                window.location.href = `/gym/admin/lophoc/deleteLopHoc/${id}`;
            }
        }
    </script>
</body>

</html>
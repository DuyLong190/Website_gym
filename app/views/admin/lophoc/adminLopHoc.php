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
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.35rem 0.85rem;
            font-size: 0.95rem;
            gap: 0.25rem;
            letter-spacing: 0.01em;
        }

        .status-active {
            background: #22c55e;
            color: white;
        }

        .status-pause {
            background: #facc15;
            color: #1e293b;
        }

        .status-cancel {
            background: #ef4444;
            color: white;
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
    <?php
    $errorsAdd = $_SESSION['errors_lophoc_add'] ?? [];
    $oldAdd = $_SESSION['old_lophoc_add'] ?? [];
    $hasErrorsAdd = !empty($errorsAdd);
    unset($_SESSION['errors_lophoc_add'], $_SESSION['old_lophoc_add']);
    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-home-user me-2"></i>Quản lý lớp học
                    </h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLopHocModal">
                        <i class="fas fa-plus me-2"></i>Thêm mới
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 14%;">Tên lớp học</th>
                                <th style="width: 14%;">PT phụ trách</th>
                                <th style="width: 8%;">Giá</th>
                                <th style="width: 10%;">Bắt đầu</th>
                                <th style="width: 10%;">Kết thúc</th>
                                <th style="width: 9%;">Sĩ số</th>
                                <th style="width: 9%;">Còn trống</th>
                                <th style="width: 12%;">Trạng thái</th>
                                <th style="width: 14%;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lophocs)): ?>
                                <?php foreach ($lophocs as $lophoc): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($lophoc->TenLop) ?></td>
                                        <td>
                                            <?php
                                            $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có';
                                            echo htmlspecialchars($tenPT);
                                            ?>
                                        </td>
                                        <td><?php echo number_format($lophoc->GiaTien, 0, ',', '.'); ?> VNĐ</td>
                                        <td><?= $lophoc->NgayBatDau ? date('d/m/Y', strtotime($lophoc->NgayBatDau)) : ''; ?></td>
                                        <td><?= $lophoc->NgayKetThuc ? date('d/m/Y', strtotime($lophoc->NgayKetThuc)) : ''; ?></td>
                                        <td><?php echo htmlspecialchars($lophoc->SoLuongToiDa ?? '') ?></td>
                                        <td>
                                            <?php
                                            $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
                                            $reg = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
                                            $remaining = ($max > 0) ? max($max - $reg, 0) : null;
                                            if ($remaining === null) {
                                                echo '';
                                            } else {
                                                echo htmlspecialchars((string)$remaining);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                        $status = $lophoc->TrangThai ?? 'Chưa xác định';
                                        if ($status === 'Đang mở') {
                                            $statusClass = 'status-active';
                                        } elseif ($status === 'Tạm ngưng') {
                                            $statusClass = 'status-pause';
                                        } else {
                                            $statusClass = 'status-cancel';
                                        }
                                        ?>
                                        <span class="status-badge <?php echo htmlspecialchars($statusClass); ?>">
                                            <?= htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="showLopHoc(<?php echo $lophoc->MaLop ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="editLopHoc(<?php echo $lophoc->MaLop ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteLopHoc(<?php echo $lophoc->MaLop ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Không có lớp học nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    </div>

    <div class="modal fade" id="addLopHocModal" tabindex="-1">
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
                            <input type="text" class="form-control" name="TenLop" required
                                value="<?php echo htmlspecialchars($oldAdd['TenLop'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['TenLop'])): ?>
                                <div class="text-danger small mt-1"><?php echo htmlspecialchars($errorsAdd['TenLop']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Giá
                            </label>
                            <input type="number" class="form-control" name="GiaTien" required min="50000"
                                value="<?php echo htmlspecialchars($oldAdd['GiaTien'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['GiaTien'])): ?>
                                <div class="text-danger small mt-1"><?php echo htmlspecialchars($errorsAdd['GiaTien']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock me-2"></i>Ngày bắt đầu
                            </label>
                            <input type="date" class="form-control" name="NgayBatDau" required
                                value="<?php echo htmlspecialchars($oldAdd['NgayBatDau'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['NgayBatDau'])): ?>
                                <div class="text-danger small mt-1"><?php echo htmlspecialchars($errorsAdd['NgayBatDau']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock me-2"></i>Ngày kết thúc
                            </label>
                            <input type="date" class="form-control" name="NgayKetThuc" required
                                value="<?php echo htmlspecialchars($oldAdd['NgayKetThuc'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['NgayKetThuc'])): ?>
                                <div class="text-danger small mt-1"><?php echo htmlspecialchars($errorsAdd['NgayKetThuc']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-users me-2"></i>Số lượng tối đa
                            </label>
                            <input type="number" class="form-control" name="SoLuongToiDa" min="1"
                                value="<?php echo htmlspecialchars($oldAdd['SoLuongToiDa'] ?? ''); ?>">
                            <?php if (!empty($errorsAdd['SoLuongToiDa'])): ?>
                                <div class="text-danger small mt-1"><?php echo htmlspecialchars($errorsAdd['SoLuongToiDa']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left me-2"></i>Mô Tả
                            </label>
                            <textarea class="form-control" name="MoTa" rows="3"><?php echo htmlspecialchars($oldAdd['MoTa'] ?? ''); ?></textarea>
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

        // Validate quan hệ ngày bắt đầu / kết thúc cho form thêm mới
        document.addEventListener('DOMContentLoaded', function() {
            var startInput = document.querySelector('#addLopHocModal input[name="NgayBatDau"]');
            var endInput = document.querySelector('#addLopHocModal input[name="NgayKetThuc"]');
            var formAdd = document.querySelector('#addLopHocModal form');

            if (!startInput || !endInput || !formAdd) return;

            function validateDates() {
                if (!startInput.value || !endInput.value) {
                    endInput.setCustomValidity('');
                    return;
                }

                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                if (endDate <= startDate) {
                    endInput.setCustomValidity('Ngày kết thúc phải lớn hơn ngày bắt đầu');
                } else {
                    endInput.setCustomValidity('');
                }
            }

            startInput.addEventListener('change', validateDates);
            endInput.addEventListener('change', validateDates);

            formAdd.addEventListener('submit', function(e) {
                validateDates();
                if (!formAdd.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });

        <?php if ($hasErrorsAdd): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var addModal = new bootstrap.Modal(document.getElementById('addLopHocModal'));
                addModal.show();
            });
        <?php endif; ?>
    </script>
</body>

</html>
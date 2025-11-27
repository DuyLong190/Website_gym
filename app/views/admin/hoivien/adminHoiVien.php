<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hội viên - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            margin-left: 15%;

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

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 100%);
            border: none;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pause {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-cancel {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .table thead {
            background: #6366f1;
            color: #fff;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f3f4f6;
        }

        .profile-label {
            font-weight: 600;
            color: #666;
        }

        .profile-value {
            color: #333;
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="mb-4 admin-title text-center">
                        <i class="fa-solid fa-users me-2"></i>Quản lý hội viên
                    </h1>
                </div>
                <div class="container-fluid px-4 py-4">
                    <div class="card mb-4 admin-card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center bg-white border-0">
                            <div class="mb-2 mb-md-0">
                                <i class="fas fa-table me-1"></i>
                                <span class="fw-bold">Danh sách hội viên</span>
                            </div>
                            <div>
                                <a href="/gym/admin/user/addUser" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm hội viên
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="hoiVienTable" class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Họ và tên</th>
                                            <th class="text-center">Ngày sinh</th>
                                            <th class="text-center">Giới tính</th>
                                            <th class="text-center">SĐT</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Gói tập</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hoiVien as $hv): ?>
                                            <tr>
                                                <td class="profile-value"><?= htmlspecialchars($hv->HoTen) ?></td>
                                                <td class="profile-value">
                                                    <?= $hv->NgaySinh ? date('d/m/Y', strtotime($hv->NgaySinh)) : '' ?>
                                                </td>
                                                <td class="profile-value">
                                                    <?= $hv->GioiTinh ? htmlspecialchars($hv->GioiTinh) : '' ?>
                                                </td>
                                                <td class="profile-value">
                                                    <?= $hv->SDT ? htmlspecialchars($hv->SDT) : '' ?>
                                                </td>
                                                <td class="profile-value">
                                                    <?= $hv->Email ? htmlspecialchars($hv->Email) : '' ?>
                                                </td>
                                                <td class="profile-value">
                                                    <?= !empty($hv->TenGoiTap) ? htmlspecialchars($hv->TenGoiTap) : '' ?>
                                                </td>
                                                <td>
                                                    <span class="status-badge 
                                                        <?php
                                                        if ($hv->TrangThai === 'Đang hoạt động') echo 'status-active';
                                                        elseif ($hv->TrangThai === 'Tạm ngưng') echo 'status-pause';
                                                        else echo 'status-cancel';
                                                        ?>">
                                                        <?= htmlspecialchars($hv->TrangThai) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/gym/admin/user/showUser/<?= $hv->MaHV ?>"
                                                        class="btn btn-sm btn-success me-1" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/gym/admin/user/editUser/<?= $hv->MaHV ?>"
                                                        class="btn btn-sm btn-info me-1" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/gym/admin/user/deleteUser/<?= $hv->MaHV ?>"
                                                        class="btn btn-sm btn-danger me-1"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa hội viên này?')"
                                                        title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($hoiVien)): ?>
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">Không có hội viên nào.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hoiVienTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json',
                },
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Tất cả"]
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    } // Disable sorting for action column
                ]
            });
        });
    </script>
</body>

</html>
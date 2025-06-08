<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hội viên - Admin</title>
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

        .badge-success {
            background: #22c55e !important;
        }

        .badge-warning {
            background: #f59e42 !important;
        }

        .badge-danger {
            background: #ef4444 !important;
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
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
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
                            <form action="/gym/admin/user/search" method="GET" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Tìm kiếm theo tên, số điện thoại, email..."
                                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Mã HV</th>
                                            <th>Họ tên</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Số điện thoại</th>
                                            <th>Email</th>
                                            <th>Gói tập</th>
                                            <th>Trạng thái</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hoiVien as $hv): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($hv->MaHV) ?></td>
                                                <td><?= htmlspecialchars($hv->HoTen) ?></td>
                                                <td><?= date('d/m/Y', strtotime($hv->NgaySinh)) ?></td>
                                                <td><?= htmlspecialchars($hv->GioiTinh) ?></td>
                                                <td><?= htmlspecialchars($hv->SDT) ?></td>
                                                <td><?= htmlspecialchars($hv->Email) ?></td>
                                                <td><?= htmlspecialchars($hv->TenGoiTap) ?></td>
                                                <td>
                                                    <?php
                                                    $badgeClass = 'danger';
                                                    if ($hv->TrangThai === 'Đang hoạt động') $badgeClass = 'success';
                                                    elseif ($hv->TrangThai === 'Tạm ngưng') $badgeClass = 'warning';
                                                    ?>
                                                    <span class="badge badge-<?= $badgeClass ?>">
                                                        <?= htmlspecialchars($hv->TrangThai) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/gym/admin/user/showUser/<?= $hv->MaHV ?>"
                                                        class="btn btn-sm btn-success me-1" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
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
                                                <td colspan="9" class="text-center text-muted">Không có hội viên nào.</td>
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
</body>

</html>
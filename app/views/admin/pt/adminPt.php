<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Huấn luyện viên - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #8f2121;
            --success-color: #12a84c;
            --info-color: #1c3be6ff;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            margin-left: 8.5rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 2rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            background: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            margin: 0 auto 1rem auto;
            box-shadow: var(--card-shadow);
            width: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .page-header h1 .icon-wrapper {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 i {
            font-size: 1.5rem;
            color: white;
        }

        .page-header h1 .title-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .page-header h1 .title-main {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
        }

        .admin-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-header .fw-bold {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--success-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-add-user {
            background: #000000;
            border: none;
            width: 48px;
            height: 48px;
            padding: 0;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .btn-add-user:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            color: white;
        }

        .btn-add-user i {
            margin: 0;
        }

        .total-count-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .total-count-badge i {
            font-size: 1rem;
        }

        .total-count-badge strong {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-info {
            background: var(--info-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-danger {
            background: var(--secondary-color);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .table {
            margin: 0;
        }

        .table thead {
            background: var(--primary-color);
            color: #fff;
        }

        .table thead th {
            border: none;
            padding: 1.25rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f8fafc;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9 !important;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .profile-value {
            color: #1f2937;
            font-weight: 500;
        }

        .card-body {
            padding: 2rem;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .pt-avatar-table {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .pt-avatar-table:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-hover-shadow);
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        /* DataTables pagination icons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border: 1px solid var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border: 1px solid var(--primary-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button i {
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 1rem;
            }

            .page-header {
                padding: 0.75rem 1rem;
                width: 100%;
            }

            .page-header h1 {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .page-header h1 .title-main {
                font-size: 1.25rem;
                white-space: normal;
                text-align: center;
            }

            .page-header h1 .icon-wrapper {
                width: 44px;
                height: 44px;
            }

            .page-header h1 .icon-wrapper i {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <div class="icon-wrapper">
                    <i data-feather="user"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Quản lý Huấn luyện viên</span>
                </div>
            </h1>
        </div>
        <div class="card admin-card">
            <div class="card-header">
                <div class="fw-bold">
                    <i class="fas fa-table"></i>
                    Danh sách huấn luyện viên
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="total-count-badge" id="ptTotalCount">
                        <i class="fas fa-user me-2"></i>
                        <span>Tổng: <strong>0</strong></span>
                    </div>
                    <button class="btn btn-add-user" data-bs-toggle="modal" data-bs-target="#addPTModal" title="Thêm huấn luyện viên">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ptTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Ảnh đại diện</th>
                                <th class="text-center">Họ và tên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">SĐT</th>
                                <th class="text-center">Chuyên môn</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="ptTableBody">
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Đang tải...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <!-- Modal Thêm HLV -->
    <div class="modal fade" id="addPTModal" tabindex="-1" aria-labelledby="addPTModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPTModalLabel">
                        <i class="fas fa-user-plus me-2"></i>
                        Thêm Huấn luyện viên Mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPTForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-image me-1"></i>
                                    Ảnh đại diện
                                </label>
                                <input type="file" class="form-control" name="image" id="add_image" accept="image/*">
                                <small class="text-muted">Chấp nhận: JPG, PNG, GIF (tối đa 5MB)</small>
                                <div class="mt-2" id="add_image_preview" style="display: none;">
                                    <img id="add_image_preview_img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                </div>
                                <div class="invalid-feedback" id="error-image"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Họ tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="HoTen" required placeholder="Nhập họ tên">
                                <div class="invalid-feedback" id="error-HoTen"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ngày sinh
                                </label>
                                <input type="date" class="form-control" name="NgaySinh">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars me-1"></i>
                                    Giới tính
                                </label>
                                <select class="form-select" name="GioiTinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="SDT" required placeholder="Nhập số điện thoại">
                                <div class="invalid-feedback" id="error-SDT"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email
                                </label>
                                <input type="email" class="form-control" name="Email" placeholder="example@email.com">
                                <div class="invalid-feedback" id="error-Email"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Địa chỉ
                                </label>
                                <input type="text" class="form-control" name="DiaChi" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-certificate me-1"></i>
                                    Chuyên môn
                                </label>
                                <input type="text" class="form-control" name="ChuyenMon" placeholder="VD: Gym & Fitness, Yoga, Cardio...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-briefcase me-1"></i>
                                    Kinh nghiệm (năm)
                                </label>
                                <input type="number" class="form-control" name="KinhNghiem" min="0" step="1" placeholder="0">
                                <div class="invalid-feedback" id="error-KinhNghiem"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    Lương (VNĐ)
                                </label>
                                <input type="number" class="form-control" name="Luong" min="0" step="1000" placeholder="0">
                                <div class="invalid-feedback" id="error-Luong"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="me-auto btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa HLV -->
    <div class="modal fade" id="editPTModal" tabindex="-1" aria-labelledby="editPTModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPTModalLabel">
                        <i class="fas fa-user-edit me-2"></i>
                        Sửa Thông tin Huấn luyện viên
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPTForm" enctype="multipart/form-data">
                    <input type="hidden" name="pt_id" id="edit_pt_id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-image me-1"></i>
                                    Ảnh đại diện
                                </label>
                                <input type="file" class="form-control" name="image" id="edit_image" accept="image/*">
                                <small class="text-muted">Chấp nhận: JPG, PNG, GIF (tối đa 5MB). Để trống nếu không muốn thay đổi.</small>
                                <div class="mt-2" id="edit_image_preview">
                                    <img id="edit_image_preview_img" src="" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                </div>
                                <div class="invalid-feedback" id="edit-error-image"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Họ tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="HoTen" id="edit_HoTen" required placeholder="Nhập họ tên">
                                <div class="invalid-feedback" id="edit-error-HoTen"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Ngày sinh
                                </label>
                                <input type="date" class="form-control" name="NgaySinh" id="edit_NgaySinh">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars me-1"></i>
                                    Giới tính
                                </label>
                                <select class="form-select" name="GioiTinh" id="edit_GioiTinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="SDT" id="edit_SDT" required placeholder="Nhập số điện thoại">
                                <div class="invalid-feedback" id="edit-error-SDT"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email
                                </label>
                                <input type="email" class="form-control" name="Email" id="edit_Email" placeholder="example@email.com">
                                <div class="invalid-feedback" id="edit-error-Email"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Địa chỉ
                                </label>
                                <input type="text" class="form-control" name="DiaChi" id="edit_DiaChi" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-certificate me-1"></i>
                                    Chuyên môn
                                </label>
                                <input type="text" class="form-control" name="ChuyenMon" id="edit_ChuyenMon" placeholder="VD: Gym & Fitness, Yoga, Cardio...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-briefcase me-1"></i>
                                    Kinh nghiệm (năm)
                                </label>
                                <input type="number" class="form-control" name="KinhNghiem" id="edit_KinhNghiem" min="0" step="1" placeholder="0">
                                <div class="invalid-feedback" id="edit-error-KinhNghiem"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    Lương (VNĐ)
                                </label>
                                <input type="number" class="form-control" name="Luong" id="edit_Luong" min="0" step="1000" placeholder="0">
                                <div class="invalid-feedback" id="edit-error-Luong"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="me-auto btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        let ptTable;
        let dataTableInitialized = false;

        function showPT(id) {
            window.location.href = `/gym/admin/pt/showPt/${id}`;
        }

        // Load danh sách PT khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo feather-icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            loadPTs();
            setupEventListeners();
        });

        // Load danh sách PT
        function loadPTs() {
            fetch('/gym/api/pt')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderPTTable(data.data);
                        updateTotalCount(data.data ? data.data.length : 0);
                        if (!dataTableInitialized && data.data && data.data.length > 0) {
                            initializeDataTable();
                        }
                    } else {
                        showError('Không thể tải danh sách HLV');
                        renderPTTable([]);
                        updateTotalCount(0);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi tải dữ liệu');
                    renderPTTable([]);
                    updateTotalCount(0);
                });
        }

        // Cập nhật tổng số PT
        function updateTotalCount(count) {
            const totalCountElement = document.getElementById('ptTotalCount');
            if (totalCountElement) {
                totalCountElement.querySelector('strong').textContent = count;
            }
        }

        // Khởi tạo DataTable
        function initializeDataTable() {
            if (dataTableInitialized) return;

            ptTable = $('#ptTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json',
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
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
                    targets: [0, 6] // Disable sorting for image and action columns
                }]
            });
            dataTableInitialized = true;
        }

        // Định dạng ngày dạng d/m/Y cho hiển thị bảng
        function formatDateDMY(dateStr) {
            if (!dateStr) return '';

            const raw = dateStr.split(' ')[0];
            const parts = raw.split('-');
            if (parts.length === 3) {
                const [y, m, d] = parts;
                return `${d.padStart(2, '0')}/${m.padStart(2, '0')}/${y}`;
            }

            const dObj = new Date(dateStr);
            if (isNaN(dObj.getTime())) return dateStr;
            const d = String(dObj.getDate()).padStart(2, '0');
            const m = String(dObj.getMonth() + 1).padStart(2, '0');
            const y = dObj.getFullYear();
            return `${d}/${m}/${y}`;
        }

        // Render bảng PT
        function renderPTTable(pts) {
            const tbody = document.getElementById('ptTableBody');

            if (!pts || pts.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Không có HLV nào trong hệ thống
                        </td>
                    </tr>
                `;
                if (dataTableInitialized && ptTable) {
                    ptTable.destroy();
                    dataTableInitialized = false;
                }
                // Khởi tạo lại feather-icons sau khi render
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                return;
            }

            tbody.innerHTML = pts.map(pt => {
                const imageUrl = pt.image ? `/gym/${pt.image}` : '/gym/public/images/user.png';
                return `
                <tr>
                    <td class="text-center">
                        <img src="${imageUrl}" alt="${pt.HoTen || 'PT'}" 
                             class="pt-avatar-table" 
                             onerror="this.src='/gym/public/images/user.png'">
                    </td>
                    <td class="profile-value text-center">${pt.HoTen || ''}</td>
                    <td class="profile-value text-center">${formatDateDMY(pt.NgaySinh)}</td>
                    <td class="profile-value text-center">${pt.GioiTinh || ''}</td>
                    <td class="profile-value text-center">${pt.SDT || ''}</td>
                    <td class="profile-value text-center">${pt.ChuyenMon || ''}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-success me-1" onclick="showPT(${pt.pt_id})" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-info me-1" onclick="editPT(${pt.pt_id})" title="Sửa">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger me-1" onclick="deletePT(${pt.pt_id})" title="Xóa">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            }).join('');

            // Khởi tạo lại DataTable nếu chưa được khởi tạo
            if (!dataTableInitialized) {
                initializeDataTable();
            } else if (ptTable) {
                // Nếu đã khởi tạo, reload lại
                ptTable.clear();
                ptTable.rows.add($(tbody).find('tr'));
                ptTable.draw();
            }

            // Khởi tạo lại feather-icons sau khi render
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Form thêm PT
            document.getElementById('addPTForm').addEventListener('submit', function(e) {
                e.preventDefault();
                addPT();
            });

            // Form sửa PT
            document.getElementById('editPTForm').addEventListener('submit', function(e) {
                e.preventDefault();
                updatePT();
            });

            // Preview ảnh khi chọn file (form thêm)
            document.getElementById('add_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('add_image_preview').style.display = 'block';
                        document.getElementById('add_image_preview_img').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('add_image_preview').style.display = 'none';
                }
            });

            // Preview ảnh khi chọn file (form sửa)
            document.getElementById('edit_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('edit_image_preview_img').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Reset preview khi đóng modal thêm
            document.getElementById('addPTModal').addEventListener('hidden.bs.modal', function() {
                document.getElementById('addPTForm').reset();
                document.getElementById('add_image_preview').style.display = 'none';
            });
        }

        // Thêm PT
        function addPT() {
            const form = document.getElementById('addPTForm');
            const formData = new FormData(form);

            // Clear errors và validation classes
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            fetch('/gym/api/pt', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addPTModal'));
                        if (modal) modal.hide();
                        form.reset();
                        loadPTs();
                        showSuccess('Thêm HLV thành công!');
                    } else if (result.errors) {
                        Object.keys(result.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            const errorEl = document.getElementById(`error-${key}`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            if (errorEl) {
                                errorEl.textContent = result.errors[key];
                                errorEl.style.display = 'block';
                            }
                        });
                    } else {
                        showError(result.message || 'Không thể thêm HLV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi thêm HLV');
                });
        }

        // Sửa PT
        function editPT(ptId) {
            fetch(`/gym/api/pt/${ptId}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const pt = result.data;
                        document.getElementById('edit_pt_id').value = pt.pt_id;
                        document.getElementById('edit_HoTen').value = pt.HoTen || '';
                        document.getElementById('edit_NgaySinh').value = pt.NgaySinh ? pt.NgaySinh.split(' ')[0] : '';
                        document.getElementById('edit_GioiTinh').value = pt.GioiTinh || '';
                        document.getElementById('edit_SDT').value = pt.SDT || '';
                        document.getElementById('edit_Email').value = pt.Email || '';
                        document.getElementById('edit_DiaChi').value = pt.DiaChi || '';
                        document.getElementById('edit_ChuyenMon').value = pt.ChuyenMon || '';
                        document.getElementById('edit_KinhNghiem').value = pt.KinhNghiem || '';
                        document.getElementById('edit_Luong').value = pt.Luong || '';

                        // Hiển thị ảnh hiện tại
                        const imageUrl = pt.image ? `/gym/${pt.image}` : '/gym/public/images/user.png';
                        document.getElementById('edit_image_preview_img').src = imageUrl;

                        const modal = new bootstrap.Modal(document.getElementById('editPTModal'));
                        modal.show();
                    } else {
                        showError(result.message || 'Không tìm thấy HLV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi tải thông tin HLV');
                });
        }

        // Cập nhật PT
        function updatePT() {
            const form = document.getElementById('editPTForm');
            const formData = new FormData(form);
            const ptId = document.getElementById('edit_pt_id').value;

            // Thêm _method để override thành PUT
            formData.append('_method', 'PUT');

            // Clear errors và validation classes
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            fetch(`/gym/api/pt/${ptId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editPTModal'));
                        if (modal) modal.hide();
                        loadPTs();
                        showSuccess('Cập nhật HLV thành công!');
                    } else if (result.errors) {
                        Object.keys(result.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            const errorEl = document.getElementById(`edit-error-${key}`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            if (errorEl) {
                                errorEl.textContent = result.errors[key];
                                errorEl.style.display = 'block';
                            }
                        });
                    } else {
                        showError(result.message || 'Không thể cập nhật HLV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi cập nhật HLV');
                });
        }

        // Xóa PT
        function deletePT(ptId) {
            const confirmModal = document.createElement('div');
            confirmModal.className = 'modal fade';
            confirmModal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Xác nhận xóa
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa HLV này? Hành động này không thể hoàn tác.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Hủy
                            </button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                                <i class="fas fa-trash me-1"></i> Xóa
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);

            const modal = new bootstrap.Modal(confirmModal);
            modal.show();

            confirmModal.querySelector('#confirmDeleteBtn').addEventListener('click', function() {
                modal.hide();

                fetch(`/gym/api/pt/${ptId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            loadPTs();
                            showSuccess('Xóa HLV thành công!');
                        } else {
                            showError(result.message || 'Không thể xóa HLV');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('Có lỗi xảy ra khi xóa HLV');
                    })
                    .finally(() => {
                        if (document.body.contains(confirmModal)) {
                            document.body.removeChild(confirmModal);
                        }
                    });
            });

            confirmModal.addEventListener('hidden.bs.modal', function() {
                if (document.body.contains(confirmModal)) {
                    document.body.removeChild(confirmModal);
                }
            });
        }

        // Hiển thị thông báo thành công
        function showSuccess(message) {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }

        // Hiển thị thông báo lỗi
        function showError(message) {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 4000
            });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    </script>
</body>

</html>
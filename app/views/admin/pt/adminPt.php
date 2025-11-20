<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý huấn luyện viên - Admin</title>
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

        h1.h2,
        .admin-title {
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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="admin-title">
                        <i class="fa-solid fa-user-tie me-2"></i>Quản lý Huấn luyện viên
                    </h1>
                    <div class="d-flex gap-2">
                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm HLV..."
                            style="max-width: 300px;">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPTModal">
                            <i class="fas fa-plus"></i> Thêm mới
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="ptTable">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Họ tên</th>
                                <th style="width: 10%;">Ngày sinh</th>
                                <th style="width: 8%;">Giới tính</th>
                                <th style="width: 10%;">SĐT</th>
                                <th style="width: 12%;">Chuyên môn</th>
                                <th style="width: 10%;">Địa chỉ</th>
                                <th style="width: 13%;" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="ptTableBody">
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Đang tải...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <!-- Modal Thêm HLV -->
    <div class="modal fade" id="addPTModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Huấn luyện viên Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPTForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="HoTen" required>
                                <div class="text-danger" id="error-HoTen"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" name="NgaySinh">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="GioiTinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="SDT" required>
                                <div class="text-danger" id="error-SDT"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="Email">
                                <div class="text-danger" id="error-Email"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="DiaChi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Chuyên môn</label>
                                <input type="text" class="form-control" name="ChuyenMon" placeholder="VD: Gym & Fitness">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kinh nghiệm (năm)</label>
                                <input type="number" class="form-control" name="KinhNghiem" min="0" step="1">
                                <div class="text-danger" id="error-KinhNghiem"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lương (VNĐ)</label>
                                <input type="number" class="form-control" name="Luong" min="0" step="1000">
                                <div class="text-danger" id="error-Luong"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm HLV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa HLV -->
    <div class="modal fade" id="editPTModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa Thông tin Huấn luyện viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPTForm">
                    <input type="hidden" name="pt_id" id="edit_pt_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="HoTen" id="edit_HoTen" required>
                                <div class="text-danger" id="edit-error-HoTen"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" name="NgaySinh" id="edit_NgaySinh">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="GioiTinh" id="edit_GioiTinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="SDT" id="edit_SDT" required>
                                <div class="text-danger" id="edit-error-SDT"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="Email" id="edit_Email">
                                <div class="text-danger" id="edit-error-Email"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="DiaChi" id="edit_DiaChi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Chuyên môn</label>
                                <input type="text" class="form-control" name="ChuyenMon" id="edit_ChuyenMon">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kinh nghiệm (năm)</label>
                                <input type="number" class="form-control" name="KinhNghiem" id="edit_KinhNghiem" min="0"
                                    step="1">
                                <div class="text-danger" id="edit-error-KinhNghiem"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lương (VNĐ)</label>
                                <input type="number" class="form-control" name="Luong" id="edit_Luong" min="0" step="1000">
                                <div class="text-danger" id="edit-error-Luong"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPT(id) {
            window.location.href = `/gym/admin/pt/showPt/${id}`;
        }
        // Load danh sách PT khi trang load
        document.addEventListener('DOMContentLoaded', function() {
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
                    } else {
                        showError('Không thể tải danh sách HLV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi tải dữ liệu');
                });
        }

        // Định dạng ngày dạng d/m/Y cho hiển thị bảng
        function formatDateDMY(dateStr) {
            if (!dateStr) return '';

            // Ưu tiên tách phần ngày nếu chuỗi có cả thời gian
            const raw = dateStr.split(' ')[0];
            const parts = raw.split('-'); // kỳ vọng YYYY-MM-DD
            if (parts.length === 3) {
                const [y, m, d] = parts;
                return `${d.padStart(2, '0')}/${m.padStart(2, '0')}/${y}`;
            }

            // Fallback: thử với Date
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
                tbody.innerHTML = '<tr><td colspan="10" class="text-center text-muted">Không có HLV nào.</td></tr>';
                return;
            }

            tbody.innerHTML = pts.map(pt => `
            <tr>
                <td>${pt.HoTen || ''}</td>
                <td>${formatDateDMY(pt.NgaySinh)}</td>
                <td>${pt.GioiTinh || ''}</td>
                <td>${pt.SDT || ''}</td>
                <td>${pt.ChuyenMon || ''}</td>
                <td>${pt.DiaChi || ''}</td>

                <td class="text-center">
                    <button class="btn btn-sm btn-success me-1" onclick="showPT(${pt.pt_id})" title="Xem">
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
        `).join('');
        }

        // Format tiền tệ
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
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

            // Tìm kiếm
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const keyword = e.target.value;
                if (keyword.trim() === '') {
                    loadPTs();
                } else {
                    searchPT(keyword);
                }
            });
        }

        // Thêm PT
        function addPT() {
            const form = document.getElementById('addPTForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Clear errors
            document.querySelectorAll('#addPTForm .text-danger').forEach(el => el.textContent = '');

            fetch('/gym/api/pt', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Đóng modal và reload
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addPTModal'));
                        if (modal) modal.hide();
                        form.reset();
                        loadPTs();
                        showSuccess('Thêm HLV thành công!');
                    } else if (result.errors) {
                        // Hiển thị lỗi validation
                        Object.keys(result.errors).forEach(key => {
                            const errorEl = document.getElementById(`error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = result.errors[key];
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
            const data = Object.fromEntries(formData.entries());
            const ptId = data.pt_id;

            // Clear errors
            document.querySelectorAll('#editPTForm .text-danger').forEach(el => el.textContent = '');

            fetch(`/gym/api/pt/${ptId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Đóng modal và reload
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editPTModal'));
                        if (modal) modal.hide();
                        loadPTs();
                        showSuccess('Cập nhật HLV thành công!');
                    } else if (result.errors) {
                        // Hiển thị lỗi validation
                        Object.keys(result.errors).forEach(key => {
                            const errorEl = document.getElementById(`edit-error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = result.errors[key];
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
            if (!confirm('Bạn có chắc chắn muốn xóa HLV này?')) {
                return;
            }

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
                });
        }

        // Tìm kiếm PT
        function searchPT(keyword) {
            fetch(`/gym/api/pt/search?keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderPTTable(data.data);
                    } else {
                        showError('Không thể tìm kiếm HLV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi tìm kiếm');
                });
        }

        // Hiển thị thông báo thành công
        function showSuccess(message) {
            alert(message);
        }

        // Hiển thị thông báo lỗi
        function showError(message) {
            alert(message);
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lịch lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .container-fluid {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-admin {
            border-radius: 18px;
            border: none;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.12);
            background: #ffffff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        }

        .calendar-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .calendar-view-toggle .btn {
            border-radius: 999px;
        }

        .calendar-container {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            background: #ffffff;
        }

        .calendar-header-row {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            background: #f3f4f6;
            border-bottom: 1px solid #e5e7eb;
        }

        .calendar-header-cell {
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            color: #1f2937;
            border-left: 1px solid #e5e7eb;
        }

        .calendar-header-cell:first-child {
            border-left: none;
        }

        .calendar-grid-week {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            max-height: 650px;
            overflow-y: auto;
        }

        .calendar-time-cell {
            border-top: 1px solid #f3f4f6;
            padding: 0.5rem;
            font-size: 0.78rem;
            color: #6b7280;
            background: #f9fafb;
        }

        .calendar-day-cell {
            position: relative;
            border-top: 1px solid #f3f4f6;
            border-left: 1px solid #f3f4f6;
            padding: 2px;
            min-height: 60px;
            background: #ffffff;
        }

        .calendar-event {
            position: relative;
            background: #dbeafe;
            border-radius: 10px;
            padding: 4px 6px;
            margin-bottom: 4px;
            font-size: 0.75rem;
            cursor: pointer;
            border-left: 3px solid #1d4ed8;
            color: #1f2937;
        }

        .calendar-event-title {
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .calendar-event-time {
            font-size: 0.72rem;
            color: #374151;
        }

        .calendar-event-room {
            font-size: 0.7rem;
            color: #6b7280;
        }

        .calendar-grid-month {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #e5e7eb;
            border-left: 1px solid #e5e7eb;
        }

        .calendar-month-cell {
            min-height: 130px;
            padding: 6px;
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .calendar-month-cell-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
            font-size: 0.78rem;
            color: #6b7280;
        }

        .calendar-month-events {
            max-height: 110px;
            overflow-y: auto;
        }

        .calendar-empty-text {
            text-align: center;
            font-size: 0.85rem;
            color: #9ca3af;
            padding: 1rem 0.5rem;
        }

        @media (max-width: 992px) {
            .calendar-header-row {
                font-size: 0.8rem;
            }

            .calendar-grid-week {
                font-size: 0.78rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2 mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Quản lý lịch lớp học
                    </h1>
                    <div class="d-flex gap-2">
                        <a href="/gym/admin/cauhinhlichhoc" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-sliders-h me-1"></i> Cấu hình lịch lặp lại
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLichLopHocModal">
                            <i class="fas fa-plus me-2"></i>Thêm lịch học
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <form class="d-flex flex-wrap gap-2 align-items-center" method="POST" action="/gym/admin/lichlophoc/generateLichFromCauHinh">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Tạo lịch tự động:</label>
                            <select name="MaLop" class="form-select form-select-sm" style="min-width: 240px;" required>
                                <option value="">-- Chọn lớp để tạo lịch theo cấu hình --</option>
                                <?php if (!empty($lophocs)): ?>
                                    <?php foreach ($lophocs as $lop): ?>
                                        <option value="<?php echo (int)$lop->MaLop; ?>">
                                            <?php echo htmlspecialchars($lop->TenLop); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-magic me-1"></i> Tạo lịch
                        </button>
                    </form>
                </div>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($_SESSION['errors'] as $field => $message): ?>
                                <li><?php echo htmlspecialchars($message); ?></li>
                            <?php endforeach; unset($_SESSION['errors']); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php
                $lopMap = [];
                if (!empty($lophocs)) {
                    foreach ($lophocs as $lop) {
                        $lopMap[$lop->MaLop] = $lop->TenLop;
                    }
                }

                $days = [
                    1 => 'Thứ 2',
                    2 => 'Thứ 3',
                    3 => 'Thứ 4',
                    4 => 'Thứ 5',
                    5 => 'Thứ 6',
                    6 => 'Thứ 7',
                    7 => 'Chủ nhật'
                ];

                // Tính ngày nhỏ nhất và lớn nhất trong danh sách lịch để giới hạn điều hướng tuần
                $minDate = null;
                $maxDate = null;
                if (!empty($lichLopHocs)) {
                    foreach ($lichLopHocs as $item) {
                        if (empty($item['NgayHoc'])) {
                            continue;
                        }
                        $d = substr($item['NgayHoc'], 0, 10);
                        if ($minDate === null || $d < $minDate) {
                            $minDate = $d;
                        }
                        if ($maxDate === null || $d > $maxDate) {
                            $maxDate = $d;
                        }
                    }
                }
                ?>

                <div class="card card-admin">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold"><i class="fas fa-calendar-week me-2"></i>Thời khóa biểu lớp học</span>
                    </div>
                    <div class="card-body">
                        <div class="calendar-toolbar">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">Xem theo:</span>
                                    <div class="btn-group calendar-view-toggle" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-view-week">Tuần</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-month">Tháng</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-week-prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span class="fw-semibold small" id="week-range-label"></span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-week-next">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-muted small">
                                Thông tin trên mỗi lớp: Tên lớp, thời gian, phòng
                            </div>
                        </div>

                        <?php if (!empty($lichLopHocs)): ?>
                            <div class="calendar-container">
                                <div class="calendar-header-row">
                                    <div class="calendar-header-cell">Giờ</div>
                                    <?php foreach ($days as $dayName): ?>
                                        <div class="calendar-header-cell"><?php echo $dayName; ?></div>
                                    <?php endforeach; ?>
                                </div>

                                <div id="calendar-week" class="calendar-grid-week"></div>

                                <div id="calendar-month" class="d-none">
                                    <div class="calendar-grid-month">
                                        <?php foreach ($days as $dayNum => $dayName): ?>
                                            <div class="calendar-month-cell" data-day="<?php echo $dayNum; ?>">
                                                <div class="calendar-month-cell-header">
                                                    <span><?php echo $dayName; ?></span>
                                                </div>
                                                <div class="calendar-month-events"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="calendar-container">
                                <div class="calendar-empty-text">
                                    Chưa có lịch lớp học nào. Vui lòng thêm lịch mới hoặc sinh lịch từ cấu hình.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal thêm lịch lớp học -->
    <div class="modal fade" id="addLichLopHocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Thêm lịch học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lichlophoc/saveLichLopHoc" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Lớp học</label>
                            <select name="MaLop" id="add-MaLop" class="form-select" required>
                                <option value="">-- Chọn lớp học --</option>
                                <?php if (!empty($lophocs)): ?>
                                    <?php foreach ($lophocs as $lop): ?>
                                        <?php
                                        $ngayBatDau = !empty($lop->NgayBatDau) ? substr($lop->NgayBatDau, 0, 10) : '';
                                        $ngayKetThuc = !empty($lop->NgayKetThuc) ? substr($lop->NgayKetThuc, 0, 10) : '';
                                        ?>
                                        <option value="<?php echo (int)$lop->MaLop; ?>" data-ngay-bat-dau="<?php echo htmlspecialchars($ngayBatDau); ?>" data-ngay-ket-thuc="<?php echo htmlspecialchars($ngayKetThuc); ?>">
                                            <?php echo htmlspecialchars($lop->TenLop); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text" id="add-lop-date-range"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày học</label>
                            <input type="date" name="NgayHoc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ bắt đầu</label>
                            <input type="time" name="GioBatDau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ kết thúc</label>
                            <input type="time" name="GioKetThuc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phòng học</label>
                            <input type="text" name="PhongHoc" class="form-control" placeholder="VD: Phòng Yoga 1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal sửa lịch lớp học -->
    <div class="modal fade" id="editLichLopHocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật lịch lớp học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/gym/admin/lichlophoc/updateLichLopHoc" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label class="form-label">Lớp học</label>
                            <select name="MaLop" id="edit-MaLop" class="form-select" required>
                                <option value="">-- Chọn lớp học --</option>
                                <?php if (!empty($lophocs)): ?>
                                    <?php foreach ($lophocs as $lop): ?>
                                        <option value="<?php echo (int)$lop->MaLop; ?>">
                                            <?php echo htmlspecialchars($lop->TenLop); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày học</label>
                            <input type="date" name="NgayHoc" id="edit-NgayHoc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ bắt đầu</label>
                            <input type="time" name="GioBatDau" id="edit-GioBatDau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ kết thúc</label>
                            <input type="time" name="GioKetThuc" id="edit-GioKetThuc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phòng học</label>
                            <input type="text" name="PhongHoc" id="edit-PhongHoc" class="form-control">
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
        function openEditModal(id, maLop, ngayHoc, gioBatDau, gioKetThuc, phongHoc) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-MaLop').value = maLop;
            document.getElementById('edit-NgayHoc').value = ngayHoc;
            document.getElementById('edit-GioBatDau').value = gioBatDau;
            document.getElementById('edit-GioKetThuc').value = gioKetThuc;
            document.getElementById('edit-PhongHoc').value = phongHoc;

            var modal = new bootstrap.Modal(document.getElementById('editLichLopHocModal'));
            modal.show();
        }

        function deleteLichLopHoc(id) {
            if (confirm('Bạn có chắc chắn muốn xóa lịch lớp học này?')) {
                window.location.href = '/gym/admin/lichlophoc/deleteLichLopHoc/' + id;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var selectLop = document.getElementById('add-MaLop');
            var infoEl = document.getElementById('add-lop-date-range');
            if (selectLop && infoEl) {
                function updateDateRange() {
                    var selectedOption = selectLop.options[selectLop.selectedIndex];
                    if (!selectedOption) {
                        infoEl.textContent = '';
                        return;
                    }

                    var start = selectedOption.getAttribute('data-ngay-bat-dau') || '';
                    var end = selectedOption.getAttribute('data-ngay-ket-thuc') || '';

                    if (start && end) {
                        infoEl.textContent = 'Ngày bắt đầu: ' + start + ' | Ngày kết thúc: ' + end;
                    } else if (start || end) {
                        infoEl.textContent = start ? 'Ngày bắt đầu: ' + start : 'Ngày kết thúc: ' + end;
                    } else {
                        infoEl.textContent = '';
                    }
                }

                selectLop.addEventListener('change', updateDateRange);
                updateDateRange();
            }

            var lichData = <?php echo json_encode($lichLopHocs ?? []); ?>;
            var lopMapData = <?php echo json_encode($lopMap ?? []); ?>;
            var minDateStr = '<?php echo $minDate ?? ''; ?>';
            var maxDateStr = '<?php echo $maxDate ?? ''; ?>';

            var weekContainer = document.getElementById('calendar-week');
            var monthContainer = document.getElementById('calendar-month');
            var btnWeek = document.getElementById('btn-view-week');
            var btnMonth = document.getElementById('btn-view-month');
            var btnWeekPrev = document.getElementById('btn-week-prev');
            var btnWeekNext = document.getElementById('btn-week-next');
            var weekLabel = document.getElementById('week-range-label');

            if (!weekContainer || !monthContainer || !btnWeek || !btnMonth || !btnWeekPrev || !btnWeekNext || !weekLabel) {
                return;
            }

            function normalizeTime(t) {
                if (!t) return '';
                return t.substring(0, 5);
            }

            function getWeekdayFromDate(dateStr) {
                if (!dateStr) return null;
                var d = new Date(dateStr);
                if (isNaN(d.getTime())) return null;
                var jsDay = d.getDay();
                if (jsDay === 0) return 7;
                return jsDay;
            }

            function parseDate(str) {
                if (!str) return null;
                var d = new Date(str);
                if (isNaN(d.getTime())) return null;
                return d;
            }

            function startOfWeekMonday(d) {
                var date = new Date(d.getFullYear(), d.getMonth(), d.getDate());
                var day = date.getDay(); // 0..6 (Sun..Sat)
                var diff = (day === 0 ? -6 : 1 - day); // về thứ 2 gần nhất
                date.setDate(date.getDate() + diff);
                date.setHours(0, 0, 0, 0);
                return date;
            }

            function addDays(date, days) {
                var d = new Date(date.getTime());
                d.setDate(d.getDate() + days);
                return d;
            }

            function formatDateLabel(d) {
                var dd = d.getDate().toString().padStart(2, '0');
                var mm = (d.getMonth() + 1).toString().padStart(2, '0');
                var yyyy = d.getFullYear();
                return dd + '/' + mm + '/' + yyyy;
            }

            var today = new Date();
            var minDate = parseDate(minDateStr) || null;
            var maxDate = parseDate(maxDateStr) || null;

            var minWeekStart = minDate ? startOfWeekMonday(minDate) : null;
            var maxWeekStart = maxDate ? startOfWeekMonday(maxDate) : null;
            var currentWeekStart = startOfWeekMonday(today);

            // Clamp tuần hiện tại vào khoảng [minWeekStart, maxWeekStart]
            if (maxWeekStart && currentWeekStart > maxWeekStart) {
                currentWeekStart = new Date(maxWeekStart.getTime());
            }
            if (minWeekStart && currentWeekStart < minWeekStart) {
                currentWeekStart = new Date(minWeekStart.getTime());
            }

            function updateWeekLabel() {
                var weekEnd = addDays(currentWeekStart, 6);
                weekLabel.textContent =
                    'Tuần ' + formatDateLabel(currentWeekStart) + ' - ' + formatDateLabel(weekEnd);
            }

            function buildWeekGrid() {
                weekContainer.innerHTML = '';

                var startHour = 7;
                var endHour = 20;

                for (var h = startHour; h < endHour; h++) {
                    var timeLabel = (h < 10 ? '0' + h : h) + ':00';

                    var timeCell = document.createElement('div');
                    timeCell.className = 'calendar-time-cell';
                    timeCell.textContent = timeLabel;
                    weekContainer.appendChild(timeCell);

                    for (var day = 1; day <= 7; day++) {
                        var dayCell = document.createElement('div');
                        dayCell.className = 'calendar-day-cell';

                        var eventsInSlot = lichData.filter(function (item) {
                            var dayOfWeek = getWeekdayFromDate(item.NgayHoc || item['NgayHoc']);
                            var dateObj = parseDate(item.NgayHoc || item['NgayHoc']);
                            var start = normalizeTime(item.GioBatDau || item['GioBatDau']);
                            var end = normalizeTime(item.GioKetThuc || item['GioKetThuc']);

                            if (!start || !end || !dayOfWeek || !dateObj) return false;

                            // chỉ hiển thị các lịch thuộc tuần hiện tại
                            var weekEnd = addDays(currentWeekStart, 7);
                            if (dateObj < currentWeekStart || dateObj >= weekEnd) return false;

                            // chuyển sang số nguyên giờ để kiểm tra lớp kéo dài nhiều tiếng
                            var startHourInt = parseInt(start.split(':')[0], 10);
                            var endHourInt = parseInt(end.split(':')[0], 10);
                            if (isNaN(startHourInt) || isNaN(endHourInt)) return false;

                            // lớp xuất hiện ở tất cả các dòng giờ h mà startHourInt <= h < endHourInt
                            return dayOfWeek === day && h >= startHourInt && h < endHourInt;
                        });

                        eventsInSlot.forEach(function (item) {
                            var ev = document.createElement('div');
                            ev.className = 'calendar-event';

                            var maLop = item.MaLop || item['MaLop'];
                            var tenLop = lopMapData[maLop] || ('Lớp #' + maLop);
                            var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                            var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                            var phong = item.PhongHoc || item['PhongHoc'] || '';

                            ev.innerHTML = '' +
                                '<div class="calendar-event-title">' + tenLop + '</div>' +
                                '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                                (phong ? '<div class="calendar-event-room">Phòng: ' + phong + '</div>' : '');

                            ev.onclick = function () {
                                openEditModal(
                                    item.id,
                                    maLop,
                                    item.NgayHoc || item['NgayHoc'],
                                    gioBatDau,
                                    gioKetThuc,
                                    phong
                                );
                            };

                            dayCell.appendChild(ev);
                        });

                        weekContainer.appendChild(dayCell);
                    }
                }
            }

            function buildMonthGrid() {
                var monthCells = monthContainer.querySelectorAll('.calendar-month-cell');
                monthCells.forEach(function (cell) {
                    var eventsWrapper = cell.querySelector('.calendar-month-events');
                    if (eventsWrapper) {
                        eventsWrapper.innerHTML = '';
                    }
                });

                lichData.forEach(function (item) {
                    var dayOfWeek = getWeekdayFromDate(item.NgayHoc || item['NgayHoc']);
                    if (!dayOfWeek) return;

                    var cell = monthContainer.querySelector('.calendar-month-cell[data-day="' + dayOfWeek + '"]');
                    if (!cell) return;

                    var eventsWrapper = cell.querySelector('.calendar-month-events');
                    if (!eventsWrapper) return;

                    var ev = document.createElement('div');
                    ev.className = 'calendar-event';

                    var maLop = item.MaLop || item['MaLop'];
                    var tenLop = lopMapData[maLop] || ('Lớp #' + maLop);
                    var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                    var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                    var phong = item.PhongHoc || item['PhongHoc'] || '';

                    ev.innerHTML = '' +
                        '<div class="calendar-event-title">' + tenLop + '</div>' +
                        '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                        (phong ? '<div class="calendar-event-room">Phòng: ' + phong + '</div>' : '');

                    ev.onclick = function () {
                        openEditModal(
                            item.id,
                            maLop,
                            item.NgayHoc || item['NgayHoc'],
                            gioBatDau,
                            gioKetThuc,
                            phong
                        );
                    };

                    eventsWrapper.appendChild(ev);
                });
            }

            function setView(view) {
                if (view === 'week') {
                    weekContainer.classList.remove('d-none');
                    monthContainer.classList.add('d-none');
                    btnWeek.classList.add('btn-primary');
                    btnWeek.classList.remove('btn-outline-primary');
                    btnMonth.classList.remove('btn-primary');
                    btnMonth.classList.add('btn-outline-primary');
                } else {
                    weekContainer.classList.add('d-none');
                    monthContainer.classList.remove('d-none');
                    btnMonth.classList.add('btn-primary');
                    btnMonth.classList.remove('btn-outline-primary');
                    btnWeek.classList.remove('btn-primary');
                    btnWeek.classList.add('btn-outline-primary');
                }
            }

            buildWeekGrid();
            updateWeekLabel();
            buildMonthGrid();
            setView('week');

            btnWeek.addEventListener('click', function () {
                setView('week');
            });

            btnMonth.addEventListener('click', function () {
                setView('month');
            });

            btnWeekPrev.addEventListener('click', function () {
                var newStart = addDays(currentWeekStart, -7);
                if (minWeekStart && newStart < minWeekStart) {
                    return;
                }
                currentWeekStart = newStart;
                buildWeekGrid();
                updateWeekLabel();
            });

            btnWeekNext.addEventListener('click', function () {
                var newStart = addDays(currentWeekStart, 7);
                if (maxWeekStart && newStart > maxWeekStart) {
                    return;
                }
                currentWeekStart = newStart;
                buildWeekGrid();
                updateWeekLabel();
            });
        });
    </script>
</body>

</html>

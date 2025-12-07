<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch dạy của huấn luyện viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #0f172a, #111827);
            min-height: 100vh;
            color: #e2e8f0;
        }

        .pt-wrapper {
            margin-left: calc(5.5rem + 2rem);
            padding: 2rem 2rem;
            min-height: 100vh;
        }

        .card-calendar {
            background: #0f172a;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.6);
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
            border: 1px solid rgba(148, 163, 184, 0.35);
            overflow: hidden;
            background: #020617;
        }

        .calendar-header-row {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            background: #020617;
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }

        .calendar-date-row {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            background: #07102a;
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
        }

        .calendar-date-cell {
            padding: 6px 8px;
            text-align: center;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .calendar-header-cell {
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            color: #e5e7eb;
            border-left: 1px solid rgba(148, 163, 184, 0.35);
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
            border-top: 1px solid rgba(30, 64, 175, 0.4);
            padding: 0.5rem;
            font-size: 0.78rem;
            color: #9ca3af;
            background: #020617;
        }

        .calendar-day-cell {
            position: relative;
            border-top: 1px solid rgba(30, 64, 175, 0.4);
            border-left: 1px solid rgba(30, 64, 175, 0.4);
            padding: 2px;
            min-height: 60px;
            background: #020617;
        }

        .calendar-event {
            position: relative;
            background: rgba(59, 130, 246, 0.18);
            border-radius: 10px;
            padding: 4px 6px;
            margin-bottom: 4px;
            font-size: 0.75rem;
            cursor: default;
            border-left: 3px solid #3b82f6;
            color: #e5e7eb;
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
            color: #bfdbfe;
        }

        .calendar-event-room {
            font-size: 0.7rem;
            color: #9ca3af;
        }

        .calendar-grid-month {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid rgba(148, 163, 184, 0.35);
            border-left: 1px solid rgba(148, 163, 184, 0.35);
        }

        .calendar-month-cell {
            min-height: 130px;
            padding: 6px;
            border-right: 1px solid rgba(148, 163, 184, 0.35);
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
            background: #020617;
        }

        .calendar-month-cell-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
            font-size: 0.78rem;
            color: #9ca3af;
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

        @media (max-width: 991px) {
            .pt-wrapper {
                margin-left: 0;
                padding: 8rem 1rem 2rem;
            }

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
<div class="pt-wrapper">
    <div class="container-fluid">
        <div class="card card-calendar">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-calendar-days me-2 text-info"></i>Lịch dạy của tôi</h2>
                        <p class="mb-0 text-secondary">Xem thời khóa biểu các lớp bạn đang đứng lớp theo tuần hoặc tháng</p>
                    </div>
                    <a href="/gym/pt/lophoc" class="btn btn-outline-light btn-sm rounded-pill">
                        <i class="fa-solid fa-list me-1"></i>Lớp học
                    </a>
                </div>

                <?php
                $days = [
                    1 => 'Thứ 2',
                    2 => 'Thứ 3',
                    3 => 'Thứ 4',
                    4 => 'Thứ 5',
                    5 => 'Thứ 6',
                    6 => 'Thứ 7',
                    7 => 'Chủ nhật'
                ];

                $minDate = null;
                $maxDate = null;
                if (!empty($lichDay)) {
                    foreach ($lichDay as $item) {
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

                <div class="calendar-toolbar">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary small">Xem theo:</span>
                            <div class="btn-group calendar-view-toggle" role="group">
                                <button type="button" class="btn btn-sm btn-primary" id="btn-view-week">Tuần</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-month">Tháng</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-light" id="btn-week-prev">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="fw-semibold small text-secondary" id="week-range-label"></span>
                            <button type="button" class="btn btn-sm btn-outline-light" id="btn-week-next">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-secondary small">
                        Mỗi ô hiển thị: Tên lớp, thời gian, phòng
                    </div>
                </div>

                <?php if (!empty($lichDay)): ?>
                    <div class="calendar-container">
                        <div class="calendar-header-row">
                            <div class="calendar-header-cell">Giờ</div>
                            <?php foreach ($days as $dayName): ?>
                                <div class="calendar-header-cell"><?php echo $dayName; ?></div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Row hiển thị ngày tương ứng với tuần đang xem -->
                        <div id="calendar-date-row" class="calendar-date-row">
                            <div class="calendar-date-cell"></div>
                            <?php for ($i = 0; $i < 7; $i++): ?>
                                <div class="calendar-date-cell" data-day-index="<?php echo $i; ?>"></div>
                            <?php endfor; ?>
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
                            Bạn chưa có lịch dạy nào được sắp xếp.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lichData = <?php echo json_encode($lichDay ?? []); ?>;
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
            var day = date.getDay();
            var diff = (day === 0 ? -6 : 1 - day);
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

        function updateDateRow() {
            var row = document.getElementById('calendar-date-row');
            if (!row) return;
            var cells = row.querySelectorAll('.calendar-date-cell');
            // cells[0] is the time column placeholder
            for (var i = 0; i < 7; i++) {
                var cell = cells[i + 1];
                if (!cell) continue;
                var d = addDays(currentWeekStart, i);
                cell.textContent = formatDateLabel(d);
            }
        }

        var today = new Date();
        var minDate = parseDate(minDateStr) || null;
        var maxDate = parseDate(maxDateStr) || null;

        var minWeekStart = minDate ? startOfWeekMonday(minDate) : null;
        var maxWeekStart = maxDate ? startOfWeekMonday(maxDate) : null;
        var currentWeekStart = startOfWeekMonday(today);

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

                        var weekEnd = addDays(currentWeekStart, 7);
                        if (dateObj < currentWeekStart || dateObj >= weekEnd) return false;

                        var startHourInt = parseInt(start.split(':')[0], 10);
                        var endHourInt = parseInt(end.split(':')[0], 10);
                        if (isNaN(startHourInt) || isNaN(endHourInt)) return false;

                        return dayOfWeek === day && h >= startHourInt && h < endHourInt;
                    });

                    eventsInSlot.forEach(function (item) {
                        var ev = document.createElement('div');
                        ev.className = 'calendar-event';

                        var maLop = item.MaLop || item['MaLop'];
                        var tenLop = lopMapData[maLop] || item.TenLop || item['TenLop'] || ('Lớp #' + maLop);
                        var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                        var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                        var phong = item.PhongHoc || item['PhongHoc'] || '';

                        ev.innerHTML = '' +
                            '<div class="calendar-event-title">' + tenLop + '</div>' +
                            '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                            (phong ? '<div class="calendar-event-room">Phòng: ' + phong + '</div>' : '');

                        dayCell.appendChild(ev);
                    });

                    weekContainer.appendChild(dayCell);
                }
            }

            // populate the date row for the current week
            updateDateRow();
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
                var tenLop = lopMapData[maLop] || item.TenLop || item['TenLop'] || ('Lớp #' + maLop);
                var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                var phong = item.PhongHoc || item['PhongHoc'] || '';

                ev.innerHTML = '' +
                    '<div class="calendar-event-title">' + tenLop + '</div>' +
                    '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                    (phong ? '<div class="calendar-event-room">Phòng: ' + phong + '</div>' : '');

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

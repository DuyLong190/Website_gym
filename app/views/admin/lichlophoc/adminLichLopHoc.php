<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lịch lớp học - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            margin-bottom: 2rem;
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

        .card-header .fw-semibold {
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

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 2px solid #6b7280;
            color: #6b7280;
            background: transparent;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #6b7280;
            color: white;
            transform: translateY(-2px);
        }

        .card-body {
            padding: 1rem;
        }

        .calendar-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .calendar-view-toggle .btn {
            border-radius: 999px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .calendar-view-toggle .btn-primary {
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
        }

        .calendar-view-toggle .btn:hover {
            transform: translateY(-2px);
        }

        .calendar-container {
            border-radius: 20px;
            border: 2px solid #e2e8f0;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }

        .calendar-container:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .calendar-header-row {
            display: grid;
            grid-template-columns: 100px repeat(7, 1fr);
            background: #4F46E5;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);
        }

        .calendar-header-cell {
            padding: 1rem 0.75rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.95rem;
            color: #ffffff;
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .calendar-header-cell:first-child {
            border-left: none;
            background: rgba(255, 255, 255, 0.1);
        }

        .calendar-header-cell:not(:first-child)::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
        }

        .calendar-grid-week {
            display: grid;
            grid-template-columns: 100px repeat(7, 1fr);
            max-height: 700px;
            overflow-y: auto;
            background: #ffffff;
            position: relative;
        }

        .calendar-events-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 10;
            display: grid;
            grid-template-columns: 100px repeat(7, 1fr);
            grid-template-rows: repeat(var(--total-rows, 13), 70px);
        }

        .calendar-events-overlay .calendar-event {
            pointer-events: all;
            position: relative;
        }

        .calendar-grid-week::-webkit-scrollbar {
            width: 8px;
        }

        .calendar-grid-week::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .calendar-grid-week::-webkit-scrollbar-thumb {
            background: #6366F1;
            border-radius: 4px;
        }

        .calendar-grid-week::-webkit-scrollbar-thumb:hover {
            background: #4F46E5;
        }

        .calendar-time-cell {
            border-top: 1px solid #e2e8f0;
            border-right: 2px solid #cbd5e1;
            padding: 0.75rem 0.5rem;
            font-size: 0.85rem;
            color: #475569;
            background: #f1f5f9;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            left: 0;
            z-index: 10;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.04);
        }

        .calendar-day-cell {
            position: relative;
            border-top: 1px solid #e2e8f0;
            border-left: 1px solid #e2e8f0;
            padding: 4px;
            min-height: 70px;
            background: #ffffff;
            transition: background-color 0.2s ease;
        }

        .calendar-day-cell:hover {
            background: #f8fafc;
        }

        .calendar-day-cell:nth-child(8n+1) {
            border-left: none;
        }

        .calendar-day-cell.has-event {
            padding: 0;
            overflow: visible;
        }

        .calendar-event {
            position: relative;
            background: #6366F1;
            border-radius: 12px;
            padding: 8px 10px;
            font-size: 0.8rem;
            cursor: pointer;
            color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
            border: none;
            overflow: hidden;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 60px;
        }

        .calendar-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px 0 0 12px;
        }

        .calendar-event:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            z-index: 5;
        }

        .calendar-event.event-color-1 {
            background: #6366F1;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
        }

        .calendar-event.event-color-1:hover {
            background: #4F46E5;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .calendar-event.event-color-2 {
            background: #EC4899;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.25);
        }

        .calendar-event.event-color-2:hover {
            background: #DB2777;
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
        }

        .calendar-event.event-color-3 {
            background: #3B82F6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
        }

        .calendar-event.event-color-3:hover {
            background: #2563EB;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .calendar-event.event-color-4 {
            background: #10B981;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }

        .calendar-event.event-color-4:hover {
            background: #059669;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .calendar-event.event-color-5 {
            background: #F59E0B;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
        }

        .calendar-event.event-color-5:hover {
            background: #D97706;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }

        .calendar-event.event-color-6 {
            background: #8B5CF6;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.25);
        }

        .calendar-event.event-color-6:hover {
            background: #7C3AED;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .calendar-event.event-color-7 {
            background: #06B6D4;
            box-shadow: 0 2px 8px rgba(6, 182, 212, 0.25);
        }

        .calendar-event.event-color-7:hover {
            background: #0891B2;
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        }

        .calendar-event-title {
            font-weight: 700;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .calendar-event-time {
            font-size: 0.75rem;
            opacity: 0.95;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .calendar-event-room {
            font-size: 0.7rem;
            opacity: 0.85;
            font-weight: 500;
        }

        .calendar-grid-month {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #e2e8f0;
            border-left: 1px solid #e2e8f0;
        }

        .calendar-month-cell {
            min-height: 150px;
            padding: 8px;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
            transition: background-color 0.2s ease;
        }

        .calendar-month-cell:hover {
            background: #f8fafc;
        }

        .calendar-month-cell-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #374151;
            padding: 4px 8px;
            background: #f1f5f9;
            border-radius: 8px;
        }

        .calendar-month-events {
            max-height: 120px;
            overflow-y: auto;
        }

        .calendar-month-events::-webkit-scrollbar {
            width: 6px;
        }

        .calendar-month-events::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .calendar-month-events::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 3px;
        }

        .calendar-empty-text {
            text-align: center;
            font-size: 1rem;
            color: #6b7280;
            padding: 3rem 1rem;
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        }

        .calendar-empty-text::before {
            content: '📅';
            display: block;
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }

        /* Modal Styling */
        .modal {
            backdrop-filter: blur(5px);
        }

        .modal-dialog {
            margin: 2rem auto;
            max-width: 600px;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .modal-title i {
            font-size: 1.75rem;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 1;
            padding: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 1.5rem;
            background: #fafafa;
        }

        .modal-body .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .modal-body .form-control,
        .modal-body .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: white;
        }

        .modal-body .form-control:focus,
        .modal-body .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 2px solid #f3f4f6;
            background: white;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .modal-footer .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-secondary {
            background: #6b7280;
            border: none;
            color: white;
        }

        .modal-footer .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .modal-footer .btn-primary {
            background: var(--success-color);
            border: none;
            color: white;
        }

        .modal-footer .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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

            .calendar-header-row {
                font-size: 0.8rem;
            }

            .calendar-grid-week {
                font-size: 0.78rem;
            }

            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/../../admin/sidebarAdmin.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1>
                <div class="icon-wrapper">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="title-text">
                    <span class="title-main">Quản lý lịch lớp học</span>
                </div>
            </h1>
        </div>

        <div class="admin-card">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
                    <form class="d-flex flex-wrap gap-2 align-items-center" method="POST" action="/gym/admin/lichlophoc/generateLichFromCauHinh">
                        <div class="d-flex align-items-center gap-2">
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
                            <i class="fas fa-magic me-1"></i> Tạo
                        </button>
                    </form>
                    <div class="d-flex gap-2">
                        <a href="/gym/admin/cauhinhlichhoc" class="btn btn-outline-secondary">
                            <i class="fas fa-sliders-h me-1"></i> Cấu hình lịch
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLichLopHocModal">
                            <i class="fas fa-plus me-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach ($_SESSION['errors'] as $field => $message): ?>
                        <li><?php echo htmlspecialchars($message); ?></li>
                    <?php endforeach;
                    unset($_SESSION['errors']); ?>
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

        <div class="admin-card">
            <div class="card-header">
                <div class="fw-semibold">
                    <i class="fas fa-calendar-week"></i>
                    Thời khóa biểu lớp học
                </div>
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
    </div>

    <!-- Modal thêm lịch lớp học -->
    <div class="modal fade" id="addLichLopHocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Thêm lịch học</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

        document.addEventListener('DOMContentLoaded', function() {
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

            function getEventColorClass(maLop) {
                var colorIndex = (maLop % 7) + 1;
                return 'event-color-' + colorIndex;
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
                var cellHeight = 70; // Chiều cao mỗi cell (px)
                var totalRows = endHour - startHour;

                // Tạo map để track các event đã được render (tránh duplicate)
                var renderedEvents = {};

                // Tạo tất cả các cells
                for (var h = startHour; h < endHour; h++) {
                    var timeLabel = (h < 10 ? '0' + h : h) + ':00';

                    var timeCell = document.createElement('div');
                    timeCell.className = 'calendar-time-cell';
                    timeCell.textContent = timeLabel;
                    weekContainer.appendChild(timeCell);

                    for (var day = 1; day <= 7; day++) {
                        var dayCell = document.createElement('div');
                        dayCell.className = 'calendar-day-cell';
                        dayCell.setAttribute('data-hour', h);
                        dayCell.setAttribute('data-day', day);
                        weekContainer.appendChild(dayCell);
                    }
                }

                // Tạo overlay container cho events
                var eventsOverlay = document.createElement('div');
                eventsOverlay.className = 'calendar-events-overlay';
                eventsOverlay.style.setProperty('--total-rows', totalRows);
                weekContainer.appendChild(eventsOverlay);

                // Render các events - chỉ ở giờ bắt đầu
                lichData.forEach(function(item) {
                    var dayOfWeek = getWeekdayFromDate(item.NgayHoc || item['NgayHoc']);
                    var dateObj = parseDate(item.NgayHoc || item['NgayHoc']);
                    var start = normalizeTime(item.GioBatDau || item['GioBatDau']);
                    var end = normalizeTime(item.GioKetThuc || item['GioKetThuc']);

                    if (!start || !end || !dayOfWeek || !dateObj) return;

                    // chỉ hiển thị các lịch thuộc tuần hiện tại
                    var weekEnd = addDays(currentWeekStart, 7);
                    if (dateObj < currentWeekStart || dateObj >= weekEnd) return;

                    // chuyển sang số nguyên giờ
                    var startHourInt = parseInt(start.split(':')[0], 10);
                    var startMinuteInt = parseInt(start.split(':')[1], 10) || 0;
                    var endHourInt = parseInt(end.split(':')[0], 10);
                    var endMinuteInt = parseInt(end.split(':')[1], 10) || 0;

                    if (isNaN(startHourInt) || isNaN(endHourInt)) return;

                    // Tính số giờ kéo dài (có thể là số thập phân)
                    var durationHours = (endHourInt + endMinuteInt / 60) - (startHourInt + startMinuteInt / 60);
                    if (durationHours <= 0) return;

                    // Tạo key để check duplicate
                    var eventKey = item.id + '_' + dayOfWeek;
                    if (renderedEvents[eventKey]) return;
                    renderedEvents[eventKey] = true;

                    // Tính vị trí trong grid
                    var rowStart = startHourInt - startHour + 1;
                    var rowSpan = Math.ceil(durationHours);
                    var colStart = dayOfWeek + 1; // +1 vì có cột giờ

                    // Tạo event
                    var ev = document.createElement('div');
                    var maLop = item.MaLop || item['MaLop'];
                    ev.className = 'calendar-event ' + getEventColorClass(maLop);

                    var tenLop = lopMapData[maLop] || ('Lớp #' + maLop);
                    var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                    var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                    var phong = item.PhongHoc || item['PhongHoc'] || '';

                    // Set grid position để event kéo dài qua nhiều hàng
                    ev.style.gridColumn = colStart;
                    ev.style.gridRow = rowStart + ' / span ' + rowSpan;
                    ev.style.margin = '4px';

                    ev.innerHTML = '' +
                        '<div class="calendar-event-title">' + tenLop + '</div>' +
                        '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                        (phong ? '<div class="calendar-event-room">📍 ' + phong + '</div>' : '');

                    ev.onclick = function() {
                        openEditModal(
                            item.id,
                            maLop,
                            item.NgayHoc || item['NgayHoc'],
                            gioBatDau,
                            gioKetThuc,
                            phong
                        );
                    };

                    eventsOverlay.appendChild(ev);
                });
            }

            function buildMonthGrid() {
                var monthCells = monthContainer.querySelectorAll('.calendar-month-cell');
                monthCells.forEach(function(cell) {
                    var eventsWrapper = cell.querySelector('.calendar-month-events');
                    if (eventsWrapper) {
                        eventsWrapper.innerHTML = '';
                    }
                });

                lichData.forEach(function(item) {
                    var dayOfWeek = getWeekdayFromDate(item.NgayHoc || item['NgayHoc']);
                    if (!dayOfWeek) return;

                    var cell = monthContainer.querySelector('.calendar-month-cell[data-day="' + dayOfWeek + '"]');
                    if (!cell) return;

                    var eventsWrapper = cell.querySelector('.calendar-month-events');
                    if (!eventsWrapper) return;

                    var ev = document.createElement('div');
                    var maLop = item.MaLop || item['MaLop'];
                    ev.className = 'calendar-event ' + getEventColorClass(maLop);

                    var tenLop = lopMapData[maLop] || ('Lớp #' + maLop);
                    var gioBatDau = normalizeTime(item.GioBatDau || item['GioBatDau']);
                    var gioKetThuc = normalizeTime(item.GioKetThuc || item['GioKetThuc']);
                    var phong = item.PhongHoc || item['PhongHoc'] || '';

                    ev.innerHTML = '' +
                        '<div class="calendar-event-title">' + tenLop + '</div>' +
                        '<div class="calendar-event-time">' + gioBatDau + ' - ' + gioKetThuc + '</div>' +
                        (phong ? '<div class="calendar-event-room">📍 ' + phong + '</div>' : '');

                    ev.onclick = function() {
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

            btnWeek.addEventListener('click', function() {
                setView('week');
            });

            btnMonth.addEventListener('click', function() {
                setView('month');
            });

            btnWeekPrev.addEventListener('click', function() {
                var newStart = addDays(currentWeekStart, -7);
                if (minWeekStart && newStart < minWeekStart) {
                    return;
                }
                currentWeekStart = newStart;
                buildWeekGrid();
                updateWeekLabel();
            });

            btnWeekNext.addEventListener('click', function() {
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
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --success-color: #10b981;
            --info-color: #3b82f6;
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
            padding: 1rem;
        }

        .main-content {
            animation: fadeInUp 0.6s ease-out;
            max-width: 1100px;
            margin: 0 auto;
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

        .user-detail-card {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .user-detail-header {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.25rem;
            border: none;
        }

        .user-detail-header h4 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.3rem;
        }

        .user-detail-header h4 i {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .info-section {
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.375rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-title i {
            font-size: 1.3rem;
        }

        .info-item {
            padding: 0.75rem;
            background: #fafafa;
            border-radius: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
            min-width: 150px;
        }

        .info-label i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
            min-width: 150px;
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .info-value {
            color: #1f2937;
            font-size: 1.15rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-align: right;
            flex: 1;
            justify-content: flex-end;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .action-buttons {
            border-top: 2px solid #f3f4f6;
        }

        .empty-value {
            color: #9ca3af;
            font-style: italic;
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

            .card-body {
                padding: 1rem;
            }

            .info-item {
                padding: 0.75rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 0.5rem;
            }

            .info-value {
                text-align: left;
                justify-content: flex-start;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <?php if (isset($goiTap) && is_object($goiTap)): ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Chi tiết gói tập</span>
                    </div>
                </h1>
            </div>
            <div class="card user-detail-card">
                <div class="user-detail-header">
                    <h4>
                        <i class="fas fa-ticket-alt"></i>
                        Thông tin gói tập
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin cơ bản -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-tag"></i>
                                        Tên gói tập
                                    </div>
                                    <div class="info-value">
                                        <?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Giá
                                    </div>
                                    <div class="info-value">
                                        <?php echo number_format($goiTap->GiaTien, 0, ',', '.'); ?> VNĐ
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Thời hạn
                                    </div>
                                    <div class="info-value">
                                        <?php echo htmlspecialchars($goiTap->ThoiHan, ENT_QUOTES, 'UTF-8'); ?> tháng
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <?php if (!empty($goiTap->MoTa)): ?>
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-align-left"></i>
                                Mô tả
                            </div>
                            <div class="info-item">
                                <div class="info-value" style="text-align: left; justify-content: flex-start; width: 100%;">
                                    <?php echo nl2br(htmlspecialchars($goiTap->MoTa, ENT_QUOTES, 'UTF-8')); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <a href="/gym/admin/goitap" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="page-header">
                <h1>
                    <div class="icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="title-text">
                        <span class="title-main">Không tìm thấy gói tập</span>
                    </div>
                </h1>
            </div>
            <div class="card user-detail-card">
                <div class="card-body">
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <p>Vui lòng quay lại danh sách để chọn gói tập khác.</p>
                        <a href="/gym/admin/goitap" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5, #2563eb);
            --surface: #ffffff;
            --surface-muted: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --accent: #22c55e;
            --warning: #f97316;
        }

        body {
            margin-left: 240px;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at top right, #eef2ff, #e0e7ff 42%, #fff);
            min-height: 100vh;
            color: var(--text-primary);
        }

        .page-wrapper {
            padding: 2.5rem 3rem 3rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            color: var(--text-primary);
            padding: 0.65rem 1.1rem;
            border-radius: 999px;
            background: var(--surface);
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.1);
        }

        .detail-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .hero-card {
            border-radius: 24px;
            padding: 2rem;
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25);
        }

        .hero-card h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .hero-card .price {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            margin-top: 0.8rem;
        }

        .status-pill.status-open {
            background: rgba(34, 197, 94, 0.18);
            color: #16a34a;
        }

        .status-pill.status-paused {
            background: rgba(250, 204, 21, 0.25);
            color: #854d0e;
        }

        .status-pill.status-ended {
            background: rgba(239, 68, 68, 0.22);
            color: #b91c1c;
        }

        .status-pill.status-unknown {
            background: rgba(15, 23, 42, 0.18);
            color: #0f172a;
        }

        .metrics-card,
        .description-card {
            border-radius: 24px;
            background: var(--surface);
            padding: 1.75rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .metric {
            padding: 1rem;
            border-radius: 16px;
            background: var(--surface-muted);
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .metric span {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .metric strong {
            font-size: 1.25rem;
        }

        .progress-track {
            height: 10px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: inherit;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .description-card h3 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            color: var(--text-secondary);
            letter-spacing: 0.08em;
        }

        .description-card p {
            line-height: 1.8;
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .detail-rows {
            margin-top: 1rem;
            display: grid;
            gap: 1rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .detail-row .label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .detail-row .value {
            font-weight: 600;
        }

        .empty-state {
            margin-top: 3rem;
            padding: 2rem;
            text-align: center;
            border-radius: 20px;
            background: var(--surface);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
            color: var(--text-secondary);
        }

        @media (max-width: 960px) {
            body {
                margin-left: 0;
            }

            .page-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <?php
            $soDangKy = isset($lophoc->SoDangKy) ? (int)$lophoc->SoDangKy : 0;
            $max = isset($lophoc->SoLuongToiDa) ? (int)$lophoc->SoLuongToiDa : 0;
            $remaining = ($max > 0) ? max($max - $soDangKy, 0) : null;
            $fillPercent = ($max > 0) ? min(100, (int)round(($soDangKy / $max) * 100)) : 0;
            $startDate = $lophoc->NgayBatDau ? new DateTimeImmutable($lophoc->NgayBatDau) : null;
            $endDate = $lophoc->NgayKetThuc ? new DateTimeImmutable($lophoc->NgayKetThuc) : null;
            $statusText = $lophoc->TrangThai ?? 'Chưa xác định';
            $statusClassMap = [
                'Đang mở' => 'status-open',
                'Đã kết thúc' => 'status-ended',
                'Tạm ngưng' => 'status-paused',
            ];
            $statusClass = $statusClassMap[$statusText] ?? 'status-unknown';
            $tenPT = !empty($lophoc->TenPT) ? $lophoc->TenPT : 'Chưa có PT';
            $description = nl2br(htmlspecialchars($lophoc->MoTa ?? '', ENT_QUOTES, 'UTF-8'));
            ?>
            <div class="section-header">
                <div>
                    <h1>
                        <i class="fa-solid fa-dumbbell me-2" aria-hidden="true"></i>
                        Chi tiết lớp học
                    </h1>
                    <p class="text-muted mt-1">Thông tin cập nhật dựa trên dữ liệu lớp học hiện tại.</p>
                </div>
                <a href="/gym/admin/lophoc" class="back-link">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <div class="detail-panel">
                <article class="hero-card">
                    <h2><?php echo htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="price">
                        <?php echo number_format($lophoc->GiaTien, 0, ',', '.'); ?> VNĐ
                    </div>
                    <div class="status-pill" style="border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fas fa-circle me-2" style="font-size:0.5rem;"></i>
                        <?php echo htmlspecialchars($statusText, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div class="detail-rows">
                        <div class="detail-row">
                            <span class="label">Huấn luyện viên</span>
                            <span class="value"><?php echo htmlspecialchars($tenPT, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Ngày bắt đầu</span>
                            <span class="value"><?php echo $startDate ? $startDate->format('d/m/Y') : '-'; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Ngày kết thúc</span>
                            <span class="value"><?php echo $endDate ? $endDate->format('d/m/Y') : '-'; ?></span>
                        </div>
                    </div>
                </article>

                <section class="metrics-card">
                    <div class="metrics-grid">
                        <div class="metric">
                            <span>Đã đăng ký</span>
                            <strong><?php echo htmlspecialchars((string)$soDangKy, ENT_QUOTES, 'UTF-8'); ?></strong>
                        </div>
                        <div class="metric">
                            <span>Còn trống</span>
                            <strong><?php echo $remaining === null ? '-' : htmlspecialchars((string)$remaining, ENT_QUOTES, 'UTF-8'); ?></strong>
                        </div>
                        <div class="metric">
                            <span>Sĩ số tối đa</span>
                            <strong><?php echo $max ? htmlspecialchars((string)$max, ENT_QUOTES, 'UTF-8') : '-'; ?></strong>
                        </div>
                        <div class="metric">
                            <span>Độ đầy</span>
                            <strong><?php echo $max ? $fillPercent . '%' : '0%'; ?></strong>
                        </div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $fillPercent; ?>%;"></div>
                    </div>
                </section>

                <article class="description-card">
                    <h3>Mô tả lớp học</h3>
                    <p><?php echo $description ?: 'Chưa có mô tả.'; ?></p>
                </article>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>Không tìm thấy lớp học</h2>
                <p>Vui lòng quay lại danh sách để chọn lớp học khác.</p>
                <a href="/gym/admin/lophoc" class="back-link" style="justify-content:center;">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
<?php include_once __DIR__ . '/../share/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg,#0f172a 0%, #0b4a6f 100%);
            color: #fff;
            padding: 40px 20px;
            border-radius: 12px;
            margin-bottom: 28px;
            text-align: center;
        }
        .detail-card {
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(15,23,42,0.06);
            overflow: hidden;
        }
        .pkg-image {
            background: linear-gradient(180deg,#e6eef7,#ffffff);
            min-height: 260px;
            display:flex;align-items:center;justify-content:center;
            color:#64748b;font-size:48px;font-weight:700;
        }
        .price-badge {
            font-size: 1.1rem;
            background: linear-gradient(90deg, #ffb700 0%, #ff9f00 100%);
            color: #111;
            font-weight: 700;
            border-radius: 8px;
            padding: 0.45em 0.9em;
            display: inline-block;
        }
        .meta-label { color:#6b7280; font-weight:600; }
        .action-row .btn { min-width:120px; }
        @media (max-width:767px){ .pkg-image{min-height:180px} }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="hero">
            <h1 class="mb-1">Chi tiết lớp học</h1>
            <div class="small opacity-75">Thông tin đầy đủ về lớp học và cách đăng ký</div>
        </div>

        <?php if (isset($lophoc) && is_object($lophoc)): ?>
            <div class="card detail-card">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="pkg-image">
                            <!-- placeholder image or icon -->
                            <div>
                                <i class="fas fa-chalkboard-user fa-3x"></i>
                                <div class="mt-2 fw-bold"><?= htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="mb-1"><?= htmlspecialchars($lophoc->TenLop, ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <div class="small text-muted">Huấn luyện viên: <?= htmlspecialchars($lophoc->TenPT ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="text-end">
                                    <div class="price-badge"><?= number_format($lophoc->GiaTien); ?> VNĐ</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="meta-label">Ngày bắt đầu</div>
                                    <div class="fw-medium"><?= htmlspecialchars($lophoc->NgayBatDau, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="col-6">
                                    <div class="meta-label">Ngày kết thúc</div>
                                    <div class="fw-medium"><?= htmlspecialchars($lophoc->NgayKetThuc, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="meta-label">Mô tả</div>
                                <div class="text-muted"><?= nl2br(htmlspecialchars($lophoc->MoTa ?? '-', ENT_QUOTES, 'UTF-8')); ?></div>
                            </div>

                            <div class="mb-3">
                                <div class="meta-label">Sỹ số tối đa</div>
                                <div class="fw-medium"><?= htmlspecialchars($lophoc->SoLuongToiDa ?? '-', ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>

                            <div class="d-flex gap-2 action-row mt-4">
                                <a href="/gym/lophoc" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
                                <button class="btn btn-primary" onclick="registerClass(<?= htmlspecialchars($lophoc->MaLop, ENT_QUOTES, 'UTF-8');?>)"><i class="fas fa-pen-to-square me-1"></i>Đăng ký</button>
                                <a href="#" class="btn btn-outline-primary"><i class="fas fa-info-circle me-1"></i>Chi tiết thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không tìm thấy thông tin lớp học.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function registerClass(maLop) {
            try {
                const response = await fetch('/gym/api/dangkylophoc', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ MaLop: maLop })
                });
                let result = {};
                try { result = await response.json(); } catch(e) { result = {}; }
                if (response.status === 401) {
                    alert(result.message || 'Vui lòng đăng nhập để đăng ký lớp học');
                    window.location.href = '/gym/account/login';
                    return;
                }
                if (response.ok && result.success) {
                    alert(result.message || 'Đăng ký thành công');
                    window.location.href = '/gym/user/lichlophoc?MaLop=' + encodeURIComponent(maLop);
                    return;
                }
                if (result.errors) {
                    if (result.errors.exists) { alert(result.errors.exists); return; }
                    if (result.errors.full) { alert(result.errors.full); return; }
                }
                alert(result.message || 'Đăng ký lớp học thất bại');
            } catch (e) {
                alert('Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    </script>
</body>

</html>
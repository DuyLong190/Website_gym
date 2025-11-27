<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lớp học của huấn luyện viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #0f172a, #111827);
            min-height: 100vh;
            color: #e2e8f0;
        }
        .pt-wrapper {
            margin-left: 18%;
            padding: 40px 30px;
        }
        .card-classes {
            background: #0f172a;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.6);
            padding: 24px;
        }
        .class-item {
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.35);
            padding: 16px 18px;
            margin-bottom: 14px;
        }
        .badge-status {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }
        .badge-active {
            background-color: #22c55e;
            color: #022c22;
        }
        .badge-inactive {
            background-color: #4b5563;
            color: #e5e7eb;
        }
        @media (max-width: 991px) {
            .pt-wrapper {
                margin-left: 0;
                padding: 120px 16px 40px;
            }
        }
    </style>
</head>
<body>
<div class="pt-wrapper">
    <div class="container-fluid">
        <div class="card-classes">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 mb-1 text-white"><i class="fa-solid fa-calendar-days me-2 text-warning"></i>Lớp học</h2>
                    <p class="mb-0 text-secondary">Đăng ký hoặc hủy đăng ký các lớp mà bạn muốn đứng lớp</p>
                </div>
                <a href="/gym/pt" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="fa-solid fa-user-tie me-1"></i>Hồ sơ
                </a>
            </div>

            <?php if (!empty($lophocs)): ?>
                <?php foreach ($lophocs as $lop): ?>
                    <?php
                    $maLop = (int)($lop->MaLop ?? 0);
                    $current = isset($dangKyMap[$maLop]) ? $dangKyMap[$maLop] : null;
                    $isRegistered = $current && (($current['TrangThai'] ?? '') === 'Đăng ký');
                    $dkId = $current ? (int)($current['id'] ?? 0) : 0;
                    ?>
                    <div class="class-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-semibold text-white mb-1">
                                <?= htmlspecialchars($lop->TenLop ?? ''); ?>
                            </div>
                            <div class="text-secondary small">
                                <i class="fa-regular fa-clock me-1"></i>
                                Bắt đầu:
                                <?= !empty($lop->NgayBatDau) ? date('d/m/Y', strtotime($lop->NgayBatDau)) : ''; ?>
                                <span class="mx-1">•</span>
                                Kết thúc:
                                <?= !empty($lop->NgayKetThuc) ? date('d/m/Y', strtotime($lop->NgayKetThuc)) : ''; ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-status <?= $isRegistered ? 'badge-active' : 'badge-inactive'; ?>">
                                <?= $isRegistered ? 'Đang đứng lớp' : 'Chưa đăng ký'; ?>
                            </span>
                            <?php if ($isRegistered && $dkId > 0): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="cancelRegister(<?= $dkId; ?>)">
                                    <i class="fa-solid fa-xmark me-1"></i>Hủy
                                </button>
                                <a href="/gym/pt/danhsach_lop?MaLop=<?= $maLop; ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-users me-1"></i>Chi tiết
                                </a>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-primary" onclick="registerLop(<?= $maLop; ?>)">
                                    <i class="fa-solid fa-plus me-1"></i>Đăng ký
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-secondary py-3">
                    Không có lớp học nào.
                </div>
            <?php endif; ?>            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    async function registerLop(maLop) {
        try {
            const response = await fetch('/gym/api/ptdayhoc', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ MaLop: maLop })
            });

            let result = {};
            try {
                result = await response.json();
            } catch (e) {
                result = {};
            }

            if (response.status === 401) {
                alert(result.message || 'Vui lòng đăng nhập bằng tài khoản huấn luyện viên');
                window.location.href = '/gym/account/login';
                return;
            }

            if (response.ok && result.success) {
                alert(result.message || 'Đăng ký đứng lớp thành công');
                window.location.reload();
                return;
            }

            if (result.errors && result.errors.exists) {
                alert(result.errors.exists);
                return;
            }

            alert(result.message || 'Không thể đăng ký đứng lớp');
        } catch (e) {
            alert('Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }

    async function cancelRegister(id) {
        if (!confirm('Bạn có chắc chắn muốn hủy đăng ký đứng lớp này?')) {
            return;
        }
        try {
            const response = await fetch('/gym/api/ptdayhoc/' + id, {
                method: 'DELETE'
            });
            let result = {};
            try {
                result = await response.json();
            } catch (e) {
                result = {};
            }

            if (response.status === 401) {
                alert(result.message || 'Vui lòng đăng nhập lại');
                window.location.href = '/gym/account/login';
                return;
            }

            if (response.ok && result.success) {
                alert(result.message || 'Đã hủy đăng ký đứng lớp');
                window.location.reload();
                return;
            }

            alert(result.message || 'Không thể hủy đăng ký đứng lớp');
        } catch (e) {
            alert('Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
</script>
</body>
</html>

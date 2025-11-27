<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="fa-solid fa-clipboard-list me-2 text-primary"></i>
                        Quản lý đăng ký lớp học
                    </h2>
                    <p class="text-muted mb-0">Theo dõi đăng ký lớp của hội viên và huấn luyện viên trong hệ thống.</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Đăng ký lớp của hội viên -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 mb-0 fw-semibold">
                                    <i class="fa-solid fa-users me-2 text-primary"></i>
                                    Đăng ký lớp của hội viên
                                </h5>
                                <span class="text-muted small">Danh sách hội viên đang tham gia hoặc đã hủy các lớp học.</span>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm align-middle mb-0">
                                    <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th>Hội viên</th>
                                        <th>Lớp học</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Ngày đăng ký</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($dangkyHv)): ?>
                                        <?php $stt = 1; foreach ($dangkyHv as $row): ?>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">
                                                    <?= htmlspecialchars($row['TenHV'] ?? ''); ?>
                                                </td>
                                                <td class="text-nowrap">
                                                    <?= htmlspecialchars($row['TenLop'] ?? ''); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php $status = trim($row['TrangThai'] ?? ''); ?>
                                                    <?php if ($status !== ''): ?>
                                                        <span class="badge <?= $status === 'DangKy' ? 'bg-success' : ($status === 'Huy' ? 'bg-secondary' : 'bg-warning text-dark'); ?>">
                                                            <?= htmlspecialchars($status === 'DangKy' ? 'Đang đăng ký' : ($status === 'Huy' ? 'Đã hủy' : $status)); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center text-muted small">
                                                    <?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : ''; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($row['id'])): ?>
                                                        <form method="post" action="/gym/admin/dangky" class="d-inline" onsubmit="return confirm('Hủy lớp học này của hội viên?');">
                                                            <input type="hidden" name="deleteId" value="<?= (int)$row['id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fa-solid fa-xmark me-1"></i>Hủy
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">Chưa có đăng ký lớp nào của hội viên.</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Đăng ký đứng lớp của PT -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-semibold">
                                    <i class="fa-solid fa-user-tie me-2 text-success"></i>
                                    Đăng ký đứng lớp của PT
                                </h5>
                                <span class="text-muted small">Danh sách huấn luyện viên đang đăng ký đứng lớp.</span>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm align-middle mb-0">
                                    <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th>Huấn luyện viên</th>
                                        <th>Lớp học</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Ngày đăng ký</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ptFiltered = [];
                                    if (!empty($dangkyPt)) {
                                        foreach ($dangkyPt as $ptRow) {
                                            $statusRaw = $ptRow['TrangThai'] ?? '';
                                            if (trim($statusRaw) === 'Đăng ký') {
                                                $ptFiltered[] = $ptRow;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($ptFiltered)): ?>
                                        <?php foreach ($ptFiltered as $row): ?>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">
                                                    <?= htmlspecialchars($row['TenPT'] ?? ''); ?>
                                                </td>
                                                <td class="text-nowrap">
                                                    <?= htmlspecialchars($row['TenLop'] ?? ''); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php $statusPt = trim($row['TrangThai'] ?? ''); ?>
                                                    <?php if ($statusPt !== ''): ?>
                                                        <span class="badge <?= $statusPt === 'Đăng ký' ? 'bg-success' : 'bg-secondary'; ?>">
                                                            <?= htmlspecialchars($statusPt); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center text-muted small">
                                                    <?= !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : ''; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Chưa có đăng ký đứng lớp nào của PT.</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

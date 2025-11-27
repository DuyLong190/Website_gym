<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin-left: 15%;
            background-color: #f3f4f6;
        }
        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
            padding: 20px 22px;
            margin-bottom: 20px;
        }
        .chart-container {
            position: relative;
            height: 320px;
            margin-bottom: 10px;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            font-weight: 600;
        }
        .section-title i {
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">
                    <i class="fa-solid fa-chart-column me-2 text-primary"></i>
                    Thống kê hệ thống
                </h2>
                <p class="text-muted mb-0">Tổng quan người dùng, gói tập và xu hướng đăng ký theo thời gian.</p>
            </div>
        </div>

        <!-- Thống kê theo role -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Thống kê theo vai trò</span>
                        </div>
                    </div>
                    <div class="chart-container mb-2">
                        <canvas id="roleChart"></canvas>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-nowrap">
                                    <th>Vai trò</th>
                                    <th class="text-end">Tổng số</th>
                                    <th class="text-end">Có gói tập</th>
                                    <th class="text-end">Chưa có gói</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['roleStats'] as $stat): ?>
                                <tr>
                                    <td><?= htmlspecialchars($stat['role_name']) ?></td>
                                    <td class="text-end fw-semibold"><?= $stat['total_users'] ?></td>
                                    <td class="text-end text-success"><?= $stat['users_with_package'] ?></td>
                                    <td class="text-end text-muted"><?= $stat['users_without_package'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Thống kê gói tập -->
            <div class="col-lg-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title">
                            <i class="fa-solid fa-dumbbell"></i>
                            <span>Thống kê gói tập</span>
                        </div>
                    </div>
                    <div class="chart-container mb-2">
                        <canvas id="packageChart"></canvas>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-nowrap">
                                    <th>Gói tập</th>
                                    <th class="text-end">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['packageStats'] as $stat): ?>
                                <tr>
                                    <td><?= htmlspecialchars($stat['TenGoiTap']) ?></td>
                                    <td class="text-end fw-semibold"><?= $stat['total_users'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê theo thời gian -->
        <div class="row mt-4 g-4">
            <div class="col-12">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Thống kê đăng ký theo thời gian</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="timeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dữ liệu cho biểu đồ
        const roleData = <?= json_encode($statistics['roleStats']) ?>;
        const packageData = <?= json_encode($statistics['packageStats']) ?>;
        const timeData = <?= json_encode($statistics['timeStats']) ?>;

        // Biểu đồ thống kê theo role
        new Chart(document.getElementById('roleChart'), {
            type: 'bar',
            data: {
                labels: roleData.map(item => item.role_name),
                datasets: [{
                    label: 'Tổng số người dùng',
                    data: roleData.map(item => item.total_users),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Có gói tập',
                    data: roleData.map(item => item.users_with_package),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Biểu đồ thống kê gói tập
        const packageLabels = [...new Set(packageData.map(item => item.TenGoiTap))];
        const roleLabels = [...new Set(packageData.map(item => item.role_name))];
        
        new Chart(document.getElementById('packageChart'), {
            type: 'bar',
            data: {
                labels: packageLabels,
                datasets: roleLabels.map((role, index) => ({
                    label: role,
                    data: packageLabels.map(pkg => {
                        const stat = packageData.find(item => 
                            item.role_name === role && item.TenGoiTap === pkg
                        );
                        return stat ? stat.total_users : 0;
                    }),
                    backgroundColor: `rgba(${index * 50}, ${255 - index * 50}, ${index * 100}, 0.5)`,
                    borderColor: `rgba(${index * 50}, ${255 - index * 50}, ${index * 100}, 1)`,
                    borderWidth: 1
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Biểu đồ thống kê theo thời gian
        new Chart(document.getElementById('timeChart'), {
            type: 'line',
            data: {
                labels: timeData.map(item => item.registration_month),
                datasets: [{
                    label: 'Số lượng đăng ký',
                    data: timeData.map(item => item.total_registrations),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html> 
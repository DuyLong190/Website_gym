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
        }
        .stat-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <h2 class="mb-4">Thống kê hệ thống</h2>

        <!-- Thống kê theo role -->
        <div class="row">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4 class="mb-3">Thống kê theo vai trò</h4>
                    <div class="chart-container">
                        <canvas id="roleChart"></canvas>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Vai trò</th>
                                    <th>Tổng số</th>
                                    <th>Có gói tập</th>
                                    <th>Chưa có gói</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['roleStats'] as $stat): ?>
                                <tr>
                                    <td><?= htmlspecialchars($stat['role_name']) ?></td>
                                    <td><?= $stat['total_users'] ?></td>
                                    <td><?= $stat['users_with_package'] ?></td>
                                    <td><?= $stat['users_without_package'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Thống kê gói tập -->
            <div class="col-md-6">
                <div class="stat-card">
                    <h4 class="mb-3">Thống kê gói tập</h4>
                    <div class="chart-container">
                        <canvas id="packageChart"></canvas>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Gói tập</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['packageStats'] as $stat): ?>
                                <tr>
                                    <td><?= htmlspecialchars($stat['TenGoiTap']) ?></td>
                                    <td><?= $stat['total_users'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê theo thời gian -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="stat-card">
                    <h4 class="mb-3">Thống kê đăng ký theo thời gian</h4>
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
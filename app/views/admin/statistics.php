<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: #eaeef6;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 8.5rem;
            margin-top: 1rem;
            margin-right: 1rem;
            padding: 2rem;
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
            background: var(--primary-gradient);
            border-radius: 20px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .overview-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .overview-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .overview-card.success::before {
            background: var(--success-gradient);
        }

        .overview-card.info::before {
            background: var(--info-gradient);
        }

        .overview-card.warning::before {
            background: var(--warning-gradient);
        }

        .overview-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .overview-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
        }

        .overview-card.success .overview-icon {
            background: var(--success-gradient);
        }

        .overview-card.info .overview-icon {
            background: var(--info-gradient);
        }

        .overview-card.warning .overview-icon {
            background: var(--warning-gradient);
        }

        .overview-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .overview-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .card-header-custom.secondary {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .card-header-custom.tertiary {
            background: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%);
        }

        .card-header-custom h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin-bottom: 1.5rem;
        }

        .table-custom {
            margin-top: 1.5rem;
        }

        .table-custom thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
            border-top: none;
        }

        .table-custom tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
        }

        .table-custom tbody tr:hover {
            background: #f8fafc;
        }

        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 1rem;
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.75rem;
            }

            .stats-overview {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-chart-line me-3"></i>Thống kê hệ thống</h1>
            <p>Tổng quan và phân tích dữ liệu hệ thống phòng gym</p>
        </div>

        <!-- Overview Cards -->
        <?php
        $totalUsers = array_sum(array_column($statistics['roleStats'], 'total_users'));
        $usersWithPackage = array_sum(array_column($statistics['roleStats'], 'users_with_package'));
        $totalPackages = count(array_unique(array_column($statistics['packageStats'], 'TenGoiTap')));
        $totalRegistrations = array_sum(array_column($statistics['timeStats'], 'total_registrations'));
        ?>
        <div class="stats-overview">
            <div class="overview-card">
                <div class="overview-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="overview-number"><?= $totalUsers ?></div>
                <div class="overview-label">Tổng số người dùng</div>
            </div>
            <div class="overview-card success">
                <div class="overview-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="overview-number"><?= $usersWithPackage ?></div>
                <div class="overview-label">Người dùng có gói tập</div>
            </div>
            <div class="overview-card info">
                <div class="overview-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="overview-number"><?= $totalPackages ?></div>
                <div class="overview-label">Loại gói tập</div>
            </div>
            <div class="overview-card warning">
                <div class="overview-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="overview-number"><?= $totalRegistrations ?></div>
                <div class="overview-label">Tổng đăng ký</div>
            </div>
        </div>

        <!-- Thống kê theo role -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="stat-card">
                    <div class="card-header-custom">
                        <h3>
                            <i class="fas fa-user-tag"></i>
                            Thống kê theo vai trò
                        </h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-container">
                            <canvas id="roleChart"></canvas>
                        </div>
                        <div class="table-responsive table-custom">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Vai trò</th>
                                        <th class="text-center">Tổng số</th>
                                        <th class="text-center">Có gói tập</th>
                                        <th class="text-center">Chưa có gói</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistics['roleStats'] as $stat): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold"><?= htmlspecialchars($stat['role_name']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-custom bg-primary text-white"><?= $stat['total_users'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-custom bg-success text-white"><?= $stat['users_with_package'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-custom bg-secondary text-white"><?= $stat['users_without_package'] ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thống kê gói tập -->
            <div class="col-lg-6">
                <div class="stat-card">
                    <div class="card-header-custom secondary">
                        <h3>
                            <i class="fas fa-box-open"></i>
                            Thống kê gói tập
                        </h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-container">
                            <canvas id="packageChart"></canvas>
                        </div>
                        <div class="table-responsive table-custom">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Vai trò</th>
                                        <th>Gói tập</th>
                                        <th class="text-center">Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistics['packageStats'] as $stat): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold"><?= htmlspecialchars($stat['role_name']) ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-medium"><?= htmlspecialchars($stat['TenGoiTap']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-custom bg-info text-white"><?= $stat['total_users'] ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê theo thời gian -->
        <div class="row">
            <div class="col-12">
                <div class="stat-card">
                    <div class="card-header-custom tertiary">
                        <h3>
                            <i class="fas fa-calendar-alt"></i>
                            Thống kê đăng ký theo thời gian
                        </h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-container">
                            <canvas id="timeChart"></canvas>
                        </div>
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
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 8
                }, {
                    label: 'Có gói tập',
                    data: roleData.map(item => item.users_with_package),
                    backgroundColor: 'rgba(17, 153, 142, 0.8)',
                    borderColor: 'rgba(17, 153, 142, 1)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });

        // Biểu đồ thống kê gói tập
        const packageLabels = [...new Set(packageData.map(item => item.TenGoiTap))];
        const roleLabels = [...new Set(packageData.map(item => item.role_name))];
        
        const colorPalette = [
            { bg: 'rgba(102, 126, 234, 0.8)', border: 'rgba(102, 126, 234, 1)' },
            { bg: 'rgba(17, 153, 142, 0.8)', border: 'rgba(17, 153, 142, 1)' },
            { bg: 'rgba(59, 130, 246, 0.8)', border: 'rgba(59, 130, 246, 1)' },
            { bg: 'rgba(240, 147, 251, 0.8)', border: 'rgba(240, 147, 251, 1)' }
        ];
        
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
                    backgroundColor: colorPalette[index % colorPalette.length].bg,
                    borderColor: colorPalette[index % colorPalette.length].border,
                    borderWidth: 2,
                    borderRadius: 8
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
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
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html> 
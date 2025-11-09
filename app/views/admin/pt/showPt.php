<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Huấn luyện viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --accent: #6366f1;
            --bg-gradient: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .pt-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border: none;
            margin-top: 2rem;
        }

        .pt-header {
            background: linear-gradient(90deg, var(--accent), var(--primary));
            color: white;
            padding: 2rem;
            border-radius: 16px 16px 0 0;
            position: relative;
        }

        .pt-avatar {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            border: 4px solid white;
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pt-avatar i {
            font-size: 48px;
            color: var(--accent);
        }

        .pt-info {
            padding: 80px 2rem 2rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: #1e293b;
        }

        .back-btn {
            background: linear-gradient(90deg, var(--accent), var(--primary));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            transition: all 0.3s;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.2);
        }

        @media (max-width: 768px) {
            .pt-header {
                padding: 1.5rem;
            }
            .pt-avatar {
                width: 100px;
                height: 100px;
                bottom: -50px;
            }
            .pt-info {
                padding: 60px 1.5rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="pt-card">
                    <div class="pt-header text-center">
                        <h1 class="h3 mb-0">Thông tin Huấn luyện viên</h1>
                        <div class="pt-avatar">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    </div>
                    
                    <div class="pt-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Họ và tên</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->HoTen ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Giới tính</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->GioiTinh ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Ngày sinh</div>
                                    <div class="info-value">
                                        <?php echo isset($pt->NgaySinh) ? date('d/m/Y', strtotime($pt->NgaySinh)) : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Số điện thoại</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->SDT ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Email</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->Email ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Địa chỉ</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->DiaChi ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Chuyên môn</div>
                                    <div class="info-value"><?php echo htmlspecialchars($pt->ChuyenMon ?? ''); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Kinh nghiệm</div>
                                    <div class="info-value">
                                        <?php echo isset($pt->KinhNghiem) ? $pt->KinhNghiem . ' năm' : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-group">
                                    <div class="info-label">Lương</div>
                                    <div class="info-value">
                                        <?php 
                                        if (isset($pt->Luong)) {
                                            echo number_format($pt->Luong, 0, ',', '.') . ' VNĐ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="/gym/admin/pt" class="back-btn">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
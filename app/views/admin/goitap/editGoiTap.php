<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Gói Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            margin-left: 15%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(120deg, #3b82f6 0%, #2563eb 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(120deg, #64748b 0%, #475569 100%);
            border: none;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(71, 85, 105, 0.3);
        }

        h1 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: #475569;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="container">
                            <h1 class="text-center mb-4">
                                <i class="fas fa-dumbbell me-2"></i>
                                Cập nhật gói tập
                            </h1>
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="/gym/admin/goitap/updateGoiTap" onsubmit="return validateForm()">
                                <input type="hidden" name="MaGoiTap" value="<?php echo $goiTap->MaGoiTap; ?>">
                                <div class="form-group mb-4">
                                    <label for="TenGoiTap">
                                        <i class="fas fa-tag me-2"></i>Tên gói tập
                                    </label>
                                    <input type="text" name="TenGoiTap" id="TenGoiTap" class="form-control" 
                                           value="<?php echo htmlspecialchars($goiTap->TenGoiTap, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="GiaTien">
                                        <i class="fas fa-money-bill-wave me-2"></i>Giá tiền
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">VNĐ</span>
                                        <input type="number" name="GiaTien" id="GiaTien" class="form-control" 
                                               step="0.01" value="<?php echo htmlspecialchars($goiTap->GiaTien); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="ThoiHan">
                                        <i class="fas fa-clock me-2"></i>Thời hạn
                                    </label>
                                    <div class="input-group">
                                        <input type="number" name="ThoiHan" id="ThoiHan" class="form-control" 
                                               value="<?php echo htmlspecialchars($goiTap->ThoiHan); ?>" required>
                                        <span class="input-group-text">tháng</span>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="MoTa">
                                        <i class="fas fa-align-left me-2"></i>Mô tả
                                    </label>
                                    <textarea name="MoTa" id="MoTa" class="form-control" rows="4"><?php echo htmlspecialchars($goiTap->MoTa ?? ''); ?></textarea>
                                </div>
                                <div class="d-flex justify-content-between mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Cập nhật
                                    </button>
                                    <a href="/gym/admin/goitap" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
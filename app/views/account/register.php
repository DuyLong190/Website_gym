<?php
include_once __DIR__ . '/../share/header.php';
if (isset($errors)) {
    echo "<ul>";
    foreach ($errors as $err) {
        echo "<li class='text-danger'>$err</li>";
    }
    echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-custom {
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .register-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.12);
            background: #fff;
            padding: 2.5rem 2rem;
            max-width: 420px;
            margin: 40px auto;
        }

        .register-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
        }

        .btn-register {
            background: linear-gradient(90deg, #6366f1 0%, #a21caf 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .btn-register:hover {
            background: linear-gradient(90deg, #a21caf 0%, #6366f1 100%);
        }

        .login-link {
            color: #6366f1;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
            color: #a21caf;
        }

        .form-floating>label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 .25em;
            transition: all 0.2s;
            opacity: 0.7;
            background: #fff;
            max-height: fit-content;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            top: 1rem;
            left: 44px;
            transform: translateY(-100%) scale(.85);
            opacity: 1;
            background: #fff;
            padding: 0 .25em;
        }

        .role-select {
            position: relative;
        }

        .role-select label {
            position: static;
            opacity: 1;
            transform: none;
            top: auto;
            left: auto;
        }
    </style>
</head>

<body>

    <section class="vh-100 gradient-custom d-flex align-items-center">
        <div class="register-card w-100">
            <h2 class="register-title text-center">Đăng Ký Tài Khoản</h2>
            <form method="POST" action="/gym/account/register" autocomplete="off">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản" required>
                    <label for="username" class="form-label">Nhập tên tài khoản</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="HoTen" name="HoTen" placeholder="Nhập họ và tên" required>
                    <label for="HoTen" class="form-label">Họ và tên</label>
                </div>

                <div class="mb-3 role-select">
                    <label for="role_id" class="form-label">Chọn vai trò</label>
                    <select class="form-select" id="role_id" name="role_id" required>
                        <option value="">-- Chọn vai trò --</option>
                        <?php 
                            if (isset($roles) && !empty($roles)) {
                                foreach ($roles as $role) {
                                    // Không cho phép chọn admin khi đăng ký
                                    if ($role->role_id != 0) {
                                        $selected = ($role->role_id == 1) ? 'selected' : '';
                                        echo "<option value='{$role->role_id}' {$selected}>" . htmlspecialchars($role->role_name) . "</option>";
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    <label for="password" class="form-label">Mật khẩu</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Nhập lại mật khẩu" required>
                    <label for="confirmpassword" class="form-label">Nhập lại mật khẩu</label>
                </div>

                <div class="mb-3">
                    <label for="NgaySinh" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="GioiTinh" id="Nam" value="Nam" checked>
                        <label class="form-check-label" for="Nam">Nam</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="GioiTinh" id="Nu" value="Nữ">
                        <label class="form-check-label" for="Nu">Nữ</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="GioiTinh" id="Khac" value="Khác">
                        <label class="form-check-label" for="Khac">Khác</label>
                    </div>
                </div>

                <div id="ptFields" style="display: none;">
                    <div class="mb-3">
                        <label for="chuyenMon" class="form-label">Chuyên môn</label>
                        <input type="text" class="form-control" id="chuyenMon" name="chuyenMon" placeholder="Ví dụ: Yoga, Gym, Boxing...">
                    </div>

                    <div class="mb-3">
                        <label for="kinhNghiem" class="form-label">Kinh nghiệm (năm)</label>
                        <input type="number" class="form-control" id="kinhNghiem" name="kinhNghiem" min="0" value="0">
                    </div>

                    <div class="mb-3">
                        <label for="luong" class="form-label">Lương cơ bản (VND)</label>
                        <input type="number" class="form-control" id="luong" name="luong" min="0" value="0">
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-register py-2" id="submit" name="submit">Tạo tài khoản</button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-dark">Đã có tài khoản? <a href="login" class="login-link">Đăng nhập</a></p>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show/hide PT fields based on role selection
            function togglePTFields() {
                const roleId = $('#role_id').val();
                if (roleId == '2') { // PT role
                    $('#ptFields').slideDown();
                    // Make PT fields required
                    $('#chuyenMon, #kinhNghiem, #luong').prop('required', true);
                } else {
                    $('#ptFields').slideUp();
                    // Remove required from PT fields
                    $('#chuyenMon, #kinhNghiem, #luong').prop('required', false);
                }
            }

            // Initial check
            togglePTFields();

            // On role change
            $('#role_id').change(togglePTFields);

            // Form validation
            $('form').on('submit', function(e) {
                const password = $('#password').val();
                const confirmPassword = $('#confirmpassword').val();
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Mật khẩu xác nhận không khớp!');
                    return false;
                }
                
                // Additional validation can be added here
                return true;
            });
        });
    </script>
</body>

</html>
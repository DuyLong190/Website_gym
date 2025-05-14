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

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
        }

        .btn-register {
            background: linear-gradient(90deg, #6366f1 0%, #a21caf 100%);
            color: #fff;
            font-weight: 600;
            border: none;
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
            pointer-events: none;
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
    </style>
</head>

<body>
    <section class="vh-100 gradient-custom d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="register-card w-100">
                <h2 class="register-title text-center">Đăng Ký Tài Khoản</h2>
                <!-- Display errors if any -->
                <?php
                if (isset($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $err) {
                        echo "<p class='mb-0'>$err</p>";
                    }
                    echo "</div>";
                }
                ?>

                <form action="/Gym/account/save" method="post" autocomplete="off">
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <label for="username" class="form-label">Nhập tên tài khoản</label>
                    </div>

                    <div class=" mb-3 form-floating">
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ và tên" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
                        <label for="fullname " class="form-label">Họ và tên</label>
                    </div>

                    <div class=" mb-3 form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        <label for="password" class="form-label">Mật khẩu</label>
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Nhập lại mật khẩu" required>
                        <label for="password" class="form-label">Nhập lại mật khẩu</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-register py-2">Tạo tài khoản</button>
                    </div>
                </form>

                <div class="text-center">
                    <p>Đã có tài khoản? <a href="login.php" class="login-link">Đăng nhập<a> </p>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
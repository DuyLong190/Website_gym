
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - LD Gym & Fitness</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .gradient-custom {
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .card.bg-dark {
            background: rgba(34, 34, 34, 0.98) !important;
            border: none;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .form-control,
        .form-control:focus {
            background-color: #f8f9fa;
            color: #111;
            border: 1px solid #555;
        }

        .form-label {
            color: #fff;
        }

        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }

        .btn-outline-light:hover {
            background: #fff;
            color: #232526;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .input-group-text {
            background: #fff;
            color: #232526;
            border-right: 0;
        }

        .form-control-lg {
            border-left: 0;
        }

        .floating-label-group {
            position: relative;
        }

        .floating-label-group input {
            padding-top: 1.5rem;
            padding-bottom: .5rem;
        }

        .floating-label-group label {
            position: absolute;
            top: 50%;
            left: 48px;
            transform: translateY(-50%);
            color: #111;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.2s;
            background: transparent;
            padding: 0 8px;
            max-width: calc(100% - 56px);
        }

        .floating-label-group input:focus+label,
        .floating-label-group input:not(:placeholder-shown)+label {
            top: -0.7rem;
            left: 44px;
            font-size: 0.95rem;
            color: rgb(254, 254, 254);
            padding: 0 8px;
            max-width: calc(100% - 56px);
        }

        .signup-link {
            color: #6366f1;
            font-weight: 500;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
            color: #a21caf;
        }
    </style>
</head>

<body>
    <section class="vh-100 gradient-custom d-flex align-items-center">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white rounded-4 shadow-lg">
                        <div class="card-body p-5">
                            <h2 class="fw-bold mb-4 text-uppercase text-center">Đăng nhập</h2>
                            <form action="/gym/account/checkLogin" method="post" >
                                <div class="mb-5">
                                    <div class="input-group input-group-lg floating-label-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" id="username" name="username" class="form-control form-control-lg"
                                            placeholder=" " required />
                                        <label for="username">Tên tài khoản</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group input-group-lg floating-label-group">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                                            placeholder=" " required />
                                        <label for="password">Mật khẩu</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <a class="text-white-50 small text-start" href="#">Quên mật khẩu?</a>
                                </div>
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-outline-light btn-lg" id="submit" name="submit">Đăng nhập</button>
                                </div>
                                <div class="text-center">
                                    <p>Chưa có tài khoản? <a href="register.php" class="signup-link">Đăng ký</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
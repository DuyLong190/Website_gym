<div class="login-wrapper">
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="/gym/account/register" autocomplete="off" id="registerForm">
                <input type="hidden" name="from_login2" value="1">
                <h1>Tạo Tài Khoản</h1>

                <!-- Error Messages -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="error-message" style="background: #fee2e2; color: #dc2626; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.875rem;">
                        <?php 
                        if (is_array($errors)) {
                            // Xử lý mảng associative (từ save()) hoặc mảng đơn giản (từ checkLogin())
                            foreach ($errors as $key => $err) {
                                if (is_numeric($key)) {
                                    // Mảng đơn giản
                                    echo '<div>' . htmlspecialchars($err) . '</div>';
                                } else {
                                    // Mảng associative
                                    echo '<div>' . htmlspecialchars($err) . '</div>';
                                }
                            }
                        } else {
                            echo '<div>' . htmlspecialchars($errors) . '</div>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Success Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message" style="background: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.875rem;">
                        <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>hoặc sử dụng email để đăng ký</span>
                
                <input type="text" id="reg_username" name="username" placeholder="Tên tài khoản" required>
                <input type="text" id="reg_HoTen" name="HoTen" placeholder="Họ và tên" required>
                
                <select id="reg_role_id" name="role_id" required style="background-color: #eee; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; border-radius: 4px; font-size: 14px;">
                    <option value="">Vai trò</option>
                    <?php 
                        if (isset($roles) && !empty($roles)) {
                            foreach ($roles as $role) {
                                if ($role->role_id != 0) {
                                    $selected = ($role->role_id == 1) ? 'selected' : '';
                                    echo "<option value='{$role->role_id}' {$selected}>" . htmlspecialchars($role->role_name) . "</option>";
                                }
                            }
                        }
                    ?>
                </select>
                
                <input type="password" id="reg_password" name="password" placeholder="Mật khẩu" required>
                <input type="password" id="reg_confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu" required>
                <input type="date" id="reg_NgaySinh" name="NgaySinh" required style="background-color: #eee; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; border-radius: 4px; font-size: 14px;">
                
                <div class="gender-group-login">
                    <div class="gender-card-login">
                        <input type="radio" name="GioiTinh" id="reg_Nam" value="Nam" checked>
                        <label for="reg_Nam">Nam</label>
                    </div>
                    <div class="gender-card-login">
                        <input type="radio" name="GioiTinh" id="reg_Nu" value="Nữ">
                        <label for="reg_Nu">Nữ</label>
                    </div>
                    <div class="gender-card-login">
                        <input type="radio" name="GioiTinh" id="reg_Khac" value="Khác">
                        <label for="reg_Khac">Khác</label>
                    </div>
                </div>

                <!-- Thông tin PT (ẩn/hiện theo vai trò) -->
                <div id="ptFields" class="pt-fields-login" style="display: none; width: 100%; margin-top: 8px;">
                    <input type="text" id="reg_chuyenMon" name="chuyenMon" placeholder="Chuyên môn" style="margin-bottom: 8px;">
                    <input type="number" id="reg_kinhNghiem" name="kinhNghiem" min="0" value="0" placeholder="Kinh nghiệm (năm)" style="margin-bottom: 8px;">
                
                </div>

                <button type="submit" id="registerSubmit" name="submit">Đăng Ký</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="/gym/account/checkLogin" method="post" id="loginForm">
                <h1>Đăng Nhập</h1>

                <!-- Error Messages -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="error-message" style="background: #fee2e2; color: #dc2626; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.875rem;">
                        <?php 
                        if (is_array($errors)) {
                            foreach ($errors as $key => $err) {
                                echo '<div>' . htmlspecialchars($err) . '</div>';
                            }
                        } else {
                            echo '<div>' . htmlspecialchars($errors) . '</div>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Success Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message" style="background: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.875rem;">
                        <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>hoặc sử dụng tài khoản</span>
                <input type="text" id="username" name="username" placeholder="Tên tài khoản" required>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                <a href="#">Quên mật khẩu?</a>
                <button type="submit" id="submit" name="submit">Đăng Nhập</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Chào Mừng Trở Lại!</h1>
                    <p>Để kết nối với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
                    <button class="ghost" id="signIn">Đăng Nhập</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Xin Chào!</h1>
                    <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                    <button class="ghost" id="signUp">Đăng Ký</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/Gym/public/js/login.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Login Form submission
        $('#loginForm').on('submit', function(e) {
            // Disable button and show loading state
            const $btn = $('#submit');
            $btn.prop('disabled', true);
            $btn.text('Đang xử lý...');

            return true;
        });

        // Register Form - Show/hide PT fields based on role selection
        function togglePTFields() {
            const roleId = $('#reg_role_id').val();
            if (roleId == '2') { // PT role
                $('#ptFields').slideDown(300);
                $('#reg_chuyenMon, #reg_kinhNghiem, #reg_luong').prop('required', true);
            } else {
                $('#ptFields').slideUp(300);
                $('#reg_chuyenMon, #reg_kinhNghiem, #reg_luong').prop('required', false);
            }
        }

        // Initial check
        togglePTFields();

        // On role change
        $('#reg_role_id').on('change', togglePTFields);

        // Register Form validation
        $('#registerForm').on('submit', function(e) {
            const password = $('#reg_password').val();
            const confirmPassword = $('#reg_confirmpassword').val();
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                $('#reg_confirmpassword').focus();
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                $('#reg_password').focus();
                return false;
            }

            // Disable button and show loading state
            const $btn = $('#registerSubmit');
            $btn.prop('disabled', true);
            $btn.text('Đang xử lý...');
            
            return true;
        });

        // Add smooth scroll to error if exists and switch to appropriate panel
        <?php if (isset($errors) && !empty($errors)): ?>
            // Kiểm tra xem errors đến từ form đăng ký hay đăng nhập
            // Nếu errors có keys như 'username', 'HoTen', 'password', 'confirmPass' thì đó là từ form đăng ký
            <?php 
            $isRegisterError = false;
            if (is_array($errors)) {
                $registerKeys = ['username', 'HoTen', 'password', 'confirmPass', 'system'];
                foreach ($registerKeys as $key) {
                    if (isset($errors[$key])) {
                        $isRegisterError = true;
                        break;
                    }
                }
            }
            ?>
            <?php if ($isRegisterError): ?>
                // Errors từ form đăng ký - chuyển sang panel đăng ký
                $('#container').addClass('right-panel-active');
            <?php endif; ?>
            
            // Scroll to error message
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('.error-message').first().offset().top - 100
                }, 500);
            }, 300);
        <?php endif; ?>
    });
</script>
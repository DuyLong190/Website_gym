<section class="register-wrapper">
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="register-main-card">
                    <!-- Header -->
                    <div class="register-header">
                        <h1 class="register-title">Đăng Ký</h1>
                    </div>

                    <!-- Error Messages -->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="register-error-alert">
                            <ul>
                                <?php foreach ($errors as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Success Messages -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="register-success-alert" style="background: #d1fae5; border: 1px solid #86efac; border-radius: 6px; padding: 0.75rem; margin-bottom: 1rem; color: #065f46;">
                            <?= htmlspecialchars($_SESSION['success_message']) ?>
                            <?php unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Registration Form -->
                    <form method="POST" action="/gym/account/register" autocomplete="off" id="registerForm">
                        <div class="form-group-modern">
                            <input type="text" class="form-input-modern" id="username" name="username" placeholder="Tên tài khoản" required>
                        </div>

                        <div class="form-group-modern">
                            <input type="text" class="form-input-modern" id="HoTen" name="HoTen" placeholder="Họ và tên" required>
                        </div>

                        <div class="form-group-modern">
                            <select class="form-select-modern" id="role_id" name="role_id" required>
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
                        </div>

                        <div class="form-group-modern">
                            <input type="password" class="form-input-modern" id="password" name="password" placeholder="Mật khẩu" required>
                        </div>

                        <div class="form-group-modern">
                            <input type="password" class="form-input-modern" id="confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu" required>
                        </div>

                        <div class="form-group-modern">
                            <input type="date" class="form-input-modern" id="NgaySinh" name="NgaySinh" required>
                        </div>

                        <div class="form-group-modern">
                            <div class="gender-group-modern">
                                <div class="gender-card">
                                    <input type="radio" name="GioiTinh" id="Nam" value="Nam" checked>
                                    <label for="Nam">Nam</label>
                                </div>
                                <div class="gender-card">
                                    <input type="radio" name="GioiTinh" id="Nu" value="Nữ">
                                    <label for="Nu">Nữ</label>
                                </div>
                                <div class="gender-card">
                                    <input type="radio" name="GioiTinh" id="Khac" value="Khác">
                                    <label for="Khac">Khác</label>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin PT (ẩn/hiện theo vai trò) -->
                        <div id="ptFields" class="pt-fields-modern" style="display: none;">
                            <div class="form-group-modern">
                                <input type="text" class="form-input-modern" id="chuyenMon" name="chuyenMon" placeholder="Chuyên môn">
                            </div>

                            <div class="form-group-modern">
                                <input type="number" class="form-input-modern" id="kinhNghiem" name="kinhNghiem" min="0" value="0" placeholder="Kinh nghiệm (năm)">
                            </div>

                            <div class="form-group-modern">
                                <input type="number" class="form-input-modern" id="luong" name="luong" min="0" value="0" placeholder="Lương cơ bản (VND)">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-register-modern" id="submit" name="submit">
                            Tạo tài khoản
                        </button>
                    </form>

                    <!-- Footer -->
                    <div class="register-footer">
                        <p class="register-footer-text">
                            Đã có tài khoản? 
                            <a href="login" class="register-login-link">Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
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
                $('#ptFields').slideDown(300);
                $('#chuyenMon, #kinhNghiem, #luong').prop('required', true);
            } else {
                $('#ptFields').slideUp(300);
                $('#chuyenMon, #kinhNghiem, #luong').prop('required', false);
            }
        }

        // Initial check
        togglePTFields();

        // On role change
        $('#role_id').on('change', togglePTFields);

        // Form validation
        $('#registerForm').on('submit', function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#confirmpassword').val();
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                $('#confirmpassword').focus();
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                $('#password').focus();
                return false;
            }

            // Disable button and show loading state
            const $btn = $('#submit');
            $btn.prop('disabled', true);
            $btn.text('Đang xử lý...');
            
            return true;
        });

        // Add smooth scroll to error if exists
        <?php if (isset($errors) && !empty($errors)): ?>
            $('html, body').animate({
                scrollTop: $('.register-error-alert').offset().top - 100
            }, 500);
        <?php endif; ?>
    });
</script>

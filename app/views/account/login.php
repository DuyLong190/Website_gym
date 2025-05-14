<?php include 'app/views/share/header.php'; ?>
?> <section class="vh-100 gradient-custom">
    <div class="container">
        <h2>Đăng Nhập</h2>
        <form action="/account/login" method="POST">
            <div class="txt_field">
                <input type="text" name="username" required>
                <label>Tên Đăng Nhập</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <label>Mật Khẩu</label>
            </div>
            <input type="submit" value="Đăng Nhập">
            <div class="signup_link">
                Chưa có tài khoản? <a href="/accoSunt/register">Đăng Ký</a>
            </div>
        </form>

        <?php if (isset($loginMessage)): ?>
            <div class="message"><?php echo $loginMessage; ?></div>
        <?php endif; ?>

        <?php if ($loginMessage): ?>
            <div class="message"><?= htmlspecialchars($loginMessage) ?></div>
        <?php endif; ?>

        <div class="overlay" id="overlay">
            <div class="form-container">
                <button class="close-btn" id="closeFormBtn">&times;</button>
                <form action="" method="POST">
                    <div class="input-box">
                        <input type="text" placeholder="Nhập tài khoản" required>

                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Nhập mật khẩu" required>

                    </div>
                    <div class="pass">Quên mật khẩu?</div>
                    <input type="submit" value="Đăng nhập">
                    <div class="signup_link">
                        Bạn chưa có tài khoản? <a href="signup.php">Đăng ký</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

        
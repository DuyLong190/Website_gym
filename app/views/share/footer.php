<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section about">
                <h3>L&D Center</h3>
                <p>Nơi rèn luyện sức khỏe tốt nhất cho bạn.</p>
            </div>
            <div class="footer-section contact">
                <h3>Liên hệ</h3>
                <p>Email: info@gymcenter.com</p>
                <p>Điện thoại: 0987.654.321</p>
                <p>Địa chỉ: 475A Điện Biên Phủ, phường 25, quận Bình Thạnh, HCMC</p>
            </div>
        </div>
        <div class="footer-bottom mt-4">
            <h3>Giờ mở cửa:</h3>
            <p>Thứ 2 - Thứ 6: 6:00 - 22:00</p>
            <p>Thứ 7 - Chủ nhật: 5:00 - 23:00</p>
        </div>
    </div>
</footer>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .footer {
        background-color: #8f2121;
        color: #fff;
        padding: 20px 0;
    }

    .footer .container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .footer-section h3 {
        margin-bottom: 15px;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .footer .container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
</style>
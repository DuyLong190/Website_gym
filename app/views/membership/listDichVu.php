<div class="page-wrapper">
    <div class="container">
        <section class="hero-section text-white py-5 mb-5">
            <div class="container px-4">
                <h1 class="text-center">DỊCH VỤ THƯ GIÃN</h1>
            </div>
        </section>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($DVTGs)): ?>
            <div class="row">
                <?php foreach ($DVTGs as $DVTG): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <ul class="product-plans">
                            <li class="product-plan">
                                <div class="title">
                                    <?php echo htmlspecialchars($DVTG->TenTG); ?>
                                </div>
                                <div class="price">
                                    <?php echo number_format($DVTG->GiaTG); ?>
                                    <span class="currency-symbol">Đ</span>
                                </div>
                                <div class="duration-info">
                                    <i class="fa fa-calendar-alt"></i>
                                    <span class="duration-label">Thời gian sử dụng:</span>
                                    <span class="duration-value"><?php echo htmlspecialchars($DVTG->ThoiGianTG); ?> phút</span>
                                </div>
                                <div class="description-content">
                                    <?php $moTa = htmlspecialchars($DVTG->MoTaTG);
                                    $cauArr = array_filter(array_map('trim', explode('.', $moTa)));
                                    foreach ($cauArr as $cau) {
                                        echo '<div class="description-item">' . $cau . '.</div>';
                                    } ?>
                                </div>
                                <div class="mt-auto">
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <button type="button" class="btn btn-primary btn-sm" style="width: auto; min-width: 80px;" onclick="toggleRegisterForm(<?php echo $DVTG->id; ?>)">
                                            Chọn
                                        </button>
                                        
                                        <form method="post" action="/gym/user/dichvu/dangky_dichvu" id="registerForm_<?php echo $DVTG->id; ?>" class="register-form" style="display: none;">
                                            <input type="hidden" name="id_dv" value="<?php echo htmlspecialchars($DVTG->id); ?>">
                                            
                                            <div class="mb-2">
                                                <label for="NgaySuDung_<?php echo $DVTG->id; ?>" class="form-label small">Ngày sử dụng <span class="text-danger">*</span></label>
                                                <input type="date" 
                                                       class="form-control form-control-sm" 
                                                       id="NgaySuDung_<?php echo $DVTG->id; ?>" 
                                                       name="NgaySuDung" 
                                                       required 
                                                       min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            
                                            <div class="mb-2">
                                                <label for="GioSuDung_<?php echo $DVTG->id; ?>" class="form-label small">Giờ sử dụng <span class="text-danger">*</span></label>
                                                <input type="time" 
                                                       class="form-control form-control-sm" 
                                                       id="GioSuDung_<?php echo $DVTG->id; ?>" 
                                                       name="GioSuDung" 
                                                       required>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <label for="GhiChu_<?php echo $DVTG->id; ?>" class="form-label small">Ghi chú (tùy chọn)</label>
                                                <textarea class="form-control form-control-sm" 
                                                          id="GhiChu_<?php echo $DVTG->id; ?>" 
                                                          name="GhiChu" 
                                                          rows="2" 
                                                          placeholder="Nhập ghi chú nếu có"></textarea>
                                            </div>
                                            
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="submit" class="btn-icon btn-icon-success" title="Đăng ký">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" class="btn-icon btn-icon-cancel" onclick="toggleRegisterForm(<?php echo $DVTG->id; ?>)" title="Hủy">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <a href="/gym/account/login" class="btn btn-primary w-100">
                                            <i class="fa fa-sign-in-alt"></i> Đăng nhập để đăng ký
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Không có dịch vụ thư giãn nào.</div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleRegisterForm(dvId) {
    const form = document.getElementById('registerForm_' + dvId);
    if (form) {
        if (form.style.display === 'none') {
            form.style.display = 'block';
            // Scroll to form
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            form.style.display = 'none';
        }
    }
}

// Set min date to today for all date inputs
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        if (!input.min) {
            input.setAttribute('min', today);
        }
    });
});
</script>

<style>
.register-form {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 10px;
    border: 1px solid #dee2e6;
}

.register-form .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 5px;
}

.register-form .form-control-sm {
    font-size: 0.875rem;
}

.register-form .btn-sm {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

.product-plan .btn {
    width: 100%;
    margin-bottom: 10px;
}

.product-plan .btn-primary.btn-sm {
    width: auto !important;
    min-width: 80px;
}

/* Icon buttons */
.btn-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    padding: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

.btn-icon:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.btn-icon-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
}

.btn-icon-success:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: white;
}

.btn-icon-cancel {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-icon-cancel:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    color: white;
}

.btn-icon i {
    font-size: 1rem;
    line-height: 1;
}

@media (max-width: 768px) {
    .register-form {
        padding: 12px;
    }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
}
</style>
<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../models/ChiTiet_Goitap_Model.php';
require_once __DIR__ . '/../config/database.php';

class GoiTapController
{
    private $goitapModel;
    private $hoiVienModel;
    private $ctgtModel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->goitapModel = new GoiTapModel($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
        $this->ctgtModel = new ChiTiet_Goitap_Model($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexGoiTap()
    {
        $goiTaps = $this->goitapModel->getGoiTaps();
        // Lấy thông tin hội viên nếu đã đăng nhập
        $hoiVien = null;
        if (isset($_SESSION['username'])) {
            $hoiVien = $this->hoiVienModel->getHoiVienByUsername($_SESSION['username']);
        }
        $pageTitle = 'Gói tập';
        $additionalHeadContent = <<<HTML
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
            <link rel="stylesheet" href="/Gym/public/css/goitap.css">
        HTML;
        require_once __DIR__ . '/../views/share/header.php';
        require_once __DIR__ . '/../views/membership/listGoiTap.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            include_once __DIR__ . '/../views/membership/showGoiTap.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    public function add()
    {
        include_once __DIR__ . '/../views/package/addGoiTap.php';
    }

    // Lưu gói tập mới
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenGoiTap = $_POST['TenGoiTap'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? '';
            $ThoiHan = $_POST['ThoiHan'] ?? '';
            $MoTa = $_POST['MoTa'] ?? '';

            $result = $this->goitapModel->addGoiTap($TenGoiTap, $GiaTien, $ThoiHan, $MoTa);
            
            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/share/header.php';
                require_once __DIR__ . '/../views/package/addGoiTap.php';
                require_once __DIR__ . '/../views/share/footer.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/goitap');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm gói tập. Vui lòng thử lại.";
            }
        }
    }

    // Hiển thị form chỉnh sửa gói tập
    public function edit($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            include_once __DIR__ . '/../views/package/editGoiTap.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    // Cập nhật gói tập
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaGoiTap = $_POST['MaGoiTap'];
            $TenGoiTap = $_POST['TenGoiTap'];
            $GiaTien = $_POST['GiaTien'];
            $ThoiHan = $_POST['ThoiHan'];
            $MoTa = $_POST['MoTa'] ?? '';

            $edit = $this->goitapModel->updateGoiTap($MaGoiTap, $TenGoiTap, $GiaTien, $ThoiHan, $MoTa);
            if ($edit) {
                header('Location: /gym/goitap');
            } else {
                echo "Cập nhật gói tập không thành công.";
            }
        }
    }

    // Xóa gói tập
    public function delete($MaGoiTap)
    {
        if ($this->goitapModel->deleteGoiTap($MaGoiTap)) {
            header('Location: /gym/goitap');
        } else {
            echo "Xóa gói tập không thành công.";
        }
    }

    public function select($MaGoiTap)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để đăng ký gói tập";
            header('Location: /gym/account/login');
            exit;
        }

        // Lấy thông tin hội viên
        $username = $_SESSION['username'];
        $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/goitap');
            exit;
        }

        // Kiểm tra gói tập có tồn tại không
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if (!$goiTap) {
            $_SESSION['error'] = "Gói tập không tồn tại";
            header('Location: /gym/goitap');
            exit;
        }

        try {
            $this->db->beginTransaction();

            // Chỉ tạo chi tiết gói tập, KHÔNG cập nhật MaGoiTap vào HoiVien
            // MaGoiTap sẽ được cập nhật sau khi admin xác nhận thanh toán
            $id_ctgt = $this->ctgtModel->createForHoiVien((int)$hoiVien->MaHV, (int)$MaGoiTap);
            if (!$id_ctgt) {
                throw new Exception('Không thể tạo chi tiết gói tập');
            }

            $this->db->commit();
            $_SESSION['success'] = "Đăng ký gói tập thành công. Vui lòng thanh toán và chờ admin xác nhận.";
            
            // Chuyển đến trang chi tiết gói tập
            header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log('GoiTapController::select error - ' . $e->getMessage());
            $_SESSION['error'] = "Đăng ký gói tập thất bại: " . $e->getMessage();
            header('Location: /gym/goitap');
        }
        exit;
    }
}
?>
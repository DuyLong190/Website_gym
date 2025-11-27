<?php
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/LichLopHocModel.php';
class UserController
{
    private $hoivienModel;
    private $goitapModel;
    private $accountModel;
    private $dangKyLopHocModel;
    private $lichLopHocModel;
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
        $this->hoivienModel = new HoiVienModel($this->db);
        $this->goitapModel = new GoiTapModel($this->db);
        $this->accountModel = new AccountModel($this->db);
        $this->dangKyLopHocModel = new DangKyLopHocModel($this->db);
        $this->lichLopHocModel = new LichLopHocModel($this->db);
    }
    public function profile()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }
        // Lấy thông tin hội viên dựa trên username
        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);
        // Debug thông tin
        if (!$hoiVien) {
            error_log("Không tìm thấy thông tin hội viên cho username: " . $username);
        }
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        require_once __DIR__ . '/../views/user/info/profile.php';
    }

    public function edit_profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/edit_profile');
            exit;
        }
    
        // Lấy thông tin hội viên dựa trên username
        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/user/profile');
            exit;
        }
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        require_once __DIR__ . '/../views/user/info/edit_profile.php';
    }

    public function update_profile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['username'])) {
                header('Location: /gym/account/login');
                exit;
            }

            $username = $_SESSION['username'];
            $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

            if (!$hoiVien) {
                $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
                header('Location: /gym/user/profile');
                exit;
            }

            // Lấy dữ liệu từ form, sử dụng null nếu không có giá trị
            $HoTen = !empty($_POST['fullname']) ? $_POST['fullname'] : null;
            $NgaySinh = !empty($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
            $GioiTinh = !empty($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
            $ChieuCao = !empty($_POST['ChieuCao']) ? $_POST['ChieuCao'] : null;
            $CanNang = !empty($_POST['CanNang']) ? $_POST['CanNang'] : null;
            $SDT = !empty($_POST['SDT']) ? $_POST['SDT'] : null;
            $Email = !empty($_POST['Email']) ? $_POST['Email'] : null;
            $DiaChi = !empty($_POST['DiaChi']) ? $_POST['DiaChi'] : null;

            // Cập nhật thông tin
            if ($this->hoivienModel->updateHoiVienProfile($hoiVien->MaHV, $HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi)) {
                // Cập nhật session HoTen nếu có thay đổi
                if ($HoTen) {
                    $_SESSION['HoTen'] = $HoTen;
                }
                $_SESSION['success'] = "Cập nhật thông tin thành công";
                header('Location: /gym/user/profile');
            } else {
                $_SESSION['error'] = "Cập nhật thông tin thất bại";
                header('Location: /gym/user/edit_profile');
            }
            exit;
        }
    }

    public function lophoc()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }

        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/user/profile');
            exit;
        }

        $MaHV = (int)$hoiVien->MaHV;
        $dangKys = $this->dangKyLopHocModel->getByHoiVien($MaHV);

        require_once __DIR__ . '/../views/user/sidebarUser.php';
        require_once __DIR__ . '/../views/user/lophoc.php';
    }

    public function lichlophoc()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }

        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/user/profile');
            exit;
        }

        $MaHV = (int)$hoiVien->MaHV;
        $dangKys = $this->dangKyLopHocModel->getByHoiVien($MaHV);

        $maLops = [];
        if (!empty($dangKys)) {
            foreach ($dangKys as $dk) {
                $trangThai = isset($dk['TrangThai']) ? $dk['TrangThai'] : '';
                if ($trangThai === 'DangKy' && isset($dk['MaLop']) && is_numeric($dk['MaLop'])) {
                    $maLops[] = (int)$dk['MaLop'];
                }
            }
            $maLops = array_values(array_unique($maLops));
        }

        $maLopFilter = null;
        if (isset($_GET['MaLop']) && is_numeric($_GET['MaLop'])) {
            $maLopFilter = (int)$_GET['MaLop'];
        }

        if ($maLopFilter !== null && !empty($maLops)) {
            $maLops = array_values(array_filter($maLops, function ($id) use ($maLopFilter) {
                return $id === $maLopFilter;
            }));
        }

        $lichLops = !empty($maLops) ? $this->lichLopHocModel->getByMaLops($maLops) : [];

        require_once __DIR__ . '/../views/user/sidebarUser.php';
        require_once __DIR__ . '/../views/user/lichlophoc.php';
    }
}
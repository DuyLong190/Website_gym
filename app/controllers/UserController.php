<?php
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/LichLopHocModel.php';
require_once __DIR__ . '/../config/database.php';
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
        ob_start();
        require_once __DIR__ . '/../views/user/info/profile.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        $sidebar = ob_get_clean();

        if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
            $headContent = $headMatches[1];
            $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
        }
        if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
            $navbarContent = $bodyMatches[1];
            $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
        }
        echo $content;
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
        ob_start();
        require_once __DIR__ . '/../views/user/info/edit_profile.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        $sidebar = ob_get_clean();

        if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
            $headContent = $headMatches[1];
            $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
        }
        if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
            $navbarContent = $bodyMatches[1];
            $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
        }
        echo $content;
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

            // Xử lý upload ảnh nếu có
            $oldImagePath = $hoiVien->image ?? null;
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                try {
                    $imagePath = $this->handleImageUpload('image', $oldImagePath);
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header('Location: /gym/user/edit_profile');
                    exit;
                }
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
            if ($this->hoivienModel->updateHoiVienProfile($hoiVien->MaHV, $HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $imagePath)) {
                // Cập nhật session HoTen nếu có thay đổi
                if ($HoTen) {
                    $_SESSION['HoTen'] = $HoTen;
                }
                $_SESSION['success'] = "Cập nhật thông tin thành công";
                header('Location: /gym/user/profile');
            } else {
                // Nếu cập nhật thất bại và đã upload ảnh mới, xóa ảnh mới và giữ ảnh cũ
                if ($imagePath && $imagePath !== $oldImagePath) {
                    $this->deleteImage($imagePath);
                }
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

        ob_start();
        require_once __DIR__ . '/../views/user/lophoc.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        $sidebar = ob_get_clean();

        if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
            $headContent = $headMatches[1];
            $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
        }
        if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
            $navbarContent = $bodyMatches[1];
            $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
        }
        echo $content;
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

        ob_start();
        require_once __DIR__ . '/../views/user/lichlophoc.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        $sidebar = ob_get_clean();

        if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
            $headContent = $headMatches[1];
            $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
        }
        if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
            $navbarContent = $bodyMatches[1];
            $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
        }
        echo $content;
    }

    // Xử lý upload ảnh
    private function handleImageUpload($fileInput, $oldImagePath = null)
    {
        // Kiểm tra xem có file được upload không
        if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
            // Nếu không có file mới và có ảnh cũ, giữ nguyên ảnh cũ
            return $oldImagePath;
        }

        $file = $_FILES[$fileInput];
        
        // Validate file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('Kích thước file không được vượt quá 5MB');
        }

        // Tạo thư mục upload nếu chưa tồn tại
        $uploadDir = __DIR__ . '/../../public/images/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Tạo tên file unique
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'hoivien_' . time() . '_' . uniqid() . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        // Upload file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception('Không thể upload file');
        }

        // Xóa ảnh cũ nếu có
        if ($oldImagePath && file_exists(__DIR__ . '/../../' . $oldImagePath)) {
            @unlink(__DIR__ . '/../../' . $oldImagePath);
        }

        // Trả về đường dẫn relative từ root
        return 'public/images/' . $fileName;
    }

    // Xóa ảnh
    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            $fullPath = __DIR__ . '/../../' . $imagePath;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }
}
<?php
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/LichLopHocModel.php';
require_once __DIR__ . '/../models/ChiTiet_Goitap_Model.php';
require_once __DIR__ . '/../models/DvThuGianModel.php';
require_once __DIR__ . '/../models/DangKyDichVuModel.php';
require_once __DIR__ . '/../models/ThanhToanHoaDonModel.php';
require_once __DIR__ . '/../models/YeuCauThanhToanModel.php';
require_once __DIR__ . '/../config/database.php';
class UserController
{
    private $hoivienModel;
    private $goitapModel;
    private $accountModel;
    private $dangKyLopHocModel;
    private $lichLopHocModel;
    private $chiTietGoiTapModel;
    private $dvtgModel;
    private $dangKyDichVuModel;
    private $thanhToanHoaDonModel;
    private $yeuCauThanhToanModel;
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
        $this->hoivienModel = new HoiVienModel($this->db);
        $this->goitapModel = new GoiTapModel($this->db);
        $this->accountModel = new AccountModel($this->db);
        $this->dangKyLopHocModel = new DangKyLopHocModel($this->db);
        $this->lichLopHocModel = new LichLopHocModel($this->db);
        $this->chiTietGoiTapModel = new ChiTiet_Goitap_Model($this->db);
        $this->dvtgModel = new DvThuGianModel($this->db);
        $this->dangKyDichVuModel = new DangKyDichVuModel($this->db);
        $this->thanhToanHoaDonModel = new ThanhToanHoaDonModel($this->db);
        $this->yeuCauThanhToanModel = new YeuCauThanhToanModel($this->db);
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
        
        // Lấy thông tin gói tập đã thanh toán để kiểm tra hiển thị TenGoiTap
        $currentPackage = null;
        if ($hoiVien && isset($hoiVien->MaHV)) {
            $currentPackage = $this->chiTietGoiTapModel->getActiveByMaHV((int)$hoiVien->MaHV);
            // Nếu không có gói chưa hủy, tìm gói đã thanh toán
            if (!$currentPackage) {
                $allPackages = $this->chiTietGoiTapModel->getAllByMaHV((int)$hoiVien->MaHV);
                foreach ($allPackages as $package) {
                    $daThanhToan = (int)($package['DaThanhToan'] ?? 0);
                    if ($daThanhToan === 1) {
                        $currentPackage = $package;
                        break;
                    }
                }
            }
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

    public function lichsuhoatdong()
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
        
        // Lấy tất cả gói tập của hội viên
        $allPackages = $this->chiTietGoiTapModel->getAllByMaHV($MaHV);
        
        // Lọc chỉ lấy các gói tập đã bị hủy
        $canceledPackages = [];
        foreach ($allPackages as $package) {
            $trangThai = $package['TrangThai'] ?? '';
            if ($trangThai === 'Đã hủy' || $trangThai === 'Hết hạn') {
                $canceledPackages[] = $package;
            }
        }

        // Lấy các lớp học đã hủy của hội viên
        $canceledClasses = $this->dangKyLopHocModel->getCanceledByHoiVien($MaHV);

        ob_start();
        require_once __DIR__ . '/../views/user/lichsu_hoatdong.php';
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

    public function dichvu()
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
        $dichVus = $this->dvtgModel->getDVTGs();
        $dangKys = $this->dangKyDichVuModel->getDangKyByMaHV($MaHV);

        ob_start();
        require_once __DIR__ . '/../views/user/dichvu/indexDichVu.php';
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

    public function dangky_dichvu()
    {
        error_log("dangky_dichvu called - Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . print_r($_POST, true));
        
        if (!isset($_SESSION['username'])) {
            error_log("dangky_dichvu: User not logged in");
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("dangky_dichvu: Not POST method, redirecting");
            header('Location: /gym/user/dichvu');
            exit;
        }

        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/user/dichvu');
            exit;
        }

        $MaHV = (int)$hoiVien->MaHV;
        $id_dv = isset($_POST['id_dv']) ? (int)$_POST['id_dv'] : 0;
        $ngaySuDung = isset($_POST['NgaySuDung']) ? $_POST['NgaySuDung'] : '';
        $gioSuDung = isset($_POST['GioSuDung']) ? $_POST['GioSuDung'] : '';
        $ghiChu = isset($_POST['GhiChu']) ? $_POST['GhiChu'] : null;

        // Validate
        if ($id_dv <= 0) {
            $_SESSION['error'] = 'Vui lòng chọn dịch vụ';
            header('Location: /gym/user/dichvu');
            exit;
        }

        if (empty($ngaySuDung) || empty($gioSuDung)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ ngày và giờ sử dụng';
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Kiểm tra ngày sử dụng không được trong quá khứ
        $ngaySuDungObj = new DateTime($ngaySuDung);
        $today = new DateTime();
        $today->setTime(0, 0, 0);
        
        if ($ngaySuDungObj < $today) {
            $_SESSION['error'] = 'Ngày sử dụng không được trong quá khứ';
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Lấy thông tin dịch vụ để lấy giá tiền
        $dichVu = $this->dvtgModel->getDVTG_ByID($id_dv);
        if (!$dichVu) {
            $_SESSION['error'] = 'Dịch vụ không tồn tại';
            header('Location: /gym/user/dichvu');
            exit;
        }

        $soTien = (float)($dichVu->GiaTG ?? 0);
        if ($soTien <= 0) {
            $_SESSION['error'] = 'Giá dịch vụ không hợp lệ';
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Tạo yêu cầu thanh toán (tương tự như gói tập)
        $thongTinDichVu = [
            'id_dv' => $id_dv,
            'NgaySuDung' => $ngaySuDung,
            'GioSuDung' => $gioSuDung,
            'GhiChu' => $ghiChu
        ];

        $result = $this->yeuCauThanhToanModel->createForDichVu($MaHV, $soTien, $thongTinDichVu);
        
        if ($result) {
            $_SESSION['success'] = 'Đăng ký dịch vụ thành công. Vui lòng thanh toán và chờ admin xác nhận.';
        } else {
            $_SESSION['error'] = 'Đăng ký dịch vụ không thành công. Vui lòng thử lại.';
            error_log("Failed to create YeuCauThanhToan for DichVu - MaHV: $MaHV, id_dv: $id_dv, NgaySuDung: $ngaySuDung, GioSuDung: $gioSuDung");
        }

        // Redirect về trang trước đó hoặc trang dịch vụ
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/gym/dichvu';
        // Nếu referer là trang user/dichvu thì giữ nguyên, nếu không thì về trang public
        if (strpos($redirectUrl, '/gym/user/dichvu') !== false) {
            $redirectUrl = '/gym/user/dichvu';
        } else {
            $redirectUrl = '/gym/dichvu';
        }
        
        header('Location: ' . $redirectUrl);
        exit;
    }

    public function huy_dangky_dichvu($id)
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/user/dichvu');
            exit;
        }

        $username = $_SESSION['username'];
        $hoiVien = $this->hoivienModel->getHoiVienByUsername($username);

        if (!$hoiVien) {
            $_SESSION['error'] = "Không tìm thấy thông tin hội viên";
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Kiểm tra đăng ký có thuộc về hội viên này không
        $dangKy = $this->dangKyDichVuModel->getDangKyById($id);
        if (!$dangKy || (int)$dangKy->MaHV !== (int)$hoiVien->MaHV) {
            $_SESSION['error'] = 'Không tìm thấy đăng ký dịch vụ';
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Chỉ cho phép hủy nếu đang ở trạng thái "Chờ xác nhận" hoặc "Đã xác nhận"
        if ($dangKy->TrangThai !== 'Chờ xác nhận' && $dangKy->TrangThai !== 'Đã xác nhận') {
            $_SESSION['error'] = 'Không thể hủy đăng ký dịch vụ này';
            header('Location: /gym/user/dichvu');
            exit;
        }

        if ($this->dangKyDichVuModel->cancelDangKy($id)) {
            $_SESSION['success'] = 'Hủy đăng ký dịch vụ thành công';
        } else {
            $_SESSION['error'] = 'Hủy đăng ký dịch vụ không thành công';
        }

        header('Location: /gym/user/dichvu');
        exit;
    }

    public function hoadon()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username']) || !isset($_SESSION['MaHV'])) {
            header('Location: /gym/account/login');
            exit;
        }

        $maHV = (int)$_SESSION['MaHV'];
        
        // Lấy danh sách hóa đơn với thông tin chi tiết
        $hoaDons = [];
        $allHoaDons = $this->thanhToanHoaDonModel->getByMaHV($maHV);
        
        foreach ($allHoaDons as $hd) {
            $hoaDonWithDetails = $this->thanhToanHoaDonModel->getWithDetails($hd['id']);
            if ($hoaDonWithDetails) {
                $hoaDons[] = $hoaDonWithDetails;
            } else {
                $hoaDons[] = $hd; // Fallback nếu không lấy được chi tiết
            }
        }

        ob_start();
        require_once __DIR__ . '/../views/user/hoadon/indexHoaDon.php';
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
}
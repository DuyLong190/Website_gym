<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/DvThuGianModel.php';
require_once __DIR__ . '/../models/DvTapLuyenModel.php';
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../config/database.php';

class AdminController
{
    private $dvtgModel;
    private $goitapModel;
    private $lophocModel;
    private $db;
    private $hoiVienModel;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->goitapModel = new GoiTapModel($this->db);
        $this->dvtgModel = new DvThuGianModel($this->db);
        $this->lophocModel = new DvTapLuyenModel($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
    }
    //Gói tập----------------------------------------------------------------------------------------------------------------------
    public function indexGoitap()
    {
        $goiTaps = $this->goitapModel->getGoiTaps();
        require_once __DIR__ . '/../views/admin/sidebarQL.php';
        require_once __DIR__ . '/../views/admin/goitap/adminGoiTap.php';
    }

    public function showGoiTap($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/goitap/showGoiTap.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    public function addGoiTap()
    {
        include_once __DIR__ . '/../views/admin/goitap/addGoiTap.php';
    }

    public function saveGoiTap()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenGoiTap = $_POST['TenGoiTap'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? '';
            $ThoiHan = $_POST['ThoiHan'] ?? '';
            $MoTa = $_POST['MoTa'] ?? '';

            $result = $this->goitapModel->addGoiTap($TenGoiTap, $GiaTien, $ThoiHan, $MoTa);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/admin/sidebarQL.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/admin/goitap');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm gói tập. Vui lòng thử lại.";
            }
        }
    }

    // Hiển thị form chỉnh sửa gói tập
    public function editGoiTap($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/goitap/editGoiTap.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    // Cập nhật gói tập
    public function updateGoiTap()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaGoiTap = $_POST['MaGoiTap'];
            $TenGoiTap = $_POST['TenGoiTap'];
            $GiaTien = $_POST['GiaTien'];
            $ThoiHan = $_POST['ThoiHan'];
            $MoTa = $_POST['MoTa'] ?? '';

            $edit = $this->goitapModel->updateGoiTap($MaGoiTap, $TenGoiTap, $GiaTien, $ThoiHan, $MoTa);
            if ($edit) {
                header('Location: /gym/admin/goitap');
            } else {
                echo "Cập nhật gói tập không thành công.";
            }
        }
    }

    // Xóa gói tập
    public function deleteGoiTap($MaGoiTap)
    {
        if ($this->goitapModel->deleteGoiTap($MaGoiTap)) {
            header('Location: /gym/admin/goitap');
        } else {
            echo "Xóa gói tập không thành công.";
        }
    }

    //Dịch vụ thư giãn---------------------------------------------------------------------------------------------------------------
    public function indexDvThuGian()
    {
        $DVTGs = $this->dvtgModel->getDVTGs();

        require_once __DIR__ . '/../views/admin/sidebarQL.php';
        require_once __DIR__ . '/../views/admin/dvtg/adminDVTG.php';
    }
    public function showDVTG($id)
    {
        $DVTG = $this->dvtgModel->getDVTG_ByID($id);
        if ($DVTG) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            include_once __DIR__ . '/../views/admin/dvtg/showDVTG.php';
        } else {
            echo "Dịch vụ này không tồn tại.";
        }
    }

    public function addDVTG()
    {
        include_once __DIR__ . '/../views/admin/dvtg/addDVTG.php';
    }

    public function saveDVTG()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenTG = $_POST['TenTG'] ?? '';
            $GiaTG = $_POST['GiaTG'] ?? '';
            $ThoiGianTG = $_POST['ThoiGianTG'] ?? '';
            $MoTaTG = $_POST['MoTaTG'] ?? '';

            $result = $this->dvtgModel->addDVTG($TenTG, $GiaTG, $ThoiGianTG, $MoTaTG);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/admin/sidebarQL.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/admin/DvThuGian');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm dịch vụ. Vui lòng thử lại.";
            }
        }
    }

    public function editDVTG($id)
    {
        $DVTG = $this->dvtgModel->getDVTG_ByID($id);
        if ($DVTG) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            include_once __DIR__ . '/../views/admin/dvtg/editDVTG.php';
        } else {
            echo "Dịch vụ này không tồn tại.";
        }
    }

    public function updateDVTG()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $TenTG = $_POST['TenTG'];
            $GiaTG = $_POST['GiaTG'];
            $ThoiGianTG = $_POST['ThoiGianTG'];
            $MoTaTG = $_POST['MoTaTG'] ?? '';

            $edit = $this->dvtgModel->updateDVTG($id, $TenTG, $GiaTG, $ThoiGianTG, $MoTaTG);
            if ($edit) {
                header('Location: /gym/admin/DvThuGian');
            } else {
                echo "Cập nhật dịch vụ không thành công.";
            }
        }
    }

    public function deleteDVTG($id)
    {
        if ($this->dvtgModel->deleteDVTG($id)) {
            header('Location: /gym/admin/DvThuGian');
        } else {
            echo "Xóa dịch vụ không thành công.";
        }
    }

    //Lớp học---------------------------------------------------------------------------------------------------------------
    public function indexLopHoc()
    {
        $lophocs = $this->lophocModel->getDVTLs();

        require_once __DIR__ . '/../views/admin/sidebarQL.php';
        require_once __DIR__ . '/../views/admin/lophoc/adminLopHoc.php';
    }
    public function showLopHoc($id)
    {
        $lophoc = $this->lophocModel->getDVTL_ByID($id);
        if ($lophoc) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/lophoc/showLopHoc.php';
        } else {
            echo "Lớp học không tồn tại.";
        }
    }

    public function addLopHoc()
    {
        include_once __DIR__ . '/../views/admin/goitap/addLopHoc.php';
    }

    public function saveLopHoc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenTL = $_POST['TenTL'] ?? '';
            $GiaTL = $_POST['GiaTL'] ?? '';
            $ThoiGianTL = $_POST['ThoiGianTL'] ?? '';
            $MoTaTL = $_POST['MoTaTL'] ?? '';

            $result = $this->lophocModel->addDVTL($TenTL, $GiaTL, $ThoiGianTL, $MoTaTL);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/admin/sidebarQL.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/admin/lophoc');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm lớp học. Vui lòng thử lại.";
            }
        }
    }

    public function editLopHoc($id)
    {
        $lophoc = $this->lophocModel->getDVTL_ByID($id);
        if ($lophoc) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/lophoc/editLopHoc.php';
        } else {
            echo "Lớp học không tồn tại.";
        }
    }

    public function updateLopHoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $TenTL = $_POST['TenTL'] ?? '';
            $GiaTL = $_POST['GiaTL'] ?? '';
            $ThoiGianTL = $_POST['ThoiGianTL'] ?? '';
            $MoTaTL = $_POST['MoTaTL'] ?? '';

            $edit = $this->lophocModel->updateDVTL($id, $TenTL, $GiaTL, $ThoiGianTL, $MoTaTL);
            if ($edit) {
                header('Location: /gym/admin/lophoc');
            } else {
                echo "Cập nhật lớp học không thành công.";
            }
        }
    }

    public function deleteLopHoc($id)
    {
        if ($this->lophocModel->deleteDVTL($id)) {
            header('Location: /gym/admin/lophoc');
        } else {
            echo "Xóa lớp học không thành công.";
        }
    }
//Hội viên---------------------------------------------------------------------------------------------------------------

    public function indexUser() 
    {
        $hoiVien = $this->hoiVienModel->getAllHoiVien();
        $goiTap = $this->goitapModel->getGoiTaps();
        require_once __DIR__ . '/../views/admin/sidebarQL.php';
        require_once __DIR__ . '/../views/admin/user/adminHoiVien.php';
    }
    public function showUser($maHV)
    {
        $hoiVien = $this->hoiVienModel->getHoiVienById($maHV);
        if ($hoiVien) {
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/user/showHoiVien.php';
        } else {
            echo "Hội viên không tồn tại.";
        }
    }
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $HoTen = $_POST['HoTen'];
            $NgaySinh = $_POST['NgaySinh'];
            $GioiTinh = $_POST['GioiTinh'];
            $SDT = $_POST['SDT'];
            $Email = $_POST['Email'];
            $DiaChi = $_POST['DiaChi'];
            $MaGoiTap = $_POST['MaGoiTap'];
            if ($this->hoiVienModel->addHoiVien($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $MaGoiTap)) {
                header('Location: /gym/admin/user');
                exit;
            }
        }

        $goiTap = $this->goitapModel->getGoiTaps();
        require_once __DIR__ . '/../views/admin/user/addHoiVien.php';
        require_once __DIR__ . '/../views/admin/sidebarQL.php';
    }
    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $HoTen = $_POST['HoTen'] ?? '';
                $NgaySinh = $_POST['NgaySinh'] ?? null;
                $GioiTinh = $_POST['GioiTinh'] ?? null;
                $SDT = $_POST['SDT'] ?? null;
                $Email = $_POST['Email'] ?? null;
                $DiaChi = $_POST['DiaChi'] ?? null;
                $MaGoiTap = $_POST['MaGoiTap'] ?? null;

                $result = $this->hoiVienModel->addHoiVien($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $MaGoiTap);

                if ($result) {
                    $_SESSION['success'] = "Thêm hội viên thành công";
                    header('Location: /gym/admin/user');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $goiTap = $this->goitapModel->getGoiTaps();
                require_once __DIR__ . '/../views/admin/sidebarQL.php';
                require_once __DIR__ . '/../views/admin/user/addHoiVien.php';
            }
        }
    }

    public function editUser($maHV) {
        try {
            // Lấy thông tin hội viên
            $hoiVien = $this->hoiVienModel->getHoiVienById($maHV);
            if (!$hoiVien) {
                // Nếu không tìm thấy hội viên, chuyển hướng về trang danh sách
                header('Location: /gym/admin/user');
                exit;
            }

            // Lấy danh sách gói tập
            $goiTap = $this->goitapModel->getGoiTaps();

            // Load view
            require_once __DIR__ . '/../views/admin/sidebarQL.php';
            require_once __DIR__ . '/../views/admin/user/editHoiVien.php';
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            error_log("Error in editUser: " . $e->getMessage());
            header('Location: /gym/admin/user');
            exit;
        }
    }
    public function updateUser($maHV) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $HoTen = $_POST['HoTen'];
            $NgaySinh = $_POST['NgaySinh'];
            $GioiTinh = $_POST['GioiTinh'];
            $SDT = $_POST['SDT'];
            $Email = $_POST['Email'];
            $DiaChi = $_POST['DiaChi'];
            $MaGoiTap = $_POST['MaGoiTap'];
            $TrangThai = $_POST['TrangThai'];

            if ($this->hoiVienModel->updateHoiVien($maHV, $HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $MaGoiTap, $TrangThai)) {
                header('Location: /gym/admin/user');
            } else {
                echo "Cập nhật hội viên không thành công.";
            }
        }
    }

    public function deleteUser($maHV) {
        if ($this->hoiVienModel->deleteHoiVien($maHV)) {
            header('Location: /gym/admin/user');
            exit;
        }
    }

    public function searchUser() {
        $keyword = $_GET['keyword'] ?? '';
        $hoiVien = $this->hoiVienModel->searchHoiVien($keyword);
        require_once __DIR__ . '/../views/admin/user/adminHoiVien.php';
    }
}
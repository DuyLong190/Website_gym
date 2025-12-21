<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/DvThuGianModel.php';
require_once __DIR__ . '/../models/LopHoc_Model.php';
require_once __DIR__ . '/../models/LichLopHocModel.php';
require_once __DIR__ . '/../models/CauHinhLichHocModel.php';
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../models/PtModel.php';
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/ChiTiet_Goitap_Model.php';
require_once __DIR__ . '/../models/YeuCauThanhToanModel.php';
require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/DangKyDichVuModel.php';
require_once __DIR__ . '/../models/ThanhToanHoaDonModel.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class AdminController
{
    private $dvtgModel;
    private $goitapModel;
    private $lophocModel;
    private $lichLopHocModel;
    private $cauHinhLichHocModel;
    private $db;
    private $hoiVienModel;
    private $ptModel;
    private $accountModel;
    private $ctgtModel;
    private $yeuCauThanhToanModel;
    private $dangKyLopHocModel;
    private $dangKyDichVuModel;
    private $thanhToanHoaDonModel;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->goitapModel = new GoiTapModel($this->db);
        $this->dvtgModel = new DvThuGianModel($this->db);
        $this->lophocModel = new LopHoc_Model($this->db);
        $this->lichLopHocModel = new LichLopHocModel($this->db);
        $this->cauHinhLichHocModel = new CauHinhLichHocModel($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
        $this->ptModel = new PtModel($this->db);
        $this->accountModel = new AccountModel($this->db);
        $this->ctgtModel = new ChiTiet_Goitap_Model($this->db);
        $this->yeuCauThanhToanModel = new YeuCauThanhToanModel($this->db);
        $this->dangKyLopHocModel = new DangKyLopHocModel($this->db);
        $this->dangKyDichVuModel = new DangKyDichVuModel($this->db);
        $this->thanhToanHoaDonModel = new ThanhToanHoaDonModel($this->db);
    }
    //Gói tập----------------------------------------------------------------------------------------------------------------------
    public function indexGoitap()
    {
        $goiTaps = $this->goitapModel->getGoiTaps();
        
        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/goitap/adminGoiTap.php';
        $content = ob_get_clean();
        
        // Lấy nội dung sidebar
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
        $sidebar = ob_get_clean();
        
        // Tách phần head (CSS và script) từ sidebar
        if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
            $headContent = $headMatches[1];
            // Chèn CSS và script vào head của adminGoiTap (trước thẻ </head>)
            $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
        }
        
        // Tách phần navbar từ body của sidebar
        if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
            $navbarContent = $bodyMatches[1];
            // Chèn navbar vào body của adminGoiTap (ngay sau thẻ <body>)
            $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
        }
        
        echo $content;
    }

    public function showGoiTap($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            ob_start();
            require_once __DIR__ . '/../views/admin/goitap/showGoiTap.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
                require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
            ob_start();
            require_once __DIR__ . '/../views/admin/goitap/editGoiTap.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
    public function indexDichVu()
    {
        $DVTGs = $this->dvtgModel->getDVTGs();

        ob_start();
        require_once __DIR__ . '/../views/admin/dichvu/adminDVTG.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
    public function showDVTG($id)
    {
        $DVTG = $this->dvtgModel->getDVTG_ByID($id);
        if ($DVTG) {
            ob_start();
            require_once __DIR__ . '/../views/admin/dichvu/showDVTG.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
        } else {
            echo "Dịch vụ này không tồn tại.";
        }
    }

    public function addDVTG()
    {
        include_once __DIR__ . '/../views/admin/dichvu/addDVTG.php';
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
                require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/admin/dichvu');
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
            ob_start();
            require_once __DIR__ . '/../views/admin/dichvu/editDVTG.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
                header('Location: /gym/admin/dichvu');
            } else {
                echo "Cập nhật dịch vụ không thành công.";
            }
        }
    }

    public function deleteDVTG($id)
    {
        if ($this->dvtgModel->deleteDVTG($id)) {
            header('Location: /gym/admin/dichvu');
        } else {
            echo "Xóa dịch vụ không thành công.";
        }
    }

    //Lớp học---------------------------------------------------------------------------------------------------------------
    public function indexLopHoc()
    {
        $lophocs = $this->lophocModel->getLopHocs();
        ob_start();
        require_once __DIR__ . '/../views/admin/lophoc/adminLopHoc.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
    public function showLopHoc($id)
    {
        $lophoc = $this->lophocModel->getLopHoc_ByID($id);
        if ($lophoc) {
            ob_start();
            require_once __DIR__ . '/../views/admin/lophoc/showLopHoc.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
            // Lấy dữ liệu từ form (tên trường phù hợp với view)
            $TenLop = $_POST['TenLop'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? 0;
            $MoTa = $_POST['MoTa'] ?? null;
            $NgayBatDau = $_POST['NgayBatDau'] ?? null;
            $NgayKetThuc = $_POST['NgayKetThuc'] ?? null;
            $SoLuongToiDa = $_POST['SoLuongToiDa'] ?? null;
            $TrangThai = $_POST['TrangThai'] ?? null;

            $result = $this->lophocModel->addLopHoc($TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc,$SoLuongToiDa, $TrangThai);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi và dữ liệu cũ
                $errors = $result;
                // có thể tái sử dụng biến để prefill form
                $old = compact('TenLop', 'GiaTien', 'MoTa', 'NgayBatDau', 'NgayKetThuc', 'SoLuongToiDa', 'TrangThai');

                $_SESSION['errors_lophoc_add'] = $errors;
                $_SESSION['old_lophoc_add'] = $old;

                header('Location: /gym/admin/lophoc');
                exit();
            } else if ($result) {
                // Nếu thêm thành công (trả về id mới), chuyển hướng về danh sách
                $_SESSION['success'] = "Thêm lớp học thành công.";
                header('Location: /gym/admin/lophoc');
                exit();
            } else {
                // Nếu có lỗi khác
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm lớp học. Vui lòng thử lại.";
                header('Location: /gym/admin/lophoc');
                exit();
            }
        } else {
            header('Location: /gym/admin/lophoc');
            exit;
        }
    }

    public function editLopHoc($MaLop)
    {
        $lophoc = $this->lophocModel->getLopHoc_ByID($MaLop);
        if ($lophoc) {
            ob_start();
            require_once __DIR__ . '/../views/admin/lophoc/editLopHoc.php';
            $content = ob_get_clean();

            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
        } else {
            echo "Lớp học không tồn tại.";
        }
    }

    public function updateLopHoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaLop = $_POST['MaLop'] ?? null;
            $TenLop = $_POST['TenLop'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? 0;
            $MoTa = $_POST['MoTa'] ?? null;
            $NgayBatDau = $_POST['NgayBatDau'] ?? null;
            $NgayKetThuc = $_POST['NgayKetThuc'] ?? null;
            $SoLuongToiDa = $_POST['SoLuongToiDa'] ?? null;
            $TrangThai = $_POST['TrangThai'] ?? null;

            if (empty($MaLop)) {
                $_SESSION['error'] = "ID lớp học không hợp lệ.";
                header('Location: /gym/admin/lophoc');
                exit;
            }

            $ok = $this->lophocModel->updateLopHoc($MaLop, $TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $SoLuongToiDa, $TrangThai);
            if ($ok) {
                $_SESSION['success'] = "Cập nhật lớp học thành công.";
                header('Location: /gym/admin/lophoc');
                exit;
            } else {
                $_SESSION['error'] = "Cập nhật lớp học không thành công.";
                header('Location: /gym/admin/lophoc');
                exit;
            }
        } else {
            header('Location: /gym/admin/lophoc');
            exit;
        }
    }

    public function deleteLopHoc($MaLop)
    {
        if ($this->lophocModel->deleteLopHoc($MaLop)) {
            header('Location: /gym/admin/lophoc');
        } else {
            echo "Xóa lớp học không thành công.";
        }
    }

    public function danhSachDangKy($MaLop)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        $lophoc = $this->lophocModel->getLopHoc_ByID($MaLop);
        if (!$lophoc) {
            $_SESSION['error'] = 'Lớp học không tồn tại.';
            header('Location: /gym/admin/lophoc');
            exit;
        }

        $danhSachDangKy = $this->dangKyLopHocModel->getActiveMembersByLop($MaLop);
        
        ob_start();
        require_once __DIR__ . '/../views/admin/lophoc/danhSachDangKy.php';
        $content = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function exportExcelDangKy($MaLop)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        $lophoc = $this->lophocModel->getLopHoc_ByID($MaLop);
        if (!$lophoc) {
            $_SESSION['error'] = 'Lớp học không tồn tại.';
            header('Location: /gym/admin/lophoc');
            exit;
        }

        $danhSachDangKy = $this->dangKyLopHocModel->getActiveMembersByLop($MaLop);

        $tenLop = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $lophoc->TenLop);
        $filename = 'DanhSachDangKy_' . $tenLop . '_' . date('Y-m-d_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        echo "\xEF\xBB\xBF"; // UTF-8 BOM để Excel đọc tiếng Việt 
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        echo '<style>
            table {
                border-collapse: collapse;
                width: 100%;
                font-family: "Times New Roman", Times, serif;
            }
            th {
                background-color: #4F46E5;
                color: white;
                font-weight: bold;
                padding: 8px;
                border: 1px solid #ddd;
                text-align: center;
                font-family: "Times New Roman", Times, serif;
            }
            td {
                padding: 8px;
                border: 1px solid #ddd;
                font-family: "Times New Roman", Times, serif;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
        </style>';
        echo '</head>';
        echo '<body>';
        echo '<table>';

        // Header
        echo '<tr>';
        echo '<th>STT</th>';
        echo '<th>Họ tên</th>';
        echo '<th>Số điện thoại</th>';
        echo '<th>Email</th>';
        echo '<th>Địa chỉ</th>';
        echo '<th>Ngày đăng ký</th>';
        echo '</tr>';

        // Dữ liệu
        $stt = 1;
        foreach ($danhSachDangKy as $dangKy) {
            $ngayDangKy = '';
            if (!empty($dangKy['created_at'])) {
                $date = new DateTime($dangKy['created_at']);
                $ngayDangKy = $date->format('d/m/Y H:i');
            }

            echo '<tr>';
            echo '<td>' . htmlspecialchars($stt++, ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($dangKy['HoTen'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($dangKy['SDT'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($dangKy['Email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($dangKy['DiaChi'] ?? 'Chưa có', ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>' . htmlspecialchars($ngayDangKy, ENT_QUOTES, 'UTF-8') . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</body>';
        echo '</html>';
        exit;
    }
    // Cấu hình lịch học----------------------------------------------------------------------------------------------------------
    public function indexCauhinhlichhoc()
    {
        $cauhinhs = $this->cauHinhLichHocModel->getAll();
        $lophocs = $this->lophocModel->getLopHocs();

        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/lichlophoc/adminCauHinhLichHoc.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function saveCauhinhlichhoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaLop = $_POST['MaLop'] ?? null;
            $ThuTrongTuan = $_POST['ThuTrongTuan'] ?? null;
            $GioBatDau = $_POST['GioBatDau'] ?? null;
            $GioKetThuc = $_POST['GioKetThuc'] ?? null;
            $PhongHocMacDinh = $_POST['PhongHocMacDinh'] ?? null;

            $result = $this->cauHinhLichHocModel->create($MaLop, $ThuTrongTuan, $GioBatDau, $GioKetThuc, $PhongHocMacDinh);

            if (is_array($result)) {
                $_SESSION['errors'] = $result;
            } elseif ($result) {
                $_SESSION['success'] = 'Thêm cấu hình lịch học thành công.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thêm cấu hình lịch học.';
            }

            header('Location: /gym/admin/cauhinhlichhoc');
            exit;
        }

        header('Location: /gym/admin/cauhinhlichhoc');
        exit;
    }

    public function updateCauhinhlichhoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $MaLop = $_POST['MaLop'] ?? null;
            $ThuTrongTuan = $_POST['ThuTrongTuan'] ?? null;
            $GioBatDau = $_POST['GioBatDau'] ?? null;
            $GioKetThuc = $_POST['GioKetThuc'] ?? null;
            $PhongHocMacDinh = $_POST['PhongHocMacDinh'] ?? null;

            if (empty($id)) {
                $_SESSION['error'] = 'ID cấu hình không hợp lệ.';
                header('Location: /gym/admin/cauhinhlichhoc');
                exit;
            }

            $result = $this->cauHinhLichHocModel->update($id, $MaLop, $ThuTrongTuan, $GioBatDau, $GioKetThuc, $PhongHocMacDinh);

            if (is_array($result)) {
                $_SESSION['errors'] = $result;
            } elseif ($result) {
                $_SESSION['success'] = 'Cập nhật cấu hình lịch học thành công.';
            } else {
                $_SESSION['error'] = 'Cập nhật cấu hình lịch học không thành công.';
            }

            header('Location: /gym/admin/cauhinhlichhoc');
            exit;
        }

        header('Location: /gym/admin/cauhinhlichhoc');
        exit;
    }

    public function deleteCauhinhlichhoc($id)
    {
        if ($this->cauHinhLichHocModel->delete($id)) {
            $_SESSION['success'] = 'Xóa cấu hình lịch học thành công.';
        } else {
            $_SESSION['error'] = 'Xóa cấu hình lịch học không thành công.';
        }

        header('Location: /gym/admin/cauhinhlichhoc');
        exit;
    }

    // Lịch lớp học---------------------------------------------------------------------------------------------------------------
    public function indexLichlophoc()
    {
        $lichLopHocs = $this->lichLopHocModel->getAll();
        $lophocs = $this->lophocModel->getLopHocs();

        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/lichlophoc/adminLichLopHoc.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function saveLichLopHoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaLop = $_POST['MaLop'] ?? null;
            $NgayHoc = $_POST['NgayHoc'] ?? null;
            $GioBatDau = $_POST['GioBatDau'] ?? null;
            $GioKetThuc = $_POST['GioKetThuc'] ?? null;
            $PhongHoc = $_POST['PhongHoc'] ?? null;

            $result = $this->lichLopHocModel->create($MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc);

            if (is_array($result)) {
                $_SESSION['errors'] = $result;
            } elseif ($result) {
                $_SESSION['success'] = 'Thêm lịch lớp học thành công.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thêm lịch lớp học.';
            }

            header('Location: /gym/admin/lichlophoc');
            exit;
        }

        header('Location: /gym/admin/lichlophoc');
        exit;
    }

    public function updateLichLopHoc()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $MaLop = $_POST['MaLop'] ?? null;
            $NgayHoc = $_POST['NgayHoc'] ?? null;
            $GioBatDau = $_POST['GioBatDau'] ?? null;
            $GioKetThuc = $_POST['GioKetThuc'] ?? null;
            $PhongHoc = $_POST['PhongHoc'] ?? null;

            if (empty($id)) {
                $_SESSION['error'] = 'ID lịch lớp học không hợp lệ.';
                header('Location: /gym/admin/lichlophoc');
                exit;
            }

            $result = $this->lichLopHocModel->update($id, $MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc);

            if (is_array($result)) {
                $_SESSION['errors'] = $result;
            } elseif ($result) {
                $_SESSION['success'] = 'Cập nhật lịch lớp học thành công.';
            } else {
                $_SESSION['error'] = 'Cập nhật lịch lớp học không thành công.';
            }

            header('Location: /gym/admin/lichlophoc');
            exit;
        }
    }

    public function deleteLichLopHoc($id)
    {
        if ($this->lichLopHocModel->delete($id)) {
            $_SESSION['success'] = 'Xóa lịch lớp học thành công.';
        } else {
            $_SESSION['error'] = 'Xóa lịch lớp học không thành công.';
        }

        header('Location: /gym/admin/lichlophoc');
        exit;
    }
    public function generateLichFromCauHinh()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaLop = $_POST['MaLop'] ?? null;

            if (empty($MaLop) || !is_numeric($MaLop)) {
                $_SESSION['error'] = 'Mã lớp không hợp lệ.';
                header('Location: /gym/admin/lichlophoc');
                exit;
            }

            $result = $this->lichLopHocModel->generateFromCauHinhByMaLop($MaLop);

            if ($result === false) {
                $_SESSION['error'] = 'Không thể sinh lịch từ cấu hình. Vui lòng kiểm tra lại cấu hình và khoảng ngày của lớp học.';
            } elseif ($result === 0) {
                $_SESSION['success'] = 'Không có lịch mới nào được tạo. Có thể chưa có cấu hình hoặc các lịch đã tồn tại.';
            } else {
                $_SESSION['success'] = 'Đã tạo ' . (int)$result . ' lịch học từ cấu hình.';
            }

            header('Location: /gym/admin/lichlophoc');
            exit;
        }

        header('Location: /gym/admin/lichlophoc');
        exit;
    }
//Hội viên---------------------------------------------------------------------------------------------------------------
    public function indexUser() 
    {
        $hoiVien = $this->hoiVienModel->getAllHoiVien();
        $goiTap = $this->goitapModel->getGoiTaps();

        // Thêm thông tin thanh toán vào mỗi hội viên
        foreach ($hoiVien as $hv) {
            $currentPackage = $this->ctgtModel->getActiveByMaHV((int)$hv->MaHV);
            // Nếu không có gói chưa hủy, tìm gói đã thanh toán
            if (!$currentPackage) {
                $allPackages = $this->ctgtModel->getAllByMaHV((int)$hv->MaHV);
                foreach ($allPackages as $package) {
                    $daThanhToan = (int)($package['DaThanhToan'] ?? 0);
                    if ($daThanhToan === 1) {
                        $currentPackage = $package;
                        break;
                    }
                }
            }
            // Thêm thông tin thanh toán vào object hội viên
            $hv->DaThanhToan = $currentPackage ? (int)($currentPackage['DaThanhToan'] ?? 0) : 0;
        }

        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/hoivien/adminHoiVien.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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
    public function showUser($maHV)
    {
        $hoiVien = $this->hoiVienModel->getHoiVienById($maHV);
        if ($hoiVien) {
            // Lấy chi tiết gói tập hiện tại (nếu có) để hiển thị và xác minh thanh toán
            $currentCtgt = $this->ctgtModel->getCurrentByMaHV((int)$maHV);
            ob_start();
            require_once __DIR__ . '/../views/admin/hoivien/showHoiVien.php';
            $content = ob_get_clean();

            
            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
            $sidebar = ob_get_clean();

            if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
                $headContent = $headMatches[1];
                // Chèn CSS và script vào head của adminGoiTap (trước thẻ </head>)
                $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
            }

            // Tách phần navbar từ body của sidebar
            if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
                $navbarContent = $bodyMatches[1];
                // Chèn navbar vào body của adminGoiTap (ngay sau thẻ <body>)
                $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
            }

            echo $content;
        } else {
            echo "Hội viên không tồn tại.";
        }
    }
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $HoTen = $_POST['HoTen'];
            $NgaySinh = $_POST['NgaySinh'];
            $GioiTinh = $_POST['GioiTinh'];
            $ChieuCao = $_POST['ChieuCao'];
            $CanNang = $_POST['CanNang'];
            $SDT = $_POST['SDT'];
            $Email = $_POST['Email'];
            $DiaChi = $_POST['DiaChi'];
            if ($this->hoiVienModel->addHoiVien($HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi)) {
                header('Location: /gym/admin/user');
                exit;
            }
        }

        $goiTap = $this->goitapModel->getGoiTaps();
        require_once __DIR__ . '/../views/admin/hoivien/addHoiVien.php';
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
    }
    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Xử lý upload ảnh nếu có
                $imagePath = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    try {
                        $imagePath = $this->handleImageUpload('image');
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        $goiTap = $this->goitapModel->getGoiTaps();
                        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
                        require_once __DIR__ . '/../views/admin/hoivien/addHoiVien.php';
                        return;
                    }
                }

                $HoTen = $_POST['HoTen'] ?? '';
                $NgaySinh = $_POST['NgaySinh'] ?? null;
                $GioiTinh = $_POST['GioiTinh'] ?? null;
                $ChieuCao = $_POST['ChieuCao'] ?? null;
                $CanNang = $_POST['CanNang'] ?? null;
                $SDT = $_POST['SDT'] ?? null;
                $Email = $_POST['Email'] ?? null;
                $DiaChi = $_POST['DiaChi'] ?? null;
                $result = $this->hoiVienModel->addHoiVien($HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $imagePath);

                if ($result) {
                    $_SESSION['success'] = "Thêm hội viên thành công";
                    header('Location: /gym/admin/user');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $goiTap = $this->goitapModel->getGoiTaps();
                require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
                require_once __DIR__ . '/../views/admin/hoivien/addHoiVien.php';
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
            $goiTap = $this->goitapModel->getGoiTaps();
            
            // Lấy gói tập hiện tại của hội viên để hiển thị thông tin hủy gói
            $currentCtgt = $this->ctgtModel->getCurrentByMaHV((int)$maHV);

            ob_start();
            require_once __DIR__ . '/../views/admin/hoivien/editHoiVien.php';
            $content = ob_get_clean();

            
            ob_start();
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
            $sidebar = ob_get_clean();

            
            if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
                $headContent = $headMatches[1];
                $content = preg_replace('/(<\/head>)/', $headContent . '$1', $content, 1);
            }

            // Tách phần navbar từ body của sidebar
            if (preg_match('/<body>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
                $navbarContent = $bodyMatches[1];
                $content = preg_replace('/(<body[^>]*>)/', '$1' . $navbarContent, $content, 1);
            }

            echo $content;
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            error_log("Error in editUser: " . $e->getMessage());
            header('Location: /gym/admin/user');
            exit;
        }
    }
    public function updateUser($maHV) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Lấy thông tin hội viên hiện tại
                $currentHoiVien = $this->hoiVienModel->getHoiVienById($maHV);
                $oldImagePath = $currentHoiVien->image ?? null;

                // Xử lý upload ảnh nếu có
                $imagePath = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    try {
                        $imagePath = $this->handleImageUpload('image', $oldImagePath);
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        header('Location: /gym/admin/user/editUser/' . $maHV);
                        exit;
                    }
                }

                $HoTen = $_POST['HoTen'];
                $NgaySinh = $_POST['NgaySinh'];
                $GioiTinh = $_POST['GioiTinh'];
                $ChieuCao = $_POST['ChieuCao'];
                $CanNang = $_POST['CanNang'];
                $SDT = $_POST['SDT'];
                $Email = $_POST['Email'];
                $DiaChi = $_POST['DiaChi'];
                $TrangThai = $_POST['TrangThai'];

                $this->db->beginTransaction();

                // Chỉ cập nhật image nếu có ảnh mới (nếu $imagePath !== null)
                $okUpdate = $this->hoiVienModel->updateHoiVien($maHV, $HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $TrangThai, $imagePath);
                if (!$okUpdate) {
                    throw new Exception('Không thể cập nhật hội viên');
                }

                $this->db->commit();
                header('Location: /gym/admin/user');
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                error_log('AdminController::updateUser error - ' . $e->getMessage());
                echo "Cập nhật hội viên không thành công.";
            }
        }
    }

    public function deleteUser($maHV) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        try {
            // Kiểm tra hội viên có tồn tại không
            $hoiVien = $this->hoiVienModel->getHoiVienById($maHV);
            if (!$hoiVien) {
                $_SESSION['error'] = 'Hội viên không tồn tại.';
                header('Location: /gym/admin/user');
                exit;
            }

            // Bắt đầu transaction để đảm bảo xóa an toàn
            $this->db->beginTransaction();

            // Xóa các bảng liên quan trước (nếu có)
            // 1. Xóa YeuCauThanhToan (không có CASCADE)
            $stmtYeuCau = $this->db->prepare("DELETE FROM YeuCauThanhToan WHERE MaHV = :maHV");
            $stmtYeuCau->bindParam(':maHV', $maHV, PDO::PARAM_INT);
            $stmtYeuCau->execute();

            // 2. Xóa Account liên kết với hội viên
            $stmtAccount = $this->db->prepare("DELETE FROM Account WHERE MaHV = :maHV");
            $stmtAccount->bindParam(':maHV', $maHV, PDO::PARAM_INT);
            $stmtAccount->execute();

            // 3. Xóa hội viên (ChiTiet_GoiTap và DangKyLopHoc sẽ tự động xóa do CASCADE)
            $ok = $this->hoiVienModel->deleteOnlyHoiVien($maHV);
            if (!$ok) {
                throw new Exception('Không thể xóa hội viên. Có thể có ràng buộc dữ liệu.');
            }

            $this->db->commit();
            $_SESSION['success'] = 'Xóa hội viên thành công!';
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Lỗi khi xóa hội viên: ' . $e->getMessage();
            error_log('AdminController::deleteUser error - ' . $e->getMessage());
        }

        header('Location: /gym/admin/user');
        exit;
    }

    public function indexDangky()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
            $id = (int)$_POST['deleteId'];
            if ($id > 0) {
                try {
                    $stmtUpd = $this->db->prepare("UPDATE DangKyLopHoc SET TrangThai = 'Huy', updated_at = NOW() WHERE id = :id");
                    $stmtUpd->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtUpd->execute();
                } catch (PDOException $e) {
                    error_log('AdminController::indexDangky cancel error - ' . $e->getMessage());
                }
            }

            header('Location: /gym/admin/dangky');
            exit;
        }

        try {
            $sqlHv = "SELECT d.*, h.HoTen AS TenHV, l.TenLop, l.SoLuongToiDa,
                             (SELECT COUNT(*) FROM DangKyLopHoc d2
                              WHERE d2.MaLop = d.MaLop AND d2.TrangThai = 'DangKy') AS SoDangKy
                      FROM DangKyLopHoc d
                      LEFT JOIN HoiVien h ON d.MaHV = h.MaHV
                      LEFT JOIN LopHoc l ON d.MaLop = l.MaLop
                      ORDER BY d.created_at DESC";
            $stmtHv = $this->db->prepare($sqlHv);
            $stmtHv->execute();
            $dangkyHv = $stmtHv->fetchAll(PDO::FETCH_ASSOC);

            $sqlPt = "SELECT p.*, pt.HoTen AS TenPT, l.TenLop
                      FROM PtDayHoc p
                      LEFT JOIN pt ON p.pt_id = pt.pt_id
                      LEFT JOIN LopHoc l ON p.MaLop = l.MaLop
                      ORDER BY p.created_at DESC";
            $stmtPt = $this->db->prepare($sqlPt);
            $stmtPt->execute();
            $dangkyPt = $stmtPt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('AdminController::indexDangky - ' . $e->getMessage());
            $dangkyHv = [];
            $dangkyPt = [];
        }
        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/dangky/indexDangky.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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


    // Quản lý yêu cầu thanh toán ----------------------------------------------------------------------

    public function indexYeucau()
    {
        // Mặc định chỉ admin truy cập được, nếu bạn đã có check quyền ở sidebar/menu có thể bỏ qua
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        $yeuCaus = $this->yeuCauThanhToanModel->getPending();
        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/yeucau/indexYeucau.php';
        $content = ob_get_clean();
        
        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function confirmYeuCau($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/yeucau');
            exit;
        }

        $yc = $this->yeuCauThanhToanModel->getDetailById((int)$id);
        if (!$yc) {
            $_SESSION['error'] = 'Không tìm thấy yêu cầu thanh toán.';
            header('Location: /gym/admin/yeucau');
            exit;
        }

        $loai = $yc['Loai'] ?? '';
        $maHV = (int)($yc['MaHV'] ?? 0);

        if (empty($loai) || $maHV <= 0) {
            $_SESSION['error'] = 'Dữ liệu yêu cầu thanh toán không hợp lệ.';
            header('Location: /gym/admin/yeucau');
            exit;
        }

        try {
            $this->db->beginTransaction();

            // Xử lý theo từng loại
            if ($loai === 'GoiTap') {
                // Xử lý yêu cầu thanh toán cho gói tập
                $id_ctgt = (int)($yc['id_ctgt'] ?? 0);
                if ($id_ctgt <= 0) {
                    throw new Exception('Không tìm thấy chi tiết gói tập.');
                }

                // Lấy thông tin chi tiết gói tập để có MaGoiTap
                $chiTietArr = $this->ctgtModel->getChiTietById($id_ctgt);
                if (empty($chiTietArr)) {
                    throw new Exception('Không tìm thấy chi tiết gói tập.');
                }
                $chiTiet = $chiTietArr[0];
                $maGoiTap = (int)($chiTiet['MaGoiTap'] ?? 0);
                
                if ($maGoiTap <= 0) {
                    throw new Exception('Dữ liệu gói tập không hợp lệ.');
                }

                // Cập nhật chi tiết gói tập: set ngày bắt đầu/kết thúc, trạng thái, thanh toán
                $okCtgt = $this->ctgtModel->confirmPayment($id_ctgt);
                if (!$okCtgt) {
                    throw new Exception('Không thể cập nhật chi tiết gói tập hoặc đã được xác nhận trước đó.');
                }

                $successMessage = 'Xác nhận yêu cầu thanh toán thành công. Gói tập đã được kích hoạt cho hội viên.';

            } elseif ($loai === 'DichVu') {
                // Xử lý yêu cầu thanh toán cho dịch vụ - tạo DangKyDichVu từ thông tin trong GhiChu
                $id_dv = (int)($yc['id_dv'] ?? 0);
                $ngaySuDung = $yc['NgaySuDung'] ?? '';
                $gioSuDung = $yc['GioSuDung'] ?? '';
                $ghiChuDichVu = $yc['GhiChuDichVu'] ?? null;

                if ($id_dv <= 0 || empty($ngaySuDung) || empty($gioSuDung)) {
                    throw new Exception('Thông tin dịch vụ không đầy đủ.');
                }

                // Tạo đăng ký dịch vụ với trạng thái đã xác nhận và đã thanh toán
                $id_dangky_dv = $this->dangKyDichVuModel->createDangKy($maHV, $id_dv, $ngaySuDung, $gioSuDung, $ghiChuDichVu);
                if (!$id_dangky_dv) {
                    throw new Exception('Không thể tạo đăng ký dịch vụ.');
                }

                // Cập nhật trạng thái đã xác nhận và đã thanh toán
                $query = "UPDATE DangKyDichVu 
                         SET DaThanhToan = 1, TrangThai = 'Đã xác nhận', updated_at = NOW()
                         WHERE id = :id_dangky";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_dangky', $id_dangky_dv, PDO::PARAM_INT);
                $stmt->execute();

                // Cập nhật id_dangky_dv vào YeuCauThanhToan để liên kết
                $updateYc = "UPDATE YeuCauThanhToan 
                            SET id_dangky_dv = :id_dangky_dv 
                            WHERE id = :id_yc";
                $stmtYc = $this->db->prepare($updateYc);
                $stmtYc->bindParam(':id_dangky_dv', $id_dangky_dv, PDO::PARAM_INT);
                $stmtYc->bindParam(':id_yc', $id, PDO::PARAM_INT);
                $stmtYc->execute();

                $successMessage = 'Xác nhận yêu cầu thanh toán thành công. Dịch vụ đã được kích hoạt cho hội viên.';

            } elseif ($loai === 'LopHoc') {
                // Xử lý yêu cầu thanh toán cho lớp học - tạo DangKyLopHoc từ thông tin trong GhiChu
                $maLop = (int)($yc['MaLop'] ?? 0);
                if ($maLop <= 0) {
                    throw new Exception('Thông tin lớp học không hợp lệ.');
                }

                // Kiểm tra lớp học có tồn tại không
                $lopHocStmt = $this->db->prepare("SELECT MaLop, SoLuongToiDa, COALESCE(SoLuongHienTai, 0) AS SoLuongHienTai FROM LopHoc WHERE MaLop = :MaLop");
                $lopHocStmt->bindParam(':MaLop', $maLop, PDO::PARAM_INT);
                $lopHocStmt->execute();
                $lopHoc = $lopHocStmt->fetch(PDO::FETCH_ASSOC);
                if (!$lopHoc) {
                    throw new Exception('Lớp học không tồn tại.');
                }

                // Kiểm tra số lượng còn lại sử dụng SoLuongHienTai
                $soLuongToiDa = (int)($lopHoc['SoLuongToiDa'] ?? 0);
                if ($soLuongToiDa > 0) {
                    $currentCount = (int)($lopHoc['SoLuongHienTai'] ?? 0);
                    if ($currentCount >= $soLuongToiDa) {
                        throw new Exception('Lớp học đã đủ số lượng, không thể đăng ký thêm.');
                    }
                }

                // Kiểm tra đã đăng ký chưa
                $existing = $this->dangKyLopHocModel->getActiveByHoiVienAndLop($maHV, $maLop);
                if ($existing) {
                    throw new Exception('Hội viên đã đăng ký lớp học này rồi.');
                }

                // Tạo đăng ký lớp học với trạng thái đã đăng ký và đã thanh toán
                $result = $this->dangKyLopHocModel->create($maHV, $maLop);
                if ($result !== true) {
                    if (is_array($result)) {
                        throw new Exception(implode(', ', $result));
                    }
                    throw new Exception('Không thể tạo đăng ký lớp học.');
                }

                // Lấy ID đăng ký vừa tạo
                $dangKy = $this->dangKyLopHocModel->getActiveByHoiVienAndLop($maHV, $maLop);
                if (!$dangKy) {
                    throw new Exception('Không thể lấy thông tin đăng ký lớp học vừa tạo.');
                }
                $id_dangky_lh = (int)($dangKy['id'] ?? 0);

                // Cập nhật DaThanhToan = 1
                $query = "UPDATE DangKyLopHoc 
                         SET DaThanhToan = 1, updated_at = NOW()
                         WHERE id = :id_dangky";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_dangky', $id_dangky_lh, PDO::PARAM_INT);
                $stmt->execute();

                // Cập nhật id_dangky_lh vào YeuCauThanhToan để liên kết
                $updateYc = "UPDATE YeuCauThanhToan 
                            SET id_dangky_lh = :id_dangky_lh 
                            WHERE id = :id_yc";
                $stmtYc = $this->db->prepare($updateYc);
                $stmtYc->bindParam(':id_dangky_lh', $id_dangky_lh, PDO::PARAM_INT);
                $stmtYc->bindParam(':id_yc', $id, PDO::PARAM_INT);
                $stmtYc->execute();

                $successMessage = 'Xác nhận yêu cầu thanh toán thành công. Lớp học đã được kích hoạt cho hội viên.';

            } else {
                throw new Exception('Loại yêu cầu thanh toán không hợp lệ.');
            }

            // Cập nhật trạng thái yêu cầu thanh toán (chung cho tất cả các loại)
            $okYc = $this->yeuCauThanhToanModel->markConfirmed((int)$id);
            if (!$okYc) {
                throw new Exception('Không thể cập nhật trạng thái yêu cầu thanh toán.');
            }

            $this->db->commit();
            $_SESSION['success'] = $successMessage;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Lỗi khi xác nhận yêu cầu: ' . $e->getMessage();
        }

        // Quay lại danh sách yêu cầu
        header('Location: /gym/admin/yeucau');
        exit;
    }

    public function verifyPayment($id_ctgt)
    {
        // Chỉ admin mới được xác minh
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/user');
            exit;
        }

        // Lấy chi tiết gói tập để xác định hội viên
        $rows = $this->ctgtModel->getChiTietById($id_ctgt);
        if (empty($rows)) {
            $_SESSION['error'] = 'Không tìm thấy chi tiết gói tập để xác minh.';
            header('Location: /gym/admin/user');
            exit;
        }

        $ct = $rows[0];
        $maHV = (int)($ct['MaHV'] ?? 0);

        if ($maHV <= 0) {
            $_SESSION['error'] = 'Dữ liệu chi tiết gói tập không hợp lệ.';
            header('Location: /gym/admin/user');
            exit;
        }

        try {
            $this->db->beginTransaction();

            $ok = $this->ctgtModel->confirmPayment((int)$id_ctgt);
            if (!$ok) {
                throw new Exception('Không thể xác minh thanh toán hoặc đã được xác minh trước đó.');
            }

            $this->db->commit();
            $_SESSION['success'] = 'Xác minh thanh toán thành công.';
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Lỗi khi xác minh thanh toán: ' . $e->getMessage();
        }

        header('Location: /gym/admin/showUser/' . $maHV);
        exit;
    }

    public function cancelPackage($maHV)
    {
        // Chỉ admin mới được hủy gói tập
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/user/editUser/' . $maHV);
            exit;
        }

        // Kiểm tra hội viên có tồn tại không
        $hoiVien = $this->hoiVienModel->getHoiVienById($maHV);
        if (!$hoiVien) {
            $_SESSION['error'] = 'Hội viên không tồn tại.';
            header('Location: /gym/admin/user');
            exit;
        }

        // Lấy gói tập hiện tại của hội viên
        $currentCtgt = $this->ctgtModel->getCurrentByMaHV((int)$maHV);
        if (!$currentCtgt) {
            $_SESSION['error'] = 'Hội viên không có gói tập nào để hủy.';
            header('Location: /gym/admin/user/editUser/' . $maHV);
            exit;
        }

        $id_ctgt = (int)($currentCtgt['id_ctgt'] ?? 0);
        $trangThai = $currentCtgt['TrangThai'] ?? '';

        // Kiểm tra xem gói tập đã bị hủy chưa
        if ($trangThai === 'Đã hủy' || $trangThai === 'Hết hạn') {
            $_SESSION['error'] = 'Gói tập này đã bị hủy hoặc hết hạn rồi.';
            header('Location: /gym/admin/user/editUser/' . $maHV);
            exit;
        }

        try {
            $this->db->beginTransaction();

            // Hủy gói tập
            $ok = $this->ctgtModel->cancelPackage($id_ctgt);
            if (!$ok) {
                throw new Exception('Không thể hủy gói tập. Có thể gói tập đã bị hủy trước đó.');
            }

            $this->db->commit();
            $_SESSION['success'] = 'Hủy gói tập thành công.';
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Lỗi khi hủy gói tập: ' . $e->getMessage();
            error_log('AdminController::cancelPackage error - ' . $e->getMessage());
        }

        header('Location: /gym/admin/user/editUser/' . $maHV);
        exit;
    }

    public function searchUser() {
        $keyword = $_GET['keyword'] ?? '';
        $hoiVien = $this->hoiVienModel->searchHoiVien($keyword);
        require_once __DIR__ . '/../views/admin/user/adminHoiVien.php';
    }

    //PT (Personal Trainer)---------------------------------------------------------------------------------------------------------------
    public function indexPt()
    {
        $pts = $this->ptModel->getAllPTs();
        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/pt/adminPt.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function showPt($pt_id)
    {
        $pt = $this->ptModel->getPtById($pt_id);

        if (!$pt) {
            // Xử lý khi không tìm thấy PT
            header('Location: /gym/admin/pt');
            exit;
        }

        // Sửa lại đường dẫn view cho đúng
        require_once __DIR__ . '/../views/admin/pt/showPt.php';
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
    }

    public function addPt()
    {
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
        require_once __DIR__ . '/../views/pt/addPT.php';
    }

    public function savePt()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $HoTen = $_POST['HoTen'] ?? '';
            $NgaySinh = $_POST['NgaySinh'] ?? '';
            $GioiTinh = $_POST['GioiTinh'] ?? '';
            $SDT = $_POST['SDT'] ?? '';
            $Email = $_POST['Email'] ?? '';
            $DiaChi = $_POST['DiaChi'] ?? '';
            $ChuyenMon = $_POST['ChuyenMon'] ?? '';
            $KinhNghiem = $_POST['KinhNghiem'] ?? '';
            $Luong = $_POST['Luong'] ?? '';

            $result = $this->ptModel->addPT($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                $errors = $result;
                require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
                require_once __DIR__ . '/../views/pt/addPT.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/admin/pt');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm PT. Vui lòng thử lại.";
            }
        }
    }

    public function editPt($MaPT)
    {
        $pt = $this->ptModel->getPTById($MaPT);
        if ($pt) {
            require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
            require_once __DIR__ . '/../views/pt/editPT.php';
        } else {
            echo "PT không tồn tại.";
        }
    }

    public function updatePt()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaPT = $_POST['MaPT'] ?? '';
            $HoTen = $_POST['HoTen'] ?? '';
            $NgaySinh = $_POST['NgaySinh'] ?? '';
            $GioiTinh = $_POST['GioiTinh'] ?? '';
            $SDT = $_POST['SDT'] ?? '';
            $Email = $_POST['Email'] ?? '';
            $DiaChi = $_POST['DiaChi'] ?? '';
            $ChuyenMon = $_POST['ChuyenMon'] ?? '';
            $KinhNghiem = $_POST['KinhNghiem'] ?? '';
            $Luong = $_POST['Luong'] ?? '';

            $result = $this->ptModel->updatePT($MaPT, $HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong);
            
            if ($result) {
                header('Location: /gym/admin/pt');
                exit();
            } else {
                echo "Cập nhật PT không thành công.";
            }
        }
    }

    public function deletePt($MaPT)
    {
        try {
            // Bắt đầu transaction để xóa an toàn cả tài khoản và hồ sơ PT
            $this->db->beginTransaction();

            // Xóa tài khoản liên kết với PT (nếu có)
            $queryAccount = "DELETE FROM Account WHERE pt_id = ?";
            $stmtAccount = $this->db->prepare($queryAccount);
            $stmtAccount->execute([$MaPT]);

            // Xóa hồ sơ PT
            $ok = $this->ptModel->deletePT($MaPT);
            if (!$ok) {
                throw new Exception('Không thể xóa hồ sơ PT');
            }

            $this->db->commit();
            header('Location: /gym/admin/pt');
            exit();
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            echo "Xóa PT không thành công: " . $e->getMessage();
        }
    }

    public function searchPt()
    {
        $keyword = $_GET['keyword'] ?? '';
        $pts = $this->ptModel->searchPT($keyword);
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
        require_once __DIR__ . '/../views/pt/adminPT.php';
    }

    public function indexStatistics()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        // Lấy thống kê từ model
        $statistics = $this->getStatistics();

        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/statistics.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    private function getStatistics()
    {
        try {
            // Thống kê theo role
            $query = "SELECT 
                        r.role_name,
                        COUNT(a.id) as total_users,
                        COUNT(CASE WHEN EXISTS(SELECT 1 FROM chitiet_goitap ct WHERE ct.MaHV = h.MaHV AND ct.TrangThai = 'Đang hoạt động') THEN 1 END) as users_with_package,
                        COUNT(CASE WHEN NOT EXISTS(SELECT 1 FROM chitiet_goitap ct WHERE ct.MaHV = h.MaHV AND ct.TrangThai = 'Đang hoạt động') THEN 1 END) as users_without_package
                    FROM Role r
                    LEFT JOIN Account a ON r.role_id = a.role_id
                    LEFT JOIN HoiVien h ON a.MaHV = h.MaHV
                    GROUP BY r.role_id, r.role_name";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $roleStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Thống kê gói tập theo role
            $query = "SELECT 
                        r.role_name,
                        g.TenGoiTap,
                        COUNT(DISTINCT h.MaHV) as total_users
                    FROM Role r
                    LEFT JOIN Account a ON r.role_id = a.role_id
                    LEFT JOIN HoiVien h ON a.MaHV = h.MaHV
                    LEFT JOIN chitiet_goitap ct ON h.MaHV = ct.MaHV AND ct.TrangThai = 'Đang hoạt động'
                    LEFT JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                    WHERE g.MaGoiTap IS NOT NULL
                    GROUP BY r.role_id, r.role_name, g.MaGoiTap, g.TenGoiTap
                    ORDER BY r.role_id, g.TenGoiTap";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $packageStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Thống kê đăng ký theo thời gian
            $query = "SELECT 
                        DATE_FORMAT(h.NgayDangKy, '%Y-%m') as registration_month,
                        COUNT(h.MaHV) as total_registrations
                    FROM HoiVien h
                    GROUP BY DATE_FORMAT(h.NgayDangKy, '%Y-%m')
                    ORDER BY registration_month DESC
                    LIMIT 12";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $timeStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'roleStats' => $roleStats,
                'packageStats' => $packageStats,
                'timeStats' => $timeStats
            ];
        } catch (PDOException $e) {
            error_log("Error in getStatistics: " . $e->getMessage());
            return [
                'roleStats' => [],
                'packageStats' => [],
                'timeStats' => []
            ];
        }
    }

    //Quản lý tài khoản và phân quyền---------------------------------------------------------------------------------------------------------------
    public function indexAccount()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        $accounts = $this->accountModel->getAllAccounts();

        // Bắt đầu output buffering để chèn sidebar vào đúng vị trí
        ob_start();
        require_once __DIR__ . '/../views/admin/account/adminAccount.php';
        $content = ob_get_clean();

        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function editAccount($accountId)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        // Lấy thông tin tài khoản
        $query = "SELECT a.id, a.username, a.HoTen, r.role_name, r.role_id
                  FROM account a
                  JOIN role r ON a.role_id = r.role_id
                  WHERE a.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        $account = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$account) {
            header('Location: /gym/admin/account');
            exit;
        }

        // Lấy danh sách roles
        $queryRoles = "SELECT role_id, role_name FROM role ORDER BY role_id";
        $stmtRoles = $this->db->prepare($queryRoles);
        $stmtRoles->execute();
        $roles = $stmtRoles->fetchAll(PDO::FETCH_OBJ);

        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
        require_once __DIR__ . '/../views/admin/account/editAccount.php';
    }

    public function updateAccount()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountId = $_POST['account_id'] ?? '';
            $roleId = $_POST['role_id'] ?? '';

            if ($accountId && $roleId !== '') {
                $result = $this->accountModel->updateRole($accountId, $roleId);
                if ($result) {
                    $_SESSION['success'] = "Cập nhật quyền tài khoản thành công!";
                } else {
                    $_SESSION['error'] = "Cập nhật quyền tài khoản thất bại!";
                }
            }

            header('Location: /gym/admin/account');
            exit;
        }
    }

    public function deleteAccount($accountId)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        try {
            // Bắt đầu transaction để đảm bảo xóa an toàn theo quan hệ
            $this->db->beginTransaction();

            // Lấy liên kết đến hồ sơ (MaHV, pt_id, role)
            $links = $this->accountModel->getAccountLinksById((int)$accountId);
            if (!$links) {
                throw new Exception('Tài khoản không tồn tại');
            }

            // Nếu là hội viên (role_id = 1), xóa tất cả các bảng liên quan đến MaHV
            if ((int)$links->role_id === 1 && !empty($links->MaHV)) {
                $maHV = (int)$links->MaHV;
                
                // 1. Xóa YeuCauThanhToan (không có CASCADE)
                $stmtYeuCau = $this->db->prepare("DELETE FROM YeuCauThanhToan WHERE MaHV = :maHV");
                $stmtYeuCau->bindParam(':maHV', $maHV, PDO::PARAM_INT);
                $stmtYeuCau->execute();

                // 2. Xóa ChiTiet_GoiTap (có CASCADE nhưng xóa thủ công để đảm bảo)
                $stmtChiTiet = $this->db->prepare("DELETE FROM ChiTiet_GoiTap WHERE MaHV = :maHV");
                $stmtChiTiet->bindParam(':maHV', $maHV, PDO::PARAM_INT);
                $stmtChiTiet->execute();

                // 3. Xóa DangKyLopHoc (có CASCADE nhưng xóa thủ công để đảm bảo)
                $stmtDangKy = $this->db->prepare("DELETE FROM DangKyLopHoc WHERE MaHV = :maHV");
                $stmtDangKy->bindParam(':maHV', $maHV, PDO::PARAM_INT);
                $stmtDangKy->execute();

                // 4. Xóa hồ sơ HoiVien
                $ok = $this->hoiVienModel->deleteOnlyHoiVien($maHV);
                if (!$ok) {
                    throw new Exception('Không thể xóa hồ sơ hội viên');
                }
            }

            // Nếu là PT (role_id = 2), xóa hồ sơ PT trước
            if ((int)$links->role_id === 2 && !empty($links->pt_id)) {
                $ok = $this->ptModel->deletePT((int)$links->pt_id);
                if (!$ok) {
                    throw new Exception('Không thể xóa hồ sơ huấn luyện viên');
                }
            }

            // Cuối cùng xóa tài khoản
            $stmt = $this->db->prepare('DELETE FROM account WHERE id = :id');
            $stmt->bindParam(':id', $accountId, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new Exception('Không thể xóa tài khoản');
            }

            $this->db->commit();
            $_SESSION['success'] = 'Xóa tài khoản và tất cả dữ liệu liên quan thành công!';
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $_SESSION['error'] = 'Lỗi khi xóa tài khoản: ' . $e->getMessage();
            error_log('AdminController::deleteAccount error - ' . $e->getMessage());
        }

        header('Location: /gym/admin/account');
        exit;
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

    // Đăng ký dịch vụ---------------------------------------------------------------------------------------------------------------
    public function indexDangky_dichvu()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        $dangKys = $this->dangKyDichVuModel->getAllDangKy();
        $countChoXacNhan = $this->dangKyDichVuModel->countByStatus('Chờ xác nhận');
        $countDaXacNhan = $this->dangKyDichVuModel->countByStatus('Đã xác nhận');
        $countDaHuy = $this->dangKyDichVuModel->countByStatus('Đã hủy');
        $countDaHoanThanh = $this->dangKyDichVuModel->countByStatus('Đã hoàn thành');

        ob_start();
        require_once __DIR__ . '/../views/admin/dangky_dichvu/indexDangKyDichVu.php';
        $content = ob_get_clean();
        
        ob_start();
        require_once __DIR__ . '/../views/admin/sidebarAdmin.php';
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

    public function confirmDangky_dichvu($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/dangky_dichvu');
            exit;
        }

        if ($this->dangKyDichVuModel->confirmDangKy($id)) {
            $_SESSION['success'] = 'Xác nhận đăng ký dịch vụ thành công.';
        } else {
            $_SESSION['error'] = 'Xác nhận đăng ký dịch vụ không thành công.';
        }

        header('Location: /gym/admin/dangky_dichvu');
        exit;
    }

    public function cancelDangky_dichvu($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/dangky_dichvu');
            exit;
        }

        if ($this->dangKyDichVuModel->cancelDangKy($id)) {
            $_SESSION['success'] = 'Hủy đăng ký dịch vụ thành công.';
        } else {
            $_SESSION['error'] = 'Hủy đăng ký dịch vụ không thành công.';
        }

        header('Location: /gym/admin/dangky_dichvu');
        exit;
    }

    public function completeDangky_dichvu($id)
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/dangky_dichvu');
            exit;
        }

        if ($this->dangKyDichVuModel->completeDangKy($id)) {
            $_SESSION['success'] = 'Đánh dấu hoàn thành dịch vụ thành công.';
        } else {
            $_SESSION['error'] = 'Đánh dấu hoàn thành dịch vụ không thành công.';
        }

        header('Location: /gym/admin/dangky_dichvu');
        exit;
    }

    // Quản lý hóa đơn
    public function indexHoadon()
    {
        // Kiểm tra đăng nhập và quyền admin
        if (!isset($_SESSION['username']) || !isset($_SESSION['role_id']) || $_SESSION['role_id'] != 0) {
            header('Location: /gym/account/login');
            exit;
        }

        // Lấy danh sách hóa đơn chờ xác nhận
        $hoaDons = $this->thanhToanHoaDonModel->getPendingPayments();

        require_once __DIR__ . '/../views/admin/hoadon/indexHoaDon.php';
    }

    public function confirmPayment($id)
    {
        // Kiểm tra đăng nhập và quyền admin
        if (!isset($_SESSION['username']) || !isset($_SESSION['role_id']) || $_SESSION['role_id'] != 0) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/admin/hoadon');
            exit;
        }

        if ($this->thanhToanHoaDonModel->confirmPayment($id)) {
            $_SESSION['success'] = 'Xác nhận thanh toán thành công.';
        } else {
            $_SESSION['error'] = 'Xác nhận thanh toán không thành công.';
        }

        header('Location: /gym/admin/hoadon');
        exit;
    }
}
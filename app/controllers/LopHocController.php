<?php
require_once __DIR__ . '/../models/LopHoc_Model.php';
require_once __DIR__ . '/../config/database.php';

class LopHocController
{
    private $lophocModel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->lophocModel = new LopHoc_Model($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexLopHoc()
    {
        $lophocs = $this->lophocModel->getLopHocs();

        require_once __DIR__ . '/../views/share/header.php';
        require_once __DIR__ . '/../views/service/listLopHoc.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($Malop)
    {
        $lophoc = $this->lophocModel->getLopHoc_ByID($Malop);
        if ($lophoc) {
            include_once __DIR__ . '/../views/service/showLopHoc.php';
        } else {
            echo "Lớp học này không tồn tại.";
        }
    }

    public function add()
    {
        include_once __DIR__ . '/../views/service/addDVTL.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form (tên trường phù hợp với view)
            $TenLop = $_POST['TenLop'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? 0;
            $MoTa = $_POST['MoTa'] ?? null;
            $NgayBatDau = $_POST['NgayBatDau'] ?? null;
            $NgayKetThuc = $_POST['NgayKetThuc'] ?? null;
            $TrangThai = $_POST['TrangThai'] ?? null;
            $pt_id = !empty($_POST['pt_id']) ? (int)$_POST['pt_id'] : null;

            $result = $this->lophocModel->addLopHoc($TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $TrangThai, $pt_id);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi và dữ liệu cũ
                $errors = $result;
                // có thể tái sử dụng biến để prefill form
                $old = compact('TenLop', 'GiaTien', 'MoTa', 'NgayBatDau', 'NgayKetThuc', 'TrangThai', 'pt_id');
                require_once __DIR__ . '/../views/share/header.php';
                require_once __DIR__ . '/../views/service/addDVTL.php';
                require_once __DIR__ . '/../views/share/footer.php';
                return;
            } else if ($result) {
                // Nếu thêm thành công (trả về id mới), chuyển hướng về danh sách
                $_SESSION['success'] = "Thêm lớp học thành công.";
                header('Location: /gym/lophoc');
                exit();
            } else {
                // Nếu có lỗi khác
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm lớp học. Vui lòng thử lại.";
                header('Location: /gym/lophoc');
                exit();
            }
        } else {
            header('Location: /gym/lophoc');
            exit;
        }
    }

    public function edit($MaLop)
    {
        $lophoc = $this->lophocModel->getLopHoc_ByID($MaLop);
        if ($lophoc) {
            include_once __DIR__ . '/../views/service/editDVTL.php';
        } else {
            echo "Lớp học này không tồn tại.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaLop = $_POST['MaLop'] ?? null;
            $TenLop = $_POST['TenLop'] ?? '';
            $GiaTien = $_POST['GiaTien'] ?? 0;
            $MoTa = $_POST['MoTa'] ?? null;
            $NgayBatDau = $_POST['NgayBatDau'] ?? null;
            $NgayKetThuc = $_POST['NgayKetThuc'] ?? null;
            $TrangThai = $_POST['TrangThai'] ?? null;
            $pt_id = !empty($_POST['pt_id']) ? (int)$_POST['pt_id'] : null;

            if (empty($MaLop)) {
                $_SESSION['error'] = "ID lớp học không hợp lệ.";
                header('Location: /gym/DvTapLuyen');
                exit;
            }

            $ok = $this->lophocModel->updateLopHoc($MaLop, $TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $TrangThai, $pt_id);
            if ($ok) {
                $_SESSION['success'] = "Cập nhật lớp học thành công.";
                header('Location: /gym/DvTapLuyen');
                exit;
            } else {
                $_SESSION['error'] = "Cập nhật lớp học không thành công.";
                header('Location: /gym/DvTapLuyen');
                exit;
            }
        } else {
            header('Location: /gym/DvTapLuyen');
            exit;
        }
    }

    public function delete($MaLop)
    {
        if ($this->lophocModel->deleteLopHoc($MaLop)) {
            header('Location: /gym/lophoc');
        } else {
            echo "Xóa dịch vụ không thành công.";
        }
    }
}

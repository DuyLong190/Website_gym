<?php
require_once __DIR__ . '/../models/DvTapLuyenModel.php';
require_once __DIR__ . '/../config/database.php';

class DvTapLuyenController
{
    private $dvtlModel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->dvtlModel = new DvTapLuyenModel($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexDVTL()
    {
        $DVTLs = $this->dvtlModel->getDVTLs();

        require_once __DIR__ . '/../views/share/header.php';
        
        require_once __DIR__ . '/../views/service/listDVTL.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($id)
    {
        $DVTL = $this->dvtlModel->getDVTL_ByID($id);
        if ($DVTL) {
            include_once __DIR__ . '/../views/service/showDVTL.php';
        } else {
            echo "Dịch vụ này không tồn tại.";
        }
    }

    public function add()
    {
        include_once __DIR__ . '/../views/service/addDVTL.php';
    }

    // Lưu gói tập mới
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenTL = $_POST['TenTL'] ?? '';
            $GiaTL = $_POST['GiaTL'] ?? '';
            $ThoiGianTL = $_POST['ThoiGianTL'] ?? '';
            $MoTaTL = $_POST['MoTaTL'] ?? '';

            $result = $this->dvtlModel->addDVTL($TenTL, $GiaTL, $ThoiGianTL, $MoTaTL);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/share/header.php';
                require_once __DIR__ . '/../views/service/addDVTL.php';
                require_once __DIR__ . '/../views/share/footer.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/DvTapLuyen');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm dịch vụ. Vui lòng thử lại.";
            }
        }
    }

    public function edit($id)
    {
        $DVTL = $this->dvtlModel->getDVTL_ByID($id);
        if ($DVTL) {
            include_once __DIR__ . '/../views/service/editDVTL.php';
        } else {
            echo "Dịch vụ này không tồn tại.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $TenTL = $_POST['TenTL'];
            $GiaTL = $_POST['GiaTL'];
            $ThoiGianTL = $_POST['ThoiGianTL'];
            $MoTaTL = $_POST['MoTaTL'] ?? '';

            $edit = $this->dvtlModel->updateDVTL($id, $TenTL, $GiaTL, $ThoiGianTL, $MoTaTL);
            if ($edit) {
                header('Location: /gym/DvTapLuyen');
            } else {
                echo "Cập nhật dịch vụ không thành công.";
            }
        }
    }

    // Xóa gói tập
    public function delete($id)
    {
        if ($this->dvtlModel->deleteDVTL($id)) {
            header('Location: /gym/DvTapLuyen');
        } else {
            echo "Xóa dịch vụ không thành công.";
        }
    }
}

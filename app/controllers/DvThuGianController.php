<?php
require_once __DIR__ . '/../models/DvThuGianModel.php';
require_once __DIR__ . '/../config/database.php';

class DvThuGianController
{
    private $dvtgModel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->dvtgModel = new DvThuGianModel($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexDVTG()
    {
        $DVTGs = $this->dvtgModel->getDVTGs();

        require_once __DIR__ . '/../views/share/header.php';
        require_once __DIR__ . '/../views/share/trangchu.php';
        require_once __DIR__ . '/../views/package/listGoiTap.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($id)
    {
        $DVTG = $this->dvtgModel->getDVTG_ByID($id);
        if ($DVTG) {
            include_once __DIR__ . '/../views/package/showDVTG.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    public function add()
    {
        include_once __DIR__ . '/../views/service/addDVTG.php';
    }

    // Lưu gói tập mới
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $TenTG = $_POST['TenTG'] ?? '';
            $GiaTG = $_POST['GiaTG'] ?? '';
            $ThoiGianTG = $_POST['ThoiGianTG'] ?? '';
            $MoTaTG = $_POST['MoTaTG'] ?? '';

            $result = $this->dvtgModel->addDVTG($TenTG, $GiaTG, $ThoiGianTG, $MoTaTG);

            if (is_array($result)) {
                // Nếu có lỗi validation, hiển thị form lại với lỗi
                require_once __DIR__ . '/../views/share/header.php';
                require_once __DIR__ . '/../views/package/addDVTG.php';
                require_once __DIR__ . '/../views/share/footer.php';
            } else if ($result === true) {
                // Nếu thêm thành công, chuyển hướng về danh sách
                header('Location: /gym/DvThuGian');
                exit();
            } else {
                // Nếu có lỗi khác
                echo "Có lỗi xảy ra khi thêm gói tập. Vui lòng thử lại.";
            }
        }
    }

    public function edit($id)
    {
        $DVTG = $this->dvtgModel->getDVTG_ByID($id);
        if ($DVTG) {
            include_once __DIR__ . '/../views/package/editDVTG.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $TenTG = $_POST['TenTG'];
            $GiaTG = $_POST['GiaTG'];
            $ThoiGianTG = $_POST['ThoiGianTG'];
            $MoTaTG = $_POST['MoTaTG'] ?? '';

            $edit = $this->dvtgModel->updateDVTG($id, $TenTG, $GiaTG, $ThoiGianTG, $MoTaTG);
            if ($edit) {
                header('Location: /gym/DvThuGian');
            } else {
                echo "Cập nhật gói tập không thành công.";
            }
        }
    }

    // Xóa gói tập
    public function delete($id)
    {
        if ($this->dvtgModel->deleteDVTG($id)) {
            header('Location: /gym/DvThuGian');
        } else {
            echo "Xóa gói tập không thành công.";
        }
    }
}

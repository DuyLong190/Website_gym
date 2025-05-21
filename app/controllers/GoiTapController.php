<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../config/database.php';

class GoiTapController
{
    private $goitapModel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->goitapModel = new GoiTapModel($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexGoiTap()
    {
        $goiTaps = $this->goitapModel->getGoiTaps();
        
        require_once __DIR__ . '/../views/share/header.php';

        require_once __DIR__ . '/../views/package/listGoiTap.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($MaGoiTap)
    {
        $goiTap = $this->goitapModel->getByMaGoiTap($MaGoiTap);
        if ($goiTap) {
            include_once __DIR__ . '/../views/package/showGoiTap.php';
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
}
?>
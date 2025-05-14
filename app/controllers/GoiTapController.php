<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../config/database.php';

class GoiTapController
{
    private $GoiTapmodel;
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        $this->GoiTapmodel = new GoiTapModel($this->db);
    }

    // Hiển thị danh sách gói tập
    public function indexGoiTap()
    {
        // Lấy danh sách gói tập từ database
        $goiTaps = $this->GoiTapmodel->getGoiTaps();
        
        // Hiển thị header
        require_once __DIR__ . '/../views/share/header.php';
        
        // Hiển thị danh sách gói tập
        require_once __DIR__ . '/../views/package/listGoiTap.php';
        
        // Hiển thị footer
        require_once __DIR__ . '/../views/share/footer.php';
    }

    public function show($MaGoiTap)
    {
        $goiTap = $this->GoiTapmodel->getByMaGoiTap($MaGoiTap);
        if (!$goiTap) {
            include_once __DIR__ . '/../views/package/show.php';
        } else {
            echo "Gói tập không tồn tại.";
        }
    }
    // Hiển thị form tạo mới gói tập
    public function add()
    {
        include_once __DIR__ . '/../views/package/addGoiTap.php';
    }

    // Lưu gói tập mới
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Ten_Goi = $_POST['ten_goi'] ?? '';
            $Gia = $_POST['gia'] ?? 0;
            $Thoi_gian = $_POST['thoi_gian'] ?? '';
            $Mo_ta = $_POST['mo_ta'] ?? '';

            $result = $this->GoiTapmodel->addGoiTap($Ten_Goi, $Gia, $Thoi_gian, $Mo_ta);
            if (is_array($result)) {
                // Xử lý lỗi nếu có
                foreach ($result as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            } else {
                // Nếu không có lỗi, chuyển hướng về danh sách gói tập
                header('Location: /app/views/package/listGoiTap.php');
            }
        }
    }

    // Hiển thị form chỉnh sửa gói tập
    public function edit($MaGoiTap)
    {
        $goiTap = $this->GoiTapmodel->getByMaGoiTap($MaGoiTap);
        if (!$goiTap) {
            include_once __DIR__ . '/../views/package/editGoiTap.php';
        } else {
            echo "Gói tập không tồn tại.";
            return;
        }
    }

    // Cập nhật gói tập
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $MaGoiTap = $_POST['MaGoiTap'];
            $Ten_Goi = $_POST['ten_goi'];
            $Gia = $_POST['gia'];
            $Thoi_gian = $_POST['thoi_gian'];
            $Mo_ta = $_POST['mo_ta'] ?? '';

            $edit = $this->GoiTapmodel->updateGoiTap($MaGoiTap, $Ten_Goi, $Gia, $Thoi_gian, $Mo_ta);
            if ($edit) {
                header('Location: /..views/package/listGoiTap.php');
            } else {
                echo "Cập nhật gói tập không thành công.";
            }
        }
    }

    // Xóa gói tập
    public function delete($MaGoiTap)
    {
        if ($this->GoiTapmodel->deleteGoiTap($MaGoiTap)) {
            header('Location: /app/views/package/listGoiTap.php');
        } else {
            echo "Xóa gói tập không thành công.";
        }
    }
}
?>
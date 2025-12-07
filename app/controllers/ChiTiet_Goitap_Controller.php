<?php 
require_once __DIR__ . '/../models/ChiTiet_Goitap_Model.php';
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../config/database.php';

class ChiTiet_Goitap_Controller {
    private $ctgtModel;
    private $hoiVienModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->ctgtModel = new ChiTiet_Goitap_Model($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
    }

    public function index_ctgt($id_ctgt = null) {
        require_once __DIR__ . '/../views/user/sidebarUser.php';
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }

        $chiTiet = [];

        if ($id_ctgt !== null) {
            $chiTiet = $this->ctgtModel->getChiTietById($id_ctgt);
        } else {
            $username = $_SESSION['username'];
            $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);
            if ($hoiVien && isset($hoiVien->MaHV)) {
                $current = $this->ctgtModel->getCurrentByMaHV((int)$hoiVien->MaHV);
                if ($current) {
                    $chiTiet = [$current];
                }
            }
        }

        if (!empty($chiTiet)) {
            ob_start();
            require __DIR__ . '/../views/user/chitiet_goitap/show.php';
            $content = ob_get_clean();

            ob_start();
            require __DIR__ . '/../views/user/sidebarUser.php';
            $sidebar = ob_get_clean();
            if (preg_match('/<head>(.*?)<\/head>/s', $sidebar, $headMatches)) {
                $headContent = $headMatches[1];
                $content = preg_replace('/(<\/head>)/i', $headContent . '$1', $content, 1);
            }

            if (preg_match('/<body[^>]*>(.*?)<\/body>/s', $sidebar, $bodyMatches)) {
                $sidebarBodyContent = $bodyMatches[1];
                $content = preg_replace('/(<body[^>]*>)/i', '$1' . $sidebarBodyContent, $content, 1);
            }

            echo $content;
        } else {
            echo "Chi tiết gói tập không tồn tại hoặc bạn chưa đăng ký gói tập nào.";
        }
    }

    public function purchase($id_ctgt)
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /gym/account/login');
            exit;
        }
        $username = $_SESSION['username'];
        $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);

        if (!$hoiVien || !isset($hoiVien->MaHV)) {
            echo "Không tìm thấy thông tin hội viên.";
            return;
        }
        $chiTietArr = $this->ctgtModel->getChiTietById($id_ctgt);
        if (empty($chiTietArr)) {
            echo "Chi tiết gói tập không tồn tại.";
            return;
        }
        $item = $chiTietArr[0];
        if ((int)($item['MaHV'] ?? 0) !== (int)$hoiVien->MaHV) {
            echo "Bạn không có quyền truy cập chi tiết gói tập này.";
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->ctgtModel->requestPayment((int)$id_ctgt);
            if ($ok) {
                $_SESSION['success'] = 'Đã gửi yêu cầu thanh toán. Vui lòng chờ admin xác minh.';
            } else {
                $_SESSION['error'] = 'Gửi yêu cầu thanh toán thất bại hoặc gói tập đã được xử lý trước đó.';
            }
            header('Location: /gym/user/chitiet_goitap/' . (int)$id_ctgt);
            exit;
        }
        ob_start();
        require_once __DIR__ . '/../views/user/chitiet_goitap/purchase.php';
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
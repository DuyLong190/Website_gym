<?php
require_once __DIR__ . '/../models/PtModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once 'app/config/database.php';

class PtApiController
{
    private $ptModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->ptModel = new PtModel($this->db);
    }

    private function ensurePT()
    {
        if (!SessionHelper::isPT() || empty($_SESSION['pt_id'])) {
            header('Location: /gym/account/login');
            exit;
        }
    }

    // Trang hồ sơ PT (web)
    public function profile()
    {
        $this->ensurePT();
        $ptId = (int)$_SESSION['pt_id'];
        $pt = $this->ptModel->getPTById($ptId);

        if (!$pt) {
            $_SESSION['error'] = 'Không tìm thấy thông tin huấn luyện viên.';
            header('Location: /gym');
            exit;
        }

        require_once __DIR__ . '/../views/pt/sidebarPT.php';
        require_once __DIR__ . '/../views/pt/profile.php';
    }

    // Trang chỉnh sửa PT (web)
    public function edit()
    {
        $this->ensurePT();
        $ptId = (int)$_SESSION['pt_id'];
        $pt = $this->ptModel->getPTById($ptId);

        if (!$pt) {
            $_SESSION['error'] = 'Không tìm thấy thông tin huấn luyện viên.';
            header('Location: /gym/pt');
            exit;
        }

        require_once __DIR__ . '/../views/pt/sidebarPT.php';
        require_once __DIR__ . '/../views/pt/edit.php';
    }

    // Cập nhật thông tin PT (web)
    public function updateProfile()
    {
        $this->ensurePT();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /gym/pt/edit');
            exit;
        }

        $ptId = (int)$_SESSION['pt_id'];

        $HoTen = trim($_POST['HoTen'] ?? '');
        $NgaySinh = !empty($_POST['NgaySinh']) ? $_POST['NgaySinh'] : null;
        $GioiTinh = !empty($_POST['GioiTinh']) ? $_POST['GioiTinh'] : null;
        $SDT = trim($_POST['SDT'] ?? '');
        $Email = !empty($_POST['Email']) ? trim($_POST['Email']) : null;
        $DiaChi = !empty($_POST['DiaChi']) ? trim($_POST['DiaChi']) : null;
        $ChuyenMon = !empty($_POST['ChuyenMon']) ? trim($_POST['ChuyenMon']) : null;
        $KinhNghiem = ($_POST['KinhNghiem'] ?? '') !== '' ? $_POST['KinhNghiem'] : null;
        $Luong = ($_POST['Luong'] ?? '') !== '' ? $_POST['Luong'] : null;

        if ($HoTen === '' || $SDT === '') {
            $_SESSION['error'] = 'Họ tên và số điện thoại không được để trống.';
            header('Location: /gym/pt/edit');
            exit;
        }

        $updated = $this->ptModel->updatePT(
            $ptId,
            $HoTen,
            $NgaySinh,
            $GioiTinh,
            $SDT,
            $Email,
            $DiaChi,
            $ChuyenMon,
            $KinhNghiem,
            $Luong
        );

        if ($updated) {
            $_SESSION['HoTen'] = $HoTen;
            $_SESSION['success'] = 'Cập nhật thông tin thành công.';
            header('Location: /gym/pt');
            exit;
        }

        $_SESSION['error'] = 'Cập nhật thông tin thất bại. Vui lòng thử lại.';
        header('Location: /gym/pt/edit');
    }

    // GET /api/pt - Hiển thị danh sách PT (API)
    public function index()
    {
        $data = $this->ptModel->getAllPTs();
        return [
            'success' => true,
            'data' => $data
        ];
    }

    // GET /api/pt/{pt_id} - Hiển thị chi tiết PT
    public function show($pt_id)
    {
        if (!is_numeric($pt_id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'Mã HLV không hợp lệ'];
        }

        $item = $this->ptModel->getPTById((int)$pt_id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy HLV'];
        }

        return [
            'success' => true,
            'data' => $item
        ];
    }

    // POST /api/pt - Tạo PT mới
    public function save()
    {
        $payload = $this->getJsonInput();
        $HoTen = $payload['HoTen'] ?? null;
        $NgaySinh = $payload['NgaySinh'] ?? null;
        $GioiTinh = $payload['GioiTinh'] ?? null;
        $SDT = $payload['SDT'] ?? null;
        $Email = $payload['Email'] ?? null;
        $DiaChi = $payload['DiaChi'] ?? null;
        $ChuyenMon = $payload['ChuyenMon'] ?? null;
        $KinhNghiem = $payload['KinhNghiem'] ?? null;
        $Luong = $payload['Luong'] ?? null;

        $result = $this->ptModel->addPT($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong);

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        if ($result) {
            http_response_code(201);
            return ['success' => true, 'message' => 'Tạo HLV thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể tạo HLV'];
    }

    // PUT /api/pt/{id} - Cập nhật PT
    public function update($pt_id)
    {
        if (!is_numeric($pt_id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'Mã HLV không hợp lệ'];
        }

        // Kiểm tra PT có tồn tại không
        $existingPT = $this->ptModel->getPTById((int)$pt_id);
        if (!$existingPT) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy HLV'];
        }

        $payload = $this->getJsonInput();
        $HoTen = $payload['HoTen'] ?? null;
        $NgaySinh = $payload['NgaySinh'] ?? null;
        $GioiTinh = $payload['GioiTinh'] ?? null;
        $SDT = $payload['SDT'] ?? null;
        $Email = $payload['Email'] ?? null;
        $DiaChi = $payload['DiaChi'] ?? null;
        $ChuyenMon = $payload['ChuyenMon'] ?? null;
        $KinhNghiem = $payload['KinhNghiem'] ?? null;
        $Luong = $payload['Luong'] ?? null;

        $result = $this->ptModel->updatePT((int)$pt_id, $HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong);
        
        if ($result) {
            return ['success' => true, 'message' => 'Cập nhật HLV thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể cập nhật HLV'];
    }

    // DELETE /api/pt/{id} - Xóa PT
    public function delete($pt_id)
    {
        if (!is_numeric($pt_id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'Mã HLV không hợp lệ'];
        }

        // Kiểm tra PT có tồn tại không
        $existingPT = $this->ptModel->getPTById((int)$pt_id);
        if (!$existingPT) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy HLV'];
        }

        try {
            // Bắt đầu transaction để xóa an toàn cả tài khoản và hồ sơ PT
            $this->db->beginTransaction();

            // Xóa tài khoản liên kết với PT (nếu có)
            $queryAccount = "DELETE FROM Account WHERE pt_id = ?";
            $stmtAccount = $this->db->prepare($queryAccount);
            $stmtAccount->execute([(int)$pt_id]);

            // Xóa hồ sơ PT
            $result = $this->ptModel->deletePT((int)$pt_id);
            if (!$result) {
                throw new Exception('Không thể xóa hồ sơ PT');
            }

            $this->db->commit();
            return ['success' => true, 'message' => 'Xóa HLV và tài khoản liên quan thành công'];
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            http_response_code(500);
            return ['success' => false, 'message' => 'Không thể xóa HLV: ' . $e->getMessage()];
        }
    }

    // GET /api/pt/search?keyword=... - Tìm kiếm PT
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';
        $pts = $this->ptModel->searchPT($keyword);
        return [
            'success' => true,
            'data' => $pts
        ];
    }

    // Lấy dữ liệu từ JSON input hoặc form data
    private function getJsonInput()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Cho phép form-encoded như fallback
            return $_POST;
        }
        return $data ?? [];
    }
}
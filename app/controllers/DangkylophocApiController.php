<?php

require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once 'app/config/Database.php';

class DangkylophocApiController
{
    private $dkModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->dkModel = new DangKyLopHocModel($this->db);
    }

    private function ensureUser()
    {
        if (!SessionHelper::isLoggedIn() || (int)($_SESSION['role_id'] ?? 0) !== 1) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập bằng tài khoản hội viên.']);
            exit;
        }
        if (empty($_SESSION['MaHV'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin hội viên trong phiên đăng nhập.']);
            exit;
        }
    }

    public function index()
    {
        // Admin xem tất cả, hội viên chỉ xem của mình
        if (SessionHelper::isAdmin()) {
            $data = $this->dkModel->getAll();
        } elseif (SessionHelper::isLoggedIn() && (int)($_SESSION['role_id'] ?? 0) === 1 && !empty($_SESSION['MaHV'])) {
            $data = $this->dkModel->getByHoiVien((int)$_SESSION['MaHV']);
        } else {
            http_response_code(401);
            return ['success' => false, 'message' => 'Không có quyền truy cập.'];
        }

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $item = $this->dkModel->getById((int)$id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy bản ghi đăng ký lớp học'];
        }

        return [
            'success' => true,
            'data' => $item,
        ];
    }

    // POST /api/dangkylophoc - hội viên đăng ký lớp
    public function store()
    {
        $this->ensureUser();

        $payload = $this->getJsonInput();
        $MaLop = $payload['MaLop'] ?? null;
        $MaHV = (int)$_SESSION['MaHV'];

        $result = $this->dkModel->create($MaHV, $MaLop);

        if ($result === true) {
            $remaining = $this->dkModel->getRemainingSlotsByLop($MaLop);
            http_response_code(201);
            return [
                'success' => true,
                'message' => 'Đăng ký lớp học thành công',
                'remaining_slots' => $remaining,
            ];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể đăng ký lớp học'];
    }

    // PUT /api/dangkylophoc/{id} - cập nhật trạng thái (tuỳ chọn)
    public function update($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $payload = $this->getJsonInput();
        $TrangThai = $payload['TrangThai'] ?? null;

        if ($TrangThai !== 'DangKy' && $TrangThai !== 'Huy') {
            http_response_code(422);
            return ['success' => false, 'message' => 'Trạng thái không hợp lệ'];
        }

        try {
            $sql = "UPDATE DangKyLopHoc SET TrangThai = :TrangThai, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $id = (int)$id;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':TrangThai', $TrangThai);
            $ok = $stmt->execute();
        } catch (PDOException $e) {
            error_log('DangkylophocApiController::update - ' . $e->getMessage());
            $ok = false;
        }

        if ($ok) {
            return ['success' => true, 'message' => 'Cập nhật đăng ký lớp học thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể cập nhật đăng ký lớp học'];
    }

    // DELETE /api/dangkylophoc/{id}
    public function delete($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $ok = $this->dkModel->deleteById((int)$id);
        if ($ok) {
            return ['success' => true, 'message' => 'Xóa đăng ký lớp học thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể xóa đăng ký lớp học'];
    }

    private function getJsonInput()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $_POST;
        }
        return $data ?? [];
    }
}

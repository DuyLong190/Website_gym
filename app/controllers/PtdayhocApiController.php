<?php

require_once __DIR__ . '/../models/PtDayHocModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once 'app/config/Database.php';

class PtdayhocApiController
{
    private $ptDkModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->ptDkModel = new PtDayHocModel($this->db);
    }

    private function ensurePT()
    {
        if (!SessionHelper::isPT() || empty($_SESSION['pt_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập bằng tài khoản huấn luyện viên.']);
            exit;
        }
    }

    public function index()
    {
        $this->ensurePT();
        $pt_id = (int)$_SESSION['pt_id'];
        $data = $this->ptDkModel->getByPt($pt_id);
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

        $item = $this->ptDkModel->getById((int)$id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy đăng ký đứng lớp'];
        }

        return [
            'success' => true,
            'data' => $item,
        ];
    }

    // POST /api/ptdayhoc - PT đăng ký đứng lớp
    public function store()
    {
        $this->ensurePT();

        $payload = $this->getJsonInput();
        $MaLop = $payload['MaLop'] ?? null;
        $pt_id = (int)$_SESSION['pt_id'];

        $result = $this->ptDkModel->create($pt_id, $MaLop);

        if ($result === true) {
            http_response_code(201);
            return ['success' => true, 'message' => 'Đăng ký đứng lớp thành công'];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể đăng ký đứng lớp'];
    }

    // PUT /api/ptdayhoc/{id} - cập nhật trạng thái (không bắt buộc dùng)
    public function update($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $payload = $this->getJsonInput();
        $TrangThai = $payload['TrangThai'] ?? null;

        if ($TrangThai !== 'Đăng ký' && $TrangThai !== 'Hủy') {
            http_response_code(422);
            return ['success' => false, 'message' => 'Trạng thái không hợp lệ'];
        }

        try {
            $sql = "UPDATE PtDayHoc SET TrangThai = :TrangThai, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $id = (int)$id;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':TrangThai', $TrangThai);
            $ok = $stmt->execute();
        } catch (PDOException $e) {
            error_log('PtdayhocApiController::update - ' . $e->getMessage());
            $ok = false;
        }

        if ($ok) {
            return ['success' => true, 'message' => 'Cập nhật đăng ký đứng lớp thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể cập nhật đăng ký đứng lớp'];
    }

    // DELETE /api/ptdayhoc/{id} - hủy đăng ký hoặc xóa bản ghi
    public function delete($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        // Thử hủy (set trạng thái Huy), nếu không được thì xóa cứng
        $ok = $this->ptDkModel->cancelById((int)$id);
        if (!$ok) {
            $ok = $this->ptDkModel->deleteById((int)$id);
        }

        if ($ok) {
            return ['success' => true, 'message' => 'Hủy đăng ký đứng lớp thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể hủy đăng ký đứng lớp'];
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

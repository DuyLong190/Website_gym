<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once 'app/config/database.php';

class GoiTapApiController 
{
    private $goiTapModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->goiTapModel = new GoiTapModel($this->db);
    }

    // GET /api/goitap
    public function index()
    {
        $data = $this->goiTapModel->getGoiTaps();
        return [
            'success' => true,
            'data' => $data
        ];
    }

    // GET /api/goitap/{id}
    public function show($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'MaGoiTap không hợp lệ'];
        }

        $item = $this->goiTapModel->getByMaGoiTap((int)$id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy gói tập'];
        }

        return [
            'success' => true,
            'data' => $item
        ];
    }

    // POST /api/goitap
    public function store()
    {
        $payload = $this->getJsonInput();
        $TenGoiTap = $payload['TenGoiTap'] ?? null;
        $GiaTien   = $payload['GiaTien'] ?? null;
        $ThoiHan   = $payload['ThoiHan'] ?? null;
        $MoTa      = $payload['MoTa'] ?? null;

        $result = $this->goiTapModel->addGoiTap($TenGoiTap, $GiaTien, $ThoiHan, $MoTa);

        if ($result === true) {
            http_response_code(201);
            return ['success' => true, 'message' => 'Tạo gói tập thành công'];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể tạo gói tập'];
    }

    // PUT /api/goitap/{id}
    public function update($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'MaGoiTap không hợp lệ'];
        }

        $payload = $this->getJsonInput();
        $TenGoiTap = $payload['TenGoiTap'] ?? null;
        $GiaTien   = $payload['GiaTien'] ?? null;
        $ThoiHan   = $payload['ThoiHan'] ?? null;
        $MoTa      = $payload['MoTa'] ?? null;

        $ok = $this->goiTapModel->updateGoiTap((int)$id, $TenGoiTap, $GiaTien, $ThoiHan, $MoTa);
        if ($ok) {
            return ['success' => true, 'message' => 'Cập nhật gói tập thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể cập nhật gói tập'];
    }

    // DELETE /api/goitap/{id}
    public function delete($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'MaGoiTap không hợp lệ'];
        }

        $ok = $this->goiTapModel->deleteGoiTap((int)$id);
        if ($ok) {
            return ['success' => true, 'message' => 'Xóa gói tập thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể xóa gói tập'];
    }

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
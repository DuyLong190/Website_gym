<?php
require_once __DIR__ . '/../models/PtModel.php';
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

    // GET /api/pt - Hiển thị danh sách PT
    public function index()
    {
        $data = $this->ptModel->getAllPTs();
        return [
            'success' => true,
            'data' => $data
        ];
    }

    // GET /api/pt/{id} - Hiển thị chi tiết PT
    public function show($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'Mã HLV không hợp lệ'];
        }

        $item = $this->ptModel->getPTById((int)$id);
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
    public function store()
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

        if ($result === true) {
            http_response_code(201);
            return ['success' => true, 'message' => 'Tạo HLV thành công'];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
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

        $result = $this->ptModel->deletePT((int)$pt_id);
        if ($result) {
            return ['success' => true, 'message' => 'Xóa HLV thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể xóa HLV'];
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
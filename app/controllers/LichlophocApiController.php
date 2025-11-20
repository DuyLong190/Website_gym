<?php

require_once __DIR__ . '/../models/LichLopHocModel.php';
require_once 'app/config/Database.php';

class LichlophocApiController
{
    private $lichLopHocModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->lichLopHocModel = new LichLopHocModel($this->db);
    }

    public function index()
    {
        $data = $this->lichLopHocModel->getAll();
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

        $item = $this->lichLopHocModel->getById((int)$id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy lịch lớp học'];
        }

        return [
            'success' => true,
            'data' => $item,
        ];
    }

    public function store()
    {
        $payload = $this->getJsonInput();

        $MaLop = $payload['MaLop'] ?? null;
        $NgayHoc = $payload['NgayHoc'] ?? null;
        $GioBatDau = $payload['GioBatDau'] ?? null;
        $GioKetThuc = $payload['GioKetThuc'] ?? null;
        $PhongHoc = $payload['PhongHoc'] ?? null;

        $result = $this->lichLopHocModel->create($MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc);

        if ($result === true) {
            http_response_code(201);
            return ['success' => true, 'message' => 'Tạo lịch lớp học thành công'];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể tạo lịch lớp học'];
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $payload = $this->getJsonInput();

        $MaLop = $payload['MaLop'] ?? null;
        $NgayHoc = $payload['NgayHoc'] ?? null;
        $GioBatDau = $payload['GioBatDau'] ?? null;
        $GioKetThuc = $payload['GioKetThuc'] ?? null;
        $PhongHoc = $payload['PhongHoc'] ?? null;

        $result = $this->lichLopHocModel->update((int)$id, $MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc);

        if ($result === true) {
            return ['success' => true, 'message' => 'Cập nhật lịch lớp học thành công'];
        }

        if (is_array($result)) {
            http_response_code(422);
            return ['success' => false, 'errors' => $result];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể cập nhật lịch lớp học'];
    }

    public function delete($id)
    {
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        $ok = $this->lichLopHocModel->delete((int)$id);
        if ($ok) {
            return ['success' => true, 'message' => 'Xóa lịch lớp học thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể xóa lịch lớp học'];
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

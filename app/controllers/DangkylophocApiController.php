<?php

require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/YeuCauThanhToanModel.php';
require_once __DIR__ . '/../models/LopHoc_Model.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once 'app/config/Database.php';

class DangkylophocApiController
{
    private $dkModel;
    private $yeuCauThanhToanModel;
    private $lopHocModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->dkModel = new DangKyLopHocModel($this->db);
        $this->yeuCauThanhToanModel = new YeuCauThanhToanModel($this->db);  
        $this->lopHocModel = new LopHoc_Model($this->db);
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

    // POST /api/dangkylophoc - hội viên đăng ký lớp (tạo YeuCauThanhToan thay vì DangKyLopHoc)
    public function store()
    {
        $this->ensureUser();

        $payload = $this->getJsonInput();
        $MaLop = isset($payload['MaLop']) ? (int)$payload['MaLop'] : null;
        $MaHV = (int)$_SESSION['MaHV'];

        // Validate
        if (empty($MaLop) || $MaLop <= 0) {
            http_response_code(422);
            return ['success' => false, 'message' => 'Lớp học không hợp lệ'];
        }

        // Kiểm tra lớp học có tồn tại không
        $lopHoc = $this->lopHocModel->getLopHoc_ByID($MaLop);
        if (!$lopHoc) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Lớp học không tồn tại'];
        }

        // Kiểm tra đã đăng ký chưa (kiểm tra cả đăng ký đã xác nhận và yêu cầu đang chờ)
        $existing = $this->dkModel->getActiveByHoiVienAndLop($MaHV, $MaLop);
        if ($existing) {
            http_response_code(422);
            return ['success' => false, 'message' => 'Bạn đã đăng ký lớp học này rồi.'];
        }

        // Kiểm tra yêu cầu thanh toán đang chờ xác nhận
        $pendingRequest = $this->yeuCauThanhToanModel->hasPendingForLopHoc($MaHV, $MaLop);
        if ($pendingRequest) {
            http_response_code(422);
            return ['success' => false, 'message' => 'Bạn đã có yêu cầu đăng ký lớp học này đang chờ xác nhận.'];
        }

        // Kiểm tra số lượng còn lại
        $remaining = $this->dkModel->getRemainingSlotsByLop($MaLop);
        if ($remaining !== null && $remaining <= 0) {
            http_response_code(422);
            return ['success' => false, 'message' => 'Lớp học đã đủ số lượng, không thể đăng ký thêm.'];
        }

        // Lấy giá tiền
        $soTien = (float)($lopHoc->GiaTien ?? 0);
        if ($soTien <= 0) {
            http_response_code(422);
            return ['success' => false, 'message' => 'Giá lớp học không hợp lệ'];
        }

        // Tạo yêu cầu thanh toán (tương tự như gói tập)
        try {
            $result = $this->yeuCauThanhToanModel->createForLopHoc($MaHV, $soTien, $MaLop);

            if ($result) {
                http_response_code(201);
                return [
                    'success' => true,
                    'message' => 'Đăng ký lớp học thành công. Vui lòng thanh toán và chờ admin xác nhận.',
                    'remaining_slots' => $remaining,
                ];
            }

            // Nếu createForLopHoc trả về false, có thể có lỗi database
            error_log('DangkylophocApiController::store - createForLopHoc returned false for MaHV: ' . $MaHV . ', MaLop: ' . $MaLop);
            http_response_code(500);
            return ['success' => false, 'message' => 'Không thể tạo yêu cầu thanh toán. Vui lòng thử lại sau.'];
        } catch (Exception $e) {
            error_log('DangkylophocApiController::store - Exception: ' . $e->getMessage());
            http_response_code(500);
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
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

    // DELETE /api/dangkylophoc/{id} - Hủy đăng ký (chỉ cập nhật trạng thái, không xóa)
    public function delete($id)
    {
        $this->ensureUser();
        
        if (!is_numeric($id)) {
            http_response_code(400);
            return ['success' => false, 'message' => 'ID không hợp lệ'];
        }

        // Kiểm tra quyền: chỉ hội viên sở hữu mới được hủy
        $item = $this->dkModel->getById((int)$id);
        if (!$item) {
            http_response_code(404);
            return ['success' => false, 'message' => 'Không tìm thấy đăng ký lớp học'];
        }

        $maHV = (int)($_SESSION['MaHV'] ?? 0);
        if ((int)($item['MaHV'] ?? 0) !== $maHV) {
            http_response_code(403);
            return ['success' => false, 'message' => 'Bạn không có quyền hủy đăng ký này'];
        }

        // Chỉ hủy nếu đang ở trạng thái DangKy
        if (($item['TrangThai'] ?? '') !== 'DangKy') {
            http_response_code(400);
            return ['success' => false, 'message' => 'Đăng ký này đã được hủy hoặc không thể hủy'];
        }

        // Hủy đăng ký (chỉ cập nhật trạng thái, không xóa)
        $ok = $this->dkModel->cancelById((int)$id);
        if ($ok) {
            return ['success' => true, 'message' => 'Hủy đăng ký lớp học thành công'];
        }

        http_response_code(500);
        return ['success' => false, 'message' => 'Không thể hủy đăng ký lớp học'];
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

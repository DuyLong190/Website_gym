<?php
require_once __DIR__ . '/../models/ThanhToanHoaDonModel.php';
require_once __DIR__ . '/../models/DangKyDichVuModel.php';
require_once __DIR__ . '/../models/DangKyLopHocModel.php';
require_once __DIR__ . '/../models/DvThuGianModel.php';
require_once __DIR__ . '/../models/LopHoc_Model.php';
require_once __DIR__ . '/../config/database.php';

class ThanhToanHoaDonController
{
    private $thanhToanHoaDonModel;
    private $dangKyDichVuModel;
    private $dangKyLopHocModel;
    private $dvThuGianModel;
    private $lopHocModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->thanhToanHoaDonModel = new ThanhToanHoaDonModel($this->db);
        $this->dangKyDichVuModel = new DangKyDichVuModel($this->db);
        $this->dangKyLopHocModel = new DangKyLopHocModel($this->db);
        $this->dvThuGianModel = new DvThuGianModel($this->db);
        $this->lopHocModel = new LopHoc_Model($this->db);
    }

    /**
     * Bước 1: Gửi yêu cầu thanh toán MoMo cho dịch vụ hoặc lớp học
     */
    public function confirm_momo()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $_SESSION['error'] = 'Phương thức không hợp lệ.';
            header('Location: /gym/user/dichvu');
            exit;
        }

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username']) || !isset($_SESSION['MaHV'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán.';
            header('Location: /gym/account/login');
            exit;
        }

        $loai = isset($_POST['loai']) ? $_POST['loai'] : null; // 'DichVu' hoặc 'LopHoc'
        $id_dangky = isset($_POST['id_dangky']) ? (int)$_POST['id_dangky'] : null;

        if (!$loai || !in_array($loai, ['DichVu', 'LopHoc']) || !$id_dangky) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ.';
            $this->redirectBack($loai);
            exit;
        }

        $maHV = (int)$_SESSION['MaHV'];
        $amount = 0;
        $orderInfo = '';
        $redirectUrl = '';

        // Lấy thông tin và giá tiền dựa trên loại
        if ($loai === 'DichVu') {
            $dangKy = $this->dangKyDichVuModel->getDangKyById($id_dangky);
            if (!$dangKy || (int)$dangKy->MaHV !== $maHV) {
                $_SESSION['error'] = 'Bạn không có quyền thanh toán dịch vụ này.';
                header('Location: /gym/user/dichvu');
                exit;
            }

            // Kiểm tra đã thanh toán chưa
            if (isset($dangKy->DaThanhToan) && (int)$dangKy->DaThanhToan === 1) {
                $_SESSION['error'] = 'Dịch vụ này đã được thanh toán.';
                header('Location: /gym/user/dichvu');
                exit;
            }

            $dichVu = $this->dvThuGianModel->getDVTG_ByID($dangKy->id_dv);
            if (!$dichVu) {
                $_SESSION['error'] = 'Dịch vụ không tồn tại!';
                header('Location: /gym/user/dichvu');
                exit;
            }

            $amount = (float)($dichVu->GiaTG ?? 0);
            $orderInfo = "Thanh toán dịch vụ " . htmlspecialchars($dichVu->TenTG ?? '') . " qua MoMo";
            $redirectUrl = "http://" . $_SERVER['HTTP_HOST'] . "/gym/ThanhToanHoaDon/momo_post";

        } else if ($loai === 'LopHoc') {
            $dangKy = $this->dangKyLopHocModel->getById($id_dangky);
            if (!$dangKy || (int)$dangKy['MaHV'] !== $maHV) {
                $_SESSION['error'] = 'Bạn không có quyền thanh toán lớp học này.';
                header('Location: /gym/user/lophoc');
                exit;
            }

            // Kiểm tra đã thanh toán chưa
            if (isset($dangKy['DaThanhToan']) && (int)$dangKy['DaThanhToan'] === 1) {
                $_SESSION['error'] = 'Lớp học này đã được thanh toán.';
                header('Location: /gym/user/lophoc');
                exit;
            }

            $lopHoc = $this->lopHocModel->getLopHoc_ByID($dangKy['MaLop']);
            if (!$lopHoc) {
                $_SESSION['error'] = 'Lớp học không tồn tại!';
                header('Location: /gym/user/lophoc');
                exit;
            }

            $amount = (float)($lopHoc->GiaTien ?? 0);
            $orderInfo = "Thanh toán lớp học " . htmlspecialchars($lopHoc->TenLop ?? '') . " qua MoMo";
            $redirectUrl = "http://" . $_SERVER['HTTP_HOST'] . "/gym/ThanhToanHoaDon/momo_post";
        }

        if ($amount <= 0) {
            $_SESSION['error'] = 'Giá tiền không hợp lệ!';
            $this->redirectBack($loai);
            exit;
        }

        // Tạo request đến MoMo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderId = time() . "_" . $loai . "_" . $id_dangky;
        $ipnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/gym/ThanhToanHoaDon/momo_ipn";
        $extraData = base64_encode(json_encode([
            'loai' => $loai,
            'id_dangky' => $id_dangky,
            'maHV' => $maHV
        ]));

        $requestId = time() . "";
        $requestType = "captureWallet";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "LD Gym",
            "storeId" => "LDGymStore",
            'requestId' => $requestId,
            'amount' => (int)$amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']);
            exit;
        } else {
            $_SESSION['error'] = 'Không thể tạo yêu cầu thanh toán. Vui lòng thử lại.';
            error_log('MoMo API Error: ' . print_r($jsonResult, true));
            $this->redirectBack($loai);
            exit;
        }
    }

    /**
     * Bước 2: Callback từ MoMo (redirect sau khi thanh toán)
     */
    public function momo_post()
    {
        if (!isset($_GET['resultCode'])) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ.';
            header('Location: /gym/user/dichvu');
            exit;
        }

        $resultCode = (int)$_GET['resultCode'];
        $extraData = isset($_GET['extraData']) ? $_GET['extraData'] : '';
        
        // Giải mã extraData
        $extraDataDecoded = [];
        if (!empty($extraData)) {
            $decoded = base64_decode($extraData);
            $extraDataDecoded = json_decode($decoded, true);
        }

        $loai = isset($extraDataDecoded['loai']) ? $extraDataDecoded['loai'] : null;
        $id_dangky = isset($extraDataDecoded['id_dangky']) ? (int)$extraDataDecoded['id_dangky'] : null;
        $maHV = isset($extraDataDecoded['maHV']) ? (int)$extraDataDecoded['maHV'] : null;

        $amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;
        $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
        $link_data_json = json_encode($_GET);

        if ($resultCode == 0) {
            // Thanh toán thành công
            $momo_status = 'Thành công';

            // Lưu giao dịch vào database
            if ($loai && $id_dangky && $maHV) {
                $this->thanhToanHoaDonModel->storeTransaction(
                    $maHV, 
                    $loai, 
                    $id_dangky, 
                    $amount, 
                    $momo_status, 
                    $link_data_json, 
                    $orderId
                );
                
                $_SESSION['success'] = 'Thanh toán thành công! Vui lòng chờ admin xác nhận.';
            } else {
                $_SESSION['error'] = 'Thanh toán thành công nhưng không thể lưu thông tin. Vui lòng liên hệ admin.';
            }
        } else {
            // Thanh toán thất bại
            $momo_status = 'Thất bại';

            // Lưu giao dịch thất bại vào database
            if ($loai && $id_dangky && $maHV) {
                $this->thanhToanHoaDonModel->storeTransaction(
                    $maHV, 
                    $loai, 
                    $id_dangky, 
                    $amount, 
                    $momo_status, 
                    $link_data_json, 
                    $orderId
                );
            }

            $message = isset($_GET['message']) ? $_GET['message'] : 'Thanh toán thất bại.';
            $_SESSION['error'] = $message;
        }

        // Redirect về trang tương ứng
        $this->redirectBack($loai);
        exit;
    }

    /**
     * IPN (Instant Payment Notification) - MoMo gọi trực tiếp đến server
     */
    public function momo_ipn()
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $resultCode = isset($data['resultCode']) ? (int)$data['resultCode'] : -1;
        $extraData = isset($data['extraData']) ? $data['extraData'] : '';
        
        // Giải mã extraData
        $extraDataDecoded = [];
        if (!empty($extraData)) {
            $decoded = base64_decode($extraData);
            $extraDataDecoded = json_decode($decoded, true);
        }

        $loai = isset($extraDataDecoded['loai']) ? $extraDataDecoded['loai'] : null;
        $id_dangky = isset($extraDataDecoded['id_dangky']) ? (int)$extraDataDecoded['id_dangky'] : null;
        $maHV = isset($extraDataDecoded['maHV']) ? (int)$extraDataDecoded['maHV'] : null;

        if ($resultCode == 0 && $loai && $id_dangky && $maHV) {
            $amount = isset($data['amount']) ? (float)$data['amount'] : 0;
            $orderId = isset($data['orderId']) ? $data['orderId'] : '';
            $momo_status = 'Thành công';
            $link_data_json = json_encode($data);

            // Kiểm tra xem đã lưu chưa (tránh trùng lặp)
            $existing = $this->thanhToanHoaDonModel->getByOrderId($orderId);
            if (!$existing) {
                // Lưu giao dịch
                $this->thanhToanHoaDonModel->storeTransaction(
                    $maHV, 
                    $loai, 
                    $id_dangky, 
                    $amount, 
                    $momo_status, 
                    $link_data_json, 
                    $orderId
                );
            } else {
                // Cập nhật trạng thái nếu đã tồn tại
                $this->thanhToanHoaDonModel->updateMomoStatus($existing['id'], $momo_status, $link_data_json);
            }
        }

        http_response_code(200);
        echo json_encode(['status' => 'success']);
        exit;
    }

    /**
     * Helper: Redirect về trang tương ứng dựa trên loại
     */
    private function redirectBack($loai)
    {
        if ($loai === 'DichVu') {
            header('Location: /gym/user/dichvu');
        } else if ($loai === 'LopHoc') {
            header('Location: /gym/user/lophoc');
        } else {
            header('Location: /gym/user/dichvu');
        }
    }

    /**
     * Helper: Gửi POST request đến MoMo API
     */
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode != 200) {
            error_log('MoMo API HTTP Error: ' . $httpCode);
        }
        
        return $result;
    }
}


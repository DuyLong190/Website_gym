<?php
require_once __DIR__ . '/../models/GoiTapModel.php';
require_once __DIR__ . '/../models/ThanhToanGoiTapModel.php';
require_once __DIR__ . '/../models/ChiTiet_Goitap_Model.php';
require_once __DIR__ . '/../models/HoiVienModel.php';
require_once __DIR__ . '/../config/database.php';

class ThanhToanGoiTapController
{
    private $goiTapModel;
    private $thanhToanGoiTapModel;
    private $ctgtModel;
    private $hoiVienModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->goiTapModel = new GoiTapModel($this->db);
        $this->thanhToanGoiTapModel = new ThanhToanGoiTapModel($this->db);
        $this->ctgtModel = new ChiTiet_Goitap_Model($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
    }

    // Bước 1: Gửi yêu cầu thanh toán MoMo
    public function confirm_momo()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: /gym/user/chitiet_goitap');
            exit;
        }

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['username']) || !isset($_SESSION['MaHV'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán.';
            header('Location: /gym/account/login');
            exit;
        }

        $id_ctgt = isset($_POST['id_ctgt']) ? (int)$_POST['id_ctgt'] : null;
        if (!$id_ctgt) {
            $_SESSION['error'] = 'Thông tin gói tập không hợp lệ.';
            header('Location: /gym/user/chitiet_goitap');
            exit;
        }

        // Lấy thông tin chi tiết gói tập
        $chiTietArr = $this->ctgtModel->getChiTietById($id_ctgt);
        if (empty($chiTietArr)) {
            $_SESSION['error'] = 'Chi tiết gói tập không tồn tại.';
            header('Location: /gym/user/chitiet_goitap');
            exit;
        }

        $item = $chiTietArr[0];
        $maHV = (int)$_SESSION['MaHV'];

        // Kiểm tra quyền truy cập
        if ((int)($item['MaHV'] ?? 0) !== $maHV) {
            $_SESSION['error'] = 'Bạn không có quyền thanh toán gói tập này.';
            header('Location: /gym/user/chitiet_goitap');
            exit;
        }

        // Kiểm tra đã thanh toán chưa
        if ((int)($item['DaThanhToan'] ?? 0) === 1) {
            $_SESSION['error'] = 'Gói tập này đã được thanh toán.';
            header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            exit;
        }

        // Lấy giá tiền từ bảng GoiTap
        $maGoiTap = (int)($item['MaGoiTap'] ?? 0);
        $goitap = $this->goiTapModel->getByMaGoiTap($maGoiTap);
        if (!$goitap) {
            $_SESSION['error'] = 'Gói tập không tồn tại!';
            header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            exit;
        }

        $amount = (float)($goitap->GiaTien ?? 0);
        if ($amount <= 0) {
            $_SESSION['error'] = 'Giá gói tập không hợp lệ!';
            header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            exit;
        }

        // Tạo request đến MoMo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán gói tập " . htmlspecialchars($goitap->TenGoiTap ?? '') . " qua MoMo";
        $orderId = time() . "_" . $id_ctgt;
        $redirectUrl = "http://" . $_SERVER['HTTP_HOST'] . "/gym/ThanhToanGoiTap/momo_post";
        $ipnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/gym/ThanhToanGoiTap/momo_ipn";
        $extraData = base64_encode(json_encode(['id_ctgt' => $id_ctgt, 'maHV' => $maHV])); // truyền id_ctgt và maHV

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
            header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            exit;
        }
    }

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

    // Bước 2: Callback từ MoMo (redirect sau khi thanh toán)
    public function momo_post()
    {
        if (!isset($_GET['resultCode'])) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ.';
            header('Location: /gym/user/chitiet_goitap');
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

        $id_ctgt = isset($extraDataDecoded['id_ctgt']) ? (int)$extraDataDecoded['id_ctgt'] : null;
        $maHV = isset($extraDataDecoded['maHV']) ? (int)$extraDataDecoded['maHV'] : null;

        if ($resultCode == 0) {
            // Thanh toán thành công
            $amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;
            $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
            $momo_status = 'Thành công';
            $link_data_json = json_encode($_GET);

            // Lưu giao dịch vào database
            if ($id_ctgt && $maHV) {
                $this->thanhToanGoiTapModel->storeTransaction($maHV, $id_ctgt, $amount, $momo_status, $link_data_json, $orderId);
                
                // KHÔNG tự động cập nhật - chờ admin xác nhận mới cập nhật
                $_SESSION['success'] = 'Thanh toán thành công! Vui lòng chờ admin xác nhận để kích hoạt gói tập.';
                header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            } else {
                $_SESSION['error'] = 'Thanh toán thành công nhưng không thể lưu thông tin. Vui lòng liên hệ admin.';
                header('Location: /gym/user/chitiet_goitap');
            }
        } else {
            // Thanh toán thất bại
            $amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;
            $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
            $momo_status = 'Thất bại';
            $link_data_json = json_encode($_GET);

            // Lưu giao dịch thất bại vào database
            if ($id_ctgt && $maHV) {
                $this->thanhToanGoiTapModel->storeTransaction($maHV, $id_ctgt, $amount, $momo_status, $link_data_json, $orderId);
            }

            $message = isset($_GET['message']) ? $_GET['message'] : 'Thanh toán thất bại.';
            $_SESSION['error'] = $message;
            
            if ($id_ctgt) {
                header('Location: /gym/user/chitiet_goitap/' . $id_ctgt);
            } else {
                header('Location: /gym/user/chitiet_goitap');
            }
        }
        exit;
    }

    // IPN (Instant Payment Notification) - MoMo gọi trực tiếp đến server
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

        $id_ctgt = isset($extraDataDecoded['id_ctgt']) ? (int)$extraDataDecoded['id_ctgt'] : null;
        $maHV = isset($extraDataDecoded['maHV']) ? (int)$extraDataDecoded['maHV'] : null;

        if ($resultCode == 0 && $id_ctgt && $maHV) {
            // Xác minh signature nếu cần
            $amount = isset($data['amount']) ? (float)$data['amount'] : 0;
            $orderId = isset($data['orderId']) ? $data['orderId'] : '';
            $momo_status = 'Thành công';
            $link_data_json = json_encode($data);

            // Lưu giao dịch
            $this->thanhToanGoiTapModel->storeTransaction($maHV, $id_ctgt, $amount, $momo_status, $link_data_json, $orderId);
            
            // KHÔNG tự động cập nhật - chờ admin xác nhận mới cập nhật
        }

        http_response_code(200);
        echo json_encode(['status' => 'success']);
        exit;
    }
}

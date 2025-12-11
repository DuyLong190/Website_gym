<?php
session_start();

require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/GoiTapController.php';
require_once 'app/controllers/DvThuGianController.php';
require_once 'app/controllers/LopHocController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/PtApiController.php';
require_once 'app/controllers/ChiTiet_Goitap_Controller.php';
require_once 'app/controllers/ThanhToanGoiTapController.php';
require_once 'app/controllers/ThanhToanHoaDonController.php';
require_once 'app/models/GoiTapModel.php';
require_once 'app/models/DvThuGianModel.php';
require_once 'app/models/LopHoc_Model.php';
require_once 'app/models/HoiVienModel.php';
require_once 'app/models/PtModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/models/RoleModel.php';
require_once 'app/models/AccountModel.php';
require_once 'app/models/ChiTiet_Goitap_Model.php';
require_once 'app/models/ThanhToanGoiTapModel.php';
require_once 'app/config/Database.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xử lý routing cho API (RESTful)
if (isset($url[0]) && $url[0] === 'api') {
    header('Content-Type: application/json');

    $resource = $url[1] ?? '';
    $controllerName = ucfirst($resource) . 'ApiController';

    // Hỗ trợ method override (PUT/DELETE qua POST với _method)
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    if ($requestMethod === 'POST' && isset($_POST['_method'])) {
        $requestMethod = strtoupper($_POST['_method']);
    }
    
    $id = $url[2] ?? null;
    $specialAction = $url[2] ?? null; // Để xử lý các action đặc biệt như 'search'

    // Mặc định action
    $action = 'index';
    $params = [];

    if ($requestMethod === 'GET') {
        // Xử lý search endpoint: GET /api/pt/search
        if ($specialAction === 'search') {
            $action = 'search';
            $params = [];
        } elseif (!empty($id) && is_numeric($id)) {
            $action = 'show';
            $params = [(int)$id];
        } else {
            $action = 'index';
        }
    } elseif ($requestMethod === 'POST') {
        $action = 'store';
    } elseif ($requestMethod === 'PUT') {
        $action = 'update';
        $params = !empty($id) ? [(int)$id] : [null];
    } elseif ($requestMethod === 'DELETE') {
        $action = 'delete';
        if (!empty($id)) { $params = [(int)$id]; }
    }
}
// Xử lý routing cho admin
else if (isset($url[0]) && $url[0] === 'admin') {
    $controllerName = 'AdminController';
    // Nếu có phần thứ 3 trong URL (ví dụ: admin/goitap/edit/1)
    if (isset($url[2])) {
        $action = $url[2];
        // Nếu có phần thứ 4 trong URL (ví dụ: admin/goitap/edit/1)
        if (isset($url[3])) {
            $params = array_slice($url, 3);
        } else {
            $params = [];
        }
    } 
    // Nếu có phần thứ 2 trong URL (ví dụ: admin/goitap)
    else if (isset($url[1])) {
        $action = 'index' . ucfirst($url[1]);
        $params = [];
    } 
    // Mặc định 
    else {
        $action = 'indexUser';
        $params = [];
    }
} else {
    // Route đặc biệt: Thanh toán MoMo cho gói tập
    if (isset($url[0]) && strtolower($url[0]) === 'thanhtoangoitap') {
        $controllerName = 'ThanhToanGoiTapController';
        $action = isset($url[1]) && $url[1] != '' ? $url[1] : '';
        $params = [];
    }
    // Route đặc biệt: Thanh toán MoMo cho dịch vụ và lớp học
    else if (isset($url[0]) && strtolower($url[0]) === 'thanhtoanhoadon') {
        $controllerName = 'ThanhToanHoaDonController';
        $action = isset($url[1]) && $url[1] != '' ? $url[1] : '';
        $params = [];
    }
    // Route đặc biệt: trang "Gói tập của tôi" và thanh toán cho user
    else if (isset($url[0], $url[1]) && $url[0] === 'user' && $url[1] === 'chitiet_goitap') {
$controllerName = 'ChiTiet_Goitap_Controller';

        // /user/chitiet_goitap/purchase/{id_ctgt}
        if (isset($url[2]) && $url[2] === 'purchase' && isset($url[3]) && is_numeric($url[3])) {
            $action = 'purchase';
            $params = [$url[3]];
        } else {
            // /user/chitiet_goitap hoặc /user/chitiet_goitap/{id_ctgt}
            $action = 'index_ctgt';
            if (isset($url[2]) && is_numeric($url[2])) {
                $params = [$url[2]];
            } else {
                $params = [];
            }
        }
    }
    // Route đặc biệt: đăng ký dịch vụ cho user
    else if (isset($url[0], $url[1], $url[2]) && $url[0] === 'user' && $url[1] === 'dichvu' && $url[2] === 'dangky_dichvu') {
        $controllerName = 'UserController';
        $action = 'dangky_dichvu';
        $params = [];
    }
    // Route đặc biệt: hủy đăng ký dịch vụ cho user
    else if (isset($url[0], $url[1], $url[2], $url[3]) && $url[0] === 'user' && $url[1] === 'dichvu' && $url[2] === 'huy_dangky_dichvu' && is_numeric($url[3])) {
        $controllerName = 'UserController';
        $action = 'huy_dangky_dichvu';
        $params = [(int)$url[3]];
    } else {
        if (isset($url[0]) && strtolower($url[0]) === 'pt') {
            $controllerName = 'PtApiController';
            $segment = $url[1] ?? '';
            switch ($segment) {
                case 'edit':
                    $action = 'edit';
                    break;
                case 'update':
                    $action = 'updateProfile';
                    break;
                case 'profile':
                case '':
                    $action = 'profile';
                    break;
                default:
                    $action = $segment;
            }
            $params = [];
        } else {
            // Xử lý routing thông thường
            $controllerMap = [
                'lophoc' => 'LopHocController',
                'dichvu' => 'DvThuGianController',
                'goitap' => 'GoiTapController',
                'user' => 'UserController',
                'pt' => 'PtApiController',
                'account' => 'AccountController',
            ];

            if (!empty($url[0])) {
                $key = strtolower($url[0]);
                $controllerName = $controllerMap[$key] ?? ucfirst($key) . 'Controller';
            } else {
                $controllerName = 'HomeController';
            }
            $action = isset($url[1]) && $url[1] != '' ? $url[1] : '';
        }
    }

    // Xác định action mặc định dựa trên controller
    if (empty($action)) {
        switch ($controllerName) {
            case 'HomeController':
                $action = 'indexHome';
                $params = [];
                break;
            case 'DvThuGianController':
                $action = 'indexDVTG';
                $params = [];
                break;
            case 'LopHocController':
                $action = 'indexLopHoc';
                $params = [];
                break;
            case 'GoiTapController':
                $action = 'indexGoiTap';
                $params = [];
                break;
            case 'UserController':
                $action = 'profile';
                $params = [];
                break;
            case 'PtApiController':
                $action = 'profile';
                $params = [];
                break;
            case 'AccountController':
                $action = 'indexAccount';
                $params = [];
                break;
            case 'Chitiet_Goitap_Controller':
                $action = 'index_ctgt';
                $params = [];
                break;
            default:
                $action = 'indexHoiVien';
                $params = [];
        }
    } else {
        // Xử lý params cho các action có tham số
        if (isset($url[2]) && is_numeric($url[2])) {
            $params = [$url[2]];
        }
    }
}

// Kiểm tra và load controller
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    header('HTTP/1.1 404 Not Found');
    if (isset($url[0]) && $url[0] === 'api') {
        die(json_encode(['error' => 'Controller not found']));
    }
    die('Không tìm thấy Controller: '.$controllerName);
}
require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    header('HTTP/1.1 404 Not Found');
    if (isset($url[0]) && $url[0] === 'api') {
        die(json_encode(['error' => 'Method not found']));
    }
    die('Không tìm thấy Action '.$action.' trong Controller '.$controllerName);
}

// Gọi action với các tham số
try {
    $result = call_user_func_array([$controller, $action], $params ?? []);
    if (isset($url[0]) && $url[0] === 'api') {
        echo json_encode($result);
    }
} catch (Exception $e) {
    if (isset($url[0]) && $url[0] === 'api') {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    } else {
        throw $e;
    }
}

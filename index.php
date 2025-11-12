<?php
session_start();
require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/GoiTapController.php';
require_once 'app/controllers/DvThuGianController.php';
require_once 'app/controllers/DvTapLuyenController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/PtApiController.php';
require_once 'app/models/GoiTapModel.php';
require_once 'app/models/DvThuGianModel.php';
require_once 'app/models/DvTapLuyenModel.php';
require_once 'app/models/HoiVienModel.php';
require_once 'app/models/PtModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/models/RoleModel.php';
require_once 'app/models/AccountModel.php';

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
        $action = 'indexGoiTap';
        $params = [];
    }
} else {
    // Xử lý routing thông thường
    $controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
    $action = isset($url[1]) && $url[1] != '' ? $url[1] : '';

    // Xác định action mặc định dựa trên controller
    if (empty($action)) {
        switch ($controllerName) {
            case 'HomeController':
                $action = 'indexHome';
                break;
            case 'DvThuGianController':
                $action = 'indexDVTG';
                break;
            case 'DvTapLuyenController':
                $action = 'indexDVTL';
                break;
            case 'GoiTapController':
                $action = 'indexGoiTap';
                break;
            case 'UserController':
                $action = 'profile';
                break;
            case 'PtApiController':
                $action = 'indexPT';
                break;
            case 'AccountController':
                $action = 'indexAccount';
                break;
            default:
                $action = 'indexGoiTap';
        }
    }
    
    // Xử lý params cho các action có tham số
    if (isset($url[2]) && is_numeric($url[2])) {
        $params = [$url[2]];
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

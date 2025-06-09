<?php
session_start();
require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/GoiTapController.php';
require_once 'app/controllers/DvThuGianController.php';
require_once 'app/controllers/DvTapLuyenController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/models/GoiTapModel.php';
require_once 'app/models/DvThuGianModel.php';
require_once 'app/models/DvTapLuyenModel.php';
require_once 'app/models/HoiVienModel.php';
require_once 'app/helpers/SessionHelper.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xử lý routing cho admin
if (isset($url[0]) && $url[0] === 'admin') {
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
            default:
                $action = 'indexGoiTap';
        }
    }
}

// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý khi không tìm thấy controller
    die('Không tìm thấy Controller: '.$controllerName);
}
require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    // Xử lý khi không tìm thấy action
    die('Không tìm thấy Action '.$action.' trong Controller '.$controllerName);
}

// Gọi action với các tham số còn lại (nếu có)
if (isset($params)) {
    call_user_func_array([$controller, $action], $params);
} else if (isset($url[2])) {
    call_user_func_array([$controller, $action], array_slice($url, 2));
} else {
    call_user_func_array([$controller, $action], []);
}

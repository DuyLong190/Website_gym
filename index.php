<?php
session_start();
require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/GoiTapController.php';
require_once 'app/controllers/DvThuGianController.php';
require_once 'app/controllers/DvTapLuyenController.php';
require_once 'app/models/GoiTapModel.php';
require_once 'app/models/DvThuGianModel.php';
require_once 'app/helpers/SessionHelper.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// Kiểm tra phần thứ hai của URL để xác định action
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
            $action ='indexDVTL';
            break;
        default:
            $action = 'indexGoiTap';
    }
}

// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý khi không tìm thấy controller
    die('Không tìm thấy Controller '.$controllerName);
}
require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    // Xử lý khi không tìm thấy action
    die('Không tìm thấy Action '.$action.' trong Controller '.$controllerName);
}
// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));

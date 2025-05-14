<?php
session_start();

// Định nghĩa hằng số cho thư mục gốc
define('BASE_PATH', __DIR__);

// Tải các file cần thiết
require_once BASE_PATH . '/app/controllers/GoiTapController.php';
require_once BASE_PATH . '/app/controllers/HomeController.php';
require_once BASE_PATH . '/app/helpers/SessionHelper.php';

// Lấy URL và làm sạch
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Tạo instance của controller
if (class_exists($controllerName)) {
    $controller = new GoiTapController();
} else {
    $controller = new HomeController();
}

// Lấy action từ URL (mặc định là 'indexGoiTap')
$action = isset($_GET['action']) ? $_GET['action'] : 'indexGoiTap';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Gọi action tương ứng
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    // Nếu action không tồn tại, chuyển về trang chủ
    $controller = new HomeController();
    $controller->index();
}

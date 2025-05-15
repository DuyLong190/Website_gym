<?php
session_start();
require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/GoiTapController.php';
require_once 'app/models/GoiTapModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Check the first part of the URL to determine the controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'GoiTapController';

// Check the second part of the URL to determine the action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'indexGoiTap';

// die ("controller=$controllerName - action=$action");
// Check if controller and action exist
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Handle not finding controller
    die('Controller not found '.$controllerName);
}
require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    // Handle action not found
    die('Action not found');
}
// Call action with remaining parameters (if any)
call_user_func_array([$controller, $action], array_slice($url, 2));

<?php
require_once ('app/config/database.php');
require_once ('app/models/AccountModel.php');

class AccountController
{
    private $db;
    private $accountModel;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = new Database();
        $this->accountModel = new AccountModel($this->db->getConnection());
    }

    function login()
    {
        include 'app/views/account/login.php';
    }

    function signup()
    {
        include 'app/views/account/signup.php';
    }

    // Hàm xử lý đăng nhập
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui long nhap userName!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui long nhap password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung";
            }

            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getUserByUsername($username);

            if ($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/signup.php';
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                $result = $this->accountModel->save($username, $fullName, $password);

                if ($result) {
                    header('Location: /app/views/account/login.php');
                }
            }
        }
    }

    function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/product');
    }
    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra thông tin đăng nhập
            $account = $this->accountModel->getUserByUsername($username);

            if ($account) {
                $pwd_hash = $account->password;
                if (password_verify($password, $pwd_hash)) {
                    session_start();
                    // Lưu thông tin người dùng vào session
                    $_SESSION['username'] = $account->username;
                    
                    header('Location: /Gym/header.php');
                } else {
                    $loginMessage = "Sai tên đăng nhập hoặc mật khẩu.";
                    include 'app/views/account/login.php';
                }
            }
        }
    }
}
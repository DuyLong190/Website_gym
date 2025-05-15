<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AccountModel.php';

class AccountController
{
    private $accountModel;
    private $db;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register()
    {
        include_once 'app/views/account/register.php';
    }

    public function login()
    {
        include_once 'app/views/account/login.php';
    }

    // Hàm xử lý đăng ký
    function save()
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
            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                $result = $this->accountModel->save($username, $fullName, $password);

                if ($result) {
                    header('Location: /Gym/account/login');
                }
            }
        }
    }

    function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /Gym');
    }
    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra thông tin đăng nhập
            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $pwd_hash = $account->password;
                if (password_verify($password, $pwd_hash)) {

                    session_start();
                    // Lưu thông tin người dùng vào session
                    $_SESSION['username'] = $account->username;

                    header('Location: /Gym');
                    exit;
                } else {
                    echo "Mật khẩu không đúng!";
                }
            } else {
                echo "Tài khoản không tồn tại!";
            }
        }
    }
}

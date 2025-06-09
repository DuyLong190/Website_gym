<?php
require_once('app/config/database.php');
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/HoiVienModel.php';

class AccountController
{
    private $accountModel;
    private $db;
    private $hoiVienModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
    }

    function register()
    {
        include_once 'app/views/account/register.php';
    }

    public function login()
    {
        include_once 'app/views/account/login.php';
    }

    function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $HoTen = $_POST['HoTen'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập tên đăng nhập!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu!";
            }
            if (empty($HoTen)) {
                $errors['HoTen'] = "Vui lòng nhập họ và tên!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận không khớp";
            }
            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }
            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                try {
                    // Bắt đầu transaction
                    $this->db->beginTransaction();

                    // Thêm hội viên trước
                    $hoiVienModel = new HoiVienModel($this->db);
                    $maHV = $hoiVienModel->addHoiVien($HoTen, null, null, null, null, null, null);

                    if (!$maHV) {
                        throw new Exception("Không thể thêm thông tin hội viên");
                    }

                    // Mã hóa mật khẩu
                    $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                    // Thêm tài khoản với MaHV vừa tạo
                    $result = $this->accountModel->save($username, $HoTen, $password, 1, $maHV);

                    if (!$result) {
                        throw new Exception("Không thể thêm tài khoản");
                    }

                    // Commit transaction
                    $this->db->commit();
                    header('Location: /gym/account/login');
                    exit;
                } catch (Exception $e) {
                    // Rollback nếu có lỗi
                    $this->db->rollBack();
                    $errors['system'] = "Có lỗi xảy ra: " . $e->getMessage();
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['role_id']);
        header('Location: /gym');
    }

    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $pwd_hashed = $account->password;
                if (password_verify($password, $pwd_hashed)) {
                    session_start();
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role_id'] = $account->role_id;
                    $_SESSION['role_name'] = $account->role_name;
                    
                    // Lấy thông tin hội viên
                    $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);
                    if ($hoiVien) {
                        $_SESSION['HoTen'] = $hoiVien->HoTen;
                    }
                    
                    header('Location: /gym');
                    exit;
                } else {
                    echo "<script>alert('Mật khẩu không đúng.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Không tìm thấy tài khoản.'); window.history.back();</script>";
            }
        }
    }

    public function profile()
    {
        include_once 'app/views/account/profile.php';
    }
}

<?php 
require_once('app/config/database.php');
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/PTModel.php';
require_once __DIR__ . '/../models/HoiVienModel.php';

class AccountController
{
    private $accountModel;
    private $db;
    private $roleModel;
    private $hoiVienModel;
    private $ptModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->roleModel = new RoleModel($this->db);
        $this->hoiVienModel = new HoiVienModel($this->db);
        // File model định nghĩa class PtModel
        $this->ptModel = new PtModel($this->db);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Lấy danh sách roles từ database (chỉ lấy user và pt role, không hiển thị admin)
            $roles = array_filter($this->roleModel->getAllRoles(), function($role) {
                return $role->role_id != 0; // Loại bỏ admin role
            });
            
            require_once __DIR__ . '/../views/account/register.php';
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->save();
        }
    }

    public function save()
    {
        // Lấy dữ liệu từ form
        $username = $_POST['username'] ?? '';
        $HoTen = $_POST['HoTen'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmpassword'] ?? '';
        $role_id = $_POST['role_id'] ?? 1; // 1: user, 2: pt
        $email = $_POST['email'] ?? '';
        $NgaySinh = $_POST['NgaySinh'] ?? null;
        $GioiTinh = $_POST['GioiTinh'] ?? null;
        $SDT = $_POST['SDT'] ?? '';
        $DiaChi = $_POST['DiaChi'] ?? '';
        $ChuyenMon = $_POST['chuyenMon'] ?? '';
        $KinhNghiem = !empty($_POST['kinhNghiem']) ? (int)$_POST['kinhNghiem'] : 0;
        $Luong = !empty($_POST['luong']) ? (int)$_POST['luong'] : 0;

        // Validation
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'Tên tài khoản không được để trống';
        }
        if (empty($HoTen)) {
            $errors['HoTen'] = 'Họ và tên không được để trống';
        }
        if (empty($password)) {
            $errors['password'] = 'Mật khẩu không được để trống';
        }
        if ($password !== $confirmPassword) {
            $errors['confirmPass'] = 'Mật khẩu không khớp';
        }
        if (strlen($password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }

        // Kiểm tra username đã tồn tại
        $existingUser = $this->accountModel->getAccountByUsername($username);
        if ($existingUser) {
            $errors['username'] = 'Tên tài khoản đã tồn tại';
        }

        // Nếu có lỗi, hiển thị form lại
        if (!empty($errors)) {
            $roles = array_filter($this->roleModel->getAllRoles(), function($role) {
                return $role->role_id != 0;
            });
            require_once __DIR__ . '/../views/account/register.php';
            return;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Transaction: tạo hồ sơ trước, sau đó tạo account với MaHV/pt_id
            $this->db->beginTransaction();

            $maHV = null;
            $pt_id = null;

            if ($role_id == 1) { // User/Hội viên
                // addHoiVien(HoTen, NgaySinh, GioiTinh, ChieuCao, CanNang, SDT, Email, DiaChi, MaGoiTap)
                $maHV = $this->hoiVienModel->addHoiVien(
                    $HoTen,
                    $NgaySinh,
                    $GioiTinh,
                    null,
                    null,
                    $SDT,
                    $email,
                    $DiaChi,
                    null
                );
                if (!$maHV) {
                    throw new Exception('Không thể tạo hồ sơ hội viên');
                }
            } elseif ($role_id == 2) { // PT/Huấn luyện viên
                $pt_id = $this->ptModel->addPT(
                    $HoTen,
                    $NgaySinh,
                    $GioiTinh,
                    $SDT,
                    $email,
                    $DiaChi,
                    $ChuyenMon,
                    $KinhNghiem,
                    $Luong
                );
                if (!$pt_id) {
                    throw new Exception('Không thể tạo hồ sơ huấn luyện viên');
                }
            }

            $saved = $this->accountModel->save(
                $username,
                $HoTen,
                $hashedPassword,
                $role_id,
                $role_id == 1 ? $maHV : null,
                $role_id == 2 ? $pt_id : null
            );

            if (!$saved) {
                throw new Exception('Không thể tạo tài khoản');
            }

            $this->db->commit();

            // Đăng ký thành công
            $_SESSION['success_message'] = 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.';
            header('Location: /gym/account/login');
            exit;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $errors['system'] = $e->getMessage();
            $roles = array_filter($this->roleModel->getAllRoles(), function($role) {
                return $role->role_id != 0;
            });
            require_once __DIR__ . '/../views/account/register.php';
        }
    }

    public function login()
    {
        include_once 'app/views/account/login.php';
    }


    function logout()
    {
        session_destroy();
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

                    // Thiết lập thông tin hiển thị mặc định từ bảng account
                    $_SESSION['HoTen'] = $account->HoTen;

                    if ((int)$account->role_id === 1) {
                        // Lấy thông tin hội viên
                        $hoiVien = $this->hoiVienModel->getHoiVienByUsername($username);
                        if ($hoiVien) {
                            $_SESSION['HoTen'] = $hoiVien->HoTen;
                            $_SESSION['MaHV'] = $hoiVien->MaHV;
                        }
                    } elseif ((int)$account->role_id === 2 && !empty($account->pt_id)) {
                        $pt = $this->ptModel->getPTById((int)$account->pt_id);
                        if ($pt) {
                            $_SESSION['HoTen'] = $pt->HoTen;
                            $_SESSION['pt_id'] = $pt->pt_id;
                        }
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

    public function updateRole()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 0) {
            header('Location: /gym/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $accountId = $_POST['account_id'] ?? '';
            $roleId = $_POST['role_id'] ?? '';

            if ($accountId && $roleId !== '') {
                $this->accountModel->updateRole($accountId, $roleId);
            }

            header('Location: /gym/admin/dashboard');
            exit;
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /gym/admin/accounts');
                exit;
            }

            try {
                $this->db->beginTransaction();

                $links = $this->accountModel->getAccountLinksById($id);
                if (!$links) {
                    throw new Exception('Tài khoản không tồn tại');
                }

                if ((int)$links->role_id === 1 && !empty($links->MaHV)) {
                    $ok = $this->hoiVienModel->deleteOnlyHoiVien((int)$links->MaHV);
                    if (!$ok) {
                        throw new Exception('Không thể xóa hồ sơ hội viên');
                    }
                }

                if ((int)$links->role_id === 2 && !empty($links->pt_id)) {
                    $ok = $this->ptModel->deletePT((int)$links->pt_id);
                    if (!$ok) {
                        throw new Exception('Không thể xóa hồ sơ huấn luyện viên');
                    }
                }

                $ok = $this->accountModel->deleteAccount((int)$id);
                if (!$ok) {
                    throw new Exception('Không thể xóa tài khoản');
                }

                $this->db->commit();
                header('Location: /gym/admin/accounts');
                exit;
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                $_SESSION['error'] = $e->getMessage();
                header('Location: /gym/admin/accounts');
                exit;
            }
        }
    }
}

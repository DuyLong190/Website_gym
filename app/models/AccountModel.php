<?php
class AccountModel
{
    private $conn;
    private $table_name = 'account';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy người dùng theo username
    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    //Lưu tài khoản
    public function save($username, $name, $password, $role= "user")
    {
        $query = "INSERT INTO " .$this->table_name . "(username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        return false;
        //$stmt->bindParam(':password', password_hash($data['password'], PASSWORD_BCRYPT));

    }
}
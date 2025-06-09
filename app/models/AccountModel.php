<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT a.id, a.username, a.HoTen, a.password, a.role_id, r.role_name 
                FROM account a 
                JOIN role r ON a.role_id = r.role_id 
                WHERE a.username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function save($username, $HoTen, $password, $role_id = 1, $maHV = null)
    {
        $query = "INSERT INTO " . $this->table_name . "(username, HoTen, password, role_id, MaHV) 
                 VALUES (:username, :HoTen, :password, :role_id, :maHV)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($username));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':HoTen', $HoTen);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':maHV', $maHV);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}

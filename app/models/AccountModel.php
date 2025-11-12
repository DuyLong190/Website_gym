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

    function save($username, $HoTen, $password, $role_id = 1, $maHV = null, $pt_id = null)
    {
        $query = "INSERT INTO " . $this->table_name . "(username, HoTen, password, role_id, MaHV, pt_id) 
                 VALUES (:username, :HoTen, :password, :role_id, :maHV, :pt_id)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($username));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':HoTen', $HoTen);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':maHV', $maHV, $maHV ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindParam(':pt_id', $pt_id, $pt_id ? PDO::PARAM_INT : PDO::PARAM_NULL);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function updateRole($accountId, $roleId)
    {
        $query = "UPDATE {$this->table_name} SET role_id = :roleId WHERE id = :accountId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllAccounts()
    {
        $query = "SELECT a.id, a.username, a.HoTen, r.role_name, r.role_id
                  FROM account a
                  JOIN role r ON a.role_id = r.role_id
                  ORDER BY a.id ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAccountById($id)
    {
        $query = "SELECT a.id, a.username, a.HoTen, a.role_id, r.role_name 
                FROM account a 
                JOIN role r ON a.role_id = r.role_id 
                WHERE a.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy thông tin liên kết để xóa kèm hồ sơ
    public function getAccountLinksById($id)
    {
        $query = "SELECT id, role_id, MaHV, pt_id FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function deleteAccount($id)
    {
        try {
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

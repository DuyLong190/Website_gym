<?php

class RoleModel
{
    private $conn;
    private $table_name = "role";  

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllRoles()
    {
        $sql = "SELECT role_id, role_name FROM role ORDER BY role_id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

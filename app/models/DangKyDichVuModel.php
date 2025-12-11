<?php
class DangKyDichVuModel
{
    private $conn;
    private $table_name = 'DangKyDichVu';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả đăng ký dịch vụ
    public function getAllDangKy()
    {
        try {
            $query = "SELECT dk.*, hv.HoTen, hv.SDT, hv.Email, dv.TenTG, dv.GiaTG, dv.ThoiGianTG
                      FROM " . $this->table_name . " dk
                      LEFT JOIN hoivien hv ON dk.MaHV = hv.MaHV
                      LEFT JOIN dichvuthugian dv ON dk.id_dv = dv.id
                      ORDER BY dk.NgayDangKy DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in getAllDangKy: " . $e->getMessage());
            return [];
        }
    }

    // Lấy đăng ký dịch vụ theo ID
    public function getDangKyById($id)
    {
        try {
            $query = "SELECT dk.*, hv.HoTen, hv.SDT, hv.Email, dv.TenTG, dv.GiaTG, dv.ThoiGianTG, dv.MoTaTG
                      FROM " . $this->table_name . " dk
                      LEFT JOIN hoivien hv ON dk.MaHV = hv.MaHV
                      LEFT JOIN dichvuthugian dv ON dk.id_dv = dv.id
                      WHERE dk.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in getDangKyById: " . $e->getMessage());
            return null;
        }
    }

    // Lấy đăng ký dịch vụ theo MaHV
    public function getDangKyByMaHV($maHV)
    {
        try {
            $query = "SELECT dk.*, dv.TenTG, dv.GiaTG, dv.ThoiGianTG, dv.MoTaTG
                      FROM " . $this->table_name . " dk
                      LEFT JOIN dichvuthugian dv ON dk.id_dv = dv.id
                      WHERE dk.MaHV = :maHV
                      ORDER BY dk.NgayDangKy DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':maHV', $maHV, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in getDangKyByMaHV: " . $e->getMessage());
            return [];
        }
    }

    // Tạo đăng ký dịch vụ mới
    public function createDangKy($maHV, $id_dv, $ngaySuDung, $gioSuDung, $ghiChu = null)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
            if (empty($maHV) || empty($id_dv) || empty($ngaySuDung) || empty($gioSuDung)) {
                error_log("createDangKy: Missing required parameters - MaHV: $maHV, id_dv: $id_dv, NgaySuDung: $ngaySuDung, GioSuDung: $gioSuDung");
                return false;
            }
            
            $query = "INSERT INTO " . $this->table_name . " (MaHV, id_dv, NgaySuDung, GioSuDung, TrangThai, GhiChu)
                      VALUES (:MaHV, :id_dv, :NgaySuDung, :GioSuDung, 'Chờ xác nhận', :GhiChu)";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                $errorInfo = $this->conn->errorInfo();
                error_log("createDangKy: Prepare failed - " . print_r($errorInfo, true));
                return false;
            }
            
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':id_dv', $id_dv, PDO::PARAM_INT);
            $stmt->bindParam(':NgaySuDung', $ngaySuDung);
            $stmt->bindParam(':GioSuDung', $gioSuDung);
            $stmt->bindParam(':GhiChu', $ghiChu);
            
            if ($stmt->execute()) {
                $lastId = $this->conn->lastInsertId();
                error_log("createDangKy: Success - Inserted ID: $lastId");
                return $lastId;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("createDangKy: Execute failed - " . print_r($errorInfo, true));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error in createDangKy: " . $e->getMessage());
            error_log("Error in createDangKy: SQL - " . $query);
            error_log("Error in createDangKy: Params - MaHV: $maHV, id_dv: $id_dv, NgaySuDung: $ngaySuDung, GioSuDung: $gioSuDung");
            return false;
        }
    }

    // Xác nhận đăng ký dịch vụ
    public function confirmDangKy($id)
    {
        try {
            $query = "UPDATE " . $this->table_name . "
                      SET TrangThai = 'Đã xác nhận', updated_at = NOW()
                      WHERE id = :id AND TrangThai = 'Chờ xác nhận'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error in confirmDangKy: " . $e->getMessage());
            return false;
        }
    }

    // Hủy đăng ký dịch vụ
    public function cancelDangKy($id)
    {
        try {
            $query = "UPDATE " . $this->table_name . "
                      SET TrangThai = 'Đã hủy', updated_at = NOW()
                      WHERE id = :id AND TrangThai IN ('Chờ xác nhận', 'Đã xác nhận')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error in cancelDangKy: " . $e->getMessage());
            return false;
        }
    }

    // Hoàn thành dịch vụ
    public function completeDangKy($id)
    {
        try {
            $query = "UPDATE " . $this->table_name . "
                      SET TrangThai = 'Đã hoàn thành', updated_at = NOW()
                      WHERE id = :id AND TrangThai = 'Đã xác nhận'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error in completeDangKy: " . $e->getMessage());
            return false;
        }
    }

    // Đếm số đăng ký theo trạng thái
    public function countByStatus($status = null)
    {
        try {
            if ($status) {
                $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE TrangThai = :status";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':status', $status);
            } else {
                $query = "SELECT COUNT(*) as count FROM " . $this->table_name;
                $stmt = $this->conn->prepare($query);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? (int)$result->count : 0;
        } catch (PDOException $e) {
            error_log("Error in countByStatus: " . $e->getMessage());
            return 0;
        }
    }
}


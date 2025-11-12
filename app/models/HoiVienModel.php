<?php
class HoiVienModel 
{
    private $conn;
    private $table_name = 'hoivien';

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    // Lấy tất cả hội viên (chỉ những người có role_id = 1, tức là User)
    public function getAllHoiVien() {
        $query = "SELECT h.*, g.TenGoiTap, a.username, a.role_id 
                FROM HoiVien h 
                LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap 
                LEFT JOIN Account a ON h.MaHV = a.MaHV
                WHERE a.role_id = 1 OR a.role_id IS NULL
                ORDER BY h.MaHV DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getHoiVienById($maHV) {
        try {
            $query = "SELECT h.*, g.TenGoiTap FROM HoiVien h 
                    LEFT JOIN ACCOUNT a ON h.MaHV = a.MaHV
                    LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap 
                    WHERE h.MaHV = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$maHV]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in getHoiVienById: " . $e->getMessage());
            return null;
        }
    }

    public function addHoiVien($HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $MaGoiTap) {
        try {
            // Validate required fields
            if (empty($HoTen)) {
                throw new Exception("Họ tên không được để trống");
            }

            // Chuẩn bị câu query
            $query = "INSERT INTO HoiVien (HoTen, NgaySinh, GioiTinh, ChieuCao, CanNang, SDT, Email, DiaChi, MaGoiTap) 
                    VALUES (:HoTen, :NgaySinh, :GioiTinh, :ChieuCao, :CanNang, :SDT, :Email, :DiaChi, :MaGoiTap)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $HoTen = htmlspecialchars(strip_tags($HoTen));
            $NgaySinh = $NgaySinh ? htmlspecialchars(strip_tags($NgaySinh)) : null;
            $GioiTinh = $GioiTinh ? htmlspecialchars(strip_tags($GioiTinh)) : null;
            $ChieuCao = $ChieuCao ? htmlspecialchars(strip_tags($ChieuCao)) : null;
            $CanNang = $CanNang ? htmlspecialchars(strip_tags($CanNang)) : null;
            $SDT = $SDT ? htmlspecialchars(strip_tags($SDT)) : null;
            $Email = $Email ? htmlspecialchars(strip_tags($Email)) : null;
            $DiaChi = $DiaChi ? htmlspecialchars(strip_tags($DiaChi)) : null;
            $MaGoiTap = $MaGoiTap ? htmlspecialchars(strip_tags($MaGoiTap)) : null;

            // Bind các tham số
            $stmt->bindParam(':HoTen', $HoTen);
            $stmt->bindParam(':NgaySinh', $NgaySinh);
            $stmt->bindParam(':GioiTinh', $GioiTinh);
            $stmt->bindParam(':ChieuCao', $ChieuCao);
            $stmt->bindParam(':CanNang', $CanNang);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);

            // Thực thi query
            if ($stmt->execute()) {
                return $this->conn->lastInsertId(); // Trả về MaHV vừa được tạo
            }
            
            // If execution fails but no exception is thrown
            $error = $stmt->errorInfo();
            error_log("Error in addHoiVien execution: " . print_r($error, true));
            throw new Exception("Không thể thêm hội viên: " . $error[2]);
            
        } catch (PDOException $e) {
            error_log("PDO Error in addHoiVien: " . $e->getMessage());
            throw new Exception("Lỗi cơ sở dữ liệu: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("Error in addHoiVien: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateHoiVien($MaHV, $HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $MaGoiTap, $TrangThai) {
        try {
            $query = "UPDATE " . $this->table_name . " SET HoTen = :HoTen, 
                        NgaySinh = :NgaySinh, 
                        GioiTinh = :GioiTinh,
                        ChieuCao = :ChieuCao,
                        CanNang = :CanNang,
                        SDT = :SDT, 
                        Email = :Email, 
                        DiaChi = :DiaChi, 
                        MaGoiTap = :MaGoiTap, 
                        TrangThai = :TrangThai 
                    WHERE MaHV = :MaHV";
            $stmt = $this->conn->prepare($query);

            // Bind các tham số
            $stmt->bindParam(':MaHV', $MaHV);
            $stmt->bindParam(':HoTen', $HoTen);
            $stmt->bindParam(':NgaySinh', $NgaySinh);
            $stmt->bindParam(':GioiTinh', $GioiTinh);
            $stmt->bindParam(':ChieuCao', $ChieuCao);
            $stmt->bindParam(':CanNang', $CanNang);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);
            $stmt->bindParam(':TrangThai', $TrangThai);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updateHoiVien: " . $e->getMessage());
            return false;
        }
    }

    public function deleteHoiVien($maHV) {
        try {
            // Bắt đầu transaction
            $this->conn->beginTransaction();

            // Xóa tài khoản trước
            $queryAccount = "DELETE FROM Account WHERE MaHV = ?";
            $stmtAccount = $this->conn->prepare($queryAccount);
            $stmtAccount->execute([$maHV]);

            // Sau đó xóa hội viên
            $queryHoiVien = "DELETE FROM HoiVien WHERE MaHV = ?";
            $stmtHoiVien = $this->conn->prepare($queryHoiVien);
            $stmtHoiVien->execute([$maHV]);

            // Commit transaction nếu mọi thứ OK
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            // Rollback nếu có lỗi
            $this->conn->rollBack();
            error_log("Error in deleteHoiVien: " . $e->getMessage());
            return false;
        }
    }

    public function searchHoiVien($keyword) {
        $query = "SELECT h.*, g.TenGoiTap, a.username, a.role_id 
                FROM HoiVien h 
                LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap 
                LEFT JOIN Account a ON h.MaHV = a.MaHV
                WHERE (h.HoTen LIKE ? OR h.SDT LIKE ? OR h.Email LIKE ?)
                AND (a.role_id = 1 OR a.role_id IS NULL)
                ORDER BY h.MaHV DESC";
        $stmt = $this->conn->prepare($query);
        $keyword = "%$keyword%";
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteOnlyHoiVien($maHV) {
        try {
            $query = "DELETE FROM HoiVien WHERE MaHV = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$maHV]);
        } catch (PDOException $e) {
            error_log("Error in deleteOnlyHoiVien: " . $e->getMessage());
            return false;
        }
    }

    public function getHoiVienByUsername($username) {
        try {
            $sql = "SELECT h.*, g.TenGoiTap FROM HoiVien h 
                    INNER JOIN Account a ON h.MaHV = a.MaHV 
                    LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap
                    WHERE a.username = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in getHoiVienByUsername: " . $e->getMessage());
            return false;
        }
    }

    public function updateHoiVienProfile($maHV, $HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi) {
        try {
            // Lấy thông tin hiện tại của hội viên
            $currentInfo = $this->getHoiVienById($maHV);
            if (!$currentInfo) {
                return false;
            }

            // Sử dụng giá trị hiện tại nếu không có giá trị mới
            $HoTen = $HoTen ?: $currentInfo->HoTen;
            $NgaySinh = $NgaySinh ?: $currentInfo->NgaySinh;
            $GioiTinh = $GioiTinh ?: $currentInfo->GioiTinh;
            $ChieuCao = $ChieuCao ?: $currentInfo->ChieuCao;
            $CanNang = $CanNang ?: $currentInfo->CanNang;
            $SDT = $SDT ?: $currentInfo->SDT;
            $Email = $Email ?: $currentInfo->Email;
            $DiaChi = $DiaChi ?: $currentInfo->DiaChi;

            $sql = "UPDATE HoiVien 
                    SET HoTen = ?, NgaySinh = ?, GioiTinh = ?, ChieuCao = ?, CanNang = ?, SDT = ?, Email = ?, DiaChi = ? 
                    WHERE MaHV = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$HoTen, $NgaySinh, $GioiTinh, $ChieuCao, $CanNang, $SDT, $Email, $DiaChi, $maHV]);
        } catch (PDOException $e) {
            error_log("Error in updateHoiVienProfile: " . $e->getMessage());
            return false;
        }
    }

    public function updateGoiTap($maHV, $maGoiTap) {
        try {
            $query = "UPDATE HoiVien 
                    SET MaGoiTap = ?, NgayDangKy = CURRENT_TIMESTAMP 
                    WHERE MaHV = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$maGoiTap, $maHV]);
        } catch (PDOException $e) {
            error_log("Error in updateGoiTap: " . $e->getMessage());
            return false;
        }
    }
}

<?php
class HoiVienModel 
{
    private $conn;
    private $table_name = 'hoivien';

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    // Lấy tất cả hội viên
    public function getAllHoiVien() {
        $query = "SELECT h.*, g.TenGoiTap FROM HoiVien h 
                LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap ORDER BY h.MaHV DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getHoiVienById($maHV) {
        try {
            $query = "SELECT h.*, g.TenGoiTap 
                     FROM HoiVien h 
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

    public function addHoiVien($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $MaGoiTap) {
        try {
            // Chuẩn bị câu query
            $query = "INSERT INTO " . $this->table_name . " (HoTen, NgaySinh, GioiTinh, SDT, Email, DiaChi, MaGoiTap) 
                     VALUES (:HoTen, :NgaySinh, :GioiTinh, :SDT, :Email, :DiaChi, :MaGoiTap)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $HoTen = htmlspecialchars(strip_tags($HoTen));
            $NgaySinh = htmlspecialchars(strip_tags($NgaySinh));
            $GioiTinh = htmlspecialchars(strip_tags($GioiTinh));
            $SDT = htmlspecialchars(strip_tags($SDT));
            $Email = htmlspecialchars(strip_tags($Email));
            $DiaChi = htmlspecialchars(strip_tags($DiaChi));
            $MaGoiTap = htmlspecialchars(strip_tags($MaGoiTap));

            // Bind các tham số
            $stmt->bindParam(':HoTen', $HoTen);
            $stmt->bindParam(':NgaySinh', $NgaySinh);
            $stmt->bindParam(':GioiTinh', $GioiTinh);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);

            // Thực thi query
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Log lỗi nếu cần
            return false;
        }
    }

    public function updateHoiVien($MaHV, $HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $MaGoiTap, $TrangThai) {
        try {
            $query = "UPDATE " . $this->table_name . " 
                     SET HoTen = :HoTen, 
                         NgaySinh = :NgaySinh, 
                         GioiTinh = :GioiTinh, 
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
        $query = "DELETE FROM HoiVien WHERE MaHV = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$maHV]);
    }

    public function searchHoiVien($keyword) {
        $query = "SELECT h.*, g.TenGoiTap 
                 FROM HoiVien h 
                 LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap 
                 WHERE h.HoTen LIKE ? OR h.SDT LIKE ? OR h.Email LIKE ?
                 ORDER BY h.MaHV DESC";
        $stmt = $this->conn->prepare($query);
        $keyword = "%$keyword%";
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
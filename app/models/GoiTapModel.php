<?php
class GoiTapModel
{
    private $conn;
    private $table_name = 'goitap';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả các gói tập
    public function getGoiTaps()
    {
        try {
            $query = "SELECT MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getGoiTaps: " . $e->getMessage());
            return [];
        }
    }

    // Lấy gói tập theo ID
    public function getByMaGoiTap($MaGoiTap)
    {
        // Debug
        error_log("GoiTapModel::getByMaGoiTap - Input MaGoiTap: " . $MaGoiTap);
        
        // Chuyển đổi MaGoiTap thành số nếu có thể
        if (is_numeric($MaGoiTap)) {
            $MaGoiTap = (int)$MaGoiTap;
        }
        
        $query  = "SELECT * FROM " . $this->table_name . " WHERE MaGoiTap = :MaGoiTap";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':MaGoiTap', $MaGoiTap, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        // Debug
        error_log("GoiTapModel::getByMaGoiTap - Query result: " . print_r($result, true));
        
        return $result;
    }

    // Thêm mới gói tập
    public function addGoiTap($TenGoiTap, $GiaTien, $ThoiHan, $MoTa)
    {
        $errors = [];
        // Validate dữ liệu
        if (empty($TenGoiTap)) {
            $errors['TenGoiTap'] = 'Tên gói tập không được để trống';
        }
        if (!is_numeric($GiaTien) || $GiaTien < 0) {
            $errors['GiaTien'] = 'Giá gói tập không hợp lệ';
        }
        if (!is_numeric($ThoiHan) || $ThoiHan < 1) {
            $errors['ThoiHan'] = 'Thời gian không hợp lệ';
        }
        if (empty($MoTa)) {
            $errors['MoTa'] = 'Mô tả không được để trống';
        }

        // Nếu có lỗi validation, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        try {
            // Chuẩn bị câu query
            $query = "INSERT INTO " . $this->table_name . " (TenGoiTap, GiaTien, ThoiHan, MoTa) 
                     VALUES (:TenGoiTap, :GiaTien, :ThoiHan, :MoTa)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenGoiTap = htmlspecialchars(strip_tags($TenGoiTap));
            $GiaTien = htmlspecialchars(strip_tags($GiaTien));
            $ThoiHan = htmlspecialchars(strip_tags($ThoiHan));
            $MoTa = htmlspecialchars(strip_tags($MoTa));

            // Bind các tham số
            $stmt->bindParam(':TenGoiTap', $TenGoiTap);
            $stmt->bindParam(':GiaTien', $GiaTien);
            $stmt->bindParam(':ThoiHan', $ThoiHan);
            $stmt->bindParam(':MoTa', $MoTa);

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

    // Cập nhật gói tập
    public function updateGoiTap($MaGoiTap, $TenGoiTap, $GiaTien, $ThoiHan, $MoTa)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET TenGoiTap = :TenGoiTap, GiaTien = :GiaTien, 
            ThoiHan = :ThoiHan, MoTa = :MoTa WHERE MaGoiTap = :MaGoiTap";
            
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenGoiTap = htmlspecialchars(strip_tags($TenGoiTap));
            $GiaTien = htmlspecialchars(strip_tags($GiaTien));
            $ThoiHan = htmlspecialchars(strip_tags($ThoiHan));
            $MoTa = htmlspecialchars(strip_tags($MoTa));

            // Bind các tham số
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);
            $stmt->bindParam(':TenGoiTap', $TenGoiTap);
            $stmt->bindParam(':GiaTien', $GiaTien);
            $stmt->bindParam(':ThoiHan', $ThoiHan);
            $stmt->bindParam(':MoTa', $MoTa);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa gói tập
    public function deleteGoiTap($MaGoiTap)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE MaGoiTap = :MaGoiTap";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
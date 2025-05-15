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
        $query = "SELECT MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy gói tập theo ID
    public function getByMaGoiTap($MaGoiTap)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaGoiTap = :MaGoiTap";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaGoiTap', $MaGoiTap, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới gói tập
    public function addGoiTap($Ten_goi, $Gia, $Thoi_gian, $Mo_ta)
    {
        $errors = [];
        
        // Validate dữ liệu
        if (empty($Ten_goi)) {
            $errors['ten_goi'] = 'Tên gói tập không được để trống';
        }
        if (!is_numeric($Gia) || $Gia < 0) {
            $errors['gia'] = 'Giá gói tập không hợp lệ';
        }
        if (empty($Thoi_gian)) {
            $errors['thoi_gian'] = 'Thời gian không được để trống';
        }
        if (empty($Mo_ta)) {
            $errors['mo_ta'] = 'Mô tả không được để trống';
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
            $Ten_goi = htmlspecialchars(strip_tags($Ten_goi));
            $Gia = htmlspecialchars(strip_tags($Gia));
            $Thoi_gian = htmlspecialchars(strip_tags($Thoi_gian));
            $Mo_ta = htmlspecialchars(strip_tags($Mo_ta));

            // Bind các tham số
            $stmt->bindParam(':TenGoiTap', $Ten_goi);
            $stmt->bindParam(':GiaTien', $Gia);
            $stmt->bindParam(':ThoiHan', $Thoi_gian);
            $stmt->bindParam(':MoTa', $Mo_ta);

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
    public function updateGoiTap($MaGoiTap, $Ten_goi, $Gia, $Thoi_gian, $Mo_ta)
    {
        try {
            $query = "UPDATE " . $this->table_name . " 
                     SET TenGoiTap = :TenGoiTap, 
                         GiaTien = :GiaTien, 
                         ThoiHan = :ThoiHan, 
                         MoTa = :MoTa 
                     WHERE MaGoiTap = :MaGoiTap";
            
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $Ten_goi = htmlspecialchars(strip_tags($Ten_goi));
            $Gia = htmlspecialchars(strip_tags($Gia));
            $Thoi_gian = htmlspecialchars(strip_tags($Thoi_gian));
            $Mo_ta = htmlspecialchars(strip_tags($Mo_ta));

            // Bind các tham số
            $stmt->bindParam(':MaGoiTap', $MaGoiTap);
            $stmt->bindParam(':TenGoiTap', $Ten_goi);
            $stmt->bindParam(':GiaTien', $Gia);
            $stmt->bindParam(':ThoiHan', $Thoi_gian);
            $stmt->bindParam(':MoTa', $Mo_ta);

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
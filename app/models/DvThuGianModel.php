<?php
class DvThuGianModel
{
    private $conn;
    private $table_name = 'dichvuthugian';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDVTGs()
    {
        $query = "SELECT id, TenTG, GiaTG, ThoiGianTG, MoTaTG FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy dịch vụ theo ID
    public function getDVTG_ByID($id)
    {
        $query  = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id,);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    // Thêm mới dịch vụ
    public function addDVTG($TenTG, $GiaTG, $ThoiGianTG, $MoTaTG)
    {
        $errors = [];
        // Validate dữ liệu
        if (empty($TenTG)) {
            $errors['TenTG'] = 'Tên dịch vụ không được để trống';
        }
        if (!is_numeric($GiaTG) || $GiaTG < 0) {
            $errors['GiaTG'] = 'Giá dịch vụ không hợp lệ';
        }
        if (!is_numeric($ThoiGianTG) || $ThoiGianTG < 1) {
            $errors['ThoiGianTG'] = 'Thời gian không hợp lệ';
        }
        if (empty($MoTaTG)) {
            $errors['MoTaTG'] = 'Mô tả không được để trống';
        }

        // Nếu có lỗi validation, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        try {
            // Chuẩn bị câu query
            $query = "INSERT INTO " . $this->table_name . " (TenTG, GiaTG, ThoiGianTG, MoTaTG) 
                     VALUES (:TenTG, :GiaTG, :ThoiGianTG, :MoTaTG)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenGoiTap = htmlspecialchars(strip_tags($TenTG));
            $GiaTien = htmlspecialchars(strip_tags($GiaTG));
            $ThoiHan = htmlspecialchars(strip_tags($ThoiGianTG));
            $MoTa = htmlspecialchars(strip_tags($MoTaTG));

            // Bind các tham số
            $stmt->bindParam(':TenTG', $TenTG);
            $stmt->bindParam(':GiaTG', $GiaTG);
            $stmt->bindParam(':ThoiGianTG', $ThoiGianTG);
            $stmt->bindParam(':MoTaTG', $MoTaTG);

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

    // Cập nhật dịch vụ
    public function updateDVTG($id, $TenTG, $GiaTG, $ThoiGianTG, $MoTaTG)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET TenTG = :TenTG, GiaTG = :GiaTG, 
            ThoiGianTG = :ThoiGianTG, MoTaTG = :MoTaTG WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenTG = htmlspecialchars(strip_tags($TenTG));
            $GiaTG = htmlspecialchars(strip_tags($GiaTG));
            $ThoiGianTG = htmlspecialchars(strip_tags($ThoiGianTG));
            $MoTaTG = htmlspecialchars(strip_tags($MoTaTG));

            // Bind các tham số
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':TenTG', $TenTG);
            $stmt->bindParam(':GiaTG', $GiaTG);
            $stmt->bindParam(':ThoiGianTG', $ThoiGianTG);
            $stmt->bindParam(':MoTaTG', $MoTaTG);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa gói tập
    public function deleteDVTG($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

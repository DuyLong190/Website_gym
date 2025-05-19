<?php
class DvTapLuyenModel
{
    private $conn;
    private $table_name = 'dichvutapluyen';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDVTLs()
    {
        $query = "SELECT id, TenTL, GiaTL, ThoiGianTL, MoTaTL FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy dịch vụ theo ID
    public function getDVTL_ByID($id)
    {
        $query  = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id,);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    // Thêm mới dịch vụ
    public function addDVTL($TenTL, $GiaTL, $ThoiGianTL, $MoTaTL)
    {
        $errors = [];
        // Validate dữ liệu
        if (empty($TenTL)) {
            $errors['TenTL'] = 'Tên dịch vụ không được để trống';
        }
        if (!is_numeric($GiaTL) || $GiaTL < 0) {
            $errors['GiaTL'] = 'Giá dịch vụ không hợp lệ';
        }
        if (!is_numeric($ThoiGianTL) || $ThoiGianTL < 1) {
            $errors['ThoiGianTL'] = 'Thời gian không hợp lệ';
        }
        if (empty($MoTaTL)) {
            $errors['MoTaTL'] = 'Mô tả không được để trống';
        }

        // Nếu có lỗi validation, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        try {
            // Chuẩn bị câu query
            $query = "INSERT INTO " . $this->table_name . " (TenTL, GiaTL, ThoiGianTL, MoTaTL) 
                     VALUES (:TenTL, :GiaTL, :ThoiGianTL, :MoTaTL)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenTL = htmlspecialchars(strip_tags($TenTL));
            $GiaTL = htmlspecialchars(strip_tags($GiaTL));
            $ThoiGianTL = htmlspecialchars(strip_tags($ThoiGianTL));
            $MoTaTL = htmlspecialchars(strip_tags($MoTaTL));

            // Bind các tham số
            $stmt->bindParam(':TenTL', $TenTL);
            $stmt->bindParam(':GiaTL', $GiaTL);
            $stmt->bindParam(':ThoiGianTL', $ThoiGianTL);
            $stmt->bindParam(':MoTaTL', $MoTaTL);

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
    public function updateDVTL($id, $TenTL, $GiaTL, $ThoiGianTL, $MoTaTL)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET TenTL = :TenTL, GiaTL = :GiaTL, 
            ThoiGianTL = :ThoiGianTL, MoTaTL = :MoTaTL WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenTL = htmlspecialchars(strip_tags($TenTL));
            $GiaTL = htmlspecialchars(strip_tags($GiaTL));
            $ThoiGianTL = htmlspecialchars(strip_tags($ThoiGianTL));
            $MoTaTL = htmlspecialchars(strip_tags($MoTaTL));

            // Bind các tham số
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':TenTL', $TenTL);
            $stmt->bindParam(':GiaTL', $GiaTL);
            $stmt->bindParam(':ThoiGianTL', $ThoiGianTL);
            $stmt->bindParam(':MoTaTL', $MoTaTL);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa gói tập
    public function deleteDVTL($id)
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

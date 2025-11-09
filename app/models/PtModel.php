<?php 
class PtModel 
{
    private $conn;
    private $table_name = 'pt';

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    // Lấy tất cả PT
    public function getAllPTs() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY pt_id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getAllPTs: " . $e->getMessage());
            return [];
        }
    }

    // Lấy PT theo ID
    public function getPTById($pt_id) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE pt_id = :pt_id";
            $stmt = $this->conn->prepare($query);
            
            // Chuyển đổi MaPT thành số nếu có thể
            if (is_numeric($pt_id)) {
                $pt_id = (int)$pt_id;
            }
            
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getPTById: " . $e->getMessage());
            return null;
        }
    }

    // Thêm mới PT
    public function addPT($HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong) {
        $errors = [];
        
        // Validate dữ liệu
        if (empty($HoTen)) {
            $errors['HoTen'] = 'Họ tên không được để trống';
        }
        if (empty($SDT)) {
            $errors['SDT'] = 'Số điện thoại không được để trống';
        }
        if (!empty($Email) && !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errors['Email'] = 'Email không hợp lệ';
        }
        if (!empty($Luong) && (!is_numeric($Luong) || $Luong < 0)) {
            $errors['Luong'] = 'Lương không hợp lệ';
        }
        if (!empty($KinhNghiem) && (!is_numeric($KinhNghiem) || $KinhNghiem < 0)) {
            $errors['KinhNghiem'] = 'Kinh nghiệm phải là số dương';
        }

        // Nếu có lỗi validation, trả về mảng lỗi
        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $query = "INSERT INTO " . $this->table_name . " (HoTen, NgaySinh, GioiTinh, SDT, Email, DiaChi, ChuyenMon, KinhNghiem, Luong) 
                     VALUES (:HoTen, :NgaySinh, :GioiTinh, :SDT, :Email, :DiaChi, :ChuyenMon, :KinhNghiem, :Luong)";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $HoTen = htmlspecialchars(strip_tags($HoTen));
            $NgaySinh = $NgaySinh ? htmlspecialchars(strip_tags($NgaySinh)) : null;
            $GioiTinh = $GioiTinh ? htmlspecialchars(strip_tags($GioiTinh)) : null;
            $SDT = htmlspecialchars(strip_tags($SDT));
            $Email = $Email ? htmlspecialchars(strip_tags($Email)) : null;
            $DiaChi = $DiaChi ? htmlspecialchars(strip_tags($DiaChi)) : null;
            $ChuyenMon = $ChuyenMon ? htmlspecialchars(strip_tags($ChuyenMon)) : null;
            $KinhNghiem = $KinhNghiem ? htmlspecialchars(strip_tags($KinhNghiem)) : null;
            $Luong = $Luong ? htmlspecialchars(strip_tags($Luong)) : null;

            // Bind các tham số
            $stmt->bindParam(':HoTen', $HoTen);
            $stmt->bindParam(':NgaySinh', $NgaySinh);
            $stmt->bindParam(':GioiTinh', $GioiTinh);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':ChuyenMon', $ChuyenMon);
            $stmt->bindParam(':KinhNghiem', $KinhNghiem);
            $stmt->bindParam(':Luong', $Luong);

            // Thực thi query
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error in addPT: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật PT
    public function updatePT($pt_id, $HoTen, $NgaySinh, $GioiTinh, $SDT, $Email, $DiaChi, $ChuyenMon, $KinhNghiem, $Luong) {
        try {
            $query = "UPDATE " . $this->table_name . " SET 
                        HoTen = :HoTen, 
                        NgaySinh = :NgaySinh, 
                        GioiTinh = :GioiTinh,
                        SDT = :SDT, 
                        Email = :Email, 
                        DiaChi = :DiaChi, 
                        ChuyenMon = :ChuyenMon, 
                        KinhNghiem = :KinhNghiem, 
                        Luong = :Luong 
                    WHERE pt_id = :pt_id";
            
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $HoTen = htmlspecialchars(strip_tags($HoTen));
            $NgaySinh = $NgaySinh ? htmlspecialchars(strip_tags($NgaySinh)) : null;
            $GioiTinh = $GioiTinh ? htmlspecialchars(strip_tags($GioiTinh)) : null;
            $SDT = htmlspecialchars(strip_tags($SDT));
            $Email = $Email ? htmlspecialchars(strip_tags($Email)) : null;
            $DiaChi = $DiaChi ? htmlspecialchars(strip_tags($DiaChi)) : null;
            $ChuyenMon = $ChuyenMon ? htmlspecialchars(strip_tags($ChuyenMon)) : null;
            $KinhNghiem = $KinhNghiem ? htmlspecialchars(strip_tags($KinhNghiem)) : null;
            $Luong = $Luong ? htmlspecialchars(strip_tags($Luong)) : null;

            // Chuyển đổi pt_id thành số nếu có thể
            if (is_numeric($pt_id)) {
                $pt_id = (int)$pt_id;
            }

            // Bind các tham số
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            $stmt->bindParam(':HoTen', $HoTen);
            $stmt->bindParam(':NgaySinh', $NgaySinh);
            $stmt->bindParam(':GioiTinh', $GioiTinh);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':ChuyenMon', $ChuyenMon);
            $stmt->bindParam(':KinhNghiem', $KinhNghiem);
            $stmt->bindParam(':Luong', $Luong);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updatePT: " . $e->getMessage());
            return false;
        }
    }

    // Xóa PT
    public function deletePT($pt_id) {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE pt_id = :pt_id";
            $stmt = $this->conn->prepare($query);
            
            // Chuyển đổi MaPT thành số nếu có thể
            if (is_numeric($pt_id)) {
                $pt_id = (int)$pt_id;
            }
            
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deletePT: " . $e->getMessage());
            return false;
        }
    }

    // Tìm kiếm PT
    public function searchPT($keyword) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " 
                     WHERE HoTen LIKE :keyword OR SDT LIKE :keyword OR Email LIKE :keyword OR ChuyenMon LIKE :keyword
                     ORDER BY pt_id DESC";
            $stmt = $this->conn->prepare($query);
            $keyword = "%$keyword%";
            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in searchPT: " . $e->getMessage());
            return [];
        }
    }
}
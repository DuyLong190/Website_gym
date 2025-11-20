<?php
class LopHoc_Model
{
    private $conn;
    private $table_name = 'LopHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getLopHocs()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY MaLop";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy lớp học theo ID
    public function getLopHoc_ByID($MaLop)
    {
        $query  = "SELECT * FROM " . $this->table_name . " WHERE MaLop = :MaLop";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm mới lớp học
    // Trả về id mới nếu thành công, mảng lỗi nếu validation fail, false nếu lỗi DB
    public function addLopHoc($TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $TrangThai, $pt_id = null)
    {
        $errors = [];

        // Validate dữ liệu
        if (empty($TenLop)) {
            $errors['TenLop'] = 'Tên lớp học không được để trống';
        }
        if (!is_numeric($GiaTien) || $GiaTien < 0) {
            $errors['GiaTien'] = 'Giá lớp học không hợp lệ';
        }
        // MoTa có thể để trống, nhưng kiểm tra kiểu
        if ($MoTa !== null && !is_string($MoTa)) {
            $errors['MoTa'] = 'Mô tả không hợp lệ';
        }

        // Validate ngày
        $format = 'Y-m-d H:i:s';
        $start = null; $end = null;
        if (!empty($NgayBatDau)) {
            $d = date_create($NgayBatDau);
            if (!$d) $errors['NgayBatDau'] = 'Ngày bắt đầu không hợp lệ';
            else $start = $d->format($format);
        } else {
            $errors['NgayBatDau'] = 'Ngày bắt đầu không được để trống';
        }
        if (!empty($NgayKetThuc)) {
            $d2 = date_create($NgayKetThuc);
            if (!$d2) $errors['NgayKetThuc'] = 'Ngày kết thúc không hợp lệ';
            else $end = $d2->format($format);
        } else {
            $errors['NgayKetThuc'] = 'Ngày kết thúc không được để trống';
        }
        if ($start && $end && strtotime($end) <= strtotime($start)) {
            $errors['NgayKetThuc'] = 'Hai ngày không được trùng nhau và ngày kết thúc phải sau ngày bắt đầu';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $query = "INSERT INTO " . $this->table_name . " 
                     (TenLop, GiaTien, MoTa, NgayBatDau, NgayKetThuc, TrangThai, pt_id, created_at, updated_at)
                     VALUES (:TenLop, :GiaTien, :MoTa, :NgayBatDau, :NgayKetThuc, :TrangThai, :pt_id, NOW(), NOW())";
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenLop = htmlspecialchars(strip_tags($TenLop));
            $GiaTien = (float)$GiaTien;
            $MoTa = $MoTa !== null ? htmlspecialchars(strip_tags($MoTa)) : null;
            $TrangThai = $TrangThai !== null ? htmlspecialchars(strip_tags($TrangThai)) : null;

            // Bind các tham số
            $stmt->bindParam(':TenLop', $TenLop);
            $stmt->bindParam(':GiaTien', $GiaTien);
            $stmt->bindParam(':MoTa', $MoTa);
            $stmt->bindParam(':NgayBatDau', $start);
            $stmt->bindParam(':NgayKetThuc', $end);
            $stmt->bindParam(':TrangThai', $TrangThai);
            if ($pt_id === null) {
                $stmt->bindValue(':pt_id', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':pt_id', (int)$pt_id, PDO::PARAM_INT);
            }

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            // Log lỗi nếu cần
            return false;
        }
    }

    // Cập nhật lớp học
    public function updateLopHoc($MaLop, $TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $TrangThai, $pt_id = null)
    {
        try {
            // Validate minimal: TenLop, GiaTien, dates
            if (empty($MaLop) || empty($TenLop)) {
                return false;
            }

            $format = 'Y-m-d H:i:s';
            $start = date_create($NgayBatDau) ? date_create($NgayBatDau)->format($format) : null;
            $end = date_create($NgayKetThuc) ? date_create($NgayKetThuc)->format($format) : null;

            if ($start && $end && strtotime($end) <= strtotime($start)) {
                return false;
            }

            $query = "UPDATE " . $this->table_name . " SET 
                        TenLop = :TenLop,
                        GiaTien = :GiaTien,
                        MoTa = :MoTa,
                        NgayBatDau = :NgayBatDau,
                        NgayKetThuc = :NgayKetThuc,
                        TrangThai = :TrangThai,
                        pt_id = :pt_id,
                        updated_at = NOW()
                      WHERE MaLop = :MaLop";

            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $TenLop = htmlspecialchars(strip_tags($TenLop));
            $GiaTien = (float)$GiaTien;
            $MoTa = $MoTa !== null ? htmlspecialchars(strip_tags($MoTa)) : null;
            $TrangThai = $TrangThai !== null ? htmlspecialchars(strip_tags($TrangThai)) : null;

            $stmt->bindParam(':TenLop', $TenLop);
            $stmt->bindParam(':GiaTien', $GiaTien);
            $stmt->bindParam(':MoTa', $MoTa);
            $stmt->bindParam(':NgayBatDau', $start);
            $stmt->bindParam(':NgayKetThuc', $end);
            $stmt->bindParam(':TrangThai', $TrangThai);
            if ($pt_id === null) {
                $stmt->bindValue(':pt_id', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':pt_id', (int)$pt_id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa lớp học
    public function deleteLopHoc($MaLop)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE MaLop = :MaLop";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

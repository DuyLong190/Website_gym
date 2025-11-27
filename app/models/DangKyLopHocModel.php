<?php
class DangKyLopHocModel
{
    private $conn;
    private $table_name = 'DangKyLopHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM {$this->table_name} ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getById - ' . $e->getMessage());
            return false;
        }
    }

    public function getByHoiVien($MaHV)
    {
        try {
            $sql = "SELECT d.*, l.TenLop, l.NgayBatDau, l.NgayKetThuc, l.GiaTien
                    FROM {$this->table_name} d
                    INNER JOIN LopHoc l ON d.MaLop = l.MaLop
                    WHERE d.MaHV = :MaHV
                    ORDER BY d.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $MaHV = (int)$MaHV;
            $stmt->bindParam(':MaHV', $MaHV, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getByHoiVien - ' . $e->getMessage());
            return [];
        }
    }

    public function getActiveByHoiVienAndLop($MaHV, $MaLop)
    {
        try {
            $sql = "SELECT * FROM {$this->table_name}
                    WHERE MaHV = :MaHV AND MaLop = :MaLop AND TrangThai = 'DangKy'
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $MaHV = (int)$MaHV;
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':MaHV', $MaHV, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getActiveByHoiVienAndLop - ' . $e->getMessage());
            return null;
        }
    }

    public function getActiveCountByLop($MaLop)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table_name} WHERE MaLop = :MaLop AND TrangThai = 'DangKy'";
            $stmt = $this->conn->prepare($sql);
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['total'] ?? 0);
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getActiveCountByLop - ' . $e->getMessage());
            return 0;
        }
    }

    public function getActiveMembersByLop($MaLop)
    {
        try {
            $sql = "SELECT d.*, h.HoTen, h.SDT, h.Email, h.TrangThai AS TrangThaiHoiVien,
                           g.TenGoiTap
                    FROM {$this->table_name} d
                    INNER JOIN HoiVien h ON d.MaHV = h.MaHV
                    LEFT JOIN GoiTap g ON h.MaGoiTap = g.MaGoiTap
                    WHERE d.MaLop = :MaLop AND d.TrangThai = 'DangKy'
                    ORDER BY h.HoTen";
            $stmt = $this->conn->prepare($sql);
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getActiveMembersByLop - ' . $e->getMessage());
            return [];
        }
    }

    public function getRemainingSlotsByLop($MaLop)
    {
        try {
            $MaLop = (int)$MaLop;
            $sql = "SELECT SoLuongToiDa FROM LopHoc WHERE MaLop = :MaLop";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$class) {
                return null;
            }
            $max = isset($class['SoLuongToiDa']) ? (int)$class['SoLuongToiDa'] : 0;
            if ($max <= 0) {
                return null;
            }
            $current = $this->getActiveCountByLop($MaLop);
            $remaining = $max - $current;
            return $remaining > 0 ? $remaining : 0;
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::getRemainingSlotsByLop - ' . $e->getMessage());
            return null;
        }
    }

    // Tạo đăng ký mới cho hội viên vào lớp học
    // Trả về true nếu thành công, mảng lỗi nếu validation fail, false nếu lỗi DB
    public function create($MaHV, $MaLop)
    {
        $errors = [];

        if (empty($MaHV) || !is_numeric($MaHV)) {
            $errors['MaHV'] = 'Hội viên không hợp lệ';
        }
        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'Lớp học không hợp lệ';
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Không cho đăng ký trùng
        $existing = $this->getActiveByHoiVienAndLop($MaHV, $MaLop);
        if ($existing) {
            $errors['exists'] = 'Bạn đã đăng ký lớp học này rồi.';
            return $errors;
        }

        try {
            $MaLopInt = (int)$MaLop;
            $sql = "SELECT SoLuongToiDa FROM LopHoc WHERE MaLop = :MaLop";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaLop', $MaLopInt, PDO::PARAM_INT);
            $stmt->execute();
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($class) {
                $max = isset($class['SoLuongToiDa']) ? (int)$class['SoLuongToiDa'] : 0;
                if ($max > 0) {
                    $current = $this->getActiveCountByLop($MaLopInt);
                    if ($current >= $max) {
                        $errors['full'] = 'Lớp học đã đủ số lượng, không thể đăng ký thêm.';
                        return $errors;
                    }
                }
            }
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::create - ' . $e->getMessage());
            return false;
        }

        try {
            $sql = "INSERT INTO {$this->table_name} (MaHV, MaLop, TrangThai, created_at, updated_at)
                    VALUES (:MaHV, :MaLop, 'DangKy', NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);

            $MaHV = (int)$MaHV;
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':MaHV', $MaHV, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::create - ' . $e->getMessage());
            return false;
        }
    }

    // Hủy đăng ký dựa trên hội viên và lớp học
    public function cancelByHoiVienAndLop($MaHV, $MaLop)
    {
        try {
            $sql = "UPDATE {$this->table_name}
                    SET TrangThai = 'Huy', updated_at = NOW()
                    WHERE MaHV = :MaHV AND MaLop = :MaLop AND TrangThai = 'DangKy'";
            $stmt = $this->conn->prepare($sql);
            $MaHV = (int)$MaHV;
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':MaHV', $MaHV, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::cancelByHoiVienAndLop - ' . $e->getMessage());
            return false;
        }
    }

    public function deleteById($id)
    {
        try {
            $sql = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $id = (int)$id;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('DangKyLopHocModel::deleteById - ' . $e->getMessage());
            return false;
        }
    }
}

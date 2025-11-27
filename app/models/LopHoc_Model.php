<?php
class LopHoc_Model
{
    private $conn;
    private $table_name = 'LopHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function parseDate($date, $fieldName, &$errors)
    {
        if (empty($date)) {
            $errors[$fieldName] = "$fieldName không được để trống";
            return null;
        }

        try {
            return new DateTime($date);
        } catch (Exception $e) {
            $errors[$fieldName] = "$fieldName không hợp lệ";
            return null;
        }
    }

    public function getLopHocs()
    {
        // Lấy danh sách lớp + số lượng đăng ký + tên PT (nếu có) qua bảng PtDayHoc
        $query = "SELECT l.*, 
                          (
                              SELECT pt.HoTen
                              FROM PtDayHoc pd
                              JOIN pt ON pd.pt_id = pt.pt_id
                              WHERE pd.MaLop = l.MaLop AND pd.TrangThai = 'Đăng ký'
                              ORDER BY pd.created_at DESC
                              LIMIT 1
                          ) AS TenPT,
                          (SELECT COUNT(*) FROM DangKyLopHoc d 
                           WHERE d.MaLop = l.MaLop AND d.TrangThai = 'DangKy') AS SoDangKy
                   FROM " . $this->table_name . " l
                   ORDER BY l.MaLop";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateExpiredClassesStatus()
    {
        try {
            $sql = "UPDATE {$this->table_name}
                    SET TrangThai = 'Đã kết thúc', updated_at = NOW()
                    WHERE NgayKetThuc IS NOT NULL
                      AND NgayKetThuc < CURDATE()
                      AND TrangThai <> 'Đã kết thúc'";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getLopHocsByTrangThai($TrangThai = 'Đang mở')
    {
        $query = "SELECT l.*, 
                          (
                              SELECT pt.HoTen
                              FROM PtDayHoc pd
                              JOIN pt ON pd.pt_id = pt.pt_id
                              WHERE pd.MaLop = l.MaLop AND pd.TrangThai = 'DangKy'
                              ORDER BY pd.created_at DESC
                              LIMIT 1
                          ) AS TenPT,
                          (SELECT COUNT(*) FROM DangKyLopHoc d 
                           WHERE d.MaLop = l.MaLop AND d.TrangThai = 'DangKy') AS SoDangKy
                   FROM " . $this->table_name . " l
                   WHERE l.TrangThai = :TrangThai
                   ORDER BY l.MaLop";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':TrangThai', $TrangThai);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy lớp học theo ID (kèm số lượng đăng ký hiện tại và tên PT nếu có)
    public function getLopHoc_ByID($MaLop)
    {
        $query  = "SELECT l.*, 
                           (
                               SELECT pt.HoTen
                               FROM PtDayHoc pd
                               JOIN pt ON pd.pt_id = pt.pt_id
                               WHERE pd.MaLop = l.MaLop AND pd.TrangThai = 'Đăng ký'
                               ORDER BY pd.created_at DESC
                               LIMIT 1
                           ) AS TenPT,
                           (SELECT COUNT(*) FROM DangKyLopHoc d 
                            WHERE d.MaLop = l.MaLop AND d.TrangThai = 'DangKy') AS SoDangKy
                    FROM " . $this->table_name . " l
                    WHERE l.MaLop = :MaLop";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm mới lớp học
    // Trả về id mới nếu thành công, mảng lỗi nếu validation fail, false nếu lỗi DB
    public function addLopHoc($TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $SoLuongToiDa, $TrangThai = null)
    {
        $errors = [];
        $format = 'Y-m-d';

        $TrangThai = $TrangThai ?? 'Đang mở';

        if (empty($TenLop))               $errors['TenLop'] = 'Tên lớp học không được để trống';
        if (!is_numeric($GiaTien) || $GiaTien < 0)
            $errors['GiaTien'] = 'Giá lớp học không hợp lệ';
        if ($MoTa !== null && !is_string($MoTa))
            $errors['MoTa'] = 'Mô tả không hợp lệ';

        $start = $this->parseDate($NgayBatDau, 'Ngày bắt đầu', $errors);
        $end   = $this->parseDate($NgayKetThuc, 'Ngày kết thúc', $errors);

        if ($start && $start < (new DateTime('today')))
            $errors['NgayBatDau'] = 'Ngày bắt đầu phải là ngày hiện tại hoặc trong tương lai';

        // Kiểm tra end > start
        if ($start && $end && $end <= $start)
            $errors['NgayKetThuc'] = 'Ngày kết thúc phải sau ngày bắt đầu và không được trùng nhau';

        if ($SoLuongToiDa !== null && $SoLuongToiDa !== '') {
            if (!is_numeric($SoLuongToiDa) || (int)$SoLuongToiDa <= 0)
                $errors['SoLuongToiDa'] = 'Số lượng tối đa phải là số nguyên lớn hơn 0';
            else
                $SoLuongToiDa = (int)$SoLuongToiDa;
        } else {
            $SoLuongToiDa = null;
        }

        if ($errors) return $errors;

        try {
            $query = "INSERT INTO {$this->table_name}
                 (TenLop, GiaTien, MoTa, NgayBatDau, NgayKetThuc, SoLuongToiDa, TrangThai, created_at, updated_at)
                 VALUES (:TenLop, :GiaTien, :MoTa, :NgayBatDau, :NgayKetThuc, :SoLuongToiDa, :TrangThai, NOW(), NOW())";

            $stmt = $this->conn->prepare($query);

            // Làm sạch
            $TenLop    = htmlspecialchars(strip_tags($TenLop));
            $MoTa      = $MoTa ? htmlspecialchars(strip_tags($MoTa)) : null;
            $GiaTien   = (float)$GiaTien;
            $TrangThai = htmlspecialchars(strip_tags($TrangThai));

            // Bind
            $stmt->bindParam(':TenLop', $TenLop);
            $stmt->bindParam(':GiaTien', $GiaTien);
            $stmt->bindParam(':MoTa', $MoTa);
            $stmt->bindValue(':NgayBatDau', $start->format($format));
            $stmt->bindValue(':NgayKetThuc', $end->format($format));
            $stmt->bindValue(':SoLuongToiDa', $SoLuongToiDa, $SoLuongToiDa === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindParam(':TrangThai', $TrangThai);

            return $stmt->execute() ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật lớp học
    public function updateLopHoc($MaLop, $TenLop, $GiaTien, $MoTa, $NgayBatDau, $NgayKetThuc, $SoLuongToiDa, $TrangThai = null)
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

            // Validate SoLuongToiDa nếu có
            if ($SoLuongToiDa !== null && $SoLuongToiDa !== '') {
                if (!is_numeric($SoLuongToiDa) || (int)$SoLuongToiDa <= 0) {
                    return false;
                }
                $SoLuongToiDa = (int)$SoLuongToiDa;
            } else {
                $SoLuongToiDa = null;
            }

            // Không cập nhật pt_id trên bảng LopHoc, PT đứng lớp được quản lý qua PtDayHoc
            $query = "UPDATE " . $this->table_name . " SET 
                        TenLop = :TenLop,
                        GiaTien = :GiaTien,
                        MoTa = :MoTa,
                        NgayBatDau = :NgayBatDau,
                        NgayKetThuc = :NgayKetThuc,
                        SoLuongToiDa = :SoLuongToiDa,
                        TrangThai = :TrangThai,
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
            if ($SoLuongToiDa === null) {
                $stmt->bindValue(':SoLuongToiDa', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':SoLuongToiDa', $SoLuongToiDa, PDO::PARAM_INT);
            }
            $stmt->bindParam(':TrangThai', $TrangThai);
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

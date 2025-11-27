<?php

class CauHinhLichHocModel
{
    private $conn;
    private $table_name = 'CauHinhLichHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT ch.*, l.TenLop
                    FROM " . $this->table_name . " ch
                    LEFT JOIN LopHoc l ON ch.MaLop = l.MaLop
                    ORDER BY ch.MaLop, ch.ThuTrongTuan, ch.GioBatDau";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public function getAllByMaLop($MaLop)
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE MaLop = :MaLop ORDER BY ThuTrongTuan, GioBatDau";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::getAllByMaLop - ' . $e->getMessage());
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::getById - ' . $e->getMessage());
            return false;
        }
    }

    public function create($MaLop, $ThuTrongTuan, $GioBatDau, $GioKetThuc, $PhongHocMacDinh = null)
    {
        $errors = [];

        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'MaLop không hợp lệ';
        }

        if (empty($ThuTrongTuan) || !is_numeric($ThuTrongTuan) || $ThuTrongTuan < 2 || $ThuTrongTuan > 8) {
            $errors['ThuTrongTuan'] = 'Thứ trong tuần không hợp lệ';
        }

        if (empty($GioBatDau)) {
            $errors['GioBatDau'] = 'GioBatDau không được để trống';
        }

        if (empty($GioKetThuc)) {
            $errors['GioKetThuc'] = 'GioKetThuc không được để trống';
        }

        if (!empty($GioBatDau) && !empty($GioKetThuc)) {
            $start = date_create($GioBatDau);
            $end = date_create($GioKetThuc);
            if (!$start || !$end || $end <= $start) {
                $errors['GioKetThuc'] = 'GioKetThuc phải lớn hơn GioBatDau';
            }

            // Giới hạn khung giờ cho phép: 07:00 - 19:00
            $minTime = date_create('07:00');
            $maxTime = date_create('19:00');
            if ($start < $minTime || $end > $maxTime) {
                $errors['TimeRange'] = 'Chỉ được cấu hình lịch trong khung giờ từ 07:00 đến 19:00';
            }
        }

        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $sql = "INSERT INTO " . $this->table_name . " (MaLop, ThuTrongTuan, GioBatDau, GioKetThuc, PhongHocMacDinh)
                    VALUES (:MaLop, :ThuTrongTuan, :GioBatDau, :GioKetThuc, :PhongHocMacDinh)";
            $stmt = $this->conn->prepare($sql);

            $MaLop = (int)$MaLop;
            $ThuTrongTuan = (int)$ThuTrongTuan;
            $GioBatDau = htmlspecialchars(strip_tags($GioBatDau));
            $GioKetThuc = htmlspecialchars(strip_tags($GioKetThuc));
            if ($PhongHocMacDinh !== null) {
                $PhongHocMacDinh = htmlspecialchars(strip_tags($PhongHocMacDinh));
            }

            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->bindParam(':ThuTrongTuan', $ThuTrongTuan, PDO::PARAM_INT);
            $stmt->bindParam(':GioBatDau', $GioBatDau);
            $stmt->bindParam(':GioKetThuc', $GioKetThuc);
            if ($PhongHocMacDinh === null || $PhongHocMacDinh === '') {
                $stmt->bindValue(':PhongHocMacDinh', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':PhongHocMacDinh', $PhongHocMacDinh);
            }

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::create - ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, $MaLop, $ThuTrongTuan, $GioBatDau, $GioKetThuc, $PhongHocMacDinh = null)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $errors = [];

        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'MaLop không hợp lệ';
        }

        if (empty($ThuTrongTuan) || !is_numeric($ThuTrongTuan) || $ThuTrongTuan < 2 || $ThuTrongTuan > 8) {
            $errors['ThuTrongTuan'] = 'Thứ trong tuần không hợp lệ';
        }

        if (empty($GioBatDau)) {
            $errors['GioBatDau'] = 'GioBatDau không được để trống';
        }

        if (empty($GioKetThuc)) {
            $errors['GioKetThuc'] = 'GioKetThuc không được để trống';
        }

        if (!empty($GioBatDau) && !empty($GioKetThuc)) {
            $start = date_create($GioBatDau);
            $end = date_create($GioKetThuc);
            if (!$start || !$end || $end <= $start) {
                $errors['GioKetThuc'] = 'GioKetThuc phải lớn hơn GioBatDau';
            }

            // Giới hạn khung giờ cho phép: 07:00 - 19:00
            $minTime = date_create('07:00');
            $maxTime = date_create('19:00');
            if ($start < $minTime || $end > $maxTime) {
                $errors['TimeRange'] = 'Chỉ được cấu hình lịch trong khung giờ từ 07:00 đến 19:00';
            }
        }

        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $sql = "UPDATE " . $this->table_name . "
                    SET MaLop = :MaLop,
                        ThuTrongTuan = :ThuTrongTuan,
                        GioBatDau = :GioBatDau,
                        GioKetThuc = :GioKetThuc,
                        PhongHocMacDinh = :PhongHocMacDinh
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $id = (int)$id;
            $MaLop = (int)$MaLop;
            $ThuTrongTuan = (int)$ThuTrongTuan;
            $GioBatDau = htmlspecialchars(strip_tags($GioBatDau));
            $GioKetThuc = htmlspecialchars(strip_tags($GioKetThuc));
            if ($PhongHocMacDinh !== null) {
                $PhongHocMacDinh = htmlspecialchars(strip_tags($PhongHocMacDinh));
            }

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->bindParam(':ThuTrongTuan', $ThuTrongTuan, PDO::PARAM_INT);
            $stmt->bindParam(':GioBatDau', $GioBatDau);
            $stmt->bindParam(':GioKetThuc', $GioKetThuc);
            if ($PhongHocMacDinh === null || $PhongHocMacDinh === '') {
                $stmt->bindValue(':PhongHocMacDinh', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':PhongHocMacDinh', $PhongHocMacDinh);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::update - ' . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('CauHinhLichHocModel::delete - ' . $e->getMessage());
            return false;
        }
    }
}

<?php

class LichLopHocModel
{
    private $conn;
    private $table_name = 'LichLopHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " ORDER BY NgayHoc, GioBatDau";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('LichLopHocModel::getAll - ' . $e->getMessage());
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
            error_log('LichLopHocModel::getById - ' . $e->getMessage());
            return false;
        }
    }

    public function create($MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc = null)
    {
        $errors = [];

        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'MaLop không hợp lệ';
        }

        if (empty($NgayHoc)) {
            $errors['NgayHoc'] = 'NgayHoc không được để trống';
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
        }

        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $sql = "INSERT INTO " . $this->table_name . " (MaLop, NgayHoc, GioBatDau, GioKetThuc, PhongHoc)
                    VALUES (:MaLop, :NgayHoc, :GioBatDau, :GioKetThuc, :PhongHoc)";
            $stmt = $this->conn->prepare($sql);

            $MaLop = (int)$MaLop;
            $NgayHoc = htmlspecialchars(strip_tags($NgayHoc));
            $GioBatDau = htmlspecialchars(strip_tags($GioBatDau));
            $GioKetThuc = htmlspecialchars(strip_tags($GioKetThuc));
            if ($PhongHoc !== null) {
                $PhongHoc = htmlspecialchars(strip_tags($PhongHoc));
            }

            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->bindParam(':NgayHoc', $NgayHoc);
            $stmt->bindParam(':GioBatDau', $GioBatDau);
            $stmt->bindParam(':GioKetThuc', $GioKetThuc);
            if ($PhongHoc === null || $PhongHoc === '') {
                $stmt->bindValue(':PhongHoc', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':PhongHoc', $PhongHoc);
            }

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log('LichLopHocModel::create - ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, $MaLop, $NgayHoc, $GioBatDau, $GioKetThuc, $PhongHoc = null)
    {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $errors = [];

        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'MaLop không hợp lệ';
        }

        if (empty($NgayHoc)) {
            $errors['NgayHoc'] = 'NgayHoc không được để trống';
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
        }

        if (count($errors) > 0) {
            return $errors;
        }

        try {
            $sql = "UPDATE " . $this->table_name . "
                    SET MaLop = :MaLop,
                        NgayHoc = :NgayHoc,
                        GioBatDau = :GioBatDau,
                        GioKetThuc = :GioKetThuc,
                        PhongHoc = :PhongHoc
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $id = (int)$id;
            $MaLop = (int)$MaLop;
            $NgayHoc = htmlspecialchars(strip_tags($NgayHoc));
            $GioBatDau = htmlspecialchars(strip_tags($GioBatDau));
            $GioKetThuc = htmlspecialchars(strip_tags($GioKetThuc));
            if ($PhongHoc !== null) {
                $PhongHoc = htmlspecialchars(strip_tags($PhongHoc));
            }

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->bindParam(':NgayHoc', $NgayHoc);
            $stmt->bindParam(':GioBatDau', $GioBatDau);
            $stmt->bindParam(':GioKetThuc', $GioKetThuc);
            if ($PhongHoc === null || $PhongHoc === '') {
                $stmt->bindValue(':PhongHoc', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':PhongHoc', $PhongHoc);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('LichLopHocModel::update - ' . $e->getMessage());
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
            error_log('LichLopHocModel::delete - ' . $e->getMessage());
            return false;
        }
    }
}

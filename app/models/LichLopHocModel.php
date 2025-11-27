<?php

class LichLopHocModel
{
    private $conn;
    private $table_name = 'LichLopHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function getLopHocDateRange($MaLop)
    {
        try {
            $sql = "SELECT NgayBatDau, NgayKetThuc FROM LopHoc WHERE MaLop = :MaLop LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return null;
            }

            return [
                'start' => !empty($row['NgayBatDau']) ? date_create($row['NgayBatDau']) : null,
                'end' => !empty($row['NgayKetThuc']) ? date_create($row['NgayKetThuc']) : null,
            ];
        } catch (PDOException $e) {
            error_log('LichLopHocModel::getLopHocDateRange - ' . $e->getMessage());
            return null;
        }
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

    public function getByMaLops(array $maLops)
    {
        if (empty($maLops)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($maLops), '?'));

        try {
            $sql = "SELECT llh.*, l.TenLop
                    FROM " . $this->table_name . " llh
                    INNER JOIN LopHoc l ON llh.MaLop = l.MaLop
                    WHERE llh.MaLop IN ($placeholders)
                    ORDER BY llh.NgayHoc, llh.GioBatDau";
            $stmt = $this->conn->prepare($sql);

            foreach ($maLops as $index => $id) {
                $stmt->bindValue($index + 1, (int)$id, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('LichLopHocModel::getByMaLops - ' . $e->getMessage());
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

        if (empty($errors['MaLop']) && !empty($MaLop)) {
            $lopRange = $this->getLopHocDateRange($MaLop);
            if (!$lopRange || !$lopRange['start'] || !$lopRange['end']) {
                $errors['MaLop'] = 'Không tìm thấy lớp học hoặc khoảng thời gian chưa được thiết lập';
            } else {
                $hocDate = date_create($NgayHoc);
                $startRange = (clone $lopRange['start'])->setTime(0, 0, 0);
                $endRange = (clone $lopRange['end'])->setTime(0, 0, 0);
                if (!$hocDate) {
                    $errors['NgayHoc'] = 'Ngày học không hợp lệ';
                } else {
                    $hocDate->setTime(0, 0, 0);
                    if ($hocDate < $startRange || $hocDate > $endRange) {
                        $errors['NgayHoc'] = 'Ngày học phải nằm trong khoảng từ ' . $startRange->format('Y-m-d') . ' đến ' . $endRange->format('Y-m-d');
                    }
                }
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

        if (empty($errors['MaLop']) && !empty($MaLop)) {
            $lopRange = $this->getLopHocDateRange($MaLop);
            if (!$lopRange || !$lopRange['start'] || !$lopRange['end']) {
                $errors['MaLop'] = 'Không tìm thấy lớp học hoặc khoảng thời gian chưa được thiết lập';
            } else {
                $hocDate = date_create($NgayHoc);
                $startRange = (clone $lopRange['start'])->setTime(0, 0, 0);
                $endRange = (clone $lopRange['end'])->setTime(0, 0, 0);
                if (!$hocDate) {
                    $errors['NgayHoc'] = 'Ngày học không hợp lệ';
                } else {
                    $hocDate->setTime(0, 0, 0);
                    if ($hocDate < $startRange || $hocDate > $endRange) {
                        $errors['NgayHoc'] = 'Ngày học phải nằm trong khoảng từ ' . $startRange->format('Y-m-d') . ' đến ' . $endRange->format('Y-m-d');
                    }
                }
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

    public function generateFromCauHinhByMaLop($MaLop)
    {
        if (empty($MaLop) || !is_numeric($MaLop)) {
            return false;
        }

        try {
            $MaLop = (int)$MaLop;

            $lopRange = $this->getLopHocDateRange($MaLop);
            if (!$lopRange || !$lopRange['start'] || !$lopRange['end']) {
                return false;
            }

            $sql = "SELECT id, ThuTrongTuan, GioBatDau, GioKetThuc, PhongHocMacDinh
                    FROM CauHinhLichHoc
                    WHERE MaLop = :MaLop
                    ORDER BY ThuTrongTuan, GioBatDau";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            $patterns = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($patterns)) {
                return 0;
            }

            $patternsByPhpDay = [];
            foreach ($patterns as $row) {
                $phpDay = (int)$row['ThuTrongTuan'] - 1;
                if ($phpDay < 1 || $phpDay > 7) {
                    continue;
                }
                $patternsByPhpDay[$phpDay][] = $row;
            }

            if (empty($patternsByPhpDay)) {
                return 0;
            }

            $startDate = (clone $lopRange['start'])->setTime(0, 0, 0);
            $endDate = (clone $lopRange['end'])->setTime(0, 0, 0);

            $current = clone $startDate;
            $created = 0;

            while ($current <= $endDate) {
                $phpDay = (int)$current->format('N');

                if (!empty($patternsByPhpDay[$phpDay])) {
                    foreach ($patternsByPhpDay[$phpDay] as $pattern) {
                        $NgayHoc = $current->format('Y-m-d');
                        $GioBatDau = $pattern['GioBatDau'];
                        $GioKetThuc = $pattern['GioKetThuc'];
                        $PhongHoc = $pattern['PhongHocMacDinh'];

                        $checkSql = "SELECT COUNT(*) FROM " . $this->table_name . "
                                     WHERE MaLop = :MaLop
                                       AND NgayHoc = :NgayHoc
                                       AND GioBatDau = :GioBatDau
                                       AND GioKetThuc = :GioKetThuc";
                        $checkStmt = $this->conn->prepare($checkSql);
                        $checkStmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
                        $checkStmt->bindParam(':NgayHoc', $NgayHoc);
                        $checkStmt->bindParam(':GioBatDau', $GioBatDau);
                        $checkStmt->bindParam(':GioKetThuc', $GioKetThuc);
                        $checkStmt->execute();
                        $exists = (int)$checkStmt->fetchColumn();

                        if ($exists > 0) {
                            continue;
                        }

                        $insertSql = "INSERT INTO " . $this->table_name . " (MaLop, NgayHoc, GioBatDau, GioKetThuc, PhongHoc)
                                      VALUES (:MaLop, :NgayHoc, :GioBatDau, :GioKetThuc, :PhongHoc)";
                        $insertStmt = $this->conn->prepare($insertSql);
                        $insertStmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
                        $insertStmt->bindParam(':NgayHoc', $NgayHoc);
                        $insertStmt->bindParam(':GioBatDau', $GioBatDau);
                        $insertStmt->bindParam(':GioKetThuc', $GioKetThuc);
                        if ($PhongHoc === null || $PhongHoc === '') {
                            $insertStmt->bindValue(':PhongHoc', null, PDO::PARAM_NULL);
                        } else {
                            $insertStmt->bindParam(':PhongHoc', $PhongHoc);
                        }

                        if ($insertStmt->execute()) {
                            $created++;
                        }
                    }
                }

                $current->modify('+1 day');
            }

            return $created;
        } catch (PDOException $e) {
            error_log('LichLopHocModel::generateFromCauHinhByMaLop - ' . $e->getMessage());
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

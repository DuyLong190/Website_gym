<?php
class PtDayHocModel
{
    private $conn;
    private $table_name = 'PtDayHoc';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByPt($pt_id)
    {
        try {
            $sql = "SELECT * FROM {$this->table_name} WHERE pt_id = :pt_id ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $pt_id = (int)$pt_id;
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('PtDayHocModel::getByPt - ' . $e->getMessage());
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $id = (int)$id;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('PtDayHocModel::getById - ' . $e->getMessage());
            return false;
        }
    }

    public function getActiveByPtAndLop($pt_id, $MaLop)
    {
        try {
            $sql = "SELECT * FROM {$this->table_name}
                    WHERE pt_id = :pt_id AND MaLop = :MaLop AND TrangThai = 'Đăng ký'
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $pt_id = (int)$pt_id;
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('PtDayHocModel::getActiveByPtAndLop - ' . $e->getMessage());
            return null;
        }
    }

    // PT đăng ký đứng lớp
    // Trả về true nếu thành công, mảng lỗi nếu validation fail, false nếu lỗi DB
    public function create($pt_id, $MaLop)
    {
        $errors = [];

        if (empty($pt_id) || !is_numeric($pt_id)) {
            $errors['pt_id'] = 'Huấn luyện viên không hợp lệ';
        }
        if (empty($MaLop) || !is_numeric($MaLop)) {
            $errors['MaLop'] = 'Lớp học không hợp lệ';
        }

        if (!empty($errors)) {
            return $errors;
        }

        $existing = $this->getActiveByPtAndLop($pt_id, $MaLop);
        if ($existing) {
            $errors['exists'] = 'Bạn đã đăng ký đứng lớp này rồi.';
            return $errors;
        }

        try {
            $sql = "INSERT INTO {$this->table_name} (pt_id, MaLop, TrangThai, created_at, updated_at)
                    VALUES (:pt_id, :MaLop, 'Đăng ký', NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);

            $pt_id = (int)$pt_id;
            $MaLop = (int)$MaLop;
            $stmt->bindParam(':pt_id', $pt_id, PDO::PARAM_INT);
            $stmt->bindParam(':MaLop', $MaLop, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log('PtDayHocModel::create - ' . $e->getMessage());
            return false;
        }
    }

    // Hủy đăng ký đứng lớp theo id bản ghi
    public function cancelById($id)
    {
        try {
            $sql = "UPDATE {$this->table_name}
                    SET TrangThai = 'Hủy', updated_at = NOW()
                    WHERE id = :id AND TrangThai = 'Đăng ký'";
            $stmt = $this->conn->prepare($sql);
            $id = (int)$id;
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('PtDayHocModel::cancelById - ' . $e->getMessage());
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
            error_log('PtDayHocModel::deleteById - ' . $e->getMessage());
            return false;
        }
    }
}

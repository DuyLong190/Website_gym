<?php
class YeuCauThanhToanModel
{
    private $conn;
    private $table_name = 'YeuCauThanhToan';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createForChiTiet($id_ctgt, $maHV, $soTien, $phuongThuc = 'Tiền mặt', $ghiChu = null)
    {
        try {
            $sql = "INSERT INTO " . $this->table_name . " (id_ctgt, MaHV, SoTien, PhuongThuc, TrangThai, GhiChu, NgayYeuCau)
                    VALUES (:id_ctgt, :MaHV, :SoTien, :PhuongThuc, 'Chờ xác nhận', :GhiChu, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ctgt', $id_ctgt, PDO::PARAM_INT);
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':SoTien', $soTien);
            $stmt->bindParam(':PhuongThuc', $phuongThuc);
            $stmt->bindParam(':GhiChu', $ghiChu);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::createForChiTiet - ' . $e->getMessage());
            return false;
        }
    }

    public function getPending()
    {
        $sql = "SELECT y.*, h.HoTen, g.TenGoiTap
                FROM " . $this->table_name . " y
                JOIN HoiVien h ON y.MaHV = h.MaHV
                JOIN ChiTiet_GoiTap ct ON y.id_ctgt = ct.id_ctgt
                JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                WHERE y.TrangThai = 'Chờ xác nhận'
                ORDER BY y.NgayYeuCau DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_yc)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id_yc";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_yc', $id_yc, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markConfirmed($id_yc)
    {
        try {
            $sql = "UPDATE " . $this->table_name . "
                    SET TrangThai = 'Đã xác nhận', NgayXacNhan = NOW()
                    WHERE id = :id_yc AND TrangThai = 'Chờ xác nhận'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_yc', $id_yc, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::markConfirmed - ' . $e->getMessage());
            return false;
        }
    }
}

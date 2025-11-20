<?php 
require_once __DIR__ . '/YeuCauThanhToanModel.php';

class ChiTiet_Goitap_Model {
    private $conn;
    private $table_name = "chitiet_goitap";  

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function supportsStatusValue($status)
    {
        try {
            $sql = "SHOW COLUMNS FROM " . $this->table_name . " LIKE 'TrangThai'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $column = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$column || empty($column['Type'])) {
                return false;
            }

            return strpos($column['Type'], "'" . $status . "'") !== false;
        } catch (PDOException $e) {
            error_log('Error checking status enum: ' . $e->getMessage());
            return false;
        }
    }

    public function getChiTietById($id_ctgt)
    {
        $sql = "SELECT ct.*, g.TenGoiTap
                FROM " . $this->table_name . " ct
                LEFT JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                WHERE ct.id_ctgt = :id_ctgt";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_ctgt', $id_ctgt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy gói tập hiện tại của một hội viên theo MaHV
    public function getCurrentByMaHV($maHV)
    {
        // Ưu tiên gói đang hoạt động, nếu không có thì lấy bản ghi mới nhất
        $sql = "SELECT ct.*, g.TenGoiTap FROM " . $this->table_name . " ct
                LEFT JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                WHERE ct.MaHV = :maHV 
                ORDER BY 
                    (ct.TrangThai = 'Đang hoạt động') DESC,
                    ct.NgayBatDau DESC,
                    ct.id_ctgt DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':maHV', $maHV, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createForHoiVien($maHV, $maGoiTap)
    {
        try {
            // Lấy thông tin gói tập để xác định giá tiền
            $goiTapStmt = $this->conn->prepare("SELECT MaGoiTap, GiaTien FROM GoiTap WHERE MaGoiTap = :MaGoiTap LIMIT 1");
            $goiTapStmt->bindParam(':MaGoiTap', $maGoiTap, PDO::PARAM_INT);
            $goiTapStmt->execute();
            $goiTap = $goiTapStmt->fetch(PDO::FETCH_ASSOC);

            if (!$goiTap) {
                return false;
            }

            $sql = "INSERT INTO " . $this->table_name . " (MaHV, MaGoiTap, NgayBatDau, NgayKetThuc, TrangThai, DaThanhToan)
                    VALUES (:MaHV, :MaGoiTap, NULL, NULL, :TrangThai, :DaThanhToan)";

            $stmt = $this->conn->prepare($sql);

            $trangThai = $this->supportsStatusValue('Chờ xác nhận') ? 'Chờ xác nhận' : 'Chờ thanh toán';
            $daThanhToan = 0;

            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':MaGoiTap', $maGoiTap, PDO::PARAM_INT);
            $stmt->bindParam(':TrangThai', $trangThai, PDO::PARAM_STR);
            $stmt->bindParam(':DaThanhToan', $daThanhToan, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return false;
            }

            $id_ctgt = (int)$this->conn->lastInsertId();
            if ($id_ctgt <= 0) {
                return false;
            }

            $ycModel = new YeuCauThanhToanModel($this->conn);
            $soTien = (float)($goiTap['GiaTien'] ?? 0);
            $okYc = $ycModel->createForChiTiet($id_ctgt, (int)$maHV, $soTien);

            return $okYc;
        } catch (PDOException $e) {
            error_log('Error in ChiTiet_Goitap_Model::createForHoiVien - ' . $e->getMessage());
            return false;
        }
    }

    public function confirmPayment($id_ctgt)
    {
        try {
            // Cập nhật NgayBatDau, NgayKetThuc dựa trên ThoiHan của gói tập
            $sql = "UPDATE " . $this->table_name . " ct
                    JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                    SET ct.NgayBatDau = CURRENT_DATE,
                        ct.NgayKetThuc = DATE_ADD(CURRENT_DATE, INTERVAL g.ThoiHan day),
                        ct.TrangThai = 'Đang hoạt động',
                        ct.DaThanhToan = 1
                    WHERE ct.id_ctgt = :id_ctgt AND ct.DaThanhToan = 0";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ctgt', $id_ctgt, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error in ChiTiet_Goitap_Model::confirmPayment - ' . $e->getMessage());
            return false;
        }
    }

    public function requestPayment($id_ctgt)
    {
        try {
            $sql = "UPDATE " . $this->table_name . "
                    SET TrangThai = 'Chờ xác minh'
                    WHERE id_ctgt = :id_ctgt AND DaThanhToan = 0";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ctgt', $id_ctgt, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error in ChiTiet_Goitap_Model::requestPayment - ' . $e->getMessage());
            return false;
        }
    }
}
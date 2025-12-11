<?php
class ThanhToanHoaDonModel
{
    private $db;
    private $table_name = 'thanhtoan_hoadon';

    public function __construct($db)
    {
        $this->db = $db; // PDO instance
    }

    /**
     * Lưu giao dịch thanh toán vào bảng thanhtoan_hoadon
     * @param int $maHV Mã hội viên
     * @param string $loai 'DichVu' hoặc 'LopHoc'
     * @param int $id_dangky ID của DangKyDichVu hoặc DangKyLopHoc
     * @param float $amount Số tiền
     * @param string $momo_status Trạng thái MoMo
     * @param string $link_data Dữ liệu JSON từ MoMo
     * @param string $order_id Mã đơn hàng
     * @return int|false ID của hóa đơn mới tạo hoặc false nếu thất bại
     */
    public function storeTransaction($maHV, $loai, $id_dangky, $amount, $momo_status, $link_data, $order_id = null)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " 
                     (MaHV, Loai, id_dangky, amount, momo_status, link_data, order_id) 
                     VALUES (:MaHV, :Loai, :id_dangky, :amount, :momo_status, :link_data, :order_id)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':Loai', $loai);
            $stmt->bindParam(':id_dangky', $id_dangky, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':momo_status', $momo_status);
            $stmt->bindParam(':link_data', $link_data);
            $stmt->bindParam(':order_id', $order_id);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            
            return false;
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::storeTransaction - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy hóa đơn theo order_id
     */
    public function getByOrderId($order_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE order_id = :order_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::getByOrderId - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy hóa đơn theo ID
     */
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::getById - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tất cả hóa đơn của hội viên
     */
    public function getByMaHV($maHV)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " 
                     WHERE MaHV = :MaHV 
                     ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::getByMaHV - Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy hóa đơn với thông tin chi tiết (join với bảng liên quan)
     */
    public function getWithDetails($id)
    {
        try {
            $query = "SELECT hd.*, 
                            hv.HoTen, hv.SDT, hv.Email,
                            CASE 
                                WHEN hd.Loai = 'DichVu' THEN dv.TenTG
                                WHEN hd.Loai = 'LopHoc' THEN lh.TenLop
                            END AS TenItem,
                            CASE 
                                WHEN hd.Loai = 'DichVu' THEN dv.GiaTG
                                WHEN hd.Loai = 'LopHoc' THEN lh.GiaTien
                            END AS GiaGoc
                     FROM " . $this->table_name . " hd
                     LEFT JOIN hoivien hv ON hd.MaHV = hv.MaHV
                     LEFT JOIN dangkydichvu dkdv ON hd.Loai = 'DichVu' AND hd.id_dangky = dkdv.id
                     LEFT JOIN dichvuthugian dv ON hd.Loai = 'DichVu' AND dkdv.id_dv = dv.id
                     LEFT JOIN dangkylophoc dklh ON hd.Loai = 'LopHoc' AND hd.id_dangky = dklh.id
                     LEFT JOIN lophoc lh ON hd.Loai = 'LopHoc' AND dklh.MaLop = lh.MaLop
                     WHERE hd.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::getWithDetails - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật trạng thái MoMo
     */
    public function updateMomoStatus($id, $momo_status, $link_data = null)
    {
        try {
            $query = "UPDATE " . $this->table_name . " 
                     SET momo_status = :momo_status";
            
            if ($link_data !== null) {
                $query .= ", link_data = :link_data";
            }
            
            $query .= ", updated_at = NOW() WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':momo_status', $momo_status);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($link_data !== null) {
                $stmt->bindParam(':link_data', $link_data);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::updateMomoStatus - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Xác nhận thanh toán và cập nhật DaThanhToan trong bảng đăng ký
     * @param int $id ID của hóa đơn
     * @return bool
     */
    public function confirmPayment($id)
    {
        try {
            // Lấy thông tin hóa đơn
            $hoaDon = $this->getById($id);
            if (!$hoaDon) {
                return false;
            }

            $this->db->beginTransaction();

            // Cập nhật trạng thái thanh toán trong bảng đăng ký tương ứng
            if ($hoaDon['Loai'] === 'DichVu') {
                $query = "UPDATE DangKyDichVu 
                         SET DaThanhToan = 1, TrangThai = 'Đã xác nhận', updated_at = NOW()
                         WHERE id = :id_dangky AND DaThanhToan = 0";
            } else if ($hoaDon['Loai'] === 'LopHoc') {
                $query = "UPDATE DangKyLopHoc 
                         SET DaThanhToan = 1, updated_at = NOW()
                         WHERE id = :id_dangky AND DaThanhToan = 0";
            } else {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_dangky', $hoaDon['id_dangky'], PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('ThanhToanHoaDonModel::confirmPayment - Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tất cả hóa đơn chờ xác nhận (cho admin)
     */
    public function getPendingPayments()
    {
        try {
            $query = "SELECT hd.*, 
                            hv.HoTen, hv.SDT, hv.Email,
                            CASE 
                                WHEN hd.Loai = 'DichVu' THEN dv.TenTG
                                WHEN hd.Loai = 'LopHoc' THEN lh.TenLop
                            END AS TenItem
                     FROM " . $this->table_name . " hd
                     LEFT JOIN hoivien hv ON hd.MaHV = hv.MaHV
                     LEFT JOIN dangkydichvu dkdv ON hd.Loai = 'DichVu' AND hd.id_dangky = dkdv.id
                     LEFT JOIN dichvuthugian dv ON hd.Loai = 'DichVu' AND dkdv.id_dv = dv.id
                     LEFT JOIN dangkylophoc dklh ON hd.Loai = 'LopHoc' AND hd.id_dangky = dklh.id
                     LEFT JOIN lophoc lh ON hd.Loai = 'LopHoc' AND dklh.MaLop = lh.MaLop
                     WHERE hd.momo_status = 'Thành công'
                     ORDER BY hd.created_at DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('ThanhToanHoaDonModel::getPendingPayments - Error: ' . $e->getMessage());
            return [];
        }
    }
}


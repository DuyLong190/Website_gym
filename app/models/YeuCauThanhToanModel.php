<?php
class YeuCauThanhToanModel
{
    private $conn;
    private $table_name = 'YeuCauThanhToan';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Tạo yêu cầu thanh toán cho gói tập
    public function createForChiTiet($id_ctgt, $maHV, $soTien, $phuongThuc = 'Tiền mặt', $ghiChu = null)
    {
        try {
            $sql = "INSERT INTO " . $this->table_name . " (Loai, id_ctgt, MaHV, SoTien, PhuongThuc, TrangThai, GhiChu, NgayYeuCau)
                    VALUES ('GoiTap', :id_ctgt, :MaHV, :SoTien, :PhuongThuc, 'Chờ xác nhận', :GhiChu, NOW())";

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

    // Tạo yêu cầu thanh toán cho dịch vụ (lưu thông tin tạm thời vào GhiChu dưới dạng JSON)
    // $thongTinDichVu: array('id_dv' => int, 'NgaySuDung' => string, 'GioSuDung' => string, 'GhiChu' => string|null)
    public function createForDichVu($maHV, $soTien, $thongTinDichVu, $phuongThuc = 'Tiền mặt')
    {
        try {
            // Lưu thông tin dịch vụ vào GhiChu dưới dạng JSON
            $ghiChuData = [
                'id_dv' => $thongTinDichVu['id_dv'] ?? 0,
                'NgaySuDung' => $thongTinDichVu['NgaySuDung'] ?? '',
                'GioSuDung' => $thongTinDichVu['GioSuDung'] ?? '',
                'GhiChu' => $thongTinDichVu['GhiChu'] ?? null
            ];
            $ghiChu = json_encode($ghiChuData, JSON_UNESCAPED_UNICODE);

            $sql = "INSERT INTO " . $this->table_name . " (Loai, MaHV, SoTien, PhuongThuc, TrangThai, GhiChu, NgayYeuCau)
                    VALUES ('DichVu', :MaHV, :SoTien, :PhuongThuc, 'Chờ xác nhận', :GhiChu, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':SoTien', $soTien);
            $stmt->bindParam(':PhuongThuc', $phuongThuc);
            $stmt->bindParam(':GhiChu', $ghiChu);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::createForDichVu - ' . $e->getMessage());
            return false;
        }
    }

    // Tạo yêu cầu thanh toán cho lớp học (lưu MaLop vào GhiChu dưới dạng JSON)
    public function createForLopHoc($maHV, $soTien, $maLop, $phuongThuc = 'Tiền mặt')
    {
        try {
            // Lưu MaLop vào GhiChu dưới dạng JSON
            $ghiChuData = [
                'MaLop' => $maLop
            ];
            $ghiChu = json_encode($ghiChuData, JSON_UNESCAPED_UNICODE);

            $sql = "INSERT INTO " . $this->table_name . " (Loai, MaHV, SoTien, PhuongThuc, TrangThai, GhiChu, NgayYeuCau)
                    VALUES ('LopHoc', :MaHV, :SoTien, :PhuongThuc, 'Chờ xác nhận', :GhiChu, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaHV', $maHV, PDO::PARAM_INT);
            $stmt->bindParam(':SoTien', $soTien);
            $stmt->bindParam(':PhuongThuc', $phuongThuc);
            $stmt->bindParam(':GhiChu', $ghiChu);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::createForLopHoc - ' . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách yêu cầu thanh toán đang chờ xác nhận (hỗ trợ cả 3 loại)
    public function getPending()
    {
        try {
            $sql = "SELECT y.*, 
                    h.HoTen,
                    -- Thông tin gói tập
                    g.TenGoiTap,
                    -- Thông tin dịch vụ (lấy từ GhiChu JSON)
                    dv.TenTG AS TenDichVu,
                    dv.GiaTG AS GiaDichVu,
                    -- Thông tin lớp học (lấy từ GhiChu JSON)
                    l.TenLop,
                    l.GiaTien AS GiaLopHoc
                FROM " . $this->table_name . " y
                JOIN HoiVien h ON y.MaHV = h.MaHV
                -- LEFT JOIN cho gói tập
                LEFT JOIN ChiTiet_GoiTap ct ON y.id_ctgt = ct.id_ctgt AND y.Loai = 'GoiTap'
                LEFT JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                -- LEFT JOIN cho dịch vụ (lấy id_dv từ GhiChu JSON)
                LEFT JOIN DichVuThuGian dv ON y.Loai = 'DichVu' 
                    AND JSON_EXTRACT(y.GhiChu, '$.id_dv') = dv.id
                -- LEFT JOIN cho lớp học (lấy MaLop từ GhiChu JSON)
                LEFT JOIN LopHoc l ON y.Loai = 'LopHoc' 
                    AND JSON_EXTRACT(y.GhiChu, '$.MaLop') = l.MaLop
                WHERE y.TrangThai = 'Chờ xác nhận'
                ORDER BY y.NgayYeuCau DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Parse thông tin từ GhiChu JSON cho mỗi kết quả
            foreach ($results as &$row) {
                if (!empty($row['GhiChu'])) {
                    $ghiChuData = json_decode($row['GhiChu'], true);
                    if ($row['Loai'] === 'DichVu' && $ghiChuData) {
                        $row['NgaySuDung'] = $ghiChuData['NgaySuDung'] ?? '';
                        $row['GioSuDung'] = $ghiChuData['GioSuDung'] ?? '';
                        $row['GhiChuDichVu'] = $ghiChuData['GhiChu'] ?? null;
                    } elseif ($row['Loai'] === 'LopHoc' && $ghiChuData) {
                        $row['MaLop'] = $ghiChuData['MaLop'] ?? null;
                    }
                }
            }
            unset($row);
            
            return $results;
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::getPending - ' . $e->getMessage());
            return [];
        }
    }

    // Lấy yêu cầu thanh toán theo ID (cơ bản)
    public function getById($id_yc)
    {
        try {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id_yc";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_yc', $id_yc, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::getById - ' . $e->getMessage());
            return false;
        }
    }

    // Lấy yêu cầu thanh toán với thông tin chi tiết đầy đủ
    public function getDetailById($id_yc)
    {
        try {
            $sql = "SELECT y.*, 
                    h.HoTen, h.SDT, h.Email,
                    -- Thông tin gói tập
                    g.TenGoiTap, g.GiaTien AS GiaGoiTap,
                    ct.NgayBatDau, ct.NgayKetThuc, ct.TrangThai AS TrangThaiGoiTap,
                    -- Thông tin dịch vụ (lấy từ GhiChu JSON)
                    dv.TenTG AS TenDichVu,
                    dv.GiaTG AS GiaDichVu,
                    -- Thông tin lớp học (lấy từ GhiChu JSON)
                    l.TenLop,
                    l.GiaTien AS GiaLopHoc,
                    l.NgayBatDau AS NgayBatDauLop, l.NgayKetThuc AS NgayKetThucLop
                FROM " . $this->table_name . " y
                JOIN HoiVien h ON y.MaHV = h.MaHV
                -- LEFT JOIN cho gói tập
                LEFT JOIN ChiTiet_GoiTap ct ON y.id_ctgt = ct.id_ctgt AND y.Loai = 'GoiTap'
                LEFT JOIN GoiTap g ON ct.MaGoiTap = g.MaGoiTap
                -- LEFT JOIN cho dịch vụ (lấy id_dv từ GhiChu JSON)
                LEFT JOIN DichVuThuGian dv ON y.Loai = 'DichVu' 
                    AND JSON_EXTRACT(y.GhiChu, '$.id_dv') = dv.id
                -- LEFT JOIN cho lớp học (lấy MaLop từ GhiChu JSON)
                LEFT JOIN LopHoc l ON y.Loai = 'LopHoc' 
                    AND JSON_EXTRACT(y.GhiChu, '$.MaLop') = l.MaLop
                WHERE y.id = :id_yc";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_yc', $id_yc, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Parse thông tin từ GhiChu JSON
            if ($result && !empty($result['GhiChu'])) {
                $ghiChuData = json_decode($result['GhiChu'], true);
                if ($result['Loai'] === 'DichVu' && $ghiChuData) {
                    $result['id_dv'] = $ghiChuData['id_dv'] ?? 0;
                    $result['NgaySuDung'] = $ghiChuData['NgaySuDung'] ?? '';
                    $result['GioSuDung'] = $ghiChuData['GioSuDung'] ?? '';
                    $result['GhiChuDichVu'] = $ghiChuData['GhiChu'] ?? null;
                } elseif ($result['Loai'] === 'LopHoc' && $ghiChuData) {
                    $result['MaLop'] = $ghiChuData['MaLop'] ?? null;
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::getDetailById - ' . $e->getMessage());
            return false;
        }
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

    // Từ chối yêu cầu thanh toán
    public function markRejected($id_yc, $ghiChu = null)
    {
        try {
            $sql = "UPDATE " . $this->table_name . "
                    SET TrangThai = 'Từ chối', NgayXacNhan = NOW(), GhiChu = :GhiChu
                    WHERE id = :id_yc AND TrangThai = 'Chờ xác nhận'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_yc', $id_yc, PDO::PARAM_INT);
            $stmt->bindParam(':GhiChu', $ghiChu);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error in YeuCauThanhToanModel::markRejected - ' . $e->getMessage());
            return false;
        }
    }
}

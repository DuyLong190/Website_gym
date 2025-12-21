USE gym_db;          
                     
CREATE TABLE GoiTap (
	MaGoiTap int AUTO_INCREMENT PRIMARY KEY,
	TenGoiTap VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL,
	GiaTien DECIMAL(10) CHECK (GiaTien >= 0),
	ThoiHan int CHECK (ThoiHan > 0),
	MoTa VARCHAR(200) CHARACTER SET utf8mb4
);                   
                
CREATE TABLE ACCOUNT (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	PASSWORD VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp,
	role TINYINT(1) NOT NULL DEFAULT 0
);                
	ALTER TABLE account add role TINYINT(1) NOT NULL DEFAULT 0;
                     
CREATE TABLE DichVuThuGian (
	id int AUTO_INCREMENT PRIMARY KEY,
	TenTG VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL,
	GiaTG DECIMAL(10,2) CHECK (GiaTG >= 0),
	ThoiGianTG int CHECK (ThoiGianTG > 0),
	MoTaTG VARCHAR(200) CHARACTER SET utf8mb4
);                                                     
                     
CREATE TABLE HoiVien (
   MaHV INT AUTO_INCREMENT PRIMARY KEY,
   HoTen VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL,
   NgaySinh DATE,    
   GioiTinh ENUM('Nam', 'Nữ', 'Khác'),
   SDT VARCHAR(15),  
   Email VARCHAR(100),
   DiaChi VARCHAR(200) CHARACTER SET utf8mb4,
   NgayDangKy Datetime DEFAULT CURRENT_timestamp,
   TrangThai ENUM('Đang hoạt động', 'Tạm ngưng', 'Đã hủy') DEFAULT 'Đang hoạt động',
   MaGoiTap INT,     
   FOREIGN KEY (MaGoiTap) REFERENCES GoiTap(MaGoiTap)
);

ALTER TABLE HoiVien
MODIFY COLUMN NgayDangKy datetime DEFAULT CURRENT_timestamp;

CREATE TABLE Role (  
   role_id TINYINT PRIMARY KEY CHECK (role_id IN (0, 1, 2)),
   role_name VARCHAR(10) NOT NULL UNIQUE CHECK (role_name IN ('admin', 'user', 'pt'))
);                   
                                        
ALTER TABLE account  
DROP COLUMN role,    
ADD COLUMN role_id TINYINT NOT NULL DEFAULT 1,
ADD CONSTRAINT fk_account_role FOREIGN KEY (role_id) REFERENCES Role(role_id);
                     
ALTER TABLE ACCOUNT  
ADD COLUMN MaHV INT, 
ADD CONSTRAINT fk_account_hoivien FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV);
                     
ALTER TABLE hoivien  
ADD COLUMN ChieuCao INT,
ADD COLUMN CanNang INT
                     
                     
CREATE TABLE pt (    
   pt_id INT AUTO_INCREMENT PRIMARY KEY,
   HoTen VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL,
   NgaySinh DATE,    
   GioiTinh ENUM('Nam', 'Nữ', 'Khác'),
   SDT VARCHAR(15),  
   Email VARCHAR(100),
   DiaChi VARCHAR(200) CHARACTER SET utf8mb4,
   ChuyenMon VARCHAR(100) CHARACTER SET utf8mb4,
   KinhNghiem INT CHECK (KinhNghiem >= 0),
   Luong DECIMAL(10,2) CHECK (Luong >= 0),
   NgayVaoLam DATE DEFAULT (CURRENT_DATE),
   TrangThai ENUM('Đang làm việc', 'Nghỉ tạm thời', 'Đã nghỉ') DEFAULT 'Đang làm việc',
);
   
ALTER TABLE account
ADD COLUMN pt_id INT NULL,
ADD CONSTRAINT fk_account_pt 
    FOREIGN KEY (pt_id) REFERENCES PT(pt_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

ALTER TABLE hoivien ADD COLUMN account_id INT;
ALTER TABLE hoivien
ADD CONSTRAINT fk_hoivien_account FOREIGN KEY (account_id)
REFERENCES account(id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE pt ADD COLUMN account_id INT;
ALTER TABLE pt
ADD CONSTRAINT fk_pt_account FOREIGN KEY (account_id)
REFERENCES account(id)
ON DELETE CASCADE
ON UPDATE CASCADE;

CREATE TABLE ChiTiet_GoiTap (
	id_ctgt INT AUTO_INCREMENT PRIMARY KEY,
   MaHV INT NOT NULL, -- FK đến HoiVien
   MaGoiTap INT NOT NULL, -- FK đến GoiTap
   NgayBatDau DATE DEFAULT (CURRENT_DATE),
   NgayKetThuc DATE NULL,
   TrangThai ENUM('Đang hoạt động', 'Hết hạn', 'Đã hủy', 'Chờ thanh toán') DEFAULT 'Chờ thanh toán',
   GhiChu VARCHAR(255) CHARACTER SET utf8mb4,
   DaThanhToan BOOLEAN DEFAULT FALSE,
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   updated_at DATETIME 
   FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (MaGoiTap) REFERENCES GoiTap(MaGoiTap) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE YeuCauThanhToan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ctgt INT NOT NULL,
    MaHV INT NOT NULL,
    SoTien DECIMAL(10,2) NOT NULL,
    TrangThai ENUM('Chờ xác nhận', 'Đã xác nhận', 'Từ chối') DEFAULT 'Chờ xác nhận',
    GhiChu VARCHAR(255),
    NgayYeuCau DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayXacNhan DATETIME,

    FOREIGN KEY (id_ctgt) REFERENCES ChiTiet_GoiTap(id_ctgt),
    FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV)
);

CREATE TABLE LopHoc (
    MaLop INT AUTO_INCREMENT PRIMARY KEY,
    TenLop VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL, -- Tên lớp: Yoga, Boxing...
    GiaTien DECIMAL(10,2) CHECK (GiaTien >= 0)
    MoTa VARCHAR(255) CHARACTER SET utf8mb4,
    NgayBatDau DATE NOT NULL,
    NgayKetThuc DATE NOT NULL,
    SoLuongToiDa INT CHECK (SoLuongToiDa > 0),
    TrangThai ENUM('Đang mở', 'Tạm ngưng', 'Đã kết thúc') DEFAULT 'Đang mở',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE lophoc 
ADD COLUMN SoLuongHienTai INT DEFAULT 0 AFTER ngayketthuc;

CREATE TABLE LichLopHoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    MaLop INT NOT NULL,
    NgayHoc DATE NOT NULL,
    GioBatDau TIME NOT NULL,
    GioKetThuc TIME NOT NULL,
    PhongHoc VARCHAR(50),
    FOREIGN KEY (MaLop) REFERENCES LopHoc(MaLop) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DangKyLopHoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    MaHV INT NOT NULL,
    MaLop INT NOT NULL,
    TrangThai ENUM('DangKy', 'Huy') DEFAULT 'DangKy',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (MaLop) REFERENCES LopHoc(MaLop) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE PtDayHoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pt_id INT NOT NULL,
    MaLop INT NOT NULL,
    TrangThai ENUM('Đăng ký', 'Hủy', 'Đã kết thúc') DEFAULT 'Đăng ký',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pt_id) REFERENCES pt(pt_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (MaLop) REFERENCES LopHoc(MaLop) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CauHinhLichHoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    MaLop INT NOT NULL,
    ThuTrongTuan INT NOT NULL CHECK (ThuTrongTuan BETWEEN 2 AND 8),
    GioBatDau TIME NOT NULL,
    GioKetThuc TIME NOT NULL,
    PhongHocMacDinh VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaLop) REFERENCES LopHoc(MaLop) ON DELETE CASCADE
);

ALTER TABLE pt ADD COLUMN image VARCHAR(255) DEFAULT NULL;
ALTER TABLE hoivien ADD COLUMN image VARCHAR(255) DEFAULT NULL;

CREATE TABLE DangKyDichVu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    MaHV INT NOT NULL,
    id_dv INT NOT NULL,
    NgayDangKy DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgaySuDung DATE NOT NULL,
    GioSuDung TIME NOT NULL,
    TrangThai ENUM('Chờ xác nhận', 'Đã xác nhận', 'Đã hủy', 'Đã hoàn thành') DEFAULT 'Chờ xác nhận',
    GhiChu VARCHAR(255) CHARACTER SET utf8mb4,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_dv) REFERENCES DichVuThuGian(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ThanhToan_GoiTap (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    goitap_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    momo_status ENUM('Chờ duyệt','Thành công','Thất bại') DEFAULT 'Chờ duyệt',
    link_data TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (goitap_id) REFERENCES GoiTap(MaGoiTap) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE thanhtoan_goitap 
ADD COLUMN id_ctgt INT NULL AFTER goitap_id,
ADD COLUMN order_id VARCHAR(255) NULL AFTER link_data;

ALTER TABLE ThanhToan_GoiTap
ADD CONSTRAINT fk_thanhtoan_chitiet_goitap 
FOREIGN KEY (id_ctgt) REFERENCES chitiet_goitap(id_ctgt) 
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE INDEX idx_order_id ON ThanhToan_GoiTap(order_id);

CREATE TABLE thanhtoan_hoadon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    MaHV INT NOT NULL,
    Loai ENUM('DichVu', 'LopHoc') NOT NULL,
    id_dangky INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL CHECK (amount >= 0),
    momo_status ENUM('Chờ duyệt', 'Thành công', 'Thất bại') DEFAULT 'Chờ duyệt',
    order_id VARCHAR(255) NULL,
    link_data TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tạo index cho order_id để tìm kiếm nhanhgym_db
CREATE INDEX idx_thanhtoan_hoadon_order_id ON thanhtoan_hoadon(order_id);
CREATE INDEX idx_thanhtoan_hoadon_loai_dangky ON thanhtoan_hoadon(Loai, id_dangky);
CREATE INDEX idx_thanhtoan_hoadon_mahv ON thanhtoan_hoadon(MaHV);
CREATE INDEX idx_thanhtoan_hoadon_loai ON thanhtoan_hoadon(Loai);

-- Thêm cột DaThanhToan vào DangKyDichVu để theo dõi trạng thái thanh toán
ALTER TABLE DangKyDichVu 
ADD COLUMN DaThanhToan BOOLEAN DEFAULT FALSE AFTER TrangThai;

-- Thêm cột DaThanhToan vào DangKyLopHoc để theo dõi trạng thái thanh toán
ALTER TABLE dangkylophoc               
ADD COLUMN DaThanhToan BOOLEAN DEFAULT FALSE AFTER TrangThai;

-- Bước 1: Thêm cột Loai để phân biệt loại yêu cầu thanh toán
ALTER TABLE YeuCauThanhToan 
ADD COLUMN Loai ENUM('GoiTap', 'DichVu', 'LopHoc') NOT NULL DEFAULT 'GoiTap' AFTER id;

-- Bước 2: Thêm cột id_dangky_dv để liên kết với DangKyDichVu
ALTER TABLE YeuCauThanhToan 
ADD COLUMN id_dangky_dv INT NULL AFTER id_ctgt;

ALTER TABLE YeuCauThanhToan 
MODIFY COLUMN id_ctgt INT NULL;

-- Bước 6: Thêm lại foreign key cho id_ctgt với CASCADE
ALTER TABLE YeuCauThanhToan 
ADD CONSTRAINT fk_yeucau_chitiet_goitap 
FOREIGN KEY (id_ctgt) REFERENCES ChiTiet_GoiTap(id_ctgt) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Bước 7: Thêm foreign key cho id_dangky_dv liên kết với DangKyDichVu
ALTER TABLE YeuCauThanhToan 
ADD CONSTRAINT fk_yeucau_dangky_dichvu 
FOREIGN KEY (id_dangky_dv) REFERENCES DangKyDichVu(id) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Bước 8: Thêm foreign key cho id_dangky_lh liên kết với DangKyLopHoc
ALTER TABLE YeuCauThanhToan 
ADD CONSTRAINT fk_yeucau_dangky_lophoc 
FOREIGN KEY (id_dangky_lh) REFERENCES DangKyLopHoc(id) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Bước 10: Tạo các index để tối ưu truy vấn
CREATE INDEX idx_yeucau_loai ON YeuCauThanhToan(Loai);
CREATE INDEX idx_yeucau_dangky_dv ON YeuCauThanhToan(id_dangky_dv);
CREATE INDEX idx_yeucau_dangky_lh ON YeuCauThanhToan(id_dangky_lh);
SHOW CREATE table chitiet_goitap;
SHOW CREATE table thanhtoan_goitap;
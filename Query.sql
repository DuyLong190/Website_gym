USE gym_db;          
                     
CREATE TABLE GoiTap (
	MaGoiTap int AUTO_CREMENT PRIMARY KEY,
	TenGoiTap VARCHAR() CHARACTER SET utf8mb4 NOT NULL,
	GiaTien DECIMAL(10) CHECK (GiaTien >= 0),
	ThoiHan int CHECK ThoiHan > 0),
	MoTa VARCHAR(200) CHARACTER SET utf8mb4
);                   
                
CREATE TABLE ACCOUNT (
	id INT AUTO_INCREMT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	PASSWORD VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp
	);                
	ALTER TABLE accounadd role TINYINT(1) NOT NULL DEFAULT 0;
                     
CREATE TABLE DichVuThuGian (
	id int AUTO_INCREMT PRIMARY KEY,
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
ADD CONSTRAINT fk_account_hoivien FOREIGN KEY (MaHV) REFERENCES HoiVien(MaHV);`account`
                     
ALTER TABLE hoivien  
ADD COLUMN ChieuCao INT,
ADD COLUMN CanNang INT
                     
                     
CREATE TABLE pt (    
   pt_id INT AUTO_INCREMENT PRIMARY KEY, -- Mã PT tự tăng
   HoTen VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL, -- Tên PT
   NgaySinh DATE,    
   GioiTinh ENUM('Nam', 'Nữ', 'Khác'),
   SDT VARCHAR(15),  
   Email VARCHAR(100),
   DiaChi VARCHAR(200) CHARACTER SET utf8mb4,
   ChuyenMon VARCHAR(100) CHARACTER SET utf8mb4, -- Chuyên môn: gym, boxing, yoga,...
   KinhNghiem INT CHECK (KinhNghiem >= 0),       -- Số năm kinh nghiệm
   Luong DECIMAL(10,2) CHECK (Luong >= 0),        -- Lương cơ bản
   NgayVaoLam DATE DEFAULT (CURRENT_DATE),
   TrangThai ENUM('Đang làm việc', 'Nghỉ tạm thời', 'Đã nghỉ') DEFAULT 'Đang làm việc',
);
   
ALTER TABLE account
ADD COLUMN pt_id INT NULL,
ADD CONSTRAINT fk_account_pt 
    FOREIGN KEY (pt_id) REFERENCES PT(pt_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

ALTER TABLE account DROP FOREIGN KEY fk_account_hoivien;
ALTER TABLE hoivien ADD COLUMN account_id INT;
ALTER TABLE hoivien
ADD CONSTRAINT fk_hoivien_account FOREIGN KEY (account_id)
REFERENCES account(id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE account DROP FOREIGN KEY fk_account_pt;
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
    PhuongThuc ENUM('Tiền mặt', 'Chuyển khoản', 'VNPay', 'Momo'),
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

gym_dbCREATE TABLE PtDayHoc (
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
    ThuTrongTuan INT NOT NULL CHECK (ThuTrongTuan BETWEEN 2 AND 8), -- 2: Thứ Hai, ... 8: Chủ Nhật
    GioBatDau TIME NOT NULL,
    GioKetThuc TIME NOT NULL,
    PhongHocMacDinh VARCHAR(50), -- Phòng mặc định cho thứ này
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaLop) REFERENCES LopHoc(MaLop) ON DELETE CASCADE
);

ALTER TABLE pt ADD COLUMN image VARCHAR(255) DEFAULT NULL;
ALTER TABLE hoivien ADD COLUMN image VARCHAR(255) DEFAULT NULL;

CREATE TABLE ThanhToan_GoiTap (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Khóa chính
    customer_id INT NOT NULL,                   -- Hội viên thanh toán
    goitap_id INT NOT NULL,                        -- Mã gói tập hoặc lớp học
    amount DECIMAL(10,2) NOT NULL,              -- Số tiền thanh toán
    momo_status ENUM('Chờ duyệt','Thành công','Thất bại') DEFAULT 'Chờ duyệt',
    link_data TEXT,                             -- Dữ liệu trả về từ MoMo (JSON)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES HoiVien(MaHV) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (goitap_id) REFERENCES GoiTap(MaGoiTap) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE ThanhToan_GoiTap 
ADD COLUMN id_ctgt INT NULL AFTER goitap_id,
ADD COLUMN order_id VARCHAR(255) NULL AFTER link_data;

ALTER TABLE ThanhToan_GoiTap
ADD CONSTRAINT fk_thanhtoan_chitiet_goitap 
FOREIGN KEY (id_ctgt) REFERENCES chitiet_goitap(id_ctgt) 
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE INDEX idx_order_id ON ThanhToan_GoiTap(order_id);

USE gym_db;

CREATE TABLE GoiTap (
	MaGoiTap int AUTO_INCREMENT PRIMARY KEY,
	TenGoiTap VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL,
	GiaTien DECIMAL(10,2) CHECK (GiaTien >= 0),
	ThoiHan int CHECK (ThoiHan > 0),
	MoTa VARCHAR(200) CHARACTER SET utf8mb4
);
INSERT INTO GoiTap (MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT003', 'Gói Nâng Cao', 1000000.0, 90, 'Dành cho hội viên tiềm năng, có thể sử dụng tất cả cơ sở vật chất mà trung tâm đang có')

CREATE TABLE ACCOUNT (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	PASSWORD VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp
	);
	ALTER TABLE account add role TINYINT(1) NOT NULL DEFAULT 0;

INSERT INTO GoiTap (TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT003', 'Gói Nâng Cao', 1000000.0, 90, 'Dành cho hội viên tiềm năng, có thể sử dụng tất cả cơ sở vật chất mà trung tâm đang có')
INSERT INTO GoiTap (MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT002', 'Gói kèm cặp', 600000.00, 60, 'Gói tập luyện 1:1 với PT.');USE gym_db;

CREATE TABLE DichVuThuGian (
	id int AUTO_INCREMENT PRIMARY KEY,
	TenTG VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL,
	GiaTG DECIMAL(10,2) CHECK (GiaTG >= 0),
	ThoiGianTG int CHECK (ThoiGianTG > 0),
	MoTaTG VARCHAR(200) CHARACTER SET utf8mb4
);
INSERT INTO dichvuthugian (id, TenTG, GiaTG, ThoiGianTG, MoTaTG) VALUES
	('1', 'Massage', 10000.0, 90, 'Massage y học cổ truyền')
SELECT id, TenTG, GiaTG, ThoiGianTG, MoTaTG FROM dichvuthugian

CREATE TABLE DichVuTapLuyen (
	id int AUTO_INCREMENT PRIMARY KEY,
	TenTL VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL,
	GiaTL DECIMAL(10,2) CHECK (GiaTL >= 0),
	ThoiGianTL int CHECK (ThoiGianTL > 0),
	MoTaTL VARCHAR(200) CHARACTER SET utf8mb4
);

INSERT INTO dichvutapluyen (id, TenTL, GiaTL, ThoiGianTL, MoTaTL) VALUES
	('1', 'Boxing', 10000.0, 90, 'Boxing thái')

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
INSERT INTO HoiVien (HoTen, NgaySinh, GioiTinh, SDT, Email, DiaChi, NgayDangKy, MaGoiTap)
VALUES ('Bùi Duy Long', '2004-10-19', 'Nam', '0961054672', 'bduylong1910@gmail.com', 'BR-VT',CURDATE(), 3)
VALUES ('Nguyen Van A', '2000-01-01', 'Nam', '0123456789', 'a@gmail.com', 'Hanoi', CURDATE(), 1);

CREATE TABLE Role (
   role_id TINYINT PRIMARY KEY CHECK (role_id IN (0, 1, 2)),
   role_name VARCHAR(10) NOT NULL UNIQUE CHECK (role_name IN ('admin', 'user', 'pt'))
);

INSERT INTO role (role_id, role_name) VALUES
 	(0, 'admin'),
 	(1, 'user'),
 	(2, 'pt');
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

-- Xóa bảng nếu đã tồn tại để tránh lỗi trùng lặp
DROP TABLE IF EXISTS PT;

gym_dbCREATE TABLE pt (
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
   account_id INT,                                -- Tài khoản gắn với PT (nếu có)
   FOREIGN KEY (account_id) REFERENCES account(id)
);

INSERT INTO PT (HoTen, NgaySinh, GioiTinh, SDT, Email, DiaChi, ChuyenMon, KinhNghiem, Luong)
VALUES
('Nguyễn Văn Bình', '1995-03-12', 'Nam', '0909123456', 'binh.pt@gmail.com', 'TP. HCM', 'Gym & Fitness', 5, 15000000.00);

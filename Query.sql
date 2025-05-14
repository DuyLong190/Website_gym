aUSE gym_db;
CREATE TABLE GoiTap (
	MaGoiTap varchar(50) primary key NOT NULL,
	TenGoiTap VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL,
	GiaTien DECIMAL(10,2) CHECK (GiaTien >= 0),
	ThoiHan int CHECK (ThoiHan > 0),
	MoTa VARCHAR(200) CHARACTER SET utf8mb4
);
INSERT INTO GoiTap (MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT003', 'Gói Nâng Cao', 1000000.0, 90, 'Dành cho hội viên tiềm năng, có thể sử dụng tất cả cơ sở vật chất mà trung tâm đang có')


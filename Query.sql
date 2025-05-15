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

CREATE TABLE ACCOUNT (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	PASSWORD VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp
	);
	ALTER TABLE ACCOUNT ADD role VARCHAR(50) DEFAULT 'user';

	INSERT INTO GoiTap (MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT003', 'Gói Nâng Cao', 1000000.0, 90, 'Dành cho hội viên tiềm năng, có thể sử dụng tất cả cơ sở vật chất mà trung tâm đang có')
INSERT INTO GoiTap (MaGoiTap, TenGoiTap, GiaTien, ThoiHan, MoTa)
VALUES ('GT002', 'Gói kèm cặp', 600000.00, 60, 'Gói tập luyện 1:1 với PT.');USE gym_db;
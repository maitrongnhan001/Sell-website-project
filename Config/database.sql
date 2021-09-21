------------------------------Create Database------------------------------
CREATE DATABASE Quanlydathang;

USE Quanlydathang;
------------------------------Create table------------------------------
USE Quanlydathang;

CREATE TABLE LoaiHangHoa (
	MaLoaiHang INT(5) AUTO_INCREMENT PRIMARY KEY,
    TenLoaiHang VARCHAR(100)
);

CREATE TABLE NhanVien (
	MSNV INT(5) AUTO_INCREMENT PRIMARY KEY,
    HoTenNV VARCHAR(50),
    UserName VARCHAR(50) UNIQUE,
    Password VARCHAR(50) UNIQUE,
    ChucVu VARCHAR(50),
    DiaChi VARCHAR(50),
    SoDienThoai VARCHAR(10) CHECK(1 = SoDienThoai REGEXP '^[0-9]{10}$')
); 

CREATE TABLE HangHoa (
	MSHH INT(5) AUTO_INCREMENT PRIMARY KEY,
    TenHH VARCHAR(100),
    QuyCach VARCHAR(100),
    Gia INT(20),
    SoLuongHang INT(10),
    MaLoaiHang INT(5),
    FOREIGN KEY (MaLoaiHang) REFERENCES LoaiHangHoa(MaLoaiHang)
);

CREATE TABLE KhachHang (
	MSKH INT(5) AUTO_INCREMENT PRIMARY KEY,
    HoTenKH VARCHAR(50),
    UserName VARCHAR(50) UNIQUE,
    Password VARCHAR(50) UNIQUE,
    TenCongTy VARCHAR(50),
    SoDienThoai VARCHAR(10) CHECK(1 = SoDienThoai REGEXP '^[0-9]{10}$'),
    SoFax VARCHAR(20)
);

CREATE TABLE DatHang (
	SoDonDH INT(5) AUTO_INCREMENT PRIMARY KEY, 
    MSKH INT(5),
    MSNV INT(5),
    NgayDH DATE,
    NgayGH DATE,
    TrangThaiDH VARCHAR(50),
    FOREIGN KEY (MSKH) REFERENCES KhachHang(MSKH),
    FOREIGN KEY (MSNV) REFERENCES NhanVien(MSNV)
);

CREATE TABLE ChiTietDatHang (
	SoDonDH INT(5),
    MSHH INT(5),
    SoLuong INT(5),
    GiaDatHang INT(10),
    GiamGia INT(10),
    CONSTRAINT PK_CTDH PRIMARY KEY (SoDonDH, MSHH),
    FOREIGN KEY (SoDonDH) REFERENCES DatHang(SoDonDH)
);

CREATE TABLE HinhHangHoa(
	MaHinh INT(5) AUTO_INCREMENT PRIMARY KEY,
    TenHinh VARCHAR(200),
    MSHH INT(5),
    FOREIGN KEY (MSHH) REFERENCES HangHoa(MSHH)
);
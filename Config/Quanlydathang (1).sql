-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 27, 2021 at 03:48 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Quanlydathang`
--

-- --------------------------------------------------------

--
-- Table structure for table `ChiTietDatHang`
--

CREATE TABLE `ChiTietDatHang` (
  `SoDonDH` int(5) NOT NULL,
  `MSHH` int(5) NOT NULL,
  `SoLuong` int(5) DEFAULT NULL,
  `GiaDatHang` int(10) DEFAULT NULL,
  `GiamGia` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ChiTietDatHang`
--

INSERT INTO `ChiTietDatHang` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(1, 1, 1, 10000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `DatHang`
--

CREATE TABLE `DatHang` (
  `SoDonDH` int(5) NOT NULL,
  `MSKH` int(5) DEFAULT NULL,
  `MSNV` int(5) DEFAULT NULL,
  `NgayDH` date DEFAULT NULL,
  `NgayGH` date DEFAULT NULL,
  `TrangThaiDH` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DatHang`
--

INSERT INTO `DatHang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `TrangThaiDH`) VALUES
(1, 1, 2, '2021-09-01', '2021-09-02', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `DiaChiKH`
--

CREATE TABLE `DiaChiKH` (
  `MaDC` int(5) NOT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `MSKH` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DiaChiKH`
--

INSERT INTO `DiaChiKH` (`MaDC`, `DiaChi`, `MSKH`) VALUES
(1, 'On Sky', 1);

-- --------------------------------------------------------

--
-- Table structure for table `HangHoa`
--

CREATE TABLE `HangHoa` (
  `MSHH` int(5) NOT NULL,
  `TenHH` varchar(100) DEFAULT NULL,
  `QuyCach` varchar(100) DEFAULT NULL,
  `Gia` int(20) DEFAULT NULL,
  `SoLuongHang` int(10) DEFAULT NULL,
  `MaLoaiHang` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HangHoa`
--

INSERT INTO `HangHoa` (`MSHH`, `TenHH`, `QuyCach`, `Gia`, `SoLuongHang`, `MaLoaiHang`) VALUES
(1, 'ai biet', 'ai biet too', 1000000000, 1000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `HinhHangHoa`
--

CREATE TABLE `HinhHangHoa` (
  `MaHinh` int(5) NOT NULL,
  `TenHinh` varchar(200) DEFAULT NULL,
  `MSHH` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HinhHangHoa`
--

INSERT INTO `HinhHangHoa` (`MaHinh`, `TenHinh`, `MSHH`) VALUES
(1, 'null', 1);

-- --------------------------------------------------------

--
-- Table structure for table `KhachHang`
--

CREATE TABLE `KhachHang` (
  `MSKH` int(5) NOT NULL,
  `HoTenKH` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `TenCongTy` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(10) DEFAULT NULL CHECK (1 = `SoDienThoai` regexp '^[0-9]{10}$'),
  `SoFax` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `KhachHang`
--

INSERT INTO `KhachHang` (`MSKH`, `HoTenKH`, `Password`, `UserName`, `TenCongTy`, `SoDienThoai`, `SoFax`) VALUES
(1, 'No Name', NULL, NULL, 'DNTT Khong Ten', '0123456789', '123');

-- --------------------------------------------------------

--
-- Table structure for table `LoaiHangHoa`
--

CREATE TABLE `LoaiHangHoa` (
  `MaLoaiHang` int(5) NOT NULL,
  `TenLoaiHang` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `LoaiHangHoa`
--

INSERT INTO `LoaiHangHoa` (`MaLoaiHang`, `TenLoaiHang`) VALUES
(2, 'AI BIET');

-- --------------------------------------------------------

--
-- Table structure for table `NhanVien`
--

CREATE TABLE `NhanVien` (
  `MSNV` int(5) NOT NULL,
  `HoTenNV` varchar(50) DEFAULT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `ChucVu` varchar(50) DEFAULT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(10) DEFAULT NULL CHECK (1 = `SoDienThoai` regexp '^[0-9]{10}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `NhanVien`
--

INSERT INTO `NhanVien` (`MSNV`, `HoTenNV`, `UserName`, `Password`, `ChucVu`, `DiaChi`, `SoDienThoai`) VALUES
(2, 'Phạm Huỳnh Ngọc', 'PhamHuynhNgoc', 'd41d8cd98f00b204e9800998ecf8427e', 'Nhân viên', 'Kế Sách - Sóc Trăng', '0123444567'),
(8, 'Nguyễn Đăng Thiên', 'NguyenDangThien', 'aaa961cade1568cc627d76e731719dd5', 'Thủ kho', 'Ninh Kiều - Cần Thơ', '0123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ChiTietDatHang`
--
ALTER TABLE `ChiTietDatHang`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `DatHang`
--
ALTER TABLE `DatHang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Indexes for table `DiaChiKH`
--
ALTER TABLE `DiaChiKH`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `HangHoa`
--
ALTER TABLE `HangHoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `MaLoaiHang` (`MaLoaiHang`);

--
-- Indexes for table `HinhHangHoa`
--
ALTER TABLE `HinhHangHoa`
  ADD PRIMARY KEY (`MaHinh`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `KhachHang`
--
ALTER TABLE `KhachHang`
  ADD PRIMARY KEY (`MSKH`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `Password` (`Password`);

--
-- Indexes for table `LoaiHangHoa`
--
ALTER TABLE `LoaiHangHoa`
  ADD PRIMARY KEY (`MaLoaiHang`);

--
-- Indexes for table `NhanVien`
--
ALTER TABLE `NhanVien`
  ADD PRIMARY KEY (`MSNV`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DatHang`
--
ALTER TABLE `DatHang`
  MODIFY `SoDonDH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `DiaChiKH`
--
ALTER TABLE `DiaChiKH`
  MODIFY `MaDC` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `HangHoa`
--
ALTER TABLE `HangHoa`
  MODIFY `MSHH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `HinhHangHoa`
--
ALTER TABLE `HinhHangHoa`
  MODIFY `MaHinh` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `KhachHang`
--
ALTER TABLE `KhachHang`
  MODIFY `MSKH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LoaiHangHoa`
--
ALTER TABLE `LoaiHangHoa`
  MODIFY `MaLoaiHang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `NhanVien`
--
ALTER TABLE `NhanVien`
  MODIFY `MSNV` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ChiTietDatHang`
--
ALTER TABLE `ChiTietDatHang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`SoDonDH`) REFERENCES `DatHang` (`SoDonDH`),
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `HangHoa` (`MSHH`);

--
-- Constraints for table `DatHang`
--
ALTER TABLE `DatHang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `KhachHang` (`MSKH`),
  ADD CONSTRAINT `dathang_ibfk_2` FOREIGN KEY (`MSNV`) REFERENCES `NhanVien` (`MSNV`);

--
-- Constraints for table `DiaChiKH`
--
ALTER TABLE `DiaChiKH`
  ADD CONSTRAINT `diachikh_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `KhachHang` (`MSKH`);

--
-- Constraints for table `HangHoa`
--
ALTER TABLE `HangHoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaLoaiHang`) REFERENCES `LoaiHangHoa` (`MaLoaiHang`);

--
-- Constraints for table `HinhHangHoa`
--
ALTER TABLE `HinhHangHoa`
  ADD CONSTRAINT `hinhhanghoa_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `HangHoa` (`MSHH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 07, 2021 at 05:14 AM
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
CREATE DATABASE Quanlydathang;

USE Quanlydathang;

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
(1, 1, 1, 10000, 0),
(9, 16, 1, 5000, 0),
(10, 16, 1, 5000, 0),
(11, 15, 1, 0, 0),
(12, 15, 1, 0, 0),
(13, 19, 1, 100000, 0),
(14, 17, 1, 34000000, 0);

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
(1, 1, 2, '2021-09-01', '2021-09-02', 'success'),
(9, 3, 10, '2021-10-03', NULL, 'Bị huỷ'),
(10, 3, 10, '2021-10-03', '2021-10-07', 'Đang giao'),
(11, 3, 10, '2021-10-03', '2021-10-06', 'Bị huỷ'),
(12, 3, 10, '2021-10-03', '2021-10-06', 'Bị huỷ'),
(13, 3, NULL, '2021-10-04', NULL, 'Đặt hàng'),
(14, 3, NULL, '2021-10-06', NULL, 'Đặt hàng');

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
(1, 'On Sky', 1),
(3, 'Bến Bào - Quách Phẩm Bắc - Đầm Dơi - Cà Mau', 3);

-- --------------------------------------------------------

--
-- Table structure for table `HangHoa`
--

CREATE TABLE `HangHoa` (
  `MSHH` int(5) NOT NULL,
  `TenHH` varchar(100) DEFAULT NULL,
  `QuyCach` varchar(2000) DEFAULT NULL,
  `Gia` int(20) DEFAULT NULL,
  `SoLuongHang` int(10) DEFAULT NULL,
  `MaLoaiHang` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HangHoa`
--

INSERT INTO `HangHoa` (`MSHH`, `TenHH`, `QuyCach`, `Gia`, `SoLuongHang`, `MaLoaiHang`) VALUES
(1, 'ai biet', 'ai biet too', 1000000000, 1000, 7),
(14, 'Bánh Pizza', 'Pizza (phát âm tiếng Ý: [ˈpittsa] (nghe), tiếng Anh: /ˈpiːtsə/  (Speaker Icon.svg nghe)), người Việt thường đọc là Pi-da /pi˧ zaː˧/, là loại bánh dẹt, tròn được chế biến từ nước, bột mỳ và nấm men, sau khi đã được ủ ít nhất 24 tiếng đồng hồ và nhào nặn thành loại bánh có hình dạng tròn và dẹt, và được cho vào lò nướng chín.', 50000, 100, 6),
(15, 'Bánh Burger', 'Hamburger[a] (tiếng Việt đọc là hăm-bơ-gơ hay hem-bơ-gơ, phát âm tiếng Anh là /ˈhæmbɜrɡər/) là một loại thức ăn bao gồm bánh mì kẹp thịt xay (thường là thịt bò) ở giữa. Miếng thịt có thể được nướng, chiên, hun khói hay nướng trên lửa. Hamburger thường ăn kèm với pho mát, rau diếp, cà chua, hành tây, dưa chuột muối chua, thịt xông khói, hoặc ớt; ngoài ra, các loại gia vị như sốt cà chua, mù tạt, sốt mayonnaise, đồ gia vị, hoặc \"nước xốt đặc biệt\", (thường là một biến tấu của sốt Thousand Island) cũng có thể thể rưới lên món bánh. Loại bánh hamburger có topping là pho mát được mọi người gọi là hamburger pho mát.[1]', 20000, 998, 2),
(16, 'Bánh Momo', 'Momo là một món bánh phải thử khi đến vùng đất Tây Tạng. Cũng giống như bánh bao của Việt nam hay bánh há cảo của Trung Quốc nhưng bánh momo Tây tạng có một hương vị rất đặc biệt, đảm bảo đã ăn một lần bạn sẽ nhớ mãi. ... Trộn hỗn hợp trên với chút muối cho vừa ăn. Sau đó vắt kiệt nước bắp cải càng khô nước càng tốt.', 5000, 998, 7),
(17, 'Laptop Macbook pro 13 M1', 'Apple Macbook Pro M1 2020 sở hữu thiết kế sang trọng kế thừa từ các thế hệ trước và bên trong là một cấu hình ấn tượng từ con chip M1 lần đầu tiên xuất hiện trên MacBook Pro, hiệu năng CPU của máy tăng đến 2.8 lần, hiệu năng GPU tăng 5 lần.', 34000000, 99, 8),
(18, 'Iphone 13', 'iPhone 13 Pro Max - siêu phẩm được mong chờ nhất ở nửa cuối năm 2021 đến từ Apple. Máy có thiết kế không mấy đột phá khi so với người tiền nhiệm, bên trong đây vẫn là một sản phẩm có màn hình siêu đẹp, tần số quét được nâng cấp lên 120 Hz mượt mà, cảm biến camera có kích thước lớn hơn, cùng hiệu năng mạnh mẽ với sức mạnh đến từ Apple A15 Bionic, sẵn sàng cùng bạn chinh phục mọi thử thách.', 33900000, 100, 9),
(19, 'Áo khoác', 'Áo khoác là loại áo mặc bên ngoài, được sử dụng bởi cả nam và nữ. Tác dụng chính của loại trang phục này là để giữ ấm cơ thể. Áo khoác thường có thiết kế với tay áo dài và phần thân áo dài dài hơn các loại áo thông thường. Tùy từng loại áo khoác mà các nhà thiết kế sẽ sử dụng khuy áo, dây kéo phéc-mơ-tuya, dây đai lưng, đóng bằng nút bấm, dây kéo...hoặc một sự kết hợp của một số trong số này.', 100000, 99, 10);

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
(13, 'product_5562.jpg', 14),
(14, 'product_6662.jpg', 15),
(15, 'product_6942.jpg', 16),
(16, 'product_9862.jpeg', 17),
(17, 'product_9911.jpeg', 18),
(18, 'product_4083.jpeg', 19);

-- --------------------------------------------------------

--
-- Table structure for table `KhachHang`
--

CREATE TABLE `KhachHang` (
  `MSKH` int(5) NOT NULL,
  `HoTenKH` varchar(50) DEFAULT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `TenCongTy` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(10) DEFAULT NULL CHECK (1 = `SoDienThoai` regexp '^[0-9]{10}$'),
  `SoFax` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `KhachHang`
--

INSERT INTO `KhachHang` (`MSKH`, `HoTenKH`, `UserName`, `Password`, `TenCongTy`, `SoDienThoai`, `SoFax`) VALUES
(1, 'No Name', '', '', 'DNTT Khong Ten', '0123456789', '123'),
(3, 'Mai Trọng Nhân', 'MaiTrongNhan', '9f1628247d3db97d374edfb96f1967a8', 'SPS (Swiss post solution)', '0943363414', '1234567810');

-- --------------------------------------------------------

--
-- Table structure for table `LoaiHangHoa`
--

CREATE TABLE `LoaiHangHoa` (
  `MaLoaiHang` int(5) NOT NULL,
  `TenLoaiHang` varchar(100) DEFAULT NULL,
  `HinhAnh` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `LoaiHangHoa`
--

INSERT INTO `LoaiHangHoa` (`MaLoaiHang`, `TenLoaiHang`, `HinhAnh`) VALUES
(2, 'Burger', 'food_category_6653.jpg'),
(6, 'Bánh Pizza', 'food_category_2394.jpg'),
(7, 'Momo', 'food_category_7728.jpg'),
(8, 'Máy tính', 'category_9630.jpeg'),
(9, 'Điện thoại', 'category_6301.jpeg'),
(10, 'Quần áo', 'category_3819.jpeg');

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
(8, 'Nguyễn Đăng Thiên', 'NguyenDangThien', 'd41d8cd98f00b204e9800998ecf8427e', 'Bán hàng', 'Ninh Kiều - Cần Thơ', '0123456789'),
(9, 'Lê Phú Cường', 'LePhuCuong', 'eef7f7d9cb5792f3fce48ffb75f898d3', 'Thủ kho', 'Châu phú - An Giang', '0222333444'),
(10, 'Mai Trọng Nhân', 'MaiTrongNhan', '9f1628247d3db97d374edfb96f1967a8', 'Quản lý', 'Đầm Dơi - Cà Mau', '0943363414');

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
  ADD UNIQUE KEY `UserName` (`UserName`);

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
  MODIFY `SoDonDH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `DiaChiKH`
--
ALTER TABLE `DiaChiKH`
  MODIFY `MaDC` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `HangHoa`
--
ALTER TABLE `HangHoa`
  MODIFY `MSHH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `HinhHangHoa`
--
ALTER TABLE `HinhHangHoa`
  MODIFY `MaHinh` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `KhachHang`
--
ALTER TABLE `KhachHang`
  MODIFY `MSKH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `LoaiHangHoa`
--
ALTER TABLE `LoaiHangHoa`
  MODIFY `MaLoaiHang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `NhanVien`
--
ALTER TABLE `NhanVien`
  MODIFY `MSNV` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

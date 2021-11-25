-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2021 at 05:24 PM
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
CREATE DATABASE IF NOT EXISTS `Quanlydathang` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Quanlydathang`;

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
(18, 23, 1, 129000, 0),
(19, 33, 1, 200000, 0),
(20, 28, 1, 169000, 0),
(21, 37, 1, 30990000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `DatHang`
--

CREATE TABLE `DatHang` (
  `SoDonDH` int(5) NOT NULL,
  `MSKH` int(5) DEFAULT NULL,
  `MSNV` int(5) DEFAULT NULL,
  `MaDC` int(5) DEFAULT NULL,
  `NgayDH` date DEFAULT NULL,
  `NgayGH` date DEFAULT NULL,
  `TrangThaiDH` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DatHang`
--

INSERT INTO `DatHang` (`SoDonDH`, `MSKH`, `MSNV`, `MaDC`, `NgayDH`, `NgayGH`, `TrangThaiDH`) VALUES
(18, 3, 8, 3, '2021-11-25', '2021-11-26', 'Đang giao'),
(19, 3, NULL, 3, '2021-11-25', NULL, 'Đặt hàng'),
(20, 3, NULL, 4, '2021-11-25', NULL, 'Đặt hàng'),
(21, 3, NULL, 5, '2021-11-25', NULL, 'Đặt hàng');

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
(3, 'Bến Bào - Quách Phẩm Bắc - Đầm Dơi - Cà Mau', 3),
(4, 'Hẻm 51 - Ninh kiều - Cần Thơ', 3),
(5, 'Ngọc Chánh - Thanh Tùng - Đầm Dơi - Cà Mau', 3);

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
(21, 'Thắc lưng', '1) MÔ TẢ\r\n\r\n- Thắt Lưng được làm bằng Da bò thật 100%, 1 lớp nguyên tấm nhập khẩu Pakistan\r\n\r\n- Xử lý trơn mặt sau, cạnh nguyên bản\r\n\r\n- Khóa hợp kim chống gỉ dính nước thoải mái\r\n\r\n- Loại khóa tự động dễ dàng tăng giảm nấc\r\n\r\n- Nếu bị rộng có thể tháo đầu khóa ra và cắt bớt dây rồi lắp vào bình thường\r\n\r\n- Kiểu dáng nam tính thời trang\r\n\r\n- Phù hợp với các loại quần kaki, âu\r\n\r\n- Có thể mua làm quà tặng cực đẹp', 150000, 1000, 21),
(22, 'Assus', 'ASUSTeK Computer Incorporated (Asus), tên một tập đoàn đa quốc gia thành lập vào 1989 có trụ sở tại Đài Loan. ... Riêng về mặt hàng máy tính xách tay trong năm 2016, laptop ASUS là thương hiệu có doanh số sản phẩm bán ra cao nhất với tỷ trọng trung bình chiếm tới 34,75%', 20000000, 99, 17),
(23, 'Ổn định hay tự do', 'ỔN ĐỊNH HAY TỰ DO (Yên ổn bạn thích không cho bạn được cuộc đời như mong muốn) - cuốn sách Best-seller dành cho thế hệ GEN Z, tiếp nối Hãy khiến tương lai biết ơn vì hiện tại bạn đã cố gắng hết mình.\r\n\r\nDưới góc nhìn thực tế cùng giọng văn vô cùng thẳng thắn, sắc sảo, nữ nhà văn đã thức tỉnh hàng vạn thanh niên Trung Quốc:\r\n\r\nMơ mộng viển vông - đơn giản là không có khả năng thực hiện ước mơ\r\nNếu như không có đích đến, thì gió phương nào cũng là ngược chiều\r\nKhi tâm thái thay đổi, áp lực sẽ biến thành động lực\r\nThành công chỉ ưu ái cho những người dũng cảm\r\nXuyên suốt 300 trang sách, bạn sẽ có được hơn 56 bài học giá trị khác cho bản thân:\r\n\r\nCuốn sách truyền động lực tới bạn: dám ước mơ cũng dám biến ước mơ thành hiện thực\r\nKhích lệ bạn theo đuổi đến cùng sự nỗ lực để đạt được thành tựu tối ưu\r\nTruyền cảm hứng để sống và làm theo những gì mình muốn\r\nKhông quên nhắc nhở bạn về sức mạnh của thái độ mềm mỏng: vừa biết khoan dung cho người khác, vừa biết cúi mình khiêm tốn\r\nĐược viết ra với mục đích song hành cùng những người trẻ vì vậy mà cuốn sách đặc biệt phù hợp dành cho thế hệ GEN Z và cuối GEN Y - là những người trẻ\r\n\r\n', 129000, 998, 12),
(24, 'Laptop Dell Vostro', 'Laptop Dell Vostro 14 3405 (3405-V4R53500U001W) là thế hệ máy tính được cải tiến về hiệu năng nhằm tối ưu khả năng xử lý thông tin một cách nhanh chóng. Với thiết kế mang tính cơ động cao nhờ trọng lượng nhẹ, chiếc laptop cao cấp của Dell sẽ là người bạn đồng hành tuyệt vời dành cho bạn, đáp ứng nhu cầu di chuyển thường xuyên. \r\nThiết kế trẻ trung hiện đại, trang bị pin 3 Cell 42Wh\r\nMáy tính xách tay/ Laptop Dell Vostro 14 3405 (3405-V4R53500U001W) mang phong cách hiện đại nhưng không kém phần thanh lịch với thiết kế  chú trọng sự tinh tế trong từng chi tiết. Tông màu đen sang trọng giúp chiếc laptop cao cấp trở nên thật nổi bật và thu hút người nhìn hơn.', 15099000, 100, 17),
(25, 'Macbook Pro 14', 'Macbook Pro 14 inch - Chiếc Macbook đáng mong đợi nhất 2021\r\nKế thừa những tinh hoa từ đời MacBook tốt nhất cùng với những nâng cấp đáng kể trong nhiều năm qua, Macbook Pro 14 inch dự kiến sẽ là mẫu laptop làm cho giới công nghệ \"phát sốt\", cũng như là cỗ máy xử lý công việc tối ưu hiệu quả.', 52990000, 100, 17),
(26, 'Code dạo ký sự', 'Code Dạo Kí Sự - Lập Trình Viên Đâu Phải Chỉ Biết Code\r\n\r\nNếu các bạn có đọc các blog về lập trình ở Việt Nam thì có lẽ cái tên Tôi đi code dạo không có gì quá xa lạ đối với các bạn.\r\n\r\nVề tác giả của blog Tôi đi code dạo, anh tên thật là Phạm Huy Hoàng, một Developer Full Stack, cựu sinh viên trường FPT University, hiện tại anh đang học Thạc sĩ Computer Science tại Đại học Lancaster ở Anh (học bổng $18000). Trước khi qua Xứ Sở Sương Mù, anh đã từng làm việc tại FPT Software và ASWIG Solutions.\r\n\r\n', 144500, 999, 12),
(28, 'Áo thun cổ ngắn', 'KIỂU DÁNG: Slim Fit\r\n\r\nCHI TIẾT:\r\n\r\n- Áo Thun Nam Polo Ngắn Tay 5S (APC21013) Chất Liêu 100% Coolmax Phối Viền Năng Động, Trẻ Trung, Nam Tính có thiết kế kiểu dáng cơ bản với dáng ôm vừa, cổ bẻ, tay ngắn in logo 5S, kiểu dáng thể thao.\r\n\r\n- Áo Thun Nam Polo Ngắn Tay 5S (APC21013) Chất Liêu 100% Coolmax Phối Viền Năng Động, Trẻ Trung, Nam Tính, dễ dàng phối cùng quần jeans hoặc shorts, giày thể thao hoặc giày lười, thích hợp sử dụng trong các dịp đi chơi, gặp gỡ bạn bè và các hoạt động ngoài trời.', 169000, 999, 13),
(29, 'Áo thun có bâu', 'KIỂU DÁNG: Slim Fit\r\n\r\nCHI TIẾT:\r\n\r\n- Áo Thun Nam Polo Ngắn Tay 5S (APC21013) Chất Liêu 100% Coolmax Phối Viền Năng Động, Trẻ Trung, Nam Tính có thiết kế kiểu dáng cơ bản với dáng ôm vừa, cổ bẻ, tay ngắn in logo 5S, kiểu dáng thể thao.\r\n\r\n- Áo Thun Nam Polo Ngắn Tay 5S (APC21013) Chất Liêu 100% Coolmax Phối Viền Năng Động, Trẻ Trung, Nam Tính, dễ dàng phối cùng quần jeans hoặc shorts, giày thể thao hoặc giày lười, thích hợp sử dụng trong các dịp đi chơi, gặp gỡ bạn bè và các hoạt động ngoài trời.', 100000, 1000, 13),
(30, 'Áo khoác', 'HƯỚNG DẪN CÁCH ĐẶT HÀNG\r\n\r\nCách chọn size: Shop có bảng size mẫu. Bạn NÊN INBOX, cung cấp chiều cao, cân nặng để SHOP TƯ VẤN SIZE\r\n\r\nMã sản phẩm đã có trong ảnh\r\n\r\nCách đặt hàng: Nếu bạn muốn mua 2 sản phẩm khác nhau hoặc 2 size khác nhau\r\n\r\n- Bạn chọn từng sản phẩm rồi thêm vào giỏ hàng - Khi giỏ hàng đã có đầy đủ các sản phẩm cần mua, bạn mới tiến hành ấn nút “ Thanh toán”\r\n\r\nShop luôn sẵn sàng trả lời inbox để tư vấn\r\n\r\n', 209000, 1000, 20),
(31, 'Giày Thể Thao Cao Cấp Nữ', 'Giày guci, hàng mới về,\r\n\r\nchất rất đẹp\r\n\r\n+ C- Giao hàng tại nhà, Thanh toán tại nhà, nhanh chóng, tiện dụng\r\n\r\nCHAT TRỰC TIẾP VỚI NHÂN VIÊN\r\n\r\n️ Gửi khách xem mẫu giày hiện có\r\n\r\n️ Tư vấn các mẫu giày phù hợp với khách hàng\r\n\r\n', 215000, 1000, 14),
(32, 'Nói dối', 'Mọi người đều nói dối.\r\n\r\nNgười ta nói dối số li đã uống trước khi về nhà. Họ nói dối số lần đi tập gym một tuần, về giá đôi giày mới mua, và cả về chuyện có đọc quyển sách mà họ đã nói hay không. Họ gọi điện báo nghỉ bệnh khi vẫn khỏe như vâm. Họ nói sẽ liên lạc nhưng rồi bặt vô âm tín. Họ nói rằng chuyện không liên quan đến bạn mặc dù có liên quan. Họ nói họ yêu bạn dù rằng họ không hề yêu. Họ nói họ vui dù rằng đang buồn chán. Họ nói họ thích phụ nữ dù thực tế họ thích đàn ông.', 96000, 1000, 12),
(33, 'Clean Code', 'Hôm nay bỗng dưng không có hứng viết bài về technical, thôi thì lôi đại cuốn này ra review vây. Mình đọc cuốn này trong thời gian còn làm việc ở FPT Software (Làm việc lúc nào cũng dư thời gian nên toàn lôi ebook ra đọc. Cuốn sách này xứng đáng là sách gối đầu giường của mọi developer. Mình khuyên các bạn nên mua bản gốc, 1 là để đọc, 2 là nếu gặp thằng nào code ngu, có thể cầm cuốn này đập vào đầu nó và bắt nó đọc.\r\n\r\n', 200000, 999, 12),
(35, 'Giày Snearker Thể Thao Nam', '\r\nKiểu dáng thể thao, mạnh mẽ,thiết kế tinh tế,năng động và trẻ trung. Đế cao su bền chắc, có độ bám cao, tăng khả năng chống trơn trượt Thích hợp khi tham gia các hoạt động thể thao, đạp xe, leo núi , trượt ván... Dễ dàng kết hợp với hầu hết các phong cách thời trang như:đi học,đi chơi,đi du lịch. Giầy đôi,giày nhóm.... Giày đi êm chân, form chuẩn, chất giày ôm chân, phù hợp với tất cả các bạn từ lứa tuổi. Giày có độ chống dính,chống trơn trượt tốt. Thích hợp cho các bạn đi giày đôi, giày nhóm, đi du lịch picnic hay đi học. Sản phẩm là sự kết hợp khéo léo giữa kiểu dáng thể thao với chất liệu vải cực tốt chắc chắn sẽ làm bạn hài lòng Giày được thiết kế đơn giản nhưng lại vô cùng bắt mắt trên nền những mảng sáng tối khác nhau, khiến đôi giày trở nên nổi bật hơn bao giờ hết. Bạn có thể kết hợp với những món đồ để tạo nên Style riêng cho mình, có cả size giày nam và nữ cho bạn lựa chọn.', 119000, 1000, 14),
(36, 'Đừng chạy theo số đông', 'Nếu tất cả mọi người ai cũng làm chủ doanh nghiệp, thì ai sẽ đi làm thuê?\r\n\r\nTôi.\r\n\r\nBởi lúc đó họ sẽ phải đấu giá để có được tôi.\r\n\r\nNhưng điều này không bao giờ xảy ra. Bởi ngay từ trong trứng đến lúc mọc cánh, chúng ta đã được dạy phải làm cho người khác cả đời. Chỉ có 1% được dạy khác.\r\n\r\nBạn không chạy theo số đông.\r\n\r\nBạn LÀ số đông.\r\n\r\nTuy nhiên bạn đừng nhầm lẫn. Cuốn sách này không chỉ nói về vấn đề “làm thuê” hay “làm riêng”. Đây chỉ là một trong những khía cạnh rất nhỏ.\r\n\r\nCuốn sách này muốn làm nổi bật một hệ tư duy ngầm lớn và khủng khiếp hơn thế mà chúng ta không nhận ra. Một sức hút vô hình nhưng mạnh mẽ.', 132700, 1000, 12),
(37, 'Iphone 13', 'iPhone 13 gói gọn nhiều tính năng cực đỉnh trong một thiết kế 6.1 inch.2 Mạng 5G giúp tải xuống các bộ phim một cách nhanh chóng và xem trực tuyến video chất lượng cao.1 Màn hình Super Retina XDR nhỏ gọn và sáng đẹp ấn tượng. Ceramic Shield với khả năng chịu va đập khi rơi tốt hơn gấp 4 lần.3 Ảnh chụp tuyệt đẹp trong điều kiện ánh sáng yếu với chế độ Ban Đêm ở tất cả các camera. Quay phim, biên tập và phát video Dolby Vision đẳng cấp điện ảnh. Chip A15 Bionic mạnh mẽ.\r\n\r\n', 30990000, 999, 16),
(38, 'Macbook Pro 13', 'Macbook Pro 13 inch thay đổi ngoạn mục nhờ chip Apple M1, với sức mạnh xử lý tăng thêm đến 2.8x, (1) tốc độ xử lý\r\nđồ họa nhanh hơn 5x1 cùng thời lượng pin lên đến 20 giờ – thời lượng pin lâu nhất từng có ở máy Mac.(2) Vì vậy, bạn\r\ncó thể đẩy nhanh tiến độ mọi việc, dù đi bất kỳ nơi đâu.', 38500000, 1000, 17);

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
(21, 'product_5595.jpeg', 21),
(22, 'product_9779.webp', 22),
(23, 'product_7311.webp', 23),
(24, 'product_9371.webp', 24),
(25, 'product_9599.jpeg', 25),
(26, 'product_966.jpeg', 21),
(27, 'product_6258.jpeg', 26),
(28, 'product_2953.jpeg', 26),
(32, 'product_8520.webp', 28),
(33, 'product_4032.webp', 29),
(34, 'product_6166.jpeg', 30),
(35, 'product_3730.webp', 31),
(36, 'product_7071.webp', 31),
(37, 'product_6816.webp', 32),
(38, 'product_6320.jpeg', 33),
(39, 'product_9848.webp', 33),
(40, 'product_9428.jpeg', 33),
(41, 'product_1234.webp', 28),
(43, 'product_545.webp', 35),
(44, 'product_5525.webp', 36),
(45, 'product_2542.jpeg', 37),
(46, 'product_8349.jpeg', 38),
(47, 'product_9999.webp', 29);

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
(12, 'Sách', 'food_category_5437.jpeg'),
(13, 'Thời trang', 'category_8012.jpeg'),
(14, 'Giày & Dép', 'category_511.webp'),
(15, 'Đồ gia dụng', 'category_1531.jpeg'),
(16, 'Điện thoại', 'category_6538.jpeg'),
(17, 'Laptop', 'category_9419.jpeg'),
(20, 'Áo khoác', 'category_928.jpeg'),
(21, 'Thắc lưng', 'category_4451.jpeg');

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
(8, 'Nguyễn Đăng Thiên', 'NguyenDangThien', 'aaa961cade1568cc627d76e731719dd5', 'Bán hàng', 'Ninh Kiều - Cần Thơ', '0123456789'),
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
  ADD KEY `MSNV` (`MSNV`),
  ADD KEY `DiaChiKH` (`MaDC`);

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
  MODIFY `SoDonDH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `DiaChiKH`
--
ALTER TABLE `DiaChiKH`
  MODIFY `MaDC` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `HangHoa`
--
ALTER TABLE `HangHoa`
  MODIFY `MSHH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `HinhHangHoa`
--
ALTER TABLE `HinhHangHoa`
  MODIFY `MaHinh` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `KhachHang`
--
ALTER TABLE `KhachHang`
  MODIFY `MSKH` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `LoaiHangHoa`
--
ALTER TABLE `LoaiHangHoa`
  MODIFY `MaLoaiHang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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

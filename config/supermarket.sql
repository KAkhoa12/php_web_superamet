-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2023 at 05:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `idCate` int(11) NOT NULL,
  `nameCategory` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idCate`, `nameCategory`) VALUES
(1, 'Trái cây'),
(2, 'Hàng đông lạnh'),
(3, 'Rau củ'),
(4, 'Thịt'),
(5, 'Hải sản'),
(6, 'Đồ uống');

-- --------------------------------------------------------

--
-- Table structure for table `detailorder`
--

CREATE TABLE `detailorder` (
  `idOder` int(11) NOT NULL,
  `idPro` int(11) NOT NULL,
  `numPro` int(11) NOT NULL,
  `pricePro` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detailorder`
--

INSERT INTO `detailorder` (`idOder`, `idPro`, `numPro`, `pricePro`, `status`, `total`) VALUES
(42, 3, 1, 15000, 'Confirmed', 15000),
(45, 3, 1, 15000, 'Confirmed', 15000),
(46, 5, 1, 40000, 'Confirmed', 40000),
(68, 3, 1, 15000, 'unconfirmed', 15000),
(69, 5, 1, 40000, 'Confirmed', 40000),
(70, 8, 1, 10000, 'Confirmed', 10000),
(71, 3, 1, 15000, 'Confirmed', 15000),
(72, 4, 2, 30000, 'Confirmed', 60000),
(72, 5, 3, 40000, 'Confirmed', 120000),
(73, 3, 1, 15000, 'Confirmed', 15000),
(73, 1, 1, 25000, 'Confirmed', 25000),
(75, 3, 1, 15000, 'Confirmed', 15000),
(75, 4, 1, 30000, 'Confirmed', 30000),
(76, 3, 1, 15000, 'unconfirmed', 15000);

--
-- Triggers `detailorder`
--
DELIMITER $$
CREATE TRIGGER `update_product_quantity` AFTER UPDATE ON `detailorder` FOR EACH ROW BEGIN
    IF NEW.`status` = 'Confirmed' THEN
        UPDATE `product`
        SET `amount` =  `amount` - NEW.numPro
        WHERE idPro = NEW.idPro;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `idOder` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `sumMoney` double NOT NULL,
  `dayCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`idOder`, `idUser`, `sumMoney`, `dayCreate`) VALUES
(42, 6, 25000, '2023-05-14 09:43:20'),
(45, 36, 25000, '2023-05-14 09:45:13'),
(46, 36, 50000, '2023-05-14 09:50:40'),
(68, 36, 0, NULL),
(69, 6, 50000, '2023-05-15 07:45:47'),
(70, 6, 20000, '2023-05-19 13:13:34'),
(71, 40, 25000, '2023-05-19 22:17:33'),
(72, 40, 190000, '2023-05-19 22:28:04'),
(73, 40, 50000, '2023-05-19 22:39:32'),
(75, 6, 55000, '2023-05-20 22:05:05'),
(76, 6, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `idPro` int(11) NOT NULL,
  `namePro` varchar(100) NOT NULL,
  `decription` varchar(500) NOT NULL,
  `oldPrice` double NOT NULL,
  `newPrice` double NOT NULL,
  `amount` int(11) NOT NULL,
  `imgPro` varchar(100) NOT NULL,
  `idCate` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'Show',
  `dvt` varchar(255) DEFAULT 'kg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idPro`, `namePro`, `decription`, `oldPrice`, `newPrice`, `amount`, `imgPro`, `idCate`, `status`, `dvt`) VALUES
(1, 'Táo', 'Táo mỹ 100% chính hãng nhập khẩu', 35000, 25000, 29, 'tao.jpg', 1, 'Show', 'kg'),
(3, 'Chuối', 'Chuối chín đỏ, giòn ngọt', 20000, 15000, 49, 'chuoi.jpg', 1, 'Show', 'kg'),
(4, 'Cam', 'Cam sành tươi ngon', 40000, 30000, 9, 'cam.jpg', 1, 'Show', 'kg'),
(5, 'Sầu riêng', 'Sầu riêng chín đỏ, thơm ngon', 50000, 40000, 10, 'saurieng.jpg', 1, 'Show', 'kg'),
(6, 'Hải sản tươi sống', 'Tôm hùm, sò điệp, hàu sạch ngon', 200000, 180000, 10, 'haisan.jpg', 5, 'Show', 'kg'),
(7, 'Thịt bò Úc', 'Thịt bò Úc chất lượng cao', 50000, 45000, 10, 'thitbouc.jpg', 4, 'Show', 'kg'),
(8, 'Cà rốt', 'Cà rốt tươi ngon xanh', 15000, 10000, 29, 'carot.jpg', 3, 'Show', 'kg'),
(9, 'Hoa quả đóng hộp', 'Mận, xoài, đào, đu đủ, dứa đóng hộp', 25000, 20000, 18, 'hoaquadonghop.jpg', 2, 'Show', 'kg'),
(10, 'Bò Mỹ', 'Thịt bò Mỹ ngon đến từng thớ', 500000, 450000, 10, 'thitbomy.jpg', 4, 'Show', 'kg'),
(11, 'Thịt bò', 'Thịt bò sạch từ các trang trại chăn nuôi đạt tiêu chuẩn', 120000, 100000, 20, 'thitbo.jpg', 4, 'Show', 'kg'),
(12, 'Nước chanh', 'Nước chanh tươi nguyên chất', 15000, 12000, 30, 'nuocchanh.jpg', 6, 'Show', 'kg'),
(13, 'Thịt Heo', 'Thịt heo tươi ngon đảm bảo chất lượng', 120000, 100000, 20, 'thitheo.jpg', 4, 'Show', 'kg'),
(14, 'Cá Ngừ', 'Cá ngừ tươi ngon từ đại dương xanh', 150000, 120000, 10, 'cangu.jpg', 5, 'Show', 'kg'),
(15, 'Sữa tươi', 'Sữa tươi nguyên chất 100% từ trang trại sữa', 25000, 20000, 30, 'suatuoi.jpg', 6, 'Show', 'kg'),
(16, 'Bắp cải', 'Bắp cải tươi ngon từ vườn rau sạch', 5000, 4000, 50, 'bapcai.jpg', 3, 'Show', 'kg'),
(17, 'Rau muống', 'Rau muống sạch, xanh', 7000, 6000, 30, 'raumuong.jpg', 3, 'Show', 'kg'),
(18, 'Tôm hùm alaska', 'Tôm hùm tươi ngon từ biển đông', 250000, 200000, 10, 'tomhum.jpg', 5, 'Show', 'kg'),
(19, 'Sườn Non', 'Sườn non tươi ngon, thơm lừng', 150000, 120000, 15, 'suonnon.jpg', 4, 'Show', 'kg'),
(20, 'Nấm kim châm', 'Nấm kim châm Hàn Quóc 200g', 22000, 19000, 44, 'namkimcham.jpg', 3, 'Show', 'kg'),
(39, 'Sầu riêng úc', 'Sầu riêng thơm ngon', 0, 50000, 10, 'khoa.png', 1, 'Show', 'kg');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `nameRole` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idRole`, `nameRole`) VALUES
(1, 'Admin'),
(2, 'Nhân viên'),
(3, 'Người dùng');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nameUser` varchar(50) NOT NULL,
  `phoneNumber` varchar(12) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `dayOfBirth` date NOT NULL,
  `idRole` int(11) NOT NULL,
  `password` varchar(80) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `imgUser` varchar(255) DEFAULT 'defaultImg.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `nameUser`, `phoneNumber`, `address`, `email`, `dayOfBirth`, `idRole`, `password`, `gender`, `imgUser`) VALUES
(1, 'Nguyễn Văn Báo ', '0767096431', '153 Hoàng Hoa Thám, Quặn Đống Đa,Hà Nội', 'nguyenvanbao@gmail.com', '2002-04-12', 1, '123123', 'Nam', 'defaultImg.jpg'),
(2, 'Nguyễn Thị Hồng', '0987654321', '123 Lê Lợi, Quận 1, TP.HCM', 'nguyenthihong@gmail.com', '2006-01-01', 3, 'Huynhquybao12', 'Nữ', 'defaultImg.jpg'),
(3, 'Trần Văn Đức', '0981111222', '456 Nguyễn Huệ, Quận 3, TP.HCM', 'tranduc@gmail.com', '2006-02-01', 2, '123456', 'Nam', 'defaultImg.jpg'),
(4, 'Lê Thị Tâm', '0983333444', '789 Điện Biên Phủ, Quận 5, TP.HCM', 'lethitam@gmail.com', '2006-03-01', 2, '123456', 'Nữ', 'defaultImg.jpg'),
(5, 'Nguyễn Văn Tùng Tèo', '0985555666', '111 Trần Phú, Quận 7, TP.HCM', 'nguyenvantung@gmail.com', '2006-04-01', 2, 'Tranvantung12', 'Nam', 'icon_dashboard.webp'),
(6, 'Phạm Thị Thùy', '0987777888', '222 Nguyễn Thị Minh Khai, Quận 10, TP.HCM', 'phamthithuy@gmail.com', '2006-05-01', 3, '123456', 'Nữ', 'defaultImg.jpg'),
(7, 'Nguyễn Văn Quang', '0989999000', '333 Bến Vân Đồn, Quận 4, TP.HCM', 'nguyenvanquang@gmail.com', '2006-06-01', 3, '123456', 'Nam', 'defaultImg.jpg'),
(8, 'Võ Thị Phương', '0981111333', '444 Lê Duẩn, Quận 1, TP.HCM', 'vothiphuong@gmail.com', '2006-07-01', 3, '123456', 'Nữ', 'defaultImg.jpg'),
(9, 'Trần Văn Quân', '0936687121', '156 Trần Duy Hưng, Cầu Giấy, Hà Nội', 'tranvanquan@gmail.com', '2005-11-25', 3, '123456', 'Nam', 'defaultImg.jpg'),
(10, 'Nguyễn Thị Thu', '0867743215', '87 Lê Trọng Tấn, Khương Mai, Thanh Xuân, Hà Nội', 'nguyenthuthu@gmail.com', '2004-02-10', 3, '123456', 'Nữ', 'defaultImg.jpg'),
(11, 'Phạm Văn Lộc', '0912345678', '12 Trường Chinh, Đống Đa, Hà Nội', 'phamvanloc@gmail.com', '2003-06-15', 3, '123456', 'Nam', 'defaultImg.jpg'),
(12, 'Vũ Thị Hà', '0903228989', '45 Tân Mai, Hoàng Mai, Hà Nội', 'vuthiha@gmail.com', '2006-09-20', 3, '123456', 'Nữ', 'defaultImg.jpg'),
(13, 'Nguyễn Thành Long', '0854321987', '28 Nguyễn Công Trứ, Hai Bà Trưng, Hà Nội', 'nguyenthanhlong@gmail.com', '2005-03-02', 3, '123456', 'Nam', 'defaultImg.jpg'),
(14, 'Lê Thị Lan', '0943245612', '42 Hoàng Ngọc Phách, Đống Đa, Hà Nội', 'lethilan@gmail.com', '2006-08-05', 3, '123456', 'Nữ', 'defaultImg.jpg'),
(15, 'Nguyễn Văn Hùng', '0978123456', '83 Trần Quang Khải, Hoàn Kiếm, Hà Nội', 'nguyenvanhung@gmail.com', '2004-12-30', 3, '123456', 'Nam', 'defaultImg.jpg'),
(34, 'khoa khoa', '', '', 'blkhoa17@gmail.com', '0000-00-00', 3, '1234', '', 'defaultImg.jpg'),
(35, 'Huỳnh Đăng Khoa', '0767096431', '', 'rimiba2361@cmeinbox.com', '2002-04-12', 3, 'Huynhkhoa544', 'Nam', 'defaultImg.jpg'),
(36, 'Huỳnh khoa 543434', '0767096431', 'Hoàng Hoa Thán', '12ww3@gmail.com', '2000-01-01', 3, 'Huynhkhoa544', 'Nam', 'defaultImg.jpg'),
(37, 'khoa khoa khoa ', '0767096433', 'hoàng than thanh ', 'blkhoi17@gmail.com', '2023-05-18', 2, 'Huynhkhoa13', 'Nữ', 'bg-form-info.jpg'),
(38, 'toi tên khoa ', '', '', 'nguyenvanbao1@gmail.com', '0000-00-00', 2, 'Toitoi12', 'Nam', 'defaultImg.jpg'),
(39, 'khoa khoa khoa khoa ', '0767096431', 'tân sơn nhì ', 'blkhoa12@gmail.com', '2023-05-25', 3, 'Huynhkhoa544', 'Nữ', ''),
(40, 'Huỳnh trân đăng Khoa', '0123458769', 'xin chào', 'rimiba236222221@cmeinbox.com', '2023-05-27', 3, 'Toitenla12', 'Nam', 'defaultImg.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCate`);

--
-- Indexes for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD KEY `idOder` (`idOder`),
  ADD KEY `idPro` (`idPro`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idOder`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idPro`),
  ADD KEY `idCate` (`idCate`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `idCate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `idOder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idPro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD CONSTRAINT `detailorder_ibfk_1` FOREIGN KEY (`idPro`) REFERENCES `product` (`idPro`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `detailorder_ibfk_2` FOREIGN KEY (`idOder`) REFERENCES `order` (`idOder`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idCate`) REFERENCES `category` (`idCate`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

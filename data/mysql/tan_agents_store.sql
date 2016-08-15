-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2016 at 09:06 PM
-- Server version: 5.6.31
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nhuadenh_nhuadenhat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tan_agents_store`
--

CREATE TABLE IF NOT EXISTS `tan_agents_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agents_store` varchar(100) NOT NULL,
  `id_province` int(11) NOT NULL,
  `id_district` int(11) NOT NULL,
  `address` varchar(150) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `tan_agents_store`
--

INSERT INTO `tan_agents_store` (`id`, `agents_store`, `id_province`, `id_district`, `address`, `telephone`, `fax`) VALUES
(1, 'CTY TNHH MTV TM THANH DUNG', 8, 46, 'A8/16 Ấp 1, Thanh Niên, Lê Minh Xuân', '(08).39716373', '(08).38651917'),
(2, 'CTY TNHH DV SÁU ẨN', 8, 39, '12R-334 Tô Hiến Thành, phường 14', '(08).35070013', '(08).38639607'),
(3, 'CTY TNHH  HOÀNG MINH ANH', 20, 328, 'B1, KP4, đường Đồng  Khởi, P. Tân Hiệp', '(061).3895.797', '(061).3895.797'),
(4, 'CTY TNHH SX- TM - DV  VÂN THIÊN ', 8, 48, '93- KP2, Võ Văn Ngân, P. Linh Chiểu', '(08).37222.464', '(08).37.220.454'),
(5, 'DOANH  NGHIỆP TƯ NHÂN  VI VI ', 20, 328, 'KP6, P.Tân Biên', '(061).3881.260', ''),
(6, 'CTY TNHH XUẤT NHẬP KHẨU  LỮ NAM ', 8, 42, '286 đường số 1, KP 7, P.Bình Trị Đông', '(08).62.602.229', '(08).62.602.002'),
(7, 'CTY TNHH  AN NHẬT HÀ ', 40, 473, '189 Nguyễn Thái Bình. P.3', '723.513.870', '726.251.012'),
(8, 'CTY TNHH HOÀNG TÍN', 29, 63, 'QL5, An Đồng 1, An Dương', '0313 513 835', '0313 783 654'),
(9, 'CTY CP TAM ĐA', 50, 658, '87 Bà Triệu, Cẩm Đông', '0333 711 978', '0333 723 468'),
(10, 'CTY CP AN ĐẠT', 25, 4, 'Số 7, Ngõ 51/2, Phố Lãng Yên', '043 9715 851', '043 6741 010'),
(11, 'CTY TNHH QUẢNG CÁO VÀ TM PHÚC LỘC', 60, 163, '236 Trần Hưng Đạo, Tiến An', '0241 3898 897', '0241 3898 899'),
(13, 'CTY TNHH TM THANH MƠ', 25, 5, '263 Trường Chinh, P. Khương Mai', '043 8532 454', '043 5638 229'),
(14, 'DNTN TM ĐÔNG NAM', 28, 340, 'Tiền Trung,. Ái Quốc', '03203 753 266', '03203 753 322'),
(15, 'CTY TNHH MTV THANH DUNG', 33, 318, '44A Lê Hồng Phong', '058.3877878', '058.3877373'),
(16, 'DNTN HOÀNG THỨC', 10, 92, '02 Vũ Bảo', '056.3521337', '056.3521309'),
(17, 'CỬA HÀNG CHÂN THANH', 37, 399, '47 Hai Bà Trưng', '063.3843104', ''),
(18, 'CTY TNHH XD- TM & DV TRƯỜNG HUY PHÁT', 22, 247, '55 Đinh Tiên Hoàng', '059.3719277', '059.3720.137'),
(19, 'CTY TNHH TM&DV  MINH NGHI', 15, 99, '153 A, đường 30/4, P. Hưng Lợi', '07106.250.194', '07106.250.195'),
(20, 'CTY TNHH TM&DV  AN KHÁNH', 58, 131, '74A4 Cao Thắng, P. Bình Khánh', '0763.989.992', '0763.989.991'),
(21, 'CTY TNHH MTV  VĨNH THỐNG', 63, 649, 'Số 2S đường Hùng Vương, P.1', '0703.877.536', '0703.877.536'),
(22, 'CTY CPVLXD BẾN TRE', 13, 227, 'Số 207D Nguyễn Đình Chiểu, Xã Phú Hưng', '075.822.315', '075.822319'),
(23, 'CTY TNHH DV&TM MỸ THÀNH', 61, 615, 'Số 110/61A Phạm Ngũ Lão, Khóm 3, P.1', '074. 3850.877', '074. 3850.897'),
(24, 'CTY TNHH MTV TM-DV ĐIỆN- ĐIỆN LẠNH THÀNH LỘC', 15, 97, 'Soá 12/11 Lê Hồng Phong, Phường Bình Thủy', '0710.625.1223', ''),
(25, 'CTY TNHH THẢO HIẾU', 66, 54, '86 Lê Phụng Hiểu', '05113 911452', '05113 911452'),
(26, 'CÔNG TY TNHH SẢN XUẤT VÀ THƯƠNG MẠI PHÚC HƯNG', 2, 673, '137 Huỳnh Thúc Kháng', '0543 512137', '0543 531 375'),
(27, 'CÔNG TY TNHH YÊN LOAN', 51, 638, '95A QL9', '0533 555999', '0533 564388'),
(28, 'CÔNG TY TNHH THÁI HOÀ', 47, 532, '04 Lê Quý Đôn', '0523 828114', '0523 850774'),
(29, 'CÔNG TY TNHH QUẾ HÀ', 42, 420, '188 Phan Đình Phùng', '0383 843881', '038 6253499'),
(30, 'HUYNH ĐỆ', 40, 473, '136/6 Huỳnh Hữu Thống, P.3', '(072) 3500567', '(072) 3825 211'),
(31, 'NGUYỄN ĐÌNH', 9, 268, '28/3A, Tổ 7, KP Bình Giao,  P. Thuận giao', '(0650) 3717 606', '(08) 542 26 242'),
(43, 'CÔNG TY CP TAM ĐA', 25, 5, '311 Nguyễn Xiển, Thanh Xuân, Hà Nội', '0433119568', '0435590383'),
(33, 'MAI TIẾN PHÁT', 8, 31, '31 Đường 14, P. An Bình', '(08)2221 2619 ', '(08)62607186'),
(34, 'PHƯỢNG HOÀNG', 8, 43, '240 XVNT, P.21', '(08) 35 142 909', '(08) 38 035 671'),
(35, 'SÁU HẠNH', 8, 53, '346 Phạm Hữu Lầu, Ấp 4, P. Phước Kiển', '(08) 3781 7836', '08) 3781 7920'),
(36, 'VÕ HẢI DƯƠNG', 8, 42, 'Số 13 Đường 7, P. An Lạc A', '(08) 3751 7977', '(08) 3701 8034'),
(37, 'KHÁNH TRƯỜNG', 20, 338, '35/4 ấp Quảng Đà, Xã Đông Hòa', '(061)3.768 002', ''),
(38, 'HÀ NAM', 8, 36, '195A Nguyễn Thị Thập, P. Tân Phú', '08)3.7751228  ', '(08)05 433 1844'),
(39, 'LÝ GIA PHÁT ', 9, 268, '8/2 Bình Phú, Bình Chuẩn', '0650) 3827 050 ', '(0650) 3798 235'),
(40, 'DUYÊN', 8, 43, '281 Xô Viết Nghệ Tĩnh, P.15 ', '08.3899.3293', '08.350 112.884'),
(41, 'TÂN TÙNG NAM', 8, 48, '142 Hiệp Bình, P. Hiệp Bình Chánh', '08-35542030', '08-35542024'),
(42, 'SIÊU CƯỜNG', 3, 155, '27 Lê Quý Đôn, P.Phước Trung', '64.3826388', '64.3717838'),
(44, 'HOÀNG TÍN', 25, 14, 'Phòng 702, toà nhà CT3A Mễ Trì Thượng, Từ Liêm, Hà Nội', '0437852757', '0437852558'),
(45, 'Công ty TNHH XD SX TM DV LAN THANH', 8, 42, '665A Kinh Dương Vương, P. An Lạc', '08.3752 6262', '08.3752 0329');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

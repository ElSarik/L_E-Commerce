-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2019 at 11:27 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appliances`
--

CREATE TABLE `appliances` (
  `id` int(4) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `power` int(10) NOT NULL,
  `description` text NOT NULL,
  `image` blob NOT NULL,
  `price` double NOT NULL,
  `quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(4) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `size` int(4) NOT NULL,
  `description` text NOT NULL,
  `image` blob NOT NULL,
  `price` double NOT NULL,
  `quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(4) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `username`, `password`, `name`, `surname`, `telephone`, `email`, `address`, `flag`) VALUES
(9, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Mr', 'Admin', '123412', 'admin@gmail.com', 'ADMIN STREET', 1),
(10, 'test', '202cb962ac59075b964b07152d234b70', '', '', '', 'test@gmail.com', '', 0),
(11, 'test1', '202cb962ac59075b964b07152d234b70', '', '', '', 'test1@gmail.com', '', 0),
(12, 'bla', '202cb962ac59075b964b07152d234b70', 'blaa', 'bla', '', 'bla@gmail.com', '', 0),
(13, 'newuser', '202cb962ac59075b964b07152d234b70', 'new', 'user', '123456', 'newuser@gmail.com', 'new user 123456', 0),
(14, 'TESTUSER', '202cb962ac59075b964b07152d234b70', 'AAA', 'BBABABA', '123', 'test@gmail.com', 'asddasvcas 231 asc', 0),
(15, 'AAAAAAAAAAAAAAAAAAAAA', '202cb962ac59075b964b07152d234b70', '', '', '', 'a@gmail.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `computers`
--

CREATE TABLE `computers` (
  `id` int(5) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cpu` varchar(100) NOT NULL,
  `ram` varchar(100) NOT NULL,
  `storage` varchar(100) NOT NULL,
  `gpu` varchar(100) NOT NULL,
  `screen` varchar(100) NOT NULL,
  `os` varchar(100) NOT NULL,
  `price` text NOT NULL,
  `description` text NOT NULL,
  `image` longblob NOT NULL,
  `quantity` int(4) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `computers`
--

INSERT INTO `computers` (`id`, `category`, `manufacturer`, `title`, `cpu`, `ram`, `storage`, `gpu`, `screen`, `os`, `price`, `description`, `image`, `quantity`, `url`) VALUES
(10000, 'Desktops', 'Innovator', 'INNOVATOR 7 ADVANCED GAMER 8700 - NO OS', 'Core i7', '8', 'Both', 'Nvidia', 'Without', 'No OS', '900', '<b>PROCESSOR</b>: CPU INTEL CORE I7-8700 3.20GHZ LGA1151 - BOX <br>\r\n<b>HDD</b>: HDD TOSHIBA DT01ACA100 1TB 3.5\'\' SATA3<br>\r\n<b>SSD</b>: SSD PNY CS900 120GB 2.5\'\' SATA 3<br>\r\n<b>RAM</b>: RAM PATRIOT PSD48G240081H SIGNATURE LINE 8GB DDR4 2400MHZ UDIMM<br>\r\n<b>GPU</b>: VGA ASUS TURBO GEFORCE RTX2060 TURBO-RTX2060-6G 6GB GDDR6 PCI-E RETAIL<br>\r\n<b>MOTHERBOARD</b>: MSI B360-F PRO RETAIL<br>\r\n<b>SOUND CARD</b>: Realtek 7.1<br>\r\n<b>NETWORK CARD</b>: Gigabit LAN controller Marvell 88E8056 PCIe Gigabit LAN controller Intel I219V<br>\r\n<b>CASE</b>: CASE INNOVATOR T10 BLACK GAMING LED RGB LIGHTS<br>\r\n<b>POWER SUPPLY</b>: PSU INNOVATOR IN03XD 650W<br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f5045522e3931323834372e6a7067, 17, 'http://www.teiep.gr/'),
(10006, 'Desktops', 'Innovator', 'INNOVATOR 3 OFFICE VALUE 7100 - WINDOWS 10', 'Core i3', '4', 'HDD', 'On Board', 'Without', 'Windows 10', '499', '<b>PROCESSOR</b>: CPU INTEL CORE I3-7100 3.90GHZ LGA1151 - BOX <br>\r\n<b>HDD</b>: HDD TOSHIBA DT01ACA100 1TB 3.5\'\' SATA3<br>\r\n<b>RAM</b>: RAM PATRIOT PSD44G240082H SL 4GB DDR4 2400MHZ CL17 UDIMM HS<br>\r\n<b>GPU</b>:On Board Intel HD Graphics 630<br>\r\n<b>MOTHERBOARD</b>: ASUS H110M-R BULK<br>\r\n<b>SOUND CARD</b>: 7.1<br>\r\n<b>NETWORK CARD</b>: Gigabit LAN (10/100/1000 Mbit)<br>\r\n<b>CASE</b>: CASE INNOVATOR BEYOND U3 BLACK<br>\r\n<b>OPTICAL DRIVE</b>: LG GH24NSD1 INTERNAL SUPER MULTI DVD RECORDER BULK<br>\r\n<b>POWER SUPPLY</b>: PSU INNOVATOR IN07XD 650W BULK<br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f5045522e3931303032302e6a7067, 0, 'https://www.google.com/'),
(10020, 'Desktops', 'Dell', 'Dell Optiplex 3060 MT (i5-8500/8GB/256GB/W10)', 'Core i5', '8', 'SSD', 'On Board', 'Without', 'Windows 10', '480', '<b>PROCESSOR</b>: CPU INTEL CORE i5 8500 3GHz Coffee Lake(8th Gen) <br>\r\n<b>SSD</b>: 256 GB<br>\r\n<b>RAM</b>: 8GB DDR4<br>\r\n<b>GPU</b>: Intel UHD Graphics 630<br>', 0x496d616765732f50726f64756374732f6c617267655f32303138303732343132353432315f64656c6c5f6f707469706c65785f333036305f6d745f69355f383530305f3867625f32353667625f7731302e6a706567, 20, 'https://www.dell.com/gr/enterprise/p/optiplex-3060-desktop/pd'),
(10021, 'Desktops', 'Lenovo', 'Lenovo V530', 'Core i3', '4', 'HDD', 'On Board', 'Without', 'Windows 10', '460', '<b>PROCESSOR</b>: INTEL CORE I3-8100 3.6GHZ Coffee Lake (8th Gen)<br>\r\n<b>HDD</b>: 1 TB 3.5\" 7200 rpm HDD<br>\r\n<b>RAM</b>: 4 GB DDR4<br>\r\n<b>GPU</b>: Intel UHD Graphics 630<br>\r\n<b>Dimensions(W x D x H)</b>: 147 x 276x 360 mm <br>\r\n<b>Weight</b>: 5.7 kg <br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f6c656e6f766f2d6465736b746f702d763533302d746f7765722d6865726f2e6a7067, 20, 'https://www.lenovo.com/lb/en/desktops/lenovo/lenovo-v-series-tower/Lenovo-V530-15ICB-Desktop/p/11LV1VDV530'),
(10022, 'Desktops', 'MSI', 'MSI Infinite A 8th', 'Core i7', '16', 'SSD', 'Nvidia', 'Without', 'Windows 10', '1700', '<b>PROCESSOR</b>: CPU INTEL CORE I7-8700 3.20GHZ<br>\r\n<b>SSD</b>: Samsung 860 EVO 500 GB<br>\r\n<b>RAM</b>: 2x U-DIMMS 8GB DDR4 2400MHz<br>\r\n<b>GPU</b>: MSI GeForce GTX 1070 Ti 8GB GDDR5<br>\r\n<b>Wireless LAN</b>: Intel Wireless-AC AC3168<br>\r\n<b>BluetoothLAN</b>: 4.2<br>\r\n<b>POWER SUPPLY</b>: 550W 80 Plus Bronze Certified<br>\r\n<b>Dimensions(W x D x H)</b>: 210 x 450 x 488 mm <br>\r\n<b>Weight</b>: 13 kg', 0x496d616765732f50726f64756374732f70726f647563745f395f32303138303430393134343132365f356163623062313632653433612e6a7067, 9, 'https://www.msi.com/Desktop/Infinite-A-8th/Specification'),
(10023, 'aiod', 'Lenovo', 'Lenovo V530z (i3-8100T / 4GB / 128GB / W10)', 'Core i3', '4', 'SSD', 'On Board', 'Full HD', 'Windows 10', '720', '<b>PROCESSOR</b>: Intel Core i3 8100T 3.1GHz <br>\r\n<b>SSD</b>: 128 GB<br>\r\n<b>RAM</b>: 4GB DDR4<br>\r\n<b>GPU</b>: Intel UHD Graphics 630<br>\r\n<b>MONITOR</b>: 21.5\" 1920 x 1080 FULL HD<br>', 0x496d616765732f50726f64756374732f32303139303231313131333934375f6c656e6f766f5f763533307a5f69335f38313030745f3467625f31323867625f7731302e6a7067, 20, ''),
(10024, 'aiod', 'Dell', 'Dell Inspiron 3280 Touch (i5-8265U / 8GB / 1TB / W10)', 'Core i5', '8', 'HDD', 'On Board', 'Full HD', 'Windows 10', '1030', '<b>PROCESSOR</b>: Intel Core i5 8265U 1.6 GHz <br>\r\n<b>HDD</b>: HDD TOSHIBA DT01ACA100 1TB 3.5\'\' SATA3<br>\r\n<b>RAM</b>: 8 GB DDR4<br>\r\n<b>GPU</b>: Intel UHD Graphics 620<br>\r\n<b>MONITOR</b>: IPS Panel 21.5\" 1920 x 1080 Full HD, Touchscreen<br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f6c617267655f32303139303330373132303532325f64656c6c5f696e737069726f6e5f333238305f746f7563685f69355f38323635755f3867625f3174625f7731302e6a706567, 11, ''),
(10025, 'Laptops', 'HP', 'HP 255 G7 (Ryzen 3-2200U/8GB/256GB/Vega Graphics/Full HD)', 'Ryzen 3', '8', 'SSD', 'AMD', 'Full HD', 'No OS', '420', '<b>PROCESSOR</b>: AMD Ryzen 3 2200U 2.5GHz Zen<br>\r\n<b>SSD</b>: 255GB SSD<br>\r\n<b>RAM</b>: 8GB DDR4<br>\r\n<b>GPU</b>: AMD Radeon Vega Graphics<br>\r\n<b>SCREEN</b>: 15,6\" 1920 x 1080 Full HD<br>', 0x496d616765732f50726f64756374732f6c617267655f32303139303431363136333430305f68705f3235355f67375f72797a656e5f335f32323030755f3867625f32353667625f726164656f6e5f766567615f67726170686963735f66756c6c5f68645f6e6f5f6f732e6a706567, 5, ''),
(10026, 'Laptops', 'Xiaomi', 'Xiaomi Mi Air 13.3', 'Core i5', '8', 'SSD', 'Nvidia', 'Full HD', 'Windows 10', '840', '<b>PROCESSOR</b>: Intel Core i5 8250U 1.6 GHz Kaby Lake R(8th Gen) <br>\r\n<b>SSD</b>: 256GB SSD<br>\r\n<b>RAM</b>: 8GB DDR4<br>\r\n<b>GPU</b>: Nvidia GeForce MX150 2GB<br>\r\n<b>SCREEN</b>: 13.3\" 1920 x 1080 Full HD<br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f6c617267655f32303138303830373133333933335f7869616f6d695f6d695f6169725f31335f335f69355f38323530755f3867625f32353667625f6765666f7263655f6d783135305f6668645f7731302e6a706567, 7, ''),
(10027, 'Tablets', 'Samsung', 'Samsung Galaxy Tab A T580 10.1', 'Octa-Core', '2', '32 GB', '8 MP', '10,1', 'Android', '150', '<b>PROCESSOR</b>: Octa-Core (4+4) 1.4GHz <br>\r\n<b>STORAGE</b>: 32GB<br>\r\n<b>RAM</b>: 2GB<br>\r\n<b>CAMERA</b>: 8MP<br>\r\n<b>SCREEN</b>: 10.0\" 1920 x 1200 pixels Multi Touch<br>', 0x496d616765732f50726f64756374732f6c617267655f32303138303231333134353531375f73616d73756e675f67616c6178795f7461625f615f323031365f333267625f31305f315f77695f66692e6a706567, 8, ''),
(10028, 'Tablets', 'Huawei', 'Huawei MediaPad M5 WiFi 10.8', 'Octa-Core', '4', '32 GB', '13 MP', '10,8', 'Android', '360', '<b>PROCESSOR</b>: Octa-Core (4+4) 2.4 GHz <br>\r\n<b>CAMERA</b>: 13 MP<br>\r\n<b>RAM</b>: 4 GB<br>\r\n<b>SCREEN</b>: 10,8\" 2560 x 1600 pixels Multi Touch<br>\r\n<b>WARANTY</b>: 3 YEARS<br>', 0x496d616765732f50726f64756374732f6c617267655f32303138303431393135353434375f6875617765695f6d656469617061645f6d355f31305f382e6a706567, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(4) NOT NULL,
  `order_id` int(4) NOT NULL,
  `main_category` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `item_id` int(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `order_id`, `main_category`, `category`, `item_id`, `quantity`) VALUES
(184, 127, 'computers', 'Desktops', 10000, 2),
(185, 127, 'computers', 'Desktops', 10006, 1),
(186, 127, 'computers', 'Desktops', 10008, 1),
(187, 128, 'computers', 'Desktops', 10000, 4),
(188, 128, 'computers', 'Desktops', 10006, 3),
(189, 129, 'computers', 'Desktops', 10000, 1),
(190, 129, 'computers', 'Desktops', 10006, 1),
(191, 130, 'computers', 'Desktops', 10000, 1),
(192, 130, 'computers', 'Desktops', 10006, 1),
(193, 131, 'computers', 'Desktops', 10000, 1),
(194, 132, 'computers', 'Desktops', 10000, 1),
(195, 132, 'computers', 'aiod', 10001, 3),
(197, 133, 'computers', 'Laptops', 10016, 1),
(198, 133, 'computers', 'Laptops', 10002, 1),
(199, 134, 'computers', 'Desktops', 10006, 24),
(200, 134, 'computers', 'aiod', 10014, 25),
(201, 134, 'computers', 'Laptops', 10016, 1),
(202, 134, 'computers', 'Tablets', 10003, 1),
(203, 134, 'computers', 'AM', 10018, 1),
(204, 134, 'computers', 'Servers', 10005, 2),
(219, 135, 'computers', 'Desktops', 10000, 3),
(220, 135, 'smartphones', 'Smartphone', 1, 4),
(224, 140, 'computers', 'Laptops', 10026, 1),
(225, 140, 'computers', 'Desktops', 10022, 1),
(276, 141, 'smartphones', 'Case', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `client_id` int(4) NOT NULL,
  `status` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `status`, `address`, `name`, `surname`, `cost`) VALUES
(127, 9, 'Sent', 'ADMIN STREET', 'Mr', 'Admin', 10299),
(128, 9, 'Completed', 'ADMIN STREET', 'Mr', 'Admin', 5097),
(129, 11, 'Sent', 'sdada', 'bl', 'ASD', 1399),
(130, 11, 'Completed', 'sadca', 'dasd', 'casc', 1399),
(131, 11, 'Sent', 'csaca', 'X', 'CAS', 900),
(132, 9, 'Sent', 'ADMIN STREET', 'Mr', 'Admin', 1005),
(133, 9, 'Completed', 'ADMIN STREET', 'Mr', 'Admin', 483),
(134, 9, 'Completed', 'ADMIN STREET', 'Mr', 'Admin', 23215),
(135, 9, 'Received', 'ADMIN STREET', 'Mr', 'Admin', 5100),
(136, 9, 'Open', 'ADMIN STREET', 'Mr', 'Admin', 0),
(140, 10, 'Received', 'Home 23', 'Mr', 'X', 2540),
(141, 14, 'Received', 'asddasvcas 231 asc', 'AAA', 'BBABABA', 119.97),
(142, 14, 'Open', 'asddasvcas 231 asc', 'AAA', 'BBABABA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `smartphones`
--

CREATE TABLE `smartphones` (
  `id` int(3) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cpu` varchar(100) NOT NULL,
  `ram` varchar(100) NOT NULL,
  `storage` varchar(100) NOT NULL,
  `screen` varchar(100) NOT NULL,
  `os` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `image` longblob NOT NULL,
  `quantity` int(4) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smartphones`
--

INSERT INTO `smartphones` (`id`, `category`, `manufacturer`, `title`, `cpu`, `ram`, `storage`, `screen`, `os`, `price`, `description`, `image`, `quantity`, `url`) VALUES
(1, 'Smartphone', 'Samsung', 'Samsung Galaxy S10+ (512GB)', 'Octacore', '8', '512', '6.4', 'Android', 1125, '<b>PROCESSOR</b>: Exynos Octa 9820 2,7 GHz (2+2+4 cores)<br>\r\n<b>STORAGE</b>: 512GB<br>\r\n<b>RAM</b>: 8GB<br>\r\n<b>FRONT CAMERA</b>: 10MP (Double)<br>\r\n<b>REAR CAMERA</b>: 12MP + 12MP +16MP (Triple)<br>\r\n<b>BATTERY</b>: 4100 mAh <br>\r\n<b>SCREEN</b>: 6.4\" 3040 x 1440 pixels Dynamic AMOLED Infinity-O<br>', 0x496d616765732f50726f64756374732f73616d73756e67325f2e706e67, 4, ''),
(5, 'Smartphone', 'Apple', 'Apple iPhone XS Max (512GB)', 'Apple', '4', '512', '6.5', 'iOS', 1450, '<b>PROCESSOR</b>: Apple A12 (4+2 cores)<br>\r\n<b>STORAGE</b>: 512GB<br>\r\n<b>RAM</b>: 4GB<br>\r\n<b>FRONT CAMERA</b>: 7MP<br>\r\n<b>REAR CAMERA</b>: 12MP + 12MP (Double)<br>\r\n<b>BATTERY</b>: 3174 mAh <br>\r\n<b>SCREEN</b>: 6.5\" 1424 x 2688 pixels     Super AMOLED capacitive touchscreen, 16M colors<br>', 0x496d616765732f50726f64756374732f6c617267655f32303138303931393131333430325f6170706c655f6970686f6e655f78735f6d61785f35313267622e6a7067, 6, ''),
(6, 'Case', 'Poetic', 'Journeyman - Apple iPhone XS Max (6.5-inch) Case', '', '', '', '', '', 16.95, '<b>360 DEGREE PROTECTION </b> - Protects your Apple iPhone XS Max from all angles. Includes: Built-in Screen Protector, Clear polycarbonate back, and TPU lining and Bumpers.\r\n<br>\r\n<br>\r\n<b>BUILT-IN-SCREEN PROTECTOR</b> - Front polycarbonate casing with a built-in screen protector adds a layer of protection without affecting screen responsiveness.\r\n<br>\r\n<br>\r\n<b>SCRATCH RESISTANT CLEAR BACK</b> - The scratch-resistant coating helps the clear back panel stay clean and clear to showcase your device in full clarity.\r\n<br>\r\n<br>\r\n<b>HEAVY DUTY MATERIAL</b> - Composed of premium polycarbonate and shock absorbing TPU bumper for drop protection.\r\n<br>\r\n<br>\r\n<b>COMPATIBILITY</b> - Compatible with Apple iPhone XS Max ONLY.', 0x496d616765732f50726f64756374732f477261792d315f383030782e6a7067, 10, ''),
(7, 'Case', 'Spigen', 'Galaxy S10 Plus Case Tough Armor', '', '', '', '', '', 39.99, 'The Tough ArmorÂ® for the Galaxy S10 Plus is the definition of rugged protection in a slim body. Its dual-layer structure is designed to be pocket-friendly, with Air Cushion TechnologyÂ® packed into every corner for extreme defense. And for added convenience, a built-in kickstand is easily accessible for hands-free viewing. Whether you go mountain climbing or out for a night on the town, the Tough ArmorÂ® has protection for every situation. <br><br>\r\n\r\n<b>COMPATIBILITY</b>: Galaxy S10 Plus<br>\r\n<br>\r\n<b>MATERIAL</b>: TPU + PC<br>\r\n<br>\r\n<b>FEATURES</b>:<br>\r\n 	<br>\r\n    <li>Extreme drop protection with two layers of impact resistance </li>\r\n    <li>Form-fitted and ergonomic for daily grip and pocket-friendliness</li>\r\n    <li>Effortless viewing anywhere with a built-in stand</li>\r\n    <li>Mil-grade certified with Air Cushion TechnologyÂ®</li>\r\n    <li>Compatible with wireless charging and Spigen screen protectors</li>', 0x496d616765732f50726f64756374732f7469746c655f7331305f706c75735f74615f67756e6d6574616c5f30315f3230343878323034382e6a7067, 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `sound`
--

CREATE TABLE `sound` (
  `id` int(4) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `power` int(4) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `image` longblob NOT NULL,
  `quantity` int(4) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sound`
--

INSERT INTO `sound` (`id`, `category`, `manufacturer`, `title`, `power`, `type`, `price`, `description`, `image`, `quantity`, `url`) VALUES
(1, 'Speakers', 'Yamaha', 'Yamaha DSR115', 130, 'Auto-Amplified', 900, '<b>FEATURES</b>: Auto-Amplified, 1300W RMS, 15\" Bass, <br>\r\n<b>DIMENSIONS </b>: H 75.5 cm, L 44.2 cm, W 42.3 cm, 28 kg', 0x496d616765732f50726f64756374732f6c617267655f32303138303432343130303931385f79616d6168615f6473723131352e6a7067, 2, ''),
(2, 'Amplifier', 'Yamaha', 'Yamaha R-S202D Black', 140, 'Complete', 240, '<b>TECHNICAL FEATURES</b>: Complete, Solid, Stereo, 140 watt / channel (8Î©), 115 watt / channel (4Î©), 100 dB SNR<br>\r\n<b>DIMENSIONS</b>: L 43.5cm, H 14.1cm, W 32.2cm', 0x496d616765732f50726f64756374732f6c617267655f32303136303931393136303531305f79616d6168615f725f73323032642e6a7067, 14, ''),
(4, 'Speakers', 'JBL', 'JBL EON615', 500, 'Auto-Amplified', 400, '<b>FEATURES</b>: Auto-Amplified, 500 W RMS, 15\" Bass<br>\r\n<b>DIMENSIONS</b>: H 70.7cm, L 43.9cm, W 36.5cm, 17.69 kg', 0x496d616765732f50726f64756374732f6c617267655f6a626c2d656f6e2d3631352e6a7067, 4, ''),
(5, 'Amplifier', 'Rotel', 'Rotel RC-1572 Black', 0, 'Pre-Amplifier', 949, '<b>TECHNICAL FEATURES</b>:Pre-Amplifier, Solid, Stereo, 110 dB SNR<br>\r\n<b>DIMENSIONS</b>:L 43.1cm, H 9.9cm, W 33.9cm', 0x496d616765732f50726f64756374732f6c617267655f32303139303431313135343230355f726f74656c5f72635f313537322e6a7067, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `vision`
--

CREATE TABLE `vision` (
  `id` int(3) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `resolution` varchar(100) NOT NULL,
  `screen` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `image` blob NOT NULL,
  `quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appliances`
--
ALTER TABLE `appliances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `smartphones`
--
ALTER TABLE `smartphones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sound`
--
ALTER TABLE `sound`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vision`
--
ALTER TABLE `vision`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appliances`
--
ALTER TABLE `appliances`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10029;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `smartphones`
--
ALTER TABLE `smartphones`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sound`
--
ALTER TABLE `sound`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vision`
--
ALTER TABLE `vision`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

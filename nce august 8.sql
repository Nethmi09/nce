-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 12:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nce`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_numbers`
--

CREATE TABLE `batch_numbers` (
  `BatchNumberId` int(11) NOT NULL,
  `BatchNumber` varchar(255) NOT NULL,
  `DescriptionBN` text NOT NULL,
  `StatusBN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_numbers`
--

INSERT INTO `batch_numbers` (`BatchNumberId`, `BatchNumber`, `DescriptionBN`, `StatusBN`) VALUES
(1, 'BN0001', 'Test', 1),
(3, '22222BN', 'rfrfrfr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `BrandId` int(11) NOT NULL,
  `BrandImage` varchar(255) DEFAULT NULL,
  `BrandName` varchar(100) NOT NULL,
  `BDescription` text NOT NULL,
  `MainCategoryId` int(11) NOT NULL,
  `BStatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`BrandId`, `BrandImage`, `BrandName`, `BDescription`, `MainCategoryId`, `BStatus`) VALUES
(1, 'apple.png', 'Apple', 'Test test', 2, 1),
(2, 'samsung.png', 'Samsung', 'Test 2', 2, 1),
(6, 'redmi.png', 'Redmi', 'Test 3', 2, 1),
(7, 'hp.png', 'HP', 'Test 4', 1, 1),
(8, 'lenovo.png', 'Lenovo', 'Test 5', 1, 1),
(9, 'yesido.png', 'Yesido', 'Test  6', 2, 1),
(10, 'google.png', 'Google', 'Test 8', 2, 1),
(11, 'kaku.png', 'Kaku', 'Test 10', 1, 1),
(17, '', 'bere', 'brererer', 1, 0),
(25, 'pexels-nerdcinema-19265336.jpg', 'testqqq', 'qqqq', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryId` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `CDescription` text NOT NULL,
  `MainCategoryId` int(11) NOT NULL,
  `Statuss` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryId`, `CategoryName`, `CDescription`, `MainCategoryId`, `Statuss`) VALUES
(1, 'Keyboards', 'Test 01', 1, 0),
(2, 'Mobile back covers', 'Test 02', 2, 1),
(5, 'Mobile Cables', 'Testtt', 2, 0),
(6, 'Computer Chargers', 'Test 6', 1, 1),
(7, 'Phone Holders', 'Test 7', 2, 1),
(8, 'Adapters', 'Test 8', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `civil_status`
--

CREATE TABLE `civil_status` (
  `CivilStatusId` int(11) NOT NULL,
  `CivilStatusName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `civil_status`
--

INSERT INTO `civil_status` (`CivilStatusId`, `CivilStatusName`) VALUES
(1, 'Single'),
(2, 'Married');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `ColorId` int(11) NOT NULL,
  `ColorName` varchar(255) NOT NULL,
  `ColorCode` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`ColorId`, `ColorName`, `ColorCode`, `Status`) VALUES
(1, 'Red', '#ec1313', 0),
(3, 'Black', '#151414', 1),
(4, 'White', '#ffffff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus_messages`
--

CREATE TABLE `contactus_messages` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `SubmittedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus_messages`
--

INSERT INTO `contactus_messages` (`Id`, `Name`, `Email`, `Message`, `SubmittedAt`) VALUES
(2, 'Nethmi Udara', 'test@gmail.com', 'test m', '0000-00-00 00:00:00'),
(3, 'Test User', 'testuser@gmail.com', 'teststststst', '2024-07-10 06:18:27'),
(4, 'Test User', 'test@gmail.com', 'tttttttttttt', '2024-07-17 12:58:01'),
(5, 'xde', 'Test@gmail.com', 'efrferf', '2024-08-03 17:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `CouponId` int(11) NOT NULL,
  `CouponNumber` varchar(255) NOT NULL,
  `Discount` varchar(255) NOT NULL,
  `AddedDate` date NOT NULL,
  `ExpireDate` date NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`CouponId`, `CouponNumber`, `Discount`, `AddedDate`, `ExpireDate`, `Status`) VALUES
(1, 'CP0001', '10', '2024-08-04', '2024-08-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courier_service`
--

CREATE TABLE `courier_service` (
  `CourierServiceId` int(11) NOT NULL,
  `CouCompanyName` varchar(255) NOT NULL,
  `ContPersonName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ContactMobile` varchar(15) NOT NULL,
  `AlternateMobile` varchar(15) NOT NULL,
  `AddressLine1` varchar(255) NOT NULL,
  `AddressLine2` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `AccountName` varchar(255) NOT NULL,
  `AccountNumber` varchar(255) NOT NULL,
  `BankName` varchar(255) NOT NULL,
  `Branch` varchar(255) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courier_service`
--

INSERT INTO `courier_service` (`CourierServiceId`, `CouCompanyName`, `ContPersonName`, `Email`, `ContactMobile`, `AlternateMobile`, `AddressLine1`, `AddressLine2`, `City`, `DistrictId`, `AccountName`, `AccountNumber`, `BankName`, `Branch`, `Status`) VALUES
(1, 'Koobiyo', 'Amal Perera', 'amal@gmail.com', '0789654123', '', 'Test 1', 'Test 2', 'Bern', 17, '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerId` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `AddressLine1` varchar(255) NOT NULL,
  `AddressLine2` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `ContactMobile` varchar(15) NOT NULL,
  `AlternateMobile` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `RegNo` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerId`, `FirstName`, `LastName`, `AddressLine1`, `AddressLine2`, `City`, `DistrictId`, `ContactMobile`, `AlternateMobile`, `Email`, `RegNo`, `UserId`) VALUES
(1, 'Kamani', 'Alvis', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, '0789654123', '0789654123', 'ksamani@gmail.com', 2024031317, 17),
(2, 'Nilan', 'Sudesh', 'No 234/A', 'Hakmana road', 'Matara', 17, '0789654123', '0789654123', 'niilan@gmail.com', 2024031318, 18),
(3, 'Nisal', 'Alvis', 'No:224/A', 'Pipeline road', 'Koswaththa', 5, '0789654123', '0789654153', 'niisal@gmail.com', 2024031819, 19),
(4, 'Nethminiiiii', 'Pereraaaaq', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, '0789645124', '0789654234', 'neethmini@gmail.com', 2024031920, 20),
(5, 'Hasini', 'Perera', 'No: 225/A, Temple road', 'Colombo 12', 'Testc', 5, '0789654123', '0112567374', 'nethmiudara109@gmail.com', 2024061125, 25),
(6, 'Sheran', 'Perera', 'Katunayaka road', 'testakkkkk', 'Negombo', 5, '0789654123', '0112874569', 'rdnethmiudara@gmail.com', 2024061126, 26),
(7, 'Kasun', 'Nimantha', 'testaddr1', 'testaddr2', 'testcty', 17, '0789654123', '0785412365', 'bittonce@gmail.com', 2024061127, 27),
(8, 'Dinesh', 'Tharusha', 'No:22/A , Castle road', 'Borella', 'Test City', 11, '0789654123', '0789654123', 'testdinesh@gmail.com', 2024071328, 28),
(9, 'Imeshi', 'Perera', 'No:224/A', 'Flower road', 'Aluthgama', 11, '0786541236', '0112567342', 'imeshi@gmail.com', 2024073135, 35),
(10, 'Megani', 'Weerasekara', 'No.32/A', 'Rathnapura road', 'Balangoda', 23, '0789654123', '0789654789', 'bitncee@gmail.com', 2024080136, 36),
(11, 'gtrgtrg', 'rtgtrgrt', 'trgtrgrtg', 'gtrgrtg', 'gtrgrtg', 3, '1789654123', '0745698745', 'bbbitnce@gmail.com', 2024080137, 37),
(12, 'Test', 'User', 'frfrfrf', 'frfrfr', 'frfrf', 6, '0789654123', '0789654123', 'bitnce@gmail.com', 2024080238, 38);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `Id` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `PaymentMethod` varchar(255) NOT NULL,
  `PaymentAmount` decimal(18,2) NOT NULL,
  `UploadedSlip` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`Id`, `CustomerId`, `OrderId`, `PaymentMethod`, `PaymentAmount`, `UploadedSlip`, `Date`, `Status`) VALUES
(1, 4, 49, '2', 0.00, '66af3d335c2bf9.19536701Nethminiiiii Pereraaaa.jpg', '2024-08-03 18:30:00', 1),
(2, 4, 50, '2', 0.00, '66af3d6f580b16.91074767Nethminiiiii Pereraaaa.jpg', '2024-08-04 18:30:00', 1),
(3, 4, 51, '2', 0.00, '66af7c93ded3f2.45898622Nethminiiiii Pereraaaa.jpg', '2024-08-03 18:30:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `DesignationId` int(11) NOT NULL,
  `DesignationName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`DesignationId`, `DesignationName`) VALUES
(1, 'Manager'),
(2, 'Admin'),
(3, 'Stock Keeper'),
(4, 'Delivery Manager'),
(5, 'Cleaner');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `DeliveryCost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`Id`, `Name`, `DeliveryCost`) VALUES
(1, 'Ampara', 600.00),
(2, 'Anuradhapura', 500.00),
(3, 'Batticaloa', 0.00),
(4, 'Badulla', 0.00),
(5, 'Colombo', 200.00),
(6, 'Galle', 0.00),
(7, 'Gampaha', 0.00),
(8, 'Hambantota', 400.00),
(9, 'Jaffna', 0.00),
(10, 'Kalutara', 0.00),
(11, 'Kandy', 400.00),
(12, 'Kegalle', 0.00),
(13, 'Kilinochchi', 0.00),
(14, 'Kurunegala', 0.00),
(15, 'Matale', 0.00),
(16, 'Mannar', 0.00),
(17, 'Matara', 0.00),
(18, 'Monaragala', 0.00),
(19, 'Mullaitivu', 0.00),
(20, 'Nuwara Eliya', 0.00),
(21, 'Polonnaruwa', 0.00),
(22, 'Puttalam', 0.00),
(23, 'Ratnapura', 0.00),
(24, 'Trincomalee', 0.00),
(25, 'Vavuniya', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeId` int(11) NOT NULL,
  `RegistrationNumber` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `NICNumber` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ContactMobile` varchar(15) NOT NULL,
  `AlternateMobile` varchar(15) NOT NULL,
  `AddressLine1` varchar(255) NOT NULL,
  `AddressLine2` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `HireDate` date NOT NULL,
  `ResignDate` date DEFAULT NULL,
  `DesignationId` int(11) NOT NULL,
  `CivilStatusId` int(11) NOT NULL,
  `EmployeeStatusId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AccountName` varchar(255) NOT NULL,
  `AccountNumber` varchar(255) NOT NULL,
  `BankName` varchar(255) NOT NULL,
  `Branch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeId`, `RegistrationNumber`, `FirstName`, `LastName`, `NICNumber`, `Email`, `ContactMobile`, `AlternateMobile`, `AddressLine1`, `AddressLine2`, `City`, `DistrictId`, `Image`, `DOB`, `Gender`, `HireDate`, `ResignDate`, `DesignationId`, `CivilStatusId`, `EmployeeStatusId`, `UserId`, `AccountName`, `AccountNumber`, `BankName`, `Branch`) VALUES
(1, 'EMP:0001', 'Nethmi', 'Udara', '987831278v', 'nethmiudara@gmail.com', '0716879121', '0112567342', 'No:225/A', 'Temple road', 'Maradana', 5, '', NULL, NULL, '2024-02-06', NULL, 1, 2, 1, 1, '', '', '', ''),
(2, 'EMP:0002', 'Hashi', 'Perera', '965874523v', 'hashi@gmail.com', '0759845632', '0785632142', 'No:62/B', 'Flower road', 'Kirulapana', 6, '', NULL, NULL, '2024-03-02', NULL, 3, 1, 2, 9, '', '', '', ''),
(3, 'EMP:0003', 'Nimali', 'Alvis', '958745612v', 'nimali@gmail.com', '0789654123', '', '', '', '', 9, '', NULL, NULL, '2023-06-10', NULL, 2, 1, 1, 0, '', '', '', ''),
(4, 'EMP:0004', 'Amal', 'Perera', '958745612v', 'amal@gmail.com', '0789654123', '', 'Test 1', 'Test 2', 'Bern', 18, '', '2024-05-01', 'Male', '2024-05-08', '0000-00-00', 4, 1, 1, 0, '', '', '', ''),
(5, 'EMP:0005', 'Nimali', 'Alvis', '958745612v', 'nimali@gmail.com', '0789654123', '0545454555', 'Neugasse 12, 8810 Horgen, Switzerland', 'Neugasse', 'Horgen', 14, '', '2024-05-01', 'Female', '2024-05-03', '0000-00-00', 2, 1, 1, 0, '', '', '', ''),
(6, 'EMP:0006', 'Kasuni', 'Perera', '958945612v', 'nimali@gmail.com', '0789654123', '0545454555', 'Test Address 1', 'ttttttttt', 'Horgeyhhjjn', 11, '', '2009-02-13', 'Female', '2024-05-03', '0000-00-00', 5, 1, 2, 0, '', '', '', ''),
(7, 'EMP:0007', 'Dilip', 'Tharuka', '948745612v', 'dilip@gmail.com', '0785412365', '', 'Neugasse 12, 8810 Horgen, Switzerland', 'Neugasse', 'Horgen', 16, '', '1994-03-16', 'Male', '2024-01-03', '0000-00-00', 4, 2, 1, 21, '', '', '', ''),
(9, 'EMP:0008', 'Nimali', 'Alvis', '958745612v', 'nimali@gmail.com', '0789654123', '', 'Test 1', 'Test 2', 'Bern', 4, '', '2024-07-02', 'Female', '2024-07-02', '0000-00-00', 3, 1, 1, 0, '', '', '', ''),
(10, 'EMP:0009', 'Amali', 'Perera', '948745612v', 'amal@gmail.com', '0789654123', '', 'Test 1', 'Test 2', 'Bern', 2, 'pexels-njeromin-14760650.jpg', '2024-07-02', 'Female', '2024-07-10', '0000-00-00', 2, 1, 1, 0, '', '', '', ''),
(11, 'EMP:0010', 'Megani', 'Apsara', '958745612v', 'mega@gmail.com', '+94789654123', '587469842', 'Europaplatz', 'Europaplatz8', 'Bern', 4, '', '2000-10-17', 'Female', '2024-01-03', '0000-00-00', 1, 1, 1, 0, '', '', '', ''),
(12, 'EMP:0011', 'Kamal', 'Wijethunga', '888745612v', 'kamalwijethunga@gmail.com', '+94789644123', '0796541236', 'No:31/B , Haputale road', 'Panama', 'Beragala', 4, '', '1988-03-10', 'Male', '2024-07-04', '0000-00-00', 2, 2, 1, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `EmployeeStatusId` int(11) NOT NULL,
  `EmployeeStatusName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`EmployeeStatusId`, `EmployeeStatusName`) VALUES
(1, 'Working'),
(2, 'Resigned');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `MainCategoryId` int(11) NOT NULL,
  `MainCategoryName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`MainCategoryId`, `MainCategoryName`, `Description`, `Status`) VALUES
(1, 'Computer Accessories', '', 1),
(2, 'Mobile Accessories', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Path` varchar(100) NOT NULL,
  `File` varchar(100) NOT NULL,
  `Icon` varchar(100) NOT NULL,
  `Idx` int(11) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`Id`, `Name`, `Path`, `File`, `Icon`, `Idx`, `Status`) VALUES
(1, 'User Management', 'users', 'manage', 'fas fa-users', 1, 1),
(2, 'Customer Management', 'customers', 'manage', 'fas fa-user-friends', 3, 1),
(3, 'Supplier Management', 'suppliers', 'manage', 'fas fa-truck', 6, 1),
(4, 'Order Management', 'orders', 'manage', 'fas fa-shopping-cart', 4, 1),
(5, 'Employee Management', 'employees', 'manage', 'fas fa-user-tie', 2, 1),
(8, 'Product Management', 'products', 'productManage', 'fas fa-cube', 8, 1),
(9, 'Inventory Management', 'inventory', 'manage', 'fas fa-warehouse', 9, 1),
(10, 'Delivery Management', 'delivery', 'manage', 'fas fa-shipping-fast', 10, 1),
(11, 'Messages', 'messages', 'manage', 'fas fa-envelope', 11, 1),
(12, 'Purchase Management', 'purchases', 'manage', 'fas fa-receipt', 7, 1),
(13, 'Sales Management', 'sales', 'manage', 'fas fa-chart-line', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderId` int(11) NOT NULL,
  `OrderNumber` bigint(16) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `PersonalName` varchar(255) DEFAULT NULL,
  `PersonalEmail` varchar(255) DEFAULT NULL,
  `PersonalContactMobile` varchar(255) DEFAULT NULL,
  `PersonalAlternateMobile` varchar(255) DEFAULT NULL,
  `PersonalAddressLine1` varchar(255) DEFAULT NULL,
  `PersonalAddressLine2` varchar(255) DEFAULT NULL,
  `PersonalCity` varchar(255) DEFAULT NULL,
  `PersonalDistrictId` int(11) DEFAULT NULL,
  `ShippingName` varchar(255) DEFAULT NULL,
  `ShippingEmail` varchar(255) DEFAULT NULL,
  `ShippingContactMobile` varchar(255) DEFAULT NULL,
  `ShippingAlternateMobile` varchar(255) DEFAULT NULL,
  `ShippingAddressLine1` varchar(255) DEFAULT NULL,
  `ShippingAddressLine2` varchar(255) DEFAULT NULL,
  `ShippingCity` varchar(255) DEFAULT NULL,
  `ShippingDistrictId` int(11) DEFAULT NULL,
  `GrandTOTAL` decimal(18,2) NOT NULL,
  `Discount` decimal(18,2) NOT NULL,
  `NetTotal` decimal(10,2) NOT NULL,
  `CouponDiscount` decimal(10,2) NOT NULL,
  `NetTtAftCD` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderStatus` int(11) NOT NULL,
  `Profit` decimal(18,2) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `DeliveryCost` decimal(18,2) NOT NULL,
  `PaymentSlip` varchar(255) NOT NULL,
  `AddedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `TotalAmount` decimal(18,2) NOT NULL,
  `PaymentMethod` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderId`, `OrderNumber`, `OrderDate`, `CustomerId`, `PersonalName`, `PersonalEmail`, `PersonalContactMobile`, `PersonalAlternateMobile`, `PersonalAddressLine1`, `PersonalAddressLine2`, `PersonalCity`, `PersonalDistrictId`, `ShippingName`, `ShippingEmail`, `ShippingContactMobile`, `ShippingAlternateMobile`, `ShippingAddressLine1`, `ShippingAddressLine2`, `ShippingCity`, `ShippingDistrictId`, `GrandTOTAL`, `Discount`, `NetTotal`, `CouponDiscount`, `NetTtAftCD`, `Quantity`, `OrderStatus`, `Profit`, `DistrictId`, `DeliveryCost`, `PaymentSlip`, `AddedDate`, `TotalAmount`, `PaymentMethod`) VALUES
(1, 202405234, '2024-05-23', 4, 'Nethmi Udara', 'nethmi@gmail.com', '0786541236', '0789654125', 'test ad 1', 'test ad 2', 'test city', 11, 'Nethmi Udara', 'nethmi@gmail.com', '0786541236', '0789654125', 'test ad 1', 'test ad 2', 'test city', 11, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 0, 0.00, '', '2024-08-01 12:49:40', 0.00, ''),
(2, 202405261, '2024-05-26', 1, 'Kamani Alvis', 'kamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'kamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 0, 0.00, '', '2024-08-01 12:50:34', 0.00, ''),
(3, 202405263, '2024-05-26', 3, 'Nisal Perera', 'nisal@gmail.com', '0789654123', '0713654789', 'Ad line1 test', 'Ad line 2 test', 'citytest', 3, 'Nisal Perera', 'nisal@gmail.com', '0789654123', '0713654789', 'Ad line1 test', 'Ad line 2 test', 'citytest', 11, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 0, 0.00, '', '2024-06-21 05:48:03', 0.00, ''),
(4, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0789654123', 'Adline1', 'Adline2', 'testc', 18, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0789654123', 'Adline1', 'Adline2', 'testc', 18, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 579.00, 18, 0.00, '', '2024-06-21 07:14:14', 0.00, '1'),
(5, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785456322', 'TestAd2', 'TEstAd3', 'TestC', 11, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785456322', 'TestAd2', 'TEstAd3', 'TestC', 11, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 11, 0.00, '', '2024-06-21 07:24:33', 0.00, '1'),
(6, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:27:53', 0.00, '1'),
(7, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:28:26', 0.00, '1'),
(8, 202406215, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:30:23', 0.00, '1'),
(9, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:33:54', 0.00, '1'),
(10, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:38:33', 0.00, '1'),
(11, 202406214, '2024-06-21', 4, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 'Nethmini', 'nethmi@gmail.com', '0789654123', '0785412362', 'Adtst1', 'Adtest2', 'citytst', 16, 0.00, 579.00, 0.00, 0.00, 0.00, 2, 1, 2.00, 16, 0.00, '', '2024-06-21 07:39:14', 0.00, '1'),
(12, 202406214, '2024-06-21', 4, 'Nethmini', 'testnethmi@gmail.com', '0789654123', '0789654123', 'Adline12', 'Adline23', 'Test3c', 15, 'Nethmini', 'testnethmi@gmail.com', '0789654123', '0789654123', 'Adline12', 'Adline23', 'Test3c', 15, 0.00, 399.00, 0.00, 0.00, 0.00, 2, 1, 2000.00, 15, 0.00, '', '2024-06-21 07:43:09', 0.00, '1'),
(13, 202406214, '2024-06-21', 4, 'Nethmini', 'testnethmi@gmail.com', '0789654123', '0789654123', 'Adline11111', 'Adline2222', 'testc', 17, 'Nethmini', 'testnethmi@gmail.com', '0789654123', '0789654123', 'Adline11111', 'Adline2222', 'testc', 17, 7900.00, 237.00, 0.00, 0.00, 0.00, 2, 1, 1200.00, 17, 0.00, '', '2024-06-21 07:48:19', 0.00, '1'),
(14, 202406214, '2024-06-21', 4, 'Nethmini', 'testnetdhmi@gmail.com', '0789654123', '0789654123', 'Adline11111', 'Adline2222', 'testc', 15, 'Nethmini', 'testnetdhmi@gmail.com', '0789654123', '0789654123', 'Adline11111', 'Adline2222', 'testc', 15, 11050.00, 331.50, 0.00, 0.00, 0.00, 2, 1, 3500.00, 15, 0.00, '', '2024-06-21 07:50:58', 0.00, '1'),
(15, 202406294, '2024-06-29', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 15000.00, 450.00, 0.00, 0.00, 0.00, 2, 1, 1300.00, 5, 0.00, '', '2024-06-29 06:35:18', 0.00, '2'),
(16, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 19000.00, 570.00, 0.00, 0.00, 0.00, 2, 1, 1400.00, 5, 0.00, '', '2024-06-29 12:31:07', 0.00, ''),
(17, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 16540.00, 496.20, 0.00, 0.00, 0.00, 2, 1, 5500.00, 0, 0.00, '', '2024-06-29 12:32:57', 0.00, ''),
(18, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 14000.00, 420.00, 0.00, 0.00, 0.00, 2, 1, 700.00, 0, 0.00, '', '2024-06-29 12:34:21', 0.00, ''),
(19, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 19290.00, 578.70, 0.00, 0.00, 0.00, 2, 1, 2500.00, 0, 0.00, '', '2024-06-29 12:39:36', 0.00, ''),
(20, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 19290.00, 578.70, 0.00, 0.00, 0.00, 2, 1, 2500.00, 0, 0.00, '', '2024-06-29 12:46:27', 0.00, ''),
(21, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 14000.00, 420.00, 0.00, 0.00, 0.00, 2, 1, 700.00, 0, 0.00, '', '2024-06-29 12:48:40', 0.00, ''),
(22, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 14000.00, 420.00, 0.00, 0.00, 0.00, 2, 1, 700.00, 5, 200.00, '', '2024-06-29 12:53:05', 0.00, '1'),
(23, 202406291, '2024-06-29', 1, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'ksamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 14290.00, 428.70, 0.00, 0.00, 0.00, 2, 1, 1800.00, 5, 200.00, '', '2024-06-29 12:53:35', 0.00, '2'),
(24, 202407104, '2024-07-10', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 9000.00, 270.00, 0.00, 0.00, 0.00, 1, 1, 1000.00, 5, 200.00, '', '2024-07-10 13:41:33', 0.00, '2'),
(25, 202407134, '2024-07-13', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 19290.00, 578.70, 0.00, 0.00, 0.00, 2, 1, 2500.00, 5, 200.00, '', '2024-07-13 16:03:16', 0.00, '2'),
(26, 202407154, '2024-07-15', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 9000.00, 270.00, 0.00, 0.00, 0.00, 1, 1, 1000.00, 0, 0.00, '', '2024-07-15 18:09:53', 0.00, ''),
(27, 202407204, '2024-07-20', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 30690.00, 920.70, 0.00, 0.00, 0.00, 5, 1, 3600.00, 5, 200.00, '', '2024-07-20 12:43:20', 0.00, '2'),
(28, 202407214, '2024-07-21', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 12900.00, 387.00, 0.00, 0.00, 0.00, 2, 1, 1900.00, 0, 0.00, '', '2024-07-21 17:05:23', 0.00, ''),
(29, 202407294, '2024-07-29', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 14000.00, 420.00, 0.00, 0.00, 0.00, 3, 1, 1500.00, 5, 200.00, '', '2024-07-29 02:25:38', 0.00, '1'),
(30, 202407319, '2024-07-31', 9, 'Imeshi Perera', 'imeshi@gmail.com', '0786541236', '0112567342', 'No:224/A', 'Flower road', 'Aluthgama', 11, 'Imeshi Perera', 'imeshi@gmail.com', '0786541236', '0112567342', 'No:224/A', 'Flower road', 'Aluthgama', 11, 20290.00, 608.70, 0.00, 0.00, 0.00, 0, 1, 0.00, 11, 400.00, '', '2024-07-31 13:37:31', 0.00, '1'),
(32, 2147483647, '2024-07-31', 9, 'Imeshi Perera', 'imeshi@gmail.com', '0786541236', '0112567342', 'No:224/A', 'Flower road', 'Aluthgama', 11, 'Imeshi Perera', 'imeshi@gmail.com', '0786541236', '0112567342', 'No:224/A', 'Flower road', 'Aluthgama', 11, 3000.00, 90.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 0, 0.00, '', '2024-07-31 14:24:28', 0.00, ''),
(33, 202407314, '2024-07-31', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 5000.00, 150.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-07-31 14:25:49', 0.00, '2'),
(34, 202407314, '2024-07-31', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 5000.00, 150.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-07-31 14:49:00', 0.00, '2'),
(35, 202407314, '2024-07-31', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 5000.00, 150.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-07-31 15:27:01', 0.00, '2'),
(36, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 17990.00, 539.70, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-08-01 12:57:59', 0.00, '1'),
(37, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 9000.00, 270.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-08-01 14:17:28', 0.00, '1'),
(38, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 7990.00, 239.70, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-08-01 14:26:26', 0.00, '1'),
(39, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 12000.00, 360.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 5, 200.00, '', '2024-08-01 19:19:49', 0.00, '2'),
(40, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 19000.00, 570.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-08-02 12:00:50', 0.00, '1'),
(41, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 13290.00, 398.70, 0.00, 0.00, 0.00, 0, 0, 0.00, 5, 200.00, '', '2024-08-01 20:40:44', 0.00, '1'),
(42, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 10000.00, 300.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 5, 200.00, '', '2024-08-01 20:41:45', 0.00, '1'),
(43, 2147483647, '2024-08-01', 4, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 'Nethmini Perera', 'neethmini@gmail.com', '0789645123', '0789654236', 'No 234/A', 'Temple road', 'Kotte', 5, 10000.00, 300.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 5, 200.00, '', '2024-08-03 04:14:20', 0.00, '1'),
(44, 2147483647, '2024-08-04', 4, 'Nethmini Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethmini Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 9000.00, 270.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 05:55:40', 0.00, '2'),
(45, 2147483647, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 10000.00, 300.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 06:10:08', 0.00, '2'),
(46, 20240804081212, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 19000.00, 570.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 06:12:15', 0.00, '2'),
(47, 20240804081638, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 28000.00, 840.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 06:16:41', 0.00, '2'),
(48, 20240804094457, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 28000.00, 840.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 07:45:01', 0.00, '2'),
(49, 20240804100018, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 28000.00, 840.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '66af3d335c2bf9.19536701Nethminiiiii Pereraaaa.jpg', '2024-08-04 08:34:59', 0.00, '2'),
(50, 20240804103541, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 9000.00, 270.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '66af3d6f580b16.91074767Nethminiiiii Pereraaaa.jpg', '2024-08-04 08:35:59', 0.00, '2'),
(51, 20240804150348, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 18000.00, 540.00, 0.00, 0.00, 0.00, 0, 1, 0.00, 11, 400.00, '66af7c93ded3f2.45898622Nethminiiiii Pereraaaa.jpg', '2024-08-04 13:15:55', 0.00, '2'),
(52, 20240804180837, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 9000.00, 270.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 11, 400.00, '', '2024-08-04 16:08:40', 0.00, '2'),
(53, 20240804195634, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 12000.00, 360.00, 0.00, 0.00, 0.00, 2, 0, 1500.00, 0, 0.00, '', '2024-08-04 17:56:34', 0.00, ''),
(54, 20240804213818, '2024-08-04', 4, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaa', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 12000.00, 360.00, 0.00, 0.00, 0.00, 2, 0, 1500.00, 11, 400.00, '', '2024-08-04 19:38:28', 400.00, '1'),
(55, 20240806074256, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 12900.00, 387.00, 12513.00, 0.00, 0.00, 2, 0, 1900.00, 11, 400.00, '', '2024-08-06 05:44:21', 400.00, '1'),
(56, 20240806093538, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 14000.00, 420.00, 13580.00, 0.00, 0.00, 2, 0, 700.00, 11, 400.00, '', '2024-08-06 07:35:45', 400.00, '1'),
(57, 20240806094422, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 14000.00, 420.00, 13580.00, 0.00, 0.00, 2, 0, 700.00, 0, 0.00, '', '2024-08-06 07:44:22', 0.00, ''),
(58, 20240806102646, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 20490.00, 614.70, 19875.30, 993.77, 18881.54, 3, 0, 3400.00, 11, 400.00, '', '2024-08-06 08:26:52', 400.00, '1'),
(59, 20240806131002, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 17, 20990.00, 629.70, 20360.30, 1018.02, 19342.29, 3, 0, 3800.00, 11, 400.00, '', '2024-08-06 11:10:13', 400.00, '1'),
(60, 20240806134427, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 13000.00, 390.00, 12610.00, 630.50, 11979.50, 2, 0, 1300.00, 11, 400.00, '', '2024-08-06 11:44:37', 400.00, '1'),
(61, 20240806140737, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 19290.00, 578.70, 18711.30, 935.57, 17775.74, 2, 0, 2500.00, 11, 400.00, '', '2024-08-06 12:07:57', 18175.74, '1'),
(62, 20240806141033, '2024-08-06', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 19290.00, 578.70, 18711.30, 935.57, 17775.74, 2, 0, 2500.00, 5, 200.00, '', '2024-08-06 12:10:52', 17975.74, '1'),
(63, 20240807062124, '2024-08-07', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 19290.00, 578.70, 18711.30, 935.57, 17775.74, 2, 0, 2500.00, 12, 0.00, '', '2024-08-07 04:21:50', 0.00, '1'),
(64, 20240807062251, '2024-08-07', 4, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 'Nethminiiiii Pereraaaaq', 'neethmini@gmail.com', '0789645124', '0789654234', 'No 234/Aa', 'Temple roadd', 'Kottee', 11, 19290.00, 578.70, 18711.30, 935.57, 17775.74, 2, 0, 2500.00, 11, 400.00, '', '2024-08-07 04:23:21', 18175.74, '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `OrderItemsId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `StockId` int(11) DEFAULT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `IssuedQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`OrderItemsId`, `OrderId`, `ProductId`, `StockId`, `UnitPrice`, `Quantity`, `IssuedQuantity`) VALUES
(1, 1, 10, 1, 3900.00, 1, 0),
(2, 2, 6, 9, 4000.00, 1, 0),
(3, 2, 11, 3, 2500.00, 1, 0),
(4, 3, 4, 7, 10000.00, 1, 0),
(5, 3, 9, 4, 8550.00, 1, 0),
(6, 3, 11, 3, 2500.00, 1, 0),
(7, 4, 1, 6, 9000.00, 1, 0),
(8, 4, 7, 2, 10290.00, 1, 0),
(9, 5, 1, 6, 9000.00, 1, 0),
(10, 5, 7, 2, 10290.00, 1, 0),
(11, 6, 1, 6, 9000.00, 1, 0),
(12, 6, 7, 2, 10290.00, 1, 0),
(13, 7, 1, 6, 9000.00, 1, 0),
(14, 7, 7, 2, 10290.00, 1, 0),
(15, 12, 5, 8, 3000.00, 1, 0),
(16, 12, 7, 2, 10290.00, 1, 0),
(17, 13, 6, 9, 4000.00, 1, 0),
(18, 13, 10, 1, 3900.00, 1, 0),
(19, 14, 9, 4, 8550.00, 1, 0),
(20, 14, 11, 3, 2500.00, 1, 0),
(21, 15, 4, 7, 10000.00, 1, 0),
(22, 15, 10, 10, 5000.00, 1, 0),
(23, 16, 1, 6, 9000.00, 1, 0),
(24, 16, 4, 7, 10000.00, 1, 0),
(25, 17, 8, 5, 7990.00, 1, 0),
(26, 17, 9, 4, 8550.00, 1, 0),
(27, 18, 4, 7, 10000.00, 1, 0),
(28, 18, 6, 9, 4000.00, 1, 0),
(29, 19, 1, 6, 9000.00, 1, 0),
(30, 19, 7, 2, 10290.00, 1, 0),
(31, 20, 1, 6, 9000.00, 1, 0),
(32, 20, 7, 2, 10290.00, 1, 0),
(33, 21, 4, 7, 10000.00, 1, 0),
(34, 21, 6, 9, 4000.00, 1, 0),
(35, 22, 4, 7, 10000.00, 1, 0),
(36, 22, 6, 9, 4000.00, 1, 0),
(37, 23, 6, 9, 4000.00, 1, 0),
(38, 23, 7, 2, 10290.00, 1, 0),
(39, 24, 1, 6, 9000.00, 1, 0),
(40, 25, 7, 2, 10290.00, 1, 0),
(41, 25, 1, 6, 9000.00, 1, 0),
(42, 26, 1, 6, 9000.00, 1, 0),
(43, 27, 4, 7, 10000.00, 1, 0),
(44, 27, 7, 2, 10290.00, 1, 0),
(45, 27, 6, 9, 4000.00, 1, 0),
(46, 27, 10, 1, 3900.00, 1, 0),
(47, 27, 11, 3, 2500.00, 1, 0),
(48, 28, 1, 6, 9000.00, 1, 0),
(49, 28, 10, 1, 3900.00, 1, 0),
(50, 29, 1, 6, 9000.00, 1, 0),
(51, 29, 11, 3, 2500.00, 2, 0),
(52, 30, 4, 7, 10000.00, 1, 0),
(53, 30, 7, 2, 10290.00, 1, 0),
(54, 31, 6, 9, 4000.00, 1, 0),
(55, 32, 5, 8, 3000.00, 1, 0),
(56, 33, 10, 10, 5000.00, 1, 0),
(57, 34, 10, 10, 5000.00, 1, 0),
(58, 35, 10, 10, 5000.00, 1, 0),
(59, 36, 4, 7, 10000.00, 1, 0),
(60, 36, 8, 5, 7990.00, 1, 0),
(61, 37, 1, 6, 9000.00, 1, 0),
(62, 38, 8, 5, 7990.00, 1, 3),
(63, 39, 1, 6, 9000.00, 1, 0),
(64, 39, 5, 8, 3000.00, 1, 0),
(65, 40, 1, 6, 9000.00, 1, 1),
(66, 40, 4, 7, 10000.00, 1, 0),
(67, 41, 5, 8, 3000.00, 1, 0),
(68, 41, 7, 2, 10290.00, 1, 0),
(69, 42, 4, 7, 10000.00, 1, 0),
(70, 43, 4, 7, 10000.00, 1, -1),
(71, 44, 1, 6, 9000.00, 1, 0),
(72, 45, 4, 7, 10000.00, 1, 0),
(73, 46, 4, 7, 10000.00, 1, 0),
(74, 46, 1, 6, 9000.00, 1, 0),
(75, 47, 4, 7, 10000.00, 1, 0),
(76, 47, 1, 6, 9000.00, 2, 0),
(77, 48, 4, 7, 10000.00, 1, 0),
(78, 48, 1, 6, 9000.00, 2, 0),
(79, 49, 4, 7, 10000.00, 1, 0),
(80, 49, 1, 6, 9000.00, 2, 0),
(81, 50, 1, 6, 9000.00, 1, 0),
(82, 51, 1, 6, 9000.00, 2, 2),
(83, 52, 1, 6, 9000.00, 1, 0),
(84, 53, 1, 6, 9000.00, 1, 0),
(85, 53, 5, 8, 3000.00, 1, 0),
(86, 54, 1, 6, 9000.00, 1, 0),
(87, 54, 5, 8, 3000.00, 1, 0),
(88, 55, 1, 6, 9000.00, 1, 0),
(89, 55, 10, 1, 3900.00, 1, 0),
(90, 56, 4, 7, 10000.00, 1, 0),
(91, 56, 6, 9, 4000.00, 1, 0),
(92, 57, 4, 7, 10000.00, 1, 0),
(93, 57, 6, 9, 4000.00, 1, 0),
(94, 58, 4, 7, 10000.00, 1, 0),
(95, 58, 8, 5, 7990.00, 1, 0),
(96, 58, 11, 3, 2500.00, 1, 0),
(97, 59, 1, 6, 9000.00, 1, 0),
(98, 59, 6, 9, 4000.00, 1, 0),
(99, 59, 8, 5, 7990.00, 1, 0),
(100, 60, 1, 6, 9000.00, 1, 0),
(101, 60, 6, 9, 4000.00, 1, 0),
(102, 61, 1, 6, 9000.00, 1, 0),
(103, 61, 7, 2, 10290.00, 1, 0),
(104, 62, 1, 6, 9000.00, 1, 0),
(105, 62, 7, 2, 10290.00, 1, 0),
(106, 63, 1, 6, 9000.00, 1, 0),
(107, 63, 7, 2, 10290.00, 1, 0),
(108, 64, 1, 6, 9000.00, 1, 0),
(109, 64, 7, 2, 10290.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_products_issue`
--

CREATE TABLE `order_products_issue` (
  `Id` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `StockId` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `IssuedQuantity` int(11) NOT NULL,
  `IssuedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products_issue`
--

INSERT INTO `order_products_issue` (`Id`, `OrderId`, `ProductId`, `StockId`, `UnitPrice`, `IssuedQuantity`, `IssuedDate`) VALUES
(1, 38, 8, 5, 7990.00, 1, '2024-08-01'),
(2, 38, 8, 5, 7990.00, 1, '2024-08-01'),
(3, 38, 8, 5, 7990.00, 1, '2024-08-01'),
(4, 40, 1, 6, 9000.00, 1, '2024-08-02'),
(5, 43, 4, 7, 10000.00, -1, '2024-08-03'),
(6, 51, 1, 6, 9000.00, 2, '2024-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `order_returns_products`
--

CREATE TABLE `order_returns_products` (
  `Id` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `StockId` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ReturnType` varchar(255) NOT NULL,
  `ReturnReason` text NOT NULL,
  `ReturnDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_returns_products`
--

INSERT INTO `order_returns_products` (`Id`, `OrderId`, `ProductId`, `StockId`, `UnitPrice`, `Quantity`, `ReturnType`, `ReturnReason`, `ReturnDate`) VALUES
(1, 43, 4, 7, 10000.00, 1, 'color_change', 'dddd', '2024-08-24');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `OrderStatusId` int(11) NOT NULL,
  `OrderStatusName` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`OrderStatusId`, `OrderStatusName`, `Status`) VALUES
(1, 'Not Proccessed', 0),
(2, 'Processing', 1),
(3, 'Packed', 2),
(4, 'Handed to deliver', 3),
(5, 'Delivered', 4),
(6, 'Cancelled', 5);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `PermissionId` int(11) NOT NULL,
  `PermissionName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`PermissionId`, `PermissionName`) VALUES
(1, 'Create'),
(2, 'View'),
(3, 'Update'),
(4, 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `price_request`
--

CREATE TABLE `price_request` (
  `Id` int(11) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `DeliverDate` date NOT NULL,
  `RequestDate` date NOT NULL,
  `FinalUpdateDate` date NOT NULL,
  `Token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_request_item`
--

CREATE TABLE `price_request_item` (
  `Id` int(11) NOT NULL,
  `PriceRequestId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `UpdatedDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `MainCategoryId` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `PurchasePrice` decimal(10,2) NOT NULL,
  `SellingPrice` decimal(10,2) NOT NULL,
  `PDescription` text NOT NULL,
  `WarrantyPeriod` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `ProductName`, `MainCategoryId`, `BrandID`, `CategoryId`, `SupplierId`, `ProductImage`, `PurchasePrice`, `SellingPrice`, `PDescription`, `WarrantyPeriod`, `Quantity`, `Status`) VALUES
(1, 'USB-C to Lightning Cable (2 m)', 2, 1, 5, 1, 'USB-C to Lightning Cable (2 m) main.jpg', 8000.00, 9000.00, 'Test', '1 Year', 4, 1),
(2, 'USB-C to Lightning Cable (1 m)', 2, 1, 5, 1, 'USB-C to Lightning Cable (1 m) main.jpg', 7000.00, 8000.00, 'tttt', '4 Months', 3, 1),
(3, 'Yesido C94 360 Bicycle Phone Holder', 2, 9, 7, 2, 'Yesido-C94-bicycle.jpg', 1500.00, 1700.00, '', '', 4, 1),
(4, 'Yesido C127 360 Bicycle Phone Holder', 2, 9, 7, 2, 'Yesido-C127-Bicycle.jpg', 1800.00, 2200.00, '', '', 2, 1),
(5, 'Yesido C138 free stretch adjustable suction cup car holder', 2, 9, 7, 2, 'Yesido C138 free stretch adjustable suction cup car holder.jpg', 2100.00, 2600.00, '', '', 4, 1),
(6, 'Yesido car holder 360 degrees free rotation C2', 2, 9, 7, 2, 'Yesido car holder 360 degrees free rotation C2.jpg', 2700.00, 3000.00, '', '', 5, 1),
(7, 'Apple USB-C 20W Original Power Adapter', 2, 1, 8, 2, 'Apple USB-C 20W Original Power Adapter.jpg', 8790.00, 10290.00, '', '', 1, 1),
(8, 'Google USB-C Charger 30W Power Adapter', 2, 10, 8, 2, 'Google USB-C Charger 30W Power Adapter.jpg', 5490.00, 7990.00, '', '', 3, 1),
(9, 'Samsung 25W PD 3pin Original Adapter', 2, 2, 8, 2, 'Samsung 25W PD 3pin Original Adapter.jpg', 5550.00, 8550.00, 'test', '', 2, 1),
(10, 'Kakusiga KSC-464 JINANYA Smart Blutooth Keyboard', 1, 11, 1, 1, 'Kakusiga KSC-464 JINANYA Smart Blutooth Keyboard.jpg', 3000.00, 3900.00, '', '', 1, 1),
(11, 'KAKU KSC-339 JIEDA 8 SMART BLUETOOTH KEYBOARD - BLACK', 1, 11, 1, 1, 'KAKU KSC-339 JIEDA 8 SMART BLUETOOTH KEYBOARD - BLACK.jpg', 2000.00, 2500.00, '', '', 2, 1),
(12, 'New one', 1, 2, 1, 2, '', 400.00, 500.00, '', '', 0, 1),
(15, 'Test new pro', 2, 2, 2, 2, 'cable.jpg', 200.00, 300.00, 'dddd', '', 1, 1),
(16, 'ttttttt', 1, 8, 6, 4, '', 5000.00, 6000.00, '', '', 1, 1),
(17, 'sssssssss', 1, 7, 6, 3, '', 8000.00, 9000.00, '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `Id` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `SerialNumber` varchar(255) NOT NULL,
  `BatchNumber` varchar(255) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`Id`, `ProductId`, `SerialNumber`, `BatchNumber`, `Status`) VALUES
(1, 13, 'SN22223', '11111BN1', 1),
(2, 13, 'SN22223', '11111BN', 1),
(4, 13, '444SN', '333BN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `StockId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `IssuedQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`StockId`, `ProductId`, `Quantity`, `UnitPrice`, `PurchaseDate`, `SupplierId`, `IssuedQuantity`) VALUES
(1, 10, 20, 3900.00, '2024-05-01', 1, 0),
(2, 7, 10, 10290.00, '2024-05-02', 2, 0),
(3, 11, 5, 2500.00, '2024-05-10', 1, 0),
(4, 9, 10, 8550.00, '2024-05-07', 2, 0),
(5, 8, 6, 7990.00, '2024-05-05', 1, 3),
(6, 1, 5, 9000.00, '2024-05-10', 2, 3),
(7, 4, 6, 10000.00, '2024-05-10', 2, -1),
(8, 5, 5, 3000.00, '2024-05-24', 2, 0),
(9, 6, 10, 4000.00, '2024-05-24', 2, 0),
(10, 10, 10, 5000.00, '2024-05-15', 1, 0),
(11, 15, 0, 300.00, '2024-08-07', 2, 1),
(12, 2, 1, 0.00, '0000-00-00', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `Id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `PermissionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serial_numbers`
--

CREATE TABLE `serial_numbers` (
  `SerialNumberId` int(11) NOT NULL,
  `SerialNumber` varchar(255) NOT NULL,
  `DescriptionSN` text NOT NULL,
  `StatusSN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serial_numbers`
--

INSERT INTO `serial_numbers` (`SerialNumberId`, `SerialNumber`, `DescriptionSN`, `StatusSN`) VALUES
(1, 'SN0001', '', 1),
(2, 'SN0002', 'test test test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_modules`
--

CREATE TABLE `sub_modules` (
  `Id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Path` varchar(100) NOT NULL,
  `File` varchar(100) NOT NULL,
  `Icon` varchar(100) DEFAULT NULL,
  `Idx` int(11) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_modules`
--

INSERT INTO `sub_modules` (`Id`, `module_id`, `Name`, `Path`, `File`, `Icon`, `Idx`, `Status`) VALUES
(1, 8, 'Main Categories', 'products', 'mainCategoryManage', '', 2, 1),
(2, 8, 'Categories', 'products', 'categoryManage', '', 3, 1),
(3, 8, 'Brands', 'products', 'brandManage', '', 4, 1),
(6, 8, 'Products', 'products', 'productManage', '', 1, 1),
(7, 1, 'Users', 'users', 'userManage', '', 1, 1),
(8, 1, 'Roles', 'users', 'roleManage', '', 2, 1),
(9, 1, 'Permission', 'users', 'permissionManage', '', 3, 1),
(10, 10, 'Courier Cost', 'delivery', 'courierCostManage', '', 1, 1),
(11, 10, 'Courier Profile', 'delivery', 'courierProfileManage', '', 2, 1),
(14, 12, 'Quotations', 'purchases', 'quotationManage', '', 2, 1),
(15, 12, 'Quotation Requests', 'purchases', 'quotationRequestsManage', '', 1, 1),
(16, 12, 'Purchase Orders', 'purchases', 'purchaseOrdersManage', '', 3, 1),
(17, 12, 'GRN', 'purchases', 'manageGRN', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `SupplierId` int(11) NOT NULL,
  `SupCompanyName` varchar(255) NOT NULL,
  `ContPersonName` varchar(255) NOT NULL,
  `ContactMobile` varchar(15) NOT NULL,
  `AlternateMobile` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `RegDate` date NOT NULL,
  `AddressLine1` varchar(255) NOT NULL,
  `AddressLine2` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `AccountName` varchar(255) NOT NULL,
  `AccountNumber` varchar(255) NOT NULL,
  `BankName` varchar(255) NOT NULL,
  `Branch` varchar(255) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierId`, `SupCompanyName`, `ContPersonName`, `ContactMobile`, `AlternateMobile`, `Email`, `RegDate`, `AddressLine1`, `AddressLine2`, `City`, `DistrictId`, `AccountName`, `AccountNumber`, `BankName`, `Branch`, `Status`) VALUES
(1, 'ABC Company', 'Amal Perera', '011256854', '0756984563', 'abccompany@gmail.com', '2024-04-26', 'No: 225/A', 'Temple road', 'Kandana', 2, 'Abc com', '4589526614562599', 'Sampath', 'Malabe', 1),
(2, 'XYZ Company', 'Hansi Alvis', '0112896541', '0789654123', 'xyz@gmail.com', '2024-04-25', 'No: 12/D', 'Flower road', 'Dumbara', 11, 'Shani', '1111111111111111', 'BOC', 'Kandy', 0),
(3, 'Techno Zone', 'Amal Perera', '0789654123', '', 'technozone@gmail.com', '2024-07-03', 'Test 1', 'Test 2', 'Bern', 4, '', '', '', '', 1),
(4, 'Mobile Plaza', 'Dilip Tharuka', '0796541236', '', 'bitnce@gmail.com', '2024-07-05', 'Neugasse 12, 8810 Horgen, Switzerland', 'Neugasse', 'Horgen', 23, '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ConfirmPassword` varchar(255) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `UserType` varchar(100) DEFAULT NULL,
  `UserRoleId` varchar(255) NOT NULL,
  `Status` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_verified` int(1) NOT NULL DEFAULT 0,
  `reset_expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `ConfirmPassword`, `FirstName`, `LastName`, `Email`, `UserType`, `UserRoleId`, `Status`, `token`, `is_verified`, `reset_expiration`) VALUES
(1, 'Nethmi11', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Nethmi', 'Udara', '', 'admin', '1', 1, NULL, 1, '2024-08-03 07:03:28'),
(10, 'Kasuni12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 1, '2024-08-03 07:03:37'),
(11, 'Hasini00', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 1, '2024-08-03 07:03:40'),
(12, 'Amal12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:45'),
(13, 'Amal123', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:48'),
(17, 'Kamani12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:20'),
(18, 'Nilan56', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:17'),
(19, 'Nisal12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:13'),
(20, 'Nethmini12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Nethminiiiii', 'Pereraaaaq', '', 'customer', '', NULL, NULL, 0, '2024-08-05 10:54:25'),
(25, 'Hasini12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:03:01'),
(26, 'Sheran12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:02:57'),
(27, 'Kasun12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', NULL, NULL, '', 'customer', '', NULL, NULL, 0, '2024-08-03 07:02:53'),
(28, 'Dinesh923', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Dinesh', 'Tharusha', 'testdinesh@gmail.com', 'customer', '', NULL, 'b1ec56b2f03cdd5b96ac259142408962', 0, '2024-08-03 07:02:49'),
(29, 'AmaliS56', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Amali', 'Perera', NULL, 'employee', '3', 1, '', 0, '2024-08-07 13:09:02'),
(31, 'Dilip91', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Dilip', 'Tharuka', NULL, 'employee', '4', 1, '', 0, '2024-08-07 13:06:38'),
(33, 'Dasu88', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Dasuni', 'Adikari', NULL, 'employee', '2', 1, '', 0, '2024-08-07 13:03:35'),
(34, 'Kamal123', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Kamal', 'Wijethunga', NULL, 'employee', '1', 1, '', 0, '2024-08-07 13:04:37'),
(35, 'Imeshi12', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Imeshi', 'Perera', 'imeshi@gmail.com', 'customer', '', NULL, '0ab5632d78a69ceea8d3108de7e0adbf', 0, '2024-08-03 07:02:23'),
(36, 'Apsa12ra', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'Megani', 'Weerasekara', 'bitncee@gmail.com', 'customer', '', NULL, '5c47d29dbabb7c50ba6f8046886a8620', 1, '2024-08-03 07:02:19'),
(37, 'bitnce', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', '$2y$10$1gjCXwTgyeaYVp6od/0iTeMlbXkapJUZm91az54eZKOV6ElXzOOXW', 'gtrgtrg', 'rtgtrgrt', 'bbbbitnce@gmail.com', 'customer', '', NULL, NULL, 0, '2024-08-03 07:02:15'),
(38, 'TestBIT', '$2y$10$nrnbF9wRZacQ97GWYHQ2X./3nTYMISkCQU/e9qRQONLWMjF81LI..', '$2y$10$wvB9SH79GeveSPAMBy57u.YltyYSSfKP0y9GpV7DvEOeAT/ncPKu6', 'Test', 'User', 'bitnce@gmail.com', 'customer', '', NULL, NULL, 1, '2024-08-03 14:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ModuleId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `Add` int(1) NOT NULL DEFAULT 1,
  `View` int(1) NOT NULL DEFAULT 1,
  `Update` int(1) NOT NULL DEFAULT 1,
  `Delete` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`Id`, `UserId`, `ModuleId`, `RoleId`, `Add`, `View`, `Update`, `Delete`) VALUES
(1, 1, 1, 0, 1, 1, 1, 1),
(2, 1, 2, 0, 1, 1, 1, 1),
(3, 1, 3, 0, 1, 1, 1, 1),
(4, 1, 4, 0, 1, 1, 1, 1),
(5, 1, 5, 0, 1, 1, 1, 1),
(6, 1, 8, 0, 1, 1, 1, 1),
(7, 1, 9, 0, 1, 1, 1, 1),
(8, 1, 10, 0, 1, 1, 1, 1),
(9, 1, 11, 0, 1, 1, 1, 1),
(10, 1, 12, 0, 1, 1, 1, 1),
(11, 1, 13, 0, 1, 1, 1, 1),
(12, 32, 8, 0, 1, 1, 1, 1),
(13, 1, 14, 0, 1, 1, 1, 1),
(14, 32, 14, 0, 1, 1, 1, 1),
(15, 34, 1, 1, 1, 1, 1, 1),
(16, 33, 2, 2, 1, 1, 1, 1),
(17, 33, 3, 2, 1, 1, 1, 1),
(18, 33, 4, 2, 1, 1, 1, 1),
(19, 33, 5, 2, 1, 1, 1, 1),
(20, 33, 8, 2, 1, 1, 1, 1),
(22, 33, 12, 2, 1, 1, 1, 1),
(23, 33, 13, 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `Id` int(11) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`Id`, `Role`, `Description`, `Status`) VALUES
(1, 'Admin', '', 0),
(2, 'Manager', '', 0),
(3, 'StockKeeper', '', 0),
(4, 'DeliveryAdmin', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

CREATE TABLE `warranty` (
  `WarrantyId` int(11) NOT NULL,
  `Warranty` varchar(255) NOT NULL,
  `WDescription` text NOT NULL,
  `WStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_numbers`
--
ALTER TABLE `batch_numbers`
  ADD PRIMARY KEY (`BatchNumberId`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`BrandId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryId`);

--
-- Indexes for table `civil_status`
--
ALTER TABLE `civil_status`
  ADD PRIMARY KEY (`CivilStatusId`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`ColorId`);

--
-- Indexes for table `contactus_messages`
--
ALTER TABLE `contactus_messages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`CouponId`);

--
-- Indexes for table `courier_service`
--
ALTER TABLE `courier_service`
  ADD PRIMARY KEY (`CourierServiceId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`DesignationId`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeId`);

--
-- Indexes for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`EmployeeStatusId`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`MainCategoryId`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderId`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`OrderItemsId`);

--
-- Indexes for table `order_products_issue`
--
ALTER TABLE `order_products_issue`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `order_returns_products`
--
ALTER TABLE `order_returns_products`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`OrderStatusId`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`PermissionId`);

--
-- Indexes for table `price_request`
--
ALTER TABLE `price_request`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `price_request_item`
--
ALTER TABLE `price_request_item`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`StockId`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `serial_numbers`
--
ALTER TABLE `serial_numbers`
  ADD PRIMARY KEY (`SerialNumberId`);

--
-- Indexes for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`SupplierId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `warranty`
--
ALTER TABLE `warranty`
  ADD PRIMARY KEY (`WarrantyId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_numbers`
--
ALTER TABLE `batch_numbers`
  MODIFY `BatchNumberId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `BrandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `civil_status`
--
ALTER TABLE `civil_status`
  MODIFY `CivilStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `ColorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contactus_messages`
--
ALTER TABLE `contactus_messages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `CouponId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courier_service`
--
ALTER TABLE `courier_service`
  MODIFY `CourierServiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `DesignationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `EmployeeStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `MainCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `OrderItemsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `order_products_issue`
--
ALTER TABLE `order_products_issue`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_returns_products`
--
ALTER TABLE `order_returns_products`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `OrderStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `PermissionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price_request`
--
ALTER TABLE `price_request`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `price_request_item`
--
ALTER TABLE `price_request_item`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `StockId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serial_numbers`
--
ALTER TABLE `serial_numbers`
  MODIFY `SerialNumberId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_modules`
--
ALTER TABLE `sub_modules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user_modules`
--
ALTER TABLE `user_modules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `warranty`
--
ALTER TABLE `warranty`
  MODIFY `WarrantyId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

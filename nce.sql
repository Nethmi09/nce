-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 01:27 PM
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
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `BrandId` int(11) NOT NULL,
  `BrandImage` varchar(255) DEFAULT NULL,
  `BrandName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `MainCategoryId` int(11) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`BrandId`, `BrandImage`, `BrandName`, `Description`, `MainCategoryId`, `Status`) VALUES
(1, 'apple.png', 'Apple', 'Test test', 2, 1),
(2, 'samsung.png', 'Samsung', 'Test 2', 2, 1),
(6, 'redmi.png', 'Redmi', 'Test 3', 2, 1),
(7, 'hp.png', 'HP', 'Test 4', 1, 1),
(8, 'lenovo.png', 'Lenovo', 'Test 5', 1, 1),
(9, 'yesido.png', 'Yesido', 'Test  6', 2, 1),
(10, 'google.png', 'Google', 'Test 8', 2, 1),
(11, 'kaku.png', 'Kaku', 'Test 10', 1, 1),
(12, '', 'Test 12', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryId` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `MainCategoryId` int(11) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryId`, `CategoryName`, `Description`, `MainCategoryId`, `Status`) VALUES
(1, 'Keyboards', 'Test 01', 1, 1),
(2, 'Mobile back covers', 'Test 02', 2, 1),
(5, 'Mobile Cables', 'Testtt', 2, 1),
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
(1, 'Kamani', 'Alvis', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, '0789654123', '0789654123', 'kamani@gmail.com', 2024031317, 17),
(2, 'Nilan', 'Sudesh', 'No 234/A', 'Hakmana road', 'Matara', 17, '0789654123', '0789654123', 'nilan@gmail.com', 2024031318, 18),
(3, 'Nisal', 'Alvis', 'No:224/A', 'Pipeline road', 'Koswaththa', 5, '0789654123', '0789654153', 'nisal@gmail.com', 2024031819, 19),
(4, 'Nethmini', 'Perera', 'No 234/A', 'Temple road', 'Kotte', 5, '0789645123', '0789654236', 'nethmini@gmail.com', 2024031920, 20);

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
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`Id`, `Name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Batticaloa'),
(4, 'Badulla'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Matale'),
(16, 'Mannar'),
(17, 'Matara'),
(18, 'Monaragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

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
(6, 'EMP:0006', 'Kasuni', 'Perera', '958945612v', 'nimali@gmail.com', '0789654123', '0545454555', 'Test Address 1', 'ttttttttt', 'Horgeyhhjjn', 11, '', '2009-02-13', 'Female', '2024-05-03', '0000-00-00', 5, 1, 2, 0, '', '', '', '');

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
  `MainCategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`MainCategoryId`, `MainCategoryName`) VALUES
(1, 'Computer Accessories'),
(2, 'Mobile Accessories');

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
(1, 'User Management', 'users', 'manage', 'fas fa-user', 1, 1),
(2, 'Customer Management', 'customers', 'manage', 'fas fa-users', 3, 1),
(3, 'Supplier Management', 'suppliers', 'manage', 'fas fa-user-tie', 5, 1),
(4, 'Order Management', 'orders', 'manage', 'fas fa-shopping-cart', 4, 1),
(5, 'Employee Management', 'employees', 'manage', 'fas fa-users', 2, 1),
(6, 'Category Management', 'categories', 'manage', 'fas fa-copyright', 7, 1),
(7, 'Brand Management', 'brands', 'manage', 'fas fa-bold', 6, 1),
(8, 'Product Management', 'products', 'manage', 'fab fa-product-hunt', 8, 1),
(9, 'Inventory Management', 'inventory', 'manage', 'fas fa-dolly-flatbed', 9, 1),
(10, 'Delivery Management', 'deliveries', 'manage', 'fas fa-truck', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderId` int(11) NOT NULL,
  `OrderNumber` int(11) DEFAULT NULL,
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
  `ShippingDistrictId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderId`, `OrderNumber`, `OrderDate`, `CustomerId`, `PersonalName`, `PersonalEmail`, `PersonalContactMobile`, `PersonalAlternateMobile`, `PersonalAddressLine1`, `PersonalAddressLine2`, `PersonalCity`, `PersonalDistrictId`, `ShippingName`, `ShippingEmail`, `ShippingContactMobile`, `ShippingAlternateMobile`, `ShippingAddressLine1`, `ShippingAddressLine2`, `ShippingCity`, `ShippingDistrictId`) VALUES
(1, 202405234, '2024-05-23', 4, 'Nethmi Udara', 'nethmi@gmail.com', '0786541236', '0789654125', 'test ad 1', 'test ad 2', 'test city', 11, 'Nethmi Udara', 'nethmi@gmail.com', '0786541236', '0789654125', 'test ad 1', 'test ad 2', 'test city', 11),
(2, 202405261, '2024-05-26', 1, 'Kamani Alvis', 'kamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5, 'Kamani Alvis', 'kamani@gmail.com', '0789654123', '0789654123', 'No: 224/A', 'Athulkotte road', 'Kotte', 5),
(3, 202405263, '2024-05-26', 3, 'Nisal Perera', 'nisal@gmail.com', '0789654123', '0713654789', 'Ad line1 test', 'Ad line 2 test', 'citytest', 3, 'Nisal Perera', 'nisal@gmail.com', '0789654123', '0713654789', 'Ad line1 test', 'Ad line 2 test', 'citytest', 11);

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
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`OrderItemsId`, `OrderId`, `ProductId`, `StockId`, `UnitPrice`, `Quantity`) VALUES
(1, 1, 10, 1, 3900.00, 1),
(2, 2, 6, 9, 4000.00, 1),
(3, 2, 11, 3, 2500.00, 1),
(4, 3, 4, 7, 10000.00, 1),
(5, 3, 9, 4, 8550.00, 1),
(6, 3, 11, 3, 2500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `PurchasePrice` decimal(10,2) NOT NULL,
  `SellingPrice` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `WarrantyPeriod` varchar(255) NOT NULL,
  `Discount` varchar(255) NOT NULL,
  `DiscountStartDate` date NOT NULL,
  `DiscountEndDate` date NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `ProductName`, `BrandID`, `CategoryId`, `SupplierId`, `ProductImage`, `PurchasePrice`, `SellingPrice`, `Description`, `WarrantyPeriod`, `Discount`, `DiscountStartDate`, `DiscountEndDate`, `Status`) VALUES
(1, 'USB-C to Lightning Cable (2 m)', 1, 5, 1, 'USB-C to Lightning Cable (2 m) main.jpg', 8000.00, 9000.00, 'Test', '1 Year', '0', '2024-04-28', '2024-05-28', 1),
(2, 'USB-C to Lightning Cable (1 m)', 1, 5, 1, 'USB-C to Lightning Cable (1 m) main.jpg', 7000.00, 8000.00, 'tttt', '4 Months', '5', '2024-04-29', '2024-04-30', 1),
(3, 'Yesido C94 360 Bicycle Phone Holder', 9, 7, 2, 'Yesido-C94-bicycle.jpg', 1500.00, 1700.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(4, 'Yesido C127 360 Bicycle Phone Holder', 9, 7, 2, 'Yesido-C127-Bicycle.jpg', 1800.00, 2200.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(5, 'Yesido C138 free stretch adjustable suction cup car holder', 9, 7, 2, 'Yesido C138 free stretch adjustable suction cup car holder.jpg', 2100.00, 2600.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(6, 'Yesido car holder 360 degrees free rotation C2', 9, 7, 2, 'Yesido car holder 360 degrees free rotation C2.jpg', 2700.00, 3000.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(7, 'Apple USB-C 20W Original Power Adapter', 1, 8, 2, 'Apple USB-C 20W Original Power Adapter.jpg', 8790.00, 10290.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(8, 'Google USB-C Charger 30W Power Adapter', 10, 8, 2, 'Google USB-C Charger 30W Power Adapter.jpg', 5490.00, 7990.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(9, 'Samsung 25W PD 3pin Original Adapter', 2, 8, 2, 'Samsung 25W PD 3pin Original Adapter.jpg', 5550.00, 8550.00, 'test', '', '', '0000-00-00', '0000-00-00', 1),
(10, 'Kakusiga KSC-464 JINANYA Smart Blutooth Keyboard', 11, 1, 1, 'Kakusiga KSC-464 JINANYA Smart Blutooth Keyboard.jpg', 3000.00, 3900.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(11, 'KAKU KSC-339 JIEDA 8 SMART BLUETOOTH KEYBOARD - BLACK', 11, 1, 1, 'KAKU KSC-339 JIEDA 8 SMART BLUETOOTH KEYBOARD - BLACK.jpg', 2000.00, 2500.00, '', '', '', '0000-00-00', '0000-00-00', 1),
(12, 'New one', 2, 1, 2, '', 400.00, 500.00, '', '', '', '0000-00-00', '0000-00-00', 1);

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
(1, 10, 20, 3900.00, '2024-05-01', 1, 2),
(2, 7, 10, 10290.00, '2024-05-02', 2, 3),
(3, 11, 5, 2500.00, '2024-05-10', 1, 2),
(4, 9, 10, 8550.00, '2024-05-07', 2, 1),
(5, 8, 6, 7990.00, '2024-05-05', 1, 2),
(6, 1, 5, 9000.00, '2024-05-10', 2, 0),
(7, 4, 6, 10000.00, '2024-05-10', 2, 0),
(8, 5, 5, 3000.00, '2024-05-24', 2, 0),
(9, 6, 10, 4000.00, '2024-05-24', 2, 0);

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
(2, 'XYZ Company', 'Hansi Alvis', '0112896541', '0789654123', 'xyz@gmail.com', '2024-04-25', 'No: 12/D', 'Flower road', 'Dumbara', 11, 'Shani', '1111111111111111', 'BOC', 'Kandy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `UserType` varchar(100) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `FirstName`, `LastName`, `UserType`, `Status`) VALUES
(1, 'Nethmi11', '$2y$10$v6NMWsGj1Zz9Ta967ndnLexptmR0xKTs/tw7hACiDLvCFcsAg/KXW', 'Nethmi', 'Udara', NULL, 0),
(8, 'Arith90', '$2y$10$TKCkc5rho/OQ44ykrK4ewuL3aT75DQ6qG3BXuUceioBP.Qkl6/FBG', '', '', NULL, 0),
(9, 'Nimal23', '$2y$10$qPKZiUSlTfCNf3/bIyhTHOgAQQjBVWhVd/IUNnFTyHmP6cpDOvSzm', 'Nimal', 'Perera', NULL, 0),
(10, 'Kasuni12', '$2y$10$jFgHT2Bw9.4ULHF292Wyees0VwKRWS2J0SXSeoXmth8B7SB2LHwaq', NULL, NULL, 'customer', NULL),
(11, 'Hasini00', '$2y$10$HmRhkXNVUARwu2WcelnCZO75RG0iFbg4qO.QwwZGKY0C/7HKBM1.q', NULL, NULL, 'customer', NULL),
(12, 'Amal12', '$2y$10$idZl8tT.AOvYI.xI3H96H.qh7HMm6aH/mW27Vc5zbsVxgdn8PK4jC', NULL, NULL, 'customer', NULL),
(13, 'Amal123', '$2y$10$c.PMAUfsDaRS8sISHMfbiOmY66s7237PTKYc1xWbSDYU86GJmo6EW', NULL, NULL, 'customer', NULL),
(14, 'Amal123sdsd', '$2y$10$O2weU3CZFFLaT5AtsWBk4OxgLOk/gHxZOVEhtWOomTBnwrSLDxY2W', NULL, NULL, 'customer', NULL),
(15, 'Amal123sdsddfsdfds', '$2y$10$BJWCJyowWuW5A05n/Y5AwOhomxTBhjaqfYBzeMX6iMwnU4zRa.sqC', NULL, NULL, 'customer', NULL),
(16, 'Amal123sdsddfsdfds', '$2y$10$BJWCJyowWuW5A05n/Y5AwOhomxTBhjaqfYBzeMX6iMwnU4zRa.sqC', NULL, NULL, 'customer', NULL),
(17, 'Kamani12', '$2y$10$AsvzerxBgATPqZ4tNLZPMu/EzM5oGiniRfNJhL9/q1NUPYNVOBAPe', NULL, NULL, 'customer', NULL),
(18, 'Nilan56', '$2y$10$2roUa92gUnBR3iH8YvlNp.mL3XBFGrG4v9IwGoYe7VtzGHGm2qZ/u', NULL, NULL, 'customer', NULL),
(19, 'Nisal12', '$2y$10$qduXF0endNmBI0BKfZFITe2mgIqqC1TcU0kB7z4TQMGRA/CwGwjbK', NULL, NULL, 'customer', NULL),
(20, 'Nethmini12', '$2y$10$bvKHsqYoN/.f6txM63dJteXYIX3SwCUYICyebt5lwrxP9FFO.s0wq', NULL, NULL, 'customer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ModuleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`Id`, `UserId`, `ModuleId`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 2),
(4, 1, 5),
(5, 1, 1),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerId`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`StockId`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `BrandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `civil_status`
--
ALTER TABLE `civil_status`
  MODIFY `CivilStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `EmployeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `EmployeeStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `MainCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `OrderItemsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `StockId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_modules`
--
ALTER TABLE `user_modules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

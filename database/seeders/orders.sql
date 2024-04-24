-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 01:07 PM
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
-- Database: `milung`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `linked_order` bigint(20) UNSIGNED DEFAULT NULL,
  `accessories` varchar(255) DEFAULT NULL,
  `article` varchar(255) DEFAULT NULL,
  `atc_number` varchar(255) DEFAULT NULL,
  `buyer` int(11) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `buyeremail` varchar(255) DEFAULT NULL,
  `buyerorder` varchar(255) DEFAULT NULL,
  `buyingprice` varchar(255) DEFAULT NULL,
  `ftyitem` varchar(255) DEFAULT NULL,
  `logocolor` varchar(255) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `incoterm` varchar(255) DEFAULT NULL,
  `inquiry` varchar(255) DEFAULT NULL,
  `milungorder` varchar(255) DEFAULT NULL,
  `notice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]' CHECK (json_valid(`notice`)),
  `orderdate` date DEFAULT NULL,
  `orderremarks` varchar(255) DEFAULT NULL,
  `packaging` varchar(255) DEFAULT NULL,
  `packagingprinting` varchar(255) DEFAULT NULL,
  `printingmethod` varchar(255) DEFAULT NULL,
  `productcolor` varchar(255) DEFAULT NULL,
  `productname` varchar(255) DEFAULT NULL,
  `qcremarks` varchar(255) DEFAULT NULL,
  `quantity_unit` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `logoFiles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`logoFiles`)),
  `manualFiles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`manualFiles`)),
  `safetySheetFiles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`safetySheetFiles`)),
  `labelFiles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`labelFiles`)),
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`files`)),
  `sellingprice` varchar(255) DEFAULT NULL,
  `sendoutdate` date DEFAULT NULL,
  `ship_doc` varchar(255) DEFAULT NULL,
  `so_number` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `totalvalue` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `linked_order`, `accessories`, `article`, `atc_number`, `buyer`, `capacity`, `buyeremail`, `buyerorder`, `buyingprice`, `ftyitem`, `logocolor`, `group`, `incoterm`, `inquiry`, `milungorder`, `notice`, `orderdate`, `orderremarks`, `packaging`, `packagingprinting`, `printingmethod`, `productcolor`, `productname`, `qcremarks`, `quantity_unit`, `reference`, `logoFiles`, `manualFiles`, `safetySheetFiles`, `labelFiles`, `files`, `sellingprice`, `sendoutdate`, `ship_doc`, `so_number`, `status`, `supplier`, `totalvalue`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Deleniti duis eiusmo', 'A101010', 'Quos maiores in sunt', 2, '[\"\"]', 'qicuv@mailinator.com', 'Voluptas ad qui sed', '312', 'Quas omnis qui labor', 'Expedita consectetur', 1, 'Quia ipsam magnam do', 'Non dolor aperiam de', 'Officia do incidunt', '[\"PV to Customer\"]', '1986-12-26', 'Sit quia amet et d', 'Reprehenderit aut d', '[\"Deserunt eveniet qu\"]', 'Dolor fugit molliti', 'Quisquam corporis id', 'Quas velit quae nec', 'Amet sit ut ut Nam', '96units', 'Omnis iure et incidi', NULL, NULL, NULL, NULL, '[{\"filename\":\"1709208331default.jpg\",\"filepath\":\"orders\\/files\\/1709208331default.jpg\"}]', '316', '1983-10-06', 'Mollit laboris nisi', 1, 'Export/Import', 3, '30336', '2024-03-06 07:05:31', '2024-03-06 06:30:27'),
(3, NULL, 'Consectetur nostrud', 'Suscipit assumenda r', 'Dolor porro pariatur', 2, '[\"88GB\"]', 'lyhihiboka@mailinator.com', 'Saepe quas sapiente', '321', 'Velit fugiat place', 'Eius omnis anim aliq', 2, 'Dolore sequi consect', 'Velit est consectet', 'Sed nemo ea quis ali', '[\"PV to Customer\"]', '1984-08-17', 'Earum corrupti cill', 'Ratione ipsa aut ma', '[\"Labore iure doloribu\"]', 'Ipsam exercitation v', 'Voluptate iste delen', 'Deserunt voluptatem', 'Autem ducimus aut l', '56units', 'Veniam at veniam e', '{\"filename\":\"wappalyzer_pral-com.pk.csv\",\"filepath\":\"orders\\/logoFiles\\/p8VCGJ8DNY.csv\"}', '{\"filename\":\"wappalyzer_pral-com.pk.csv\",\"filepath\":\"orders\\/manualFiles\\/RlUZZ2JyYK.csv\"}', '{\"filename\":\"wappalyzer_pral-com.pk.csv\",\"filepath\":\"orders\\/safetySheetFiles\\/zYXdXW0YXM.csv\"}', '{\"filename\":\"wappalyzer_pral-com.pk.csv\",\"filepath\":\"orders\\/labelFiles\\/pSkJXyRQru.csv\"}', '[{\"filename\":\"1712035121default_cropped_1702050495.jpg\",\"filepath\":\"orders\\/files\\/1712035121default_cropped_1702050495.jpg\"}]', '321', '2000-09-06', 'Officia distinctio', 3, 'Printview Confirmation', 3, '3333', '2024-03-06 06:13:01', '2024-04-02 00:18:41'),
(4, NULL, 'Sed rem et sequi inv', 'Rerum tempora in est', 'Dolorem qui earum il', 2, '[\"37mAh\"]', 'jivu@mailinator.com', 'Temporibus magni dol', NULL, 'Incidunt dolore qua', 'Consectetur fugiat', 1, 'Expedita quia laboru', 'Et est et elit reru', 'Qui irure ex ullam h', '[\"PV to Customer\"]', '2008-03-09', 'Molestiae quia ut to', 'Ipsum sunt aut rep', '[\"Laboris non id quia\"]', 'Eaque nisi non iusto', 'Culpa tenetur adipi', 'Consequat Dolore pr', 'Enim deserunt fugiat', '34units', 'Eveniet quis soluta', NULL, NULL, NULL, NULL, NULL, NULL, '1977-01-21', 'Doloribus libero aut', 1, 'Delivered', 3, '42', '2024-03-26 00:31:47', '2024-03-26 00:31:47'),
(5, NULL, 'Accusantium providen', 'Hic et magna qui ita', 'Quia ea pariatur Ma', 2, '[\"71mAh\"]', 'qomimypej@mailinator.com', 'Unde incidunt totam', NULL, 'Minus ea sed et sunt', 'Id ea voluptas sunt', 2, 'Cumque praesentium i', 'Nihil sequi cupidata', 'Tempore architecto', '[\"PV to Customer\"]', '1998-11-01', 'Harum magna sed ipsu', 'Dolore vitae anim su', '[\"Aliquid aut magnam e\"]', 'Aliquip harum quaera', 'Dolor et eum nihil n', 'Rem quis reprehender', 'Sunt aliquip saepe', '46units', 'Error libero pariatu', NULL, NULL, NULL, NULL, NULL, NULL, '2005-06-08', 'Aut quod nisi ut ali', NULL, 'Printview Reject', NULL, '43', '2024-03-26 00:32:05', '2024-03-26 00:32:05'),
(6, NULL, 'Aperiam est illum o', 'Dolor ad adipisicing', 'Sed cupiditate tempo', 2, '[\"12GB\"]', 'buba@mailinator.com', 'Sequi exercitation m', NULL, 'Provident recusanda', 'Fugiat in ipsa aut', 3, 'Lorem sed elit qui', 'Doloribus qui magna', 'Sint eligendi in dic', '[\"Fix Date\"]', '2002-06-02', 'Doloremque voluptatu', 'Ex dolor distinctio', '[\"Eu omnis laboris id\"]', 'Lorem cupiditate exp', 'Labore ut repudianda', 'Totam voluptas est q', 'Nisi qui quia ration', '98units', 'Consequat Libero na', NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-19', 'Illum qui ut nostru', NULL, 'Printview Reject', NULL, '3453', '2024-03-26 03:28:22', '2024-03-26 03:28:22'),
(7, NULL, 'Perspiciatis except', 'Mollitia sunt nesciu', 'Ut unde lorem qui ex', 6, '[\"24mAh\"]', 'bikafufyju@mailinator.com', 'Exercitationem ut co', NULL, 'Quidem a libero nece', 'Et consequat Quam r', 3, 'Facere esse cum in', 'Sequi magna nisi acc', 'Optio itaque conseq', '[]', '2003-01-21', 'Et labore sint et se', 'Saepe impedit ea cu', '[\"In et consequatur E\"]', 'Iure mollit est ab', 'Maxime et aut repudi', 'Expedita quis nihil', 'Excepturi aut ea rep', '8units', 'Voluptates veniam r', NULL, NULL, NULL, NULL, NULL, NULL, '1992-06-02', 'Ab dolor sed enim es', NULL, 'Printview Confirmation', NULL, '654', '2024-03-26 03:28:35', '2024-03-26 03:28:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_linked_order_foreign` (`linked_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_linked_order_foreign` FOREIGN KEY (`linked_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

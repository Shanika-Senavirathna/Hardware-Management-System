-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 05:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartbuild_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electrical'),
(4, 'Plumbing'),
(5, 'Building Materials'),
(7, 'Paint & Accessories'),
(8, 'Tools & Hardware'),
(9, 'Fasteners');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `min_reorder_level` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `category_name`, `category_id`, `quantity`, `min_reorder_level`, `unit_price`) VALUES
(2, 'HW-002', 'Tokyo Super Cement 50kg', 'Cement & Blocks', 2, 222.00, 20, 1980.00),
(3, 'HW-003', 'UltraTech Cement 50kg', 'Cement & Blocks', 3, 85.00, 10, 1920.00),
(4, 'HW-004', 'Solid Blocks 4 inch', 'Cement & Blocks', 3, 1515.00, 5, 75.00),
(5, 'HW-005', 'Solid Blocks 6 inch', 'Cement & Blocks', 4, 1039.00, 8, 95.00),
(6, 'HW-006', 'Common Red Bricks', 'Cement & Blocks', 5, 5000.00, 5, 35.00),
(7, 'HW-007', 'Paving Blocks Rectangular', 'Cement & Blocks', 0, 820.00, 0, 65.00),
(8, 'HW-008', 'Wall Plaster Mix 25kg', 'Cement & Blocks', 0, 76.00, 0, 850.00),
(9, 'HW-009', 'Waterproofing Slurry 5kg', 'Cement & Blocks', 0, 60.00, 0, 3200.00),
(10, 'HW-010', 'White Cement 1kg', 'Cement & Blocks', 0, 100.00, 0, 250.00),
(11, 'HW-011', 'Lime Powder 10kg', 'Cement & Blocks', 0, 60.00, 0, 450.00),
(12, 'HW-012', 'Skim Coat Smart Wall 25kg', 'Cement & Blocks', 0, 40.00, 0, 1650.00),
(13, 'HW-013', 'Tile Mortar Standard 25kg', 'Cement & Blocks', 0, 75.00, 0, 1450.00),
(14, 'HW-014', 'Tile Grout Waterproof 1kg', 'Cement & Blocks', 0, 150.00, 0, 350.00),
(15, 'HW-015', 'Ready Mix Concrete 25kg', 'Cement & Blocks', 0, 30.00, 0, 980.00),
(16, 'HW-016', 'Coarse Sand Cube', 'Cement & Blocks', 0, 5.00, 0, 18500.00),
(17, 'HW-017', 'Fine Sand Cube', 'Cement & Blocks', 0, 3.00, 0, 22000.00),
(18, 'HW-018', 'Aggregate Chips 3/4 inch Cube', 'Cement & Blocks', 0, 4.00, 0, 24000.00),
(19, 'HW-019', 'Rubble 6x9 inch Cube', 'Cement & Blocks', 0, 6.00, 0, 16000.00),
(20, 'HW-020', 'Fire Bricks Standard', 'Cement & Blocks', 0, 200.00, 0, 180.00),
(21, 'HW-021', 'Fly Ash Bricks', 'Cement & Blocks', 0, 1200.00, 0, 55.00),
(22, 'HW-022', 'AAC Light Weight Blocks', 'Cement & Blocks', 0, 399.00, 0, 380.00),
(23, 'HW-023', 'Gypsum Board 4x6 feet', 'Cement & Blocks', 0, 80.00, 0, 2100.00),
(24, 'HW-024', 'Asbestos Roofing Sheet 8ft', 'Cement & Blocks', 0, 77.00, 0, 2850.00),
(25, 'HW-025', 'Asbestos Roofing Sheet 10ft', 'Cement & Blocks', 0, 60.00, 0, 3400.00),
(26, 'HW-026', 'Zinc Aluminium Sheet 10ft', 'Cement & Blocks', 0, 50.00, 0, 4200.00),
(27, 'HW-027', 'Transparent Roofing Sheet 8ft', 'Cement & Blocks', 0, 25.00, 0, 3100.00),
(28, 'HW-028', 'Roofing Ridge Capping 6ft', 'Cement & Blocks', 0, 40.00, 0, 1250.00),
(29, 'HW-029', 'PVC Gutters 10ft', 'Cement & Blocks', 0, 45.00, 0, 1850.00),
(30, 'HW-030', 'Gutter Bracket PVC', 'Cement & Blocks', 0, 120.00, 0, 180.00),
(31, 'HW-031', 'Gutter Running Head PVC', 'Cement & Blocks', 0, 30.00, 0, 650.00),
(32, 'HW-032', 'Gutter End Cap PVC', 'Cement & Blocks', 0, 79.00, 0, 150.00),
(33, 'HW-033', 'Gutter Downpipe 10ft', 'Cement & Blocks', 0, 50.00, 0, 1100.00),
(34, 'HW-034', 'Cement Air Vent 9x9 inch', 'Cement & Blocks', 0, 60.00, 0, 220.00),
(35, 'HW-035', 'Cement Flower Pot Large', 'Cement & Blocks', 0, 15.00, 0, 1250.00),
(36, 'HW-036', 'Clay Roofing Tile Standard', 'Cement & Blocks', 0, 2000.00, 0, 95.00),
(37, 'HW-037', 'Wire Mesh 1/2 inch Roll', 'Cement & Blocks', 0, 12.00, 0, 6800.00),
(38, 'HW-038', 'Chicken Wire Mesh Roll', 'Cement & Blocks', 0, 15.00, 0, 4500.00),
(39, 'HW-039', 'Expanded Metal Sheet', 'Cement & Blocks', 0, 30.00, 0, 1850.00),
(40, 'HW-040', 'Polythene Sheet Underlay Roll', 'Cement & Blocks', 0, 8.00, 0, 8500.00),
(41, 'HW-041', 'Orange LED Bulb 9W', 'Electrical', 0, 300.00, 0, 380.00),
(42, 'HW-042', 'Orange LED Bulb 12W', 'Electrical', 0, 250.00, 0, 480.00),
(43, 'HW-043', 'Orange LED Bulb 18W', 'Electrical', 0, 150.00, 0, 680.00),
(44, 'HW-044', 'LED Panel Light Round 12W', 'Electrical', 0, 80.00, 0, 1250.00),
(45, 'HW-045', 'LED Panel Light Square 18W', 'Electrical', 0, 60.00, 0, 1650.00),
(46, 'HW-046', 'Orange 1 Gang Switch', 'Electrical', 0, 120.00, 0, 320.00),
(47, 'HW-047', 'Orange 2 Gang Switch', 'Electrical', 0, 100.00, 0, 420.00),
(48, 'HW-048', 'Orange 3 Gang Switch', 'Electrical', 0, 80.00, 0, 520.00),
(49, 'HW-049', 'Orange 4 Gang Switch', 'Electrical', 0, 50.00, 0, 650.00),
(50, 'HW-050', 'Orange 13A Switched Socket', 'Electrical', 0, 140.00, 0, 580.00),
(51, 'HW-051', 'Orange 5A Switched Socket', 'Electrical', 0, 110.00, 0, 450.00),
(52, 'HW-052', 'Orange Fan Speed Controller', 'Electrical', 0, 70.00, 0, 850.00),
(53, 'HW-053', 'Orange Light Dimmer', 'Electrical', 0, 40.00, 0, 950.00),
(54, 'HW-054', 'Orange Door Bell Switch', 'Electrical', 0, 65.00, 0, 360.00),
(55, 'HW-055', 'Main Switch 30A Orange', 'Electrical', 0, 25.00, 0, 2850.00),
(56, 'HW-056', 'Trip Switch 40A Orange', 'Electrical', 0, 30.00, 0, 4950.00),
(57, 'HW-057', 'MCB 10A Single Pole Kevilton', 'Electrical', 0, 90.00, 0, 450.00),
(58, 'HW-058', 'MCB 16A Single Pole Kevilton', 'Electrical', 0, 100.00, 0, 450.00),
(59, 'HW-059', 'MCB 32A Single Pole Kevilton', 'Electrical', 0, 80.00, 0, 480.00),
(60, 'HW-060', '4 Way Enclosure Box Surface', 'Electrical', 0, 34.00, 0, 1250.00),
(61, 'HW-061', '8 Way Enclosure Box Flush', 'Electrical', 0, 19.00, 0, 2400.00),
(62, 'HW-062', 'Kelani Cables 1/1.13 Cu (100m)', 'Electrical', 0, 15.00, 0, 6800.00),
(63, 'HW-063', 'Kelani Cables 7/0.67 Cu (100m)', 'Electrical', 0, 10.00, 0, 12500.00),
(64, 'HW-064', 'Kelani Cables 7/1.04 Cu (100m)', 'Electrical', 0, 40.00, 0, 24500.00),
(65, 'HW-065', 'Twin Core Flex Wire 14/0016', 'Electrical', 0, 500.00, 0, 45.00),
(66, 'HW-066', 'Twin Core Flex Wire 23/0016', 'Electrical', 0, 400.00, 0, 65.00),
(67, 'HW-067', 'Earth Wire 7/0.50 Green 100m', 'Electrical', 0, 8.00, 0, 5400.00),
(68, 'HW-068', 'PVC Conduit Pipe 20mm 10ft', 'Electrical', 0, 300.00, 0, 160.00),
(69, 'HW-069', 'PVC Conduit Pipe 25mm 10ft', 'Electrical', 0, 200.00, 0, 210.00),
(70, 'HW-070', 'PVC Flexible Hose 20mm 50m', 'Electrical', 0, 12.00, 0, 2400.00),
(71, 'HW-071', 'PVC Sun Box 1 Gang', 'Electrical', 0, 400.00, 0, 60.00),
(72, 'HW-072', 'PVC Sun Box 2 Gang', 'Electrical', 0, 250.00, 0, 80.00),
(73, 'HW-073', 'Insulation Tape Black Nitto', 'Electrical', 0, 500.00, 0, 120.00),
(74, 'HW-074', 'Insulation Tape Red Nitto', 'Electrical', 0, 200.00, 0, 120.00),
(75, 'HW-075', 'Wire Connectors Choc Block', 'Electrical', 0, 150.00, 0, 90.00),
(76, 'HW-076', 'Porcelain Lamp Holder Batten', 'Electrical', 0, 180.00, 0, 150.00),
(77, 'HW-077', 'Pendant Lamp Holder Plastic', 'Electrical', 0, 220.00, 0, 110.00),
(78, 'HW-078', 'Ceiling Fan 48 inch KDK', 'Electrical', 0, 15.00, 0, 14500.00),
(79, 'HW-079', 'Exhaust Fan 8 inch Orange', 'Electrical', 0, 18.00, 0, 4200.00),
(80, 'HW-080', 'LED Floodlight 50W Outdoor', 'Electrical', 0, 25.00, 0, 3800.00),
(81, 'HW-081', 'LED Floodlight 100W Outdoor', 'Electrical', 0, 14.00, 0, 6500.00),
(82, 'HW-082', 'Door Bell Ding Dong wired', 'Electrical', 0, 30.00, 0, 1150.00),
(83, 'HW-083', 'Casing Clip No 1 pack', 'Electrical', 0, 99.00, 0, 250.00),
(84, 'HW-084', 'Casing Clip No 2 pack', 'Electrical', 0, 99.00, 0, 280.00),
(85, 'HW-085', 'PVC Casing 3/4 inch 6ft', 'Electrical', 0, 250.00, 0, 110.00),
(86, 'HW-086', 'Plug Top 13A Fused Orange', 'Electrical', 0, 160.00, 0, 320.00),
(87, 'HW-087', 'Multi Plug Adapter 3 Way', 'Electrical', 0, 90.00, 0, 450.00),
(88, 'HW-088', 'Extension Cord 4 Way 5m', 'Electrical', 0, 25.00, 0, 2650.00),
(89, 'HW-089', 'Solder Wire Reel 100g', 'Electrical', 0, 30.00, 0, 850.00),
(90, 'HW-090', 'Soldering Iron 40W', 'Electrical', 0, 20.00, 0, 1250.00),
(91, 'HW-091', 'Causeway Brilliant White 10L', 'Paint & Accessories', 0, 15.00, 0, 8500.00),
(92, 'HW-092', 'Causeway Brilliant White 4L', 'Paint & Accessories', 0, 35.00, 0, 3800.00),
(93, 'HW-093', 'Causeway Weathercoat White 10L', 'Paint & Accessories', 0, 10.00, 0, 14500.00),
(94, 'HW-094', 'Causeway Weathercoat White 4L', 'Paint & Accessories', 0, 25.00, 0, 6200.00),
(95, 'HW-095', 'Wall Filler Standard 10L', 'Paint & Accessories', 0, 20.00, 0, 4200.00),
(96, 'HW-096', 'Wall Filler Standard 4L', 'Paint & Accessories', 0, 40.00, 0, 1850.00),
(97, 'HW-097', 'Water Base Floor Paint Red 4L', 'Paint & Accessories', 0, 18.00, 0, 4800.00),
(98, 'HW-098', 'Anti Corrosive Primer Grey 4L', 'Paint & Accessories', 0, 3.00, 0, 3400.00),
(99, 'HW-099', 'Anti Corrosive Primer Red 1L', 'Paint & Accessories', 0, 29.00, 0, 950.00),
(100, 'HW-100', 'Enamel Gloss Paint Black 1L', 'Paint & Accessories', 0, 30.00, 0, 1450.00),
(101, 'HW-101', 'Enamel Gloss Paint White 1L', 'Paint & Accessories', 0, 35.00, 0, 1450.00),
(102, 'HW-102', 'Clear Varnish Gloss 1L', 'Paint & Accessories', 0, 25.00, 0, 1250.00),
(103, 'HW-103', 'Wood Stain Teak 1L', 'Paint & Accessories', 0, 20.00, 0, 1350.00),
(104, 'HW-104', 'Wood Stain Mahogany 1L', 'Paint & Accessories', 0, 22.00, 0, 1350.00),
(105, 'HW-105', 'Turpentine Thinner 1L', 'Paint & Accessories', 0, 80.00, 0, 450.00),
(106, 'HW-106', 'NC Thinner Premium 1L', 'Paint & Accessories', 0, 40.00, 0, 850.00),
(107, 'HW-107', 'Paint Brush Harris 1 inch', 'Paint & Accessories', 0, 150.00, 0, 180.00),
(108, 'HW-108', 'Paint Brush Harris 2 inch', 'Paint & Accessories', 0, 120.00, 0, 290.00),
(109, 'HW-109', 'Paint Brush Harris 3 inch', 'Paint & Accessories', 0, 100.00, 0, 420.00),
(110, 'HW-110', 'Paint Brush Harris 4 inch', 'Paint & Accessories', 0, 90.00, 0, 580.00),
(111, 'HW-111', 'Paint Roller 9 inch with Tray', 'Paint & Accessories', 0, 40.00, 0, 1150.00),
(112, 'HW-112', 'Paint Roller Foam Refill 9in', 'Paint & Accessories', 0, 70.00, 0, 350.00),
(113, 'HW-113', 'Sandpaper No 80 Rough', 'Paint & Accessories', 0, 300.00, 0, 60.00),
(114, 'HW-114', 'Sandpaper No 120 Medium', 'Paint & Accessories', 0, 300.00, 0, 60.00),
(115, 'HW-115', 'Sandpaper No 220 Fine', 'Paint & Accessories', 0, 400.00, 0, 60.00),
(116, 'HW-116', 'Waterproof Emery Paper No 400', 'Paint & Accessories', 0, 200.00, 0, 80.00),
(117, 'HW-117', 'Masking Tape 1 inch Nitto', 'Paint & Accessories', 0, 150.00, 0, 150.00),
(118, 'HW-118', 'Masking Tape 2 inch Nitto', 'Paint & Accessories', 0, 90.00, 0, 280.00),
(119, 'HW-119', 'Wall Putty Powder 20kg', 'Paint & Accessories', 0, 35.00, 0, 1850.00),
(120, 'HW-120', 'Scraper Knife 3 inch Metal', 'Paint & Accessories', 0, 80.00, 0, 220.00),
(121, 'HW-121', 'Claw Hammer Premium 500g', 'Tools & Hardware', 0, 24.00, 0, 1450.00),
(122, 'HW-122', 'Sledge Hammer 2kg', 'Tools & Hardware', 0, 12.00, 0, 2850.00),
(123, 'HW-123', 'Hand Saw 24 inch Stanley', 'Tools & Hardware', 0, 15.00, 0, 2400.00),
(124, 'HW-124', 'Hacksaw Frame Adjustable', 'Tools & Hardware', 0, 30.00, 0, 950.00),
(125, 'HW-125', 'Hacksaw Blade Eclipse 18TPI', 'Tools & Hardware', 0, 200.00, 0, 120.00),
(126, 'HW-126', 'Adjustable Wrench 10 inch', 'Tools & Hardware', 0, 17.00, 0, 1850.00),
(127, 'HW-127', 'Combination Pliers 8 inch', 'Tools & Hardware', 0, 40.00, 0, 1150.00),
(128, 'HW-128', 'Long Nose Pliers 6 inch', 'Tools & Hardware', 0, 30.00, 0, 950.00),
(129, 'HW-129', 'Wire Stripper Automatic', 'Tools & Hardware', 0, 15.00, 0, 1650.00),
(130, 'HW-130', 'Screwdriver Set 6pcs Magnet', 'Tools & Hardware', 0, 25.00, 0, 1450.00),
(131, 'HW-131', 'Digital Voltage Tester Pen', 'Tools & Hardware', 0, 80.00, 0, 250.00),
(132, 'HW-132', 'Measuring Tape 5m Stanley', 'Tools & Hardware', 0, 50.00, 0, 850.00),
(133, 'HW-133', 'Spirit Level Heavy 24 inch', 'Tools & Hardware', 0, 18.00, 0, 1550.00),
(134, 'HW-134', 'Chisel Wood 1/2 inch', 'Tools & Hardware', 0, 25.00, 0, 450.00),
(135, 'HW-135', 'Chisel Wood 1 inch', 'Tools & Hardware', 0, 19.00, 0, 650.00),
(136, 'HW-136', 'Steel Chisel Pointed 12 inch', 'Tools & Hardware', 0, 35.00, 0, 550.00),
(137, 'HW-137', 'Mason Trowel 8 inch Pointed', 'Tools & Hardware', 0, 60.00, 0, 480.00),
(138, 'HW-138', 'Plastering Float Wooden', 'Tools & Hardware', 0, 45.00, 0, 250.00),
(139, 'HW-139', 'Plastering Float Plastic', 'Tools & Hardware', 0, 40.00, 0, 320.00),
(140, 'HW-140', 'Plumb Bob Steel with String', 'Tools & Hardware', 0, 25.00, 0, 650.00),
(141, 'HW-141', 'Wire Nails 1 inch 1kg', 'Tools & Hardware', 0, 50.00, 0, 380.00),
(142, 'HW-142', 'Wire Nails 2 inch 1kg', 'Building Materials', 0, 80.00, 0, 360.00),
(143, 'HW-143', 'Wire Nails 3 inch 1kg', 'Tools & Hardware', 0, 100.00, 0, 360.00),
(144, 'HW-144', 'Wire Nails 4 inch 1kg', 'Tools & Hardware', 0, 60.00, 0, 360.00),
(145, 'HW-145', 'Concrete Nails 2 inch Box', 'Tools & Hardware', 0, 40.00, 0, 650.00),
(146, 'HW-146', 'Concrete Nails 3 inch Box', 'Tools & Hardware', 0, 35.00, 0, 750.00),
(147, 'HW-147', 'Roofing Nails GI 2 inch 1kg', 'Tools & Hardware', 0, 45.00, 0, 480.00),
(148, 'HW-148', 'GI Binding Wire 22G 1kg', 'Tools & Hardware', 0, 70.00, 0, 520.00),
(149, 'HW-149', 'Wood Screws 1 inch 100pcs', 'Tools & Hardware', 0, 150.00, 0, 250.00),
(150, 'HW-150', 'Wood Screws 2 inch 100pcs', 'Tools & Hardware', 0, 80.00, 0, 450.00),
(151, 'HW-151', 'Rawl Plugs No 6 Pack', 'Tools & Hardware', 0, 200.00, 0, 150.00),
(152, 'HW-152', 'Rawl Plugs No 8 Pack', 'Tools & Hardware', 0, 150.00, 0, 180.00),
(153, 'HW-153', 'Padlock 40mm Brass Solex', 'Tools & Hardware', 0, 40.00, 0, 1850.00),
(154, 'HW-154', 'Padlock 50mm Brass Solex', 'Tools & Hardware', 0, 30.00, 0, 2450.00),
(155, 'HW-155', 'Door Lock Brass Mortise Set', 'Tools & Hardware', 0, 15.00, 0, 5800.00),
(156, 'HW-156', 'Drawer Lock Standard Chrome', 'Tools & Hardware', 0, 60.00, 0, 450.00),
(157, 'HW-157', 'Tower Bolt Brass 4 inch', 'Tools & Hardware', 0, 100.00, 0, 350.00),
(158, 'HW-158', 'Door Hinge Steel 4 inch Pair', 'Tools & Hardware', 0, 120.00, 0, 280.00),
(159, 'HW-159', 'Butt Hinge Brass 3 inch Pair', 'Tools & Hardware', 0, 80.00, 0, 420.00),
(160, 'HW-160', 'Shovel Square Nose Steel', 'Tools & Hardware', 0, 25.00, 0, 1650.00),
(161, 'HW-161', 'PVC Pipe 1/2 inch Type 1000 10ft', 'Plumbing', 0, 200.00, 0, 380.00),
(162, 'HW-162', 'PVC Pipe 3/4 inch Type 1000 10ft', 'Plumbing', 0, 150.00, 0, 490.00),
(163, 'HW-163', 'PVC Pipe 1 inch Type 1000 10ft', 'Plumbing', 0, 100.00, 0, 750.00),
(164, 'HW-164', 'PVC Pipe 2 inch Type 400 10ft', 'Plumbing', 0, 60.00, 0, 1150.00),
(165, 'HW-165', 'PVC Pipe 4 inch Drainage 10ft', 'Plumbing', 0, 40.00, 0, 2850.00),
(166, 'HW-166', 'PVC Socket 1/2 inch', 'Plumbing', 0, 500.00, 0, 30.00),
(167, 'HW-167', 'PVC Socket 3/4 inch', 'Plumbing', 0, 400.00, 0, 40.00),
(168, 'HW-168', 'PVC Elbow 90 Deg 1/2 inch', 'Plumbing', 0, 600.00, 0, 35.00),
(169, 'HW-169', 'PVC Elbow 90 Deg 3/4 inch', 'Plumbing', 0, 400.00, 0, 50.00),
(170, 'HW-170', 'PVC Tee 1/2 inch', 'Plumbing', 0, 350.00, 0, 45.00),
(171, 'HW-171', 'PVC Tee 3/4 inch', 'Plumbing', 0, 250.00, 0, 60.00),
(172, 'HW-172', 'PVC Reducing Socket 3/4 to 1/2', 'Plumbing', 0, 200.00, 0, 45.00),
(173, 'HW-173', 'PVC Valve Socket 1/2 inch', 'Plumbing', 0, 300.00, 0, 35.00),
(174, 'HW-174', 'PVC Faucet Socket 1/2 inch', 'Plumbing', 0, 250.00, 0, 40.00),
(175, 'HW-175', 'PVC End Cap 1/2 inch', 'Plumbing', 0, 400.00, 0, 25.00),
(176, 'HW-176', 'PVC Union 1/2 inch', 'Plumbing', 0, 80.00, 0, 180.00),
(177, 'HW-177', 'PVC Ball Valve 1/2 inch Compact', 'Plumbing', 0, 120.00, 0, 280.00),
(178, 'HW-178', 'PVC Ball Valve 3/4 inch Compact', 'Plumbing', 0, 90.00, 0, 380.00),
(179, 'HW-179', 'Brass Ball Valve 1/2 inch', 'Plumbing', 0, 30.00, 0, 1450.00),
(180, 'HW-180', 'PVC Solvent Cement Glue 50g', 'Plumbing', 0, 150.00, 0, 180.00),
(181, 'HW-181', 'PVC Solvent Cement Glue 100g', 'Plumbing', 0, 100.00, 0, 320.00),
(182, 'HW-182', 'Thread Seal Tape Teflon 12mm', 'Plumbing', 0, 800.00, 0, 70.00),
(183, 'HW-183', 'Water Tap Plastic 1/2 inch', 'Plumbing', 0, 150.00, 0, 220.00),
(184, 'HW-184', 'Water Tap Brass 1/2 inch Chrome', 'Plumbing', 0, 65.00, 0, 1250.00),
(185, 'HW-185', 'Sink Waste Coupling Brass', 'Plumbing', 0, 45.00, 0, 850.00),
(186, 'HW-186', 'Flexible Waste Hose Expandable', 'Plumbing', 0, 120.00, 0, 350.00),
(187, 'HW-187', 'Pillar Tap Basin Luxury', 'Plumbing', 0, 20.00, 0, 3400.00),
(188, 'HW-188', 'Hand Shower Set Chrome', 'Plumbing', 0, 25.00, 0, 2200.00),
(189, 'HW-189', 'Kitchen Sink Mixer Tap', 'Plumbing', 0, 12.00, 0, 6800.00),
(190, 'HW-190', 'Float Valve Brass 1/2 inch', 'Plumbing', 0, 18.00, 0, 1650.00),
(191, 'HW-191', 'Water Tank Overfow Pipe 1in', 'Plumbing', 0, 50.00, 0, 150.00),
(192, 'HW-192', 'Flexible Hose Connection 18in', 'Plumbing', 0, 100.00, 0, 450.00),
(193, 'HW-193', 'Stop Valve Brass 1/2 inch', 'Plumbing', 0, 50.00, 0, 950.00),
(194, 'HW-194', 'Bottle Trap Brass Chrome', 'Plumbing', 0, 14.00, 0, 2900.00),
(195, 'HW-195', 'PVC Floor Drain Grating 4in', 'Plumbing', 0, 80.00, 0, 180.00),
(196, 'HW-196', 'Stainless Steel Grating 4in', 'Plumbing', 0, 45.00, 0, 650.00),
(197, 'HW-197', 'Commode Hose Spray Set', 'Plumbing', 0, 40.00, 0, 1450.00),
(198, 'HW-198', 'PVC Pipe Clip 1/2 inch', 'Plumbing', 0, 995.00, 0, 15.00),
(199, 'HW-199', 'PVC Pipe Clip 3/4 inch', 'Plumbing', 0, 800.00, 0, 20.00),
(203, 'HW-200', 'sand (Cube)', 'Building Materials', 0, 5.75, 0, 2500.00),
(205, 'HW-201', 'Broken Stones (Cube)', 'Cement & Blocks', 0, 9.50, 0, 25000.00),
(206, 'HW-202', 'Red Soil (Cube)', 'Building Materials', 0, 20.00, 0, 1500.00),
(207, 'HW-203', 'Roofing Timber (Ft)', 'Building Materials', 0, 20.00, 0, 100.00),
(208, 'HW-204', 'Cement', 'Cement & Blocks', 0, 50.00, 0, 1500.00),
(209, 'HW-205', 'Nail 1/2\'\' (per 1kg)', 'Fasteners', 0, 50.00, 0, 600.00),
(210, 'HW-206', 'Nail 3/4\'\' (per 1kg)', 'Fasteners', 0, 50.00, 0, 650.00),
(211, 'HW-207', 'Nail 1\'\' (per 1kg)', 'Fasteners', 0, 50.00, 0, 700.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `sale_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `product_code`, `quantity`, `total_amount`, `sale_date`) VALUES
(43, 'INV-0001', 'HW-061', 1.00, 2400.00, '2026-07-08 02:44:50'),
(44, 'INV-0002', 'HW-098', 1.00, 3400.00, '2026-07-08 02:45:18'),
(45, 'INV-0003', 'HW-098', 1.00, 3400.00, '2026-07-08 03:02:06'),
(46, 'INV-0004', 'HW-098', 1.00, 3400.00, '2026-07-08 03:02:30'),
(47, 'INV-0005', 'HW-098', 1.00, 3400.00, '2026-07-08 03:16:46'),
(48, 'INV-0006', 'HW-200', 0.50, 1250.00, '2026-07-08 03:40:58'),
(49, 'INV-0007', 'HW-099', 1.00, 950.00, '2026-07-08 03:41:34'),
(50, 'INV-0008', 'HW-099', 1.00, 950.00, '2026-07-08 04:02:22'),
(51, 'INV-0009', 'HW-200', 0.50, 1250.00, '2026-07-08 05:16:50'),
(52, 'INV-0010', 'HW-098', 1.00, 3400.00, '2026-07-08 05:17:06'),
(53, 'INV-0011', 'HW-200', 0.25, 625.00, '2026-07-08 08:25:01'),
(54, 'INV-0012', 'HW-200', 0.50, 1250.00, '2026-07-08 08:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'Admin'),
(2, 'cashier', 'cashier123', 'Cashier'),
(3, 'shanika', 'shanika123', 'Cashier'),
(4, 'sahan', '12345', 'Cashier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

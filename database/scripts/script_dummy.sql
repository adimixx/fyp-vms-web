-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.25 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

ALTER TABLE `complaints` DISABLE KEYS;
ALTER TABLE `maintenance_quotations` DISABLE KEYS;
ALTER TABLE `maintenance_quotation_items` DISABLE KEYS;
ALTER TABLE `maintenance_requests` DISABLE KEYS;
ALTER TABLE `model_has_roles` DISABLE KEYS;
ALTER TABLE `users` DISABLE KEYS;
ALTER TABLE `vehicle_catalogs` DISABLE KEYS;
ALTER TABLE `vehicle_inventories` DISABLE KEYS;

-- Dumping data for table vms.psm.complaints: ~0 rows (approximately)
INSERT INTO `complaints` (`id`, `created_at`, `updated_at`, `user_id`, `vehicle_inventory_id`, `name`, `detail`, `media`, `status_id`) VALUES
	(1, '2021-08-10 14:44:03', '2021-08-10 14:48:28', 12, 1, 'Example Complaint A', 'Complaint on Example Complaint A', _binary 0x613A313A7B693A303B733A31343A22313632383630363633392E6A7067223B7D, 15),
	(2, '2021-08-10 14:44:36', '2021-08-10 15:07:48', 12, 2, 'Example Complaint B', 'Complaint on Example Complaint B', _binary 0x613A303A7B7D, 15),
	(3, '2021-08-10 14:45:01', '2021-08-10 15:13:40', 12, 6, 'Example Complaint C', 'Complaint on Example Complaint C', _binary 0x613A303A7B7D, 15),
	(4, '2021-08-10 14:46:06', '2021-08-10 14:59:02', 12, 4, 'Example Complaint D', 'Complaint on Example Complaint D', _binary 0x613A313A7B693A303B733A31343A22313632383630363736332E6A7067223B7D, 15),
	(5, '2021-08-10 14:47:10', '2021-08-10 14:47:10', 12, 5, 'Example Complaint E', 'A Description on Complaint E', _binary 0x613A323A7B693A303B733A31343A22313632383630363832372E6A7067223B693A313B733A31343A22313632383630363832342E6A7067223B7D, 13);


-- Dumping data for table vms.psm.maintenance_quotations: ~0 rows (approximately)
INSERT INTO `maintenance_quotations` (`id`, `created_at`, `updated_at`, `maintenance_request_id`, `maintenance_vendor_id`, `user_id`, `date_request`, `date_invoice`, `cost_total`, `status_id`, `file_directory`) VALUES
	(1, '2021-08-10 14:49:31', '2021-08-10 15:06:38', 1, 1, 1, '2021-08-10', '2021-08-10', 300000, 8, NULL),
	(2, '2021-08-10 14:49:40', '2021-08-10 14:49:40', 1, 2, 1, '2021-08-10', NULL, NULL, 5, NULL),
	(3, '2021-08-10 14:50:09', '2021-08-10 15:00:45', 1, 4, 1, '2021-08-08', '2021-08-10', 110000, 7, NULL),
	(4, '2021-08-10 14:50:44', '2021-08-10 15:06:38', 1, 7, 1, '2021-08-05', '2021-08-10', 102000, 8, NULL),
	(5, '2021-08-10 15:08:23', '2021-08-10 15:09:10', 3, 2, 1, '2021-08-01', '2021-08-10', 100000, 8, NULL),
	(6, '2021-08-10 15:08:56', '2021-08-10 15:09:10', 3, 10, 1, '2021-08-03', '2021-08-10', 40000, 7, NULL),
	(7, '2021-08-10 15:14:00', '2021-08-10 15:52:16', 4, 2, 1, '2021-08-01', '2021-08-10', 95000, 7, NULL);

-- Dumping data for table vms.psm.maintenance_quotation_items: ~0 rows (approximately)
INSERT INTO `maintenance_quotation_items` (`id`, `created_at`, `updated_at`, `item`, `quantity`, `price`, `subtotal`, `maintenance_quotation_id`) VALUES
	(1, '2021-08-10 14:49:31', '2021-08-10 14:49:31', 'Item A', 10, 10000, 100000, 1),
	(2, '2021-08-10 14:49:31', '2021-08-10 14:49:31', 'Item B', 2, 100000, 200000, 1),
	(3, '2021-08-10 14:50:09', '2021-08-10 14:50:09', 'Item A', 100, 1000, 100000, 3),
	(4, '2021-08-10 14:50:09', '2021-08-10 14:50:09', 'Item B', 1, 10000, 10000, 3),
	(5, '2021-08-10 14:50:44', '2021-08-10 14:50:44', 'Item A', 10, 10000, 100000, 4),
	(6, '2021-08-10 14:50:44', '2021-08-10 14:50:44', 'Item B1', 1, 2000, 2000, 4),
	(7, '2021-08-10 15:08:23', '2021-08-10 15:08:23', 'Item A', 1, 10000, 10000, 5),
	(8, '2021-08-10 15:08:23', '2021-08-10 15:08:23', 'Item B', 2, 20000, 40000, 5),
	(9, '2021-08-10 15:08:23', '2021-08-10 15:08:23', 'Fees', 1, 50000, 50000, 5),
	(10, '2021-08-10 15:08:56', '2021-08-10 15:08:56', 'Item A', 2, 10000, 20000, 6),
	(11, '2021-08-10 15:08:56', '2021-08-10 15:08:56', 'Charges', 1, 20000, 20000, 6),
	(12, '2021-08-10 15:14:00', '2021-08-10 15:52:01', 'Tayar A', 2, 40000, 80000, 7),
	(13, '2021-08-10 15:14:18', '2021-08-10 15:14:18', 'Balancing', 1, 5000, 5000, 7),
	(14, '2021-08-10 15:16:50', '2021-08-10 15:16:50', 'Upah', 1, 10000, 10000, 7);

-- Dumping data for table vms.psm.maintenance_requests: ~0 rows (approximately)
INSERT INTO `maintenance_requests` (`id`, `created_at`, `updated_at`, `code`, `vehicle_inventory_id`, `maintenance_category_id`, `maintenance_unit_id`, `complaint_id`, `user_id`, `name`, `detail`, `status_id`, `status_note`, `finalize_note`, `finalize_file`) VALUES
	(1, '2021-08-10 14:48:28', '2021-08-10 15:54:29', '21', 1, 1, 2, 1, 1, 'Example Complaint A', 'Complaint on Example Complaint A', 20, 'Approved By Committee A', 'Item OK', _binary 0x613A303A7B7D),
	(2, '2021-08-10 14:59:02', '2021-08-10 14:59:11', '21', 4, 2, 2, 4, 1, 'Example Complaint D', 'Complaint on Example Complaint D', 17, NULL, NULL, NULL),
	(3, '2021-08-10 15:07:48', '2021-08-10 15:09:21', '21', 2, 3, 2, 2, 1, 'Example Complaint B', 'Complaint on Example Complaint B', 19, NULL, NULL, NULL),
	(4, '2021-08-10 15:13:40', '2021-08-10 15:52:51', '21', 6, 4, 2, 3, 1, 'Example Complaint C', 'Complaint on Example Complaint C', 22, 'Only 1 quotation provided', NULL, NULL);


-- Dumping data for table vms.psm.model_has_roles: ~13 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 2),
	(1, 'App\\Models\\User', 3),
	(3, 'App\\Models\\User', 4),
	(3, 'App\\Models\\User', 5),
	(2, 'App\\Models\\User', 6),
	(2, 'App\\Models\\User', 7),
	(2, 'App\\Models\\User', 8),
	(2, 'App\\Models\\User', 9),
	(4, 'App\\Models\\User', 10),
	(4, 'App\\Models\\User', 11),
	(4, 'App\\Models\\User', 12),
	(4, 'App\\Models\\User', 13);


-- Dumping data for table vms.psm.users: ~13 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`, `staff_no`, `nric`, `phone`, `status_id`, `deleted_at`) VALUES
	(2, 'Admin 01', 'admin01@vms.psm', '2021-08-10 14:12:08', '$2y$10$hO2H0gDHPgQJunPazZkrbeOdje21RCNaf/cRkdvGoBRrdTiILowpK', NULL, NULL, NULL, '2021-08-10 14:01:11', '2021-08-10 14:26:18', '00001', '010203040507', NULL, 3, NULL),
	(3, 'Admin 02', 'admin02@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:01:40', '2021-08-10 14:10:29', '00002', '010203040508', NULL, 1, NULL),
	(4, 'Management 01', 'management01@vms.psm', '2021-08-10 14:23:09', '$2y$10$wtrqecXS/io0ah9rb6q6uOX/l9u4tINap5prYM3GAgs5LqvEauITG', NULL, NULL, NULL, '2021-08-10 14:02:16', '2021-08-10 14:26:13', '00003', '010203040509', NULL, 3, NULL),
	(5, 'Management 02', 'management02@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:02:55', '2021-08-10 14:10:41', '00004', '010203040510', NULL, 1, NULL),
	(6, 'Committee 01', 'committee01@vms.psm', '2021-08-10 14:24:17', '$2y$10$MROVp7S8wB75lYno5ESwWu/koL4NL5kZ.36.JN2AiG2N2C38TSvTu', NULL, NULL, NULL, '2021-08-10 14:03:43', '2021-08-10 14:26:06', '00005', '010203040511', NULL, 3, NULL),
	(7, 'Committee 02', 'committee02@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:04:23', '2021-08-10 14:10:50', '00006', '010203040512', NULL, 1, NULL),
	(8, 'Committee 03', 'committee03@vms.psm', NULL, '$2y$10$tkzJLPF8JSe0l0C3DkXZIeb.X9qZNukfdCVqI8Sx7uHkZANuHPAwS', NULL, NULL, NULL, '2021-08-10 14:05:00', '2021-08-10 14:26:42', '00007', '010203040513', NULL, 2, NULL),
	(9, 'Committee 04', 'committee04@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:05:33', '2021-08-10 14:10:59', '00009', '010203040514', NULL, 1, NULL),
	(10, 'Staff 01', 'staff01@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:06:33', '2021-08-10 14:11:03', '00010', '010203040515', NULL, 1, NULL),
	(11, 'Staff 02', 'staff02@vms.psm', NULL, '$2y$10$yYVwsaFbM7cfktEqLLAXu.3OBpPi.OIu/52CHRiGNwiui4gL4ZOc6', NULL, NULL, NULL, '2021-08-10 14:06:56', '2021-08-10 14:27:36', '00011', '010203040516', NULL, 2, NULL),
	(12, 'Staff 03', 'staff03@vms.psm', '2021-08-10 14:28:15', '$2y$10$38NnKTXy334jD3AyqdL76.81pTHK/t8RZ51pU/04zWNRouySC2vmK', NULL, NULL, NULL, '2021-08-10 14:07:32', '2021-08-10 14:28:15', '00012', '010203040517', NULL, 3, NULL),
	(13, 'Staff 04', 'staff04@vms.psm', NULL, NULL, NULL, NULL, NULL, '2021-08-10 14:08:19', '2021-08-10 14:11:19', '00015', '010203040518', NULL, 1, NULL);

-- Dumping data for table vms.psm.vehicle_catalogs: ~0 rows (approximately)
INSERT INTO `vehicle_catalogs` (`id`, `created_at`, `updated_at`, `vehicle_category_id`, `brand`, `model`, `variant`, `year`) VALUES
	(1, '2021-08-10 14:31:26', '2021-08-10 14:31:26', 3, 'Proton', 'Preve', '1.5', '2020'),
	(2, '2021-08-10 14:33:36', '2021-08-10 14:33:36', 1, 'Ford', 'Ranger', '2.2 XLT', '2018'),
	(3, '2021-08-10 14:35:08', '2021-08-10 14:35:08', 1, 'Isuzu', 'D-MAX', '1.9L Single Cab', '2021'),
	(4, '2021-08-10 14:37:10', '2021-08-10 14:37:10', 1, 'Mercedes-Benz', 'AMG G', '63', '2018'),
	(5, '2021-08-10 14:38:29', '2021-08-10 14:38:29', 3, 'Audi', 'A4', 'Sport 2.0 TFSI quattro', '2019'),
	(6, '2021-08-10 14:39:21', '2021-08-10 14:39:21', 3, 'Honda', 'City', '1.5 E', '2020');

-- Dumping data for table vms.psm.vehicle_inventories: ~0 rows (approximately)
INSERT INTO `vehicle_inventories` (`id`, `created_at`, `updated_at`, `vehicle_catalog_id`, `status_id`, `reg_no`, `mileage`, `last_service_date`, `next_service_mileage`, `next_service_date`) VALUES
	(1, '2021-08-10 14:31:56', '2021-08-10 14:44:04', 1, 12, 'ABC001', 10, NULL, 10000, '2021-11-30'),
	(2, '2021-08-10 14:34:00', '2021-08-10 14:44:36', 2, 12, 'ABC002', 10, NULL, 10000, '2022-01-10'),
	(3, '2021-08-10 14:35:36', '2021-08-10 14:35:36', 3, 9, 'ABC003', 10, NULL, 10000, '2022-03-10'),
	(4, '2021-08-10 14:37:30', '2021-08-10 14:46:06', 4, 12, 'ABC100', 900, NULL, 10000, '2022-01-10'),
	(5, '2021-08-10 14:38:48', '2021-08-10 14:47:10', 5, 12, 'ABC200', 900, NULL, 10000, '2021-08-31'),
	(6, '2021-08-10 14:39:54', '2021-08-10 14:45:01', 6, 12, 'ABC456', 11000, NULL, 21000, '2021-09-10');


ALTER TABLE `complaints` ENABLE KEYS;
ALTER TABLE `maintenance_quotations` ENABLE KEYS;
ALTER TABLE `maintenance_quotation_items` ENABLE KEYS;
ALTER TABLE `maintenance_requests` ENABLE KEYS;
ALTER TABLE `model_has_roles` ENABLE KEYS;
ALTER TABLE `users` ENABLE KEYS;
ALTER TABLE `vehicle_catalogs` ENABLE KEYS;
ALTER TABLE `vehicle_inventories` ENABLE KEYS;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

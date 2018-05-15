CREATE TABLE `wp_rg_lead_detail_long` (  `lead_detail_id` bigint(20) unsigned NOT NULL,  `value` longtext COLLATE utf8mb4_unicode_520_ci,  PRIMARY KEY (`lead_detail_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_lead_detail_long` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_rg_lead_detail_long` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

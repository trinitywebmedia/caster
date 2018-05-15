CREATE TABLE `wp_rg_lead_detail` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `lead_id` int(10) unsigned NOT NULL,  `form_id` mediumint(8) unsigned NOT NULL,  `field_number` float NOT NULL,  `value` longtext COLLATE utf8mb4_unicode_520_ci,  PRIMARY KEY (`id`),  KEY `form_id` (`form_id`),  KEY `lead_id` (`lead_id`),  KEY `lead_field_number` (`lead_id`,`field_number`),  KEY `lead_field_value` (`value`(191))) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_lead_detail` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_rg_lead_detail` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

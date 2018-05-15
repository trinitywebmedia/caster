CREATE TABLE `wp_rg_lead_meta` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `form_id` mediumint(8) unsigned NOT NULL DEFAULT '0',  `lead_id` bigint(20) unsigned NOT NULL,  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,  PRIMARY KEY (`id`),  KEY `meta_key` (`meta_key`(191)),  KEY `lead_id` (`lead_id`),  KEY `form_id_meta_key` (`form_id`,`meta_key`(191))) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_lead_meta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_rg_lead_meta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

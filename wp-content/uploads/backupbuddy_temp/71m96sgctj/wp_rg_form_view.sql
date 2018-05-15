CREATE TABLE `wp_rg_form_view` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `form_id` mediumint(8) unsigned NOT NULL,  `date_created` datetime NOT NULL,  `ip` char(15) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `count` mediumint(8) unsigned NOT NULL DEFAULT '1',  PRIMARY KEY (`id`),  KEY `date_created` (`date_created`),  KEY `form_id` (`form_id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_form_view` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_rg_form_view` VALUES('1', '1', '2018-04-12 14:37:22', '', '1');
INSERT INTO `wp_rg_form_view` VALUES('2', '1', '2018-05-04 17:05:05', '', '1');
/*!40000 ALTER TABLE `wp_rg_form_view` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

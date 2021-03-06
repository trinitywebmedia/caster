CREATE TABLE `wp_termmeta` (  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,  PRIMARY KEY (`meta_id`),  KEY `term_id` (`term_id`),  KEY `meta_key` (`meta_key`(191))) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_termmeta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_termmeta` VALUES('1', '2', 'headline', '');
INSERT INTO `wp_termmeta` VALUES('2', '2', 'intro_text', '');
INSERT INTO `wp_termmeta` VALUES('3', '2', 'display_title', '0');
INSERT INTO `wp_termmeta` VALUES('4', '2', 'display_description', '0');
INSERT INTO `wp_termmeta` VALUES('5', '2', 'doctitle', '');
INSERT INTO `wp_termmeta` VALUES('6', '2', 'description', '');
INSERT INTO `wp_termmeta` VALUES('7', '2', 'keywords', '');
INSERT INTO `wp_termmeta` VALUES('8', '2', 'layout', '');
INSERT INTO `wp_termmeta` VALUES('9', '2', 'noindex', '0');
INSERT INTO `wp_termmeta` VALUES('10', '2', 'nofollow', '0');
INSERT INTO `wp_termmeta` VALUES('11', '2', 'noarchive', '0');
/*!40000 ALTER TABLE `wp_termmeta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

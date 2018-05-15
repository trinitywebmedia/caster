CREATE TABLE `wp_usermeta` (  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,  PRIMARY KEY (`umeta_id`),  KEY `user_id` (`user_id`),  KEY `meta_key` (`meta_key`(191))) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_usermeta` VALUES('1', '1', 'nickname', 'wpengine');
INSERT INTO `wp_usermeta` VALUES('2', '1', 'first_name', '');
INSERT INTO `wp_usermeta` VALUES('3', '1', 'last_name', '');
INSERT INTO `wp_usermeta` VALUES('4', '1', 'description', 'This is the \"wpengine\" admin user that our staff uses to gain access to your admin area to provide support and troubleshooting. It can only be accessed by a button in our secure log that auto generates a password and dumps that password after the staff member has logged in. We have taken extreme measures to ensure that our own user is not going to be misused to harm any of our clients sites.');
INSERT INTO `wp_usermeta` VALUES('5', '1', 'rich_editing', 'true');
INSERT INTO `wp_usermeta` VALUES('6', '1', 'syntax_highlighting', 'true');
INSERT INTO `wp_usermeta` VALUES('7', '1', 'comment_shortcuts', 'false');
INSERT INTO `wp_usermeta` VALUES('8', '1', 'admin_color', 'fresh');
INSERT INTO `wp_usermeta` VALUES('9', '1', 'use_ssl', '0');
INSERT INTO `wp_usermeta` VALUES('10', '1', 'show_admin_bar_front', 'true');
INSERT INTO `wp_usermeta` VALUES('11', '1', 'locale', '');
INSERT INTO `wp_usermeta` VALUES('12', '1', 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}');
INSERT INTO `wp_usermeta` VALUES('13', '1', 'wp_user_level', '10');
INSERT INTO `wp_usermeta` VALUES('14', '1', 'dismissed_wp_pointers', '');
INSERT INTO `wp_usermeta` VALUES('15', '1', 'show_welcome_panel', '1');
INSERT INTO `wp_usermeta` VALUES('16', '2', 'nickname', 'casterarticles');
INSERT INTO `wp_usermeta` VALUES('17', '2', 'first_name', '');
INSERT INTO `wp_usermeta` VALUES('18', '2', 'last_name', '');
INSERT INTO `wp_usermeta` VALUES('19', '2', 'description', '');
INSERT INTO `wp_usermeta` VALUES('20', '2', 'rich_editing', 'true');
INSERT INTO `wp_usermeta` VALUES('21', '2', 'syntax_highlighting', 'true');
INSERT INTO `wp_usermeta` VALUES('22', '2', 'comment_shortcuts', 'false');
INSERT INTO `wp_usermeta` VALUES('23', '2', 'admin_color', 'fresh');
INSERT INTO `wp_usermeta` VALUES('24', '2', 'use_ssl', '0');
INSERT INTO `wp_usermeta` VALUES('25', '2', 'show_admin_bar_front', 'true');
INSERT INTO `wp_usermeta` VALUES('26', '2', 'locale', '');
INSERT INTO `wp_usermeta` VALUES('27', '2', 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}');
INSERT INTO `wp_usermeta` VALUES('28', '2', 'wp_user_level', '10');
INSERT INTO `wp_usermeta` VALUES('29', '2', 'default_password_nag', '');
INSERT INTO `wp_usermeta` VALUES('30', '2', 'session_tokens', 'a:2:{s:64:\"01762d6044c21ed2a7704702875bda98c9e979fa3596bfb3936112415bac372c\";a:4:{s:10:\"expiration\";i:1526160990;s:2:\"ip\";s:11:\"196.52.2.19\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36\";s:5:\"login\";i:1525988190;}s:64:\"0e630344358e0dc4deab56b6ff7d2ebc23b91ca9ba5a483918b17cb78dd1c723\";a:4:{s:10:\"expiration\";i:1526163244;s:2:\"ip\";s:14:\"76.167.116.111\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36\";s:5:\"login\";i:1525990444;}}');
INSERT INTO `wp_usermeta` VALUES('31', '2', 'wp_dashboard_quick_press_last_post_id', '34');
INSERT INTO `wp_usermeta` VALUES('32', '2', 'community-events-location', 'a:1:{s:2:\"ip\";s:12:\"76.167.116.0\";}');
INSERT INTO `wp_usermeta` VALUES('33', '2', 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}');
INSERT INTO `wp_usermeta` VALUES('34', '2', 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:\"add-post_tag\";}');
INSERT INTO `wp_usermeta` VALUES('35', '2', 'wp_user-settings', 'libraryContent=browse&editor=html');
INSERT INTO `wp_usermeta` VALUES('36', '2', 'wp_user-settings-time', '1523356583');
INSERT INTO `wp_usermeta` VALUES('37', '2', 'dismissed_wp_pointers', 'text_widget_paste_html,text_widget_custom_html,theme_editor_notice');
INSERT INTO `wp_usermeta` VALUES('38', '1', 'googleplus', '');
INSERT INTO `wp_usermeta` VALUES('39', '2', 'nav_menu_recently_edited', '2');
INSERT INTO `wp_usermeta` VALUES('40', '2', 'gform_recent_forms', 'a:1:{i:0;s:1:\"1\";}');
INSERT INTO `wp_usermeta` VALUES('41', '3', 'nickname', 'donnfelker');
INSERT INTO `wp_usermeta` VALUES('42', '3', 'first_name', 'Donn');
INSERT INTO `wp_usermeta` VALUES('43', '3', 'last_name', 'Felker');
INSERT INTO `wp_usermeta` VALUES('44', '3', 'description', 'Donn Felker is the founder of <a href=\"https://caster.io\">Caster.IO</a>. He\'s is a best selling author in mobile development and he also co-hosts the <a href=\"http://www.fragmentedpodcast.com\">Fragmented Podcast - a Podcast for Android Developers</a>. Most recently he\'s been diving deep into blockchain with a focus on Ethereum and Solidity. Follow him on <a href=\"http://www.twitter.com/donnfelker\">Twitter</a>, <a href=\"https://www.instagram.com/donnfelker\">Instagram</a> or visit <a href=\"http://www.donnfelker.com\">his site</a>.');
INSERT INTO `wp_usermeta` VALUES('45', '3', 'rich_editing', 'true');
INSERT INTO `wp_usermeta` VALUES('46', '3', 'syntax_highlighting', 'true');
INSERT INTO `wp_usermeta` VALUES('47', '3', 'comment_shortcuts', 'false');
INSERT INTO `wp_usermeta` VALUES('48', '3', 'admin_color', 'fresh');
INSERT INTO `wp_usermeta` VALUES('49', '3', 'use_ssl', '0');
INSERT INTO `wp_usermeta` VALUES('50', '3', 'show_admin_bar_front', 'true');
INSERT INTO `wp_usermeta` VALUES('51', '3', 'locale', '');
INSERT INTO `wp_usermeta` VALUES('52', '3', 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}');
INSERT INTO `wp_usermeta` VALUES('53', '3', 'wp_user_level', '10');
INSERT INTO `wp_usermeta` VALUES('54', '3', 'dismissed_wp_pointers', 'text_widget_custom_html');
INSERT INTO `wp_usermeta` VALUES('55', '3', 'genesis_admin_menu', '1');
INSERT INTO `wp_usermeta` VALUES('56', '3', 'genesis_seo_settings_menu', '1');
INSERT INTO `wp_usermeta` VALUES('57', '3', 'genesis_import_export_menu', '1');
INSERT INTO `wp_usermeta` VALUES('58', '3', 'genesis_author_box_single', '1');
INSERT INTO `wp_usermeta` VALUES('59', '3', 'genesis_author_box_archive', '1');
INSERT INTO `wp_usermeta` VALUES('60', '3', 'headline', '');
INSERT INTO `wp_usermeta` VALUES('61', '3', 'intro_text', '');
INSERT INTO `wp_usermeta` VALUES('62', '3', 'doctitle', '');
INSERT INTO `wp_usermeta` VALUES('63', '3', 'meta_description', '');
INSERT INTO `wp_usermeta` VALUES('64', '3', 'meta_keywords', '');
INSERT INTO `wp_usermeta` VALUES('65', '3', 'noindex', '');
INSERT INTO `wp_usermeta` VALUES('66', '3', 'nofollow', '');
INSERT INTO `wp_usermeta` VALUES('67', '3', 'noarchive', '');
INSERT INTO `wp_usermeta` VALUES('68', '3', 'layout', '');
INSERT INTO `wp_usermeta` VALUES('69', '3', 'googleplus', '');
INSERT INTO `wp_usermeta` VALUES('70', '3', 'session_tokens', 'a:1:{s:64:\"f89e2fa7a4ad99e60937e0dd806d2dbac9638daf223a67b969b8d10fb9251f65\";a:4:{s:10:\"expiration\";i:1523550019;s:2:\"ip\";s:13:\"73.33.227.160\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36\";s:5:\"login\";i:1523377219;}}');
INSERT INTO `wp_usermeta` VALUES('71', '3', 'gform_recent_forms', 'a:1:{i:0;s:1:\"1\";}');
INSERT INTO `wp_usermeta` VALUES('72', '3', 'wp_dashboard_quick_press_last_post_id', '24');
INSERT INTO `wp_usermeta` VALUES('73', '3', 'community-events-location', 'a:1:{s:2:\"ip\";s:11:\"73.33.227.0\";}');
INSERT INTO `wp_usermeta` VALUES('74', '3', 'wp_user-settings', 'libraryContent=browse&editor=html');
INSERT INTO `wp_usermeta` VALUES('75', '3', 'wp_user-settings-time', '1523379592');
INSERT INTO `wp_usermeta` VALUES('76', '4', 'nickname', 'craigrussell');
INSERT INTO `wp_usermeta` VALUES('77', '4', 'first_name', 'Craig');
INSERT INTO `wp_usermeta` VALUES('78', '4', 'last_name', 'Russell');
INSERT INTO `wp_usermeta` VALUES('79', '4', 'description', '');
INSERT INTO `wp_usermeta` VALUES('80', '4', 'rich_editing', 'true');
INSERT INTO `wp_usermeta` VALUES('81', '4', 'syntax_highlighting', 'true');
INSERT INTO `wp_usermeta` VALUES('82', '4', 'comment_shortcuts', 'false');
INSERT INTO `wp_usermeta` VALUES('83', '4', 'admin_color', 'fresh');
INSERT INTO `wp_usermeta` VALUES('84', '4', 'use_ssl', '0');
INSERT INTO `wp_usermeta` VALUES('85', '4', 'show_admin_bar_front', 'true');
INSERT INTO `wp_usermeta` VALUES('86', '4', 'locale', '');
INSERT INTO `wp_usermeta` VALUES('87', '4', 'wp_capabilities', 'a:1:{s:6:\"author\";b:1;}');
INSERT INTO `wp_usermeta` VALUES('88', '4', 'wp_user_level', '2');
INSERT INTO `wp_usermeta` VALUES('89', '4', 'dismissed_wp_pointers', '');
INSERT INTO `wp_usermeta` VALUES('90', '3', 'closedpostboxes_post', 'a:0:{}');
INSERT INTO `wp_usermeta` VALUES('91', '3', 'metaboxhidden_post', 'a:7:{i:0;s:11:\"postexcerpt\";i:1;s:13:\"trackbacksdiv\";i:2;s:10:\"postcustom\";i:3;s:16:\"commentstatusdiv\";i:4;s:11:\"commentsdiv\";i:5;s:7:\"slugdiv\";i:6;s:9:\"authordiv\";}');
INSERT INTO `wp_usermeta` VALUES('92', '3', 'meta-box-order_post', 'a:3:{s:4:\"side\";s:51:\"submitdiv,categorydiv,tagsdiv-post_tag,postimagediv\";s:6:\"normal\";s:159:\"genesis_inpost_seo_box,genesis_inpost_layout_box,postexcerpt,trackbacksdiv,postcustom,commentstatusdiv,commentsdiv,slugdiv,authordiv,genesis_inpost_scripts_box\";s:8:\"advanced\";s:0:\"\";}');
INSERT INTO `wp_usermeta` VALUES('93', '3', 'screen_layout_post', '2');
INSERT INTO `wp_usermeta` VALUES('94', '4', 'default_password_nag', '');
INSERT INTO `wp_usermeta` VALUES('95', '4', 'session_tokens', 'a:1:{s:64:\"8fb2bd464a54d26d4d4fb10a96a7f3989d6dacf723100edb1d4ddbf10335b3ca\";a:4:{s:10:\"expiration\";i:1523617627;s:2:\"ip\";s:14:\"86.178.209.219\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36\";s:5:\"login\";i:1523444827;}}');
INSERT INTO `wp_usermeta` VALUES('96', '4', 'wp_dashboard_quick_press_last_post_id', '30');
INSERT INTO `wp_usermeta` VALUES('97', '4', 'community-events-location', 'a:1:{s:2:\"ip\";s:12:\"86.178.209.0\";}');
INSERT INTO `wp_usermeta` VALUES('98', '4', 'wp_user-settings', 'libraryContent=browse&imgsize=full&align=center');
INSERT INTO `wp_usermeta` VALUES('99', '4', 'wp_user-settings-time', '1523502410');
INSERT INTO `wp_usermeta` VALUES('100', '4', 'closedpostboxes_post', 'a:1:{i:0;s:11:\"categorydiv\";}');
INSERT INTO `wp_usermeta` VALUES('101', '4', 'metaboxhidden_post', 'a:5:{i:0;s:11:\"postexcerpt\";i:1;s:13:\"trackbacksdiv\";i:2;s:10:\"postcustom\";i:3;s:16:\"commentstatusdiv\";i:4;s:7:\"slugdiv\";}');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
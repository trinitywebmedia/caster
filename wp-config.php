<?php
# Database Configuration
define( 'DB_NAME', 'wp_casterarticles' );
define( 'DB_USER', 'casterarticles' );
define( 'DB_PASSWORD', 'siQJiI42ZuoyOiOs19vY' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'gG8z*HZ=B?s6U;$0NHtwR|_.iUKn2>vn8yb2=-MLF; MH;(|lYEIP>PhIgk+*-qf');
define('SECURE_AUTH_KEY',  '55>:be582)>n>v0b6;;{5n$n+|<Yn~;eFPs[sKTszIycG<ZZY<vP{B*.i[ucuaJK');
define('LOGGED_IN_KEY',    'J(t7uxB,ezg94pUx_1@5MOf1uRJ#gOKsW_|$)Wv.fa&S8sFg`l+t1mvSk%]ZpxIk');
define('NONCE_KEY',        '7KTXGCT^vb7Nzgx)k+8lK&cMti|aC-f)KE+CVvXoHoN;+]`Trif -T&*|$<.cc`K');
define('AUTH_SALT',        '+M#cu9R?OoHW{|t[g;$^Y 2/BpL2>U0`)4TbLPYfos{C4[s%wo@zP(`}<nI^~[n~');
define('SECURE_AUTH_SALT', '/kwJ|z}iB#]S%N-+:0F1H:hfY6Ii||`*C3Rt#=u*+E^~5cW24,n#cZ4Y?pT+vIT,');
define('LOGGED_IN_SALT',   'Htv,,6of?:XtBG>#=V/o?4K$z=oI+Mq0cyLnng7GFZ4Q#4R>2T:yV@RYL`Q)2zqR');
define('NONCE_SALT',       '<}|#JC**e]M2GhI}|0cg@p5~Z$;-}?1+y(K#$xH1I%BYr>$xL7$^:@b`3IHsT4By');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'casterarticles' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '16ce58bfb42a4b9f027b72eda96de950550bae36' );

define( 'WPE_CLUSTER_ID', '100360' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'articles.caster.io', 1 => 'casterarticles.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-100360', );

$wpe_special_ips=array ( 0 => '104.198.106.192', );

$wpe_ec_servers=array ( );

$wpe_netdna_domains=array ( 0 =>  array ( 'zone' => '3ai6dk2qtj0i1rwt5z2ff5lb', 'match' => 'articles.caster.io', 'enabled' => true, ), );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}

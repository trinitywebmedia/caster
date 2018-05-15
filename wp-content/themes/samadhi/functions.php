<?php
/**
 * Samadhi.
 *
 * This file adds functions to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

// Starts the engine.
require_once( get_template_directory() . '/lib/init.php' );

// Sets Localization.
load_child_theme_textdomain( 'samadhi', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'samadhi' ) );

// Includes bootstrap inclusion function.
include( get_stylesheet_directory() . '/include/bootstrap_class_inclusion.php' );

// Adds custom meta boxes.
require_once( get_stylesheet_directory() . '/include/cpt/super-cpt.php' );
require_once( get_stylesheet_directory() . '/include/cpt/zp_cpt.php' );

// Registers required plugins via TGM Plugin Activation.
 require_once ( get_stylesheet_directory() . '/include/tgm-plugin-activation/register-required-plugins.php' );

// Includes CMB2 config functions.
require_once ( get_stylesheet_directory() . '/include/metabox/cmb2-functions.php' );

// Includes ZP custom loop.
require_once ( get_stylesheet_directory() . '/include/zp_custom_loop.php' );

// Includes additional theme functions.
require_once ( get_stylesheet_directory() . '/include/theme_functions.php' );

// Includes theme customizer.
require_once( get_stylesheet_directory() . '/include/customizer/customizer.php' );

// Include section composer functions.
require_once (  get_stylesheet_directory( ) . '/include/section_composer.php' );

// Includes widgets.
require_once( get_stylesheet_directory() . '/include/widgets/class-carousel-widget.php' );
require_once( get_stylesheet_directory() . '/include/widgets/class-post-box-widget.php' );
require_once( get_stylesheet_directory() . '/include/widgets/class-post-slider-widget.php' );
require_once( get_stylesheet_directory() . '/include/widgets/class-post-sidebar.php' );

// Defines child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Samadhi' );
define( 'CHILD_THEME_URL', 'http://demo.zigzagpress.com/samadhi/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Adds title tag support.
add_theme_support( 'title-tag' );

// Adds mobile viewport support.
add_theme_support( 'genesis-responsive-viewport' );


// Adds support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array( 'footer-widgets' ) );

// Adds support for post formats.
add_theme_support( 'post-formats', array( ) );

// Adds 3 footer widget areas.
add_theme_support( 'genesis-footer-widgets', 3 );

// Repositions Primary Navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );

// Repositions Secondary Navigation.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Remove secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'samadhi' ) ) );

// Unregisters secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes the header right widget area
unregister_sidebar( 'header-right' );

// Adds after entry widget area.
add_theme_support( 'genesis-after-entry-widget-area' ); 

// Unregisters layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Adds Tinymice Editor styles.
add_action( 'after_setup_theme', 'zp_add_editor_styles' );
function zp_add_editor_styles() {

	add_editor_style( get_stylesheet_directory_uri() . '/css/zp_editor_style.css' );

}

// Enqueues Google Font
add_action( 'wp_enqueue_scripts', 'zp_google_font', 5 );
function zp_google_font() {

	$fnt = '';
	$query_args = array();

	if ( get_theme_mod( 'body_font' ) ||  get_theme_mod( 'head_font' ) ||  get_theme_mod( 'meta_font' ) ) {

		$fnt = $fnt_wt = '';
		$font_option = array( 'body_font', 'head_font', 'meta_font' );
		$font_weight_option = array( 'body_font_weight', 'head_font_weight', 'meta_font_weight' );
		$i = 0;

		while ( $i < count( $font_option ) ) {
			if ( get_theme_mod( $font_option[$i] ) ) {
				$font_family = str_replace( ' ', '+', get_theme_mod( $font_option[$i] ) );
				$font_style = ( get_theme_mod( $font_weight_option[$i] ) != '' ) ? get_theme_mod( $font_weight_option[$i] ) : '';

				if ( $i != 4 ) {
					$fnt = $fnt . $font_family . ':' . $font_style . '|';
				} else {
					$fnt = $fnt . $font_family . ':' . $font_style;
				}

			}
			$i++;
		}

		$query_args = array(
			'family' => $fnt,
		);
	}

	if ( get_theme_mod( 'body_font' ) ) {
		$query_args = $query_args;
	} elseif ( get_theme_mod( 'head_font' ) ) {
		$query_args = $query_args;
	}	elseif ( get_theme_mod( 'meta_font' ) ) {
		$query_args = $query_args;
	}
	 else {
		$query_args = array(
			'family' => apply_filters( 'zp_default_font', 'Work+Sans:300,400,500,600,700|Prata' ),
		);
	}

	wp_enqueue_style( 'zp_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

}

// Adds additional stylesheets.
add_action( 'wp_enqueue_scripts', 'zp_print_styles' );
function zp_print_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'bootstrap_css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'ionicons_css', get_stylesheet_directory_uri() . '/css/ionicons.min.css' );
	wp_enqueue_style( 'magnific_popup', get_stylesheet_directory_uri() . '/css/magnific-popup.min.css' );
	wp_enqueue_style( 'app_css', get_stylesheet_directory_uri() . '/css/app.min.css' );
	
	wp_register_style( 'jquery-swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css' );
	wp_enqueue_style( 'owl-carousel-css', get_stylesheet_directory_uri( ) . '/css/owl.carousel.css' );

	// Adds Mobile stylesheet.
	wp_register_style( 'mobile', get_stylesheet_directory_uri() . '/css/mobile.css' );
	wp_enqueue_style( 'mobile' );

	// Adds custom stylesheet.
	wp_register_style( 'custom', get_stylesheet_directory_uri() . '/custom.css' );
	wp_enqueue_style( 'custom' );

}

// Enqueues theme scripts.
add_action( 'wp_enqueue_scripts', 'zp_theme_js' );
function zp_theme_js() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap.min', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', '', '3.0', true );
	wp_enqueue_script( 'jquery.fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', '', '1.0.3', true );
	wp_enqueue_script( 'jquery_scrollTo_js', get_stylesheet_directory_uri() . '/js/jquery.ScrollTo.min.js', '', '1.4.3.1', true );
	wp_enqueue_script( 'jquery.isotope.min', get_stylesheet_directory_uri() . '/js/jquery.isotope.min.js', '', '2.2.2', true  );
	wp_enqueue_script( 'magnific_popup', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.js', '', '1.0', true );
	wp_enqueue_script( 'imageloaded', get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js', '', '4.1.1', true );
	wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', '', '2.0.0', true  );
	wp_enqueue_script( 'custom_js', get_stylesheet_directory_uri() . '/js/custom.js', '', '1.0', true );
	wp_register_script( 'zp_post_load_more', get_stylesheet_directory_uri() . '/js/zp_post_load_more.js', '', time(), true );
	wp_register_script( 'jquery-swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/js/swiper.min.js','', time(), true );
	
}

// Enqueues admin style and scripts.
add_action( 'admin_enqueue_scripts', 'zp_admin_scripts', 999 );
function zp_admin_scripts() {
	wp_register_script( 'zp-admin-js', get_stylesheet_directory_uri() . '/include/metabox/assets/js/custom-admin.js', '', '', true );
	wp_enqueue_style( 'zp-admin-css', get_stylesheet_directory_uri() . '/include/metabox/assets/css/custom-admin.css' );
	$passed_data = array( 'expandedString' =>  esc_html__( '[-] Show less options', 'samadhi' ), 'closedString' => esc_html__( '[+] Show more options', 'samadhi' ) );
	wp_localize_script( 'zp-admin-js', 'passed_data', $passed_data );
	wp_enqueue_script( array( 'jquery-ui-sortable', 'zp-admin-js' ) );
}

// Sets Jetpack Tiled Galleries width.
if ( ! isset( $content_width ) ) {
	$content_width = 702;
}

// Modifies footer credits.
add_filter( 'genesis_footer_creds_text', 'zp_footer_creds_text' );
function zp_footer_creds_text() {
	
	$cred_text = '<div class="creds"><p>' . __( 'Copyright', 'samadhi' ) . ' &copy; ' . date('Y') . ' &middot; ' . get_bloginfo( 'name' ) . ' &middot; ' . get_bloginfo( 'description' ) . ' &middot; BY <a href="https://zigzagpress.com" target="_blank">ZIGZAGPRESS</a></p></div>';

	// Modifies left footer area.
	$footer_logo_image = get_theme_mod( 'footer_logo' );
	if ( $footer_logo_image ) {
		$footer_logo = '<img src="' . $footer_logo_image . '" alt="' . get_bloginfo( 'name' ) . '"  />';
	} else {
		$footer_logo = '<h2 class="footer_logo">' . get_bloginfo() . '</h2>';
	}

	echo '<div class="zp_footer_left col-md-12">';
	echo '<div class="zp_footer_logo_area">' . apply_filters( 'zp_footer_logo', $footer_logo, $footer_logo_image ) . '</div>';
	echo '</div>';

	// Modifies right footer area.
	//echo '<div class="zp_footer_right col-md-12">';
	//if ( get_theme_mod( 'footer_text' ) ) {
		//echo '<div class="creds">' . get_theme_mod( 'footer_text' ) . '</div>';
	//} else {
		echo $cred_text;
	//}
	echo '</div>';

}

// Enables shortcode in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

// Removes post images.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Adds theme logo support.
add_theme_support( 'custom-logo', array() );

// Filters Genesis site title to enable logo.
add_action( 'get_header', 'zp_custom_logo_option' );
function zp_custom_logo_option() {

	if ( has_custom_logo() ) {
		// Removes site title and site description.
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		// Displays new custom logo.
		add_action( 'genesis_site_title', 'zp_custom_logo' );
	}

}

// Adds custom logo function.
function zp_custom_logo() {

	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

// Modifies read more text.
add_filter( 'excerpt_more', 'zp_read_more_link' );
add_filter( 'get_the_content_more_link', 'zp_read_more_link' );
add_filter( 'the_content_more_link', 'zp_read_more_link' );
function zp_read_more_link() {

	$readmore_text = get_theme_mod( 'read_more' );	
	$readmore_text = ( $readmore_text != '' ) ? $readmore_text : __( 'Read More ', 'samadhi' );		
    return '&hellip; <div><a class="more-link" href="' . get_permalink() . '">' . $readmore_text . '</a></div>';

}

// Reduces excerpt length
add_filter( 'excerpt_length', 'zp_excerpt_length', 999 );
function zp_excerpt_length( $length ) {
	return 35;
}

// Repositions post info.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

// Adds Contact Form 7 shortcode support.
add_filter( 'wpcf7_form_elements', 'zp_wpcf7_form_elements' );
function zp_wpcf7_form_elements( $form ) {

	$form = do_shortcode( $form );
	return $form;

}

// Add image sizes.
add_image_size( 'blog_gallery', 786, 524, true );
add_image_size( 'col2' , 540 );
add_image_size( 'col3', 408 );
add_image_size( 'col4' , 255 );
add_image_size( 'related_col2' , 555 );
add_image_size( 'related_col3', 360 );
add_image_size( 'related_col4' , 262 );
add_image_size( 'related_post', 217, 217, true );
add_image_size( 'blog-archive', 863, 575, true );
add_image_size( 'post-box', 326, 245, true );
add_image_size( 'post-box-top', 703, 528, true );
add_image_size( 'post-small', 413, 275, true );
add_image_size( 'post-slider', 1200, 600, true );
add_image_size( 'post-sidebar', 300, 300, true );

// Adds Infinite Scroll support.
add_theme_support( 'infinite-scroll', array(
	'container'      => 'content_scrolling',
	'render'         => 'zp_blog_loop',
	'type'           => 'scroll',
	'footer_widgets' => false,
	'footer'         => 'zp-footer',
) );

// Removes post nav when infinite scroll is active.
add_action ( 'genesis_after_entry', 'zp_remove_pagination' );
function zp_remove_pagination() {

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
	}

}

// Adds Nav attributes to top link.
add_action( 'genesis_before_footer','zp_add_top_link' );
function zp_add_top_link(){

	echo '<a href="#top" id="top-link" class="to_top" >Up <i class="ion ion-ios-arrow-thin-right"></i></a>';

}

// Enable Woocommerce support
add_action( 'after_setup_theme', 'zp_woocommerce_support' );
function zp_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

// Removes related products.
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Adds woocommerce single product gallery support
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

// Changes number of products per row to 3.
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 3; // Defines 3 products per row.
	}
}

// Sets a sidebar specific to shop and product pages.
add_action( 'get_header', 'zp_shop_sidebar' );
function zp_shop_sidebar() {

	if ( class_exists( 'Woocommerce' ) ) {
		if ( is_shop() || is_singular( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
			remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
			add_action( 'genesis_after_content', 'zp_get_shop_sidebar' );
		}
	}

}

// Adds a sidebar for shop and product pages.
function zp_get_shop_sidebar() {

	$site_layout = genesis_site_layout();

	if ( 'content-sidebar' == $site_layout || 'sidebar-content' == $site_layout ) {
	?>
	<aside class="sidebar sidebar-primary widget-area" role="complementary" aria-label="Primary Sidebar" itemscope="" itemtype="http://schema.org/WPSideBar">
	<?php
		genesis_structural_wrap( 'sidebar' );
		do_action( 'genesis_before_sidebar_widget_area' );
		dynamic_sidebar( 'shop-sidebar' );
		do_action( 'genesis_after_sidebar_widget_area' );
		genesis_structural_wrap( 'sidebar', 'close' );
	?>
	</aside>
	<?php 
	}

}

// Replaces search text with icon.
add_filter( 'genesis_search_button_text', 'zp_search_button_icon' );
function zp_search_button_icon( $text ) {

	return esc_attr( '&#xf179;' );

}

// Displays 12 products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// Registers Widget Areas.
genesis_register_sidebar( array(
	'id'          => 'portfolio-sidebar',
	'name'        => __( 'Portfolio Sidebar', 'samadhi' ),
	'description' => __( 'This is the sidebar for the portfolio single page.', 'samadhi' ),
));
genesis_register_sidebar( array(
	'id'          => 'shop-sidebar',
	'name'        => __( 'Shop Sidebar', 'samadhi' ),
	'description' => __( 'This the sidebar for the shop and product pages.', 'samadhi' ),
) );

genesis_register_sidebar( array(
	'id'          => 'home-before-loop',
	'name'        => __( 'Magazine Before Loop', 'samadhi' ),
	'description' => __( 'This is a widget area before loop in the homepage.', 'samadhi' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widget',
	'name'        => __( 'Magazine Widget', 'samadhi' ),
	'description' => __( 'This is the homepage widget area.', 'samadhi' ),
));
genesis_register_sidebar( array(
	'id'          => 'home-left',
	'name'        => __( 'Magazine Left Content', 'samadhi' ),
	'description' => __( 'This is the homepage left content widget area.', 'samadhi' ),
));

genesis_register_sidebar( array(
	'id'          => 'home-right',
	'name'        => __( 'Magazine Right Content', 'samadhi' ),
	'description' => __( 'This is the homepage right content widget area.', 'samadhi' ),
));


// Add before header navigation
add_action( 'genesis_before_header', 'zp_before_header_nav_open' );
function zp_before_header_nav_open(){
	echo '<div class="zp_before_header_nav"><div class="zp_before_header_nav_wrap">';
}

// Adds mobile menu
add_action( 'genesis_before_header', 'zp_mobile_nav', 12 );
function zp_mobile_nav() {

		echo '<div class="mobile_menu navbar-default" role="navigation"><button type="button" class="navbar-toggle" >';
		echo '<span class="icon-bar icon-first"></span><span class="icon-bar icon-second"></span><span class="icon-bar icon-third"></span>';
		echo '</button><span class="mobile_menu_label">' . __( 'MENU', 'samadhi' ) . '</span></div>';

}

// Reposition Primary Nav
add_action( 'genesis_before_header', 'genesis_do_nav', 13 );

add_action( 'genesis_before_header', 'zp_before_header_nav_close', 15 );
function zp_before_header_nav_close(){
	echo '</div></div>';
}

// Add before header nav search bar
add_action( 'genesis_before_header', 'zp_before_header_search' );
function zp_before_header_search(){

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$form_dropdown = '<div class="search_form_dropdown">' . $search . '<span class="zp_search_close"><span class="ion-ios-close-empty"></span></span></div>';

	echo '<div class="zp_before_header_search right search"><span class="zp_search_icon"><i class="ion-ios-search"></i></span>'.$form_dropdown.'</div>';
}

// Updates search place holder
add_filter( 'genesis_search_text', 'themeprefix_search_button_text' );
function themeprefix_search_button_text( $text ) {
	return __( 'Search', 'samadhi' );
}

// Reposition portfolio related items
add_action( 'genesis_after_content', 'zp_portfolio_related' );
function zp_portfolio_related(){
	if( is_singular( 'portfolio' ) ){
		echo '<div class="single_portfolio_related">';
		echo zp_related_portfolio( -1, 3 );
		echo '</div>';
	}
}

//Register stick nav
add_action( 'genesis_register_nav_menus', 'zp_register_mobile_nav' );
function zp_register_mobile_nav(){
	register_nav_menus( array(
		'mobile_nav' => __( 'Mobile Menu', 'samadhi' )
	) );
}

// Adds sliding navigation wrap open
add_action( 'genesis_before_header', 'zp_sliding_wrap_open', 9 );
function zp_sliding_wrap_open(){
	echo '<div class="sliding_nav"><div class="sliding_close"><span class="dashicons dashicons-no-alt"></span></div><div class="sliding_nav_wrap">';
}

// Adds sticky nav
add_action( 'genesis_before_header', 'zp_add_mobile_nav', 9 );
function zp_add_mobile_nav(){
	//echo '<div class="zp_sticky_nav" style="display: none;">';
		genesis_nav_menu( array( 'theme_location' => 'mobile_nav', 'echo' => '0' ) );
	//echo '</div>';
}

// Adds sliding navigation wrap close
add_action( 'genesis_before_header', 'zp_sliding_wrap_close', 9 );
function zp_sliding_wrap_close(){
	echo '</div></div>';
}

// Adds body class
add_filter( 'body_class', 'zp_add_body_class' );
function zp_add_body_class( $classes ) {
	// get theme option
	$option = get_theme_mod( 'menu_display' );

	if( $option == 'show' ){
		$classes[] = 'desktop_menu';
	}

	// Set default body class
	$classes[] = 'header_two';

    return $classes;
}

/**
 * Includes Custom Theme Functions.
 *
 * Write all your custom functions in this file.
 */ 
require_once( get_stylesheet_directory() . '/include/custom_functions.php' );
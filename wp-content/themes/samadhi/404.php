<?php
/**
 * Samadhi.
 *
 * This file adds the error/404 page template to the Samadhi Theme.
 *
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

// Forces fullwidth layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Removes default template markup.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_nav', 11 );
remove_action( 'genesis_header', 'zp_mobile_nav' );
remove_action( 'genesis_footer', 'zp_footer_creds_text' );
remove_action( 'genesis_header', 'zp_header_cart' );
remove_action( 'genesis_header', 'zp_header_search' );

remove_action( 'genesis_before_header', 'zp_before_header_nav_open' );
remove_action( 'genesis_before_header', 'zp_mobile_nav', 12 );
remove_action( 'genesis_before_header', 'genesis_do_nav', 13 );
remove_action( 'genesis_before_header', 'zp_before_header_search' );
remove_action( 'genesis_before_header', 'zp_before_header_nav_close', 15 );

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Adds custom loop.
add_action( 'genesis_loop', 'zp_genesis_404' );
function zp_genesis_404() {
	?>
	<script type="text/javascript">
		jQuery( document).ready(function(){
			var height = jQuery( window ).height();
			jQuery( '.error404 .entry-content-title' ).css({"height": height+"px"});
		});
		jQuery( window).resize(function(){
			var height = jQuery( window ).height();
			jQuery( '.error404 .entry-content-title' ).css({"height": height+"px"});
		});
	</script>
	<div class="entry-content-title">
		<div class="entry-content-header">
			<h1 class="entry-title"><?php _e( '404 Page', 'samadhi' ) ?></h1>
			<p><?php _e( 'Sorry, that page does not exist.', 'samadhi' ); ?></p>
			<p class="pagination"> <a class="button" href="javascript:javascript:history.go(-1)"><?php _e( 'Go Back', 'samadhi' ); ?></a><?php _e( ' <span>or</span> ', 'samadhi' ); ?><a class="button" href="<?php echo home_url(); ?>"><?php _e( 'Go Home', 'samadhi' ); ?></a> </p>
		</div>
	</div>
	<?php
	
}
genesis();

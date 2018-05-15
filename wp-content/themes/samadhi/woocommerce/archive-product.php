<?php
/**
 * This template displays the archive for Products
 *
 * @package genesis_connect_woocommerce
 * @version 3.3.0
 *
 */
/** Remove default Genesis loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/** Get Shop Page ID */
global $shop_page_id;
$shop_page_id = get_option( 'woocommerce_shop_page_id' );

/* Force fullwidth layout */
add_filter( 'genesis_pre_get_option_site_layout', 'genesiswooc_archive_layout' );
function genesiswooc_archive_layout( $layout ) {
	global $shop_page_id;
	//$layout = get_post_meta( $shop_page_id, '_genesis_layout', true );
	$layout = ( get_theme_mod( 'shop_layout' ) != '' ) ? get_theme_mod( 'shop_layout' ) : 'full-width-content';
	
	return $layout;
}

/** Custom Archive Loop */	
add_action( 'genesis_before_loop', 'genesiswooc_archive_product_loop' );
function genesiswooc_archive_product_loop() {
	do_action('woocommerce_before_main_content');
	?>				
	<?php if ( have_posts() ) : ?>
		
		<?php do_action('woocommerce_before_shop_loop'); ?>
		
		<ul id="zp_product_archive" class="products">
			
			<?php woocommerce_product_subcategories(); ?>
		
			<?php while ( have_posts() ) : the_post(); ?>
		
				<?php wc_get_template_part( 'content', 'product' ); ?>
		
			<?php endwhile; // end of the loop. ?>
				
		</ul>
		<?php do_action('woocommerce_after_shop_loop'); ?>
		
	<?php else : ?>
		
		<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
					
			<p><?php _e( 'No products found which match your selection.', 'samadhi' ); ?></p>
					
		<?php endif; ?>
		
	<?php endif; ?>
		
	<div class="clear"></div>	<?php do_action( 'woocommerce_pagination' ); ?>
	<?php do_action('woocommerce_after_main_content');
	
}
	 
genesis();
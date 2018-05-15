<?php
remove_action( 'genesis_loop', 'genesis_do_loop' );
/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
/** Uncomment the below line of code to add back WooCommerce breadcrumbs */
//add_action( 'genesis_before_loop', 'woocommerce_breadcrumb', 10, 0 );
/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/** Get Shop Page ID */
global $shop_page_id;
$shop_page_id = get_option( 'woocommerce_shop_page_id' );

/* Force fullwidth layout */
add_filter( 'genesis_pre_get_option_site_layout', 'genesiswooc_tax_layout' );
function genesiswooc_tax_layout( $layout ) {
	global $shop_page_id;
	$layout = get_post_meta( $shop_page_id, '_genesis_layout', true );

	//$layout = ( get_theme_mod( 'shop_layout' ) != '' ) ? get_theme_mod( 'shop_layout' ) : 'full-width-content';
	
	return $layout;
}


/*
* Reposition shop header
*/
add_action( 'genesis_before_content', 'zp_shop_header', 19 );
function zp_shop_header(){
	global $wp_query;
	?>
	<div class="zp_shop_header">
		<h1 class="page-title">	
		<?php echo single_term_title( "", false ); ?>
	 </h1>     
		<?php echo '<div class="term-description">' . wpautop( wptexturize( term_description() ) ) . '</div>'; ?>
	</div>
	<?php
}
add_action( 'genesis_loop', 'genesiswooc_product_taxonomy_loop' );
/**
* Displays shop items for the queried taxonomy term
*
 * This function has been refactored in 0.9.4 to provide compatibility with
 * both WooC 1.6.0 and backwards compatibility with older versions.
 * This is needed thanks to substantial changes to WooC template contents
 * introduced in WooC 1.6.0.
 *
 * @uses genesiswooc_content_product() if WooC is version 1.6.0+
 * @uses genesiswooc_product_taxonomy() for earlier WooC versions
 *
 * @since 0.9.0
 * @updated 0.9.4
 */
 
function genesiswooc_product_taxonomy_loop() {
	global $wp_query;
	do_action('woocommerce_before_main_content');
	?>
	<?php if ( have_posts() ) : ?>
			
		<?php do_action('woocommerce_before_shop_loop'); ?>
		
		<ul id="zp_product_archive" class="products">
			
			<?php woocommerce_product_subcategories(); ?>
		
			<?php while ( have_posts() ) : the_post(); ?>
		
				<?php wc_get_template_part( 'content', 'product' ); ?>
		
			<?php endwhile; // end of the loop. ?>
				
		</ul>		<?php do_action('woocommerce_after_shop_loop'); ?>
		
	<?php else : ?>
		
		<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
					
			<p><?php _e( 'No products found which match your selection.', 'samadhi' ); ?></p>
					
		<?php endif; ?>
		
	<?php endif; ?>
		
	<div class="clear"></div>	<?php do_action( 'woocommerce_pagination' ); ?>
	<?php do_action('woocommerce_after_main_content');
}
genesis();
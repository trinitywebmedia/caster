<?php
/**
 * Samadhi.
 *
 * This file adds the section page template to the Samadhi Theme.
 *
 * Template Name: Section
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */
// Removes page header image
remove_action( 'genesis_after_header', 'zp_page_header_feature' );

// Removes breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Forces page to full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Adds the template body class.
add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array( 'section_template' ) );
} );

// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );

// Adds section custom loop.
add_action(	'genesis_loop', 'zp_section_template' );
function zp_section_template() {
	global $post;
	$blocks = get_post_meta( get_the_ID(), 'zpmeta_section_block', true );
	$counter = 0;
	foreach ( (array) $blocks as $key => $entry ) :
		$counter++;
		$block_type = cmb2_get_meta( $entry, 'zpmeta_section_block_select' );
		$section_id = 'section' . $post->ID . '_' . $counter;
	?>
		<section id="<?php echo 'section' . $post->ID . '_' . $counter; ?>" class="section_block">
			<?php
				if( $block_type == 'portfolio' ){
					zp_section_portfolio( $entry, $section_id );
				}
				if( $block_type == 'header_text' ){
					zp_section_header_text( $entry, $section_id );
				}
				if( $block_type == 'column_blocks' ){
					zp_section_column_blocks( $entry, $section_id );
				}
				if( $block_type == 'block_custom_shortcode' ){
					zp_section_shortcode_blocks( $entry, $section_id );
				}
				if( $block_type == 'slider' ){
					zp_section_slider( $entry, $section_id );
				}
				if( $block_type == 'hero_image' ){
					zp_section_hero_image( $entry, $section_id );
				}
				if( $block_type == 'column_split' ){
					zp_section_column_split( $entry, $section_id );
				}
			?>
		</section>			
	<?php
	endforeach;
}
genesis();
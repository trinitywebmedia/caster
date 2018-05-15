<?php
/**
 * Samadhi.
 *
 * This file adds the single portfolio template to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

// Adds single portfolio navigation.
//add_action( 'genesis_after_header', 'zp_portfolio_single_nav' );
function zp_portfolio_single_nav() {

	global $post;
	$output = '';

	$output .= '<div class="single_portfolio_nav">';

	$prev_post = get_previous_post();
	if ( !empty( $prev_post ) ) {
		$output .= '<div class="single_nav_prev"><a href="' . get_permalink( $prev_post->ID ) . '" class="btn btn-lg btn-default">Previous Post</a></div>';
	}

	$next_post = get_next_post();
	if ( !empty( $next_post )){
		$output .= '<div class="single_nav_next inline"><a href="' . get_permalink( $next_post->ID ) . '" class="btn btn-lg btn-default">Next Post</a></div>';
	}
	$output .= '</div>';

	echo $output;

}

// Removes default sidebar and the sidebar created by Genesis Simple Sidebars.
add_action( 'get_header', 'zp_portfolio_sidebar' );
function zp_portfolio_sidebar() {

	if ( is_singular( 'portfolio' ) ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
		remove_action( 'genesis_sidebar_alt', 'ss_do_sidebar_alt' );
		add_action( 'genesis_sidebar', 'zp_get_portfolio_sidebar' );
	}

}

// Adds portfolio sidebar.
function zp_get_portfolio_sidebar() {

	genesis_structural_wrap( 'sidebar' );
	do_action( 'genesis_before_sidebar_widget_area' );
	dynamic_sidebar( 'portfolio-sidebar' );
	do_action( 'genesis_after_sidebar_widget_area' );
	genesis_structural_wrap( 'sidebar', 'close' );

}

// Adds Related Portfolio.
/*
add_action( 'genesis_after_content', 'zp_display_related_portfolio' );
function zp_display_related_portfolio() {

	$items = genesis_get_option( 'zp_related_items', ZP_SETTINGS_FIELD );
	$columns = genesis_get_option( 'zp_related_columns', ZP_SETTINGS_FIELD );
	
	if ( genesis_get_option( 'zp_enable_related', ZP_SETTINGS_FIELD ) ) {
		echo '<div class="zp_related_container"><div class="container"><div class="row">' . zp_related_portfolio( $items, $columns ) . '</div></div></div>';
	}

}
*/

// Removes the default Genesis loop.
remove_action( 	'genesis_loop', 'genesis_do_loop'  );

// Adds the portfolio loop.
add_action( 'genesis_loop', 'zp_single_portfolio_page'  );
function zp_single_portfolio_page() {

	global $post;

	$output = '';

	// Retrieves post meta values.
	$button_label = get_post_meta( $post->ID, 'button_label', true );
	$button_link = get_post_meta( $post->ID, 'button_link', true );

	$output .= '<div class="single_portfolio_main">';
	$output .= '<article ' . genesis_attr( 'entry' ) . '>';

	if ( have_posts() ) : while ( have_posts() ) : the_post();

		$image = get_the_post_thumbnail( $post->ID  , 'full', array( 'class'=> 'img-responsive', 'alt' => get_the_title(), 'title' => get_the_title() ) );
		$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		// Gets the type of link.
		$link_type = get_post_meta( $post->ID, 'portfolio_link', true );

		// Gets video link.
		$video_link = get_post_meta( $post->ID, 'single_video_link', true );

		// Gets portfolio attached images ids.
		$portfolio_images = get_post_meta( $post->ID, 'portfolio_images', true );

		// Gets portfolio image display type.
		$display_type = get_post_meta( $post->ID, 'display_type', true );

		$output .= '<div ' . genesis_attr( 'entry-content' ) . '>';

		// If lightbox.
		if ( $link_type == 'lightbox' ) {
			$lightbox_images = get_post_meta( $post->ID, 'lightbox_images', true );
			$video_link = get_post_meta( $post->ID, 'video_link', true );

			if ( $video_link ) {
					$output .= $script.'<div class="single_portfolio_container single_portfolio_image gallery-video"><a href="' . $video_link . '" ><span class="portfolio_icon_class"><i class="ion-ios-search"></i></span>' . $image . '</a></div>';
			} elseif ( $lightbox_images != '' ) {	
				// Gallery on the lightbox.
				$lightbox_gallery = '';
				$lightbox_gallery_ids = array_filter( explode( ",", $lightbox_images ) ); 
				$i = 0;
				while ( $i < count( $lightbox_gallery_ids ) ) {
					if ( isset( $lightbox_gallery_ids[$i] ) ) {
						$image_full = wp_get_attachment_image_src( $lightbox_gallery_ids[$i], 'full' );
						$image_tag = wp_get_attachment_image( $lightbox_gallery_ids[$i], 'thumbnail' );
						$image_meta = zp_get_attachment_meta( $lightbox_gallery_ids[$i] );
						$lightbox_gallery .= '<a style="display: none; " href="' . $image_full[0] . '" title="' . $image_meta['title'] . '">' . $image_tag . '</a>';
					}
				$i++;
				}
				$script = '<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery(".gallery_' . $post->ID . '").magnificPopup({
							delegate: "a",
							type: "image",
							tLoading: "Loading image...",
							mainClass: "mfp-img-mobile",
							gallery: {
								enabled: true,
								navigateByImgClick: true,
								preload: [0,1]
							},
							callbacks: {
								buildControls: function() {
									this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
							}
							
						  }
						});
					});
				</script>';			
				
				$output .= $script.'<div class="single_portfolio_container single_portfolio_image gallery_' . $post->ID . '"><a href="' . $image_url . '" ><span class="portfolio_icon_class"><i class="ion-ios-search"></i></span>' . $image . '</a>'.$lightbox_gallery.'</div>';
			}else {
				$output .= '<div class="single_portfolio_container single_portfolio_image gallery-image"><a href="' . $image_url . '"><span class="portfolio_icon_class"><i class="ion-ios-arrow-thin-right"></i></span>' . $image . '</a></div>';
			}

		} elseif ( $link_type == 'external_link' ) {
		// If external link.
			$external_link = get_post_meta( $post->ID, 'zp_external_link', true );
			$output .= '<div class="single_portfolio_container single_portfolio_image"><a href="' . $external_link . '" target="_blank" ><span class="portfolio_icon_class portfolio_icon_link"><i class="ion-ios-redo-outline"></i></span>' . $image . '</a></div>';
		} else {
		// If single page or empty.
			if ( $video_link ) {
				$output .= '<div class="single_portfolio_container single_portfolio_video fitvids"><iframe src="' . zp_return_desired_link( $video_link ) . '" width="710" height="400" ></iframe></div>';
			} elseif ( $portfolio_images ) {
				$output .= '<div class="single_portfolio_container single_portfolio_slide">';
				$output .= zp_gallery( $post->ID, 'full', 'portfolio_images', true );
				$output .= '</div>';
			} else {
				$output .= '<div class="single_portfolio_container single_portfolio_image gallery-image"><a href="' . $image_url . '"><span class="portfolio_icon_class"><i class="ion-ios-arrow-thin-right"></i></span>' . $image . '</a></div>';
			}
		}

		// Adds title.
		$output .= '<div class="single_portfolio_title">';
		$output .= '<p class="entry-meta">'.do_shortcode( '[post_date]' ).__( ' by ', 'samadhi' ).get_the_author_link().' '. do_shortcode( '[post_edit]' ).'</p>';
		$output .= '<h1>' . get_the_title() . '</h1>';		
		$output .= '</div>';

		// Adds content.
		if( get_the_content() ) {
			$output .= '<div class="single_portfolio_container single_portfolio_content">';
			$output .= '<div class="single_portfolio_section single_portfolio_meta">';
			$output .= apply_filters( 'the_content', get_the_content() );
			$output .= '</div>';
		}

		/*if( $button_link ) {
			$output .= '<div class="single_portfolio_section single_portfolio_button"><a class="button" href="' . $button_link . '">' . $button_label . '</a></div>';
		}*/

		$output .= '</div>';

	endwhile; endif;
	$output .= '</article>';

	// Adds related portfolio.
	//$output .= '<div class="single_portfolio_related">';
	//$output .= zp_related_portfolio( -1, 2 );
	//$output .= '</div>';

	$output .= '</div>';
	echo $output;

}

// Runs the Genesis loop.
genesis();

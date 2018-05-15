<?php
/**
 * Samadhi.
 *
 * This file adds the custom meta boxes to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */
function zp_custom_post_type() {
// Adds Portfolio Post Type.
	$portfolio_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions','genesis-layouts', 'genesis-seo', 'genesis-cpt-archives-settings', 'excerpt' )
	);
	
	// Registers portfolio post type.
	$portfolio = new Super_Custom_Post_Type( 'portfolio', 'Portfolio', 'Portfolio',  $portfolio_custom_default );
	$portfolio_category = new Super_Custom_Taxonomy( 'portfolio_category' , 'Portfolio Category' , 'Portfolio Categories', 'cat' );
	connect_types_and_taxes( $portfolio, array( $portfolio_category ) );
	
	$portfolio->add_meta_box( array(
		'context'  => 'normal',
		'id'       => 'portfolio_settings',
		'fields'   => array(
			'portfolio_link' => array(
				'data-desc'  => __( 'Select what type of link you want for this portfolio item.', 'samadhi' ),
				'label'      => __( 'Type of Portfolio link', 'samadhi' ),
				'options'    => array( 'lightbox', 'external_link', 'slider' ),
				'type'       => 'select',
			),
		),
		'priority' => 'high',
	) );
	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_lightbox',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			'video_link'      => array( 'label' => __( 'Video Link', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Add video link here. Video link format: Youtube: "http://www.youtube.com/watch?v=7HKoqNJtMTQ", Vimeo: "https://vimeo.com/123123". Leave empty if you don\'t want to have a video on a lightbox.', 'samadhi' ) ),
			'lightbox_images' => array( 'label' => __( 'Upload/Attach images to this portfolio item. Images attached in here will be shown in lightbox to form slideshow gallery.', 'samadhi' ), 'type' => 'multiple_media', 'data-desc' => __( 'Leave empty if you don\'t want to have a galley slideshow on a lightbox.', 'samadhi' ) ),
		)
	) );
	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_external_link',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			'zp_external_link' => array( 'label' => __( 'External Link', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Add external link for this portfolio item.', 'samadhi' ) ),			
		)
	) );
	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_slider',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			/*'button_label'      => array( 'label' => __( 'Button Label', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Add button label', 'samadhi' ) ),
			'button_link'       => array( 'label' => __( 'Button Link', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Add button link', 'samadhi' ) ),*/
			'portfolio_images'  => array( 'label' => __( 'Upload/Attach an image to this portfolio item. Images attached in here will be shown in lightbox and single portfolio page.', 'samadhi' ), 'type' => 'multiple_media', 'data-desc' => __( 'Add images to this portfolio. If this is empty, the featured image will be use.', 'samadhi' ) ),
			//'display_type'      => array( 'label' => __( 'Portfolio Image Display Type', 'samadhi' ), 'type' => 'select', 'options' => array( 'slider' ), 'data-desc' => __( 'Select how to display portfolio images on single portfolio page.', 'samadhi' ) ),
			//'single_video_link' => array( 'label' => __( 'Video Link', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Add video link here. Video link format: Youtube: "http://www.youtube.com/watch?v=7HKoqNJtMTQ", Vimeo: "https://vimeo.com/123123". If this is empty, the featured image will be used on lightbox.', 'samadhi' ) )
		)
	) );
	

	// Manages portfolio columns.
	function zp_add_portfolio_columns( $columns ) {
		global $zp_option;
		
		return array(
			'author'             => __( 'Author', 'samadhi' ),
			'cb'                 => '<input type="checkbox" />',
			'date'               => __( 'Date', 'samadhi' ),
			'portfolio_category' => __( 'Portfolio Category(s)', 'samadhi' ),
			'title'              => __( 'Title', 'samadhi' ),
		);
	}
	
	add_filter( 'manage_portfolio_posts_columns', 'zp_add_portfolio_columns' );
	function zp_custom_portfolio_columns( $column, $post_id ) {
		global $zp_option;
		
		switch ( $column ) {
			case 'portfolio_category':
				$terms = get_the_term_list( $post_id, 'portfolio_category', '', ',', '' );
				if ( is_string( $terms ) )
					echo $terms;
				else
					_e( 'Unable to get portfolio category.', 'samadhi' );
					break;
		}
	}
	add_action( 'manage_posts_custom_column' , 'zp_custom_portfolio_columns', 10, 2 );
	
	// Adds Page Custom Meta.
	$page_meta = new Super_Custom_Post_Meta( 'page' );
	$page_meta->add_meta_box( array(
		'id'       => 'masonry-template-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'display_type'     => array( 'label' => __( 'Display Type', 'samadhi' ), 'type' => 'select', 'options'=> array( 'blog' => 'Blog', 'portfolio' => 'Portfolio' ), 'data-desc' => __( 'Add images for gallery post format.', 'samadhi' ) ),
			'display_category' => array( 'label' => __( 'Category', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Define category to display. Use the category slug.', 'samadhi' ) ),
			'display_columns'  => array( 'label' => __( 'Columns', 'samadhi' ), 'type' => 'select', 'options'=> array( '2' => '2 Columns', '3' => '3 Columns' , '4' => '4 Columns' ),  'data-desc' => __( 'Define category to display. Use the category slug.', 'samadhi' ) ),
			'display_filter'   => array( 'label' => __( 'Enable filter?', 'samadhi' ), 'type' => 'select', 'options'=> array( 'true' => 'Yes', 'false' => 'No' ),  'data-desc' => __( 'Select true to enable category filter.', 'samadhi' ) ),
			'display_items'    => array( 'label' => __( 'Items', 'samadhi' ), 'type' => 'text', 'data-desc' => __( 'Set number of items to display.', 'samadhi' ) ),
			'display_loadmore' => array( 'label' => __( 'Enable load more button?', 'samadhi' ), 'type' => 'select', 'options'=> array( 'true' => 'Yes', 'false' => 'No' ), 'data-desc' => __( 'Select true to enable the load more button at the bottom of the items.', 'samadhi' ) ),
		)
	) );
}
add_action( 'after_setup_theme', 'zp_custom_post_type' );

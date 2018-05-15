<?php
/**
 * Samadhi.
 *
 * This file includes and setup custom metaboxes and fields additions to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */
/**
 * Helper function to get meta values
 */
function cmb2_get_meta( $type, $value ) {
    return isset( $type[ $value ] ) && ! empty( $type[ $value ] ) ? $type[ $value ] : false;
}
/**
 * Only return default value if we don't have a post ID (in the 'post' query variable)
 *
 * @param  bool  $default On/Off (true/false)
 * @return mixed          Returns true or '', the blank default
 */
function cmb2_set_checkbox_default_for_new_post( $default ) {
    return isset( $_GET['post'] ) ? '' : ( $default ? (string) $default : '' );
}
/**
 * Metabox for Page Template
 * @author Kenneth White
 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $meta_box
 * @return bool display metabox
 */
function cmb2_metabox_show_on_template( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
        return $display;
    }
    if ( 'cpt-template' !== $meta_box['show_on']['key'] ) {
        return $display;
    }
    $post_id = 0;
    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }
    if ( ! $post_id ) {
        return false;
    }
    if ( get_post_type( $post_id ) == 'page' ) {
	    $template_name = get_page_template_slug( $post_id );
	    $template_name = ! empty( $template_name ) ? substr( $template_name, 0, -4 ) : '';
	    // See if there's a match
	    return in_array( $template_name, (array) $meta_box['show_on']['value'] );
	} else {
		return $display;
	}
}
add_filter( 'cmb2_show_on', 'cmb2_metabox_show_on_template', 10, 2 );
/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array An array of options that matches the CMB2 options array
 */
function cmb2_get_post_options( $query_args ) {
    $args = wp_parse_args( $query_args, array(
        'post_type'   => 'post',
        'posts_per_page' => -1,
        // Following args: A-Z sorting
        'orderby' => 'title',
        'order' => 'ASC'
    ) );
    $posts = get_posts( $args );
    $post_options = array();
    if ( $posts ) {
        foreach ( $posts as $post ) {
         	$post_options[ $post->ID ] = $post->post_title . ' (' . ucfirst ( $post->post_type ) . ')';
        }
    }
    return $post_options;
}
/**
 * Gets 5 posts for your_post_type and displays them as options
 * @return array An array of options that matches the CMB2 options array
 */
function cmb2_get_posts_and_cpts() {
    return cmb2_get_post_options( array( 'post_type' => array ( 'post', 'room', 'event', 'food', 'deal' ) ) );
}

/**
 * Add Portfolio Image Size metabox 
 */
//add_action( 'cmb2_admin_init', 'zp_register_portfolio_image_size_metabox' );
function zp_register_portfolio_image_size_metabox() {
	$prefix = 'zpmeta_portfolio_';
	$cmb_image_size = new_cmb2_box( array(
		'id'            => $prefix . 'size_metabox',
		'title'         => esc_html__( 'Portfolio Image Size', 'samadhi' ),
		'object_types'  => array( 'portfolio' ),
		//'show_on'       => array( 'key' => 'cpt-template', 'value' => array( 'template-composer', 'template-room', 'template-event', 'template-food', 'template-deal', 'template-guestpost' ) ),
		'context'       => 'side',
		'priority'      => 'high',
		'show_names'    => false,
	) );
	$cmb_image_size->add_field( array(
		'name' => esc_html__( 'Image Size', 'samadhi' ),
		'desc' => esc_html__( 'Set portfolio image size', 'samadhi' ),
		'id'   => $prefix . 'image_size',
		'type'             => 'select',
		'default'          => 'small',
		'options'          => array(
			'small'             => esc_html__( 'Small', 'samadhi' ),
			'large'   	   => esc_html__( 'Large', 'samadhi' ),
		),
	) );
}
/**
 * Add Portfolio metabox for single portfolio
 */
//add_action( 'cmb2_admin_init', 'zp_register_portfolio_metabox' );
function zp_register_portfolio_metabox() {
	$prefix = 'zpmeta_portfolio_';
	$cmb_portfolio = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Portfolio Option', 'samadhi' ),
		'object_types'  => array( 'portfolio' ),
		//'show_on'       => array( 'key' => 'cpt-template', 'value' => array( 'template-composer', 'template-room', 'template-event', 'template-food', 'template-deal', 'template-guestpost' ) ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => false,
	) );
	$cmb_portfolio->add_field( array(
		'name'             => esc_html__( 'Type', 'samadhi' ),
		'desc'             => esc_html__( 'Select the link type of portfolio items', 'samadhi' ),
		'id'               => $prefix . 'single_linktype',
		'type'             => 'select',
		'default'          => 'single_portfolio',
		'options'          => array(
			'single_portfolio'             => esc_html__( 'Single Portfolio Page', 'samadhi' ),
			'lightbox'             => esc_html__( 'Lightbox', 'samadhi' ),
			'external'   	   => esc_html__( 'External Link', 'samadhi' ),
		),
	) );
	$cmb_portfolio->add_field( array(
		'name'           => esc_html__( 'External Link', 'samadhi' ),
	    'desc'           => esc_html__( 'Set external link', 'samadhi' ),
		'id'         => $prefix . 'single_external',
		'type'       => 'text'
	) );
	$cmb_portfolio->add_field( array(
	    'name'           => esc_html__( 'Porfolio Images', 'samadhi' ),
	    'desc'           => esc_html__( 'Set images for the carousel', 'samadhi' ),
	    'id'   => $prefix . 'single_images',
	    'type' => 'file_list',
	    'preview_size' => array( 100, 100 ),
	    // Optional, override default text strings
	    'text' => array(
	        'add_upload_files_text' => esc_html__( 'Upload Images', 'samadhi' ),
	        'remove_image_text' => esc_html__( 'Remove Images', 'samadhi' ),
	        'file_text' => esc_html__( 'Images: ', 'samadhi' ), // default: "File:"
	        'file_download_text' => esc_html__( 'Download', 'samadhi' ), // default: "Download"
	        'remove_text' => esc_html__( 'Remove', 'samadhi' ),// default: "Remove"
	    ),
	) );
	$cmb_portfolio->add_field( array(
		'name'           => esc_html__( 'Client Name', 'samadhi' ),
	    'desc'           => esc_html__( 'Set client name', 'samadhi' ),
		'id'         => $prefix . 'single_clientname',
		'type'       => 'text'
	) );
	$cmb_portfolio->add_field( array(
		'name'           => esc_html__( 'Client Link Label', 'samadhi' ),
	    'desc'           => esc_html__( 'Set client link label', 'samadhi' ),
		'id'         => $prefix . 'single_clientlabel',
		'type'       => 'text'
	) );
	$cmb_portfolio->add_field( array(
		'name'           => esc_html__( 'Client Link', 'samadhi' ),
	    'desc'           => esc_html__( 'Set client link', 'samadhi' ),
		'id'         => $prefix . 'single_clientlink',
		'type'       => 'text'
	) );
	
}
/**
 * Add Section Builder Meta Box in Composer pages
 */
add_action( 'cmb2_admin_init', 'zp_register_section_builder_metabox' );
function zp_register_section_builder_metabox() {
	$prefix = 'zpmeta_section_';
	$cmb_section = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Section Builder', 'samadhi' ),
		'object_types'  => array( 'page' ),
		'show_on'       => array( 'key' => 'cpt-template', 'value' => 'template-section' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$block_id = $cmb_section->add_field( array(
		'id'          => $prefix . 'block',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => esc_html__( 'Section {#}', 'samadhi' ),
			'add_button'    => esc_html__( 'Add Another Section', 'samadhi' ),
			'remove_button' => esc_html__( 'Remove Section', 'samadhi' ),
			'sortable'      => true,
			'closed'     => true,
		),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'             => esc_html__( 'Section Type', 'samadhi' ),
		'desc'             => esc_html__( 'Select the type of block you want to display', 'samadhi' ),
		'id'               => $prefix . 'block_select',
		'type'             => 'select',
		'default'          => 'none',
		'options'          => array(
			'none'             => esc_html__( 'None', 'samadhi' ),
			'block_custom_shortcode'   	   => esc_html__( 'Custom Shortcode Section', 'samadhi' ),
			'column_blocks'   	   => esc_html__( 'Column Blocks', 'samadhi' ),
			'column_split'   	   => esc_html__( 'Column Split', 'samadhi' ),
			'header_text'   	   => esc_html__( 'Header Text', 'samadhi' ),
			'hero_image'   	   => esc_html__( 'Hero Image', 'samadhi' ),
			'portfolio'   	   => esc_html__( 'Portfolio', 'samadhi' ),
			'slider'   	   => esc_html__( 'Slider', 'samadhi' ),		
		),
	) );
	// Column Split
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'split_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Subtitle', 'samadhi' ),
		'id'         => $prefix . 'split_subtitle',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'split_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Button Label', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set button label link', 'samadhi' ),
		'id'         => $prefix . 'split_label',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set button link', 'samadhi' ),
		'id'         => $prefix . 'split_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'split_bgimage',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );

	$cmb_section->add_group_field( $block_id, array(
	    'name'    => esc_html__( 'Images for Slider', 'samadhi' ),
	    'desc'    => esc_html__( 'Upload images if your prefer to have a slider.', 'samadhi' ),
	    'id'      => $prefix . 'split_sliderimages',
	    'type'    => 'file_list',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'text' => array(
	        'add_upload_files_text' => esc_html__( 'Add Images', 'samadhi' ),
	        'remove_image_text' => esc_html__( 'Remove Images', 'samadhi' ),
	        'remove_text' => esc_html__( 'Remove', 'samadhi' ),
	    ),
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Video Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Enter a youtube or vimeo URL.', 'samadhi' ),
		'id'         => $prefix . 'split_video',
		'type'       => 'oembed'
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Block Layout', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set the block layout', 'samadhi' ),
		'id'         => $prefix . 'split_layout',
		'type'             => 'select',
		'default'          => 'wrap',
		'options'          => array(
			'image_left'             => esc_html__( 'Figure on Left', 'samadhi' ),
			'image_right'   	   => esc_html__( 'Figure on Right', 'samadhi' ),
		)
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'split_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the block', 'samadhi' ),
		'id'      => $prefix . 'split_textcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Block Wrapper', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set the block wrapper', 'samadhi' ),
		'id'         => $prefix . 'split_wrap',
		'type'             => 'select',
		'default'          => 'wrap',
		'options'          => array(
			'wrap'             => esc_html__( 'Wrap', 'samadhi' ),
			'fullwidth'   	   => esc_html__( 'Fullwidth', 'samadhi' ),
		)
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Height', 'samadhi' ),
		'desc'    	=> esc_html__( 'Override the default height of the block. Example 500', 'samadhi' ),
		'id'         => $prefix . 'split_height',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'split_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'split_padding_bottom',
		'type'       => 'text'
	) );
	// Hero Image
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'hero_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'hero_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Content Alignment', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set content alignment', 'samadhi' ),
		'id'         => $prefix . 'hero_content_alignment',
		'type'       => 'select',
		'default'          => 'center',
		'options'          => array(
			'center'             => esc_html__( 'Center', 'samadhi' ),
			'left'   	   => esc_html__( 'Left', 'samadhi' ),
			'right'   	   => esc_html__( 'Right', 'samadhi' ),
		)
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Button Label', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set button label link', 'samadhi' ),
		'id'         => $prefix . 'hero_label',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set button link', 'samadhi' ),
		'id'         => $prefix . 'hero_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'hero_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'hero_textcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'hero_bgimage',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'hero_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'hero_opacity',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Block Wrapper', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set the block wrapper', 'samadhi' ),
		'id'         => $prefix . 'hero_wrap',
		'type'             => 'select',
		'default'          => 'wrap',
		'options'          => array(
			'wrap'             => esc_html__( 'Wrap', 'samadhi' ),
			'fullwidth'   	   => esc_html__( 'Fullwidth', 'samadhi' ),
		)
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set top padding. Ex. 20', 'samadhi' ),
		'id'         => $prefix . 'hero_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set bottom padding. Ex. 20', 'samadhi' ),
		'id'         => $prefix . 'hero_padding_bottom',
		'type'       => 'text'
	) );
	// Column Blocks
	/*$cmb_section->add_group_field( $block_id, array(
	    'name' => esc_html__( 'Columns', 'samadhi' ),
	    'id'   => $prefix . 'col_block_column',
	    'type' => 'select',
	    'default'          => '1',
	    'options' => array(
	    	'1'        => esc_html__( 'One Column', 'samadhi' ),
	    	'2'        => esc_html__( 'Two Columns', 'samadhi' ),
	    	'3'     => esc_html__( 'Three Columns', 'samadhi' ),
	    	'4'     => esc_html__( 'Four Columns', 'samadhi' )
	    ),
	) );
	*/
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => wp_kses( '<span id="col-block-1" class="column-trigger">[+] '.__( 'Column 1','samadhi').'</span>', array( 'span' => array( 'class' => array(), 'id' => array() ) ) ),
	    'id'      => $prefix . 'col_block_label',
	    'type'    => 'title',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set column link', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_image',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_opacity',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Background', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover BG color', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_hover_bg',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover text color', 'samadhi' ),
		'id'      => $prefix . 'col_block_1_hover_text',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'col_block_1_padding_bottom',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => wp_kses( '<span id="col-block-2" class="column-trigger">[+] '.__( 'Column 2','samadhi').'</span>', array( 'span' => array( 'class' => array(), 'id' => array() ) ) ),
	    'id'      => $prefix . 'col_block_2_label',
	    'type'    => 'title',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set column link', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_image',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_opacity',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Background', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover BG color', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_hover_bg',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover text color', 'samadhi' ),
		'id'      => $prefix . 'col_block_2_hover_text',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'col_block_2_padding_bottom',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => wp_kses( '<span id="col-block-3" class="column-trigger">[+] '.__( 'Column 3','samadhi').'</span>', array( 'span' => array( 'class' => array(), 'id' => array() ) ) ),
	    'id'      => $prefix . 'col_block_3_label',
	    'type'    => 'title',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set column link', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_image',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_opacity',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Background', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover BG color', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_hover_bg',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover text color', 'samadhi' ),
		'id'      => $prefix . 'col_block_3_hover_text',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'col_block_3_padding_bottom',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => wp_kses( '<span id="col-block-4" class="column-trigger">[+] '.__( 'Column 4','samadhi').'</span>', array( 'span' => array( 'class' => array(), 'id' => array() ) ) ),
	    'id'      => $prefix . 'col_block_4_label',
	    'type'    => 'title',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Title', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_title',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Description', 'samadhi' ),
		'desc'    	=> esc_html__( 'Define column description', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_desc',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Link', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set column link', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_link',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_image',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_opacity',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Background', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover BG color', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_hover_bg',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Hover Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set hover text color', 'samadhi' ),
		'id'      => $prefix . 'col_block_4_hover_text',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'col_block_4_padding_bottom',
		'type'       => 'text'
	) );
	// Slider
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => esc_html__( 'Add Image', 'samadhi' ),
	    'desc'    => esc_html__( 'Upload an image.', 'samadhi' ),
	    'id'      => $prefix . 'slider',
	    'type'    => 'file_list',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'text' => array(
	        'add_upload_files_text' => esc_html__( 'Add Images', 'samadhi' ),
	        'remove_image_text' => esc_html__( 'Remove Images', 'samadhi' ),
	        'remove_text' => esc_html__( 'Remove', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Slider Height', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set slider height', 'samadhi' ),
		'id'         => $prefix . 'slider_height',
		'default' => '600',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the description', 'samadhi' ),
		'id'      => $prefix . 'slider_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color of the slider', 'samadhi' ),
		'id'      => $prefix . 'slider_overlay_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set slider overlay opacity.Example 0.2', 'samadhi' ),
		'id'         => $prefix . 'slider_overlay_opacity',
		'default' => '0.2',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'slider_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'slider_padding_bottom',
		'type'       => 'text'
	) );
	// Portfolio
	$cmb_section->add_group_field( $block_id, array(
	    'name' => esc_html__( 'Portfolio layout', 'samadhi' ),
	    'id'   => $prefix . 'portfolio_layout',
	    'type' => 'select',
	    'default'          => '3',
	    'options' => array(
	    	'2'     => esc_html__( 'Two Column', 'samadhi' ),
	    	'3'     => esc_html__( 'Three Column', 'samadhi' ),
	    	'4'      => esc_html__( 'Four Column', 'samadhi' )
	    ),
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'portfolio_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'portfolio_bgimage',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'portfolio_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'portfolio_opacity',
		'type'       => 'text'
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'portfolio_layout_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'portfolio_layout_padding_bottom',
		'type'       => 'text'
	) );
	// Header Text
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Header Title', 'samadhi' ),
		'id'         => $prefix . 'header_text_title',
		'type'       => 'text',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Header Subtitle', 'samadhi' ),
		'id'         => $prefix . 'header_text_subtitle',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Header Content', 'samadhi' ),
		'id'         => $prefix . 'header_text_content',
		'type'       => 'textarea',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Text Alignment', 'samadhi' ),
		'id'         => $prefix . 'header_text_alignment',
		'type' 		 => 'select',
	    'default'          => 'left',
	    'options' => array(
	    	'left'        => esc_html__( 'Left', 'samadhi' ),
	    	'right'     => esc_html__( 'Right', 'samadhi' ),
	    	'center'     => esc_html__( 'Center', 'samadhi' )
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the block', 'samadhi' ),
		'id'      => $prefix . 'header_text_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the block', 'samadhi' ),
		'id'      => $prefix . 'header_text_textcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'header_text_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'header_text_padding_bottom',
		'type'       => 'text'
	) );
	
	/*$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Social Icon Shortcode', 'samadhi' ),
		'desc'   	 => esc_html__( 'Define a social shortcode in here', 'samadhi' ),
		'id'         => $prefix . 'header_social_icons',
		'type'       => 'textarea',
	) );*/

	// Custom Shortcode
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Custom Shortcode', 'samadhi' ),
		'desc'   	 => esc_html__( 'Use your custom shortcode to appear in the block, like table, and other shortcode from third-party plugins', 'samadhi' ),
		'id'         => $prefix . 'custom_shortcode',
		'type'       => 'textarea',
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set background color of the column', 'samadhi' ),
		'id'      => $prefix . 'custom_shortcode_bgcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Text Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set text color of the column', 'samadhi' ),
		'id'      => $prefix . 'custom_shortcode_textcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Background Image', 'samadhi' ),
		'desc'    => esc_html__( 'Set backrground image for the block', 'samadhi' ),
		'id'      => $prefix . 'custom_shortcode_bgimage',
		'type'    => 'file',
		'options' => array(
	        'url' => false,
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add Image', 'samadhi' ),
	    ),
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'    => esc_html__( 'Overlay Color', 'samadhi' ),
		'desc'    => esc_html__( 'Set overlay color when using BG image', 'samadhi' ),
		'id'      => $prefix . 'custom_shortcode_overlay',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Overlay Opacity', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set overlay opcacity. Example: 0.5', 'samadhi' ),
		'id'         => $prefix . 'custom_shortcode_opacity',
		'type'       => 'text'
	) );

	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Block Wrapper', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set the block wrapper', 'samadhi' ),
		'id'         => $prefix . 'custom_shortcode_wrap',
		'type'             => 'select',
		'default'          => 'wrap',
		'options'          => array(
			'wrap'             => esc_html__( 'Wrap', 'samadhi' ),
			'fullwidth'   	   => esc_html__( 'Fullwidth', 'samadhi' ),
		)
	) );


	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Top', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding top', 'samadhi' ),
		'id'         => $prefix . 'custom_shortcode_padding_top',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
		'name'       => esc_html__( 'Padding Bottom', 'samadhi' ),
		'desc'    	=> esc_html__( 'Set block padding bottom', 'samadhi' ),
		'id'         => $prefix . 'custom_shortcode_padding_bottom',
		'type'       => 'text'
	) );
	$cmb_section->add_group_field( $block_id, array(
	    'name'    => wp_kses( __( '<span class="more-trigger">[+] '.__( 'Show more options','samadhi').'</span>', 'samadhi' ), array( 'span' => array( 'class' => array() ) ) ),
	    'id'      => $prefix . 'more_trigger',
	    'type'    => 'title',
	) );
}
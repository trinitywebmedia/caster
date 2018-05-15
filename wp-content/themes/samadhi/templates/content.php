<?php 
/**
 * Samadhi.
 *
 * This file adds the default post format template to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */
$content = get_the_content();
$title = get_the_title();
$permalink = get_permalink();
$image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) );
echo '<div class="media_container">';
	if ( $image && has_post_thumbnail() ) {
		printf( '<a href = "%s" rel = "bookmark"><img class = "post-image" src = "%s" alt="" /></a>', get_permalink(), $image );
	}
echo '</div>';
echo '<div class="content_container">';
	do_action( 'genesis_entry_header' );
	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		do_action( 'genesis_entry_content' );
	echo '</div>'; // Ends .entry-content.
	do_action( 'genesis_after_entry_content' );
	do_action( 'genesis_entry_footer' );
echo '</div>';

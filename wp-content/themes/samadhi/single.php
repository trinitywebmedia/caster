<?php
/**
 * Samadhi.
 *
 * This file adds the single page template to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/themes/samadhi/
 */
 
// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );
// Adds custom single loop.
add_action(	'genesis_loop', 'zp_custom_single_template' );
function zp_custom_single_template() {
	global $post, $paged;
	// Sets views on single post.
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			$content = get_the_content();
			$title = get_the_title();
			$permalink = get_permalink();
			do_action( 'genesis_before_entry' );
			printf( '<article %s>', genesis_attr( 'entry' ) );

			$image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) );
			if ( genesis_get_option( 'content_archive_thumbnail' ) ) {
				echo '<div class="media_container">';
					if ( $image && has_post_thumbnail() ) {
						printf( '<a href = "%s" rel = "bookmark"><img class = "post-image" src = "%s" alt="" /></a>', get_permalink(), $image );
					}
				echo '</div>';
			}
			// Adds content container.
			echo '<div class="content_container">';
				do_action( 'genesis_entry_header' );
				do_action( 'genesis_before_entry_content' );
				printf( '<div %s>', genesis_attr( 'entry-content' ) );
				genesis_do_post_content();
				echo '</div>';

				do_action( 'genesis_after_entry_content' );
				do_action( 'genesis_entry_footer' );
			// Ends content container.
			echo '</div>';
		
			echo '</article>';
			do_action( 'genesis_after_entry' );
		endwhile; // Ends one post.
		do_action( 'genesis_after_endwhile' );
	else : // Checks if no posts exist.
		do_action( 'genesis_loop_else' );
	endif; // Ends loop.
}
// Runs the Genesis loop.
genesis();

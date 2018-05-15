<?php
/**
 * Samadhi.
 *
 * This file adds the archive page template to the Samadhi Theme.
 *
 * Template Name: Archive
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

// Removes the post entry content.
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Adds the custome entry content.
add_action( 'genesis_entry_content', 'zp_custom_archive_template' );
add_action( 'genesis_post_content', 'zp_custom_archive_template' );
function zp_custom_archive_template() { ?>

	<div class="class="col-md-12 col-sm-12 col-xs-12"">
		<h4><?php _e( 'Pages:', 'samadhi' ); ?></h4>
		<ul>
			<?php wp_list_pages( 'title_li=' ); ?>
		</ul>

		<h4><?php _e( 'Categories:', 'samadhi' ); ?></h4>
		<ul>
			<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
		</ul>
	</div>

	<div class="class="col-md-12 col-sm-12 col-xs-12"">
		<h4><?php _e( 'Authors:', 'samadhi' ); ?></h4>
		<ul>
			<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
		</ul>

		<h4><?php _e( 'Monthly:', 'samadhi' ); ?></h4>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>

		<h4><?php _e( 'Recent Posts:', 'samadhi' ); ?></h4>
		<ul>
			<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
		</ul>
	</div>

<?php
}

// Runs the Genesis loop.
genesis();

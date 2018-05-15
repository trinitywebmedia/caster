<?php
/**
 * Samadhi.
 *
 * This file adds the homepage to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */
// Removes the post image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );
// Adds the blog loop.
add_action(	'genesis_loop', 'zp_blog_loop' );
// Runs the Genesis loop.
genesis();
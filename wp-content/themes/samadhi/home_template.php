<?php
/**
 * Samadhi.
 *
 * This file adds the masonry page template to the Samadhi Theme.
 *
 * Template Name: Magazine
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

// Forces page to full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Adds the template body class.
add_filter( 'body_class', 'zp_home_template_bodyclass' );
function zp_home_template_bodyclass( $classes ) {

	$classes[] = 'zp_home_template';
	return $classes;

}

// Adds Home Before Loop widget area.
//add_action( 'genesis_before_loop', 'zp_home_top_widget_area', 5 );
function zp_home_top_widget_area() {

	if ( is_active_sidebar( 'home-before-loop' ) && is_home() ) {
		echo '<div class="home-before-loop">';
			dynamic_sidebar( 'home-before-loop' );
		echo '</div>';
	}

}

// Removes breadcrumbs.
remove_action(  'genesis_before_content', 'genesis_do_breadcrumbs' );

// Adds before loop widget area.
add_action(	'genesis_before_content_sidebar_wrap', 'zp_before_loop_widgetarea' );
function zp_before_loop_widgetarea() {

	if ( is_active_sidebar( 'home-before-loop' ) ) {
		echo '<div class="home-before-loop"><div class="container"><div class="row">';
			dynamic_sidebar( 'home-before-loop' );
		echo '</div></div></div>';
	}
}

// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );

// Adds home custom loop.
add_action(	'genesis_loop', 'zp_home_template' );
function zp_home_template() {

	if ( is_active_sidebar( 'home-widget' ) ) {
		echo '<div class="home-widget"><div class="container"><div class="row">';
			dynamic_sidebar( 'home-widget' );
		echo '</div></div></div>';
	}


	if ( is_active_sidebar( 'home-left' ) || is_active_sidebar( 'home-right' )  ){
		
		echo '<div class="zp_home_content"><div class="container"><div class="row">';

		if ( is_active_sidebar( 'home-left' ) ) {
			echo '<div class="home-left"><div class="home-left-wrap">';
				dynamic_sidebar( 'home-left' );
			echo '</div></div>';
		}

		if ( is_active_sidebar( 'home-right' ) ) {
			echo '<div class="home-right"><div class="home-right-wrap">';
				dynamic_sidebar( 'home-right' );
			echo '</div></div>';
		}

		echo '</div></div></div>';
	}

}

// Runs the Genesis loop.
genesis();

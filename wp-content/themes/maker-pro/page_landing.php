<?php
/**
 * This file adds the Landing page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Maker Pro Theme
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'maker_add_body_class' );
function maker_add_body_class( $classes ) {

	$classes[] = 'maker-landing';
	return $classes;

}

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_theme_support( 'genesis-menus' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the Before Footer Widget Area
remove_action( 'genesis_before_footer', 'maker_before_footer_widget_area', 5 );

//* Remove site footer widgets
remove_theme_support( 'genesis-footer-widgets' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();

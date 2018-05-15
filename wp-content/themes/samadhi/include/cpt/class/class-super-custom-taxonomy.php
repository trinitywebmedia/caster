<?php
/**
 * Slush Pro.
 *
 * This defines the custom post types for use in the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */
/**
 * Easy-as-pie custom post types.
 *
 * @author Matthew Boynes
 */
class Super_Custom_Taxonomy {
	/**
	 * The tax slug, e.g. event.
	 *
	 * @var string
	 */
	var $name;
	/**
	 * The singular name for our tax, e.g. Goose.
	 *
	 * @var string
	 */
	var $singular;
	/**
	 * The plural name for our tax, e.g. Geese.
	 *
	 * @var string
	 */
	var $plural;
	/**
	 * Does this tax have hierarchy like categories?
	 *
	 * @var bool
	 */
	var $hierarchical = false;
	/**
	 * Objects to which this tax applies.
	 *
	 * @var array
	 */
	var $objects = array();
	/**
	 * Holds the information passed to register_taxonomy.
	 *
	 * @var array See {@link http://codex.wordpress.org/Function_Reference/register_taxonomy the WordPress Codex}
	 */
	var $tax = array();
	/**
	 * Initializes a Custom Post Type.
	 *
	 * @uses SCPT_Markup::labelify
	 * @param string $name The Custom Post Type slug. Should be singular, all lowercase, letters and numbers only, dashes for spaces.
	 * @param string $singular Optional. The singular form of our tax to be used in menus, etc. If absent, $name gets converted to words.
	 * @param string $plural Optional. The plural form of our tax to be used in menus, etc. If absent, 's' is added to $singular.
	 * @param string|bool $acts_like Optional. Define if this should act like categories or tags. If this starts with 'cat' the tax will act like a category; any other value and it will act like a tag.
	 * @param array|bool $register Optional. If false, the tax won't be automatically registered. If an array, can override any of the tax defaults. See {@link http://codex.wordpress.org/Function_Reference/register_taxonomy the WordPress Codex} for possible values.
	 * @author Matthew Boynes
	 */
	function __construct( $name, $singular = false, $plural = false, $acts_like = false, $register = array() ) {
		$this->name = $name;
		if ( ! $singular )
			$singular = SCPT_Markup::labelify( $this->name );
		if ( ! $plural )
			$plural = $singular . 's';
		$this->singular = $singular;
		$this->plural = $plural;
		$this->hierarchical = ( $acts_like && false !== strpos( strtolower( $acts_like ), 'cat' ) );
		if ( false !== $register )
			$this->register_taxonomy( $register );
	}
	/**
	 * Prepares our tax. See the code itself for our defaults, any of which can be overridden by passing that key in an array to this method.
	 *
	 * @uses register_tax_action
	 * @param array $customizations Overrides to the tax defaults.
	 * @return void
	 * @author Matthew Boynes
	 */
	public function register_taxonomy( $customizations = array(), $hierarchical = false ) {
		$this->args = array_merge(
			apply_filters( 'scpt_plugin_default_tax_options', array(
				'hierarchical' => $this->hierarchical,
				'label'        => $this->plural,
				'labels'       => array(
					'name'                       => _x( $this->plural, $this->name, 'samadhi' ),
					'singular_name'              => _x( $this->singular, $this->name, 'samadhi' ),
					'search_items'               => _x( 'Search ' . $this->plural, $this->name, 'samadhi' ),
					'popular_items'              => _x( 'Popular ' . $this->plural, $this->name, 'samadhi' ),
					'all_items'                  => _x( 'All ' . $this->plural, $this->name, 'samadhi' ),
					'parent_item'                => _x( 'Parent ' . $this->singular, $this->name, 'samadhi' ),
					'parent_item_colon'          => _x( 'Parent ' . $this->singular . ':', $this->name, 'samadhi' ),
					'edit_item'                  => _x( 'Edit ' . $this->singular, $this->name, 'samadhi' ),
					'update_item'                => _x( 'Update ' . $this->singular, $this->name, 'samadhi' ),
					'add_new_item'               => _x( 'Add New ' . $this->singular, $this->name, 'samadhi' ),
					'new_item_name'              => _x( 'New ' . $this->singular . ' Name', $this->name, 'samadhi' ),
					'separate_items_with_commas' => _x( 'Separate ' . strtolower( $this->plural ) . ' with commas', $this->name, 'samadhi' ),
					'add_or_remove_items'        => _x( 'Add or remove ' . strtolower( $this->plural ), $this->name, 'samadhi' ),
					'choose_from_most_used'      => _x( 'Choose from the most used ' . strtolower( $this->plural ), $this->name, 'samadhi' ),
					'menu_name'                  => _x( $this->plural, $this->name, 'samadhi' ),
				),
					/*
					 * These defaults don't need to be overridden:
					 * 'public'                  => true,
					 * 'show_in_nav_menus'       => true,
					 * 'show_ui'                 => true,
					 * 'show_tagcloud'           => true,
					 * 'rewrite'                 => true,
					 * 'query_var'               => true,
					 * 'update_count_callback'   => false,
					 * 'capabilities'            => array(),
					 */
			) ),
			$customizations
		);
		$this->register_tax_action();
	}
	/**
	 * Connects one or more post types to this tax.
	 *
	 * @param string|array $object The post type(s) to connect.
	 * @return void
	 * @author Matthew Boynes
	 */
	public function connect_post_types( $objects ) {
		if ( ! is_array( $objects ) ) $objects = array( $objects );
		$this->objects = array_merge( $this->objects, $objects );
	}
	/**
	 * Hooks our tax into WordPress.
	 *
	 * @see register_tax
	 * @return void
	 * @author Matthew Boynes
	 */
	protected function register_tax_action() {
		add_action( 'init', array( &$this, 'register_tax' ) );
	}
	/**
	 * Registers our tax.
	 *
	 * @see register_tax_action
	 * @return void
	 * @author Matthew Boynes
	 */
	public function register_tax() {
		register_taxonomy( $this->name, $this->objects, $this->args );
	}
	/**
	 * Overrides taxonomy options after construction.
	 *
	 * @param string|array $overrides Either an associative array of options for register_taxonomy or
	 *        a string, which is to be one of the array's keys. If string, $value must also be set.
	 * @param mixed $value The value pair to the key if $overrides is a string.
	 * @return void
	 * @author Matthew Boynes
	 */
	public function args( $overrides, $value = null ) {
		if ( is_string( $overrides ) && null !== $value )
			$overrides = array( $overrides => $value );
		elseif ( ! is_array( $overrides ) )
			return;
		$this->args = array_merge( $this->args, $overrides );
	}
}

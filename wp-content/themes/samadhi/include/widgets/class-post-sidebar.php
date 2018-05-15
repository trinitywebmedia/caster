<?php
/**
 * Samadhi.
 *
 * This file adds the Post Sidebar Widget to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

add_action( 'widgets_init', 'zp_load_post_sidebar_widget' );
function zp_load_post_sidebar_widget() {

	register_widget( 'ZP_Post_Sidebar' );

}

class ZP_Post_Sidebar extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'          => '',
			'posts_cat'      => '',
			'posts_num'      => 1,
			'posts_offset'   => 0,
			'orderby'        => '',
			'order'          => '',
		);

		$widget_ops = array(
			'classname'   => 'zp-post-sidebar',
			'description' => __( 'Displays featured posts', 'samadhi' ),
		);

		$control_ops = array(
			'id_base' => 'zp-post-sidebar',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'zp-post-sidebar', __( 'ZP - Post Sidebar', 'samadhi' ), $widget_ops, $control_ops );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style_js' ) );

	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query               Query object.
	 * @global array    $_genesis_displayed_ids Array of displayed post IDs.
	 * @global $integer $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query, $_genesis_displayed_ids, $post, $authordata;

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		// Set up the author bio.
		if ( ! empty( $instance['title'] ) )
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

		$query_args = array(
			'post_type' => 'post',
			'cat'       => $instance['posts_cat'],
			'showposts' => $instance['posts_num'],
			'offset'    => $instance['posts_offset'],
			'orderby'   => $instance['orderby'],
			'order'     => $instance['order'],
		);

		$instance_id = uniqid();

		$wp_query = new WP_Query( $query_args );

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			echo '<article class="' . join( ' ', get_post_class( 'post-sidebar' ) ) . '">';

			$image = genesis_get_image( array(
				'format'  => 'html',
				'size'    => 'post-sidebar',
				'context' => 'zp-post-sidebar',
				'attr'    => array ( 'alt' => get_the_title() ),
			) );

			if( $image )
				printf( '%s', $image );

			echo '<div class="post_sidebar_content">';
				echo '<div class="post_sidebar_wrap">';
					echo '<div class="post_sidebar_cell">';
						// meta
						echo '<p class="entry-meta">';
							echo '<span class="entry_date_wrap">' . do_shortcode( '[post_date format="m.d.y" ]' ) . '</span>';
							echo do_shortcode( '[post_author_posts_link]' );
						echo '</p>';

						// title
						$title = get_the_title() ? get_the_title() : '';
						$heading = genesis_a11y( 'headings' ) ? 'h4' : 'h3';
						printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );

						//readmore arrow
						echo '<a class="more" href="'.get_permalink().'"><i class="ion ion-ios-arrow-thin-right"></i></a>';

					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '<a class="cover_link" href="'.get_permalink().'"></a>';

			echo '</article>';

		endwhile; endif;

		// Restore original query.
		wp_reset_query();

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		$new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'samadhi' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>        


			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'samadhi' ); ?>:</label>
					<?php
					$categories_args = array(
						'name'            => $this->get_field_name( 'posts_cat' ),
						'id'              => $this->get_field_id( 'posts_cat' ),
						'selected'        => $instance['posts_cat'],
						'orderby'         => 'Name',
						'hierarchical'    => 1,
						'show_option_all' => __( 'All Categories', 'samadhi' ),
						'hide_empty'      => '0',
					);
					wp_dropdown_categories( $categories_args ); ?>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>"><?php _e( 'Number of Posts to Show', 'samadhi' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_num' ) ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>"><?php _e( 'Number of Posts to Offset', 'samadhi' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_offset' ) ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By', 'samadhi' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
						<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'samadhi' ); ?></option>
						<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'samadhi' ); ?></option>
						<option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'samadhi' ); ?></option>
						<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'samadhi' ); ?></option>
						<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'samadhi' ); ?></option>
						<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'samadhi' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Sort Order', 'samadhi' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
						<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'samadhi' ); ?></option>
						<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'samadhi' ); ?></option>
					</select>
				</p>
				
			</div>

		<?php
	}

	// Adds assets.
	function enqueue_style_js(){

		if ( is_home() || is_front_page() ) {
			wp_enqueue_style( 'jquery-swiper' );
			wp_enqueue_script( 'jquery-swiper' );       
		}

	}

}

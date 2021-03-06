<?php
/**
 * Samadhi.
 *
 * This file adds the Post Box Widget to the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

add_action( 'widgets_init', 'zp_load_post_box_widget' );
function zp_load_post_box_widget() {

	register_widget( 'ZP_Post_Box' );

}

class ZP_Post_Box extends WP_Widget {
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
			'title'         => '',
			'posts_layout'  => '',
			'posts_cat'     => '',
			'posts_num'     => 1,
			'posts_offset'  => 0,
			'orderby'       => '',
			'order'         => '',
			'show_title'    => 0,
			'show_date'     => 0,
			'show_author'   => 0,
			'show_comments' => 0,
			'show_readmore' => 0,
			'show_content'  => 'excerpt',
			'content_limit' => '',
			'more_text'     => __( 'Read More...', 'samadhi' ),
		);

		$widget_ops = array(
			'classname'   => 'zp-post-box',
			'description' => __( 'Displays featured posts with thumbnails', 'samadhi' ),
		);

		$control_ops = array(
			'id_base' => 'zp-post-box',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'zp-post-box', __( 'ZP - Post Box', 'samadhi' ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_style_js' ) );
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
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	function widget( $args, $instance ) {

		global $wp_query, $_genesis_displayed_ids, $post;

		// Merges with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		// Sets up the author bio.
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

		echo '<div class="post_box_content">';
		$wp_query = new WP_Query( $query_args );

		$post_checker = 1;
		if ( have_posts() ) : while ( have_posts() ) : the_post();

			if ( 'layout_2' == $instance['posts_layout'] ) {                
				$post_item_class = ( 1 == $post_checker || 2 == $post_checker  ) ? 'post_feature_item' : 'post_small_item';
			} elseif ( 'layout_3' == $instance['posts_layout'] ){
				$post_item_class = ( 1 == $post_checker ) ? 'post_feature_item' : 'post_small_item';
			} else {
				$post_item_class = '';
			}

			$post_layout_class = ( $instance['posts_layout'] ) ? 'post_' . $instance['posts_layout'] : '';
			echo '<article class="' . join( ' ', get_post_class( array( $post_layout_class, $post_item_class ) ) ) . '">';

			if ( 'layout_1' == $instance['posts_layout'] ) {
				$image_size = ( $post_checker == 1 ) ? 'post-box-top' : 'post-box';
			} elseif ( 'layout_2' == $instance['posts_layout'] ) {              
				$image_size = ( 1 == $post_checker || 2 == $post_checker  ) ? 'post-box-top' : 'post-small';
			} elseif ( 'layout_3' == $instance['posts_layout'] ) {              
				$image_size = ( 1 == $post_checker ) ? 'blog-archive' : 'post-small';
			} else {
				$image_size = 'blog-archive';
			}

			$image = genesis_get_image( array(
				'format'  => 'html',
				'size'    => $image_size,
				'context' => 'zp-post-box',
				'attr'    => array ( 'alt' => get_the_title() ),
			) );

			if ( $image )
			printf( '<a href="%s" >%s</a>', get_permalink(), $image );

			if ( $instance['show_title'] )
				echo '<header class="entry-header">';

				if ( ! empty( $instance['show_title'] ) ) {

					$title = get_the_title() ? get_the_title() : __( '(no title)', 'samadhi' );

					$heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

					printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );

				}

				if ( $instance['show_date'] || $instance['show_author'] || $instance['show_comments'] ) {
					echo '<p class="entry-meta">';
						if ( $instance['show_date'] )
							echo do_shortcode( '[post_date]' );

						if ( $instance['show_author'] )
							echo do_shortcode( '[post_author_posts_link before="' . __( 'By ', 'samadhi' ) . '"]' );

						if ( $instance['show_comments'] )
							echo do_shortcode( '[post_comments]' );
					echo '</p>';
				}
							
			if ( $instance['show_title'] )
				echo '</header>';

			if ( ! empty( $instance['show_content'] ) ) {

				echo genesis_html5() ? '<div class="entry-content">' : '';

				if ( 'excerpt' == $instance['show_content'] ) {
					the_excerpt();
				}
				elseif ( 'content-limit' == $instance['show_content'] ) {
					the_content_limit( (int) $instance['content_limit'], '');
				}
				else {

					global $more;

					$orig_more = $more;
					$more = 0;

					the_content();

					$more = $orig_more;

				}

				echo genesis_html5() ? '</div>' : '';
			}
			// If readmore.
			if ( $instance['show_readmore'] ) {
				$morelink = ( ! empty( $instance['more_text'] ) )? $instance['more_text'] : __( 'Read More', 'samadhi' );
				echo '<p class="entry-readmore"><a class="more-link" href="' . get_permalink() . '">' . $morelink . '</a></p>';
			}

			echo '</article>';

			$post_checker++;
		endwhile; endif;

		echo '</div>';

		// Restores original query.
		wp_reset_query();

		// The EXTRA Posts (list).
		if ( ! empty( $instance['extra_num'] ) ) {
			if ( ! empty( $instance['extra_title'] ) )
				echo $args['before_title'] . esc_html( $instance['extra_title'] ) . $args['after_title'];

			$offset = intval( $instance['posts_num'] ) + intval( $instance['posts_offset'] );

			$query_args = array(
				'cat'       => $instance['posts_cat'],
				'showposts' => $instance['extra_num'],
				'offset'    => $offset,
			);

			$wp_query = new WP_Query( $query_args );

			$listitems = '';

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					$_genesis_displayed_ids[] = get_the_ID();
					$listitems .= sprintf( '<li><a href="%s">%s</a></li>', get_permalink(), get_the_title() );
				}

				if ( mb_strlen( $listitems ) > 0 )
					printf( '<ul>%s</ul>', $listitems );
			}

			// Restores original query.
			wp_reset_query();
		}

		if ( ! empty( $instance['more_from_category'] ) && ! empty( $instance['posts_cat'] ) )
			printf(
				'<p class="more-from-category"><a href="%1$s" title="%2$s">%3$s</a></p>',
				esc_url( get_category_link( $instance['posts_cat'] ) ),
				esc_attr( get_cat_name( $instance['posts_cat'] ) ),
				esc_html( $instance['more_from_category_text'] )
			);

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

		// Merges with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'samadhi' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>        

		<div class="genesis-widget-column">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">
				<p>
					<label for="<?php echo $this->get_field_id( 'posts_layout' ); ?>"><?php _e( 'Layout', 'samadhi' ); ?>:</label>
				</p>
				<p class="zp_layout_select">
					<label class="box"><img src="<?php echo get_stylesheet_directory_uri().'/images/post_layout_1.png'; ?>" alt="Layout 1"><br><input type="radio" id="<?php echo $this->get_field_id( 'posts_layout' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_layout' ) ); ?>" value="layout_1" <?php checked( 'layout_1',  esc_attr( $instance['posts_layout'] ) ); ?> class="widefat" /></label>
					<label class="box"><img src="<?php echo get_stylesheet_directory_uri().'/images/post_layout_2.png'; ?>" alt="Layout 2"><br><input type="radio" id="<?php echo $this->get_field_id( 'posts_layout' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_layout' ) ); ?>" value="layout_2" <?php checked( 'layout_2',  esc_attr( $instance['posts_layout'] ) ); ?> class="widefat" /></label>
					<label class="box"><img src="<?php echo get_stylesheet_directory_uri().'/images/post_layout_3.png'; ?>" alt="Layout 3"><br><input type="radio" id="<?php echo $this->get_field_id( 'posts_layout' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_layout' ) ); ?>" value="layout_3" <?php checked( 'layout_3',  esc_attr( $instance['posts_layout'] ) ); ?> class="widefat" /></label>
				</p>
			</div>

			<div class="genesis-widget-column-box">

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'samadhi' ); ?>:</label>
					<?php
					$categories_args = array(
						'hide_empty'      => '0',
						'hierarchical'    => 1,
						'id'              => $this->get_field_id( 'posts_cat' ),
						'name'            => $this->get_field_name( 'posts_cat' ),
						'orderby'         => 'Name',
						'selected'        => $instance['posts_cat'],
						'show_option_all' => __( 'All Categories', 'samadhi' ),
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
		</div>

		<div class="genesis-widget-column genesis-widget-column-right">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Post Title', 'samadhi' ); ?></label>
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" value="1" <?php checked( $instance['show_date'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php _e( 'Show Post Date', 'samadhi' ); ?></label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" value="1" <?php checked( $instance['show_author'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php _e( 'Show Post Author', 'samadhi' ); ?></label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_comments' ) ); ?>" value="1" <?php checked( $instance['show_comments'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>"><?php _e( 'Show Post Comments', 'samadhi' ); ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Content Type', 'samadhi' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>">
						<option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php _e( 'Show Content', 'samadhi' ); ?></option>
						<option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'samadhi' ); ?></option>
						<option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'samadhi' ); ?></option>
						<option value="" <?php selected( '', $instance['show_content'] ); ?>><?php _e( 'No Content', 'samadhi' ); ?></option>
					</select>
					<br />
					<label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Limit content to', 'samadhi' ); ?>
						<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
						<?php _e( 'characters', 'samadhi' ); ?>
					</label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_readmore' ) ); ?>" value="1" <?php checked( $instance['show_readmore'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>"><?php _e( 'Show Read More?', 'samadhi' ); ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'More Text', 'samadhi' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
				</p>

			</div>
		</div>
		<?php

	}

	// Add extra CSS.
	function enqueue_style_js(){

		wp_enqueue_script( 'jquery' );
		?>
		<style type="text/css">

			label.box {
				display: inline-block;
				width: 30%;
				overflow: hidden;
				margin-right: 3%;
			}

			label.box:last-child {
				margin-right: 0;
			}

			label.box img {
				width: 100%;
			}

		</style>
		<?php
	}

}

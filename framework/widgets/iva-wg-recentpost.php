<?php
/**
 * Plugin Name: Recent Posts Widget
 * Description: A widget used for displaying recent posts.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function reino_recent_post_widget() {
	register_widget( 'Reino_Recent_Post_Widget' );
}
add_action( 'widgets_init', 'reino_recent_post_widget' );

class Reino_Recent_Post_Widget extends WP_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'recent-posts-wg',
			'description' => esc_html__( 'Most Recent Posts.', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'recentpost_entries',
		);

		/* Create the widget. */
		parent::__construct( 'recentpost_entries', sprintf( esc_html__( ' %s: Latest Posts', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest Posts','reino' );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
			$number = 5;
		}
		if ( empty( $instance['description_length'] ) || ! $description_length = absint( $instance['description_length'] ) ) {
			$description_length = 40;
		}
		$show_date 		= isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$imagedisable 	= isset( $instance['recentpost_imagedisable'] ) ? $instance['recentpost_imagedisable'] : false;
		$list_style 	= isset( $instance['list_style'] ) ? $instance['list_style'] : false;
		$reino_recent_post_query = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
		) ) );

		//$before_widget = apply_filters('widget_display_callback', 'my_widget_display_callback', 10, 3 );


		if ( $reino_recent_post_query->have_posts() ) :

			echo wp_kses_post( $before_widget );

			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			while ( $reino_recent_post_query->have_posts() ) : $reino_recent_post_query->the_post();
				echo '<div class="recent__post' . ( 'true' == $list_style ? ' list' : '' ) . '">';
				if ( 'true' != $imagedisable ) {
					if ( has_post_thumbnail() ) {
						echo '<div class="recent__post-img post__thumbnail">';
						echo get_the_post_thumbnail( get_the_ID(), 'reino-medium-square' );
						echo '<a class="hover__link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '"></a>';
						echo '</div>';
					}
				}

				echo '<div class="recent__post-content">';
				echo '<h4 class="recent__post-title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h4>';

				if ( 'true' == $show_date ) {
					echo '<span class="date">' . get_the_date() . '</span>';
				} else {
					echo '<p>' . esc_html( wp_html_excerpt( get_the_content(), $description_length ) ) . '</p>';
				}
				echo '</div></div>';
				endwhile;
			echo wp_kses_post( $after_widget );
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] 				 	 = strip_tags( $new_instance['title'] );
		$instance['number'] 				 = (int) $new_instance['number'];
		$instance['description_length']		 = (int) $new_instance['description_length'];
		$instance['show_date'] 				 = (bool) $new_instance['show_date'];
		$instance['recentpost_imagedisable'] = (bool) $new_instance['recentpost_imagedisable'];
		$instance['list_style'] = (bool) $new_instance['list_style'];
		return $instance;
	}

	function form( $instance ) {

		$title     				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    				= isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$description_length   	= isset( $instance['description_length'] ) ? absint( $instance['description_length'] ) : 40;
		$show_date 				= isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$imagedisable 			= isset( $instance['recentpost_imagedisable'] ) ? (bool) $instance['recentpost_imagedisable'] : false;
		$list_style 			= isset( $instance['list_style'] ) ? (bool) $instance['list_style'] : false;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:','reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date','reino' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?','reino' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description_length' ) ); ?>"><?php esc_html_e( 'Length of Description to show:','reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'description_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_length' ) ); ?>" type="text" value="<?php echo esc_attr( $description_length ); ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $imagedisable ); ?> id="<?php echo esc_attr( $this->get_field_id( 'recentpost_imagedisable' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recentpost_imagedisable' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'recentpost_imagedisable' ) ); ?>"><?php esc_html_e( 'Disable Post Thumbnail?','reino' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $list_style ); ?> id="<?php echo esc_attr( $this->get_field_id( 'list_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_style' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'list_style' ) ); ?>"><?php esc_html_e( 'Display List Style','reino' ); ?></label>
		</p>
<?php
	}
}

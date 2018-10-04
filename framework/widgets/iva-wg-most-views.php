<?php
/**
 * Plugin Name: Most Viewd Posts Widget
 * Description: A widget used for displaying most viewd posts.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function vamico_post_views_widget() {
	register_widget( 'Vamico_Most_Views_Widget' );
}
add_action( 'widgets_init', 'vamico_post_views_widget' );

class Vamico_Most_Views_Widget extends WP_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'most-views-wg',
			'description' => esc_html__( 'Display most viewed posts.', 'vamico' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'post_views',
		);

		/* Create the widget. */
		parent::__construct( 'post_views', sprintf( esc_html__( ' %s: Most Viewd Posts', 'vamico' ), VAMICO_THEME_NAME ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Most Viewd Posts','vamico' );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
			$number = 5;
		}
		$imagedisable = isset( $instance['imagedisable'] ) ? $instance['imagedisable'] : false;
		$list_style   = isset( $instance['list_style'] ) ? $instance['list_style'] : false;

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		$args = array(
			'posts_per_page' => $number,
			'paged'			 => $paged,
			'meta_key' 		 => 'vamico_post_views',
			'orderby' 		 => 'meta_value_num',
			'order' 		 => 'DESC',
		);
		$vamico_most_viewed_query = new WP_Query( $args );

		if ( $vamico_most_viewed_query->have_posts() ) :

			echo wp_kses_post( $before_widget );

			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			while ( $vamico_most_viewed_query->have_posts() ) : $vamico_most_viewed_query->the_post();
				$vamico_view_count = absint( get_post_meta( get_the_ID(), 'vamico_post_views', true ) );
				if ( 0 !== $vamico_view_count ) {
					echo '<div class="recent__post ' . ( 'true' == $list_style ? ' list' : '' ) . '">';
					if ( 'true' != $imagedisable ) {
						if ( has_post_thumbnail() ) {
							echo '<div class="recent__post-img post__thumbnail">';
							echo get_the_post_thumbnail( get_the_ID(), 'vamico-medium-square' );
							echo '<a class="hover__link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '"></a>';
							echo '</div>';
						}
					}
					echo '<div class="recent__post-content">';
					echo '<h4 class="recent__post-title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h4>';

					if ( function_exists( 'vamico_postviews_round_number' ) ) {
						$count = vamico_postviews_round_number( $vamico_view_count );
					}
					echo '<span class="post__meta">' . esc_html( $count ) . ' ' . esc_html__( 'Views','vamico' ) . '</span>';
					echo '</div></div>';
				}
			endwhile;
			echo wp_kses_post( $after_widget );
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] 				 = strip_tags( $new_instance['title'] );
		$instance['number'] 			 = (int) $new_instance['number'];
		$instance['imagedisable'] 		 = (bool) $new_instance['imagedisable'];
		$instance['list_style'] 		 = (bool) $new_instance['list_style'];
		return $instance;
	}

	function form( $instance ) {

		$title     				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    				= isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$imagedisable 			= isset( $instance['imagedisable'] ) ? (bool) $instance['imagedisable'] : false;
		$list_style 			= isset( $instance['list_style'] ) ? (bool) $instance['list_style'] : false;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','vamico' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:','vamico' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $imagedisable ); ?> id="<?php echo esc_attr( $this->get_field_id( 'imagedisable' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'imagedisable' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'imagedisable' ) ); ?>"><?php esc_html_e( 'Disable Post Thumbnail?','vamico' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $list_style ); ?> id="<?php echo esc_attr( $this->get_field_id( 'list_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_style' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'list_style' ) ); ?>"><?php esc_html_e( 'Display List Style','vamico' ); ?></label>
		</p>
<?php
	}
}

<?php
/**
 * Plugin Name: Facebook Like
 * Description: A widget used for displaying Facebook Like.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function reino_facebook_like_widget() {
	register_widget( 'Reino_Facebook_Like_Widget' );
}

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'reino_facebook_like_widget' );

// Define the Widget as an extension of WP_Widget
class Reino_Facebook_Like_Widget extends WP_Widget {

	function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'facebook-like-wg',
			'description' => esc_html__( 'A widget that displays a Facebook Like Box', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'facebook_like_widget',
		);

		/* Create the widget. */
		parent::__construct( 'facebook_like_widget', sprintf( esc_html__( ' %s: Facebook Like Box', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );
	}

	// outputs the content of the widget
	public function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$page_url = $instance['page_url'];
		$faces = $instance['faces'];
		$stream = $instance['stream'];
		$cover = $instance['cover'];
		echo wp_kses_post( $before_widget );

		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-page" data-href="<?php echo esc_url( $page_url ); ?>" data-hide-cover="<?php if ( $cover ) { echo 'false'; } else { echo 'true'; } ?>" data-show-facepile="<?php if($faces) { echo 'true'; } else { echo 'false'; } ?>" data-show-posts="<?php if ( $stream ) { echo 'true'; } else { echo 'false'; } ?>"></div>

		<?php
		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['page_url'] = strip_tags( $new_instance['page_url'] );
		$instance['faces'] = (bool) $new_instance['faces'];
		$instance['stream'] = (bool) $new_instance['stream'];
		$instance['cover'] = (bool) $new_instance['cover'];

		return $instance;
	}

	// outputs the options form on admin
	function form( $instance ) {

		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$page_url = isset( $instance['page_url'] ) ? esc_attr( $instance['page_url'] ) : '';
		$faces  = isset( $instance['faces'] ) ? (bool) $instance['faces'] : false;
		$stream  = isset( $instance['stream'] ) ? (bool) $instance['stream'] : false;
		$cover = isset( $instance['cover'] ) ? (bool) $instance['cover'] : false;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php esc_html_e( 'Face Page URL:','reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" type="text" value="<?php echo esc_attr( $page_url ); ?>" />
			<small><?php esc_html_e( 'e.g. http://www.facebook.com/envato', 'reino' ); ?></small>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $faces ); ?> id="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'faces' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>"><?php esc_html_e( 'Show Faces:','reino' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $stream ); ?> id="<?php echo esc_attr( $this->get_field_id( 'stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'stream' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'stream' ) ); ?>"><?php esc_html_e( 'Show Stream:','reino' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $cover ); ?> id="<?php echo esc_attr( $this->get_field_id( 'cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cover' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'cover' ) ); ?>"><?php esc_html_e( 'Show Page Cover Image','reino' ); ?></label>
		</p>
	<?php
	}
}

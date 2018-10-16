<?php
/**
 * Plugin Name: Promo Banner
 * Description: A widget used for displaying Promo Banner.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function reino_promo_banner_widget() {
	register_widget( 'Reino_Promo_Banner_Widget' );
}

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'reino_promo_banner_widget' );

// Define the Widget as an extension of WP_Widget
class Reino_Promo_Banner_Widget extends WP_Widget {

	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'promo__banner-wg',
			'description' => esc_html__( 'A widget that displays a Promotion Banner', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'promo_banner_widget',
		);

		/* Create the widget. */
		/* translators: %s: search term */
		parent::__construct( 'promo_banner_widget', sprintf( esc_html__( ' %s: Promo Banner', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );
	}

	// outputs the content of the widget
	public function widget( $args, $instance ) {
		extract( $args );
		$title      = $instance['title'];
		$link_url   = $instance['link_url'];
		$image_url  = $instance['image_url'];
		$banner_css = '';

		echo wp_kses_post( $before_widget );

		if ( ! empty( $image_url ) ) {
			$banner_css = ' style="background-image:url(' . esc_url( $image_url ) . ');height:110px;';
		}
		echo '<div class="promo__banner" ' . esc_attr( $banner_css ) . '">';
		echo '<a class="promo__banner-link" href="' . esc_url( $link_url ) . '"></a>';
		echo '<div class="promo__banner-title"><h5 class="promo__banner-heading">' . esc_html( $title ) . '</h5></div>';
		echo '</div>';

		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['link_url']  = strip_tags( $new_instance['link_url'] );
		$instance['image_url'] = strip_tags( $new_instance['image_url'] );

		return $instance;
	}

	// outputs the options form on admin
	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$link_url  = isset( $instance['link_url'] ) ? esc_attr( $instance['link_url'] ) : '';
		$image_url = isset( $instance['image_url'] ) ? esc_attr( $instance['image_url'] ) : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Promo Image URL:', 'reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_attr( $image_url ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php esc_html_e( 'Promo Link URL:', 'reino' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
		</p>
	<?php
	}
}

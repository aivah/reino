<?php
/**
 * Plugin Name: Custom Ads
 * Description: A widget used for displaying Custom Ads.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function vamico_custom_ads_widget() {
	register_widget( 'Vamico_custom_ads_Widget' );
}

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'vamico_custom_ads_widget' );

// Define the Widget as an extension of WP_Widget
class Vamico_custom_ads_Widget extends WP_Widget {

	function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'custom_ads-wg',
			'description' => esc_html__( 'Add Custom Ads information to your widget.', 'vamico' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'custom_ads_widgets',
		);

		/* Create the widget. */
		parent::__construct( 'custom_ads_widgets', sprintf( esc_html__( ' %s: Custom Ads', 'vamico' ), VAMICO_THEME_NAME ), $widget_ops, $control_ops );
	}

	// outputs the content of the widget
	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$custom_ads_content = $instance['custom_ads_content'];
		echo wp_kses_post( $before_widget );
		$before_url = $after_url = '';

		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		echo '<div class="custom_ads__widget">';
		echo wp_kses_post( $custom_ads_content );
		echo '</div>';
		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['custom_ads_content'] = strip_tags( $new_instance['custom_ads_content'] );

		return $instance;
	}

	// outputs the options form on admin
	function form( $instance ) {
		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'custom_ads_content' => '',
		));
		$title  = strip_tags( $instance['title'] );
		$custom_ads_content = strip_tags( $instance['custom_ads_content'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','vamico' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'custom_ads_content' ) ); ?>"><?php esc_html_e( 'Custom Ads Content:','vamico' ); ?></label>
			<textarea rows="8" style="width:100%" id="<?php echo esc_attr( $this->get_field_id( 'custom_ads_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_ads_content' ) ); ?>"><?php echo esc_textarea( $custom_ads_content ); ?></textarea>
		</p>
	<?php
	}
}

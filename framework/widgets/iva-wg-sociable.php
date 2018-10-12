<?php
/**
 * Plugin Name: Sociable Widget
 * Description: A widget used for displaying Sociable.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
// Register Widget
function reino_sociable_widget() {
	register_widget( 'Reino_Sociable_Widget' );
}

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'reino_sociable_widget' );

// Define the Widget as an extension of WP_Widget
class Reino_Sociable_Widget extends WP_Widget {

	function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'socials-wg',
			'description' => esc_html__( 'Sociable widget for sidebar.', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'sociable_widget',
		);

		/* Create the widget. */
		parent::__construct( 'sociable_widget', sprintf( esc_html__( ' %s: Sociables', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );
	}

	// outputs the content of the widget
	public function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$color = $instance['color'];
		echo wp_kses_post( $before_widget );

		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		echo wp_kses_post( reino_sociables( $color ) );

		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['color'] = strip_tags( $new_instance['color'] );

		return $instance;
	}

	// outputs the options form on admin
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'color' => '',
		) );
		$title = strip_tags( $instance['title'] );
		$color = strip_tags( $instance['color'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'reino' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'Color' ) ); ?>"><?php esc_html_e( 'Color:', 'reino' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>">
				<option value="black" <?php if ( 'black' === $color ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Black','reino' ); ?></option>
				<option value="white" <?php if ( 'white' === $color ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'White','reino' ); ?></option>
			</select>
		</p>
	<?php
	}
}

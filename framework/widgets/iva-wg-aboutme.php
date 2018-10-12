<?php
/**
 * Plugin Name: About Me
 * Description: A widget used for displaying About Author Information.
 * Version: 1.0
 * Author: Maqk
 * Author URI: http://www.aivahthemes.com
 */
// Register Widget
function reino_aboutme_widget() {
	register_widget( 'Reino_AboutMe_Widget' );
}

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'reino_aboutme_widget' );

// Define the Widget as an extension of WP_Widget
class Reino_AboutMe_Widget extends WP_Widget {

	function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'aboutme-wg',
			'description' => esc_html__( 'Add about me information to your widget.', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base' => 'aboutme_widgets',
		);

		/* Create the widget. */
		parent::__construct( 'aboutme_widgets', sprintf( esc_html__( ' %s: About Me', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );
	}

	// outputs the content of the widget
	function widget( $args, $instance ) {
		extract( $args );

		$before_url = $after_url = '';

		$title               = $instance['aboutme_title'];
		$aboutme_image_url   = $instance['aboutme_image_url'];
		$aboutme_page_url    = $instance['aboutme_page_url'];
		$aboutme_subtitle    = $instance['aboutme_subtitle'];
		$aboutme_text        = $instance['aboutme_text'];
		$aboutme_signature_url = $instance['aboutme_signature_url'];

		echo wp_kses_post( $before_widget );

		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}

		echo '<div class="aboutme__widget">';

		if ( $aboutme_page_url ) {
			$before_url = '<a href="' . esc_url( $aboutme_page_url ) . '">';
			$after_url = '</a>';
		}
		if ( $aboutme_image_url ) {
			echo '<div class="aboutme__img">' . $before_url . '<img src="' . esc_url( $aboutme_image_url ) . '" alt="' . esc_attr( $title ) . '" />' . $after_url . '</div>';
		}
		echo '<div class="aboutme__details">';
		if ( $aboutme_subtitle ) {
			echo '<h5 class="aboutme__title">' . esc_html( $aboutme_subtitle ) . '</h5>';
		}
		if ( $aboutme_text ) {
			echo '<p>' . esc_html( $aboutme_text ) . '</p>';
		}
		if ( $aboutme_signature_url ) {
			echo '<div class="aboutme__biography"><img src="' . esc_url( $aboutme_signature_url ) . '" alt="' . esc_attr( $title ) . '" /></div>';
		}
		echo '</div>';
		echo '</div>';
		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['aboutme_title']      = strip_tags( $new_instance['aboutme_title'] );
		$instance['aboutme_image_url']  = strip_tags( $new_instance['aboutme_image_url'] );
		$instance['aboutme_page_url']   = strip_tags( $new_instance['aboutme_page_url'] );
		$instance['aboutme_subtitle']   = strip_tags( $new_instance['aboutme_subtitle'] );
		$instance['aboutme_text']       = strip_tags( $new_instance['aboutme_text'] );
		$instance['aboutme_signature_url'] = strip_tags( $new_instance['aboutme_signature_url'] );

		return $instance;
	}

	// outputs the options form on admin
	function form( $instance ) {
		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, array(
			'aboutme_title' => '',
			'aboutme_image_url' => '',
			'aboutme_page_url' => '',
			'aboutme_subtitle' => '',
			'aboutme_text' => '',
			'aboutme_signature_url' => '',
		));

		$title                 = strip_tags( $instance['aboutme_title'] );
		$aboutme_image_url     = strip_tags( $instance['aboutme_image_url'] );
		$aboutme_page_url      = strip_tags( $instance['aboutme_page_url'] );
		$aboutme_subtitle      = strip_tags( $instance['aboutme_subtitle'] );
		$aboutme_text          = strip_tags( $instance['aboutme_text'] );
		$aboutme_signature_url = strip_tags( $instance['aboutme_signature_url'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_title' ) ); ?>"><?php esc_html_e( 'Title', 'reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'aboutme_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" type="text" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_image_url' ) ); ?>"><?php esc_html_e( 'Image URL', 'reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'aboutme_image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_image_url' ) ); ?>" value="<?php echo esc_attr( $aboutme_image_url ); ?>" type="text" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_page_url' ) ); ?>"><?php esc_html_e( 'Page URL', 'reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'aboutme_page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_page_url' ) ); ?>" value="<?php echo esc_attr( $aboutme_page_url ); ?>" type="text" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_subtitle' ) ); ?>"><?php esc_html_e( 'Sub Title', 'reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'aboutme_subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_subtitle' ) ); ?>" value="<?php echo esc_attr( $aboutme_subtitle ); ?>" type="text" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_text' ) ); ?>"><?php esc_html_e( 'Biography', 'reino' ); ?></label>
			<textarea  rows="8" style="width:100%" id="<?php echo esc_attr( $this->get_field_id( 'aboutme_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_text' ) ); ?>"><?php echo esc_textarea( $aboutme_text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aboutme_signature_url' ) ); ?>"><?php esc_html_e( 'Autograph Image URL', 'reino' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'aboutme_signature_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'aboutme_signature_url' ) ); ?>" value="<?php echo esc_attr( $aboutme_signature_url ); ?>" type="text" style="width:100%;" />
		</p>
	<?php
	}
}

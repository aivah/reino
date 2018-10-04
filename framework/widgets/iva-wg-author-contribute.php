<?php

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'vamico_author_info' );
function vamico_author_info() {
	register_widget( 'Vamico_Author_Info_Widget' );
}

// Define the Widget as an extension of WP_Widget
class Vamico_Author_Info_Widget extends WP_Widget {

	/* constructor */
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'author-info-wg',
			'description' => esc_html__( 'Displays Author Info.', 'vamico' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'vamico_author_info',
		);

		/* translators: %s: Theme Name */
		parent::__construct( 'vamico_author_info', sprintf( esc_html__( ' %s: Author Info', 'vamico' ), VAMICO_THEME_NAME ), $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {
		extract( $args );
		$out = '';
		$title = $instance['title'];
		$out .= $before_widget;

		// Title
		if ( $title ) {
			$out .= $before_title . $title . $after_title;
		}
		global $post, $current_user;
		// USer Profile Info
		$vamico_user        = wp_get_current_user();
		$vamico_user_info    = get_userdata( $vamico_user->ID );
		$vamico_user_avatar  = get_avatar( $vamico_user->ID, 100 );
		$vamico_user_url     = $vamico_user->user_url;
		$vamico_user_desc    = $vamico_user->description;

		$out .= '<div class="iva-author-wrapper">';
		if ( is_user_logged_in() ) {
			$out .= '<div class="iva-author-thumb">';
			$out .= $vamico_user_avatar;
			$out .= '</div>';//.vamico-wg__author_thumb
			$out .= '<h4 class="iva-author-name">' . $vamico_user_info->display_name . '</h4>';
			$out .= '<span class="iva-author-posts-count">';
			$out .= sprintf( esc_html__( 'Number of posts published by user: %d', 'vamico' ), count_user_posts( $vamico_user->ID ) );
			$out .= '</span>';//.vamico__info
		}
		$out .= '</div>';
		$out .= $after_widget;
		if ( is_user_logged_in() ) {
			echo wp_kses_post( $out );
		}
	}
	//processes widget options to be saved

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	// Outputs the options form on admin
	function form( $instance ) {

		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
		) );
		$title = strip_tags( $instance['title'] );

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'vamico' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_html( $title ) . '" />';
		echo '</p>';
	}
}

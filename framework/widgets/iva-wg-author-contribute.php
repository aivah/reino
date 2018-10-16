<?php

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'reino_author_info' );
function reino_author_info() {
	register_widget( 'Reino_Author_Info_Widget' );
}

// Define the Widget as an extension of WP_Widget
class Reino_Author_Info_Widget extends WP_Widget {

	/* constructor */
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'   => 'author-info-wg',
			'description' => esc_html__( 'Displays Author Info.', 'reino' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'reino_author_info',
		);

		/* translators: %s: Theme Name */
		parent::__construct( 'reino_author_info', sprintf( esc_html__( ' %s: Author Info', 'reino' ), REINO_THEME_NAME ), $widget_ops, $control_ops );

	}

	public function widget( $args, $instance ) {
		extract( $args );
		$out   = '';
		$title = $instance['title'];
		$out  .= $before_widget;

		// Title
		if ( $title ) {
			$out .= $before_title . $title . $after_title;
		}
		global $post, $current_user;
		// USer Profile Info
		$reino_user        = wp_get_current_user();
		$reino_user_info   = get_userdata( $reino_user->ID );
		$reino_user_avatar = get_avatar( $reino_user->ID, 100 );
		$reino_user_url    = $reino_user->user_url;
		$reino_user_desc   = $reino_user->description;

		$out .= '<div class="iva-author-wrapper">';
		if ( is_user_logged_in() ) {
			$out .= '<div class="iva-author-thumb">';
			$out .= $reino_user_avatar;
			$out .= '</div>';//.reino-wg__author_thumb
			$out .= '<h4 class="iva-author-name">' . $reino_user_info->display_name . '</h4>';
			$out .= '<span class="iva-author-posts-count">';
			/* translators: %s: search term */
			$out .= sprintf( esc_html__( 'Number of posts published by user: %d', 'reino' ), count_user_posts( $reino_user->ID ) );
			$out .= '</span>';//.reino__info
		}
		$out .= '</div>';
		$out .= $after_widget;
		if ( is_user_logged_in() ) {
			echo wp_kses_post( $out );
		}
	}
	//processes widget options to be saved

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	// Outputs the options form on admin
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
		) );
		$title    = strip_tags( $instance['title'] );

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'reino' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_html( $title ) . '" />';
		echo '</p>';
	}
}

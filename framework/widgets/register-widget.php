<?php
/**
 * Register Sidebars
 */
if ( function_exists( 'register_sidebar' ) ) {

	// Default Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'reino' ),
		'id'            => 'defaultsidebar',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	));

	// Header Left Side Area
	register_sidebar( array(
		'name'          => esc_html__( 'Header Widget Left', 'reino' ),
		'id'            => 'header_widget_area_left',
		'description'   => esc_html__( 'Add only one widget which will appear on your header style 2 left side', 'reino' ),
		'before_widget' => '<div id="%1$s" class="icon-box_widget left-w %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	));

	// Header Right Side Area
	register_sidebar( array(
		'name'          => esc_html__( 'Header Widget Right', 'reino' ),
		'id'            => 'header_widget_area_right',
		'description'   => esc_html__( 'Add only one widget which will appear on your headers style 2 right side', 'reino' ),
		'before_widget' => '<div id="%1$s" class="icon-box_widget right-w %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	));

	// Footer Instagram Widget
	register_sidebar(array(
		'name'          => esc_html__( 'Instagram Photos', 'reino' ),
		'id'            => 'footer_instagram_widget',
		'description'   => esc_html__( 'Add your instagram details and display the instagram pictures in footer widget. Default limit is 10', 'reino' ),
		'before_widget' => '<div id="%1$s" class="instagram-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	));

	// default_header_widget
	register_sidebar( array(
		'name'          => esc_html__( 'Default Header Widget', 'reino' ),
		'id'            => 'default_header_widget',
		'description'   => esc_html__( 'Add only one sociables widget which will appear on your default header only', 'reino' ),
		'before_widget' => '<div id="%1$s" class="default-header-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	));
} // End if().

/**
 * Custom Sidebars
 */
if ( function_exists( 'register_sidebar' ) ) {
	// Copyright Left Content
	register_sidebar( array(
		'name'          => esc_html__( 'Copyright Left Content', 'reino' ),
		'id'            => 'footer_leftcopyright',
		'description'   => esc_html__( 'Add only one widget which will appear on your Footer Copyright Left', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	// Copyright Right Content
	register_sidebar(array(
		'name'          => esc_html__( 'Copyright Right Content', 'reino' ),
		'id'            => 'footer_rightcopyright',
		'description'   => esc_html__( 'Add only one widget which will appear on your Footer Copyright Right contemt', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	// footer-branches
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Branches', 'reino' ),
		'id'            => 'footer-branches',
		'description'   => esc_html__( 'Add only one widget which will appear after copyright in footer', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	// Sticky Contentt
	register_sidebar( array(
		'name'          => esc_html__( 'Top Stickybar Content', 'reino' ),
		'id'            => 'reino_stickycontent',
		'description'   => esc_html__( 'Add only one widget which will appear on your sticky bar on top', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Area Top', 'reino' ),
		'id'            => 'footer_area_top',
		'description'   => esc_html__( 'Add widget which will appear on your footer top section', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	// Footer area bottom
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Area Bottom', 'reino' ),
		'id'            => 'footer_area_bottom',
		'description'   => esc_html__( 'Add widget which will appear on your footer bottom section', 'reino' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
} // End if().

/**
 * Custom Sidebar Widget
 */
if ( function_exists( 'register_sidebar' ) ) {

	$reino_template_custom_widget = get_option( 'reino_customsidebar' );

	if ( is_array( $reino_template_custom_widget ) ) {
		foreach ( $reino_template_custom_widget as $reino_page_name ) {
			if ( '' !== $reino_page_name ) {
				$reino_page_name = trim( $reino_page_name );
				register_sidebar(array(
					'name'          => $reino_page_name,
					'id'            => 'sidebar-' . strtolower( preg_replace( '/\s+/', '-', $reino_page_name ) ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				));
			}
		}
	}
}
/* Footer Custom Columns */
$reino_footer_widget_layout = get_option( 'reino_footer_widget_layout' );

if ( ! empty( $reino_footer_widget_layout ) && is_array( $reino_footer_widget_layout ) ) {
	$reino_footer_widgets_col_num = $reino_footer_widget_layout['number'];
} else {
	$reino_footer_widgets_col_num = 4;
}

if ( $reino_footer_widgets_col_num > 0 ) {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widgets', 'reino' ),
			'id'            => 'footer-widgets',
			/* translators: d: widgets count */
			'description'   => sprintf( esc_html__( 'Footer area works best with %d widgets. This number can be changed in the Theme Options panel &rarr; Footer.', 'reino' ), $reino_footer_widgets_col_num ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s cols col_footer_widgets_num">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

function reino_footer_widgets_cols_array() {
	$reino_footer_wg_cols = array();

	$reino_footer_widget_layout = get_option( 'reino_footer_widget_layout' );

	if ( ! empty( $reino_footer_widget_layout ) ) {
		$reino_footer_wg_cols = explode( ',', $reino_footer_widget_layout['result'] );
	}
	if ( is_array( $reino_footer_wg_cols ) && ! empty( $reino_footer_wg_cols ) ) {
		$reino_footer_col_spans = array( (int) $reino_footer_wg_cols[0] );
		// Count footer columns
		$reino_fwc = count( $reino_footer_wg_cols );
		for ( $i = 0; $i < ( $reino_fwc - 1 ); $i++ ) {
			$reino_footer_col_spans[] = $reino_footer_wg_cols[ $i + 1 ] - $reino_footer_wg_cols[ $i ];
		}
		$reino_footer_col_spans[] = 12 - $reino_footer_wg_cols[ $i ];
		return $reino_footer_col_spans;
	} elseif ( 1 === $reino_footer_wg_cols ) {
		return array( '12' );
	}

	// default: disable footer
	return array();
}

/* Add dynamic_sidebar_params filter */
add_filter( 'dynamic_sidebar_params', 'reino_footer_widgets' );
function reino_footer_widgets( $params ) {

	global $wp_registered_widgets;

	$reino_footer_wg_cols = reino_footer_widgets_cols_array();

	static $counter = 0;

	static $reino_footer_first_row = true;

	if ( isset( $params[0]['id'] ) && 'footer-widgets' === $params[0]['id'] ) {
		$params[0]['before_widget'] = str_replace( 'footer_widgets_num', $reino_footer_wg_cols[ $counter ], $params[0]['before_widget'] );
		if ( false === $reino_footer_first_row && 0 === $counter ) {
			$params[0]['before_widget'] = '</div><div class="inner">' . $params[0]['before_widget'];
		}
		$counter++;
	}
	end( $reino_footer_wg_cols );
	if ( $counter > key( $reino_footer_wg_cols ) ) {
		$counter = 0;

		$reino_footer_first_row = false;
	}

	$wg_id  = $params[0]['widget_id'];
	$wg_obj = $wp_registered_widgets[ $wg_id ];
	$wg_opt = get_option( $wg_obj['callback'][0]->option_name );
	$wg_num = $wg_obj['params'][0]['number'];
	if ( isset( $wg_opt[ $wg_num ]['iva_widget_custom_css'] ) ) {
		if ( isset( $wg_opt[ $wg_num ]['iva_widget_custom_css'] ) ) {
			$float = $wg_opt[ $wg_num ]['iva_widget_custom_css'];
		} else {
			$float = '';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $float . ' ', $params[0]['before_widget'] );
	}

	return $params;
}

// Add input fields(priority 5, 3 parameters)
add_action( 'in_widget_form', 'reino_add_widget_form', 5, 3 );

// Callback function for options update (priorität 5, 3 parameters)
add_filter( 'widget_update_callback', 'reino_widget_form_update', 5, 3 );

// add class names (default priority, one parameter)
add_filter( 'dynamic_sidebar_params', 'reino_form_params' );

function reino_add_widget_form( $t, $return, $instance ) {

	$instance = wp_parse_args( (array) $instance, array(
		'wg_custom_css' => '',
		'wg_bg_color'   => '',
		'wg_text_color' => '',
	));

	$wg_custom_css = strip_tags( $instance['wg_custom_css'] );
	$wg_bg_color   = strip_tags( $instance['wg_bg_color'] );
	$wg_text_color = strip_tags( $instance['wg_text_color'] );

	?>
		<p><label for="<?php echo esc_attr( $t->get_field_id( 'wg_custom_css' ) ); ?>"><?php esc_html_e( 'Custom Class:', 'reino' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'wg_custom_css' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'wg_custom_css' ) ); ?>" value="<?php echo esc_attr( $wg_custom_css ); ?>" style="width:100%;" />
		</p>

		<p><label for="<?php echo esc_attr( $t->get_field_id( 'wg_bg_color' ) ); ?>"><?php esc_html_e( 'Background HEX Color:', 'reino' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'wg_bg_color' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'wg_bg_color' ) ); ?>" value="<?php echo esc_attr( $wg_bg_color ); ?>" style="width:100%;" />
		</p>
		<p><label for="<?php echo esc_attr( $t->get_field_id( 'wg_text_color' ) ); ?>"><?php esc_html_e( 'Text HEX Color:', 'reino' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'wg_text_color' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'wg_text_color' ) ); ?>" value="<?php echo esc_attr( $wg_text_color ); ?>" style="width:100%;" />
		</p>
	<?php
	$retrun = null;
	return array( $t, $return, $instance );
}

function reino_widget_form_update( $instance, $new_instance, $old_instance ) {
	$instance['wg_custom_css'] = strip_tags( $new_instance['wg_custom_css'] );
	$instance['wg_bg_color']   = strip_tags( $new_instance['wg_bg_color'] );
	$instance['wg_text_color'] = strip_tags( $new_instance['wg_text_color'] );
	return $instance;
}

function reino_form_params( $params ) {

	global $wp_registered_widgets;

	$wg_id  = $params[0]['widget_id'];
	$wg_obj = $wp_registered_widgets[ $wg_id ];
	$wg_opt = get_option( $wg_obj['callback'][0]->option_name );
	$wg_num = $wg_obj['params'][0]['number'];

	// Get Custom Background color submitted
	$wg_bg_color = isset( $wg_opt[ $wg_num ]['wg_bg_color'] )
						? $wg_opt[ $wg_num ]['wg_bg_color']
						: '';
	// Get Custom text color submitted
	$wg_text_color = isset( $wg_opt[ $wg_num ]['wg_text_color'] )
						? $wg_opt[ $wg_num ]['wg_text_color']
						: '';

	$bgcolor    = ( ! empty( $wg_bg_color ) ) ? 'background-color:' . $wg_bg_color . '; padding:20px;' : '';
	$txtcolor   = ( ! empty( $wg_text_color ) ) ? ' color:' . $wg_text_color . ';' : '';
	$css_extras = ' style="' . $bgcolor . $txtcolor . '"';

	$params[0]['before_widget'] = str_replace( '>', ' ' . $css_extras . ' >', $params[0]['before_widget'] );

	if ( isset( $wg_opt[ $wg_num ]['wg_custom_css'] ) ) {
		if ( isset( $wg_opt[ $wg_num ]['wg_custom_css'] ) ) {
			$float = $wg_opt[ $wg_num ]['wg_custom_css'];
		} else {
			$float = '';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $float . ' ', $params[0]['before_widget'], 1 );
	}
	return $params;
}

<?php
/**
 * Register Sidebars
 */
if ( function_exists( 'register_sidebar' ) ) {

	// Default Sidebar
	register_sidebar( array(
		'name' => esc_html__( 'Main Sidebar', 'vamico' ),
		'id' => 'defaultsidebar',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	));

	// Header Left Side Area
	register_sidebar(array(
		'name' => esc_html__( 'Header Widget Left', 'vamico' ),
		'id' => 'header_widget_area_left',
		'description' => esc_html__( 'Select only one widget which will appear on your headers', 'vamico' ),
		'before_widget' => '<div id="%1$s" class="icon-box_widget left-w %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<strong>',
		'after_title' => '</strong>',
	));
	// Header Right Side Area
	register_sidebar(array(
		'name' => esc_html__( 'Header Widget Right', 'vamico' ),
		'id' => 'header_widget_area_right',
		'description' => esc_html__( 'Select only one widget which will appear on your headers style 2 only', 'vamico' ),
		'before_widget' => '<div id="%1$s" class="icon-box_widget right-w %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<strong>',
		'after_title' => '</strong>',
	));
	// Footer Instagram Widget
	register_sidebar(array(
		'name' => esc_html__( 'Instagram Footer', 'vamico' ),
		'id' => 'footer_instagram_widget',
		'description' => esc_html__( 'Use the "Instagram" widget here. IMPORTANT: For best result set number of photos to 6', 'vamico' ),
		'before_widget' => '<div id="%1$s" class="instagram-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<strong>',
		'after_title' => '</strong>',
	));
	// default_header_widget
	register_sidebar(array(
		'name' => esc_html__( 'Default Header Widget', 'vamico' ),
		'id' => 'default_header_widget',
		'description' => esc_html__( 'Select only one sociables widget which will appear on your default header only', 'vamico' ),
		'before_widget' => '<div id="%1$s" class="default-header-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<strong>',
		'after_title' => '</strong>',
	));
} // End if().

/**
 * Custom Sidebars
 */
if ( function_exists( 'register_sidebar' ) ) {
	// Copyright Left Content
	register_sidebar(array(
		'name' => esc_html__( 'Copyright Left Content', 'vamico' ),
		'id' => 'footer_leftcopyright',
		'description' => esc_html__( 'Select only one widget which will appear on your Copyright Left Content', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Copyright Right Content
	register_sidebar(array(
		'name' => esc_html__( 'Copyright Right Content', 'vamico' ),
		'id' => 'footer_rightcopyright',
		'description' => esc_html__( 'Select only one widget which will appear on your Copyright Right contemt', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// footer-branches
	register_sidebar(array(
		'name' => esc_html__( 'Footer Branches', 'vamico' ),
		'id' => 'footer-branches',
		'description' => esc_html__( 'Select only one widget which will appear after copyright in footer', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	/**
	 * Sticky Content  Widgets
	 *-----------------------------
	 */
	 // Sticky Contentt
	register_sidebar(array(
		'name' => esc_html__( 'Sticky Content', 'vamico' ),
		'id' => 'vamico_stickycontent',
		'description' => esc_html__( 'Select only one widget which will appear on your sticky bar Content', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	/**
	 * Footer Column Widgets
	 */
	 // Footer area top
	register_sidebar(array(
		'name' => esc_html__( 'Footer Area Top','vamico' ),
		'id' => 'footer_area_top',
		'description' => esc_html__( 'Select widget which will appear on your footer top section', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	 // Footer area bottom
	register_sidebar(array(
		'name' => esc_html__( 'Footer Area Bottom','vamico' ),
		'id' => 'footer_area_bottom',
		'description' => esc_html__( 'Select widget which will appear on your footer bottom section', 'vamico' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
} // End if().

/**
 * Custom Sidebar Widget
 */
if ( function_exists( 'register_sidebar' ) ) {

	$vamico_template_custom_widget = get_option( 'vamico_customsidebar' );

	if ( is_array( $vamico_template_custom_widget ) ) {
		foreach ( $vamico_template_custom_widget as $vamico_page_name ) {
			if ( '' !== $vamico_page_name ) {
				$vamico_page_name = trim( $vamico_page_name );
				register_sidebar(array(
					'name' => $vamico_page_name,
					'id' => 'sidebar-' . strtolower( preg_replace( '/\s+/', '-', $vamico_page_name ) ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => '</aside>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				));
			}
		}
	}
}
/* Footer Custom Columns */
$vamico_footer_widget_layout = get_option( 'vamico_footer_widget_layout' );

if ( ! empty( $vamico_footer_widget_layout ) && is_array( $vamico_footer_widget_layout ) ) {
	$vamico_footer_widgets_col_num = $vamico_footer_widget_layout['number'];
} else {
	$vamico_footer_widgets_col_num = 4;
}

if ( $vamico_footer_widgets_col_num > 0 ) {
	register_sidebar(
		array(
			'name' => esc_html__( 'Footer Widgets', 'vamico' ),
			'id' => 'footer-widgets',
			'description' => sprintf( esc_html__( 'Footer area works best with %d widgets. This number can be changed in the Theme Options panel &rarr; Footer.', 'vamico' ), $vamico_footer_widgets_col_num ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s cols col_footer_widgets_num">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}

function vamico_footer_widgets_cols_array() {
	$vamico_footer_widgets_cols_array = array();
	$vamico_footer_widget_layout = get_option( 'vamico_footer_widget_layout' );

	if ( ! empty( $vamico_footer_widget_layout ) ) {
		$vamico_footer_widgets_cols_array = explode( ',', $vamico_footer_widget_layout['result'] );
	}
	if ( is_array( $vamico_footer_widgets_cols_array ) && ! empty( $vamico_footer_widgets_cols_array ) ) {
		$vamico_footer_col_spans = array( (int) $vamico_footer_widgets_cols_array[0] );
		// Count footer columns
		$vamico_fwc = count( $vamico_footer_widgets_cols_array );
		for ( $i = 0; $i < ( $vamico_fwc - 1 ); $i++ ) {
			$vamico_footer_col_spans[] = $vamico_footer_widgets_cols_array[ $i + 1 ] - $vamico_footer_widgets_cols_array[ $i ];
		}
		$vamico_footer_col_spans[] = 12 - $vamico_footer_widgets_cols_array[ $i ];
		return $vamico_footer_col_spans;
	} elseif ( 1 === $vamico_footer_widgets_cols_array ) {
		return array( '12' );
	}

	// default: disable footer
	return array();
}

/* Add dynamic_sidebar_params filter */
add_filter( 'dynamic_sidebar_params', 'vamico_footer_widgets' );
function vamico_footer_widgets( $params ) {

	global $wp_registered_widgets;

	$vamico_footer_widgets_cols_array = vamico_footer_widgets_cols_array();
	static $counter   = 0;
	static $vamico_footer_first_row = true;

	if ( isset( $params[0]['id'] ) && $params[0]['id'] == 'footer-widgets' ) {
		$params[0]['before_widget'] = str_replace( 'footer_widgets_num', $vamico_footer_widgets_cols_array[ $counter ], $params[0]['before_widget'] );
		if ( false === $vamico_footer_first_row && 0 === $counter ) {
			$params[0]['before_widget'] = '</div><div class="inner">' . $params[0]['before_widget'];
		}
		$counter++;
	}
	end( $vamico_footer_widgets_cols_array );
	if ( $counter > key( $vamico_footer_widgets_cols_array ) ) {
		$counter   = 0;
		$vamico_footer_first_row = false;
	}
	// Custom Class
	$vamico_widget_id  = $params[0]['widget_id'];
	$vamico_widget_obj = $wp_registered_widgets[ $vamico_widget_id ];
	$vamico_widget_opt = get_option( $vamico_widget_obj['callback'][0]->option_name );
	$vamico_widget_num = $vamico_widget_obj['params'][0]['number'];
	if ( isset( $vamico_widget_opt[ $vamico_widget_num ]['iva_widget_custom_css'] ) ) {
		if ( isset( $vamico_widget_opt[ $vamico_widget_num ]['iva_widget_custom_css'] ) ) {
			$float = $vamico_widget_opt[ $vamico_widget_num ]['iva_widget_custom_css'];
		} else {
			$float = '';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $float . ' ', $params[0]['before_widget'] );
	}

	return $params;
}

// Add input fields(priority 5, 3 parameters)
add_action( 'in_widget_form', 'vamico_add_widget_form', 5, 3 );

// Callback function for options update (priorität 5, 3 parameters)
add_filter( 'widget_update_callback', 'vamico_widget_form_update', 5, 3 );

// add class names (default priority, one parameter)
add_filter( 'dynamic_sidebar_params', 'vamico_form_params' );

function vamico_add_widget_form( $t, $return, $instance ) {

	$instance = wp_parse_args( (array) $instance, array(
		'vamico_wg_custom_css' => '',
		'vamico_wg_custom_bg'  => '',
		'vamico_wg_custom_txt' => '',
	));

	$vamico_wg_custom_css = strip_tags( $instance['vamico_wg_custom_css'] );
	$vamico_wg_custom_bg  = strip_tags( $instance['vamico_wg_custom_bg'] );
	$vamico_wg_custom_txt = strip_tags( $instance['vamico_wg_custom_txt'] );

	?>
		<p><label for="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_css' ) ); ?>"><?php esc_html_e( 'Custom Class:', 'vamico' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_css' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'vamico_wg_custom_css' ) ); ?>" value="<?php echo esc_attr( $vamico_wg_custom_css ); ?>" style="width:100%;" />
		</p>

		<p><label for="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_bg' ) ); ?>"><?php esc_html_e( 'Background HEX Color:', 'vamico' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_bg' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'vamico_wg_custom_bg' ) ); ?>" value="<?php echo esc_attr( $vamico_wg_custom_bg ); ?>" style="width:100%;" />
		</p>
		<p><label for="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_txt' ) ); ?>"><?php esc_html_e( 'Text HEX Color:', 'vamico' ); ?></label>
		<input id="<?php echo esc_attr( $t->get_field_id( 'vamico_wg_custom_txt' ) ); ?>" type="text" name="<?php echo esc_attr( $t->get_field_name( 'vamico_wg_custom_txt' ) ); ?>" value="<?php echo esc_attr( $vamico_wg_custom_txt ); ?>" style="width:100%;" />
		</p>
	<?php
	$retrun = null;
	return array( $t, $return, $instance );
}

function vamico_widget_form_update( $instance, $new_instance, $old_instance ) {
	$instance['vamico_wg_custom_css'] = strip_tags( $new_instance['vamico_wg_custom_css'] );
	$instance['vamico_wg_custom_bg']  = strip_tags( $new_instance['vamico_wg_custom_bg'] );
	$instance['vamico_wg_custom_txt'] = strip_tags( $new_instance['vamico_wg_custom_txt'] );
	return $instance;
}

function vamico_form_params( $params ) {

	global $wp_registered_widgets;

	$vamico_widget_id     = $params[0]['widget_id'];
	$vamico_widget_obj    = $wp_registered_widgets[ $vamico_widget_id ];
	$vamico_widget_opt    = get_option( $vamico_widget_obj['callback'][0]->option_name );
	$vamico_widget_num    = $vamico_widget_obj['params'][0]['number'];
	$vamico_wg_custom_bg  = $vamico_widget_opt[ $vamico_widget_num ]['vamico_wg_custom_bg'];
	$vamico_wg_custom_txt = $vamico_widget_opt[ $vamico_widget_num ]['vamico_wg_custom_txt'];

	$bgcolor    = ( ! empty( $vamico_wg_custom_bg ) ) ? 'background-color:' . $vamico_wg_custom_bg . '; padding:20px;' : '';
	$txtcolor   = ( ! empty( $vamico_wg_custom_txt ) ) ? ' color:' . $vamico_wg_custom_txt . ';' : '';
	$css_extras = ' style="' . $bgcolor . $txtcolor . '"';
	$params[0]['before_widget'] = str_replace( '>', ' ' . $css_extras . ' >', $params[0]['before_widget'] );

	if ( isset( $vamico_widget_opt[ $vamico_widget_num ]['vamico_wg_custom_css'] ) ) {
		if ( isset( $vamico_widget_opt[ $vamico_widget_num ]['vamico_wg_custom_css'] ) ) {
			$float = $vamico_widget_opt[ $vamico_widget_num ]['vamico_wg_custom_css'];
		} else {
			$float = '';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $float . ' ', $params[0]['before_widget'], 1 );
	}
	return $params;
}

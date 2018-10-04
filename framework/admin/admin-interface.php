<?php
/**
 * function vamico_fw_optionsframework_add_admin - Load static framework options pages
 * Credits to Devin too for using some coding from his framework https://github.com/devinsays
 */
function vamico_fw_optionsframework_add_admin() {

	global $vamico_options, $vamico_icon;
	/**
	 * Save Options Settings
	 */
	if ( isset( $_REQUEST['page'] ) && 'optionsframework' === $_REQUEST['page'] ) {

		if ( isset( $_REQUEST['iva_save'] ) && 'reset' === $_REQUEST['iva_save'] ) {

			vamico_fw_optionsframework_reset_options( $vamico_options, 'optionsframework' );

			header( 'Location: admin.php?page=optionsframework&reset=true' );
			die;
		}
	}
	/**
	 * Add a top level menu page in the 'objects' section
	 *
	 * @param string 'VAMICO_THEME_NAME' The text to be displayed in the title tags of the page when the menu is selected
	 * @param string 'VAMICO_THEME_NAME' The text to be used for the menu
	 * @param string 'edit_theme_options' The capability required for this menu to be displayed to the user.
	 * @param string 'optionsframework' The slug name to refer to this menu by $vamico_sociable(should be unique for this menu)
	 * @param callback 'optionsframework_options_page' The function to be called to output the content for this page.
	 * @param string '$vamico_icon' The url to the icon to be used for this menu
	 *
	 * @return string The resulting page's hook_suffix
	 */
	add_theme_page( VAMICO_THEME_NAME, VAMICO_THEME_NAME, 'edit_theme_options', 'optionsframework', 'vamico_fw_optionsframework_options_page', $vamico_icon );

	/**
	 * Hooks a function on to a specific action.
	 * Runs in the HTML header so a admin framework can add JavaScript scripts to all admin pages.
	 */
	add_action( 'admin_print_scripts', 'vamico_admin_print_scripts' );
}

/**
 * Hooks for adding admin menu
 */
add_action( 'admin_menu', 'vamico_fw_optionsframework_add_admin' );

/**
 * Function vamico_fw_optionsframework_reset_options
 * updates the vamico_theme_option_values option value in wp_options table
 */
function vamico_fw_optionsframework_reset_options( $vamico_options, $page = 'optionsframework' ) {

	$output = unserialize( json_decode( get_option( 'vamico_default_theme_option_values' ) ) );

	vamico_update_option_values( $vamico_options, $output );
	update_option( 'vamico_theme_option_values', $output );
}

/**
 * function vamico_fw_optionsframework_options_page -  Builds the Options Page
 */
function vamico_fw_optionsframework_options_page() {

	global $vamico_options;

	$vamico_theme_data	= wp_get_theme();
	$vamico_theme_version = $vamico_theme_data->get( 'Version' );
	$vamico_theme_name    = $vamico_theme_data->get( 'Name' );

	$user_id 		= get_current_user_id();
	$current_user 	= wp_get_current_user();
	$avatar 		= get_avatar( $user_id, 50 );
	$howdy  		= sprintf( esc_html__( 'Howdy, %1$s','vamico' ), $current_user->display_name );
	?>
	<div class="iva_container_wrap">
		<div class="iva_container">
			<div class="page_load"><?php esc_html_e( 'Loading Theme Options...','vamico' ); ?></div>

			<form action="" enctype="multipart/form-data" id="atpform" method='post'>

				<div id="atp-popup-save" class="atp-save-popup"><div class="atp-save-save"><?php esc_html_e( 'Options Updated','vamico' ); ?></div></div>
				<div id="atp-popup-reset" class="atp-save-popup"><div class="atp-save-reset"><?php esc_html_e( 'Options Reset','vamico' ); ?></div></div>

				<div class="iva_ofw_header clearfix">
					<div class="leftpane">
						<div class="headinfo">
							<div class="atp_avatar"><?php echo wp_kses_post( $avatar ); ?></div>
							<h4><?php echo wp_kses_post( $howdy ); ?> </h4>
							<h5><span><?php esc_html_e( 'Theme Options Panel', 'vamico' );?></span></h5>
						</div>
					</div>
					<div class="rightpane">
						<div class="headlogo">
							<h1><?php echo esc_html( $vamico_theme_name ); ?></h1>
						</div>
						<div class="panelinfo">
							<div class="themename"><?php esc_html_e( 'Version', 'vamico' );?> <span class="details orange"><?php echo esc_html( $vamico_theme_version ); ?></span></div>
						</div>
					</div>
				</div>	<!-- #atp_header -->
				<?php

				// Get all the options based on menu/page selection
				switch ( $_GET['page'] ) {
					case 'optionsframework' :
						$return = vamico_fw_optionsframework_machine( $vamico_options );
						break;
				}
				?>
				<div class="iva_ofw_content">
					<div id="atp-nav">
						<ul>
							<?php echo wp_kses_post( $return[1] ); ?>
						</ul>
					</div>

					<div id="content">
						<div class="options-content">
							<?php
							echo wp_kses( $return[0], array(
							        'a'  => array(
							         'href' => true,
							         'data-url' => true,
							         'data-download' => true,
							         'data-import' => true,
							         'data-delete' => true,
							         'class' => true,
							         'title' => true,
							        ),
							        'img' => array(
							         'src' => true,
							         'alt' => true,
							         'data-id' => true,
									 'class' => true,
							        ),
							        'b'  => array(),
							        'p' => array(
							         'class' => true,
							         'style' => true,
							        ),
							        'em' => array(),
							        'i'  => array(
							         'class' => true,
							        ),
							        'strong' => array(),
							        'span' => array(),
							        'small' => array(),
							        'br'  => array(),
							        'div' => array(
							         'id' => true,
							         'class' => true,
							        ),
							        'select' => array(
							         'class' => true,
							         'name'  => true,
							         'id'    => true,
							         'multiple' => true,
							        ),
							        'option'   => array(
							         'value' => true,
							         'selected' => true,
							        ),
							        'optgroup' => array(
							         'label' => true,
							        ),
							        'button' => array(
							         'name' => true,
							         'id' => true,
							         'class' => true,
							         'type' => true,
							         'value' => true,
							        ),
							        'li'    => array(),
							        'ul'    => array(),
							        'span'    => array(
							         'class' => true,
							        ),
							        'heading'  => array(),
							        'input'    => array(
									'data-index' => true,
							         'checked' => true,
							         'type' => true,
							         'class' => true,
							         'name' => true,
							         'id' => true,
							         'value' => true,
							         'style' => true,
							        ),
							        'label' => array(
							         'for' => true,
							        ),
							        'h1'       => array(
							         'class' => true,
							        ),
							        'h3'       => array(),
							        'textarea' => array(
							         'class' => true,
							         'name' => true,
							         'id' => true,
							         'cols' => true,
							         'rows' => true,
							        ),
							        'strong'   => array(),
							        'table' => array(
							         'id' => true,
							         'class' => true,
							        ),
							        'tbody' => array(),
							        'tr' => array(),
							        'td' => array(),
							        'th' => array(
							         'align' => true,
							         'width' => true,
							        ),
							));
							?>
						</div>
					</div>
					<div class="clear"></div>
				</div>

				<div class="savebar">
					<div class="savelink">
						<img style="display:none" src="<?php echo esc_url( VAMICO_ADMIN_URI . '/images/spinner.gif' ); ?>" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php echo esc_html__( 'saving...', 'vamico' ); ?>" />
						<input type="submit" value="<?php echo esc_html__( 'Save All Changes', 'vamico' ); ?>" class="green-button button button-hero right button-primary" />
					</div><!-- savelink-->
				</form>
				<form action="" method="post" style="display:inline" id="atpform-reset">
					<span class="submit-footer-reset">
						<input name="reset" type="submit" value="<?php echo esc_html__( 'Reset Options', 'vamico' );?>" class="red-button button button-secondary" />
						<input type="hidden" name="iva_save" value="reset" />
					</span>
				</form>
				</div>
				<?php
				if ( ! empty( $update_message ) ) {
					echo wp_kses_post( $update_message );
				}?>
				<div class="clear"></div>
		</div><!-- end atpinterface-->
</div><!-- end atp_container-->
<?php
}

/**
 * Load required javascripts for Options Page - of_load_only
 */
function vamico_admin_print_scripts() {

	$vamico_sociable = array(
		'adn'        	=> esc_html__( 'ADN', 'vamico' ),
		'android'    	=> esc_html__( 'Android', 'vamico' ),
		'behance'   	=> esc_html__( 'Behance', 'vamico' ),
		'delicious'  	=> esc_html__( 'Delicious', 'vamico' ),
		'deviantart' 	=> esc_html__( 'DeviantArt', 'vamico' ),
		'digg'       	=> esc_html__( 'Digg', 'vamico' ),
		'dribbble'   	=> esc_html__( 'Dribbble', 'vamico' ),
		'facebook'  	=> esc_html__( 'Facebook', 'vamico' ),
		'flickr'	 	=> esc_html__( 'Flickr', 'vamico' ),
		'google-plus' 	=> esc_html__( 'Google Plus', 'vamico' ),
		'instagram'  	=> esc_html__( 'Instagram', 'vamico' ),
		'lastfm'     	=> esc_html__( 'Lastfm', 'vamico' ),
		'linkedin'   	=> esc_html__( 'LinkedIn', 'vamico' ),
		'pinterest-p' 	=> esc_html__( 'Pinterest', 'vamico' ),
		'reddit'     	=> esc_html__( 'Reddit', 'vamico' ),
		'skype'      	=> esc_html__( 'Skype', 'vamico' ),
		'soundcloud' 	=> esc_html__( 'SoundCloud', 'vamico' ),
		'stumbleupon' 	=> esc_html__( 'Stumbleupon', 'vamico' ),
		'snapchat' 		=> esc_html__( 'Snapchat', 'vamico' ),
		'twitter'     	=> esc_html__( 'Twitter', 'vamico' ),
		'vimeo-square' 	=> esc_html__( 'Vimeo', 'vamico' ),
		'whatsapp'   	=> esc_html__( 'Whatsapp', 'vamico' ),
		'yahoo'      	=> esc_html__( 'Yahoo', 'vamico' ),
		'yelp'       	=> esc_html__( 'Yelp', 'vamico' ),
		'youtube'    	=> esc_html__( 'Youtube', 'vamico' ),
		'vk'         	=> esc_html__( 'VK', 'vamico' ),
		'paypal'	 	=> esc_html__( 'Paypal', 'vamico' ),
		'rss'	 	=> esc_html__( 'RSS', 'vamico' ),
		'dropbox'    	=> esc_html__( 'Dropbox', 'vamico' ),
		'envelope'	 	=> esc_html__( 'Email', 'vamico' ),
	);
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'vamico-ajax-handler', VAMICO_FRAMEWORK_URI . 'admin/js/vamico-ajax-handler.js', array( 'jquery' ) );
	wp_enqueue_script( 'vamico-of-medialibrary-uploader', VAMICO_FRAMEWORK_URI . 'admin/js/vamico-of-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'underscore' );
	wp_enqueue_media();
	wp_localize_script( 'vamico-ajax-handler', 'sociables_args', $vamico_sociable );

	$querystring_reset = isset( $_REQUEST['reset'] ) ? esc_html( $_REQUEST['reset'] ) : '';
	$admin_ajax_url = esc_url( admin_url( 'admin-ajax.php' ) );
	$querystring_page = isset( $_REQUEST['page'] ) ? esc_html( $_REQUEST['page'] ):'';
	wp_add_inline_script( 'vamico-ajax-handler', "var querystring_reset='$querystring_reset', admin_ajax_url='$admin_ajax_url', querystring_page='$querystring_page'" );
}

/**
* Ajax Save Action - of_ajax_callback
*/
add_action( 'wp_ajax_vamico_ajax_upload', 'vamico_ajax_callback' );

function vamico_ajax_callback() {

	global $wpdb,$vamico_options; // this is how you get access to the database

	$save_type = $_POST['type'];

	// Save type =  U P L A O D
	if ( $save_type == 'upload' ) {

		$clickedID 				= $_POST['data']; // Acts as the name
		$filename 				= $_FILES[ $clickedID ];
		$filename['name'] 		= preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] );
		$override['test_form'] 	= false;
		$override['action'] 	= 'wp_handle_upload';
		$uploaded_file 			= wp_handle_upload( $filename,$override );
		$upload_tracking[] 		= $clickedID;

		update_option( $clickedID , $uploaded_file['url'] );

		if ( ! empty( $uploaded_file['error'] ) ) {
			echo 'Upload Error: ' . esc_html( $uploaded_file['error'] );
		} else {
			echo esc_url( $uploaded_file['url'] );
		} // End if().
		exit;
	} elseif ( $save_type == 'options' || $save_type == 'framework' ) { // Save type =  O P T I O N S / F R A M E W O R K

		$data = $_POST['data'];
		$import_process_initiated = false;

		//to identify whether saving/updating the settings, this becomes true when action performed through advance options

		parse_str( $data,$output );

		vamico_update_option_values( $vamico_options,$output );

		if ( $output['vamico_theme_option_values'] != '' ) {

			$vamico_import_output = unserialize( json_decode( $output['vamico_theme_option_values'] ) );
			if ( $vamico_import_output ) {

				update_option( 'vamico_theme_option_values',$vamico_import_output );

				if ( count( $vamico_import_output ) > 1 ) {
					vamico_update_option_values( $vamico_options,$vamico_import_output );
				}
			}
		}
		$output['vamico_theme_option_values'] = ''; //remove the content of vamico_theme_option_values

		update_option( 'vamico_theme_option_values', $output );//updates the vamico_theme_option_values option value
		die();
	} // End if().
}

/**
 * ARRAY TYPES
 * U P D A T E   O P T I O N S   V A L U E S
 */
function vamico_update_option_values( $vamico_options, $output ) {

	// loop through the template options
	foreach ( $vamico_options as $option_array ) {

		$new_value = '';

		if ( isset( $option_array['id'] ) ) {

			// Non - Headings...
			$type = $option_array['type'];
			$id   = $option_array['id'];

			if ( is_array( $type ) ) {
				foreach ( $type as $array ) {
					// T E X T
					//---------------------------------
					if ( $array['type'] == 'text' ) {
						$std 		= $array['std'];
						$new_value  = $output[ $id ];
						if ( $new_value == '' ) {
							$new_value = $std;
						}
						$new_value = stripslashes( $new_value );
					}

					// S O C I A B L E S
					//---------------------------------
					if ( $type == 'custom_socialbook_mark' ) {

						$std = $array['std'];
						$new_value = $output[ $id ];
						if ( $new_value == '' ) { $new_value = $std; }
						$new_value = stripslashes( $new_value );
					}
				}
			} elseif ( $type == 'select' ) {// S E L E C T
				//---------------------------------
				$new_value = isset( $output[ $option_array['id'] ] ) ? $output[ $option_array['id'] ]:'';
			} elseif ( $type == 'multiselect' ) {// M U L T I   S E L E C T
				//---------------------------------
				$new_value = isset( $output[ $option_array['id'] ] ) ? $output[ $option_array['id'] ]:'';
			} elseif ( $type == 'checkbox' ) {// C H E C K B O X
				//---------------------------------
				$new_value = isset( $output[ $option_array['id'] ] ) ? $output[ $option_array['id'] ]:'';
				$new_value != '' ? 'on':'off';
			} elseif ( $type == 'multicheck' ) {// M U L T I   C H E C K B O X
				//---------------------------------
				$new_value = array();
				$new_value = isset( $output[ $option_array['id'] ] ) ? $output[ $option_array['id'] ]:'';
			} elseif ( $type == 'typography' ) {// T Y P O G R A P H Y
				//---------------------------------
				$typography_array = array();
				$typography_array['size'] = $output[ $option_array['id'] . '_size' ];
				$typography_array['lineheight'] = $output[ $option_array['id'] . '_lineheight' ];
				$typography_array['style'] = $output[ $option_array['id'] . '_style' ];
				$typography_array['color'] = $output[ $option_array['id'] . '_color' ];
				$typography_array['fontvariant'] = $output[ $option_array['id'] . '_fontvariant' ];
				$new_value = $typography_array;
			} elseif ( $type == 'custom_google_fonts' ) {// Font Family
				//---------------------------------
				$new_value = isset( $output[ $option_array['id'] ] ) ? $output[ $option_array['id'] ]:'';
			} elseif ( $type == 'background' ) {// B A C K G R O U N D
				//---------------------------------
				$background_array = array();
				$background_array['image'] = $output[ $option_array['id'] . '_image' ];
				$background_array['color'] = $output[ $option_array['id'] . '_color' ];
				$background_array['repeat'] = $output[ $option_array['id'] . '_repeat' ];
				$background_array['position'] = $output[ $option_array['id'] . '_position' ];
				$background_array['attachment'] = $output[ $option_array['id'] . '_attachment' ];
				$new_value = $background_array;
			} elseif ( $type == 'teaserselect' ) {// T E A S E R S E L E C T
				//---------------------------------
				$teaserselect_array = array();
				$teaserselect_array['options'] = $output[ $option_array['id'] . '_options' ];
				$teaserselect_array['custom'] = stripslashes( $output[ $option_array['id'] . '_custom' ] );
				$new_value = $teaserselect_array;
			} elseif ( $type == 'customsidebar' ) {// C U S T O M   S I D E B A R
				//---------------------------------
				if ( isset( $output[ $option_array['id'] ] ) ) {
					$new_value = array();
					$new_value = $output[ $option_array['id'] ];
				}
			} elseif ( $type == 'sliderselect' ) {// S L I D E R   S E L E C T
				//---------------------------------
				$sliderselect_array = array();
				$sliderselect_array['slider'] = $output[ $option_array['id'] . '_slider' ];
				$new_value = $sliderselect_array;
			} elseif ( $type == 'border' ) {// B O R D E R
				//---------------------------------
				$border_array = array();
				$border_array['width'] = $output[ $option_array['id'] . '_width' ];
				$border_array['style'] = $output[ $option_array['id'] . '_style' ];
				$border_array['color'] = $output[ $option_array['id'] . '_color' ];
				$new_value = $border_array;
			} elseif ( $type == 'mmenu_ancestor' ) {// M E G A  M E N U
				//---------------------------------
				$mmenu_ancestor_array = array();
				$mmenu_ancestor_array['image'] 		= $output[ $option_array['id'] . '_image' ];
				$mmenu_ancestor_array['pleft'] 		= $output[ $option_array['id'] . '_pleft' ];
				$mmenu_ancestor_array['pbottom'] 	= $output[ $option_array['id'] . '_pbottom' ];
				$mmenu_ancestor_array['pright'] 	= $output[ $option_array['id'] . '_pright' ];
				$mmenu_ancestor_array['position'] 	= $output[ $option_array['id'] . '_position' ];
				$new_value = $mmenu_ancestor_array;
			} elseif ( $type == 'add_uislider' ) {// UI Slider
				//---------------------------------
				$footer_widget_layout_array = array();
				$footer_widget_layout_array['number'] = $output[ $option_array['id'] . '_number' ];
				$footer_widget_layout_array['result'] = $output[ $option_array['id'] . '_result' ];
				$new_value = $footer_widget_layout_array;
			} else { // Not Upload
				//---------------------------------
				$new_value = isset( $output[ $id ] ) ? $output[ $id ] : '';
			}

			//stripslashes before saving value into the database
			if ( $type != 'upload' ) {
				if ( ! is_array( $new_value ) ) {
					$new_value = stripslashes( $new_value );
				}
			}
			//update option values
			update_option( $id,$new_value );
		} // End if().
	} // End foreach().
}
/**
 * Generates The Options Within the Panel -
 * O P T I O N S F R A M E W O R K   M A C H I N E
 */
function vamico_fw_optionsframework_machine( $vamico_options ) {
	$counter = 0;
	$menu = $output = '';
	$menuitems = $s_headings = array();
	foreach ( $vamico_options as $key => $value ) {
		if ( $value['type'] == 'heading' || $value['type'] == 'subnav' ) {
			$s_headings[] = $value;
		}
	}
	$heading_key = 0;
	foreach ( $s_headings as $key => $value ) {
		$head = 'atp-option-' . preg_replace( '/[^a-zA-Z0-9\s]/', '', strtolower( trim( str_replace( ' ', '', $value['name'] ) ) ) );
		$value['head'] = $head;
		if ( $value['type'] == 'heading' ) {
			$menuitems[ $head ] = $value;
			$heading_key = $head;
		}
		if ( $value['type'] == 'subnav' ) {
			$menuitems[ $heading_key ]['children'][] = $value;
		}
	}

	foreach ( $vamico_options as $value ) {

		$counter++;
		$val = '';

		// H E A D I N G
		//---------------------------------
		if ( $value['type'] != 'heading' &&  $value['type'] != 'subnav' ) {
			$class = '';
			if ( isset( $value['class'] ) ) {
				$class = $value['class'];
			}
			$output .= '<div  class="section section-' . $value['type'] . ' ' . $class . '">' . "\n";
		}
		if ( ! isset( $value['desc'] ) ) {
			$explain_value = '';
		} else {
			$explain_value = $value['desc'];
		}
		$select_value = '';

		switch ( $value['type'] ) {

			// S U B S E C T I O N
			//---------------------------------
			case 'subsection':
					$default = $value['name'];
					$output .= '<div class="sub-section"><h1 class="sub-title">' . $default . '</h1>' . $explain_value . '</div>';
					break;

			// T E X T
			//---------------------------------
			case 'text':
				$val = $value['std'];
				$std = get_option( $value['id'] );
				if ( $std != '' ) { $val = $std; }
				$inputsize = isset( $value['inputsize'] ) ? $value['inputsize'] : '10';

				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<input class="atp-input" name="' . $value['id'] . '" id="' . $value['id'] . '" type="' . $value['type'] . '" value="' . esc_attr( $val ) . '" style="width:' . $inputsize . 'px" />';
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;
			// S E L E C T
			//---------------------------------
			case 'select':
				$class = '';
				if ( isset( $value['class'] ) ) {
					$class = $value['class'];
				}
				$value_options = isset( $value['options'] ) ? $value['options'] : '';

				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div class="select_wrapper ' . $class . '">';
				$output .= '<select class="of-input select " name="' . $value['id'] . '" id="' . $value['id'] . '">';
				if ( ! empty( $value_options ) ) {
					foreach ( $value_options as $key => $option ) {
						$output .= '<option value="' . $key . '" ' . selected( get_option( $value['id'] ),$key, false ) . ' />' . $option . '</option>';
					}
				}
				$output .= '</select>';
				$output .= '</div></div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;
			// M U L T I S E L E C T
			//---------------------------------
			case 'multiselect':
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div>';
				$output .= '<select class="of-input" multiple="multiple" name="' . $value['id'] . '[]" id="' . $value['id'] . '[]">';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( get_option( $value['id'] ) ) {
						if ( @in_array( $key, get_option( $value['id'] ) ) ) { $selected = 'selected=\"selected\"'; }
					} else {
						//Empty Value if Unchecked
					}
					$output .= '<option value="' . $key . '"  ' . $selected . ' />' . $option . '</option>';
				}
				$output .= '</select>';
				$output .= '</div></div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;
			// S O C I A B L E S
			//---------------------------------
			case 'custom_socialbook_mark':
				global $socialimages_select,$vamico_sociable;
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="explain">' . $explain_value . '</div><br>';
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div id="sys_social_book">';
				$output .= '<table id="sys_socialbookmark" class="fancy_table">';
				$output .= '<tr>';
				$output .= '<th width="100">' . esc_html__( 'Website', 'vamico' ) . '</th>';
				$output .= '<th width="100">' . esc_html__( 'URL', 'vamico' ) . '</th>';
				$output .= '<th width="100">' . esc_html__( 'Name', 'vamico' ) . '</th>';
				$output .= '<th align="center" width="70">' . esc_html__( 'Delete', 'vamico' ) . '</th>';
				$output .= '</tr>';
				$vamico_sociable = array(
					'adn'        	=> esc_html__( 'ADN', 'vamico' ),
					'android'    	=> esc_html__( 'Android', 'vamico' ),
					'behance'   	=> esc_html__( 'Behance', 'vamico' ),
					'delicious'  	=> esc_html__( 'Delicious', 'vamico' ),
					'deviantart' 	=> esc_html__( 'DeviantArt', 'vamico' ),
					'digg'       	=> esc_html__( 'Digg', 'vamico' ),
					'dribbble'   	=> esc_html__( 'Dribbble', 'vamico' ),
					'facebook'  	=> esc_html__( 'Facebook', 'vamico' ),
					'flickr'	 	=> esc_html__( 'Flickr', 'vamico' ),
					'google-plus' 	=> esc_html__( 'Google Plus', 'vamico' ),
					'instagram'  	=> esc_html__( 'Instagram', 'vamico' ),
					'lastfm'     	=> esc_html__( 'Lastfm', 'vamico' ),
					'linkedin'   	=> esc_html__( 'LinkedIn', 'vamico' ),
					'pinterest-p' 	=> esc_html__( 'Pinterest', 'vamico' ),
					'reddit'     	=> esc_html__( 'Reddit', 'vamico' ),
					'skype'      	=> esc_html__( 'Skype', 'vamico' ),
					'soundcloud' 	=> esc_html__( 'SoundCloud', 'vamico' ),
					'stumbleupon' 	=> esc_html__( 'Stumbleupon', 'vamico' ),
					'snapchat' 		=> esc_html__( 'Snapchat', 'vamico' ),
					'twitter'     	=> esc_html__( 'Twitter', 'vamico' ),
					'vimeo-square' 	=> esc_html__( 'Vimeo', 'vamico' ),
					'whatsapp'   	=> esc_html__( 'Whatsapp', 'vamico' ),
					'yahoo'      	=> esc_html__( 'Yahoo', 'vamico' ),
					'yelp'       	=> esc_html__( 'Yelp', 'vamico' ),
					'youtube'    	=> esc_html__( 'Youtube', 'vamico' ),
					'vk'         	=> esc_html__( 'VK', 'vamico' ),
					'paypal'	 	=> esc_html__( 'Paypal', 'vamico' ),
					'dropbox'    	=> esc_html__( 'Dropbox', 'vamico' ),
					'envelope'	 	=> esc_html__( 'Email', 'vamico' ),
				);
				if ( get_option( 'vamico_social_bookmark' ) != '' ) {
					$sys_social_items = explode( '#;', get_option( 'vamico_social_bookmark' ) );
					for ( $i = 0;$i < count( $sys_social_items );$i++ ) {
						$sys_social_item = explode( '#|', $sys_social_items[ $i ] );
						$output .= '<tr>';
						$output .= '<td>';
						$output .= '<select id="sys_social_file_icon" class="sys_social_file_icon" name="sys_social_file_icon"  width="300">';
						foreach ( $vamico_sociable as $key => $values ) {
							$selected = $sys_social_item[1] == $key ? ' selected="selected"' : '';
							$output .= '<option ' . $selected . ' value="' . $key . '" >' . $values . '</option>';
							$selected = '';
						}
						$output .= '</select>';
						$output .= '</td>';
						$output .= '<td><input type="text" class="sys_social_account_url" value="' . $sys_social_item[2] . '" /></td>';
						$output .= '<td><input type="text" class="sys_social_title" value="' . $sys_social_item[0] . '" /></td>';
						$output .= '<td><a href="#" class="sys_social_item_delete button button-primary red-button">' . esc_html__( 'Delete', 'vamico' ) . '</a></td>';
						$output .= '</tr>';
					}
				}
				$output .= '</table>';
				$output .= '<p>';
				$output .= '<button name="sys_add_social_book" id="sys_add_social_item" type="button" value="' . esc_attr__( 'Add New Row', 'vamico' ) . '" class="button button-primary red-button" /><span>' . esc_html__( 'Add New', 'vamico' ) . '</span></button>';
				$output .= '<input type="hidden" id="vamico_social_bookmark" name="vamico_social_bookmark"/>';
				$output .= '</p>';
				$output .= '</div></div>';
				break;
			// S I D E B A R
			//---------------------------------
			case 'customsidebar':
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$val = $value['std'];
				$std = get_option( $value['id'] );
				$custom_sidebar_arr = @get_option( $value['id'] );
				if ( $std != '' ) { $val = $std; }
				$output .= '<div id="custom_widget_sidebar"><table id="custom_widget_table" cellpadding="0" cellspacing="0">';
				$output .= '<tbody>';
				if ( $custom_sidebar_arr != '' ) {
					foreach ( $custom_sidebar_arr as $custom_sidebar_code ) {
						$output .= '<tr><td><input type="text" name="' . $value['id'] . '[]" value="' . $custom_sidebar_code . '"  size="30" style="width:97%" /></td><td><span class="button red-button iva_custom_siderbar_del">' . esc_html__( 'Delete', 'vamico' ) . '</span></td></tr>';
					}
				}
				$output .= '</tbody></table><button type="button" class="button blue-button button-large iva_custom_sidebar" id="' . esc_attr( $value['id'] ) . '[]"  name="add_custom_widget" value="' . esc_attr__( 'Add Sidebar', 'vamico' ) . '" >' . esc_html__( 'Add Sidebar', 'vamico' ) . '</button></div>';
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// T E X T A R E A
			//---------------------------------
			case 'textarea':
				$cols = '8';
				$ta_value = '';
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="explain">' . $explain_value . '</div>';
				$output .= '<div class="controls" >' . "\n";

				if ( isset( $value['std'] ) ) {
					$ta_value = $value['std'];
					if ( isset( $value['options'] ) ) {
						$ta_options = $value['options'];
						if ( isset( $ta_options['cols'] ) ) {
							$cols = $ta_options['cols'];
						} else {
							$cols = '8';
						}
					}
				}
				$std = get_option( $value['id'] );
				if ( $std != '' ) { $ta_value = stripslashes( $std ); }
				$output .= '<textarea class="atp-input" name="' . $value['id'] . '" id="' . $value['id'] . '" cols="' . $cols . '" rows="8">' . esc_textarea( $ta_value ) . '</textarea>';
				$output .= '</div>';
				break;

			// R A D I O
			//---------------------------------
			case 'radio':
				$select_value = get_option( $value['id'] );
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					if ( $select_value != '' ) {
						if ( $select_value == $key ) { $checked = ' checked'; }
					} else {
						if ( $value['std'] == $key ) { $checked = ' checked'; }
					}
					$output .= '<div class="controls" >' . "\n";
					$output .= '<input class="atp-input atp-radio" type="radio" name="' . $value['id'] . '" value="' . $key . '" ' . $checked . ' />' . $option . '<br />';
					$output .= '</div>';

				}
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// CHECKBOX
			//---------------------------------
			case 'checkbox':
				$std = $value['std'];
				$saved_std = get_option( $value['id'] );
				$checked = '';

				if ( ! empty( $saved_std ) ) {
					if ( $saved_std == 'on' ) {
						$checked = 'checked="checked"';
					} else {
						$checked = '';
					}
				} elseif ( $std == 'on' ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}

				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<input type="checkbox" class="checkbox" value="on" id="' . $value['id'] . '" name="' . $value['id'] . '" ' . $checked . ' />';
				$output .= '</div>';
				$output .= '<div class="explain"><label for="' . esc_attr( $value['id'] ) . '">' . $explain_value . '</label></div>';
				break;

			// M U L T I   C H E C K B O X
			//---------------------------------
			case 'multicheck':
				$std = $value['std'];
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					if ( get_option( $value['id'] ) ) {
						if ( @in_array( $key, get_option( $value['id'] ) ) ) {$checked = 'checked=\"checked\"';}
					} else {
						//Empty Value if Unchecked
					}
					$output .= '<input type="checkbox" class="checkbox" name="' . $value['id'] . '[]" id="' . $key . '" value="' . $key . '" ' . $checked . ' /> <label for="' . esc_attr( $key ) . '">' . $option . '</label><br>';
				}
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// U P L O A D
			//---------------------------------
			case 'upload':
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= vamico_fw_optionsframework_mediaupload( $value['id'], $val, null );
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// C O L O R
			//---------------------------------
			case 'color':
				$val = $value['std'];
				$stored  = get_option( $value['id'] );
				if ( $stored != '' ) { $val = $stored; }
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<input class="color" name="' . $value['id'] . '" id="' . $value['id'] . '" type="text" value="' . $val . '" />';
				$output .= '<div class="wpcolorSelector"><div  id="' . $value['id'] . '_picker" ></div></div>';
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// T Y P O G R A P H Y
			//---------------------------------
			case 'typography':
				$default = $value['std'];
				$typography_stored = get_option( $value['id'] );
				$output .= '<h3 class="heading">' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";

				// C O L O R
				if ( isset( $default['color'] ) ) {
					$val = $default['color'];
				}
				if ( $typography_stored['color'] != '' ) {
					$val = $typography_stored['color'];
				}
				$output .= '<div class="typocolor"><input class="atp-color atp-typography color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
				$output .= '<div class="wpcolorSelector"><div id="' . $value['id'] . '_color_picker"></div></div></div>';

				// F O N T   S I Z E
				$val = $default['size'];
				if ( $typography_stored['size'] != '' ) { $val = $typography_stored['size']; }
				$output .= '<div class="atp-typo-size"><div class="select_wrapper"><select class="select" name="' . $value['id'] . '_size" id="' . $value['id'] . '_size">';
				$output .= '<option value="">' . esc_html__( 'Font Size', 'vamico' ) . '</option>';
				for ( $i = 9; $i < 71; $i++ ) {
					if ( $val == $i ) {
						$active = 'selected="selected"';
					} else {
						$active = '';
					}
					$output .= '<option value="' . $i . 'px" ' . $active . '>' . $i . 'px</option>';
				}
				$output .= '</select></div></div>';

				// L I N E   H E I G H T
				$val = $default['lineheight'];
				if ( $typography_stored['lineheight'] != '' ) { $val = $typography_stored['lineheight']; }
				$output .= '<div class="atp-typo-lineheight"><div class="select_wrapper"><select class="select" name="' . $value['id'] . '_lineheight" id="' . $value['id'] . '_lineheight">';
				$output .= '<option value="">' . esc_html__( 'Line Height', 'vamico' ) . '</option>';
				for ( $i = 9; $i < 71; $i++ ) {
					if ( $val == $i ) {
						$active = 'selected="selected"';
					} else {
						$active = '';
					}
					$output .= '<option value="' . $i . 'px" ' . $active . '>' . $i . 'px</option>';
				}
				$output .= '</select></div></div>';

				// F O N T   S T Y L E
				$val = $default['style'];
				if ( $typography_stored['style'] != '' ) { $val = $typography_stored['style']; }
				$normal = '';
				$italic = '';
				if ( $val == 'normal' ) { $normal = 'selected="selected"'; }
				if ( $val == 'italic' ) { $italic = 'selected="selected"'; }
				$output .= '<div class="atp-typo-style"><div class="select_wrapper"><select class="select" name="' . $value['id'] . '_style" id="' . $value['id'] . '_style">';
				$output .= '<option value="">' . esc_html__( 'Font-Style', 'vamico' ) . '</option>';
				$output .= '<option value="normal" ' . $normal . '>' . esc_html__( 'Normal', 'vamico' ) . '</option>';
				$output .= '<option value="italic" ' . $italic . '>' . esc_html__( 'Italic', 'vamico' ) . '</option>';
				$output .= '</select></div></div>';

				// F O N T   V A R I A N T
				if ( isset( $default['fontvariant'] ) ) {
					$val = $default['fontvariant'];
				}
				if ( $typography_stored['fontvariant'] != '' ) { $val = $typography_stored['fontvariant']; }
				$array_weight = array(
					'normal'  => esc_html__( 'Normal', 'vamico' ),
					'bold' 	  => esc_html__( 'Bold', 'vamico' ),
					'lighter' => esc_html__( 'Lighter', 'vamico' ),
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				 );

				$output .= '<div class="atp-typo-fontvariant"><div class="select_wrapper"><select class="select" name="' . $value['id'] . '_fontvariant" id="' . $value['id'] . '_fontvariant">';
				$output .= '<option value="">' . esc_html__( 'Font-Variant', 'vamico' ) . '</option>';
				foreach ( $array_weight as $key => $values ) {
					$fontselected = '';
					if ( $val == $key ) { $fontselected = 'selected="selected"'; }
						$output .= '<option value="' . $key . '" ' . $fontselected . '>' . $values . '</option>';
				}
				$output .= '</select>';
				$output .= '</div></div>';
				$output .= '</div>'; // section-typography end.
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// F O N T  F A M I L Y S E L E C T
			// --------------------------------------------------
			case 'custom_google_fonts':
				global $vamico_fontface;
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div class="select_wrapper ' . $value['class'] . '">';
				$output .= '<select class="of-input select  google_font_select" name="' . $value['id'] . '" id="' . $value['id'] . '">';
				foreach ( $value['options'] as $select_key => $option ) {
					$output .= '<option value="' . $select_key . '" ' . selected( get_option( $value['id'] ),$key, false ) . ' />' . $option . '</option>';
				}
				$vamico_google_fonts = vamico_google_fonts();
				$output .= '<optgroup label="Google Web Fonts">';
				foreach ( $vamico_google_fonts as $key => $googlefont ) {
					$name = $googlefont['name'];
					$output .= '<option value="' . $name . '" ' . selected( get_option( $value['id'] ),$name, false ) . ' />' . $name . '</option>';
				}
				$output .= '</optgroup>';
				$output .= '</select></div>';

				if ( isset( $value['preview']['text'] ) ) {
					$g_text = $value['preview']['text'];

				} else {
					$g_text = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';

				}
				if ( isset( $value['preview']['size'] ) ) {
					$g_size = 'style="font-size: ' . $value['preview']['size'] . ';"';
				} else {
					$g_size = '';
				}
				$hide = 'hide';
				if ( get_option( $value['id'] ) != '' ) {
					$hide = '';
				}
				$output .= '<p  class="' . $value['id'] . '_ggf_previewer google_font_preview ' . $hide . '" ' . $g_size . '>' . $g_text . '</p>';
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// B A C K G R O U N D
			//---------------------------------
			case 'background':
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$default = $value['std'];
				$background_stored = get_option( $value['id'] );

				// U P L O A D   I M A G E
				$val = $default['image'];
				$imgid = $value['id'] . '_image';
				if ( $background_stored['image'] != '' ) { $val = $background_stored['image']; }
				$output .= '<div class="atp-background-upload clearfix">';
				$output .= vamico_fw_optionsframework_mediaupload( $imgid,$val,null );
				$output .= '</div>';

				// C O L O R
				$val = $default['color'];
				if ( $background_stored['color'] != '' ) { $val = $background_stored['color']; }
				$output .= '<div class="atp-background-color">';
				$output .= '<input class="color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
				$output .= '<div class="wpcolorSelector"><div  id="' . $value['id'] . '_color_picker" ></div></div>';
				$output .= '</div>';

				// R E P E A T
				$val = $default['repeat'];
				if ( isset( $background_stored['repeat'] ) != '' ) { $val = $background_stored['repeat']; }

				$repeat = $norepeat = $repeatx = $repeaty = '';

				if ( $val == 'repeat' ) { $repeat = 'selected="selected"'; }
				if ( $val == 'no-repeat' ) { $norepeat = 'selected="selected"'; }
				if ( $val == 'repeat-x' ) { $repeatx = 'selected="selected"'; }
				if ( $val == 'repeat-y' ) { $repeaty = 'selected="selected"'; }

				$output .= '<div class="atp-background-repeat">';
				$output .= '<div class="select_wrapper">';
				$output .= '<select class="atp-background select" name="' . $value['id'] . '_repeat" id="' . $value['id'] . '_repeat">';
				$output .= '<option value="repeat" ' . $repeat . '>' . esc_html__( 'Repeat', 'vamico' ) . '</option>';
				$output .= '<option value="no-repeat" ' . $norepeat . '>' . esc_html__( 'No-Repeat', 'vamico' ) . ' </option>';
				$output .= '<option value="repeat-x" ' . $repeatx . '>' . esc_html__( 'Repeat-X', 'vamico' ) . '</option>';
				$output .= '<option value="repeat-y" ' . $repeaty . '>' . esc_html__( 'Repeat-Y', 'vamico' ) . '</option>';
				$output .= '</select>';
				$output .= '</div></div>';

				// P O S I T I O N
				$val = $default['position'];
				if ( $background_stored['position'] != '' ) { $val = $background_stored['position']; }

				$lefttop = $leftcenter = $leftbottom = $righttop = $rightcenter = $rightbottom = $centertop = $centercenter = $centerbottom = '';
				if ( $val == 'left top' ) { $lefttop = 'selected="selected"'; }
				if ( $val == 'left center' ) { $leftcenter = 'selected="selected"'; }
				if ( $val == 'left bottom' ) { $leftbottom = 'selected="selected"'; }
				if ( $val == 'right top' ) { $righttop = 'selected="selected"'; }
				if ( $val == 'right center' ) { $rightcenter = 'selected="selected"'; }
				if ( $val == 'right bottom' ) { $rightbottom = 'selected="selected"'; }
				if ( $val == 'center top' ) { $centertop = 'selected="selected"'; }
				if ( $val == 'center center' ) { $centercenter = 'selected="selected"'; }
				if ( $val == 'center bottom' ) { $centerbottom = 'selected="selected"'; }

				$output .= '<div class="atp-background-position">';
				$output .= '<div class="select_wrapper">';
				$output .= '<select class="atp-background select" name="' . $value['id'] . '_position" id="' . $value['id'] . '_position">';
				$output .= '<option value="left top" ' . $lefttop . '>' . esc_html__( 'Left Top', 'vamico' ) . '</option>';
				$output .= '<option value="left center" ' . $leftcenter . '>' . esc_html__( 'Left Center', 'vamico' ) . '</option>';
				$output .= '<option value="left bottom" ' . $leftbottom . '>' . esc_html__( 'Left Bottom', 'vamico' ) . '</option>';
				$output .= '<option value="right top" ' . $righttop . '>' . esc_html__( 'Right Top', 'vamico' ) . '</option>';
				$output .= '<option value="right center" ' . $rightcenter . '>' . esc_html__( 'Right Center', 'vamico' ) . '</option>';
				$output .= '<option value="right bottom" ' . $rightbottom . '>' . esc_html__( 'Right Bottom', 'vamico' ) . '</option>';
				$output .= '<option value="center top" ' . $centertop . '>' . esc_html__( 'Center Top', 'vamico' ) . '</option>';
				$output .= '<option value="center center" ' . $centercenter . '>' . esc_html__( 'Center Center', 'vamico' ) . '</option>';
				$output .= '<option value="center bottom" ' . $centerbottom . '>' . esc_html__( 'Center Bottom', 'vamico' ) . '</option>';
				$output .= '</select>';
				$output .= '</div></div>';

				// A T T A C H M E N T
				$val = $default['attachment'];
				if ( $background_stored['attachment'] != '' ) {
					$val = $background_stored['attachment'];
				}

				$fixed = $scroll = '';

				if ( $val == 'fixed' ) {
					$fixed = 'selected="selected"';
				}
				if ( $val == 'scroll' ) {
					$scroll = 'selected="selected"';
				}

				$output .= '<div class="atp-background-attachment">';
				$output .= '<div class="select_wrapper">';
				$output .= '<select class="atp-background select" name="' . $value['id'] . '_attachment" id="' . $value['id'] . '_attachment">';
				$output .= '<option value="fixed" ' . $fixed . '>' . esc_html__( 'Fixed', 'vamico' ) . '</option>';
				$output .= '<option value="scroll" ' . $scroll . '>' . esc_html__( 'Scroll', 'vamico' ) . '</option>';
				$output .= '</select>';
				$output .= '</div></div>';
				$output .= '</div>'; //controls part end
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// I M A G E S
			//---------------------------------
			case 'images':
				$i = 0;
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$select_value = get_option( $value['id'] );
				foreach ( $value['options'] as $key => $option ) {
					$i++;
					$checked = $selected = '';

					if ( $select_value != '' ) {
						if ( $select_value == $key ) {
							$checked = ' checked';
							$selected = 'iva-radio-option-selected';
						}
					} else {
						if ( $value['std'] == $key ) {
							$checked = ' checked';
							$selected = 'iva-radio-option-selected';
						} elseif ( $i == 1  && ! isset( $select_value ) ) {
							$checked = ' checked';
							$selected = 'iva-radio-option-selected';
						} elseif ( $i == 1  && $value['std'] == '' ) {
							$checked = ' checked';
							$selected = 'iva-radio-option-selected';
						} else {
							$checked = '';
						}
					}
					$output .= '<span>';
					$output .= '<input type="radio" id="iva-radio-img-' . $value['id'] . $i . '" class="checkbox iva-radio-img-radio" value="' . $key . '" name="' . $value['id'] . '" ' . $checked . ' />';
					$output .= '<div class="iva-radio-img-label">' . $key . '</div>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . $key . '" class="iva-radio-option ' . $selected . '" data-id="iva-radio-img-' . $value['id'] . $i . '"  />';
					$output .= '</span>';
				}
				$output .= '</div>';
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;
			// H E A D I N G
			//---------------------------------
			case 'heading':
				if ( $counter >= 2 ) {
					$output .= '</div>' . "\n";
				}
				$jquery_click_hook = str_replace( ' ', '', strtolower( $value['name'] ) );
				$jquery_click_hook = "atp-option-" . trim( preg_replace( '/ +/', '', preg_replace( '/[^A-Za-z0-9 ]/', '', urldecode( html_entity_decode( strip_tags( $jquery_click_hook ) ) ) ) ) );
				$output .= '<div class="group" id="' . $jquery_click_hook . '">' . "\n";
				break;
			//S U B  N A V I G A T I O N
			//---------------------------------
			case 'subnav':
				if ( $counter >= 2 ) {
					$output .= '</div>' . "\n";
				}
				$jquery_click_hook = str_replace( ' ', '', strtolower( $value['name'] ) );
				$jquery_click_hook = "atp-option-" . trim( preg_replace( '/ +/', '', preg_replace( '/[^A-Za-z0-9 ]/', '', urldecode( html_entity_decode( strip_tags( $jquery_click_hook ) ) ) ) ) );
				$output .= '<div class="group" id="' . $jquery_click_hook . '">' . "\n";
				break;
			//E X P O R T  B A C K U P O P T I O N S
			//---------------------------------
			case 'export_backupoptions':
				$output .= '<form class="export_form" method="post" enctype="multipart/form-data">';
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div class="iva_export_ob_msg"></div>';

				// Export Backup options
				$output .= '<span class="iva_style_wrap"><a href="#" class="export-data-btn button button-hero blue-button" data-url= ' . admin_url( 'admin.php?page=optionsframework' ) . '>' . esc_html__( 'Export Options','vamico' ) . '</a></span>';
				$output .= '<div class="clearfix"></div>';
				$output .= '</div>';//.controls
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;
			//I M P O R T  B A C K U P O P T I O N S
			//---------------------------------
			case 'import_backupoptions':
				$output .= '<form class="export_form" method="post" enctype="multipart/form-data">';
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";
				$output .= '<div class="iva_import_ob_msg"></div>';
				$output .= '<div class="clearfix"></div>';
				$theme_options_txt_files  = array();
				$theme_options_backup_dir = list_files( VAMICO_FRAMEWORK_DIR . '/admin/options-importer/export_options' );
				foreach ( $theme_options_backup_dir as $file ) {
				    if ( ! is_dir( VAMICO_FRAMEWORK_DIR . '/admin/options-importer/export_options' . $file ) ) {
						if ( stristr( $file, '.txt' ) !== false ) {
							$theme_options_txt_files[ $file ] = $file;
						}
				    }
				}
				ksort( $theme_options_txt_files );
				if ( ! empty( $theme_options_txt_files ) ) {
					$i = 1;
					foreach ( $theme_options_txt_files as $ob_txt_name => $ob_txt_value ) {
						$ob_file_info = pathinfo( $ob_txt_value );
						$ob_file_name = $ob_file_info['basename'];
						$output .= '<div class="export_wrap">';
						$output .= '<div class="export_ob_wrap"><div class="export_ob_title">' . $i . ' . ' . $ob_file_name . '</div></div>';
						$output .= '<div class="export_ob_btn">';
						$output .= '<span><a class="ob_import button green-button" data-url= ' . admin_url( 'admin.php?page=optionsframework' ) . ' data-import="' . $ob_file_name . '">' . esc_html__( 'Import','vamico' ) . '</a></span>';
						$output .= '<span><a class="ob_delete button red-button" data-url= ' . admin_url( 'admin.php?page=optionsframework' ) . ' data-delete="' . $ob_file_name . '" >' . esc_html__( 'Delete','vamico' ) . '</a></span>';
						$output .= '</div>';//.export_ob_btn
						$output .= '</div>';//.export_wrap
						$i++;
					}
				}
				$output .= '<div class="clearfix"></div>';

				$vamico_ob_txtarea_cols = '8';
				$output .= '<div class="import-options-bkp">';
				$output .= '<p>' . wp_kses( __( 'Input your sample options data exported in a text file to restore. Copy the content from the text file then place in below textarea and hit <strong>Import File</strong> button', 'vamico' ),
					array(
						'strong' => array(),
					)
				) . '</p>';
				$output .= '<textarea class="atp-input import_ob_input" id="import_ob_input" cols="' . $vamico_ob_txtarea_cols . '" rows="8" data-url= ' . admin_url( 'admin.php?page=optionsframework' ) . '></textarea>';
				$output .= '<span><a class="import_options_btn button green-button button-hero" data-url= ' . admin_url( 'admin.php?page=optionsframework' ) . '>' . esc_html__( 'Import File', 'vamico' ) . '</a></span>';
				$output .= '</div>';
				$output .= '</div>';//.controls
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

			// Mega menu case
			case 'mmenu_ancestor':
				$output .= '<h3>' . $value['name'] . '</h3>' . "\n";
				$output .= '<div class="controls" >' . "\n";

				$mm_img_val = $mm_position = '';
				$mm_pright = $mm_pbottom = $mm_pleft = '0';

				$mm_img_id = $value['id'] . '_image';

				$mmenu_stored = get_option( $value['id'] );
				if ( $mmenu_stored != '' ) {
					$mm_img_val	= $mmenu_stored['image'];
					$mm_pright = $mmenu_stored['pright'];
					$mm_pbottom = $mmenu_stored['pbottom'];
					$mm_pleft = $mmenu_stored['pleft'];
					$mm_position = $mmenu_stored['position'];
				}

				$output .= '<div class="mm_upload atp-background-upload clearfix">';
				$output .= vamico_fw_optionsframework_mediaupload( $mm_img_id,$mm_img_val,null );
				$output .= '</div>';

				$position_lb = $position_rb = $position_cb = '';

				// Adds selected attribute for the option value
				if ( $mm_position == 'left bottom' ) { $position_lb = 'selected="selected"' ; }
				if ( $mm_position == 'right bottom' ) { $position_rb = 'selected="selected"' ; }
				if ( $mm_position == 'center bottom' ) { $position_cb = 'selected="selected"' ; }

				$output .= '<div class="mm_desc">' . esc_html__( 'Background position', 'vamico' ) . '</div>';
				$output .= '<div class="select_wrapper select200">';
				$output .= '<select class="atp-background select" name="' . $value['id'] . '_position" id="' . $value['id'] . '_position">';
				$output .= '<option value="left bottom" ' . $position_lb . '>' . esc_html__( 'Left Bottom', 'vamico' ) . '</option>';
				$output .= '<option value="right bottom" ' . $position_rb . '>' . esc_html__( 'Right Bottom', 'vamico' ) . '</option>';
				$output .= '<option value="center bottom" ' . $position_cb . '>' . esc_html__( 'Center Bottom', 'vamico' ) . '</option>';
				$output .= '</select>';
				$output .= '</div>';//select_wrapper

				$output .= '<div class="clear"></div>';

				$output .= '<div class="mm_wrap">';
				$output .= '<div class="mm_desc">' . esc_html__( 'Padding', 'vamico' ) . '</div>';
				$output .= '<input class="input40 input_disable" name="' . $value['id'] . '_ptop" id="' . $value['id'] . '_ptop" type="text" readonly="readonly" value="25"/>';
				$output .= '<input class="input40" name="' . $value['id'] . '_pright" id="' . $value['id'] . '_pright" type="text"  value="' . $mm_pright . '" />';
				$output .= '<input class="input40" name="' . $value['id'] . '_pbottom" id="' . $value['id'] . '_pbottom" type="text" value="' . $mm_pbottom . '" />';
				$output .= '<input class="input40" name="' . $value['id'] . '_pleft" id="' . $value['id'] . '_pleft" type="text" value="' . $mm_pleft . '" />';
				$output .= '<div class="mm_desc">';
				$output .= '<span>' . esc_html__( 'Top', 'vamico' ) . '</span>';
				$output .= '<span>' . esc_html__( 'Right', 'vamico' ) . '</span>';
				$output .= '<span>' . esc_html__( 'Bottom', 'vamico' ) . '</span>';
				$output .= '<span>' . esc_html__( 'Left', 'vamico' ) . '</span>';
				$output .= '</div>';
				$output .= '</div>';//mm_wrap
				$output .= '</div>'; //controls part end
				$output .= '<div class="explain">' . $explain_value . '</div>';
				break;

				case 'add_uislider':
					$number = $result = '';
					$footer_widget_layout = get_option( $value['id'] );
					if ( ! empty( $footer_widget_layout ) ) {
						$number = $footer_widget_layout['number'];
						$result = $footer_widget_layout['result'];
					}
			        $output .= '<h3>' . $value['name'] . '</h3>' . "\n";
			        $output .= '<div class="controls" >' . "\n";
					$output .= '<div class="select_wrapper select300">';
					$output .= '<select class="of-input select" name="' . $value['id'] . '_number" id="' . $value['id'] . '_number">';
					for ( $i = 1; $i <= 6; $i++ ) {
						$output .= '<option value="' . $i . '" ' . selected( $number, $i, false ) . ' />' . $i .'</option>';
					}
					$output .= '</select>';
					$output .= '</div>';
					$output .= '<div class="clear"></div>';
					// Slider
					$output .= '<div id="vamico_ui_slider" class="cus-col-slider"></div>';
					$output .= '<input type="hidden" class="slider_result" value="' . $result . '" name="' . $value['id'] . '_result" id="' . $value['id'] . '_result"  />';
					$output .= '<input type="hidden" class="slider_result_db_values" value="' . $result . '">';
					$output .= '<input type="hidden" class="slider_result_db_cols" value="' . $number . '">';
					$output .= '</div>';//.controls
					$output .= '<div class="explain">' . $explain_value . '</div>';
					break;
			}

		//------------------------------------
		//	E N D   S W I T C H   C A S E
		//------------------------------------
		// Option Value Type
		// if TYPE is an array, formatted into smaller inputs... ie smaller values
		if ( is_array( $value['type'] ) ) {
			foreach ( $value['type'] as $array ) {
				$id = $array['id'];
				$std = $array['std'];
				$saved_std = get_option( $id );
				if ( $saved_std != $std ) {
					$std = $saved_std;
				}
				$meta = $array['meta'];
				if ( $array['type'] == 'text' ) { // Only text at this point
					$output .= '<input class="input-text-small atp-input" name="' . $id . '" id="' . $id . '" type="text" value="' . $std . '" />';
					$output .= '<span class="meta-two">' . $meta . '</span>';
				}
			}
		}

		// Option Value not equals to Headings and checkbox
		if ( $value['type'] != 'heading' && $value['type'] != 'subnav' ) {
			if ( $value['type'] != 'checkbox' ) {
				$output .= '';
			}
			$output .= '</div>' . "\n";
		}
	} // End foreach().

	if ( count( $menuitems ) > 0 ) {

		$menu = '';

		foreach ( $menuitems as $key => $value ) {
			if ( isset( $v['icon'] ) && ( $v['icon'] != '' ) ) { }

			if ( isset( $value['children'] ) && ( count( $value['children'] ) > 0 ) ) {
				$class = 'parent';
				$hasdropdown = 'class="dropmenu"';
			} else {
				$class = 'parent no-child';
				$hasdropdown = '';
			}

			$menu .= '<li ' . $hasdropdown . '>' . "\n" . '';

			$menu .= '<a class="' . $class . '" title="' . $value['name'] . '" href="#' . $value['head'] . '"><i class="fa ' . esc_attr( $value['icon'] ) . ' fa-fw"></i> ' . $value['name'] . '</a>' . "\n";
			if ( isset( $value['children'] ) && ( count( $value['children'] ) > 0 ) ) {
				$menu .= '<ul class="sub-menu">' . "\n";
				foreach ( $value['children'] as $i => $j ) {
					$menu .= '<li>' . "\n" . '<a  title="' . $j['name'] . '" href="#' . $j['head'] . '">' . $j['name'] . '</a></li>' . "\n";
				}
				$menu .= '</ul>' . "\n";
			}
			$menu .= '</li>' . "\n";

		}
	}

	$output .= '</div>';
	return array( $output, $menu, $menuitems );
}
// E N D   -   O P T I O N S   F R A M E W O R K   M A C H I N E
//--------------------------------------------------------------

/**
 * Media Uploader Using the WordPress Media Library.
 *
 * Parameters:
 * - string $_id - A token to identify this field (the name).
 * - string $_value - The value of the field, if present.
 * - string $_mode - The display mode of the field.
 * - string $_desc - An optional description of the field.
 * - int $_postid - An optional post id (used in the meta boxes).
 *
 * Dependencies:
 * - optionsframework_mlu_get_silentpost()
 */
if ( ! function_exists( 'vamico_fw_optionsframework_mediaupload' ) ) {
	function vamico_fw_optionsframework_mediaupload( $_id, $_value, $_mode = 'full', $_desc = '', $_postid = 0, $_name = '' ) {

		/* new code*/
		$option_name = get_option( $_id );

		$output = $id = $class = $int = $name = '';

		$value = get_option( $_id );
		$id = strip_tags( strtolower( $_id ) );
		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}
		if ( $_name != '' ) {
			$name = $option_name . '[' . $id . '][' . $_name . ']';
		} else {
			$name = $option_name . '[' . $id . ']';
		}

		if ( $value ) { $class = ' has-file'; }

		$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="' . $id . '" value="' . $value . '" />' . "\n";
		$output .= '<input id="upload_' . $id . '" class="upload_button button-primary button-large" type="button" value="' . esc_html__( 'Upload', 'vamico' ) . '" rel="' . $int . '" />' . "\n";

		if ( $_desc != '' ) {
			$output .= '<span class="of_metabox_desc">' . $_desc . '</span>' . "\n";
		}

		$output .= '<div class="clear"></div><div class="iva-screenshot" id="' . $id . '_image">' . "\n";

		if ( $value != '' ) {
			$remove = '<a href="javascript:(void);" class="custom_clear_image_button button button-primary">x</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif*)/i', $value );

			if ( $image ) {
				$image_attributes = wp_get_attachment_image_src( vamico_get_attachment_id_from_src( $value ) );

				$attachments_id = vamico_get_attachment_id_from_src( $value );

				$alt_text = get_post_meta( $attachments_id, '_wp_attachment_image_alt', true );
				if ( empty( $alt_text ) ) { // If not, Use the Caption
					$attachment = get_post( $attachments_id );
					$alt_text   = trim( strip_tags( $attachment->post_excerpt ) );
				}
				if ( empty( $alt_text ) ) { // Finally, use the title
					$attachment = get_post( $attachments_id );
					$alt_text   = trim( strip_tags( $attachment->post_title ) );
				}

				if ( '' !== $image_attributes[0] ) {
					$output .= '<img src="' . esc_url( $image_attributes[0] ) . '" alt="' . $alt_text . '" />' . $remove . '';
				} else {
					$output .= '<img src="' . esc_url( $value ) . '" alt="' . $alt_text . '" />' . $remove . '';
				}
			} else {
				$parts = explode( '/', $value );
				for ( $i = 0; $i < count( $parts ); ++$i ) {
					$title = $parts[ $i ];
				}

				// No output preview if it's not an image.
				$output .= '';

				// Standard generic output if it's not an image.
				$title = esc_html__( 'View File', 'vamico' );
				$output .= '<div class="no_image"><span class="file_link"></span>' . $remove . '</div>';
			}
		}
		$output .= '</div>' . "\n";
		return $output;
	}
} // End if().

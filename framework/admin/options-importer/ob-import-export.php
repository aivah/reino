<?php
// Export Options Backup
add_action( 'wp_ajax_vamico_export_ob', 'vamico_export_object' );
add_action( 'wp_ajax_nopriv_vamico_export_ob', 'vamico_export_object' );
function vamico_export_object() {

	global $wpdb, $wp_filesystem;

	$url = wp_nonce_url( 'themes.php?page=optionsframework' );
	if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, 'save' ) ) ) {
		return true;
	}
	// now we have some credentials, try to get the wp_filesystem running
	if ( ! WP_Filesystem( $creds ) ) {
		// our credentials were no good, ask the user for them again
		request_filesystem_credentials( $url, '', true, false,'save' );
		return true;
	}

	$theme_options = wp_json_encode( serialize( ( get_option( 'vamico_theme_option_values' ) ) ) );
	$timestamp = date( 'd-m-y' ) . '_' . time();
	$export_filename   = 'theme_options_' . $timestamp . '.txt';
	$theme_options_dir = get_parent_theme_file_path() . '/framework/admin/options-importer/export_options/' . $export_filename;
	$wp_filesystem->put_contents( $theme_options_dir, $theme_options );
	$filesize = $wp_filesystem->size( $theme_options_dir );
	exit;
}

// Import Options Backup from file
add_action( 'wp_ajax_vamico_import_ob_from_file', 'vamico_import_object_from' );
add_action( 'wp_ajax_nopriv_vamico_import_ob_from_file', 'vamico_import_object_from' );
function vamico_import_object_from() {
	global $wpdb, $vamico_options;

	$theme_options_txt = isset( $_POST['import_ob_file'] ) ? stripslashes( $_POST['import_ob_file'] ) : '';

	if ( isset( $theme_options_txt ) ) {

		$options_data = unserialize( json_decode( $theme_options_txt ) );
		update_option( 'vamico_theme_option_values', $options_data ); // update theme options
		if ( count( $options_data ) > 1 ) {
			vamico_update_option_values( $vamico_options, $options_data );
		}
	}
	exit;
}

// Import Options Backup
add_action( 'wp_ajax_vamico_import_ob', 'vamico_import_object' );
add_action( 'wp_ajax_nopriv_vamico_import_ob', 'vamico_import_object' );
function vamico_import_object() {
	global $wpdb, $vamico_options;

	$ob_import_filename = isset( $_POST['ob_import'] ) ? $_POST['ob_import'] :'';
	$theme_options_txt = get_parent_theme_file_uri() . '/framework/admin/options-importer/export_options/' . $ob_import_filename;
	if ( isset( $theme_options_txt ) ) {
		$theme_options_txt = wp_remote_get( $theme_options_txt );
		$options_data = unserialize( json_decode( $theme_options_txt['body'] ) );
		update_option( 'vamico_theme_option_values', $options_data ); // update theme options
		if ( count( $options_data ) > 1 ) {
			vamico_update_option_values( $vamico_options,$options_data );
		}
	}
	exit;
}
// Delete File
add_action( 'wp_ajax_vamico_delete_ob', 'vamico_delete_object' );
add_action( 'wp_ajax_nopriv_vamico_delete_ob', 'vamico_delete_object' );
function vamico_delete_object() {
	global $wpdb;
	$ob_delete_file = isset( $_POST['delete_file'] ) ? $_POST['delete_file'] :'';
	$ob_delete_path = get_parent_theme_file_path() . '/framework/admin/options-importer/export_options/' . $ob_delete_file;
	unlink( $ob_delete_path );
}

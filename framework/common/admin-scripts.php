<?php
/**
 * function vamico_admin_enqueue_scripts
 * Enqueue Scripts in admin
 */
if ( ! function_exists( 'vamico_admin_enqueue_scripts' ) ) {
	function vamico_admin_enqueue_scripts() {

		$vamico_theme_data   = wp_get_theme();
		$vamico_theme_version = $vamico_theme_data->Version;

		wp_enqueue_script( 'vamico-of-script', VAMICO_FRAMEWORK_URI . 'admin/js/vamico-of-script.js', array(), $vamico_theme_version );

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_localize_script( 'vamico-of-script', 'vamico_localize_script_param', array(
			'SiteUrl' => get_parent_theme_file_uri(),
		));
		wp_localize_script( 'vamico-of-script', 'vamico_admin_js_param', array(
			'themeoption_reset' 	  => esc_html__( 'Click OK to reset. Any settings will be lost!', 'vamico' ),
			'importing_data_load' 	  => esc_html__( 'Importing the sample data will overwrite your current pages and content. Please make sure you take a backup of content and proceed with importing.', 'vamico' ),
			'importer_success' 		  => esc_html__( 'Imported Successfully, please wait a few seconds to reload the page', 'vamico' ),
			'ob_import_success' 	  => esc_html__( 'Imported successfully, please wait a few seconds until reloading the page', 'vamico' ),
			'importer_delete_confirm' => esc_html__( 'Are you sure you want to delete this theme options permanently?', 'vamico' ),
			'importer_delete_success' => esc_html__( 'Deleted successfully, please wait few seconds until the page reloads', 'vamico' ),
		));
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'vamico-admin-style', VAMICO_FRAMEWORK_URI . 'admin/css/admin-style.css', array(), $vamico_theme_version );
		wp_enqueue_style( 'vamico-ui-core-style', VAMICO_FRAMEWORK_URI . 'admin/css/jquery-ui.min.css' );
		wp_enqueue_style( 'font-awesome', VAMICO_THEME_CSS . '/fontawesome/css/font-awesome.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'vamico_admin_enqueue_scripts' );

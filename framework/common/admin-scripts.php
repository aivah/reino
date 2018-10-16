<?php
/**
 * function reino_admin_enqueue_scripts
 * Enqueue Scripts in admin
 */
if ( ! function_exists( 'reino_admin_enqueue_scripts' ) ) {
	function reino_admin_enqueue_scripts() {

		$reino_theme_data    = wp_get_theme();
		$reino_theme_version = $reino_theme_data->Version;

		wp_enqueue_script( 'reino-of-script', REINO_FRAMEWORK_URI . 'admin/js/reino-of-script.js', array(), $reino_theme_version );

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_localize_script( 'reino-of-script', 'reino_localize_script_param', array(
			'SiteUrl' => get_parent_theme_file_uri(),
		));
		wp_localize_script( 'reino-of-script', 'reino_admin_js_param', array(
			'themeoption_reset'       => esc_html__( 'Click OK to reset. Any settings will be lost!', 'reino' ),
			'importing_data_load'     => esc_html__( 'Importing the sample data will overwrite your current pages and content. Please make sure you take a backup of content and proceed with importing.', 'reino' ),
			'importer_success'        => esc_html__( 'Imported Successfully, please wait a few seconds to reload the page', 'reino' ),
			'ob_import_success'       => esc_html__( 'Imported successfully, please wait a few seconds until reloading the page', 'reino' ),
			'importer_delete_confirm' => esc_html__( 'Are you sure you want to delete this theme options permanently?', 'reino' ),
			'importer_delete_success' => esc_html__( 'Deleted successfully, please wait few seconds until the page reloads', 'reino' ),
		));
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'reino-admin-style', REINO_FRAMEWORK_URI . 'admin/css/admin-style.css', array(), $reino_theme_version );
		wp_enqueue_style( 'reino-ui-core-style', REINO_FRAMEWORK_URI . 'admin/css/jquery-ui.min.css' );
		wp_enqueue_style( 'font-awesome', REINO_THEME_CSS . '/fontawesome/css/font-awesome.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'reino_admin_enqueue_scripts' );

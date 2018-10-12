<?php
// Sidebar
?>
<div id="sidebar" class="sidebar">
<div class="content widget-area">
<?php
$reino_widget = '';
/**
 * Check if widget pages are there
 * then display opted widgets for that page's sidebar
 * else display default sidebar
 */
if ( is_archive() || is_search() ) {
	// If Woocommerce is Installed and Active
	if ( class_exists( 'woocommerce' ) && is_shop() ) {
		$reino_wc_shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$reino_widgets         = get_post_meta( $reino_wc_shop_page_id, 'reino_custom_widget', true );
		$reino_widget          = strtolower( preg_replace( '/\s+/', '-', $reino_widgets ) );
	}
} else {
	$reino_widgets = get_post_meta( $post->ID, 'reino_custom_widget', true );
	$reino_widget  = strtolower( preg_replace( '/\s+/', '-', $reino_widgets ) );
}
/**
 * If current page falls under widget pages
 * then display sidebar widgets accordingly
 * Otherwise display default widgets
 */
if ( $reino_widget && is_active_sidebar( 'sidebar-' . $reino_widget ) ) {
	dynamic_sidebar( 'sidebar-' . $reino_widget );
} else {
	if ( is_active_sidebar( 'defaultsidebar' ) ) {
		dynamic_sidebar( 'defaultsidebar' );
	}
}
?>
</div>
</div>
<?php

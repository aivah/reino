<?php
// Sidebar
?>
<div id="sidebar" class="sidebar">
<div class="content widget-area">
<?php
$vamico_widget = '';
/**
 * Check if widget pages are there
 * then display opted widgets for that page's sidebar
 * else display default sidebar
 */
if ( is_archive() || is_search() ) {
	// If Woocommerce is Installed and Active
	if ( class_exists( 'woocommerce' ) && is_shop() ) {
		$vamico_wc_shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$vamico_widgets         = get_post_meta( $vamico_wc_shop_page_id, 'vamico_custom_widget', true );
		$vamico_widget          = strtolower( preg_replace( '/\s+/', '-', $vamico_widgets ) );
	}
} else {
	$vamico_widgets = get_post_meta( $post->ID, 'vamico_custom_widget', true );
	$vamico_widget  = strtolower( preg_replace( '/\s+/', '-', $vamico_widgets ) );
}
/**
 * If current page falls under widget pages
 * then display sidebar widgets accordingly
 * Otherwise display default widgets
 */
if ( $vamico_widget && is_active_sidebar( 'sidebar-' . $vamico_widget ) ) {
	dynamic_sidebar( 'sidebar-' . $vamico_widget );
} else {
	if ( is_active_sidebar( 'defaultsidebar' ) ) {
		dynamic_sidebar( 'defaultsidebar' );
	}
}
?>
</div>
</div>
<?php

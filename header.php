<?php
/**
 * The template for displaying the header
 * @package WordPress
 * @subpackage Vamico
 * @since Vamico 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	// Adds site icon with a fallback
	if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {
		if ( get_option( 'vamico_custom_favicon' ) ) {
			echo '<link rel="shortcut icon" href="' . esc_url( get_option( 'vamico_custom_favicon' ) ) . '" type="image/x-icon">';
		}
	}
	?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
// Pulls an frontpage id ID for page slider
if (
	is_tag() ||
	is_search() ||
	is_404() ||
	is_home()
) {
	$vamico_frontpageid = '';
} else {
	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() ) {
			$vamico_frontpageid = get_option( 'woocommerce_shop_page_id' );
		} elseif ( is_cart( get_option( 'woocommerce_cart_page_id' ) ) ) {
			$vamico_frontpageid = get_option( 'woocommerce_cart_page_id' );
		} else {
			$vamico_frontpageid = $post->ID;
		}
	} else {
		$vamico_frontpageid = $post->ID;
	}
}
// General Preloader
$vamico_page_preloader = get_option( 'vamico_page_preloader' ) ? get_option( 'vamico_page_preloader' ) : '';
if ( 'on' !== $vamico_page_preloader ) {
	echo '<div class="vamico_page_loader"></div>';
}

$vamico_body_pattern     = get_option( 'vamico_overlayimages' );
$vamico_page_layout_mode = get_option( 'vamico_layoutoption' ) ? esc_attr( get_option( 'vamico_layoutoption' ) ) : 'stretched';
$vamico_page_layout      = get_post_meta( $vamico_frontpageid, 'vamico_page_layout', true );
if ( 'on' === $vamico_page_layout ) {
	$vamico_page_layout_mode = 'boxed';
}

?>
<div class="<?php echo esc_attr( $vamico_page_layout_mode ); ?>" id="<?php echo esc_attr( $vamico_page_layout_mode ); ?>">
	<?php
	if ( ! empty( $vamico_body_pattern ) ) {
		echo '<div class="bodyoverlay"></div>';
	}
	?>
	<div id="wrapper" class="wrapper">
	<?php
	// Switch Headers
	$vamico_headerstyle = get_option( 'vamico_headerstyle' ) ? get_option( 'vamico_headerstyle' ) : '';
	switch ( $vamico_headerstyle ) {
		case 'headerstyle1':
			get_template_part( 'headers/header', 'style1' );
			break;
		case 'headerstyle2':
			get_template_part( 'headers/header', 'style2' );
			break;
		case 'headerstyle3':
			get_template_part( 'headers/header', 'style3' );
			break;
		case 'fixedheader':
			get_template_part( 'headers/header', 'fixed' );
			break;
		default:
			get_template_part( 'headers/header', 'style1' );
	}
	if ( is_front_page() ) {
		// Get Slider based on the option selected in theme options panel
		if ( get_option( 'vamico_slidervisble' ) !== 'on' ) {
			$vamico_chooseslider = get_option( 'vamico_slider' );
			switch ( $vamico_chooseslider ) :
				case 'static_image':
					get_template_part( 'slider/static', 'slider' );
					break;
				case 'owl_slider':
					get_template_part( 'slider/owl', 'slider' );
					break;
				case 'customslider':
					get_template_part( 'slider/custom', 'slider' );
					break;
				case 'default':
					get_template_part( 'slider/default', 'slider' );
					break;
				default:
					get_template_part( 'slider/owl', 'slider' );
			endswitch;
		}
	}

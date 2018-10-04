<?php
$vamico_gallery        = get_post_meta( get_the_ID(), 'vamico_post_gallery', true );
$vamico_gallery_layout = get_post_meta( get_the_ID(), 'vamico_post_gallery_layout', true );
echo '<div class="post__gallery">';
if ( 'justified' == $vamico_gallery_layout ) {
	if ( ! empty( $vamico_gallery ) ) {
		$vamico_gallery_ids = explode( ',', $vamico_gallery );
		echo '<div class="gallery-justified">';
		foreach ( $vamico_gallery_ids as $img_id ) {
			echo '<figure>';
			echo wp_get_attachment_link( $img_id, 'large', false, false, false );
			echo '</figure>';
		}
		echo '</div>';
	}
} elseif ( 'slider' == $vamico_gallery_layout ) {
	do_action( 'vamico_theme_owlslider', get_the_ID() );
	if ( ! empty( $vamico_gallery ) ) {
		$vamico_gallery_ids = explode( ',', $vamico_gallery );
		echo '<div class="owl-container gallery-slider">';
		echo '<div class="owl-carousel" id="vamico_postformat_gallery">';
		foreach ( $vamico_gallery_ids as $img_id ) {
			echo '<div class="owl-item">' . wp_get_attachment_image( $img_id, 'vamico-large-horizontal' ) . '</div>';
		}
		echo '</div>';//.owl-carousel
		echo '</div><div class="clear"></div>';
	}
}
echo '</div>';

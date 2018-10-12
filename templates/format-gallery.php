<?php
$reino_gallery        = get_post_meta( get_the_ID(), 'reino_post_gallery', true );
$reino_gallery_layout = get_post_meta( get_the_ID(), 'reino_post_gallery_layout', true );
echo '<div class="post__gallery">';
if ( 'justified' == $reino_gallery_layout ) {
	if ( ! empty( $reino_gallery ) ) {
		$reino_gallery_ids = explode( ',', $reino_gallery );
		echo '<div class="gallery-justified">';
		foreach ( $reino_gallery_ids as $img_id ) {
			echo '<figure>';
			echo wp_get_attachment_link( $img_id, 'large', false, false, false );
			echo '</figure>';
		}
		echo '</div>';
	}
} elseif ( 'slider' == $reino_gallery_layout ) {
	do_action( 'reino_theme_owlslider', get_the_ID() );
	if ( ! empty( $reino_gallery ) ) {
		$reino_gallery_ids = explode( ',', $reino_gallery );
		echo '<div class="owl-container gallery-slider">';
		echo '<div class="owl-carousel" id="reino_postformat_gallery">';
		foreach ( $reino_gallery_ids as $img_id ) {
			echo '<div class="owl-item">' . wp_get_attachment_image( $img_id, 'reino-large-horizontal' ) . '</div>';
		}
		echo '</div>';//.owl-carousel
		echo '</div><div class="clear"></div>';
	}
}
echo '</div>';

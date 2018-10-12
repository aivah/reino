<?php // Static Slider; ?>
<div class="featured_slider">
	<div class="slider_wrapper">
		<div id="static-slider" class="staticslider">
		<?php
		$width = '';
		if ( 'boxed' === get_option( 'reino_layoutoption' ) ) {
			$width = '1280';
		} else {
			$width = '1920';
		}
		$src           = get_option( 'reino_static_image_upload' );
		$link          = esc_url( get_option( 'reino_static_link' ) );
		$attachment_id = reino_get_attachment_id_from_src( $src );

		echo '<figure>';
		if ( '' !== $link ) {
			echo wp_get_attachment_image( $attachment_id, 'reino-extra-large', '', '' );
		} else {
			echo wp_get_attachment_image( $attachment_id, 'reino-extra-large', '', '' );
		}
		echo '</figure>';
		?>
		</div>
	</div>
</div>
<?php

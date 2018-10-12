<?php
$reino_audio_mp3   = get_post_meta( get_the_ID(), 'reino_audio_mp3', true );
$reino_audio_ogg   = get_post_meta( get_the_ID(), 'reino_audio_ogg', true );
$reino_audio_embed = get_post_meta( get_the_ID(), 'reino_audio_embed', true );
if ( ! empty( $reino_audio_embed ) || ! empty( $reino_audio_ogg ) || ! empty( $reino_audio_mp3 ) ) {
	if ( ! empty( $reino_audio_embed ) ) {
		echo '<div class="post__audio">' . do_shortcode( $reino_audio_embed ) . '</div>';
	} else {
		$reino_audio_output = '[audio ';
		if ( ! empty( $reino_audio_mp3 ) ) {
			$reino_audio_output .= 'mp3="' . $reino_audio_mp3 . '" ';
		}
		if ( ! empty( $reino_audio_ogg ) ) {
			$reino_audio_output .= 'ogg="' . $reino_audio_ogg . '"';
		}
		$reino_audio_output .= ']';
		echo '<div class="post__audio">';
		echo do_shortcode( $reino_audio_output );
		echo '</div>';
	}
}

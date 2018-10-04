<?php
$vamico_audio_mp3   = get_post_meta( get_the_ID(), 'vamico_audio_mp3', true );
$vamico_audio_ogg   = get_post_meta( get_the_ID(), 'vamico_audio_ogg', true );
$vamico_audio_embed = get_post_meta( get_the_ID(), 'vamico_audio_embed', true );
if ( ! empty( $vamico_audio_embed ) || ! empty( $vamico_audio_ogg ) || ! empty( $vamico_audio_mp3 ) ) {
	if ( ! empty( $vamico_audio_embed ) ) {
		echo '<div class="post__audio">' . do_shortcode( $vamico_audio_embed ) . '</div>';
	} else {
		$vamico_audio_output = '[audio ';
		if ( ! empty( $vamico_audio_mp3 ) ) {
			$vamico_audio_output .= 'mp3="' . $vamico_audio_mp3 . '" ';
		}
		if ( ! empty( $vamico_audio_ogg ) ) {
			$vamico_audio_output .= 'ogg="' . $vamico_audio_ogg . '"';
		}
		$vamico_audio_output .= ']';
		echo '<div class="post__audio">';
		echo do_shortcode( $vamico_audio_output );
		echo '</div>';
	}
}

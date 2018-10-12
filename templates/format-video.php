<?php
$video_embed  = get_post_meta( get_the_ID(), 'reino_video_embed', true );
$video_m4v    = get_post_meta( get_the_ID(), 'reino_video_m4v', true );
$video_ogv    = get_post_meta( get_the_ID(), 'reino_video_ogv', true );
$video_poster = get_post_meta( get_the_ID(), 'reino_video_poster', true );
if ( ! empty( $video_embed ) || ! empty( $video_m4v ) || ! empty( $video_ogv ) ) {
	$wp_version = floatval( get_bloginfo( 'version' ) );
	// video embed
	if ( ! empty( $video_embed ) ) {
		echo '<div class="post__video">' . do_shortcode( $video_embed ) . '</div>';
	} elseif ( $wp_version >= '3.6' ) {
		// self hosted video post 3-6
		if ( ! empty( $video_m4v ) || ! empty( $video_ogv ) ) {
			$video_output = '[video ';
			if ( ! empty( $video_m4v ) ) {
				$video_output .= 'mp4="' . $video_m4v . '"';
			}
			if ( ! empty( $video_ogv ) ) {
				$video_output .= 'ogv="' . $video_ogv . '"';
			}
			$video_output .= ' poster="' . $video_poster . '"]';
			echo '<div class="video">' . do_shortcode( $video_output ) . '</div>';
		}
	}
}

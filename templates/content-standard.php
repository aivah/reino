<?php

echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'post-standard' ) ) ) . '">';
// Post Header
reino_post_header();
// Post thumbnail
reino_post_media();
// Post Entry

if ( 'post_excerpt' === get_option( 'reino_post_content' ) ) {
	echo '<div class="post__excerpt">';
	echo reino_string_limit_words( get_the_excerpt(), 50 );
	echo '</div>';//.post__excerpt
} elseif ( 'post_full' === get_option( 'reino_post_content' ) ) {
	echo '<div class="post__content">';
	the_content();
	echo '</div>';//.post__content
}

echo reino_read_more( '', 'btn btn-primary btn-lg' );
echo '</article>';

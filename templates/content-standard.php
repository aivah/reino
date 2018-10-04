<?php

echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'post-standard' ) ) ) . '">';
// Post Header
vamico_post_header();
// Post thumbnail
vamico_post_media();
// Post Entry
if ( has_excerpt() ) {
	if ( ! is_archive() ) {
		echo '<div class="post__excerpt">';
		echo vamico_string_limit_words( get_the_excerpt(), 45 );
		echo '</div>';//.post__excerpt
	}
} else {
	if ( ! is_archive() ) {
		echo '<div class="post__excerpt">';
		echo wp_trim_words( strip_shortcodes( get_the_content() ), 45, $more = null );
		echo '</div>';//.post__excerpt
	} else {
		echo '<div class="post__content">';
		the_content();
		echo '</div>';//.post__content
	}
}
echo vamico_read_more( '', 'btn btn-primary btn-lg' );
echo '</article>';

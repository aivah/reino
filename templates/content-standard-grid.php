<?php
global $vamico_post_count;
if ( 1 == $vamico_post_count ) {
	echo '<div class="item-grid col-md-12 grid-first-post">';
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( array( 'post-standard', 'grid-item', 'post-gs-fp' ) ) ) ) . '">';
	// Post Header
	vamico_post_header();
	// Post thumbnail
	vamico_post_media();
	// Post Entry
	echo '<div class="post__excerpt">';
	if ( has_excerpt() ) {
		echo vamico_string_limit_words( get_the_excerpt(), 35 );
	} else {
		echo wp_trim_words( strip_shortcodes( get_the_content() ), 35, $more = null );
	}
	echo '</div>';//.post__excerpt
	echo vamico_read_more( '', 'btn btn-primary btn-lg' );
	echo '</article>';
	echo '</div>';
} else {
	echo '<div class="item-grid col-md-6">';
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'grid-item' ) ) ) . '">';
	// Post thumbnail
	if ( has_post_thumbnail() ) {
		echo '<div class="post__thumbnail">';
		echo get_the_post_thumbnail( get_the_ID(), 'vamico-medium-horizontal' );
		// Read Time
		echo '<div class="post__thumbnail-meta">';
		vamico_the_post_meta( array( 'readtime', 'views' ), true );
		echo '</div>';//.post__thumb
		echo '<a class="hover__link" href="' . esc_url( get_the_permalink() ) . '"></a>';
		echo '</div>';//.post__thumbnail
	}
	vamico_post_header();
	vamico_blog_post_entry();
	vamico_read_more( '', 'btn btn-primary' );
	echo '</article>';
	echo '</div>';
}

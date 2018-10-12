<?php
global $reino_post_count;
if ( 1 == $reino_post_count ) {
	echo '<div class="item-grid col-md-12 grid-first-post">';
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( array( 'post-standard', 'grid-item', 'post-gs-fp' ) ) ) ) . '">';
	// Post Header
	reino_post_header();
	// Post thumbnail
	reino_post_media();
	// Post Entry
	echo '<div class="post__excerpt">';
	if ( 'post_excerpt' === get_option( 'reino_post_content' ) ) {
		echo '<div class="post__excerpt">';
		echo reino_string_limit_words( get_the_excerpt(), 50 );
		echo '</div>';//.post__excerpt
	} elseif ( 'post_full' === get_option( 'reino_post_content' ) ) {
		echo '<div class="post__content">';
		the_content();
		echo '</div>';//.post__content
	}
	echo '</div>';//.post__excerpt
	echo reino_read_more( '', 'btn btn-primary btn-lg' );
	echo '</article>';
	echo '</div>';
} else {
	echo '<div class="item-grid col-md-6">';
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'grid-item' ) ) ) . '">';
	// Post thumbnail
	if ( has_post_thumbnail() ) {
		echo '<div class="post__thumbnail">';
		echo get_the_post_thumbnail( get_the_ID(), 'reino-medium-horizontal' );
		// Read Time
		echo '<div class="post__thumbnail-meta">';
		reino_the_post_meta( array( 'readtime', 'views' ), true );
		echo '</div>';//.post__thumb
		echo '<a class="hover__link" href="' . esc_url( get_the_permalink() ) . '"></a>';
		echo '</div>';//.post__thumbnail
	}
	reino_post_header();
	reino_blog_post_entry();
	reino_read_more( '', 'btn btn-primary' );
	echo '</article>';
	echo '</div>';
}

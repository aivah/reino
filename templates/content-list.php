<?php
echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'list-item' ) ) ) . '">';
echo '<div class="row">';
// Post thumbnail
if ( has_post_thumbnail() ) {
	$columns = '8';
} else {
	$columns = '12';
}

if ( has_post_thumbnail() ) {
	echo '<div class="col-md-4">';
	echo '<div class="post__thumbnail">';
	echo '<a class="hover__link" href="' . esc_url( get_the_permalink() ) . '">';
	echo get_the_post_thumbnail( get_the_ID(), 'reino-medium-vertical' );
	echo '</a>';
	// Read Time
	echo '<div class="post__thumbnail-meta">';
	if ( get_option( 'reino_postmeta' ) !== 'on' ) {
		reino_the_post_meta( array( 'readtime', 'views' ), true );
	}
	echo '</div>';//.post__thumb
	echo '</div>';//.post__thumbnail
	echo '</div>';//.col-md-4
}
echo '<div class="col-md-' . esc_attr( $columns ) . '">';
echo '<div class="list__content">';
reino_post_header();
reino_blog_post_entry();
reino_read_more( '', 'btn btn-primary' );
echo '</div>';
echo '</div>';//.col-md-8
echo '</div>';
echo '</article>';

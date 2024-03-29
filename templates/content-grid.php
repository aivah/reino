<?php

$vamico_join_postclass = join( ' ', get_post_class( 'grid-item' ) );

echo '<div class="col-md-6 item-grid">';
echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( $vamico_join_postclass ) . '">';
// Post thumbnail
if ( has_post_thumbnail() ) {
	echo '<div class="post__thumbnail">';
	echo get_the_post_thumbnail( get_the_ID(), 'vamico-medium-uncropped' );
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

<?php
global $vamico_post_count;
if ( 1 == $vamico_post_count ) {
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( array( 'post-standard', 'list-item', 'post-ls-fp' ) ) ) ) . '">';
	// Post Header
	vamico_post_header();
	// Post thumbnail
	vamico_post_media();
	// Post Entry
	echo '<div class="post__excerpt">';
	if ( has_excerpt() ) {
		echo vamico_string_limit_words( get_the_excerpt(), 35 );
	} else {
		echo wp_trim_words( get_the_content(), 35, $more = null );
	}
	echo '</div>';//.post__excerpt
	echo vamico_read_more( '', 'btn btn-primary btn-lg' );
	echo '</article>';

} else {
	echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'list-item' ) ) ) . '">';
	echo '<div class="row">';
	// Post thumbnail
	if ( has_post_thumbnail() ) {
		echo '<div class="col-md-4">';
		echo '<div class="post__thumbnail">';
		echo get_the_post_thumbnail( get_the_ID(), 'vamico-medium-vertical' );
		// Read Time
		echo '<div class="post__thumbnail-meta">';
		vamico_the_post_meta( array( 'readtime', 'views' ), true );
		echo '</div>';//.post__thumb
		echo '<a class="hover__link" href="' . esc_url( get_the_permalink() ) . '"></a>';
		echo '</div>';//.post__thumbnail
		echo '</div>';//.col-md-4
		echo '<div class="col-md-8">';
		echo '<div class="list__content">';
		vamico_post_header();
		vamico_blog_post_entry();
		vamico_read_more( '', 'btn btn-primary' );
		echo '</div>';
		echo '</div>';//.col-md-8
	} else {
		echo '<div class="col-md-12">';
		echo '<div class="list__content">';
		vamico_post_header();
		vamico_blog_post_entry();
		vamico_read_more( '', 'btn btn-primary' );
		echo '</div>';
		echo '</div>';//.col-md-8
	}
	echo '</div>';
	echo '</article>';
}

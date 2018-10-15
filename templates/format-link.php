<?php
$reino_format_link = get_post_meta( get_the_ID(), 'reino_link_url', true );
if ( ! empty( $reino_format_link ) ) {
	echo '<div class="post__link">';
	echo '<h2 class="entry-title"><a href="' . esc_url( $reino_format_link ) . '" rel="bookmark">' . get_the_title() . '</a></h2>';
	echo '<h4 class="sub-title"><a href="' . esc_url( $reino_format_link ) . '" rel="bookmark" target="_blank"><i class="fa fa-link fa-fw"></i>&nbsp;' . esc_attr( $reino_format_link ) . '</a></h4>';
	echo '</div>';
}

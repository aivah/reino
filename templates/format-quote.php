<?php
$reino_pf_quote = get_post_meta( get_the_ID(), 'reino_quote_text', true );
if ( ! empty( $reino_pf_quote ) ) {
	echo '<div class="post__quote">';
	echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" rel="bookmark">';
	echo '<p class="quote">' . esc_textarea( $reino_pf_quote ) . '<span>' . get_the_title() . '</span></p>';
	echo '</a>';
	echo '</div>';
}

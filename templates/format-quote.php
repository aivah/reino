<?php
$vamico_pf_quote = get_post_meta( get_the_ID(), 'vamico_quote_text', true );
if ( ! empty( $vamico_pf_quote ) ) {
	echo '<div class="post__quote">';
	echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" rel="bookmark">';
	echo '<p class="quote">' . esc_textarea( $vamico_pf_quote ) . '<span>' . get_the_title() . '</span></p>';
	echo '</a>';
	echo '</div>';
}

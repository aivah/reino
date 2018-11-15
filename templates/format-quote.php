<?php

global $allowed_html;
$reino_pf_quote = get_post_meta( get_the_ID(), 'reino_quote_text', true );

if ( ! empty( $reino_pf_quote ) ) {
	echo '<blockquote>';
	echo '<p>' . wp_kses( $reino_pf_quote, $allowed_html ) . '</p>';
	echo '</blockquote>';
}

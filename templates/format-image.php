<?php
if ( has_post_thumbnail() ) {
	echo '<div class="post__thumbnail">';
	echo get_the_post_thumbnail( get_the_ID(), 'vamico-extra-large' );
	echo '</div>';
}

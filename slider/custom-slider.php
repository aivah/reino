<div class="featured_slider">
	<div class="slider_stretched">
	<?php
	$slider = get_option( 'vamico_customslider' );
	echo do_shortcode( $slider );
	?>
	</div>
</div>
<?php

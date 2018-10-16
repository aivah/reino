<?php

$reino_slider_cat      = get_option( 'reino_slider_cat' );
$reino_slider_img_size = get_option( 'reino_slider_img_size' )
						? get_option( 'reino_slider_img_size' )
						: 'reino-medium-horizontal';

$reino_slider_post_ids = get_option( 'reino_slider_post_ids' );
?>
<div class="featured_slider clearfix">
	<div class="sliders">
<?php do_action( 'reino_flexslider_scripts', get_the_ID() ); ?>
<?php
if ( '' !== $reino_slider_cat ) {
	$reino_slider_query = array(
		'posts_per_page' => -1,
		'tax_query'      => array(
			'relation' => 'OR',
		),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);

	$reino_tax_cat = array(
		'taxonomy' => 'category',
		'field'    => 'slug',
		'terms'    => $reino_slider_cat,
	);
	array_push( $reino_slider_query['tax_query'], $reino_tax_cat );
} elseif ( '' !== $reino_slider_post_ids ) {
	$reino_slider_ids_array = explode( ',', $reino_slider_post_ids );
	$reino_slider_query = array(
		'posts_per_page' => $reino_owlslider_limit,
		'post__in'       => $reino_slider_ids_array,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
} else {
	$reino_slider_query = array(
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
}

$reino_slider = new WP_Query( $reino_slider_query );

echo '<div class="flex-img flexslider">';
echo '<ul class="slides">';
while ( $reino_slider->have_posts() ) :
	$reino_slider->the_post();
	if ( has_post_thumbnail() ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_ID(), $reino_slider_img_size );
		echo '<li class="flex-thumb">';
		echo '<img src="' . esc_url( $thumbnail[0] ) . '" alt="' . get_the_title() . '">';
		echo '</li>';
	}
endwhile;
wp_reset_postdata();
echo '</ul>';
echo '</div>';
?>

<div class="flex-details flexslider">
	<ul class="slides">
		<?php
		while ( $reino_slider->have_posts() ) :
			$reino_slider->the_post();
			if ( has_post_thumbnail() ) {
				echo '<li class="flex-caption">';
				echo esc_html( reino_post_category() );
				echo '<h2><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h2>';
				if ( 'on' !== get_option( 'reino_postmeta' ) ) {
					reino_the_post_meta( array( 'date', 'author' ), true );
				}
			}
			echo '</li>';
		endwhile;
		wp_reset_postdata();
		?>
	</ul>
</div>

<div class="slider-controls">
	<div class="slide-numbers">
		<div class="total-slide-numb"></div>
		<span class="timeline">
			<span></span>
		</span>
		<div class="current-slide-numb"></div>
	</div>
	<div class="custom-direction-nav">
		<?php
		$counter = -1;
		while ( $reino_slider->have_posts() ) :
			$reino_slider->the_post();
			if ( has_post_thumbnail() ) {
				$counter++;
				echo '<a rel="' . $counter . '" class="slide_thumb" title="' . get_the_title() . '" href="#"></a>';
			}
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</div>
</div> <!-- .sliders  -->
</div><!-- .featured_slider -->
<?php

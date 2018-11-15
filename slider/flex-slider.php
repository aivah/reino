<?php

$reino_slider_cat      = get_option( 'reino_slider_cat' );
$reino_slider_img_size = get_option( 'reino_slider_img_size' )
						? get_option( 'reino_slider_img_size' )
						: 'reino-large-horizontal';

$reino_slider_post_ids = get_option( 'reino_slider_post_ids' );
?>
<div class="featured_slider">
	<div class="flex-inner">
		<?php

		do_action( 'reino_flexslider_scripts', get_the_ID() );

		if ( '' !== $reino_slider_cat ) {

			$reino_slider_query = array(
				'posts_per_page' => 5,
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
				'posts_per_page' => 5,
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

		// Caption Slider
		echo '<div class="flex-details flexslider">';
		echo '<ul class="slides">';
		while ( $reino_slider->have_posts() ) :
			$reino_slider->the_post();
			if ( has_post_thumbnail() ) {
				echo '<li class="flex-caption">';
				echo esc_html( reino_post_category() );
				echo '<h2 class="flex-title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h2>';
				if ( 'on' !== get_option( 'reino_postmeta' ) ) {
					reino_the_post_meta( array( 'date', 'author' ), true );
				}
			}
			echo '</li>';
		endwhile;
		wp_reset_postdata();
		echo '</ul>';
		echo '</div>';

		// Slider Numbers
		echo '<div class="slider-controls">';
		echo '<div class="slide-numbers">';
		echo '<div class="total-slide-numb"></div>';
		echo '<span class="timeline"><span></span></span>';
		echo '<div class="current-slide-numb"></div>';
		echo '</div>';
		echo '<div class="custom-direction-nav">';

		$counter = -1;
		while ( $reino_slider->have_posts() ) :
			$reino_slider->the_post();
			if ( has_post_thumbnail() ) {
				$counter++;
				echo '<a rel="' . $counter . '" class="slide_thumb" title="' . get_the_title() . '" href="#"></a>';
			}
		endwhile;
		wp_reset_postdata();
		echo '</div>';
		echo '</div>';
		?>

</div> <!-- .sliders  -->
</div><!-- .featured_slider -->
<?php

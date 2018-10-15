<?php
$reino_owlslider_limit    = get_option( 'reino_owlslider_limit' ) ? get_option( 'reino_owlslider_limit' ) : '-1';
$reino_slider_cat         = get_option( 'reino_slider_cat' );
$reino_slider_caption_pos = get_option( 'reino_slider_caption_pos' );
$reino_slider_post_ids    = get_option( 'reino_slider_post_ids' );
$reino_owl_slider_type    = get_option( 'reino_owl_slider_type' ) ? get_option( 'reino_owl_slider_type' ) : 'owl-boxed';
$reino_owl_slides_number  = get_option( 'reino_owl_slides_number' ) ? get_option( 'reino_owl_slides_number' ) : '3';
$reino_slider_img_size    = get_option( 'reino_slider_img_size' ) ? get_option( 'reino_slider_img_size' ) : 'reino-medium-horizontal';

$reino_owlslider_capoverlay = get_option( 'reino_owlslider_capoverlay' )
							? get_option( 'reino_owlslider_capoverlay' )
							: '';

if ( 'on' !== $reino_owlslider_capoverlay ) {
	$reino_owlslider_capoverlay = 'owl__caption-overlay ';
}

?>
<div class="featured_slider clearfix" >
<?php do_action( 'reino_theme_owlslider', get_the_ID() ); ?>
	<div class="owl-container owl-featured">
		<div class="owl-carousel owl-theme
		<?php
		echo esc_attr( $reino_owlslider_capoverlay );
		?>
		owl-<?php echo esc_attr( $reino_owl_slider_type ); ?>"
		<?php
		if ( 'columns' == $reino_owl_slider_type ) {
			echo 'data-slidesnumber="' . esc_attr( $reino_owl_slides_number ) . '"';
		}
		?>
		>
		<?php

		if ( '' !== $reino_slider_cat ) {
			$reino_slider_query = array(
				'posts_per_page' => $reino_owlslider_limit,
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
				'posts_per_page' => $reino_owlslider_limit,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			);
		}

		$reino_slider = new WP_Query( $reino_slider_query );

		while ( $reino_slider->have_posts() ) :
			$reino_slider->the_post();

			if ( has_post_thumbnail() ) {

				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_ID(), $reino_slider_img_size );

				echo '<article class="' . esc_attr( join( ' ', get_post_class() ) ) . '">';
				echo '<div class="owl__post ' . $reino_owlslider_capoverlay . $reino_slider_caption_pos . '">';
				echo '<img src="' . esc_url( $thumbnail[0] ) . '" alt="' . get_the_title() . '">';
				echo '<div class="owl__caption">';
				echo '<div class="owl__fullscreen" data-animation-in="slideInUp" data-animation-out="animate-out slideOutDown" >';
				echo esc_html( reino_post_category() );
				echo '<h2 class="owl__title" data-animation-in="slideInDown" data-animation-out="animate-out slideOutUp">';
				echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h2>';
				if ( 'on' !== get_option( 'reino_postmeta' ) ) {
					reino_the_post_meta( array( 'date', 'author' ), true );
				}
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</article>';
			}
			endwhile;
			wp_reset_postdata();
			?>
		</div><!-- .owlcarousel -->
	</div>
	<!--</div> .slider_inner -->
</div><!-- .featured_slider -->
<?php

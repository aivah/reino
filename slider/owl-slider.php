<?php
$vamico_owlslider_limit    = get_option( 'vamico_owlslider_limit' ) ? get_option( 'vamico_owlslider_limit' ) : '-1';
$vamico_slider_cat         = get_option( 'vamico_slider_cat' );
$vamico_slider_caption_pos = get_option( 'vamico_slider_caption_pos' );
$vamico_slider_post_ids    = get_option( 'vamico_slider_post_ids' );
$vamico_owl_slider_type    = get_option( 'vamico_owl_slider_type' ) ? get_option( 'vamico_owl_slider_type' ) : 'boxed';
$vamico_owl_slides_number  = get_option( 'vamico_owl_slides_number' ) ? get_option( 'vamico_owl_slides_number' ) : '3';
$vamico_slider_img_size    = get_option( 'vamico_slider_img_size' ) ? get_option( 'vamico_slider_img_size' ) : 'vamico-medium-horizontal';

$vamico_owlslider_capoverlay = get_option( 'vamico_owlslider_capoverlay' )
							? get_option( 'vamico_owlslider_capoverlay' )
							: '';

if ( 'on' !== $vamico_owlslider_capoverlay ) {
	$vamico_owlslider_capoverlay = 'owl__caption-overlay ';
}

?>
<div class="featured_slider clearfix" >
<?php do_action( 'vamico_theme_owlslider', get_the_ID() ); ?>
	<div class="owl-container owl-featured">
		<div class="owl-carousel
		<?php
		echo esc_attr( $vamico_owlslider_capoverlay );
		?>
		owl-<?php echo esc_attr( $vamico_owl_slider_type ); ?>"
		<?php
		if ( 'multiple' == $vamico_owl_slider_type ) {
			echo 'data-slidesnumber="' . esc_attr( $vamico_owl_slides_number ) . '"'; }
		?>
			<?php
			if ( '' !== $vamico_slider_cat ) {
				$vamico_slider_query = array(
					'posts_per_page' => $vamico_owlslider_limit,
					'tax_query'      => array(
						'relation' => 'OR',
					),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				);

				$vamico_tax_cat = array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $vamico_slider_cat,
				);
				array_push( $vamico_slider_query['tax_query'], $vamico_tax_cat );
			} elseif ( '' !== $vamico_slider_post_ids ) {
				$vamico_slider_ids_array = explode( ',', $vamico_slider_post_ids );

				$vamico_slider_query = array(
					'posts_per_page' => $vamico_owlslider_limit,
					'post__in'       => $vamico_slider_ids_array,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				);
			} else {
				$vamico_slider_query = array(
					'posts_per_page' => $vamico_owlslider_limit,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				);
			}

			$vamico_slider = new WP_Query( $vamico_slider_query );

			while ( $vamico_slider->have_posts() ) :
				$vamico_slider->the_post();

				if ( has_post_thumbnail() ) {

					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_ID(), $vamico_slider_img_size );

					echo '<article class="' . esc_attr( join( ' ', get_post_class() ) ) . '">';
					echo '<div class="owl__post ' . $vamico_owlslider_capoverlay . $vamico_slider_caption_pos . '">';
					echo '<img src="' . esc_url( $thumbnail[0] ) . '" alt="' . get_the_title() . '">';
					echo '<div class="owl__caption">';
					echo '<div class="owl__large" data-animation-in="slideInUp" data-animation-out="animate-out slideOutDown" >';
					echo esc_html( vamico_post_category() );
					if ( get_option( 'vamico_postmeta' ) !== 'on' ) {
						vamico_the_post_meta( array( 'date', 'author', 'comments' ), true );
					}

					echo '<h2 class="owl__title" data-animation-in="slideInDown" data-animation-out="animate-out slideOutUp">';
					echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h2>';
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

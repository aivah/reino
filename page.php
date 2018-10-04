<?php
// Includes the header.php template file from your current theme's directory
get_header();

$vamico_featured_img_type = '';
$vamico_featured_img      = '';

$vamico_featured_img_val = get_post_meta( get_the_ID(), 'vamico_featured_img_type', true )
						? get_post_meta( get_the_ID(), 'vamico_featured_img_type', true )
						: 'default';

$vamico_featured_loc_opt = get_option( 'vamico_featured_img_pos' )
						? get_option( 'vamico_featured_img_pos' )
						: 'inside_post';

$vamico_featured_location = get_post_meta( get_the_ID(), 'vamico_featured_img_pos', true )
						? get_post_meta( get_the_ID(), 'vamico_featured_img_pos', true )
						: $vamico_featured_loc_opt;

$vamico_featured_desc     = get_post_meta( get_the_ID(), 'vamico_featured_desc', true );
$vamico_featured_styling  = get_post_meta( get_the_ID(), 'vamico_featured_styling', true );
$vamico_featured_bgcolor  = get_post_meta( get_the_ID(), 'vamico_featured_bgcolor', true );
$vamico_featured_txtcolor = get_post_meta( get_the_ID(), 'vamico_featured_txtcolor', true );

$vamico_fs_txtcolor_val = $vamico_featured_txtcolor ? 'color:' . $vamico_featured_txtcolor . ';' : '';
$vamico_fs_bgcolor_val  = $vamico_featured_bgcolor ? 'background-color:' . $vamico_featured_bgcolor . ';' : '';
$vamico_fs_txt_css      = ( '' !== $vamico_fs_txtcolor_val ) ? ' style="' . $vamico_fs_txtcolor_val . '"' : '';
$vamico_fs_bg_css       = ( '' !== $vamico_fs_bgcolor_val ) ? ' style="' . $vamico_fs_bgcolor_val . '"' : '';

if ( 'default' === $vamico_featured_img_val ) {
	$vamico_featured_img_type = get_option( 'vamico_featured_img_type' )
								? get_option( 'vamico_featured_img_type' )
								: 'standard';
} else {
	$vamico_featured_img_type = $vamico_featured_img_val;
}

if ( 'inside_post' === $vamico_featured_location && 'wide' === $vamico_featured_img_type ) {
	echo wp_kses_post( vamico_featured_content( get_the_ID() ) );
}
?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<?php
			if ( 'outside_post' === $vamico_featured_location ) {
				if ( has_post_thumbnail() ) {
					echo '<div class="outside_content">';
					echo '<div class="post__thumb">';
					echo get_the_post_thumbnail( get_the_ID(), 'vamico-extra-large' );
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="outside_content ' . esc_attr( $vamico_featured_styling ) . '" ' . $vamico_fs_bg_css . '>';
					echo '<div class="outside_box">';
					echo '<h1 ' . $vamico_fs_txt_css . '>' . get_the_title( get_the_ID() ) . '</h1>';
					if ( ! empty( $vamico_featured_desc ) ) {
						echo '<p ' . $vamico_fs_txt_css . '>' . wp_kses_post( $vamico_featured_desc ) . '</p>';
					}
					echo '</div>';
					echo '</div>';
				}
			}
			?>
			<main class="content-area">
				<div class="entry-content-wrapper entry-content">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							?>
							<?php
							if ( 'inside_post' === $vamico_featured_location ) {
								if ( ( 'standard' === $vamico_featured_img_type ) || ( 'default' === $vamico_featured_img_type ) ) {
									echo '<div class="page-header ' . esc_attr( $vamico_featured_styling ) . '">';
									echo '<h1 class="entry-title">' . get_the_title( get_the_ID() ) . '</h1>';
									if ( ! empty( $vamico_featured_desc ) ) {
										echo '<p>' . wp_kses_post( $vamico_featured_desc ) . '</p>';
									}
									echo '</div>';
								}
								if ( 'default' === $vamico_featured_img_type ) {
									if ( has_post_thumbnail() ) {
										echo '<div class="post__thumb">';
										echo get_the_post_thumbnail( get_the_ID(), 'vamico-extra-large' );
										echo '</div>';
									}
								}
							}
							?>
							<?php the_content(); ?>
							<?php
							wp_link_pages( array(
								'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'vamico' ),
								'after' => '</div>',
							) );
							?>

					<?php endwhile; ?>
					<?php endif; ?>
					<?php comments_template( '', true ); ?>
				</div><!-- .entry-content-wrapper -->
			</main><!-- .content-area -->

			<?php
			if ( vamico_generator( 'vamico_sidebar_option', get_the_ID() ) !== 'fullwidth' ) {
				get_sidebar();
			}
			?>

		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

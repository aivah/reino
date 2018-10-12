<?php
// Includes the header.php template file from your current theme's directory
get_header();

$reino_featured_img_type = '';
$reino_featured_img      = '';

$reino_featured_img_val = get_post_meta( get_the_ID(), 'reino_featured_img_type', true )
						? get_post_meta( get_the_ID(), 'reino_featured_img_type', true )
						: 'default';

$reino_featured_loc_opt = get_option( 'reino_featured_img_pos' )
						? get_option( 'reino_featured_img_pos' )
						: 'inside_post';

$reino_featured_location = get_post_meta( get_the_ID(), 'reino_featured_img_pos', true )
						? get_post_meta( get_the_ID(), 'reino_featured_img_pos', true )
						: $reino_featured_loc_opt;

$reino_featured_desc     = get_post_meta( get_the_ID(), 'reino_featured_desc', true );
$reino_featured_styling  = get_post_meta( get_the_ID(), 'reino_featured_styling', true );
$reino_featured_bgcolor  = get_post_meta( get_the_ID(), 'reino_featured_bgcolor', true );
$reino_featured_txtcolor = get_post_meta( get_the_ID(), 'reino_featured_txtcolor', true );

$reino_fs_txtcolor_val = $reino_featured_txtcolor ? 'color:' . $reino_featured_txtcolor . ';' : '';
$reino_fs_bgcolor_val  = $reino_featured_bgcolor ? 'background-color:' . $reino_featured_bgcolor . ';' : '';
$reino_fs_txt_css      = ( '' !== $reino_fs_txtcolor_val ) ? ' style="' . $reino_fs_txtcolor_val . '"' : '';
$reino_fs_bg_css       = ( '' !== $reino_fs_bgcolor_val ) ? ' style="' . $reino_fs_bgcolor_val . '"' : '';

if ( 'default' === $reino_featured_img_val ) {
	$reino_featured_img_type = get_option( 'reino_featured_img_type' )
								? get_option( 'reino_featured_img_type' )
								: 'standard';
} else {
	$reino_featured_img_type = $reino_featured_img_val;
}

if ( 'inside_post' === $reino_featured_location && 'wide' === $reino_featured_img_type ) {
	echo wp_kses_post( reino_featured_content( get_the_ID() ) );
}
?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<?php
			if ( 'outside_post' === $reino_featured_location ) {
				if ( has_post_thumbnail() ) {
					echo '<div class="outside_content">';
					echo '<div class="post__thumb">';
					echo get_the_post_thumbnail( get_the_ID(), 'reino-extra-large' );
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="outside_content ' . esc_attr( $reino_featured_styling ) . '" ' . $reino_fs_bg_css . '>';
					echo '<div class="outside_box">';
					echo '<h1 ' . $reino_fs_txt_css . '>' . get_the_title( get_the_ID() ) . '</h1>';
					if ( ! empty( $reino_featured_desc ) ) {
						echo '<p ' . $reino_fs_txt_css . '>' . wp_kses_post( $reino_featured_desc ) . '</p>';
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
							if ( 'inside_post' === $reino_featured_location ) {
								if ( ( 'standard' === $reino_featured_img_type ) || ( 'default' === $reino_featured_img_type ) ) {
									echo '<div class="page-header ' . esc_attr( $reino_featured_styling ) . '">';
									echo '<h1 class="entry-title">' . get_the_title( get_the_ID() ) . '</h1>';
									if ( ! empty( $reino_featured_desc ) ) {
										echo '<p>' . wp_kses_post( $reino_featured_desc ) . '</p>';
									}
									echo '</div>';
								}
								if ( 'default' === $reino_featured_img_type ) {
									if ( has_post_thumbnail() ) {
										echo '<div class="post__thumb">';
										echo get_the_post_thumbnail( get_the_ID(), 'reino-extra-large' );
										echo '</div>';
									}
								}
							}
							?>
							<?php the_content(); ?>
							<?php
							wp_link_pages( array(
								'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'reino' ),
								'after' => '</div>',
							) );
							?>

					<?php endwhile; ?>
					<?php endif; ?>
					<?php comments_template( '', true ); ?>
				</div><!-- .entry-content-wrapper -->
			</main><!-- .content-area -->

			<?php
			if ( reino_generator( 'reino_sidebar_option', get_the_ID() ) !== 'fullwidth' ) {
				get_sidebar();
			}
			?>

		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

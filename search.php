<?php
get_header();
?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<main class="content-area">
				<div class="entry-content-wrapper clearfix">
					<div class="archive-box"><?php reino_page_title(); ?></div>
					<div class="post__layout row">
					<?php
					$reino_post_count = 0;
					$reino_before     = '';
					$reino_after      = '';
					echo wp_kses_post( $reino_before );
					if ( have_posts() ) :
						while ( have_posts() ) :
							$reino_post_count++;
							the_post();
							if ( 1 === $reino_post_count ) {
								get_template_part( 'templates/content', 'standard' );
							} else {
								echo '<div class="col-md-6">';
								echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class( 'grid-item' ) ) ) . '">';
								if ( has_post_thumbnail() ) {
									// Post thumbnail
									echo '<div class="post__thumbnail">';
									echo get_the_post_thumbnail( get_the_ID(), 'reino-medium-uncropped' );
									// Read Time
									echo '<div class="post__thumbnail-meta">';
									reino_the_post_meta( array( 'readtime', 'views' ), true );
									echo '</div>';//.post__thumbnail-meta
									echo '<a class="hover__link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '"></a>';
									echo '</div>';//.post__thumbnail
								}
								reino_post_header();
								reino_blog_post_entry();
								reino_read_more( '', 'btn btn-primary' );
								echo '</article>';
								echo '</div>';
							}
							?>
					<?php endwhile; ?>
					</div>
						<?php
						// Displays pagination
						if ( function_exists( 'reino_pagination' ) ) {
							reino_pagination();
						}
						?>

					<?php else : ?>

					<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'reino' ); ?></div>
					<?php get_search_form(); ?>
					<?php endif; ?>
					<?php echo wp_kses_post( $reino_before ); ?>
				</div>
			</main><!-- .content-area -->

			<?php get_sidebar(); ?>
			<!-- .pagemid -->

			<div class="clear"></div>

		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

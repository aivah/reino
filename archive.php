<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */

get_header(); ?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">

			<main class="content-area">
				<div class="entry-content-wrapper clearfix">
					<div class="archive-box">
						<div class="archive-img">
						<?php reino_category_img( 'thumbnail' ); ?>
						</div>
						<?php reino_page_title(); ?>
					</div>
					<?php
					$reino_post_count = 0;

					$reino_before = '';
					$reino_after  = '';

					$reino_archive_style = get_option( 'reino_archive_style' ) ? get_option( 'reino_archive_style' ) : '';
					if ( 'archive_standard_style' === $reino_archive_style ) {
						$reino_before = '<div class="post__layout"><div class="post__layout-standard">';
						$reino_after  = '</div></div>';//. post-layout
					}
					if ( 'archive_grid_style' === $reino_archive_style ) {
						$reino_before = '<div class="post__layout post-masonry-grid row"><div class="grid-sizer"></div>';
						$reino_after  = '</div>';//. post-layout
					}
					if ( 'archive_list_style' === $reino_archive_style ) {
						$reino_before = '<div class="post__layout"><div class="post__layout-list">';
						$reino_after  = '</div></div>';//. post-layout
					}
					echo wp_kses_post( $reino_before );
					if ( have_posts() ) :
						while ( have_posts() ) :
							$reino_post_count++;
							the_post();
							switch ( $reino_archive_style ) {
								case 'archive_standard_style':
									get_template_part( 'templates/content', 'standard' );
									break;
								case 'archive_grid_style':
									get_template_part( 'templates/content', 'grid' );
									break;
								case 'archive_list_style':
									get_template_part( 'templates/content', 'list' );
									break;
								default:
									get_template_part( 'templates/content', 'standard' );
									break;
							}
							?>
					<?php endwhile; ?>
						<?php echo wp_kses_post( $reino_after ); ?>
							<?php
								// Pagination
							if ( function_exists( 'reino_pagination' ) ) {
								reino_pagination();
							}
							?>
					<?php else : ?>
					<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'reino' ); ?></div>
					<?php get_search_form(); ?>
					<?php endif; ?>

				</div><!-- .entry-content-wrapper-->
			</main><!-- .content-area -->

			<?php
			if ( reino_generator( 'reino_sidebar_option', get_the_ID() ) != 'fullwidth' ) {
				get_sidebar();
			}
			?>

		</div><!-- inner -->
	</div><!-- #primary.pagemid -->
</div>
<?php
get_footer();

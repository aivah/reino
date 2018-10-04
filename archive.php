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
						<?php vamico_page_title(); ?>
					</div>
					<?php $vamico_post_count = 0; ?>
					<?php
					$vamico_before = '';
					$vamico_after  = '';

					$vamico_archive_style = get_option( 'vamico_archive_style' ) ? get_option( 'vamico_archive_style' ) : '';
					if ( 'archive_standard_style' === $vamico_archive_style ) {
						$vamico_before = '<div class="post__layout"><div class="post__layout-standard">';
						$vamico_after  = '</div></div>';//. post-layout
					}
					if ( 'archive_grid_style' === $vamico_archive_style ) {
						$vamico_before = '<div class="post__layout post-masonry-grid row"><div class="grid-sizer"></div>';
						$vamico_after  = '</div>';//. post-layout
					}
					if ( 'archive_list_style' === $vamico_archive_style ) {
						$vamico_before = '<div class="post__layout"><div class="post__layout-list">';
						$vamico_after  = '</div></div>';//. post-layout
					}
					echo wp_kses_post( $vamico_before );
					if ( have_posts() ) :
						while ( have_posts() ) :
							$vamico_post_count++;
							the_post();
							switch ( $vamico_archive_style ) {
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
						<?php echo wp_kses_post( $vamico_after ); ?>
							<?php
								// Pagination
							if ( function_exists( 'vamico_pagination' ) ) {
								vamico_pagination();
							}
							?>
					<?php else : ?>
					<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vamico' ); ?></div>
					<?php get_search_form(); ?>
					<?php endif; ?>

				</div><!-- .entry-content-wrapper-->
			</main><!-- .content-area -->

			<?php
			if ( vamico_generator( 'vamico_sidebar_option', get_the_ID() ) != 'fullwidth' ) {
				get_sidebar();
			}
			?>

		</div><!-- inner -->
	</div><!-- #primary.pagemid -->
</div>
<?php
get_footer();

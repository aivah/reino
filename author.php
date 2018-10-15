<?php
/**
 * The template for displaying Author archive pages
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package Reino
 */

get_header(); ?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<main class="content-area">
				<div class="entry-content-wrapper clearfix">

					<?php reino_generator( 'reino_about_author' ); ?>
					<?php
					if ( reino_generator( 'reino_sidebar_option', get_the_id() ) !== 'fullwidth' ) {
						$width = '520';
					} else {
						$width = '960';
					}
					?>
					<?php $reino_post_count = 0; ?>
					<?php
					$reino_before           = '';
					$reino_after            = '';
					$reino_author_style     = get_option( 'reino_author_style' ) ? get_option( 'reino_author_style' ) : '';
					if ( 'author_standard_style' === $reino_author_style ) {
						$reino_before = '<div class="post__layout"><div class="post__layout-standard">';
						$reino_after  = '</div></div>';//. post-layout
					}
					if ( 'author_grid_style' === $reino_author_style ) {
						$reino_before = '<div class="post__layout row">';
						$reino_after  = '</div>';//. post-layout
					}
					if ( 'author_list_style' === $reino_author_style ) {
						$reino_before = '<div class="post__layout"><div class="post__layout-list">';
						$reino_after  = '</div></div>';//. post-layout
					}
					echo wp_kses_post( $reino_before );
					if ( have_posts() ) :
						while ( have_posts() ) :
							$reino_post_count++;
							the_post();
							switch ( $reino_author_style ) {
								case 'author_standard_style':
									get_template_part( 'templates/content', 'standard' );
									break;
								case 'author_grid_style':
									get_template_part( 'templates/content', 'grid' );
									break;
								case 'author_list_style':
									get_template_part( 'templates/content', 'list' );
									break;
								default:
									get_template_part( 'templates/content', 'standard' );
									break;
							}
							?>
					<?php endwhile; ?>
							<?php
							// Pagination
							if ( function_exists( 'reino_pagination' ) ) {
								reino_pagination();
							}
							?>
					<?php else : ?>
					<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'reino' ); ?></div>
					<?php get_search_form(); ?>
					<?php
					endif;
?>
					<?php echo wp_kses_post( $reino_before ); ?>
				</div>
			</main><!-- .content-area -->
			<?php
			if ( reino_generator( 'reino_sidebar_option', get_the_ID() ) !== 'fullwidth' ) {
				get_sidebar();
			}
			?>
			<div class="clear"></div>
		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

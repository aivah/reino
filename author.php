<?php
/**
 * The template for displaying Author archive pages
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package Vamico
 */

get_header(); ?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<main class="content-area">
				<div class="entry-content-wrapper clearfix">

					<?php vamico_generator( 'vamico_about_author' ); ?>
					<?php
					if ( vamico_generator( 'vamico_sidebar_option', get_the_id() ) !== 'fullwidth' ) {
						$width = '520';
					} else {
						$width = '960';
					}
					?>
					<?php $vamico_post_count = 0; ?>
					<?php
					$vamico_before       = '';
					$vamico_after        = '';
					$vamico_author_style = get_option( 'vamico_author_style' ) ? get_option( 'vamico_author_style' ) : '';
					if ( 'author_standard_style' === $vamico_author_style ) {
						$vamico_before = '<div class="post__layout"><div class="post__layout-standard">';
						$vamico_after  = '</div></div>';//. post-layout
					}
					if ( 'author_grid_style' === $vamico_author_style ) {
						$vamico_before = '<div class="post__layout row">';
						$vamico_after  = '</div>';//. post-layout
					}
					if ( 'author_list_style' === $vamico_author_style ) {
						$vamico_before = '<div class="post__layout"><div class="post__layout-list">';
						$vamico_after  = '</div></div>';//. post-layout
					}
					echo wp_kses_post( $vamico_before );
					if ( have_posts() ) :
						while ( have_posts() ) :
							$vamico_post_count++;
							the_post();
							switch ( $vamico_author_style ) {
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
							if ( function_exists( 'vamico_pagination' ) ) {
								vamico_pagination();
							}
							?>
					<?php else : ?>
					<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vamico' ); ?></div>
					<?php get_search_form(); ?>
					<?php
					endif;
?>
					<?php echo wp_kses_post( $vamico_before ); ?>
				</div>
			</main><!-- .content-area -->
			<?php
			if ( vamico_generator( 'vamico_sidebar_option', get_the_ID() ) !== 'fullwidth' ) {
				get_sidebar();
			}
			?>
			<div class="clear"></div>
		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

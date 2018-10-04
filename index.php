<?php
get_header(); ?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<div class="content-area">

				<div class="entry-content-wrapper clearfix">
				<?php vamico_page_title(); ?>
				<?php

				$vamico_blog_style    = get_option( 'vamico_blog_style' ) ? get_option( 'vamico_blog_style' ) : '';
				$vamico_blog_all_cats = get_option( 'vamico_blog_cats' );

				$vamico_before    = '';
				$vamico_after     = '';
				$vamico_blog_cats = '';

				if ( is_array( $vamico_blog_all_cats ) && count( $vamico_blog_all_cats ) > 0 ) {
					$vamico_blog_cats = implode( ', ', $vamico_blog_all_cats );
				}

				if ( get_query_var( 'paged' ) ) {
					$paged = get_query_var( 'paged' );
				} elseif ( get_query_var( 'page' ) ) {
					$paged = get_query_var( 'page' );
				} else {
					$paged = 1;
				}

				global $wp_query;

				$vamico_temp = $wp_query;

				$vamico_blog_args = array(
					'cat'   => $vamico_blog_cats,
					'paged' => $paged,
				);

				$wp_query = new WP_Query( $vamico_blog_args );

				$vamico_blog_style = get_option( 'vamico_blog_style' ) ? get_option( 'vamico_blog_style' ) : '';
				if (
					( 'post_standard_style' === $vamico_blog_style ) ||
					( 'post_list_style' === $vamico_blog_style ) ||
					( 'post_standard_list_style' === $vamico_blog_style )
				) {
					$vamico_before = '<div class="post__layout">';
					$vamico_after  = '</div>';//. post-layout
				}
				if ( ( 'post_grid_style' === $vamico_blog_style ) || ( 'post_standard_grid_style' === $vamico_blog_style ) ) {
					$vamico_before = '<div class="post__layout post-masonry-grid row"><div class="grid-sizer"></div>';
					$vamico_after  = '</div>';//. post-layout
				}
				echo wp_kses_post( $vamico_before );

				$vamico_post_count = 0;
				if ( $wp_query->have_posts() ) :
					while ( $wp_query->have_posts() ) :
						$vamico_post_count++;
						$wp_query->the_post();
						switch ( $vamico_blog_style ) {
							case 'post_standard_style':
								get_template_part( 'templates/content', 'standard' );
								break;
							case 'post_grid_style':
								get_template_part( 'templates/content', 'grid' );
								break;
							case 'post_list_style':
								get_template_part( 'templates/content', 'list' );
								break;
							case 'post_standard_grid_style':
								get_template_part( 'templates/content', 'standard-grid' );
								break;
							case 'post_standard_list_style':
								get_template_part( 'templates/content', 'standard-list' );
								break;
							default:
								get_template_part( 'templates/content', 'standard' );
								break;
						}
				endwhile;
					?>
					<?php echo wp_kses_post( $vamico_after ); ?>
					<?php
					if ( function_exists( 'vamico_pagination' ) ) {
						vamico_pagination();
					}
					?>

				<?php else : ?>
				<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vamico' ); ?></div>
				<?php get_search_form(); ?>
				<?php endif; ?>

				<?php
				$wp_query = null;
				$wp_query = $vamico_temp;
				?>
				<?php wp_reset_postdata(); ?>
			</div> <!-- .Entry-content-wrapper -->
			</div><!-- .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div>
<?php
get_footer();

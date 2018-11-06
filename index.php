<?php
get_header(); ?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<div class="content-area">

				<div class="entry-content-wrapper clearfix">
				<?php reino_page_title(); ?>
				<?php

				$reino_blog_style    = get_option( 'reino_blog_style' ) ? get_option( 'reino_blog_style' ) : '';
				$reino_blog_all_cats = get_option( 'reino_blog_cats' );

				$reino_before    = '';
				$reino_after     = '';
				$reino_blog_cats = '';

				if ( is_array( $reino_blog_all_cats ) && count( $reino_blog_all_cats ) > 0 ) {
					$reino_blog_cats = implode( ', ', $reino_blog_all_cats );
				}

				if ( get_query_var( 'paged' ) ) {
					$paged = get_query_var( 'paged' );
				} elseif ( get_query_var( 'page' ) ) {
					$paged = get_query_var( 'page' );
				} else {
					$paged = 1;
				}

				global $wp_query;

				$reino_temp = $wp_query;

				$reino_blog_args = array(
					'cat'   => $reino_blog_cats,
					'paged' => $paged,
				);

				$wp_query = new WP_Query( $reino_blog_args );

				$reino_blog_style = get_option( 'reino_blog_style' ) ? get_option( 'reino_blog_style' ) : '';
				if (
					( 'post_standard_style' === $reino_blog_style ) ||
					( 'post_list_style' === $reino_blog_style ) ||
					( 'post_standard_list_style' === $reino_blog_style )
				) {
					$reino_before = '<div class="post__layout">';
					$reino_after  = '</div>';//. post-layout
				}
				if ( ( 'post_grid_style' === $reino_blog_style ) || ( 'post_standard_grid_style' === $reino_blog_style ) ) {
					$reino_before = '<div class="post__layout post-masonry-grid row">' . reino_grid_sizer();
					$reino_after  = '</div>';//. post-layout
				}
				echo wp_kses_post( $reino_before );

				$reino_post_count = 0;
				if ( $wp_query->have_posts() ) :
					while ( $wp_query->have_posts() ) :
						$reino_post_count++;
						$wp_query->the_post();
						switch ( $reino_blog_style ) {
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
					<?php echo wp_kses_post( $reino_after ); ?>
					<?php
					if ( function_exists( 'reino_pagination' ) ) {
						reino_pagination();
					}
					?>

				<?php else : ?>
				<div class="alert alert-warning"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'reino' ); ?></div>
				<?php get_search_form(); ?>
				<?php endif; ?>

				<?php
				$wp_query = null;
				$wp_query = $reino_temp;
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

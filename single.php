<?php
get_header(); ?>
<?php
$reino_featured_img_type = '';
$reino_featured_img_val  = get_post_meta( get_the_ID(), 'reino_featured_img_type', true )
							? get_post_meta( get_the_ID(), 'reino_featured_img_type', true )
							: 'default';

$reino_featured_img_pos_ofw = get_option( 'reino_featured_img_pos' )
							? get_option( 'reino_featured_img_pos' )
							: 'inside_post';

$reino_featured_styling = get_post_meta( get_the_ID(), 'reino_featured_styling', true );

$reino_featured_img_pos = get_post_meta( get_the_ID(), 'reino_featured_img_pos', true )
							? get_post_meta( get_the_ID(), 'reino_featured_img_pos', true )
							: $reino_featured_img_pos_ofw;

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

if ( 'inside_post' === $reino_featured_img_pos && 'fullwidth' === $reino_featured_img_type ) {
	echo wp_kses_post( reino_featured_image( get_the_ID() ) );
}

$reino_post_format = get_post_format();
?>
<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<?php

			// Displays if image position is selected as outside
			if ( 'outside_post' === $reino_featured_img_pos ) {
				// reino_post_single_thumb();
				if ( has_post_thumbnail() ) {
					if ( in_array( $reino_post_format, array( 'gallery', 'video', 'audio', 'image' ), true ) ) {
						echo '<div class="post__thumb featured-inside-fullwidth">';
						get_template_part( 'templates/format', $reino_post_format );
						echo '</div>';
					} else {
						echo '<div class="post__thumb featured-inside-fullwidth">';
						echo get_the_post_thumbnail( get_the_ID(), 'reino-extra-large' );
						echo '</div>';
					}
				} else {
					if ( ! empty( $reino_featured_desc ) ) {
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
			}
			?>
			<main class="content-area">
				<div class="entry-content-wrapper clearfix">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();

						echo '<article id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class() ) ) . '">';

						if ( 'inside_post' === $reino_featured_img_pos ) {
							// Post Header
							echo wp_kses_post( reino_post_view( get_the_ID() ) );
							// Post thumbnail
							if (
								( 'standard' === $reino_featured_img_type ) ||
								( 'default' === $reino_featured_img_type )
							) {
								if ( 'standard' === $reino_featured_img_type ) {
									if ( has_post_thumbnail() ) {
										echo '<div class="post__thumb featured-inside-std">';
										echo get_the_post_thumbnail( get_the_ID(), 'reino-extra-large' );
										echo '</div>';//.post__thumb
									}
								}
								if ( ! empty( $reino_featured_desc ) ) {
									echo '<p>' . wp_kses_post( $reino_featured_desc ) . '</p>';
								}
								echo '<div class="post__header ' . esc_attr( $reino_featured_styling ) . '">';
								echo esc_html( reino_post_category() );
								echo '<h2 class="entry-title">' . get_the_title( get_the_ID() ) . '</h2>';
								if ( get_option( 'reino_postmeta' ) !== 'on' ) {
									reino_the_post_meta( array( 'date', 'readtime', 'views', 'likes' ), false );
								}
								echo '</div>';//.post__header
								if ( 'default' === $reino_featured_img_type ) {
									if ( has_post_thumbnail() ) {
										echo '<div class="post__thumb featured-inside-def">';
										echo get_the_post_thumbnail( get_the_ID(), 'reino-extra-large' );
										echo '</div>';//.post__thumb
									}
								}
							}

							if ( 'default' === $reino_featured_img_type || 'fullwidth' === $reino_featured_img_type ) {
								if ( in_array( $reino_post_format, array( 'gallery', 'video', 'audio' ), true ) ) {
									echo '<div class="post__thumbmedia">';
									get_template_part( 'templates/format', $reino_post_format );
									echo '</div>';//.post__thumb
								}
							}
						}
						if ( 'outside_post' === $reino_featured_img_pos ) {
							echo '<div class="page-header ' . esc_attr( $reino_featured_styling ) . '">';
							echo esc_html( reino_post_category( get_the_ID() ) );
							echo '<h1 class="entry-title">' . get_the_title( get_the_ID() ) . '</h1>';
							if ( ! empty( $reino_featured_desc ) ) {
								echo '<p>' . wp_kses_post( $reino_featured_desc ) . '</p>';
							}
							if ( get_option( 'reino_postmeta' ) !== 'on' ) {
								reino_the_post_meta( array( 'date', 'readtime', 'views', 'likes' ), false );
							}
							echo '</div>'; //.page-header
						}
						// Post Entry
						echo '<div class="post__content">';
						the_content();

						wp_link_pages( array(
							'before'           => '<div class="content-navigation"><div class="nav-links">',
							'after'            => '</div></div>',
							'link_before'      => '<span class="page-number">',
							'link_after'       => '</span>',
							'next_or_number'   => 'next_and_number',
							'separator'        => ' ',
							'nextpagelink'     => esc_html__( 'Next page', 'reino' ),
							'previouspagelink' => esc_html__( 'Previous page', 'reino' ),
						));

						echo '</div>';//.post__content

						// Tags
						echo '<div class="post__tag-share">';
						if ( get_option( 'reino_hide_tags' ) !== 'on' ) {
							the_tags( '<ul class="post__tags"><li>', '</li><li>', '</li></ul>' );
						}
						if ( get_option( 'reino_hide_share_btns' ) !== 'on' ) {
							echo '<div id="post__share" class="post__share"><i class="fa fa-share-alt fa-fw"></i></div>';
						}
						echo '</div>'; // .post__tag-share


						// About author
						if ( 'on' !== get_option( 'reino_about_author' ) ) {
							reino_generator( 'reino_about_author' );
						}

						// Post next and previous navigation
						if ( get_option( 'reino_singlenavigation' ) !== 'on' ) {
							reino_generator( 'reino_single_navigation' );
						}

						// Related Posts
						if ( get_option( 'reino_related_posts' ) !== 'on' ) {
							reino_generator( 'reino_related_posts', get_the_ID() );
						}

						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						echo '</article>';
						?>
				<?php endwhile; ?>
				<?php else : ?>
				<?php '<p>' . esc_html__( 'Sorry, no posts matched your criteria.', 'reino' ) . '</p>'; ?>
				<?php endif; ?>
				</div><!-- .entry-content-wrapper-->
			</main><!-- .content-area -->
			<?php
			if ( reino_generator( 'reino_sidebar_option', get_the_ID() ) != 'fullwidth' ) {
				get_sidebar();
			}
			?>
		</div><!-- .inner -->
	</div><!-- .pagemid -->
</div><!-- #main -->
<?php
get_footer();

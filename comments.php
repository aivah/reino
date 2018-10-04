<?php
if ( post_password_required() ) {
	return;
}
?>
<?php if ( have_comments() ) : ?>
<div id="comments" class="comments-area">
	<h3 class="comments-title">
		<?php
		$comments_number = get_comments_number();
		if ( 1 === $comments_number ) {
			/* translators: %s: post title */
			printf( esc_html_x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'vamico' ), get_the_title() );
		} else {
			echo esc_html(
				sprintf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s thought on &ldquo;%2$s&rdquo;',
						'%1$s thoughts on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'vamico'
					),
					wp_kses_post( number_format_i18n( $comments_number ) ),
					get_the_title()
				)
			);
		}
		?>
	</h3>

	<?php the_comments_navigation(); ?>

	<ol class="comments-list">
		<?php
		wp_list_comments( array(
			'callback' => 'vamico_custom_comment',
		) );
		?>
	</ol><!-- .commentlist -->

	<?php the_comments_navigation(); ?>
	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		echo '<p class="no-comments">' . esc_html__( 'Comments are closed.', 'vamico' ) . '</p>';
	endif;
	?>
</div><!-- #comments .post__comments -->
<?php endif; ?>
<?php
// Comment Form
comment_form( array(
	'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
	'title_reply_after'  => '</h2>',
));

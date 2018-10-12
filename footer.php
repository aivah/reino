<?php
/**
 * Footer Sidebar
 */
?>
<?php
/* Instagram Widget */
if ( is_active_sidebar( 'footer_instagram_widget' ) ) {
	echo '<div class="footer-instagram">';
	dynamic_sidebar( 'footer_instagram_widget' );
	echo '</div>';
}
?>
<div id="footer" class="footer-wrap">
	<?php
	// Footer Area Top
	if ( 'on' !== get_option( 'reino_footer_area_top' ) ) {
		if ( is_active_sidebar( 'footer_area_top' ) ) {
			echo '<div class="footer-area-top"><div class="inner">';
			dynamic_sidebar( 'footer_area_top' );
			echo '</div></div>';
		}
	}
	if ( 'on' !== get_option( 'reino_footer_sidebar' ) ) {
		// Get footer sidebar widgets
		if ( 'on' !== get_option( 'reino_footer_sidebar' )
			&& is_active_sidebar( 'footer-widgets' )
			) {
			echo '<div class="footer-area-middle">';
			echo '<div class="inner">';
			echo '<div class="inner-row">';
			if ( is_active_sidebar( 'footer-widgets' ) ) :
				dynamic_sidebar( 'footer-widgets' );
			endif;
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
	// Footer Area Bottom
	if ( 'on' !== get_option( 'reino_footer_area_bottom' ) ) {
		if ( is_active_sidebar( 'footer_area_bottom' ) ) {
			echo '<div class="footer-area-bottom"><div class="inner">';
			dynamic_sidebar( 'footer_area_bottom' );
			echo '</div></div>';
		}
	}
	?>
</div> <!-- .footer-area -->
<?php if ( is_active_sidebar( 'footer_leftcopyright' ) || is_active_sidebar( 'footer_rightcopyright' ) ) { ?>
	<div class="copyright-wrap">
		<div class="inner">
			<div class="copyright">
				<div class="copyright-left">
					<?php
					if ( is_active_sidebar( 'footer_leftcopyright' ) ) :
						dynamic_sidebar( 'footer_leftcopyright' );
					endif;
					?>
				</div><!-- .copyright-left -->
				<div class="copyright-right">
					<?php
					if ( is_active_sidebar( 'footer_rightcopyright' ) ) :
						dynamic_sidebar( 'footer_rightcopyright' );
					endif;
					if ( is_active_sidebar( 'footer-branches' ) ) {
						echo '<a class="at-footer-branches">' . esc_html__( 'More Branches', 'reino' ) . '</a>';
					}
					?>
				</div><!-- .copyright-right -->
			</div><!-- .copyright -->
		</div><!-- .inner -->
	</div><!-- .copyright-wrap -->
<?php } ?>
</div><!-- .wrapper -->
</div><!-- #layout -->

<div id="socials__modal" class="modal_overlay">
	<a id="close__share" href="javascript:;"><span></span><span></span></a>
	<?php if ( is_single() ) { ?>
			<div class="modal-box-wrap">
				<div class="modal-box-content">
					<div class="modal-box-inner">
					<?php get_template_part( 'share', 'link' ); ?>
					</div>
				</div>
			</div>
	<?php } ?>
</div>
<div id="back-top">
	<a href="#header" title="<?php echo esc_html__( 'Scroll Top', 'reino' ); ?>">
		<span class="fa fa-angle-up fa-fw fa-lg"></span>
	</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
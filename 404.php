<?php
get_header(); ?>

<div id="main" class="main">
	<div id="primary" class="pagemid">
		<div class="inner">
			<div class="entry-content-wrapper">
				<div class="wrap404">
					<div class="error_404">
						<i class="fa fa-traffic-cone"></i>
						<?php
						echo '<h2 class="error_title">' . esc_html__( '404', 'reino' ) . '</h2>';
						echo '<p>' . esc_html__( 'The page you are looking for was moved, removed, or does not exist.', 'reino' ) . '</p>';
						echo '<a class="btn btn-primary small btn-lg" href="' . esc_url( site_url() ) . '"><span>' . esc_html__( 'Go To HomePage', 'reino' ) . '</span></a>';
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();

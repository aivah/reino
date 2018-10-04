<?php
/* Header Fixed Style */
?>
<?php if ( 'on' !== get_option( 'vamico_topbar' ) ) { ?>
<div class="topbar-wrap">
	<div class="inner">
		<div class="topbar">
			<div class="topbar-left"><div class="topbar-left-col"><?php vamico_generator( 'vamico_secondary_menu' ); ?></div></div><!-- topbar-left -->
			<div class="topbar-right"><div class="topbar-right-col"><?php echo wp_kses_post( vamico_sociables( 'black' ) ); ?></div></div><!-- /topbar-left -->
		</div><!-- topbar -->
	</div><!-- /inner -->
</div><!-- /topbar-wrap -->
<?php } ?>
<div class="header-fixed-empty"></div>
<header class="header-fixed">
	<div class="header-wrap">
		<div class="header-inner">

			<div class="header-left">
				<div class="logo">
				<?php
				// echo '<div class="iva-light-logo">';
				// vamico_generator( 'vamico_logo', 'vamico_header_light_logo' );
				// echo '</div>';
				echo '<div class="iva-dark-logo">';
				vamico_generator( 'vamico_logo', 'vamico_header_dark_logo' );
				echo '</div>';
				?>
				</div>
			</div>

			<div class="header-right">
				<div class="primarymenu menuwrap">
				<?php vamico_generator( 'vamico_primary_menu' ); ?>
				<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
					<div id="iva-hamburger" class="iva-hamburger"><span></span><span></span><span></span><span></span></div>
				<?php } ?>
				</div>
			</div>

		</div><!-- .header-area-->
		<?php
			vamico_generator( 'vamico_mobile_menu' );
		?>
	</div><!-- #fixedheader-->
</header><!-- .header-->
<?php
/* Header Style Default */
?>
<header class="header-s1">
	<?php if ( 'on' !== get_option( 'reino_topbar' ) ) { ?>
	<div class="topbar-wrap">
		<div class="inner">
			<div class="topbar">
				<div class="topbar-left"><div class="topbar-left-col"><?php reino_generator( 'reino_secondary_menu' ); ?></div></div><!-- topbar-left -->
				<div class="topbar-right"><div class="topbar-right-col">
					<?php
					echo wp_kses_post( reino_sociables(
						$color = 'black'
					));
					?>
				</div></div><!-- /topbar-left -->
			</div><!-- topbar -->
		</div><!-- /inner -->
	</div><!-- /topbar-wrap -->
	<?php } ?>
	<div class="header-wrap">
		<div class="header-inner">
			<?php
			$reino_subscribe_link        = get_option( 'reino_subscribe_link' );
			$reino_subscribe_btn_disable = get_option( 'reino_subscribe_btn_disable' );
			$reino_search_icn_disable    = get_option( 'reino_search_icn_disable' );
			echo '<div class="header-left">';
			if ( 'on' !== $reino_subscribe_btn_disable && ! empty( get_option( 'reino_subscribe_link' ) ) ) {
				echo '<a href="' . esc_url( $reino_subscribe_link ) . '" target="_blank" class="subscribe_btn btn btn-primary"><span>' . esc_html__( 'Subscribe', 'reino' ) . '</span></a>';
			}
			echo '</div>';
			?>
			<?php
			if ( get_option( 'reino_owl_slider_type' ) === 'large' ) {
				?>
				<div class="header-center"><div class="logo"><?php reino_generator( 'reino_logo', 'reino_header_light_logo' ); ?></div></div>
			<?php } else { ?>
				<div class="header-center"><div class="logo"><?php reino_generator( 'reino_logo', 'reino_header_dark_logo' ); ?></div></div>
			<?php } ?>
			<div class="header-right">
				<?php if ( 'on' !== $reino_search_icn_disable ) { ?>
				<a href="javascript:;" class="search__icon" id="search__icon"><i class="fa fa-search fa-fw"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="primary-menu">
		<div class="menu-inner">
			<div class="menu-left">
				<?php reino_generator( 'reino_primary_menu' ); ?>
			</div>
				<?php
				if ( class_exists( 'woocommerce' ) ) {
					echo '<div class="menu-right">';
					reino_minicart();
					echo '</div>';
				}
				?>
		</div>
	</div>

</header><!-- #header -->
<div class="m-header-wrap clearfix">
	<div class="m-header-inner">
		<div class="m-header-left">
			<div><?php reino_generator( 'reino_logo', 'reino_header_dark_logo' ); ?></div>
		</div>
		<div class="m-header-right">
			<div class="m-header-col">
				<?php if ( 'on' !== $reino_search_icn_disable ) { ?>
					<a href="javascript:;" class="search__icon"><i class="fa fa-search fa-fw"></i></a>
				<?php } ?>
			</div>
			<?php
			if ( class_exists( 'woocommerce' ) ) {
				echo '<div class="m-header-col">';
				reino_minicart();
				echo '</div>'; //.m-header-col
			}
			if ( has_nav_menu( 'primary-menu' ) ) {
				echo '<div class="m-header-col">';
				echo '<div class="iva-hamburger"><span></span><span></span><span></span><span></span></div>';
				echo '</div>'; //.m-header-col
			}
			?>
		</div>
	</div>
</div>
<?php reino_generator( 'reino_mobile_menu' ); ?>
<div id="search__modal" class="modal_overlay">
	<a id="close__search" href="javascript:;"><span></span><span></span></a>
	<div class="modal-box-wrap">
		<div class="modal-box-content">
			<div class="modal-box-inner">
				<h2 class="modal-box-title"><?php echo esc_html_e( 'Search', 'reino' ); ?></h2>
				<form role="search" method="get" name="searchform" id="search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
					<input type="text" value="<?php the_search_query(); ?>" name="s" id="search_input" class="search_input" autocomplete="off" placeholder="<?php esc_html_e( 'Type keywords and hit enter', 'reino' ); ?>"/>
					<div class="loading-wrapper"><div class="spinner"></div></div>
					<div id="autocomplete"></div>
				</form>
			</div>
		</div>
	</div>
</div>

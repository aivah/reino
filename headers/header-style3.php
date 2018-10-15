<?php
/* Header Style Default */
// Define variables
$reino_search_icn_disable = get_option( 'reino_search_icn_disable' );
$reino_headers3_position  = get_option( 'reino_headers3_position' );
?>
<header class="header-s3">
<?php if ( empty( $reino_headers3_position ) ) { ?>
	<div class="header-wrap">
		<div class="header-inner">
			<div class="header-center">
				<div class="logo">
					<?php reino_generator( 'reino_logo', 'reino_header_dark_logo' ); ?>
				</div><!-- /logo -->
			</div>
			<div class="header-s3-mmenu">
				<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
					<div class="iva-hamburger"><span></span><span></span><span></span><span></span></div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
<div class="primary-menu">
		<div class="menu-inner">
			<div class="menu-left"><?php reino_generator( 'reino_primary_menu' ); ?></div>
			<div class="menu-right">
				<div class="s3-col">
				<?php
				echo wp_kses_post( reino_sociables(
					$color = 'black'
				));
				?>
				</div>
				<?php
				if ( class_exists( 'woocommerce' ) ) {
					echo '<div class="s3-col">';
					reino_minicart();
					echo '</div>';
				}
				?>
				<?php if ( 'on' !== $reino_search_icn_disable && ! empty( get_option( 'reino_subscribe_link' ) ) ) { ?>
				<div class="s3-col"><a href="javascript:;" class="search__icon" id="search__icon"><i class="fa fa-search fa-fw"></i></a></div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php if ( 'on' === $reino_headers3_position ) { ?>
	<div class="header-wrap">
		<div class="header-inner">
			<div class="header-center">
				<div class="logo">
					<?php reino_generator( 'reino_logo', 'reino_header_dark_logo' ); ?>
				</div><!-- /logo -->
			</div>
			<div class="header-s3-mmenu">
				<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
					<div class="iva-hamburger"><span></span><span></span><span></span><span></span></div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
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
					<input type="text" value="<?php the_search_query(); ?>" name="s" id="search_input" autocomplete="off" placeholder="<?php esc_html_e( 'Type keywords and hit enter', 'reino' ); ?>"/>
					<div class="loading-wrapper"><div class="spinner"></div></div>
					<div id="autocomplete"></div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
// Search Input
?>
<?php $reino_unique_id = uniqid( 'search-form-' ); ?>
<div class="search-box">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" id="<?php echo esc_attr( $reino_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_html__( 'Enter Keyword', 'reino' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="search-submit btn btn-md btn-primary"><span><?php echo esc_html__( 'Search', 'reino' ); ?></span></button>
	</form>
</div>
<?php

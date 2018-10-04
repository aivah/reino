<?php
// if this post has a featured image
$vamico_admin_img_uri_post_thumb = '';
$vamico_out                      = '';
if ( has_post_thumbnail( get_the_ID() ) ) {
	// get the featured image
	$vamico_admin_img_uri_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	$vamico_admin_img_uri_post_thumb = $vamico_admin_img_uri_post_thumb[0];
}
// Google+
if ( get_option( 'vamico_google_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="google" target="_blank" href="http://plus.google.com/share?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '&amp;annotation=' . get_the_title() . '"  title="' . esc_html__( 'googleplus', 'vamico' ) . '"><i class="fa fa-google-plus fa-fw fa-lg"><span></span></i></a></li>';
}
// Facebook
if ( get_option( 'vamico_facebook_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="facebook" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'facebook', 'vamico' ) . '" target="_blank"><i class="fa fa-facebook fa-lg fa-fw"><span></span></i></a></li>';
}
// Twitter
if ( get_option( 'vamico_twitter_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="twitter" href="http://twitter.com/share?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;text=' . get_the_title() . '" title="' . esc_html__( 'twitterbird', 'vamico' ) . '" target="_blank"><i class="fa fa-twitter fa-lg fa-fw"><span></span></i></a></li>';
}
// Reddit
if ( get_option( 'vamico_reddit_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="reddit" href="http://reddit.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'reddit', 'vamico' ) . '" target="_blank"><i class="fa fa-reddit fa-lg fa-fw"><span></span></i></a></li>';
}
// Linkdedin
if ( get_option( 'vamico_linkedIn_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'linkedin', 'vamico' ) . '" target="_blank"><i class="fa fa-linkedin fa-lg fa-fw"><span></span></i></a></li>';
}
// Digg
if ( get_option( 'vamico_digg_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="digg" href="http://www.digg.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'digg', 'vamico' ) . '" target="_blank"><i class="fa fa-digg fa-lg fa-fw"><span></span></i></a></li>';
}
// Tumblr
if ( get_option( 'vamico_tumblr_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="tumblr" href="http://www.tumblr.com/share/link?url=' . rawurlencode( get_permalink( get_the_ID() ) ) . '&amp;name=' . rawurlencode( $post->post_title ) . '&amp;description=' . rawurlencode( get_the_excerpt() ) . '" title="' . esc_html__( 'tumblr', 'vamico' ) . '" target="_blank"><i class="fa fa-tumblr fa-fw fa-lg"><span></span></i></a></li>';
}
// Pinterest
if ( get_option( 'vamico_pinterest_enable' ) === 'on' ) {
	if ( '' !== $vamico_admin_img_uri_post_thumb ) {
		$vamico_out .= '<li><a class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&media=' . esc_url( $vamico_admin_img_uri_post_thumb ) . '&description=' . get_the_title() . '" title="' . esc_html__( 'pinterest', 'vamico' ) . '" target="_blank"><i class="fa fa-pinterest-p fa-fw fa-lg"><span></span></i></a></li>';
	} else {
		$vamico_out .= '<li><a class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&description=' . get_the_title() . '" title="' . esc_html__( 'pinterest', 'vamico' ) . '" target="_blank"><i class="fa fa-pinterest-p fa-fw fa-lg"><span></span></i></a></li>';
	}
}
// StumbleUpon
if ( get_option( 'vamico_stumbleupon_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="stumbleupon" href="http://www.stumbleupon.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'stumbleupon', 'vamico' ) . '" target="_blank"><i class="fa fa-stumbleupon fa-fw fa-lg"><span></span></i></a></li>';
}
// Email
if ( get_option( 'vamico_email_enable' ) === 'on' ) {
	$vamico_out .= '<li><a class="mail" href="mailto:?subject=' . get_the_title() . '&amp;body=' . esc_url( get_permalink( get_the_ID() ) ) . '" title="' . esc_html__( 'email', 'vamico' ) . '" target="_blank"><i class="fa fa-envelope fa-fw fa-lg"><span></span></i></a></li>';
}
if ( ! empty( $vamico_out ) ) {
	$vamico_output  = '<h2>' . esc_html__( 'Share', 'vamico' ) . '</h2>';
	$vamico_output .= '<p>' . esc_html__( 'Share the posts with your friends', 'vamico' ) . '</p>';
	$vamico_output .= '<ul class="socials_list is-rounded">';
	$vamico_output .= $vamico_out;
	$vamico_output .= '</ul>';
	echo wp_kses_post( $vamico_output );
}

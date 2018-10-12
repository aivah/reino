<?php
// if this post has a featured image
$reino_admin_img_uri_post_thumb = '';
$reino_out                      = '';
if ( has_post_thumbnail( get_the_ID() ) ) {
	// get the featured image
	$reino_admin_img_uri_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	$reino_admin_img_uri_post_thumb = $reino_admin_img_uri_post_thumb[0];
}
// Google+
if ( get_option( 'reino_google_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="google" target="_blank" href="http://plus.google.com/share?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '&amp;annotation=' . get_the_title() . '"  title="' . esc_html__( 'googleplus', 'reino' ) . '"><i class="fa fa-google-plus fa-fw fa-lg"><span></span></i></a></li>';
}
// Facebook
if ( get_option( 'reino_facebook_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="facebook" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'facebook', 'reino' ) . '" target="_blank"><i class="fa fa-facebook fa-lg fa-fw"><span></span></i></a></li>';
}
// Twitter
if ( get_option( 'reino_twitter_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="twitter" href="http://twitter.com/share?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;text=' . get_the_title() . '" title="' . esc_html__( 'twitterbird', 'reino' ) . '" target="_blank"><i class="fa fa-twitter fa-lg fa-fw"><span></span></i></a></li>';
}
// Reddit
if ( get_option( 'reino_reddit_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="reddit" href="http://reddit.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'reddit', 'reino' ) . '" target="_blank"><i class="fa fa-reddit fa-lg fa-fw"><span></span></i></a></li>';
}
// Linkdedin
if ( get_option( 'reino_linkedIn_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'linkedin', 'reino' ) . '" target="_blank"><i class="fa fa-linkedin fa-lg fa-fw"><span></span></i></a></li>';
}
// Digg
if ( get_option( 'reino_digg_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="digg" href="http://www.digg.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'digg', 'reino' ) . '" target="_blank"><i class="fa fa-digg fa-lg fa-fw"><span></span></i></a></li>';
}
// Tumblr
if ( get_option( 'reino_tumblr_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="tumblr" href="http://www.tumblr.com/share/link?url=' . rawurlencode( get_permalink( get_the_ID() ) ) . '&amp;name=' . rawurlencode( $post->post_title ) . '&amp;description=' . rawurlencode( get_the_excerpt() ) . '" title="' . esc_html__( 'tumblr', 'reino' ) . '" target="_blank"><i class="fa fa-tumblr fa-fw fa-lg"><span></span></i></a></li>';
}
// Pinterest
if ( get_option( 'reino_pinterest_enable' ) === 'on' ) {
	if ( '' !== $reino_admin_img_uri_post_thumb ) {
		$reino_out .= '<li><a class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&media=' . esc_url( $reino_admin_img_uri_post_thumb ) . '&description=' . get_the_title() . '" title="' . esc_html__( 'pinterest', 'reino' ) . '" target="_blank"><i class="fa fa-pinterest-p fa-fw fa-lg"><span></span></i></a></li>';
	} else {
		$reino_out .= '<li><a class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&description=' . get_the_title() . '" title="' . esc_html__( 'pinterest', 'reino' ) . '" target="_blank"><i class="fa fa-pinterest-p fa-fw fa-lg"><span></span></i></a></li>';
	}
}
// StumbleUpon
if ( get_option( 'reino_stumbleupon_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="stumbleupon" href="http://www.stumbleupon.com/submit?url=' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;title=' . get_the_title() . '" title="' . esc_html__( 'stumbleupon', 'reino' ) . '" target="_blank"><i class="fa fa-stumbleupon fa-fw fa-lg"><span></span></i></a></li>';
}
// Email
if ( get_option( 'reino_email_enable' ) === 'on' ) {
	$reino_out .= '<li><a class="mail" href="mailto:?subject=' . get_the_title() . '&amp;body=' . esc_url( get_permalink( get_the_ID() ) ) . '" title="' . esc_html__( 'email', 'reino' ) . '" target="_blank"><i class="fa fa-envelope fa-fw fa-lg"><span></span></i></a></li>';
}
if ( ! empty( $reino_out ) ) {
	$reino_output  = '<h2>' . esc_html__( 'Share', 'reino' ) . '</h2>';
	$reino_output .= '<p>' . esc_html__( 'Share the posts with your friends', 'reino' ) . '</p>';
	$reino_output .= '<ul class="socials_list is-rounded">';
	$reino_output .= $reino_out;
	$reino_output .= '</ul>';
	echo wp_kses_post( $reino_output );
}

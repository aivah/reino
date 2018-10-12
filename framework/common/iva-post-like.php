<?php
class Reino_Post_Like {
	function __construct() {
		// Enqueues the scripts.
		add_action( 'wp_enqueue_scripts', array( &$this, 'reino_enqueue_scripts' ) );
		// Handle the request
		add_action( 'wp_ajax_reino-love', array( &$this, 'reino_ajax_like' ) );
		// Executes for users that are not logged in.
		add_action( 'wp_ajax_nopriv_reino-love', array( &$this, 'reino_ajax_like' ) );
	}
	/**
	 * function reino_enqueue_scripts()
	 *
	 * enqueues the scripts.
	 * @uses wp_enqueue_script()
	 */
	function reino_enqueue_scripts() {
		// In javascript, object properties are accessed as ajax_object.ajax_url
		wp_localize_script( 'reino-customjs', 'ivaLove', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'youLikedit' => esc_html__( 'You already liked it!', 'reino' ),
		));
	}
	/**
	 *
	 * Handle request then generate response using WP_Ajax_Response
	 *
	 */
	function reino_ajax_like( $post_id ) {

		$likes_id = sanitize_text_field( $_POST['loves_id'] );
		// Update
		if ( isset( $likes_id ) ) {
			$post_id = str_replace( 'iva-love-', '', $likes_id );
			echo wp_kses_post( $this->reino_like_post( $post_id, 'update' ) );
		} else {
			$post_id = str_replace( 'iva-love-', '', $likes_id );
			echo wp_kses_post( $this->reino_like_post( $post_id, 'get' ) );
		}

		exit;
	}

	/**
	 * function reino_like_post()
	 */
	function reino_like_post( $post_id, $action = 'get' ) {
		if ( ! is_numeric( $post_id ) ) {
			return;
		}

		switch ( $action ) {

			case 'get':
				$love_count = get_post_meta( $post_id, '_reino_love', true );
				if ( ! $love_count ) {
					$love_count = 0;
					add_post_meta( $post_id, '_reino_love', $love_count, true );
				}

				return '<span class="iva-love-count">' . $love_count . '</span>';
				break;

			case 'update':
				$love_count = get_post_meta( $post_id, '_reino_love', true );
				if ( isset( $_COOKIE[ 'iva_love_' . $post_id ] ) ) {
					return $love_count;
				}

				$love_count++;
				update_post_meta( $post_id, '_reino_love', $love_count );
				setcookie( 'iva_love_' . $post_id, $post_id, time() * 20, '/' );

				return '<span class="iva-love-count">' . $love_count . '</span>';
				break;

		}
	}

	/**
	 * function reino_add_like()
	 */
	function reino_add_like() {
		global $post;

		$output = $this->reino_like_post( $post->ID );
		$class = 'iva-love';
		$title = esc_html__( 'Like this','reino' );
		if ( isset( $_COOKIE[ 'iva_love_' . $post->ID ] ) ) {
			$class = 'iva-love loved';
			$title = esc_html__( 'You already like this!','reino' );
		}

		return '<a href="#" class="' . $class . '" id="iva-love-' . $post->ID . '" title="' . $title . '">' . $output . ' <i class="fa fa-heart"></i></a>';
	}
}

$reino_post_like = new Reino_Post_Like();

/**
 * function reino_post_like()
 * get the ball rollin'
 */
function reino_post_like( $reino_like = '' ) {
	global $reino_post_like;
	if ( $reino_like == 'iva_like' ) {
		return $reino_post_like->reino_add_like();
	} else {
		echo wp_kses_post( $reino_post_like->reino_add_like() );
	}
}

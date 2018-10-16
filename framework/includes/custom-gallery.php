<?php
// Filters the default gallery shortcode output.
// If the filtered output isn’t empty, it will be used instead of generating the default gallery template.

add_filter( 'post_gallery', 'reino_post_gallery', 10, 3 );

function reino_post_gallery( $output = '', $atts, $instance ) {

	$post = get_post();

	static $instance = 0;
	$instance++;

	$defaults = array(
		'id'      => $post ? $post->ID : 0,
		'order'   => 'ASC',
		'orderby' => 'menu_order ID',
		'columns' => 3,
		'size'    => 'full',
	);

	if ( is_array( $atts ) ) {
		$atts = array_merge( $defaults, $atts );
	} else {
		$atts = array_merge( $defaults, (array) $atts );
	}

	$columns = $atts['columns'];

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) ) {
			$atts['orderby'] = 'post__in';
		}
		$atts['include'] = $atts['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) {
			unset( $attr['orderby'] );
		}
	}

	if ( ! empty( $atts['include'] ) ) {
		$post_attachments = get_posts(
			array(
				'include'        => $atts['include'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);

		$attachments = array();
		foreach ( $post_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $post_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'exclude'        => $atts['exclude'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	} else {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	}
	if ( empty( $attachments ) ) {
		return '';
	}

	$selector = "gallery-{$instance}";

	if ( isset( $atts['type'] ) ) {
		$type = $atts['type'];
	}

	if ( ! empty( $type ) ) {
		// Justified
		if ( 'justified' === $type ) {
			$output = '<div class="gallery-justified">';
			foreach ( $attachments as $id => $attachment ) {
				$attr = ( trim( $attachment->post_excerpt ) ) ?
				array(
					'aria-describedby' => "$selector-$id",
				) : '';

				if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
					$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
				} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
					$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
				} else {
					$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
				}
				$output .= '<figure>' . $image_output . '</figure>';
			}
			$output .= '</div>';
		}

		if ( 'slider' === $type ) {
			do_action( 'reino_theme_owlslider', get_the_ID() );
			if ( ! empty( $attachments ) ) {
				$output .= '<div class="owl-container gallery-slider">';
				$output .= '<div class="owl-carousel" id="reino_postformat_gallery">';
				foreach ( $attachments as $id => $attachment ) {
					$output .= '<div class="owl-item">' . wp_get_attachment_image( $id, 'full' ) . '</div>';
				}
				$output .= '</div>';//.owl-carousel
				$output .= '</div><div class="clear"></div>';
			}
		}

		if ( 'grid' === $type ) {
			// Grid

			$columns = $atts['columns'];

			if ( 5 === $columns ) {
				$columns = 4;
			} elseif ( 7 === $columns ) {
				$columns = 6;
			} elseif ( 8 === $columns ) {
				$columns = 6;
			} elseif ( 9 === $columns ) {
				$columns = 12;
			}

			$i       = 0;
			$output  = '<div class="gallery-grid">';
			$output .= '<div class="row">';
			foreach ( $attachments as $id => $attachment ) {
				$i++;
				$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
				if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
					$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
				} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
					$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
				} else {
					$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
				}
				$output .= '<div class="item col-md-' . ( 12 / $columns ) . '">';
				$output .= '<figure>';
				$output .= $image_output;
				$output .= '</figure>';
				$output .= '</div>';

				if ( $i === $columns ) {
					$output .= '</div><div class="row">';
					$i       = 0;
				}
			}
			$output .= '</div>';
		}
	}
	return $output;
}

add_action('print_media_templates', function() {
	// define your backbone template;
	// the "tmpl-" prefix is required,
	// and your input field should have a data-setting attribute
	// matching the shortcode name

	$gallery_types = apply_filters('print_media_templates_gallery_settings_types',
		array(
			'default_val' => esc_html__( 'Default', 'reino' ),
			'justified'   => esc_html__( 'Justified', 'reino' ),
			'grid'        => esc_html__( 'Grid', 'reino' ),
			'slider'      => esc_html__( 'Slider', 'reino' ),
		)
	);
	echo '<div id="tmpl-custom-gallery-type">';
	echo '<label class="setting">';
	echo '<span>' . esc_html__( 'Layout Type', 'reino' ) . '</span>';
	echo '<select data-setting="type">';
	foreach ( $gallery_types as $key => $value ) {
		echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
	}
	echo '</select>';
	echo '</label>';
	echo '</div>';
});
add_action( 'wp_enqueue_media', 'reino_gallery_enqueue_media' );
function reino_gallery_enqueue_media() {
	wp_enqueue_script( 'reino-custom-gallery-settings', REINO_FRAMEWORK_URI . 'admin/js/reino-custom-gallery.js', array(), '' );
}

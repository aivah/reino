<?php
/**
 * function reino_post_meta_date
 * Post Date Meta
 */
if ( ! function_exists( 'reino_post_meta_date' ) ) {
	function reino_post_meta_date( $tag = 'span', $icon = false ) {
		if ( get_option( 'reino_hide_date' ) !== 'on' ) {
			echo '<' . esc_attr( $tag ) . ' class="meta-date">';
			echo '<time class="meta-time" datetime="' . get_the_date( 'c' ) . '">';
			echo '<a href="' . esc_url( get_permalink() ) . '">' . get_the_date() . '</a>';
			echo '</time>';
			echo '</' . esc_attr( $tag ) . '>';
		}
	}
}
/**
 * function reino_post_meta_readtime
 * Post Reading Time
 */
if ( ! function_exists( 'reino_post_meta_readtime' ) ) {
	function reino_post_meta_readtime( $tag = 'span', $icon = false ) {
		$content          = apply_filters( 'the_content', get_post_field( 'post_content', get_the_ID() ) );
		$strip_shortcodes = strip_shortcodes( $content );
		$strip_tags       = strip_tags( $strip_shortcodes );
		$word_count       = str_word_count( $strip_tags );
		$reading_time     = ceil( $word_count / 250 );
		if ( get_option( 'reino_hide_read_time' ) !== 'on' ) {
			if ( true === $icon ) {
				echo '<' . esc_attr( $tag ) . ' class="meta-read-time"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> ' . esc_html( $reading_time ) . '</' . esc_attr( $tag ) . '>';
			}
			if ( false === $icon ) {
				echo '<' . esc_attr( $tag ) . ' class="meta-read-time">' . esc_html( $reading_time ) . esc_html__( ' Min Read', 'reino' ) . '</' . esc_attr( $tag ) . '>';
			}
		}
	}
}
/**
 * function reino_post_meta_author
 * Post Author Meta
 */
if ( ! function_exists( 'reino_post_meta_author' ) ) {
	function reino_post_meta_author( $tag = 'span', $icon = false ) {
		if ( get_option( 'reino_hide_author_name' ) !== 'on' ) {
			echo '<' . esc_attr( $tag ) . ' class="meta-author"><span class="by">' . esc_html__( 'By ', 'reino' ) . '</span>';
			echo '<a rel="nofollow" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>';
			echo '</' . esc_attr( $tag ) . '>'; //.meta-author
		}
	}
}
/**
 * function reino_post_meta_likes
 * Post Likes Meta
 */
if ( ! function_exists( 'reino_post_meta_likes' ) ) {
	function reino_post_meta_likes( $tag = 'span', $icon = false ) {
		if ( get_option( 'reino_hide_likes' ) !== 'on' ) {
			echo '<' . esc_attr( $tag ) . ' class="meta-likes">' . wp_kses_post( reino_post_like( 'iva_like' ) ) . '</' . esc_attr( $tag ) . '>';
		}
	}
}
/**
 * function reino_post_meta_views
 * Post Views Meta
 */
if ( ! function_exists( 'reino_post_meta_views' ) ) {
	function reino_post_meta_views( $tag = 'span', $icon = false ) {
		if ( get_option( 'reino_hide_views' ) !== 'on' ) {
			$reino_post_count = absint( get_post_meta( get_the_ID(), 'reino_post_views', true ) );
			if ( function_exists( 'reino_postviews_round_number' ) ) {
				$count = reino_postviews_round_number( $reino_post_count );
			}
			if ( true === $icon ) {
				echo '<' . esc_attr( $tag ) . ' class="meta-views"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> ' . esc_html( $count ) . '</' . esc_attr( $tag ) . '>';
			}
			if ( false === $icon ) {
				/* translators: %s: views count */
				$views_count = sprintf( _nx( '%s view', '%s views', $count, '', 'reino' ), $count );
				echo '<' . esc_attr( $tag ) . ' class="meta-views">' . esc_html( $views_count ) . '</' . esc_attr( $tag ) . '>';
			}
		}
	}
}
/**
 * function reino_postviews_round_number
 * Round Numbers To K (Thousand), M (Million) or B (Billion)
 */
if ( ! function_exists( 'reino_postviews_round_number' ) ) {
	function reino_postviews_round_number( $number, $min_value = 1000, $decimal = 1 ) {
		if ( $number < $min_value ) {
			return number_format_i18n( $number );
		}
		$alphabets = array(
			1000000000 => 'B',
			1000000    => 'M',
			1000       => 'K',
		);
		foreach ( $alphabets as $key => $value ) {
			if ( $number >= $key ) {
				return round( $number / $key, $decimal ) . '' . $value;
			}
		}
	}
}
/**
 * function reino_post_meta_comments
 * Post Comments Meta
 */
if ( ! function_exists( 'reino_post_meta_comments' ) ) {
	function reino_post_meta_comments( $tag = 'span', $icon = false ) {
		if ( get_option( 'reino_hide_comment_link' ) !== 'on' ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<' . esc_attr( $tag ) . ' class="meta-comments">';
				if ( false === $icon ) {
					echo '<i class="fa fa-comment-o fa-fw" aria-hidden="true"></i>';
				} if ( true === $icon ) {
					comments_popup_link( __( 'No Comments', 'reino' ), __( '1 Comment', 'reino' ), __( '% Comments', 'reino' ) );
				} else {
					comments_popup_link( ' 0', ' 1', ' %', 'comments-link', '' );
				}
				echo '</' . esc_attr( $tag ) . '>'; //.meta-comments
			}
		}
	}
}
/**
 * function reino_the_post_meta
 * Post Meta
 */
if ( ! function_exists( 'reino_the_post_meta' ) ) {
	function reino_the_post_meta( $meta_tag, $icon = true, $tag = 'span' ) {
		if ( ! empty( $meta_tag ) ) {
			echo '<ul class="post__meta">';
			foreach ( $meta_tag as $meta_function ) {
				$meta_function = "reino_post_meta_$meta_function";
				$meta_function( 'li', $icon );
			}
			echo '</ul>';
		}
	}
}
/**
 * function reino_post_category
 * Post Categories Meta
 */
if ( ! function_exists( 'reino_post_category' ) ) {
	function reino_post_category() {
		$categories = get_the_category( get_the_ID() );
		if ( get_option( 'reino_hide_categories' ) !== 'on' ) {
			echo '<ul class="post-categories">';
			foreach ( $categories as $category ) {
				$color = get_term_meta( $category->term_id, 'category_bg_color', true );
				$color = ( ! empty( $color ) ) ? 'style="color:#' . $color . ';"' : '';
				echo '<li><a ' . wp_kses_post( $color ) . ' href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
			}
			echo '</ul>';
		}
	}
}

/**
 * function reino_post_category_img
 * Post Category Image
 */
if ( ! function_exists( 'reino_category_img' ) ) {
	function reino_category_img( $size = 'thumbnail' ) {
		$categories = get_the_category( get_the_ID() );
		foreach ( $categories as $category ) {
			$category_img = get_term_meta( $category->term_id, 'category_image_id', true );
			echo wp_get_attachment_image( $category_img, $size );
		}
	}
}
/**
 * function reino_get_multi_tax_list
 * returns taxonomy terms list
 */
if ( ! function_exists( 'reino_get_multi_tax_list' ) ) {
	function reino_get_multi_tax_list( $post_id, $taxonomy, $link, $before = '', $sep = '', $after = '' ) {
		$multi_tax_terms = wp_get_object_terms( $post_id, $taxonomy );
		if ( ! empty( $multi_tax_terms ) ) {
			if ( ! is_wp_error( $multi_tax_terms ) ) {
				foreach ( $multi_tax_terms as $term ) {
					if ( 'true' === $link ) {
						$links[] = '<a href="' . esc_url( get_term_link( $term->slug, $taxonomy ) ) . '">' . esc_html( $term->name ) . '</a>';
					} else {
						$links[] = esc_html( $term->name );
					}
				}
			}
		}
		return $before . join( $sep, $links ) . $after;
	}
}

/**
 * function reino_featured_content
 * Featured Post
 */
if ( ! function_exists( 'reino_featured_image' ) ) {
	function reino_featured_image( $post_id ) {

		$reino_featured_img_type = '';
		$reino_img_src           = '';
		$reino_featured_img      = '';
		$reino_fs_css            = '';
		$before                  = '';
		$after                   = '';
		$class                   = '';

		$reino_featured_styling  = get_post_meta( $post_id, 'reino_featured_styling', true );
		$reino_featured_desc     = get_post_meta( $post_id, 'reino_featured_desc', true );
		$reino_featured_img_val  = get_post_meta( $post_id, 'reino_featured_img_type', true )
								? get_post_meta( $post_id, 'reino_featured_img_type', true )
								: '';
		$reino_featured_bgcolor  = get_post_meta( $post_id, 'reino_featured_bgcolor', true );
		$reino_featured_txtcolor = get_post_meta( $post_id, 'reino_featured_txtcolor', true );
		$reino_fs_txtcolor_val   = $reino_featured_txtcolor
								? 'color:' . $reino_featured_txtcolor . ';'
								: '';
		$reino_fs_bgcolor_val    = $reino_featured_bgcolor
								? 'background-color:' . $reino_featured_bgcolor . ';'
								: '';
		$reino_fs_txt_css        = ( '' !== $reino_fs_txtcolor_val ) ? ' style="' . $reino_fs_txtcolor_val . '"' : '';
		$reino_fs_bg_css         = ( '' !== $reino_fs_bgcolor_val ) ? ' style="' . $reino_fs_bgcolor_val . '"' : '';

		if ( 'default' === $reino_featured_img_val ) {
			$reino_featured_img_type = get_option( 'reino_featured_img_type' )
									? get_option( 'reino_featured_img_type' )
									: 'standard';
		} else {
			$reino_featured_img_type = $reino_featured_img_val;
		}

		if ( 'fullwidth' === $reino_featured_img_type ) {
			$class           = 'page-header page-header-bg ' . esc_attr( $reino_featured_styling ) . '';
			$reino_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_ID( $post_id ), 'reino-extra-large' );
		}

		if ( ! empty( $reino_thumbnail ) ) {
			$reino_fs_bgimg_val = $reino_thumbnail
							? 'background-image: url(' . $reino_thumbnail[0] . ');'
							: '';

			$reino_fs_css = ( '' !== $reino_fs_txtcolor_val || '' !== $reino_fs_bgimg_val )
							? ' style="' . $reino_fs_txtcolor_val . $reino_fs_bgimg_val . '"'
							: '';
		} else {
			$reino_fs_css = ( '' !== $reino_fs_txtcolor_val || '' !== $reino_fs_bgcolor_val )
							? ' style="' . $reino_fs_txtcolor_val . $reino_fs_bgcolor_val . '"'
							: '';
		}

		echo '<section class="' . esc_attr( $class ) . '" ' . $reino_fs_css . '>';
		echo '<div class="page-header-inner ' . esc_attr( $reino_featured_styling ) . '">';
		if ( is_singular( 'post' ) ) {
			echo esc_html( reino_post_category( $post_id ) );
		}
		echo '<h1 class="entry-title" ' . $reino_fs_txt_css . '>' . get_the_title( $post_id ) . '</h1>';
		if ( is_singular( 'page' ) ) {
			if ( ! empty( $reino_featured_desc ) ) {
				echo wp_kses_post( $reino_featured_desc );
			} else {
				if ( has_excerpt() ) {
					echo the_excerpt();
				}
			}
		}
		if ( is_singular( 'post' ) ) {
			if ( get_option( 'reino_postmeta' ) !== 'on' ) {
				reino_the_post_meta( array( 'date', 'readtime', 'views', 'likes' ), false );
			}
		}
		echo '</div>'; //.owl__caption
		echo '</section>'; //.
	}
}
/**
 * function reino_read_more
 * The Post Read More Button
 */
if ( ! function_exists( 'reino_read_more' ) ) {
	function reino_read_more( $url = '', $class = '' ) {
		if ( '' === $url ) {
			$url = get_the_permalink();
		}
		if ( '' === $class ) {
			$class = 'link_more';
		}
		if ( 'on' !== get_option( 'reino_post_read_more' ) ) {
			echo '<div class="post__more">';
			echo '<a href="' . esc_url( $url ) . '" class="btn btn-primary ' . esc_attr( $class ) . '"><span>' . esc_html__( 'Continue Reading ', 'reino' ) . '</span></a>';
			echo '</div>';
		}
	}
}

/**
 * function reino_pagination
 * Display navigation to next/previous set of posts when applicable.
 * Pagination
 */
if ( ! function_exists( 'reino_pagination' ) ) {
	function reino_pagination() {

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $GLOBALS['wp_query']->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => '<i class="fa fa-angle-left fa-fw"></i>' . esc_html__( 'Previous', 'reino' ),
				'next_text' => esc_html__( 'Next', 'reino' ) . '<i class="fa fa-angle-right fa-fw"></i>',
			)
		);

		if ( $links ) {
			$out  = '<nav class="navigation paging-navigation">';
			$out .= '<div class="pagination loop-pagination">';
			$out .= $links;
			$out .= '</div>';
			$out .= '</nav>';
		}
		echo wp_kses_post( $out );
	}
}

/**
 * function reino_body_class
 * Theme Body Class
 */
if ( ! function_exists( 'reino_body_class' ) ) {
	function reino_body_class( $classes ) {
		if (
			is_tag() ||
			is_search() ||
			is_404() ||
			is_home()
		) {
			$reino_frontpageid = '';
		} else {
			if ( class_exists( 'woocommerce' ) ) {
				if ( is_shop() ) {
					$reino_frontpageid = get_option( 'woocommerce_shop_page_id' );
				} elseif ( is_cart( get_option( 'woocommerce_cart_page_id' ) ) ) {
					$reino_frontpageid = get_option( 'woocommerce_cart_page_id' );
				} else {
					$reino_frontpageid = get_the_ID();
				}
			} else {
				$reino_frontpageid = get_the_ID();
			}
		}

		$reino_sidebar_layout = reino_generator( 'reino_sidebar_option', $reino_frontpageid );
		$reino_headerstyle    = get_option( 'reino_headerstyle' ) ? get_option( 'reino_headerstyle' ) : 'header-default';

		if ( is_single() || is_page() ) {
			$reino_featured_img_val  = get_post_meta( $reino_frontpageid, 'reino_featured_img_type', true ) ? get_post_meta( $reino_frontpageid, 'reino_featured_img_type', true ) : '';
			$reino_featured_location = get_post_meta( $reino_frontpageid, 'reino_featured_img_pos', true ) ? get_post_meta( $reino_frontpageid, 'reino_featured_img_pos', true ) : get_option( 'reino_featured_img_pos' );
			if ( 'default' === $reino_featured_img_val ) {
				$reino_featured_img_type = get_option( 'reino_featured_img_type' ) ? get_option( 'reino_featured_img_type' ) : 'standard';
			} else {
				$reino_featured_img_type = $reino_featured_img_val;
			}
			if ( 'inside_post' === $reino_featured_location ) {
				$classes[] = 'page-header-' . $reino_featured_img_type;
			}
		}
		if ( is_front_page() ) {
			if ( get_option( 'reino_owl_slider_type' ) === 'large' ) {
				$classes[] = 'header-owl-fullscreen';
			}
		}

		$reino_page_layout = get_post_meta( get_the_ID(), 'reino_page_layout', true );

		$reino_page_layout_ofw = get_option( 'reino_layoutoption' );

		if ( 'on' === $reino_page_layout || 'boxed' === $reino_page_layout_ofw ) {
			$classes[] = 'reino-boxed';
		}

		$reino_header_fullwidth = get_option( 'reino_header_fullwidth' );
		if ( 'on' === $reino_header_fullwidth ) {
			$classes[] = 'header-full';
		}
		$classes[] = $reino_sidebar_layout;
		$classes[] = $reino_headerstyle;

		return $classes;
	}
	add_filter( 'body_class', 'reino_body_class' );
} // End if().

/**
 * function reino_post_classes()
 */
if ( ! function_exists( 'reino_post_classes' ) ) {
	function reino_post_classes( $classes, $class, $post_id ) {
		if ( is_single() ) {
			$classes[] = 'singlepost';
		}
		if ( is_singular( 'slider' ) ) {
			$classes[] = 'post';
		}
		if ( is_singular( 'post' ) ) {
			$post_image_type = get_option( 'reino_post_image_type' ) ? get_option( 'reino_post_image_type' ) : 'none';
			if ( $post_image_type ) {
				$classes[] = $post_image_type;
			}
		}
		if ( 'on' === get_option( 'reino_post_radius' ) ) {
			$classes[] = 'is-radius';
		}
		if ( 'on' === get_option( 'reino_post_boxed' ) ) {
			$classes[] = 'is-boxed';
		}

		return $classes;
	}
	add_filter( 'post_class', 'reino_post_classes', 10, 3 );
}
/**
 * function reino_excerpt_length
 */
if ( ! function_exists( 'reino_excerpt_length' ) ) {
	function reino_excerpt_length( $length ) {
		return 200;
	}
	add_filter( 'excerpt_length', 'reino_excerpt_length', 999 );
}
/**
 * function reino_string_limit_words
 */
if ( ! function_exists( 'reino_string_limit_words' ) ) {
	function reino_string_limit_words( $string, $word_limit ) {
		$words = explode( ' ', $string, ( $word_limit + 1 ) );
		if ( count( $words ) > $word_limit ) {
			array_pop( $words );
		}
		return implode( ' ', $words );
	}
}
/**
 * function reino_excerpt_more
 */
if ( ! function_exists( 'reino_excerpt_more' ) ) {
	function reino_excerpt_more( $more ) {
		return '&hellip;';
	}
	add_filter( 'excerpt_more', 'reino_excerpt_more' );
}

/**
 * function reino_gallery_add_rel_attribute
 */
if ( ! function_exists( 'reino_gallery_add_rel_attribute' ) ) {
	function reino_gallery_add_rel_attribute( $link ) {
		global $post;
		return str_replace( '<a href', '<a data-rel="prettyPhoto[pp_default]" href', $link );
	}
	add_filter( 'wp_get_attachment_link', 'reino_gallery_add_rel_attribute' );
}

/**
 * function reino_sociables
 * Sociables List from theme options
 */
if ( ! function_exists( 'reino_sociables' ) ) {
	function reino_sociables( $color ) {
		$out = '';
		if ( get_option( 'reino_social_bookmark' ) != '' ) {
			$reino_social_bookmark_icons = explode( '#;', get_option( 'reino_social_bookmark' ) );
			$reino_socialbookmark_icons  = count( $reino_social_bookmark_icons );

			$out = '<ul class="at__social">';
			for ( $i = 0; $i < $reino_socialbookmark_icons; $i++ ) {
				$reino_social_icon = explode( '#|', $reino_social_bookmark_icons[ $i ] );
				if ( '' == $reino_social_icon[1] ) {
					$reino_social_icon[1] = '#';
				}
				if ( 'black' === $color ) {
					$icon_color = '_bio';
				} else {
					$icon_color = '';
				}
				if ( 'black' === $color ) {
					$out .= '<li class="' . $reino_social_icon[1] . '"><a class="at__social-link" href="' . esc_url( $reino_social_icon[2] ) . '" target="_blank">';
					$out .= '<i class="fa fa-' . $reino_social_icon[1] . ' fa-fw" title="' . $reino_social_icon[0] . '"></i></a></li>';
				} else {
					$out .= '<li class="' . $reino_social_icon[1] . '"><a class="at__social-link" href="' . esc_url( $reino_social_icon[2] ) . '" target="_blank">';
					$out .= '<i class="fa fa-' . $reino_social_icon[1] . ' fa-fw white" title="' . $reino_social_icon[0] . '"></i></a></li>';
				}
			} // End for().
			$out .= '</ul>';
		}
		return $out;
	}
}
/**
 * function reino_page_title
 * Page titles displays below header
 */
if ( ! function_exists( 'reino_page_title' ) ) {
	function reino_page_title() {
		global $wp_query;
		$allowed_html = array(
			'span' => array(),
			'h1'   => array(),
		);
		if ( is_archive() ) {
			if ( is_category() ) {
				/* translators: Archives category display */
				$subtitle = sprintf( wp_kses( __( 'Browsing Category: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = single_cat_title( '', false );
			} elseif ( is_tag() ) {
				/* translators: Archives tag display */
				$subtitle = sprintf( wp_kses( __( 'Archives by Tag: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = single_tag_title( '', false );
			} elseif ( is_author() ) {
				/* translators: Author name display */
				$subtitle = sprintf( wp_kses( __( 'All Posts by Author: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = get_the_author( '', false );
			} elseif ( is_year() ) {
				/* translators: Displays the year from the posts */
				$subtitle = sprintf( wp_kses( __( 'Archives by Year: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = get_the_date( 'Y' );
			} elseif ( is_month() ) {
				/* translators: Displays month from the posts */
				$subtitle = sprintf( wp_kses( __( 'Archives by Month: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = get_the_date( 'F Y' );
			} elseif ( is_day() ) {
				/* translators: Displays the day */
				$subtitle = sprintf( wp_kses( __( 'Archives by day: <span> %s posts</span>', 'reino' ), $allowed_html ), $wp_query->found_posts );
				$title    = get_the_date( 'F j, Y' );
			} else {
				$title = get_the_archive_title();
			}
		} elseif ( is_search() ) {
			$subtitle = wp_kses( esc_html__( 'Search Results for', 'reino' ), $allowed_html );
			$title    = get_search_query();
		} elseif ( is_404() ) {
			$subtitle = wp_kses( esc_html__( '<h2 class="big__sub-title">404</h2>', 'reino' ), $allowed_html );
			$title    = esc_html__( 'Page not found', 'reino' );
		} elseif ( is_page() ) {
			$title = get_the_title();
		}
		if ( isset( $title ) ) {
			echo '<div class="archive-details">';
			if ( isset( $subtitle ) ) {
				echo '<span class="archive__sub-title">' . wp_kses_post( $subtitle ) . '</span>';
			}
			echo '<h1>' . wp_kses_post( $title ) . '</h1>';
			echo '</div>';
		}
	}
}
/**
 * function reino_modify_read_more_link
 * Customize the contact information fields available to your WordPress users
 */
if ( ! function_exists( 'reino_modify_read_more_link' ) ) {
	function reino_modify_read_more_link() {
	}
	add_filter( 'the_content_more_link', 'reino_modify_read_more_link' );
}
/**
 * function reino_post_header
 */
if ( ! function_exists( 'reino_post_header' ) ) {
	function reino_post_header() {

		$categories = get_the_category( get_the_ID() );

		echo '<div class="post__header">';
		if ( get_the_category_list() && ( get_option( 'reino_hide_categories' ) !== 'on' ) ) {
			echo '<ul class="post-categories">';
			foreach ( $categories as $category ) {
				$color = get_term_meta( $category->term_id, 'category_bg_color', true );
				$color = ( ! empty( $color ) ) ? 'style="color:#' . $color . ';"' : '';
				echo '<li><a ' . wp_kses_post( $color ) . ' href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
			}
			echo '</ul>';
		}
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		echo '<div class="post__header-meta">';
		echo '<div class="post__header-avatar">' . get_avatar(
			get_the_author_meta( 'email' ),
			$size    = '30',
			$default = ''
		) . '</div>';
		if ( get_option( 'reino_postmeta' ) !== 'on' ) {
			reino_the_post_meta( array( 'date', 'author', 'likes', 'comments' ), true );
		}
		echo '</div>';
		echo '</div>'; //.post__header
	}
}
/**
 * function reino_post_media
 */
if ( ! function_exists( 'reino_post_media' ) ) {
	function reino_post_media() {
		$format           = get_post_format();
		$reino_blog_style = get_option( 'reino_blog_style' ) ? get_option( 'reino_blog_style' ) : '';
		$thumb            = wp_get_attachment_image_src( get_post_thumbnail_id(), 'reino-large-horizontal' );

		if ( 'post_standard_style' !== $reino_blog_style ) {
			if ( has_post_thumbnail() ) {
				echo '<div class="post__thumbnail">';
				if ( ! is_single() ) {
					if ( 'image' === $format ) {
						echo '<a href="' . esc_url( $thumb ) . '">' . get_the_post_thumbnail( get_the_ID(), 'reino-large-horizontal' ) . '</a>';
					} else {
						echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_post_thumbnail( get_the_ID(), 'reino-large-horizontal' ) . '</a>';
					}
				} elseif ( in_array( $format, array( 'gallery', 'video', 'audio', 'image' ) ) ) {
					get_template_part( 'templates/format', $format );
				}
				echo '</div>';
			}
		} else {
			if ( has_post_thumbnail() ) {
				echo '<div class="post__thumbnail">';
				if ( ! is_single() ) {
					echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_post_thumbnail( get_the_ID(), 'reino-large-horizontal' ) . '</a>';
				} elseif ( in_array( $format, array( 'gallery', 'video', 'audio', 'image' ) ) ) {
					get_template_part( 'templates/format', $format );
				}
				echo '</div>';
			}
		}
	}
}
/**
 * function reino_post_single_thumb
 */
if ( ! function_exists( 'reino_post_single_thumb' ) ) {
	function reino_post_single_thumb() {
		if ( has_post_thumbnail() ) {
			// echo '<div class="post__thumb hover-dots">';
			echo '<div class="post__thumb">';
			echo '<div class="post__thumbnail">';
			echo get_the_post_thumbnail( get_the_ID(), 'reino-large-horizontal' );
			// Read Time
			echo '<div class="post__thumbnail-meta">';
			reino_the_post_meta( array( 'readtime', 'views' ) );
			echo '</div>';//.post__thumb
			echo '</div>';//.post__thumb
			echo '</div>';//.post__thumb
		}
	}
}
/**
 * function reino_blog_post_entry
 * Post Content from them options
 */
if ( ! function_exists( 'reino_blog_post_entry' ) ) {
	function reino_blog_post_entry( $reino_post_count = false ) {
		if ( 'post_excerpt' === get_option( 'reino_post_content' ) ) {
			echo '<div class="post__excerpt">';
			echo reino_string_limit_words( get_the_excerpt(), 50 );
			echo '</div>';//.post__excerpt
		} elseif ( 'post_full' === get_option( 'reino_post_content' ) ) {
			echo '<div class="post__content">';
			the_content();
			echo '</div>';//.post__content
		}
	}
}
/**
 * function reino_post_view
 * Post View Counts
 */
if ( ! function_exists( 'reino_post_view' ) ) {
	function reino_post_view( $post_id ) {
		$count = get_post_meta( $post_id, 'reino_post_views', true );
		if ( '' === $count ) {
			$count = 0;
			delete_post_meta( $post_id, 'reino_post_views' );
			add_post_meta( $post_id, 'reino_post_views', 0 );
		}
		if ( '' !== $count ) {
			$count++;
			update_post_meta( $post_id, 'reino_post_views', $count );
		}
	}
}
/**
 * function reino_comment_form_fields
 * Comment Form Fields
 */
if ( ! function_exists( 'reino_comment_form_fields' ) ) {
	function reino_filter_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();

		$args     = array();
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$html5    = 'html5';
		$fields   = array(
			'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'reino' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'reino' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'reino' ) . '</label> ' .
						'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
		);

		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'reino_filter_comment_form_fields' );
}
/**
 * Filter wp_link_pages to add prev and next links to a numbered link list
 */
if ( ! function_exists( 'reino_wp_link_pages' ) ) {
	function reino_wp_link_pages( $args ) {

		if ( 'next_and_number' === $args['next_or_number'] ) {

			global $page, $numpages, $multipage, $more, $pagenow;

			$args['next_or_number'] = 'number';

			$prev = '';
			$next = '';

			if ( $multipage ) {
				if ( $more ) {
					$i = $page - 1;
					if ( $i && $more ) {
						$args['before'] .= _wp_link_page( $page - 1 )
						. $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$args['after'] = _wp_link_page( $page + 1 )
						. $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
						. $args['after'];
					}
				}
			}
		}
		return $args;
	}
	add_filter( 'wp_link_pages_args', 'reino_wp_link_pages' );
}

/**
 * function reino_tag_cloud
 * Remove inline styles from Tag Clouds
 */
if ( ! function_exists( 'reino_tag_cloud' ) ) {
	function reino_tag_cloud( $tag_string ) {
		return preg_replace( "/style='font-size:.+pt;'/", '', $tag_string );
	}
	add_filter( 'wp_generate_tag_cloud', 'reino_tag_cloud' );
}
if ( ! function_exists( 'set_tag_cloud_font_size' ) ) {
	function set_tag_cloud_font_size( $args ) {
		$args['smallest'] = 10; /* Set the smallest size to 12px */
		$args['largest']  = 10;  /* set the largest size to 19px */
		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'set_tag_cloud_font_size' );
}
/**
* Setup AJAX search function
**/
add_action( 'wp_ajax_reino_post_ajax_search', 'reino_post_ajax_search' );
add_action( 'wp_ajax_nopriv_reino_post_ajax_search', 'reino_post_ajax_search' );
function reino_post_ajax_search() {
	global $wpdb;
	if ( strlen( $_POST['s'] ) > 0 ) {
		$limit        = 10;
		$search       = strtolower( addslashes( $_POST['s'] ) );
		$search_query = "
			SELECT $wpdb->posts.*
			FROM $wpdb->posts
			WHERE 1=1 AND ((lower($wpdb->posts.post_title) like %s))
			AND $wpdb->posts.post_type IN ('post', 'page')
			AND (post_status = 'publish')
			ORDER BY $wpdb->posts.post_date DESC
			LIMIT $limit;
		";

		$searchposts = $wpdb->get_results( $wpdb->prepare( $search_query, '%' . $wpdb->esc_like( $search ) . '%' ), OBJECT );
		echo '<ul>';
		if ( ! empty( $searchposts ) ) {
			foreach ( $searchposts as $result_item ) {
				$post       = $result_item;
				$post_thumb = array();
				echo '<li>';
				if ( has_post_thumbnail( $post->ID, 'thumbnail' ) ) {
					$image_id   = get_post_thumbnail_id( $post->ID );
					$post_thumb = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
					$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					echo '<div class="s_thumb"><a href="' . esc_url( get_permalink( $post->ID ) ) . '"><img src="' . $post_thumb[0] . '" alt="' . $image_alt . '" /></a></div>';
				}
				echo '<div class="s_post">';
				echo '<h4 class="s_title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . get_the_title( $post->ID ) . '</h4></a>';
				echo '<span class="s_date"><i class="fa fa-clock-o"></i>' . get_the_date( get_option( 'date_format' ), $post->ID ) . '</span>';
				echo '</div>';
				echo '</li>';

			}
			echo '<li class="s_allpost"><a class="btn btn-primary" href="javascript:jQuery(\'#search__form\').submit()">' . esc_html__( 'View all results', 'reino' ) . '</a></li>';
			echo '</ul>';
		} else {
			echo '<li>' . esc_html__( 'No Results', 'reino' ) . '</li>';
		}
		echo '</ul>';
	}
	die();
}

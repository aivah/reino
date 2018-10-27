<?php

function reino_skin_generator() {
	$reino_option_var = array(
		'reino_themecolor',
		'reino_site_title',
		'reino_tagline',
		'reino_page_preloader_image',
		'reino_page_preloader_bgcolor',
		'reino_headerproperties',
		'reino_header_s3_height',
		'reino_topbar_bgcolor',
		'reino_topbar_text',
		'reino_topbar_link',
		'reino_bodyproperties',
		'reino_overlayimages',
		'reino_footer_area_middle',
		'reino_footer_area_bottom',
		'reino_footer_area_top',
		'reino_content_area_bg',
		'reino_breadcrumbtext',
		'reino_mmenu_bg',
		'reino_mmenu_font',
		'reino_mmenu_hoverbg',
		'reino_mmenu_linkhover',
		'reino_mmenu_dd_bg',
		'reino_mmenu_dd_link',
		'reino_mmenu_dd_linkhover',
		'reino_mmenu_dd_hoverbg',
		'reino_mmenu_active_link',
		'reino_link',
		'reino_linkhover',
		'reino_footerlink',
		'reino_footerlinkhover',
		'reino_copyrightlink',
		'reino_copyrightlinkhover',
		'reino_bodyfont',
		'reino_postmeta_font',
		'reino_headingfont',
		'reino_mainmenufont',
		'reino_bodyp',
		'reino_countdown_font',
		'reino_h1',
		'reino_h2',
		'reino_h3',
		'reino_h4',
		'reino_h5',
		'reino_h6',
		'reino_sidebar_widget_title',
		'reino_footer_widget_title',
		'reino_footer_widget_text',
		'reino_copyright_text',
		'reino_footer_area_top_bg_color',
		'reino_footer_area_top_text_color',
		'reino_footer_area_top_link_color',
		'reino_footer_area_top_link_hover_color',
		'reino_footer_area_bottom_bg_color',
		'reino_footer_area_bottom_text_color',
		'reino_footer_area_bottom_link_color',
		'reino_footer_area_bottom_link_hover_color',
		'reino_owlslider_width',
		'reino_owlslider_height',
		'reino_slider_bg_color',
		'reino_content_width',
		'reino_innercontent_width',
		'reino_boxedcontent_width',
	);
	foreach ( $reino_option_var as $value ) {
		$$value = get_option( $value );
	}

	$reino_sidebar_cw = get_option( 'reino_content_width' )
						? ( 100 - get_option( 'reino_content_width' ) )
						: '';

	global $post;
	$reino_page_bg_properties = get_post_meta( get_the_ID(), 'reino_page_bg_prop', true );

	if ( ! empty( $reino_page_bg_properties ) ) {
		$reino_page_bg_properties = array(
			'image'      => $reino_page_bg_properties['0']['image'],
			'repeat'     => $reino_page_bg_properties['0']['repeat'],
			'position'   => $reino_page_bg_properties['0']['position'],
			'color'      => $reino_page_bg_properties['0']['color'],
			'attachment' => $reino_page_bg_properties['0']['attachement'],
		);
	}

	$custom_css = '';

	$theme_color = isset( $reino_themecolor ) ? $reino_themecolor : '';

	if ( '' !== $theme_color ) {
		$custom_css = "
		#back-top span,
		.copyright,
		.button,
		button,
		.footer-area-top,
		input[type='button'],
		input[type='reset'], input[type='submit'],
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
		.woocommerce input.button.alt,
		.post-password-form input[type='submit'],
		.contributor-posts-link,
		.singlepost .post__tags a,
		.at-cases-details:after,
		.ac_wrap .ac_title.active,
		.at-service-container .at-item.style3 .at-image .at-category,
		.iva-date-ui.ui-widget-content .ui-state-active {
			background-color: {$theme_color} !important;
		}

		.content-area a,
		.post__header h2 a,
		.widget a,
		.client-name,
		.at-service-container .at-item.style2 .at-content .at-category i,
		.footer-wrap .contactinfo-wrap .icon,
		.breadcrumbs > span i.fa,
		.product-categories .cat-item a:hover:after,
		.at-staff-wapper .at-staff-info .info i,
		.widget_postslist li .pdesc a:hover,
		.widget_postslist li .w-postmeta:before,
		.at-vacancy-table-wrap .at-vacancy-table tbody td a,
		.at-vacancy-table-wrap .at-vacancy-table tbody td span,
		.woocommerce nav.woocommerce-pagination ul li a,
		.woocommerce nav.woocommerce-pagination ul li span,
		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current {
			color: {$theme_color};
		}

		.fancytitle span,
		blockquote,
		.iva-tabs li.current,
		.woocommerce ul.products li.product a:hover img,
		.at-vacancy-table-wrap .at-vacancy-table thead th.headerSortDown,
		.at-person.grid ul li:hover .at-person-image img,
		#sidebar .widget_nav_menu li.current_page_item > a,
		#sidebar .widget_nav_menu li.current_page_item > a:hover,
		#sidebar .widget_nav_menu li.current_page_item a,
		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current,
		.woocommerce ul.products li.product a:hover img {
			border-color: {$theme_color};
		}
	";
	} // End if().

	$custom_css .= reino_generate_font_prop( array( 'h1#site-title' ),
		$reino_site_title
	);

	$custom_css .= reino_gen_css_prop( array( 'h1#site-title a' ),
		array(
			'color' => $reino_site_title['color'],
		)
	);

	$custom_css .= reino_generate_font_prop( array( 'h2#site-description' ),
		$reino_tagline
	);

	$custom_css .= reino_gen_css_prop( array( '.reino_page_loader' ),
		array(
			'background-color' => $reino_page_preloader_bgcolor,
			'background-image' => 'url( ' . REINO_THEME_URI . '/images/svg-loaders/' . $reino_page_preloader_image . ')',
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.topbar-wrap' ),
		array(
			'background-color' => $reino_topbar_bgcolor,
			'color'            => $reino_topbar_text,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.topbar-wrap a',
			'.topbar .sec-menu a',
		), array(
			'color' => $reino_topbar_link,
		)
	);

	$custom_css .= reino_generate_image_prop( array( '.header-wrap' ),
		$reino_headerproperties
	);

	$reino_hs3_height = ! empty( $reino_header_s3_height ) ? (int) $reino_header_s3_height . 'px' : '';

	if ( ! empty( $reino_hs3_height ) ) {
		$custom_css .= reino_gen_css_prop(
			array(
				'.header-s1 .header-inner',
				'.header-s2 .header-inner',
				'.header-s3 .header-inner',
			), array(
				'min-height' => $reino_hs3_height,
			)
		);
	}

	$custom_css .= reino_generate_image_prop( array( 'body' ),
		$reino_bodyproperties
	);

	$custom_css .= reino_generate_image_prop( array( 'body' ),
		$reino_page_bg_properties
	);

	if ( ! empty( $reino_overlayimages ) ) {
		$custom_css .= reino_gen_css_prop( array( '.bodyoverlay' ),
			array(
				'background-image' => 'url( ' . REINO_THEME_URI . '/images/patterns/' . $reino_overlayimages . ')',
			)
		);
	}

	if ( ! empty( $reino_slider_bg_color ) ) {
		$custom_css .= reino_gen_css_prop( array( '.page-header-fullwidth .page-header' ),
			array(
				'background-color' => $reino_slider_bg_color,
			)
		);
	}

	$custom_css .= reino_generate_image_prop( array( '.footer-area-middle' ),
		$reino_footer_area_middle
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-bottom' ),
		array( 'background-color' => $reino_footer_area_bottom )
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-top' ),
		array( 'background-color' => $reino_footer_area_top )
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-top' ),
		array( 'background-color' => $reino_footer_area_top )
	);

	$custom_css .= reino_gen_css_prop( array( '.pagemid' ),
		array( 'background-color' => $reino_content_area_bg )
	);

	$custom_css .= reino_gen_css_prop( array( '.breadcrumbs' ),
		array(
			'color' => $reino_breadcrumbtext,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.content-area a',
			'.widget-title',
			'.widget li a',
			'.post__header h2 a',
			'.post__comments-nocomments',
		), array(
			'color' => $reino_link,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.content-area a:hover',
			'.post__header h2 a:hover',
			'.widget li a:hover',
		), array(
			'color' => $reino_linkhover,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.footer-area-middle a',
			'.footer-area-middle .widget a',
		), array(
			'color' => $reino_footerlink,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.footer-area-middle a:hover',
			'.footer-area-middle .widget a:hover',
		), array(
			'color' => $reino_footerlinkhover,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.copyright a' ),
		array(
			'color' => $reino_copyrightlink,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.copyright a:hover' ),
		array(
			'color' => $reino_copyrightlinkhover,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'body',
			'textarea',
			'select',
			'input',
		), array(
			'font-family' => $reino_bodyfont,
		)
	);
	$custom_css .= reino_gen_css_prop(
		array(
			'.btn',
			'button',
			'.post__meta',
			'.post__header .post-categories',
			'.post-categories',
			'.instagram-pics .insta-meta',
			'.wg-post-content .date',
			'.sidebar .widget a',
			'.footer-wrap .widget a',
			'.post-navigation .nav-next',
			'.post-navigation .nav-previous',
		), array(
			'font-family' => $reino_postmeta_font,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'.nav-links',
			'.post__comments-nocomments',
			'.post-navigation .meta-nav',
			'.author__description h4 a',
			'.promo__box-overlay h5',
			'.post-navigation .nav-next',
			'.post-navigation .nav-previous',
			'.content blockquote',
			'blockquote',
			'.posts__pagination .post__pagination-title',
		), array(
			'font-family' => $reino_headingfont,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.sf-menu' ),
		array(
			'font-family' => $reino_mainmenufont,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.countdown-amount',
			'.countdown-section',
		), array(
			'font-family' => $reino_countdown_font,
		)
	);

	$custom_css .= reino_generate_font_prop(
		array(
			'body',
			'input',
			'select',
			'textarea',
		),
		$reino_bodyp
	);

	$custom_css .= reino_generate_font_prop( array( 'h1' ), $reino_h1 );
	$custom_css .= reino_generate_font_prop( array( 'h2' ), $reino_h2 );
	$custom_css .= reino_generate_font_prop( array( 'h3' ), $reino_h3 );
	$custom_css .= reino_generate_font_prop( array( 'h4' ), $reino_h4 );
	$custom_css .= reino_generate_font_prop( array( 'h5' ), $reino_h5 );
	$custom_css .= reino_generate_font_prop( array( 'h6' ), $reino_h6 );
	$custom_css .= reino_generate_font_prop( array( '.widget-title' ),
		$reino_sidebar_widget_title
	);

	$custom_css .= reino_generate_font_prop( array( '.footer-wrap .widget-title' ),
		$reino_footer_widget_title
	);

	$custom_css .= reino_generate_font_prop( array( '.footer-wrap' ),
		$reino_footer_widget_text
	);

	$custom_css .= reino_generate_font_prop( array( '.copyright' ),
		$reino_copyright_text
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-top' ),
		array(
			'background-color' => $reino_footer_area_top_bg_color,
			'color'            => $reino_footer_area_top_text_color,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-top a' ),
		array(
			'color' => $reino_footer_area_top_link_color,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-top a:hover' ),
		array(
			'color' => $reino_footer_area_top_link_hover_color,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-bottom' ),
		array(
			'background-color' => $reino_footer_area_bottom_bg_color,
			'color'            => $reino_footer_area_bottom_text_color,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-bottom a' ),
		array(
			'color' => $reino_footer_area_bottom_link_color,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.footer-area-bottom a:hover' ),
		array(
			'color' => $reino_footer_area_bottom_link_hover_color,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.header-s1 .primary-menu',
			'.header-s2 .primary-menu',
			'.header-s3 .primary-menu',
		), array(
			'background-color' => $reino_mmenu_bg,
		)
	);

	$custom_css .= reino_generate_font_prop(
		array(
			'.sf-menu a',
			'.header-s1 .sf-menu > li > a',
			'.header-s2 .sf-menu > li > a',
			'.header-s3 .sf-menu > li > a',
		), $reino_mmenu_font
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.header-s1 .sf-menu li:hover',
			'.header-s2 .sf-menu li:hover',
			'.header-s3 .sf-menu li:hover',
		), array(
			'background-color' => $reino_mmenu_hoverbg,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.sf-menu a:hover',
			'.header-s1 .sf-menu > li > a:hover',
			'.header-s2 .sf-menu > li > a:hover',
			'.header-s3 .sf-menu > li > a:hover',
		), array(
			'color' => $reino_mmenu_linkhover,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.sf-mega',
			'.sf-menu ul',
		), array(
			'background-color' => $reino_mmenu_dd_bg,
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.sf-menu ul a' ),
		array(
			'color' => $reino_mmenu_dd_link,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.sf-menu li li:hover',
			'.sf-menu li li:hover ul',
			'.sf-menu li li.sfHover',
			'.sf-menu li li a:focus',
			'.sf-menu li li a:hover',
			'.sf-menu li li a:active',
		), array(
			'color' => $reino_mmenu_dd_linkhover,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.sf-menu li li:hover',
			'.sf-menu li li:hover ul',
			'.sf-menu li li.sfHover',
			'.sf-menu li li a:focus',
			'.sf-menu li li a:hover',
			'.sf-menu li li a:active',
		), array(
			'background-color' => $reino_mmenu_dd_hoverbg,
		)
	);

	$custom_css .= reino_gen_css_prop(
		array(
			'.sf-menu li.current-menu-item > a',
			'.sf-menu li.current-menu-ancestor > a',
			'.sf-menu li.current-page-ancestor > a',
		), array(
			'color' => $reino_mmenu_active_link,
		)
	);

	$reino_owlslider_width  = ! empty( $reino_owlslider_width ) ? $reino_owlslider_width : '1180px';
	$reino_owlslider_height = ! empty( $reino_owlslider_height ) ? $reino_owlslider_height : '600px';

	$custom_css .= reino_gen_media_queries(
		array(
			'.owl-carousel.owl-boxed .owl-item img',
			'.owl-carousel.owl-columns .owl-item img',
		), array(
			'height' => $reino_owlslider_height,
		), array(
			'min-width' => '992px',
		)
	);

	$custom_css .= reino_gen_media_queries(
		array(
			'.owl-boxed article',
		), array(
			'width' => $reino_owlslider_width,
		), array(
			'min-width' => '1200px',
		)
	);

	$custom_css .= reino_gen_css_prop( array( '.rightsidebar .content-area' ),
		array(
			'width' => $reino_content_width . '%',
		)
	);

	if ( $reino_sidebar_cw ) {
		$custom_css .= reino_gen_css_prop( array( '.rightsidebar #sidebar' ),
			array(
				'width' => $reino_sidebar_cw . '%',
			)
		);
	}

	if ( $reino_innercontent_width ) {
		$custom_css .= reino_gen_css_prop(
			array(
				'.inner',
				'.header-inner',
				'.menu-inner',
				'.pagemid > .inner',
				'.subheader-inner',
			), array(
				'width' => $reino_innercontent_width . 'px !important',
			)
		);
	}

	if ( $reino_boxedcontent_width ) {
		$custom_css .= reino_gen_css_prop( array( '#boxed #wrapper' ),
			array(
				'width' => $reino_boxedcontent_width . 'px',
			)
		);
	}

	if ( $reino_owlslider_width ) {
		$custom_css .= reino_gen_css_prop( array( '.owl-boxed' ),
			array(
				'max-width' => $reino_owlslider_width . '!important',
			)
		);
	}

	if ( class_exists( 'woocommerce' ) ) {
		wp_add_inline_style( 'reino-responsive', $custom_css );
	} else {
		wp_add_inline_style( 'reino-responsive', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'reino_skin_generator', 100 );

// Font css attributes
function reino_generate_font_prop( $selectors = null, $arr_var = null ) {

	$css = '';

	$inline_css = '';

	$size       = ! empty( $arr_var['size'] ) ? 'font-size:' . $arr_var['size'] . ';' : '';
	$color      = ! empty( $arr_var['color'] ) ? 'color:' . $arr_var['color'] . ';' : '';
	$lineheight = ! empty( $arr_var['lineheight'] ) ? 'line-height:' . $arr_var['lineheight'] . ';' : '';
	$style      = ! empty( $arr_var['style'] ) ? 'font-style:' . $arr_var['style'] . ';' : '';
	$variant    = ! empty( $arr_var['fontvariant'] ) ? 'font-weight:' . $arr_var['fontvariant'] . ';' : '';

	$css = "{$size} {$color} {$lineheight} {$style} {$variant}";
	$css = trim( $css );

	if ( isset( $selectors ) ) {
		if ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css", $selectors );
		}
	}
	// Apply inline CSS
	if ( '' == trim( $inline_css ) ) {
		$inline_css .= $css;
	} else {
		$inline_css .= '{ ' . $css . '} ';
	}
	// Format/Clean the CSS.
	$inline_css = "\n" . $inline_css;
	if ( '' != $css ) {
		return $inline_css;
	}
}

// Background image css attributes
function reino_generate_image_prop( $selectors = null, $arr_var = null ) {

	$css        = '';
	$inline_css = '';

	$image      = ( isset( $arr_var['image'] ) && ! empty( $arr_var['image'] ) )
				? 'background-image:url( ' . $arr_var['image'] . ' );'
				: '';
	$repeat     = isset( $arr_var['repeat'] )
				? 'background-repeat:' . $arr_var['repeat'] . ';'
				: '';
	$position   = isset( $arr_var['position'] )
				? 'background-position:' . $arr_var['position'] . ';'
				: '';
	$color      = ( isset( $arr_var['color'] ) && ! empty( $arr_var['color'] ) )
				? 'background-color:' . $arr_var['color'] . ';'
				: '';
	$attachment = isset( $arr_var['attachment'] )
				? 'background-attachment:' . $arr_var['attachment'] . ';'
				: '';

	if ( '' !== $image ) {
		$css = "{$image} {$repeat} {$position} {$color} {$attachment}";
	} else {
		$css = "{$color}";
	}

	if ( isset( $selectors ) ) {
		if ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css", $selectors );
		}
	}
	// Apply inline CSS
	if ( '' == trim( $inline_css ) ) {
		$inline_css .= $css;
	} else {
		$inline_css .= '{ ' . $css . '} ';
	}

	// Format/Clean the CSS.
	$inline_css = "\n" . $inline_css;
	if ( '' != $css ) {
		return $inline_css;
	}
}

function reino_gen_css_prop( $selectors = null, $properties = null ) {

	$css        = '';
	$inline_css = '';

	if ( is_array( $properties ) && ! empty( $properties ) ) {
		foreach ( $properties as $name => $value ) {
			if ( '' != $value ) {
				if ( 'font-family' === $name ) {
					$value = '"' . $value . '"';
				}
				$css .= "$name:$value; ";
			}
		}
	}
	if ( isset( $selectors ) ) {
		if ( is_string( $selectors ) && '' != $selectors ) {
			$inline_css .= $selectors;
		} elseif ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css", $selectors );
		}
	}

	// Apply inline CSS
	if ( '' == trim( $inline_css ) ) {
		$inline_css .= $css;
	} else {
		$inline_css .= '{ ' . $css . '} ';
	}

	// Format/Clean the CSS.
	$inline_css = "\n" . $inline_css;
	if ( '' != $css ) {
		return $inline_css;
	}

}

function reino_gen_media_queries( $selectors = null, $properties = null, $media_properties = null ) {

	$css         = '';
	$inline_css  = '';
	$media_query = '';

	if ( is_array( $properties ) && ! empty( $properties ) ) {
		foreach ( $properties as $name => $value ) {
			if ( '' != $value ) {
				if ( 'font-family' === $name ) {
					$value = '"' . $value . '"';
				}
				$css .= "$name:$value; ";
			}
		}
	}
	if ( isset( $selectors ) ) {
		if ( is_string( $selectors ) && '' != $selectors ) {
			$inline_css .= $selectors;
		} elseif ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css", $selectors );
		}
	}

	// Apply inline CSS
	if ( '' == trim( $inline_css ) ) {
		$inline_css .= $css;
	} else {
		$inline_css .= '{ ' . $css . '} ';
	}

	// Format/Clean the CSS.
	$inline_css = "\n" . $inline_css;

	if ( is_array( $media_properties ) && ! empty( $media_properties ) ) {
		$media_query = '@media only screen';
		foreach ( $media_properties as $name => $value ) {
			$media_query .= " and ( $name : $value ) ";
		}
		$media_query .= ' { ';
		if ( '' != $css ) {
			$media_query .= $inline_css;
		}
		$media_query .= ' } ';
		return $media_query;
	}
}

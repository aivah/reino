<?php

function vamico_skin_generator() {
	$vamico_option_var = array(
		'vamico_themecolor',
		'vamico_site_title',
		'vamico_tagline',
		'vamico_page_preloader_image',
		'vamico_page_preloader_bgcolor',
		'vamico_headerproperties',
		'vamico_header_s3_height',
		'vamico_topbar_bgcolor',
		'vamico_topbar_text',
		'vamico_topbar_link',
		'vamico_bodyproperties',
		'vamico_overlayimages',
		'vamico_footer_area_middle',
		'vamico_footer_area_bottom',
		'vamico_footer_area_top',
		'vamico_content_area_bg',
		'vamico_breadcrumbtext',
		'vamico_mmenu_bg',
		'vamico_mmenu_font',
		'vamico_mmenu_hoverbg',
		'vamico_mmenu_linkhover',
		'vamico_mmenu_dd_bg',
		'vamico_mmenu_dd_link',
		'vamico_mmenu_dd_linkhover',
		'vamico_mmenu_dd_hoverbg',
		'vamico_mmenu_active_link',
		'vamico_link',
		'vamico_linkhover',
		'vamico_footerlink',
		'vamico_footerlinkhover',
		'vamico_copyrightlink',
		'vamico_copyrightlinkhover',
		'vamico_bodyfont',
		'vamico_headingfont',
		'vamico_mainmenufont',
		'vamico_bodyp',
		'vamico_countdown_font',
		'vamico_h1',
		'vamico_h2',
		'vamico_h3',
		'vamico_h4',
		'vamico_h5',
		'vamico_h6',
		'vamico_sidebar_widget_title',
		'vamico_footer_widget_title',
		'vamico_footer_widget_text',
		'vamico_copyright_text',
		'vamico_footer_area_top_bg_color',
		'vamico_footer_area_top_text_color',
		'vamico_footer_area_top_link_color',
		'vamico_footer_area_top_link_hover_color',
		'vamico_footer_area_bottom_bg_color',
		'vamico_footer_area_bottom_text_color',
		'vamico_footer_area_bottom_link_color',
		'vamico_footer_area_bottom_link_hover_color',
		'vamico_owlslider_width',
		'vamico_owlslider_height',
		'vamico_slider_bg_color',
		'vamico_content_width',
		'vamico_innercontent_width',
		'vamico_boxedcontent_width',
	);
	foreach ( $vamico_option_var as $value ) {
		$$value = get_option( $value );
	}

	if ( get_option( 'vamico_content_width' ) ) {
		$vamico_sidebar_cw = 100 - get_option( 'vamico_content_width' );
	}

	global $post;
	$vamico_page_bg_properties = get_post_meta( get_the_ID(),'vamico_page_bg_prop', true );
	if ( ! empty( $vamico_page_bg_properties ) ) {
		$vamico_page_bg_properties = array(
			'image' 	=> $vamico_page_bg_properties['0']['image'],
			'repeat' 	=> $vamico_page_bg_properties['0']['repeat'],
			'position' 	=> $vamico_page_bg_properties['0']['position'],
			'color' 	=> $vamico_page_bg_properties['0']['color'],
			'attachment'=> $vamico_page_bg_properties['0']['attachement'],
		);
	}
	$custom_css = '';
	$theme_color = isset( $vamico_themecolor ) ? $vamico_themecolor : '';
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
			background-color:{$theme_color} !important;
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
			color:{$theme_color};
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

	$custom_css .= vamico_generate_font_prop( array(
		'h1#site-title',
		), $vamico_site_title
	);
	$custom_css .= vamico_gen_css_prop( array(
		'h1#site-title a',
		), array(
		 	'color' => $vamico_site_title['color'],
		)
	);

	$custom_css .= vamico_generate_font_prop( array(
		'h2#site-description',
		), $vamico_tagline
	);

	$custom_css .= vamico_gen_css_prop( array(
		'.vamico_page_loader',
		), array(
			'background-color' => $vamico_page_preloader_bgcolor,
			'background-image' => 'url( ' . VAMICO_THEME_URI . '/images/svg-loaders/' . $vamico_page_preloader_image . ')',
		)
	);

	$custom_css .= vamico_gen_css_prop( array(
		'.topbar-wrap',
		), array(
			'background-color' => $vamico_topbar_bgcolor,
		 	'color' => $vamico_topbar_text,
		)
	);

	$custom_css .= vamico_gen_css_prop( array(
		'.topbar-wrap a',
		'.topbar .sec-menu a',
		), array(
			'color' => $vamico_topbar_link,
		)
	);
	$custom_css .= vamico_generate_image_prop( array(
		'.header-wrap',
		), $vamico_headerproperties
	);

	$vamico_hs3_height = ! empty( $vamico_header_s3_height ) ? (int)$vamico_header_s3_height . 'px' : '';

	if ( ! empty( $vamico_hs3_height ) ) {
		$custom_css .= vamico_gen_css_prop( array(
			'.header-s1 .header-inner',
			'.header-s2 .header-inner',
			'.header-s3 .header-inner',
			),array(
				'min-height' => $vamico_hs3_height,
			)
		);
	}

	$custom_css .= vamico_generate_image_prop( array(
		'body',
		), $vamico_bodyproperties
	);

	$custom_css .= vamico_generate_image_prop( array(
		'body',
		), $vamico_page_bg_properties
	);
	if ( ! empty( $vamico_overlayimages ) ) {
		$custom_css .= vamico_gen_css_prop( array(
			'.bodyoverlay',
			), array(
				'background-image' => 'url( ' . VAMICO_THEME_URI . '/images/patterns/' . $vamico_overlayimages . ')',
			)
		);
	}
	if ( ! empty( $vamico_slider_bg_color ) ) {
		$custom_css .= vamico_gen_css_prop( array(
			'.page-header-wide .page-header',
			), array(
				'background-color' => $vamico_slider_bg_color,
			)
		);
	}
	$custom_css .= vamico_generate_image_prop( array(
		'.footer-area-middle',
		), $vamico_footer_area_middle
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-bottom',
		), array(
			'background-color' => $vamico_footer_area_bottom,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-top',
		), array(
			'background-color' => $vamico_footer_area_top,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-top',
		), array(
			'background-color' => $vamico_footer_area_top,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.pagemid',
		), array(
			'background-color' => $vamico_content_area_bg,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.breadcrumbs',
		), array(
			'color' => $vamico_breadcrumbtext,
		)
	);

	$custom_css .= vamico_gen_css_prop( array(
		'.content-area a',
		'.widget-title',
		'.widget li a',
		'.post__header h2 a',
		'.post__comments-nocomments',
		), array(
			'color' => $vamico_link,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.content-area a:hover',
		'.post__header h2 a:hover',
		'.widget li a:hover',
		), array(
			'color' => $vamico_linkhover,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-middle a',
		'.footer-area-middle .widget a',
		), array(
			'color' => $vamico_footerlink,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-middle a:hover',
		'.footer-area-middle .widget a:hover',
		), array(
			'color' => $vamico_footerlinkhover,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.copyright a',
		), array(
			'color' => $vamico_copyrightlink,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.copyright a:hover',
		), array(
			'color' => $vamico_copyrightlinkhover,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'body',
		'textarea',
		'select',
		'input',
		), array(
			'font-family' => $vamico_bodyfont,
		)
	);
	$custom_css .= vamico_gen_css_prop( array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.nav-links', '.post__comments-nocomments', '.post-navigation .meta-nav', '.author__description h4 a', '.promo__box-overlay h5', '.post-navigation .nav-next', '.post-navigation .nav-previous', '.content blockquote', 'blockquote', '.posts__pagination .post__pagination-title' ), array(
		'font-family' => $vamico_headingfont,
	) );
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu',
		), array(
			'font-family' => $vamico_mainmenufont,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.countdown-amount',
		'.countdown-section',
		), array(
			'font-family' => $vamico_countdown_font,
		)
	);

	$custom_css .= vamico_generate_font_prop( array(
		'body',
		'input',
		'select',
		'textarea',
		), $vamico_bodyp
	);
	$custom_css .= vamico_generate_font_prop( array( 'h1' ), $vamico_h1 );
	$custom_css .= vamico_generate_font_prop( array( 'h2' ), $vamico_h2 );
	$custom_css .= vamico_generate_font_prop( array( 'h3' ), $vamico_h3 );
	$custom_css .= vamico_generate_font_prop( array( 'h4' ), $vamico_h4 );
	$custom_css .= vamico_generate_font_prop( array( 'h5' ), $vamico_h5 );
	$custom_css .= vamico_generate_font_prop( array( 'h6' ), $vamico_h6 );
	$custom_css .= vamico_generate_font_prop( array(
		'.widget-title',
		), $vamico_sidebar_widget_title
	);
	$custom_css .= vamico_generate_font_prop( array(
		'.footer-wrap .widget-title',
		), $vamico_footer_widget_title
	);
	$custom_css .= vamico_generate_font_prop( array(
		'.footer-wrap',
		), $vamico_footer_widget_text
	);

	$custom_css .= vamico_generate_font_prop( array( '.copyright' ), $vamico_copyright_text );

	// Footer Area Top Properties
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-top',
		), array(
			'background-color' => $vamico_footer_area_top_bg_color,
		 	'color' => $vamico_footer_area_top_text_color,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-top a',
		), array(
		'color' => $vamico_footer_area_top_link_color,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-top a:hover',
		), array(
		'color' => $vamico_footer_area_top_link_hover_color,
		)
	);
	// Footer Area Top Properties
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-bottom',
		), array(
			'background-color' => $vamico_footer_area_bottom_bg_color,
		 	'color' => $vamico_footer_area_bottom_text_color,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-bottom a',
		), array(
			'color' => $vamico_footer_area_bottom_link_color,
		)
	);
	$custom_css .= vamico_gen_css_prop( array(
		'.footer-area-bottom a:hover',
		), array(
			'color' => $vamico_footer_area_bottom_link_hover_color,
		)
	);

	// Menu Background for header 3,2
	$custom_css .= vamico_gen_css_prop( array(
		'.header-s1 .primary-menu',
		'.header-s2 .primary-menu',
		'.header-s3 .primary-menu',
		), array(
			'background-color' => $vamico_mmenu_bg,
		)
	);

	// Menu font color and properties
	$custom_css .= vamico_generate_font_prop( array(
		'.sf-menu a',
		'.header-s1 .sf-menu > li > a',
		'.header-s2 .sf-menu > li > a',
		'.header-s3 .sf-menu > li > a',
		), $vamico_mmenu_font
	);

	// Menu Link Hover Background - Parent
	$custom_css .= vamico_gen_css_prop( array(
		'.header-s1 .sf-menu li:hover',
		'.header-s2 .sf-menu li:hover',
		'.header-s3 .sf-menu li:hover',
		), array(
		 	'background-color' => $vamico_mmenu_hoverbg,
		)
	);

	// Menu Link Hover Color
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu a:hover',
		'.header-s1 .sf-menu > li > a:hover',
		'.header-s2 .sf-menu > li > a:hover',
		'.header-s3 .sf-menu > li > a:hover',
		), array(
		 	'color' => $vamico_mmenu_linkhover,
		)
	);

	// Menu Dropdown Background
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-mega, .sf-menu ul'
		), array(
		 	'background-color' => $vamico_mmenu_dd_bg,
		)
	);

	// Menu Dropdown Link Color
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu ul a'
		), array(
		 	'color' => $vamico_mmenu_dd_link,
		)
	);

	// Menu Dropdown Link Color
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu li li:hover',
		'.sf-menu li li:hover ul',
		'.sf-menu li li.sfHover',
		'.sf-menu li li a:focus',
		'.sf-menu li li a:hover',
		'.sf-menu li li a:active',
		), array(
		 	'color' => $vamico_mmenu_dd_linkhover,
		)
	);

	// Menu Dropdown Link Color
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu li li:hover',
		'.sf-menu li li:hover ul',
		'.sf-menu li li.sfHover',
		'.sf-menu li li a:focus',
		'.sf-menu li li a:hover',
		'.sf-menu li li a:active',
		), array(
		 	'background-color' => $vamico_mmenu_dd_hoverbg,
		)
	);

	// Menu Active Link Background
	$custom_css .= vamico_gen_css_prop( array(
		'.sf-menu li.current-menu-item > a',
		'.sf-menu li.current-menu-ancestor > a',
		'.sf-menu li.current-page-ancestor > a',
		), array(
		 	'color' => $vamico_mmenu_active_link,
		)
	);
	$vamico_owlslider_width = ! empty( $vamico_owlslider_width ) ? $vamico_owlslider_width : '1180px';
	$vamico_owlslider_height = ! empty( $vamico_owlslider_height ) ? $vamico_owlslider_height : '400px';
	$custom_css .= vamico_gen_media_queries(
		array(
			'.owl-carousel.owl-boxed .owl-item img',
			'.owl-carousel.owl-center .owl-item img',
			'.owl-carousel.owl-multiple .owl-item img',
		), array(
			'height' => $vamico_owlslider_height,
		),
		array(
			'min-width' => '992px',
		)
	);

	$custom_css .= vamico_gen_media_queries(
		array(
			'.owl-boxed article',
			'.owl-center article',
		), array(
			'width' => $vamico_owlslider_width,
		),
		array(
			'min-width' => '1200px',
		)
	);

	$custom_css .= vamico_gen_css_prop(
		array(
			'.rightsidebar .content-area',
		), array(
			'width' => $vamico_content_width . '%',
		)
	);

	if($vamico_sidebar_cw) {
	$custom_css .= vamico_gen_css_prop(
		array(
			'.rightsidebar #sidebar',
		), array(
			'width' => $vamico_sidebar_cw . '%',
		)
	);
	}

	if( $vamico_innercontent_width ) {
	$custom_css .= vamico_gen_css_prop(
		array(
			'.inner',
			'.header-inner',
			'.menu-inner',
			'.pagemid > .inner',
			'.subheader-inner',
		), array(
			'width' => $vamico_innercontent_width . 'px !important',
		)
	);
	}

	if($vamico_boxedcontent_width){
	$custom_css .= vamico_gen_css_prop(
		array(
			'#boxed #wrapper',
		), array(
			'width' => $vamico_boxedcontent_width . 'px',
		)
	);
	}

	if($vamico_owlslider_width) {
	$custom_css .= vamico_gen_css_prop( array(
		'.owl-boxed'
		), array(
			'max-width' => $vamico_owlslider_width . '!important',
		)
	);
	}

	if ( class_exists( 'woocommerce' ) ) {
		wp_add_inline_style( 'vamico-responsive', $custom_css );
	} else {
		wp_add_inline_style( 'vamico-responsive', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'vamico_skin_generator', 100 );

//for font css attributes
function vamico_generate_font_prop( $selectors = null, $arr_var = null ) {
	$css = $inline_css = '';

	$size			= ! empty( $arr_var['size'] )		? 'font-size:' . $arr_var['size'] . ';' : '';
	$color			= ! empty( $arr_var['color'] ) 		? 'color:' . $arr_var['color'] . ';' : '';
	$lineheight		= ! empty( $arr_var['lineheight'] )	? 'line-height:' . $arr_var['lineheight'] . ';' : '';
	$style			= ! empty( $arr_var['style'] ) 		? 'font-style:' . $arr_var['style'] . ';' : '';
	$variant		= ! empty( $arr_var['fontvariant'] ) ? 'font-weight:' . $arr_var['fontvariant'] . ';' : '';

	$css = "{$size} {$color} {$lineheight} {$style} {$variant}";
	$css = trim( $css );

	if ( isset( $selectors ) ) {
		if ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css",  $selectors );
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

//for background image css attributes
function vamico_generate_image_prop( $selectors = null, $arr_var = null ) {

	$css = $inline_css = '';

	$image			= ( isset( $arr_var['image'] ) && ! empty( $arr_var['image'] ) ) ? 'background-image:url( ' . $arr_var['image'] . ' );' : '';
	$repeat			= isset( $arr_var['repeat'] ) ? 'background-repeat:' . $arr_var['repeat'] . ';' : '';
	$position		= isset( $arr_var['position'] ) ? 'background-position:' . $arr_var['position'] . ';' : '';
	$color			= ( isset( $arr_var['color'] ) && ! empty( $arr_var['color'] ) ) ? 'background-color:' . $arr_var['color'] . ';' : '';
	$attachment		= isset( $arr_var['attachment'] ) ? 'background-attachment:' . $arr_var['attachment'] . ';' : '';

	if ( '' !== $image ) {
		$css = "{$image} {$repeat} {$position} {$color} {$attachment}";
	} else {
		$css = "{$color}";
	}

	if ( isset( $selectors ) ) {
		if ( is_array( $selectors ) && ! empty( $selectors ) ) {
			$inline_css .= implode( ",\n$inline_css",  $selectors );
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

function vamico_gen_css_prop( $selectors = null, $properties = null ) {
	$css = $inline_css = '';

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
			$inline_css .= implode( ",\n$inline_css",  $selectors );
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

function vamico_gen_media_queries( $selectors = null, $properties = null, $media_properties = null ) {
	$css = $inline_css = $media_query = '';

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
			$inline_css .= implode( ",\n$inline_css",  $selectors );
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

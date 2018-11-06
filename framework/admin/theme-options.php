<?php
add_action( 'init', 'reino_theme_options' );
// Get theme version from style.css
if ( ! function_exists( 'reino_theme_options' ) ) {

	$reino_options = array();

	function reino_theme_options() {

		global $reino_options, $reino_theme_ob;

		$range_content_width = array();
		for ( $i = 80; $i >= 50; $i-- ) {
			$j = 100 - $i;

			$range_content_width[ $i ] = $i . '% | ' . $j . '%';
		}

		$options_array_allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'em'     => array(),
			'i'      => array(),
			'strong' => array(),
			'span'   => array(),
			'small'  => array(),
			'br'     => array(),
		);

		function reino_range( $start, $end, $steps = 1 ) {
			$range_options = array();
			$range_values  = range( $start, $end, $steps );
			foreach ( $range_values as $key => $value ) {
				$range_options[ $value ] = $value;
			}
			return $range_options;
		}

		$reino_fontface = array(
			''                                      => esc_html__( 'Select a font', 'reino' ),
			'Arial'                                 => esc_html__( 'Arial', 'reino' ),
			'Verdana'                               => esc_html__( 'Verdana', 'reino' ),
			'Tahoma'                                => esc_html__( 'Tahoma', 'reino' ),
			'Sans-serif'                            => esc_html__( 'Sans-serif', 'reino' ),
			'Lucida Grande'                         => esc_html__( 'Lucida Grande', 'reino' ),
			'Georgia, Serif'                        => esc_html__( 'Georgia', 'reino' ),
			'Trebuchet MS, Tahoma, Sans-serif'      => esc_html__( 'Trebuchet', 'reino' ),
			'Times New Roman, Geneva, Sans-serif'   => esc_html__( 'Times New Roman', 'reino' ),
			'Palatino, Palatino Linotyp, Serif'     => esc_html__( 'Palatino', 'reino' ),
			'Helvetica Neue, Helvetica, sans-serif' => esc_html__( 'Helvetica', 'reino' ),
		);
		/**
		* General Settings
		*/
		$reino_options[] = array(
			'name' => esc_html__( 'General', 'reino' ),
			'icon' => 'fa-cog',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Custom Logo', 'reino' ),
			'desc'    => esc_html__( 'Select the Logo Style you wish to use Title or Image.', 'reino' ),
			'id'      => 'reino_logo',
			'std'     => 'title',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'title' => esc_html__( 'Title', 'reino' ),
				'logo'  => esc_html__( 'Logo', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Dark Logo Image', 'reino' ),
			'desc'  => esc_html__( 'Upload a dark colored logo for your theme which will be displayed in white background areas, or specify the image url of your online logo. (http://yoursite.com/logo_dark.png)', 'reino' ),
			'id'    => 'reino_header_dark_logo',
			'std'   => '',
			'class' => 'iva_of logo',
			'type'  => 'upload',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Light Logo Image', 'reino' ),
			'desc'  => esc_html__( 'Upload a light colored logo for your theme which will be displayed in dark background areas, or specify the image url of your online logo. (http://yoursite.com/logo_light.png)', 'reino' ),
			'id'    => 'reino_header_light_logo',
			'std'   => '',
			'class' => 'iva_of logo',
			'type'  => 'upload',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Site Title', 'reino' ),
			'desc'  => esc_html__( 'Select Site Title Color and its Properties.', 'reino' ),
			'id'    => 'reino_site_title',
			'std'   => array(
				'size'        => '',
				'lineheight'  => '',
				'style'       => '',
				'fontvariant' => '',
			),
			'class' => 'iva_of title',
			'type'  => 'typography',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Site Description', 'reino' ),
			'desc'  => esc_html__( 'Select Site Description Color and its Properties.', 'reino' ),
			'id'    => 'reino_tagline',
			'std'   => array(
				'size'        => '',
				'lineheight'  => '',
				'style'       => '',
				'fontvariant' => '',
			),
			'class' => 'iva_of title',
			'type'  => 'typography',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Custom Favicon', 'reino' ),
			'desc' => esc_html__( 'Upload a 16px x 16px ICO icon format that will represent your website favicon.', 'reino' ),
			'id'   => 'reino_custom_favicon',
			'std'  => '',
			'type' => 'upload',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Disable General Preloader', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable General Preloader Image on front page.', 'reino' ),
			'id'   => 'reino_page_preloader',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'General Preloader Image', 'reino' ),
			'desc'    => esc_html__( 'Select the General Preloader Image.', 'reino' ),
			'id'      => 'reino_page_preloader_image',
			'std'     => '',
			'type'    => 'images',
			'class'   => 'svg_loader',
			'options' => array(
				'audio.svg'            => REINO_THEME_URI . '/images/svg-loaders/audio.svg',
				'rings.svg'            => REINO_THEME_URI . '/images/svg-loaders/rings.svg',
				'grid.svg'             => REINO_THEME_URI . '/images/svg-loaders/grid.svg',
				'hearts.svg'           => REINO_THEME_URI . '/images/svg-loaders/hearts.svg',
				'oval.svg'             => REINO_THEME_URI . '/images/svg-loaders/oval.svg',
				'three-dots.svg'       => REINO_THEME_URI . '/images/svg-loaders/three-dots.svg',
				'spinning-circles.svg' => REINO_THEME_URI . '/images/svg-loaders/spinning-circles.svg',
				'puff.svg'             => REINO_THEME_URI . '/images/svg-loaders/puff.svg',
				'circles.svg'          => REINO_THEME_URI . '/images/svg-loaders/circles.svg',
				'tail-spin.svg'        => REINO_THEME_URI . '/images/svg-loaders/tail-spin.svg',
				'bars.svg'             => REINO_THEME_URI . '/images/svg-loaders/bars.svg',
				'ball-triangle.svg'    => REINO_THEME_URI . '/images/svg-loaders/ball-triangle.svg',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'General Preloader Background Color', 'reino' ),
			'desc' => esc_html__( 'Preloader Background Color set to default with theme if you choose color from here it will change Preloader Background color.', 'reino' ),
			'id'   => 'reino_page_preloader_bgcolor',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Subheader (Page Title) Alignment', 'reino' ),
			'desc'    => esc_html__( 'Select Content Alignment. Choose between 1, 2 or 3 position layouts.', 'reino' ),
			'id'      => 'reino_subheader_align',
			'std'     => 'left',
			'type'    => 'images',
			'options' => array(
				'left'   => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'center' => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'right'  => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Subheader (Page Title)', 'reino' ),
			'desc'    => esc_html__( 'Page Title which appears in subheader section.', 'reino' ),
			'id'      => 'reino_subheader',
			'std'     => 'default',
			'class'   => 'select300',
			'options' => array(
				'default' => esc_html__( 'Default (post title)', 'reino' ),
				'disable' => esc_html__( 'Disable Subheader', 'reino' ),
			),
			'type'    => 'select',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Google API key', 'reino' ),
			'desc'      => esc_html__( 'Enter the Google API Key.', 'reino' ),
			'id'        => 'reino_google_api_key',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Headers', 'reino' ),
			'icon' => 'fa-header',
			'type' => 'heading',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name'    => esc_html__( 'Header Style', 'reino' ),
			'desc'    => esc_html__( 'Select the Style you wish to choose for the Header. If not selected default header will be selected. File Path themename/headers/header-default.php', 'reino' ),
			'id'      => 'reino_headerstyle',
			'std'     => '',
			'class'   => 'select300',
			'options' => array(
				''             => esc_html__( 'Choose Header Style', 'reino' ),
				'headerstyle1' => esc_html__( 'Header Style1', 'reino' ),
				'headerstyle2' => esc_html__( 'Header Style2', 'reino' ),
				'headerstyle3' => esc_html__( 'Header Style3', 'reino' ),
				'fixedheader'  => esc_html__( 'Fixed Header', 'reino' ),
			),
			'type'    => 'select',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Header Fullwidth', 'reino' ),
			'desc'  => esc_html__( 'Check this if you wish to make header as fullwidth.', 'reino' ),
			'id'    => 'reino_header_fullwidth',
			'class' => '',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Header Top', 'reino' ),
			'desc'  => esc_html__( 'Check this if you wish to make header top of the logo.', 'reino' ),
			'id'    => 'reino_headers3_position',
			'class' => 'iva_of_headerstyle headerstyle3',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Custom Header Height', 'reino' ),
			'desc'      => esc_html__( 'Enter the custom header height. Enter only the units without px / % / em.', 'reino' ),
			'id'        => 'reino_header_s3_height',
			'class'     => '',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Header Background Properties', 'reino' ),
			'desc'  => esc_html__( 'Select the Background Image for Header and assign its Properties according to your requirements.', 'reino' ),
			'id'    => 'reino_headerproperties',
			'class' => 'iva_of_headerstyle headerstyle1 headerstyle2 headerstyle3 headerstyle4 fixedheader',
			'std'   => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type'  => 'background',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Sociable Icons', 'reino' ),
			'desc'  => esc_html__( 'Check this if you wish to disable the Sociable Icons from Header Style4.', 'reino' ),
			'id'    => 'reino_disable_sociables',
			'class' => 'iva_of_headerstyle headerstyle4',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Sociable Icons Color', 'reino' ),
			'desc'  => esc_html__( 'Check this if you wish to change the Sociable Hover Color.', 'reino' ),
			'id'    => 'reino_sociables_color',
			'class' => 'iva_of_headerstyle headerstyle4',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Subscribe Button Link', 'reino' ),
			'desc'      => esc_html__( 'Enter the URL for subscribe button.', 'reino' ),
			'id'        => 'reino_subscribe_link',
			'class'     => 'iva_of_headerstyle headerstyle1',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Disable Subscribe Button', 'reino' ),
			'desc'  => esc_html__( 'Check this if you wish to disable subscribe button in header default.', 'reino' ),
			'id'    => 'reino_subscribe_btn_disable',
			'class' => 'iva_of_headerstyle headerstyle1',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Disable Search Icon', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable search icon in header default.', 'reino' ),
			'id'   => 'reino_search_icn_disable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Topbar Background Color', 'reino' ),
			'desc' => esc_html__( 'This will apply the Background Color to the Topbar.', 'reino' ),
			'id'   => 'reino_topbar_bgcolor',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Topbar Text Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Text Color to the Topbar.', 'reino' ),
			'id'   => 'reino_topbar_text',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Topbar Link Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Link Color in the Topbar.', 'reino' ),
			'id'   => 'reino_topbar_link',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Top Bar', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Top Bar.', 'reino' ),
			'id'   => 'reino_topbar',
			'std'  => '',
			'type' => 'checkbox',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Styling', 'reino' ),
			'icon' => 'fa-paint-brush',
			'type' => 'heading',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'General Elements', 'reino' ),
			'type' => 'subnav',
		);

		$reino_options[] = array(
			'name'    => esc_html__( 'Layout Width', 'reino' ),
			'desc'    => esc_html__( 'Please choose the width of your content and sidebar', 'reino' ),
			'id'      => 'reino_content_width',
			'std'     => '75',
			'type'    => 'select',
			'class'   => 'select300',
			'options' => $range_content_width,
		);

		$reino_options[] = array(
			'name'      => esc_html__( 'Inner Container', 'reino' ),
			'desc'      => esc_html__( 'Enter the Inner content area width. Enter only the units without px / % / em. Default is 1100', 'reino' ),
			'id'        => 'reino_innercontent_width',
			'std'       => '',
			'inputsize' => '300',
			'type'      => 'text',
		);

		$reino_options[] = array(
			'name'      => esc_html__( 'Boxed Container Wrapper', 'reino' ),
			'desc'      => esc_html__( 'Enter the boxed container wrappper area width. Enter only the units without px / % / em. Default is 1200', 'reino' ),
			'id'        => 'reino_boxedcontent_width',
			'std'       => '',
			'inputsize' => '300',
			'type'      => 'text',
		);

		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name'    => esc_html__( 'Layout Option', 'reino' ),
			'desc'    => esc_html__( 'Select the layout option BOXED/STRETCHED which you wish to choose for the theme.', 'reino' ),
			'id'      => 'reino_layoutoption',
			'std'     => 'stretched',
			'type'    => 'images',
			'class'   => 'select300',
			'options' => array(
				'stretched' => REINO_FRAMEWORK_URI . 'admin/images/columns/stretched.png',
				'boxed'     => REINO_FRAMEWORK_URI . 'admin/images/columns/boxed.png',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Theme Color', 'reino' ),
			'desc' => esc_html__( 'Theme Color set to default with theme. But if you wish to choose color from here it will change all the links and backgrounds used in the theme.', 'reino' ),
			'id'   => 'reino_themecolor',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Body Background Properties', 'reino' ),
			'desc' => esc_html__( 'Select the Background Image for Body and assign its Properties according to your requirements.', 'reino' ),
			'id'   => 'reino_bodyproperties',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Background Pattern Images', 'reino' ),
			'desc'    => esc_html__( 'Choose Background Pattern Images for the theme and this works only if the layout is selected as Boxed in Styling Section.', 'reino' ),
			'id'      => 'reino_overlayimages',
			'std'     => '',
			'type'    => 'images',
			'options' => array(
				''           => REINO_THEME_URI . '/images/patterns/no-pat.png',
				'pat_01.png' => REINO_THEME_URI . '/images/patterns/pattern-1-Preview.jpg',
				'pat_02.png' => REINO_THEME_URI . '/images/patterns/pattern-2-Preview.jpg',
				'pat_03.png' => REINO_THEME_URI . '/images/patterns/pattern-3-Preview.jpg',
				'pat_04.png' => REINO_THEME_URI . '/images/patterns/pattern-4-Preview.jpg',
				'pat_05.png' => REINO_THEME_URI . '/images/patterns/pattern-5-Preview.jpg',
				'pat_06.png' => REINO_THEME_URI . '/images/patterns/pattern-6-Preview.jpg',
				'pat_07.png' => REINO_THEME_URI . '/images/patterns/pattern-7-Preview.jpg',
				'pat_08.png' => REINO_THEME_URI . '/images/patterns/pattern-8-Preview.jpg',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Subheader Background Properties', 'reino' ),
			'desc' => esc_html__( 'Select the Background Image for Subheader and assign its Properties according to your requirements.', 'reino' ),
			'id'   => 'reino_subheaderproperties',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Subheader Title Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Color to the Subheader Text.', 'reino' ),
			'id'   => 'reino_subheader_textcolor',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Background', 'reino' ),
			'desc' => esc_html__( 'Footer Background Properties includes the sidebar footer widgets area as well. If you wish to disable footer area you can go to Footer Tab and do that..', 'reino' ),
			'id'   => 'reino_footer_area_middle',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Top Area Background', 'reino' ),
			'desc' => esc_html__( 'This will apply color to the footer top area of theme.', 'reino' ),
			'id'   => 'reino_footer_area_top',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Bottom Area Background', 'reino' ),
			'desc' => esc_html__( 'This will apply color to the footer top area of theme.', 'reino' ),
			'id'   => 'reino_footer_area_bottom',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Content Area Background Color', 'reino' ),
			'desc' => esc_html__( 'This will apply color to the primary content area of theme. This will work if you are not using Visual Composer background colors and stretched optin.', 'reino' ),
			'id'   => 'reino_content_area_bg',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Menu', 'reino' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Background', 'reino' ),
			'desc' => esc_html__( 'This applies the Background Color for Header Style2, Header Style3 and Header Style4 .', 'reino' ),
			'id'   => 'reino_mmenu_bg',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Font and Link Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Menu Parent Lists.', 'reino' ),
			'id'   => 'reino_mmenu_font',
			'type' => 'typography',
			'std'  => array(
				'size'        => '',
				'style'       => '',
				'color'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Hover BG', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Menu Hover BG.', 'reino' ),
			'id'   => 'reino_mmenu_hoverbg',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Hover Text', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Menu Hover Text.', 'reino' ),
			'id'   => 'reino_mmenu_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Background Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Background Color.', 'reino' ),
			'id'   => 'reino_mmenu_dd_bg',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Text Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Text Color.', 'reino' ),
			'id'   => 'reino_mmenu_dd_link',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Text Hover Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Text Hover Color.', 'reino' ),
			'id'   => 'reino_mmenu_dd_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Hover Background Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Hover Background Color.', 'reino' ),
			'id'   => 'reino_mmenu_dd_hoverbg',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Menu Active Link Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Active Link Color.', 'reino' ),
			'id'   => 'reino_mmenu_active_link',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Link Colors', 'reino' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Conent Area Link Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Theme Links.', 'reino' ),
			'id'   => 'reino_link',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Conent Area Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Select the Color for Theme Links Hover.', 'reino' ),
			'id'   => 'reino_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Subheader Link Color', 'reino' ),
			'desc' => esc_html__( 'Links under subheader section.', 'reino' ),
			'id'   => 'reino_subheaderlink',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Subheader Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Links Hover under subheader section.', 'reino' ),
			'id'   => 'reino_subheaderlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Link Color', 'reino' ),
			'desc' => esc_html__( 'Footer containing links under widget or text widget, (link color).', 'reino' ),
			'id'   => 'reino_footerlink',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Footer content containing any links under widget or text widget, (link hover color).', 'reino' ),
			'id'   => 'reino_footerlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Copyright Link Color', 'reino' ),
			'desc' => esc_html__( 'Copyright content containing any links color. (link color).', 'reino' ),
			'id'   => 'reino_copyrightlink',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Copyright Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Copyright content containing any links color. (link color).', 'reino' ),
			'id'   => 'reino_copyrightlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Typography', 'reino' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Google Font', 'reino' ),
			'desc' => wp_kses( __( '<br>Select the fonts you wish to use for the website fonts or google webfonts. If you select the headings font it will replace all the heading font family for the whole theme including footer and sidebar widget titles.', 'reino' ), $options_array_allowed_html ),
			'type' => 'subsection',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name'    => esc_html__( 'Body Font Family', 'reino' ),
			'desc'    => esc_html__( 'Select a Font Family for Body Content.', 'reino' ),
			'id'      => 'reino_bodyfont',
			'class'   => '',
			'options' => $reino_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'reino' ),
				'size' => '15px',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Headings Font Family', 'reino' ),
			'desc'    => esc_html__( 'Select a Font Family for Headings ( h1, h2, h3, h4, h5, h6 ).', 'reino' ),
			'id'      => 'reino_headingfont',
			'class'   => '',
			'options' => $reino_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'This is how your heading looks like!', 'reino' ),
				'size' => '36px',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Post Meta Font Family', 'reino' ),
			'desc'    => esc_html__( 'Select a Font Family for Post Meta Data.', 'reino' ),
			'id'      => 'reino_postmeta_font',
			'class'   => '',
			'options' => $reino_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'reino' ),
				'size' => '15px',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Menu Font Family', 'reino' ),
			'desc'    => esc_html__( 'Select a Font Family for Top Navigation Menu.', 'reino' ),
			'id'      => 'reino_mainmenufont',
			'class'   => '',
			'options' => $reino_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'This is how your menu font looks like', 'reino' ),
				'size' => '26px',
			),
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Various Font Properties', 'reino' ),
			'desc' => wp_kses( __( '<br>Select the front properties like font size, line-height, font-style and font-weight for various elements used in the theme.', 'reino' ), $options_array_allowed_html ),
			'type' => 'subsection',
		);
		//---------------------------------------------------------------------------------------------------
		$reino_options[] = array(
			'name' => esc_html__( 'Body', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Body Font.', 'reino' ),
			'id'   => 'reino_bodyp',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H1', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H1 Heading.', 'reino' ),
			'id'   => 'reino_h1',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H2', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H2 Heading.', 'reino' ),
			'id'   => 'reino_h2',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H3', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H3 Heading.', 'reino' ),
			'id'   => 'reino_h3',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H4', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H4 Heading.', 'reino' ),
			'id'   => 'reino_h4',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H5', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H5 Heading.', 'reino' ),
			'id'   => 'reino_h5',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'H6', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H6 Heading.', 'reino' ),
			'id'   => 'reino_h6',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Sidebar Widget Titles', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Sidebar Widget Titles.', 'reino' ),
			'id'   => 'reino_sidebar_widget_title',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Widget Titles', 'reino' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Footer Widget Titles.', 'reino' ),
			'id'   => 'reino_footer_widget_title',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Text', 'reino' ),
			'desc' => esc_html__( 'Select the Color &amp; Font Properties for Footer Section.', 'reino' ),
			'id'   => 'reino_footer_widget_text',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Copyright Text', 'reino' ),
			'desc' => esc_html__( 'Select the Color &amp; Font Properties for Copyright Section.', 'reino' ),
			'id'   => 'reino_copyright_text',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);

		/*---------------------------------------------------- */
		/* Slider Options                                      */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Sliders', 'reino' ),
			'icon' => 'fa-sliders',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Frontpage Slider', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Slider.', 'reino' ),
			'id'   => 'reino_slidervisble',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Select Slider Type', 'reino' ),
			'desc'    => esc_html__( 'Select which Slider you want to use for the Frontpage of the theme.', 'reino' ),
			'id'      => 'reino_slider',
			'std'     => 'owl_slider',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => $reino_theme_ob->reino_get_vars( 'slider_type' ),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Slider Image Size', 'reino' ),
			'desc'    => esc_html__( 'Below are the size names that are images cropped For the sizes added in theme check documentation.', 'reino' ),
			'id'      => 'reino_slider_img_size',
			'std'     => 'reino-extra-large',
			'class'   => 'select300 iva_of_sliders owl_slider',
			'type'    => 'select',
			'options' => array(
				'reino-extra-large'       => esc_html__( 'Default', 'reino' ),
				'reino-large-horizontal'  => esc_html__( 'Large Horizontal', 'reino' ),
				'reino-large-vertical'    => esc_html__( 'Large Vertical', 'reino' ),
				'reino-large-square'      => esc_html__( 'Large Square', 'reino' ),
				'reino-medium-horizontal' => esc_html__( 'Medium Horizontal', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Slider Post(s) From', 'reino' ),
			'id'      => 'reino_slider_post_from',
			'std'     => 'cat_names',
			'class'   => 'select300 iva_of_sliders owl_slider',
			'type'    => 'select',
			'options' => array(
				'cat_names' => esc_html__( 'Category', 'reino' ),
				'post_ids'  => esc_html__( 'Post ID(s)', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Category Names', 'reino' ),
			'desc'    => esc_html__( 'Select Post Categories to hold the slides from.', 'reino' ),
			'id'      => 'reino_slider_cat',
			'class'   => 'slider_post_from cat_names iva_of_sliders owl_slider',
			'std'     => 'postslider',
			'type'    => 'multiselect',
			'options' => $reino_theme_ob->reino_get_vars( 'posts' ),
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Post ID(s)', 'reino' ),
			'desc'      => esc_html__( 'Comma separated list of post ID(s) you wish to display.', 'reino' ),
			'id'        => 'reino_slider_post_ids',
			'class'     => 'slider_post_from post_ids iva_of_sliders owl_slider',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Owl Slider Type', 'reino' ),
			'desc'    => esc_html__( 'Select Slider Type.', 'reino' ),
			'id'      => 'reino_owl_slider_type',
			'class'   => 'iva_of_sliders owl_slider select300',
			'std'     => 'center',
			'type'    => 'select',
			'options' => array(
				'fullscreen' => esc_html__( 'Owl Fullscreen', 'reino' ),
				'boxed'      => esc_html__( 'Owl Boxed', 'reino' ),
				'columns'    => esc_html__( 'Owl Columns', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Number of Visible Slides', 'reino' ),
			'desc'    => esc_html__( 'Select Number of Visible Slides.', 'reino' ),
			'id'      => 'reino_owl_slides_number',
			'class'   => 'select300 iva_of_sliders owl_slider_type owl_slider columns',
			'std'     => '3',
			'type'    => 'select',
			'options' => reino_range( 1, 4 ),
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Carousel Limits', 'reino' ),
			'desc'      => esc_html__( 'Enter the limit for Slides you want to hold on the Slider', 'reino' ),
			'id'        => 'reino_owlslider_limit',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider owl_boxed columns fullscreen',
			'type'      => 'text',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Slider Width', 'reino' ),
			'desc'      => esc_html__( 'Enter the custom width of the slider, recommended width: 1200px for a fullwidth slider and 1100px for center slider.', 'reino' ),
			'id'        => 'reino_owlslider_width',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider boxed',
			'type'      => 'text',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Slider Height', 'reino' ),
			'desc'      => esc_html__( 'Enter the custom height of the slider, recommended height: 600px.', 'reino' ),
			'id'        => 'reino_owlslider_height',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider boxed columns',
			'type'      => 'text',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Caption Overlay', 'reino' ),
			'desc'      => esc_html__( 'Check this if  you wish to display caption below the image.', 'reino' ),
			'id'        => 'reino_owlslider_capoverlay',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider boxed columns',
			'type'      => 'checkbox',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Autoplay', 'reino' ),
			'desc'    => esc_html__( 'Selec the Autoplay option to play the carousel automatically', 'reino' ),
			'id'      => 'reino_owlslide_autoplay',
			'class'   => 'select300 iva_of_sliders owl_slider_type owl_slider boxed columns fullscreen',
			'std'     => 'true',
			'type'    => 'select',
			'options' => array(
				'true'  => esc_html__( 'True', 'reino' ),
				'false' => esc_html__( 'False', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Autoplay Interval', 'reino' ),
			'desc'    => esc_html__( 'Autoplay interval timeout for the slides. where 1000 = 1 sec', 'reino' ),
			'id'      => 'reino_owlslide_timeout',
			'std'     => '5000',
			'class'   => 'iva_of_sliders owl_slider_type owl_slider boxed columns fullscreen select300',
			'type'    => 'select',
			'options' => reino_range( 1000, 10000, 1000 ),
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Item spacings', 'reino' ),
			'desc'      => esc_html__( 'enter the margins between the slider images. Enter using pixels', 'reino' ),
			'id'        => 'reino_owlslide_margin',
			'std'       => '0',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider columns',
			'type'      => 'text',
			'inputsize' => '',
		);

		$reino_options[] = array(
			'name'    => esc_html__( 'Caption Default Position', 'reino' ),
			'desc'    => esc_html__( 'Select the caption position for the page, Left, Right or Center.', 'reino' ),
			'id'      => 'reino_slider_caption_pos',
			'class'   => 'iva_of_sliders owl_slider_type owl_slider boxed columns fullscreen',
			'std'     => 'is-center',
			'type'    => 'images',
			'options' => array(
				'is-left'   => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center' => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'  => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		);

		$reino_options[] = array(
			'name'  => esc_html__( 'Static Image', 'reino' ),
			'desc'  => esc_html__( 'Upload the image size 1920 x 750 pixels to display on the homepage instead of slider.', 'reino' ),
			'id'    => 'reino_static_image_upload',
			'std'   => '',
			'class' => 'iva_of_sliders static_image',
			'type'  => 'upload',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Custom Slider', 'reino' ),
			'desc'      => esc_html__( 'Use in your Custom Slider Plugin Shortcodes. Example : [revslider id="1"]', 'reino' ),
			'id'        => 'reino_customslider',
			'std'       => '',
			'class'     => 'iva_of_sliders customslider',
			'type'      => 'textarea',
			'inputsize' => '',
		);
		/*---------------------------------------------------- */
		/* Post Options                                        */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Post Options', 'reino' ),
			'icon' => 'fa-newspaper-o',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Post Featured Image Location', 'reino' ),
			'desc'    => esc_html__( 'Select the featured image position inside the post or outside', 'reino' ),
			'id'      => 'reino_featured_img_pos',
			'std'     => 'inside_post',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'inside_post'  => esc_html__( 'Inside Post', 'reino' ),
				'outside_post' => esc_html__( 'Outside Post', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Post Featured Image Types', 'reino' ),
			'desc'    => esc_html__( 'Select the post featured image style you wish to display', 'reino' ),
			'id'      => 'reino_featured_img_type',
			'std'     => 'default',
			'class'   => 'select300 inside_post reino_featured_img_type',
			'type'    => 'select',
			'options' => array(
				'default'   => esc_html__( 'Default', 'reino' ),
				'standard'  => esc_html__( 'Standard', 'reino' ),
				'fullwidth' => esc_html__( 'Full Width', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Slider Background Color', 'reino' ),
			'desc'  => esc_html__( 'This will apply Color to the slider Area.', 'reino' ),
			'id'    => 'reino_slider_bg_color',
			'class' => 'reino_slider_bg_color fullwidth',
			'std'   => '',
			'type'  => 'color',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Blog Styles', 'reino' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the posts layout', 'reino' ),
			'id'      => 'reino_blog_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'post_standard_style'      => esc_html__( 'Full Post Layout', 'reino' ),
				'post_grid_style'          => esc_html__( 'Grid Post Layout', 'reino' ),
				'post_list_style'          => esc_html__( 'List Post Layout', 'reino' ),
				'post_standard_grid_style' => esc_html__( '1 Full Post then Grid Layout', 'reino' ),
				'post_standard_list_style' => esc_html__( '1 Full Post then List Layout', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Archive Styles', 'reino' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the archive page', 'reino' ),
			'id'      => 'reino_archive_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'archive_standard_style' => esc_html__( 'Full Post Layout', 'reino' ),
				'archive_grid_style'     => esc_html__( 'Grid Post Layout', 'reino' ),
				'archive_list_style'     => esc_html__( 'List Post Layout', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Post Columns Styles', 'reino' ),
			'desc'    => esc_html__( 'Select the columns you wish to choose for frontpage posts', 'reino' ),
			'id'      => 'reino_post_cols',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'col-md-6' => esc_html__( '2 Columns', 'reino' ),
				'col-md-3' => esc_html__( '3 Columns', 'reino' ),
				'col-md-4' => esc_html__( '4 Columns', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Author Styles', 'reino' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the author archive page', 'reino' ),
			'id'      => 'reino_author_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				''       => esc_html__( 'Default', 'reino' ),
				'center' => esc_html__( 'Centered', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Blog Page Categories', 'reino' ),
			'desc'    => esc_html__( 'Selected Categories will hold the posts to display in Blog Page Template. ( template : template_blog.php)', 'reino' ),
			'id'      => 'reino_blog_cats',
			'std'     => '',
			'type'    => 'multicheck',
			'options' => $reino_theme_ob->reino_get_vars( 'categories' ),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Featured Image from top of Post', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the featured image from top of the post.', 'reino' ),
			'id'   => 'reino_hide_featured_img',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Post Content', 'reino' ),
			'desc'    => esc_html__( 'Select the option you wish to choose for the content display style of the post.', 'reino' ),
			'id'      => 'reino_post_content',
			'std'     => 'post_excerpt',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'post_excerpt'   => esc_html__( 'Post Excerpt', 'reino' ),
				'post_full'      => esc_html__( 'Full Post', 'reino' ),
				'post_nocontent' => esc_html__( 'No Content', 'reino' ),
			),
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Post Readmore', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable readmore button from the posts.', 'reino' ),
			'id'   => 'reino_post_read_more',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Categories', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable categories from the post.', 'reino' ),
			'id'   => 'reino_hide_categories',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Date', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable date from the post.', 'reino' ),
			'id'   => 'reino_hide_date',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Author Name', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable author name from the post.', 'reino' ),
			'id'   => 'reino_hide_author_name',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Share Button', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable share button from the post.', 'reino' ),
			'id'   => 'reino_hide_share_btns',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Likes', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable likes from the post.', 'reino' ),
			'id'   => 'reino_hide_likes',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Views', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable views from the post.', 'reino' ),
			'id'   => 'reino_hide_views',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Readtime', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable read time from the post.', 'reino' ),
			'id'   => 'reino_hide_read_time',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Tags', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable date from the post.', 'reino' ),
			'id'   => 'reino_hide_tags',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Hide Comment link', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable Comment links from the post.', 'reino' ),
			'id'   => 'reino_hide_comment_link',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'About Author', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Author Info in Post Single Page.', 'reino' ),
			'id'   => 'reino_about_author',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Related Posts', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Related Posts in Post Single Page (based on tags).', 'reino' ),
			'id'   => 'reino_relatedposts',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name'      => esc_html__( 'Related Posts limit', 'reino' ),
			'desc'      => esc_html__( 'Enter the no.of posts to display.', 'reino' ),
			'id'        => 'reino_related_limit',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Post Pagination', 'reino' ),
			'desc' => wp_kses( __( 'Check this if you wish to disable <strong>Next/Previous</strong> Post Pagination.', 'reino' ), $options_array_allowed_html ),
			'id'   => 'reino_singlenavigation',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Blog Post Meta', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable Meta Data in Blog Posts and Single Page.', 'reino' ),
			'id'   => 'reino_postmeta',
			'std'  => '',
			'type' => 'checkbox',
		);

		$reino_options[] = array(
			'name' => esc_html__( 'Posts Boxed Style', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to use the boxed style for the posts.', 'reino' ),
			'id'   => 'reino_post_boxed',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Posts Bordered Style', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to use the border style for the posts. Make sure the Posts Boxed Style is selected above.', 'reino' ),
			'id'   => 'reino_post_radius',
			'std'  => '',
			'type' => 'checkbox',
		);

		/*---------------------------------------------------- */
		/* Sidebar Options                                     */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Sidebars', 'reino' ),
			'icon' => 'fa-columns',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Custom Sidebars', 'reino' ),
			'desc' => esc_html__( 'Create the custom sidebars and go to <strong>Appearance > Widgets</strong> to see the newly sidebar you have created. After assigning the widgets in the prefered sidebar you can assign specific sidebar to specific pages/posts in Options below the WordPress content editor of each page/post.', 'reino' ),
			'id'   => 'reino_customsidebar',
			'std'  => '',
			'type' => 'customsidebar',
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Sidebars Layout', 'reino' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the page, Left Sidebar, Right Sidebar or Full Width.', 'reino' ),
			'id'      => 'reino_defaultlayout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => REINO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => REINO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => REINO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Archive page Layout', 'reino' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the archive page, Left Sidebar, Right Sidebar or Full Width.', 'reino' ),
			'id'      => 'reino_archive_layout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => REINO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => REINO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => REINO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		$reino_options[] = array(
			'name'    => esc_html__( 'Author page Layout', 'reino' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the author page, Left Sidebar, Right Sidebar or Full Width.', 'reino' ),
			'id'      => 'reino_author_layout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => REINO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => REINO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => REINO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		/*---------------------------------------------------- */
		/* Footer Options                                      */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Footer', 'reino' ),
			'icon' => 'fa-columns',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Ads Before Footer', 'reino' ),
			'desc' => esc_html__( 'The content displays before footer widgets', 'reino' ),
			'id'   => 'reino_ads_content',
			'std'  => '',
			'type' => 'textarea',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Sidebar', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Sidebar.', 'reino' ),
			'id'   => 'reino_footer_sidebar',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Widget Layout', 'reino' ),
			'desc' => esc_html__( 'Select the Footer Columns for Widgets. If you choose 4 columns drag only 4 Widgets in Footer Widgets Section', 'reino' ),
			'id'   => 'reino_footer_widget_layout',
			'std'  => '',
			'type' => 'add_uislider',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Top Enable / Disable', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Area Top.', 'reino' ),
			'id'   => 'reino_footer_area_top',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Top Background Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Top of theme.', 'reino' ),
			'id'   => 'reino_footer_area_top_bg_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Top Text Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Top of theme.', 'reino' ),
			'id'   => 'reino_footer_area_top_text_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Top Link Color', 'reino' ),
			'desc' => esc_html__( 'Footer Area Top content containing any links color. (link color)..', 'reino' ),
			'id'   => 'reino_footer_area_top_link_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Top Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Footer Area Top content containing any links hover color. (link color)..', 'reino' ),
			'id'   => 'reino_footer_area_top_link_hover_color',
			'std'  => '',
			'type' => 'color',
		);
		// Footer Area Bottom
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Enable / Disable', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Area Bottom.', 'reino' ),
			'id'   => 'reino_footer_area_bottom',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Background Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Bottom of theme.', 'reino' ),
			'id'   => 'reino_footer_area_bottom_bg_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Text Color', 'reino' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Bottom of theme.', 'reino' ),
			'id'   => 'reino_footer_area_bottom_text_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Link Color', 'reino' ),
			'desc' => esc_html__( 'Footer Area Bottom content containing any links color. (link color)..', 'reino' ),
			'id'   => 'reino_footer_area_bottom_link_color',
			'std'  => '',
			'type' => 'color',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Link Hover Color', 'reino' ),
			'desc' => esc_html__( 'Footer Area Bottom content containing any links hover color. (link color)..', 'reino' ),
			'id'   => 'reino_footer_area_bottom_link_hover_color',
			'std'  => '',
			'type' => 'color',
		);
		/*---------------------------------------------------- */
		/* Sociables                                           */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Sociables', 'reino' ),
			'icon' => 'fa-share-alt',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Sociables', 'reino' ),
			'desc' => esc_html__( 'Click Add New to add Sociables where you can add / delete. If you wish to use in widgets then use the shortcode as [sociable color="black/white"].', 'reino' ),
			'id'   => 'reino_social_bookmark',
			'std'  => '',
			'type' => 'custom_socialbook_mark',
		);
		/*---------------------------------------------------- */
		/* Share links Options                                 */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Sharelinks', 'reino' ),
			'icon' => 'fa-share',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Google+', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Google+ Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_google_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Facebook', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Facebook Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_facebook_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'LinkedIn', 'reino' ),
			'desc' => esc_html__( 'Check this to enable LinkedIn Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_linkedIn_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Digg', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Digg Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_digg_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'StumbleUpon', 'reino' ),
			'desc' => esc_html__( 'Check this to enable StumbleUpon Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_stumbleupon_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Pinterest', 'reino' ),
			'desc'  => esc_html__( 'Check this to enable Pinterest Icon for Post Sharing.', 'reino' ),
			'id'    => 'reino_pinterest_enable',
			'class' => 'pinterest_sharing',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Twitter', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Twitter Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_twitter_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Tumblr', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Tumblr Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_tumblr_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Email', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Email Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_email_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Reddit', 'reino' ),
			'desc' => esc_html__( 'Check this to enable Reddit Icon for Post Sharing.', 'reino' ),
			'id'   => 'reino_reddit_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		/*---------------------------------------------------- */
		/* Import and Export                                   */
		/*---------------------------------------------------- */
		$reino_options[] = array(
			'name' => esc_html__( 'Options Backup', 'reino' ),
			'icon' => 'fa-floppy-o',
			'type' => 'heading',
		);
		$reino_options[] = array(
			'name' => esc_html__( 'Options Backup', 'reino' ),
			'desc' => esc_html__( 'Import,Export Backup options.', 'reino' ),
			'type' => 'subsection',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Export Backup Options', 'reino' ),
			'desc'  => esc_html__( 'This will Export Backup Options.', 'reino' ),
			'id'    => 'reino_export_backup_options',
			'std'   => '',
			'class' => 'atp-backup-options',
			'type'  => 'export_backupoptions',
		);
		$reino_options[] = array(
			'name'  => esc_html__( 'Import Backup Options', 'reino' ),
			'desc'  => esc_html__( 'This will Import Backup Options you saved. Location theme/framework/admin/options-importer/export_options/.', 'reino' ),
			'id'    => 'reino_import_backup_options',
			'std'   => '',
			'class' => 'atp-backup-options',
			'type'  => 'import_backupoptions',
		);
		// Additional Theme Options from Niche Theme Folder
		$reino_options = apply_filters( 'custompost_themeoptions', $reino_options );
		// Custom Additional Localization Options
		$reino_options = apply_filters( 'customlocalization_themeoptions', $reino_options );

		return $reino_options;
	}
} // End if().

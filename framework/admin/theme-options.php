<?php
add_action( 'init', 'vamico_theme_options' );
// Get theme version from style.css
if ( ! function_exists( 'vamico_theme_options' ) ) {

	$vamico_options = array();

	function vamico_theme_options() {

		global $vamico_options, $vamico_theme_ob;

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

		function vamico_range( $start, $end, $steps = 1 ) {
			$range_options = array();
			$range_values  = range( $start, $end, $steps );
			foreach ( $range_values as $key => $value ) {
				$range_options[$value] = $value;
			}
			return $range_options;
		}

		$vamico_fontface = array(
			''                                      => esc_html__( 'Select a font', 'vamico' ),
			'Arial'                                 => esc_html__( 'Arial', 'vamico' ),
			'Verdana'                               => esc_html__( 'Verdana', 'vamico' ),
			'Tahoma'                                => esc_html__( 'Tahoma', 'vamico' ),
			'Sans-serif'                            => esc_html__( 'Sans-serif', 'vamico' ),
			'Lucida Grande'                         => esc_html__( 'Lucida Grande', 'vamico' ),
			'Georgia, Serif'                        => esc_html__( 'Georgia', 'vamico' ),
			'Trebuchet MS, Tahoma, Sans-serif'      => esc_html__( 'Trebuchet', 'vamico' ),
			'Times New Roman, Geneva, Sans-serif'   => esc_html__( 'Times New Roman', 'vamico' ),
			'Palatino, Palatino Linotyp, Serif'     => esc_html__( 'Palatino', 'vamico' ),
			'Helvetica Neue, Helvetica, sans-serif' => esc_html__( 'Helvetica', 'vamico' ),
		);
		/**
		* General Settings
		*/
		$vamico_options[] = array(
			'name' => esc_html__( 'General', 'vamico' ),
			'icon' => 'fa-cog',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Custom Logo', 'vamico' ),
			'desc'    => esc_html__( 'Select the Logo Style you wish to use Title or Image.', 'vamico' ),
			'id'      => 'vamico_logo',
			'std'     => 'title',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'title' => esc_html__( 'Title', 'vamico' ),
				'logo'  => esc_html__( 'Logo', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Dark Logo Image', 'vamico' ),
			'desc'  => esc_html__( 'Upload a dark colored logo for your theme which will be displayed in white background areas, or specify the image url of your online logo. (http://yoursite.com/logo_dark.png)', 'vamico' ),
			'id'    => 'vamico_header_dark_logo',
			'std'   => '',
			'class' => 'iva_of logo',
			'type'  => 'upload',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Light Logo Image', 'vamico' ),
			'desc'  => esc_html__( 'Upload a light colored logo for your theme which will be displayed in dark background areas, or specify the image url of your online logo. (http://yoursite.com/logo_light.png)', 'vamico' ),
			'id'    => 'vamico_header_light_logo',
			'std'   => '',
			'class' => 'iva_of logo',
			'type'  => 'upload',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Site Title', 'vamico' ),
			'desc'  => esc_html__( 'Select Site Title Color and its Properties.', 'vamico' ),
			'id'    => 'vamico_site_title',
			'std'   => array(
				'size'        => '',
				'lineheight'  => '',
				'style'       => '',
				'fontvariant' => '',
			),
			'class' => 'iva_of title',
			'type'  => 'typography',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Site Description', 'vamico' ),
			'desc'  => esc_html__( 'Select Site Description Color and its Properties.', 'vamico' ),
			'id'    => 'vamico_tagline',
			'std'   => array(
				'size'        => '',
				'lineheight'  => '',
				'style'       => '',
				'fontvariant' => '',
			),
			'class' => 'iva_of title',
			'type'  => 'typography',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Custom Favicon', 'vamico' ),
			'desc' => esc_html__( 'Upload a 16px x 16px ICO icon format that will represent your website favicon.', 'vamico' ),
			'id'   => 'vamico_custom_favicon',
			'std'  => '',
			'type' => 'upload',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Disable General Preloader', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable General Preloader Image on front page.', 'vamico' ),
			'id'   => 'vamico_page_preloader',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'General Preloader Image', 'vamico' ),
			'desc'    => esc_html__( 'Select the General Preloader Image.', 'vamico' ),
			'id'      => 'vamico_page_preloader_image',
			'std'     => '',
			'type'    => 'images',
			'class'   => 'svg_loader',
			'options' => array(
				'audio.svg'            => VAMICO_THEME_URI . '/images/svg-loaders/audio.svg',
				'rings.svg'            => VAMICO_THEME_URI . '/images/svg-loaders/rings.svg',
				'grid.svg'             => VAMICO_THEME_URI . '/images/svg-loaders/grid.svg',
				'hearts.svg'           => VAMICO_THEME_URI . '/images/svg-loaders/hearts.svg',
				'oval.svg'             => VAMICO_THEME_URI . '/images/svg-loaders/oval.svg',
				'three-dots.svg'       => VAMICO_THEME_URI . '/images/svg-loaders/three-dots.svg',
				'spinning-circles.svg' => VAMICO_THEME_URI . '/images/svg-loaders/spinning-circles.svg',
				'puff.svg'             => VAMICO_THEME_URI . '/images/svg-loaders/puff.svg',
				'circles.svg'          => VAMICO_THEME_URI . '/images/svg-loaders/circles.svg',
				'tail-spin.svg'        => VAMICO_THEME_URI . '/images/svg-loaders/tail-spin.svg',
				'bars.svg'             => VAMICO_THEME_URI . '/images/svg-loaders/bars.svg',
				'ball-triangle.svg'    => VAMICO_THEME_URI . '/images/svg-loaders/ball-triangle.svg',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'General Preloader Background Color', 'vamico' ),
			'desc' => esc_html__( 'Preloader Background Color set to default with theme if you choose color from here it will change Preloader Background color.', 'vamico' ),
			'id'   => 'vamico_page_preloader_bgcolor',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Subheader (Page Title) Alignment', 'vamico' ),
			'desc'    => esc_html__( 'Select Content Alignment. Choose between 1, 2 or 3 position layouts.', 'vamico' ),
			'id'      => 'vamico_subheader_align',
			'std'     => 'left',
			'type'    => 'images',
			'options' => array(
				'left'   => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'center' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'right'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Subheader (Page Title)', 'vamico' ),
			'desc'    => esc_html__( 'Page Title which appears in subheader section.', 'vamico' ),
			'id'      => 'vamico_subheader',
			'std'     => 'default',
			'class'   => 'select300',
			'options' => array(
				'default' => esc_html__( 'Default (post title)', 'vamico' ),
				'disable' => esc_html__( 'Disable Subheader', 'vamico' ),
			),
			'type'    => 'select',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Google API key', 'vamico' ),
			'desc'      => esc_html__( 'Enter the Google API Key.', 'vamico' ),
			'id'        => 'vamico_google_api_key',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Headers', 'vamico' ),
			'icon' => 'fa-header',
			'type' => 'heading',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name'    => esc_html__( 'Header Style', 'vamico' ),
			'desc'    => esc_html__( 'Select the Style you wish to choose for the Header. If not selected default header will be selected. File Path themename/headers/header-default.php', 'vamico' ),
			'id'      => 'vamico_headerstyle',
			'std'     => '',
			'class'   => 'select300',
			'options' => array(
				''             => esc_html__( 'Choose Header Style', 'vamico' ),
				'headerstyle1' => esc_html__( 'Header Style1', 'vamico' ),
				'headerstyle2' => esc_html__( 'Header Style2', 'vamico' ),
				'headerstyle3' => esc_html__( 'Header Style3', 'vamico' ),
				'fixedheader'  => esc_html__( 'Fixed Header', 'vamico' ),
			),
			'type'    => 'select',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Header Fullwidth', 'vamico' ),
			'desc'  => esc_html__( 'Check this if you wish to make header as fullwidth.', 'vamico' ),
			'id'    => 'vamico_header_fullwidth',
			'class' => '',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Header Top', 'vamico' ),
			'desc'  => esc_html__( 'Check this if you wish to make header top of the logo.', 'vamico' ),
			'id'    => 'vamico_headers3_position',
			'class' => 'iva_of_headerstyle headerstyle3',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Custom Header Height', 'vamico' ),
			'desc'      => esc_html__( 'Enter the custom header height. Enter only the units without px / % / em.', 'vamico' ),
			'id'        => 'vamico_header_s3_height',
			'class'     => '',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Header Background Properties', 'vamico' ),
			'desc'  => esc_html__( 'Select the Background Image for Header and assign its Properties according to your requirements.', 'vamico' ),
			'id'    => 'vamico_headerproperties',
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
		$vamico_options[] = array(
			'name'  => esc_html__( 'Sociable Icons', 'vamico' ),
			'desc'  => esc_html__( 'Check this if you wish to disable the Sociable Icons from Header Style4.', 'vamico' ),
			'id'    => 'vamico_disable_sociables',
			'class' => 'iva_of_headerstyle headerstyle4',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Sociable Icons Color', 'vamico' ),
			'desc'  => esc_html__( 'Check this if you wish to change the Sociable Hover Color.', 'vamico' ),
			'id'    => 'vamico_sociables_color',
			'class' => 'iva_of_headerstyle headerstyle4',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Subscribe Button Link', 'vamico' ),
			'desc'      => esc_html__( 'Enter the URL for subscribe button.', 'vamico' ),
			'id'        => 'vamico_subscribe_link',
			'class'     => 'iva_of_headerstyle headerstyle1',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '330',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Disable Subscribe Button', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable subscribe button in header default.', 'vamico' ),
			'id'   => 'vamico_subscribe_btn_disable',
			'class'=> 'iva_of_headerstyle headerstyle1',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Disable Search Icon', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable search icon in header default.', 'vamico' ),
			'id'   => 'vamico_search_icn_disable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Topbar Background Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply the Background Color to the Topbar.', 'vamico' ),
			'id'   => 'vamico_topbar_bgcolor',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Topbar Text Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Text Color to the Topbar.', 'vamico' ),
			'id'   => 'vamico_topbar_text',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Topbar Link Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Link Color in the Topbar.', 'vamico' ),
			'id'   => 'vamico_topbar_link',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Top Bar', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Top Bar.', 'vamico' ),
			'id'   => 'vamico_topbar',
			'std'  => '',
			'type' => 'checkbox',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Styling', 'vamico' ),
			'icon' => 'fa-paint-brush',
			'type' => 'heading',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'General Elements', 'vamico' ),
			'type' => 'subnav',
		);

		$vamico_options[] = array(
			'name'    => esc_html__( 'Layout Width', 'vamico' ),
			'desc'    => esc_html__( 'Please choose the width of your content and sidebar', 'vamico' ),
			'id'      => 'vamico_content_width',
			'std'     => '75',
			'type'    => 'select',
			'class'   => 'select300',
			'options' => $range_content_width,
		);

		$vamico_options[] = array(
			'name'      => esc_html__( 'Inner Container', 'vamico' ),
			'desc'      => esc_html__( 'Enter the Inner content area width. Enter only the units without px / % / em. Default is 1100', 'vamico' ),
			'id'        => 'vamico_innercontent_width',
			'std'       => '',
			'inputsize' => '300',
			'type'      => 'text',
		);

		$vamico_options[] = array(
			'name'      => esc_html__( 'Boxed Container Wrapper', 'vamico' ),
			'desc'      => esc_html__( 'Enter the boxed container wrappper area width. Enter only the units without px / % / em. Default is 1200', 'vamico' ),
			'id'        => 'vamico_boxedcontent_width',
			'std'       => '',
			'inputsize' => '300',
			'type'      => 'text',
		);

		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name'    => esc_html__( 'Layout Option', 'vamico' ),
			'desc'    => esc_html__( 'Select the layout option BOXED/STRETCHED which you wish to choose for the theme.', 'vamico' ),
			'id'      => 'vamico_layoutoption',
			'std'     => 'stretched',
			'type'    => 'images',
			'class'   => 'select300',
			'options' => array(
				'stretched' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/stretched.png',
				'boxed'     => VAMICO_FRAMEWORK_URI . 'admin/images/columns/boxed.png',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Theme Color', 'vamico' ),
			'desc' => esc_html__( 'Theme Color set to default with theme. But if you wish to choose color from here it will change all the links and backgrounds used in the theme.', 'vamico' ),
			'id'   => 'vamico_themecolor',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Body Background Properties', 'vamico' ),
			'desc' => esc_html__( 'Select the Background Image for Body and assign its Properties according to your requirements.', 'vamico' ),
			'id'   => 'vamico_bodyproperties',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Background Pattern Images', 'vamico' ),
			'desc'    => esc_html__( 'Choose Background Pattern Images for the theme and this works only if the layout is selected as Boxed in Styling Section.', 'vamico' ),
			'id'      => 'vamico_overlayimages',
			'std'     => '',
			'type'    => 'images',
			'options' => array(
				''           => VAMICO_THEME_URI . '/images/patterns/no-pat.png',
				'pat_01.png' => VAMICO_THEME_URI . '/images/patterns/pattern-1-Preview.jpg',
				'pat_02.png' => VAMICO_THEME_URI . '/images/patterns/pattern-2-Preview.jpg',
				'pat_03.png' => VAMICO_THEME_URI . '/images/patterns/pattern-3-Preview.jpg',
				'pat_04.png' => VAMICO_THEME_URI . '/images/patterns/pattern-4-Preview.jpg',
				'pat_05.png' => VAMICO_THEME_URI . '/images/patterns/pattern-5-Preview.jpg',
				'pat_06.png' => VAMICO_THEME_URI . '/images/patterns/pattern-6-Preview.jpg',
				'pat_07.png' => VAMICO_THEME_URI . '/images/patterns/pattern-7-Preview.jpg',
				'pat_08.png' => VAMICO_THEME_URI . '/images/patterns/pattern-8-Preview.jpg',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Subheader Background Properties', 'vamico' ),
			'desc' => esc_html__( 'Select the Background Image for Subheader and assign its Properties according to your requirements.', 'vamico' ),
			'id'   => 'vamico_subheaderproperties',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Subheader Title Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Color to the Subheader Text.', 'vamico' ),
			'id'   => 'vamico_subheader_textcolor',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Background', 'vamico' ),
			'desc' => esc_html__( 'Footer Background Properties includes the sidebar footer widgets area as well. If you wish to disable footer area you can go to Footer Tab and do that..', 'vamico' ),
			'id'   => 'vamico_footer_area_middle',
			'std'  => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => '',
				'position'   => '',
				'attachment' => '',
			),
			'type' => 'background',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Top Area Background', 'vamico' ),
			'desc' => esc_html__( 'This will apply color to the footer top area of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_top',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Bottom Area Background', 'vamico' ),
			'desc' => esc_html__( 'This will apply color to the footer top area of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Content Area Background Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply color to the primary content area of theme. This will work if you are not using Visual Composer background colors and stretched optin.', 'vamico' ),
			'id'   => 'vamico_content_area_bg',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu', 'vamico' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Background', 'vamico' ),
			'desc' => esc_html__( 'This applies the Background Color for Header Style2, Header Style3 and Header Style4 .', 'vamico' ),
			'id'   => 'vamico_mmenu_bg',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Font and Link Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Menu Parent Lists.', 'vamico' ),
			'id'   => 'vamico_mmenu_font',
			'type' => 'typography',
			'std'  => array(
				'size'        => '',
				'style'       => '',
				'color'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Hover BG', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Menu Hover BG.', 'vamico' ),
			'id'   => 'vamico_mmenu_hoverbg',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Hover Text', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Menu Hover Text.', 'vamico' ),
			'id'   => 'vamico_mmenu_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Background Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Background Color.', 'vamico' ),
			'id'   => 'vamico_mmenu_dd_bg',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Text Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Text Color.', 'vamico' ),
			'id'   => 'vamico_mmenu_dd_link',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Text Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Text Hover Color.', 'vamico' ),
			'id'   => 'vamico_mmenu_dd_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Dropdown Hover Background Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Dropdown Menu Hover Background Color.', 'vamico' ),
			'id'   => 'vamico_mmenu_dd_hoverbg',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Menu Active Link Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Active Link Color.', 'vamico' ),
			'id'   => 'vamico_mmenu_active_link',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Link Colors', 'vamico' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Conent Area Link Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Theme Links.', 'vamico' ),
			'id'   => 'vamico_link',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Conent Area Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Select the Color for Theme Links Hover.', 'vamico' ),
			'id'   => 'vamico_linkhover',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Subheader Link Color', 'vamico' ),
			'desc' => esc_html__( 'Links under subheader section.', 'vamico' ),
			'id'   => 'vamico_subheaderlink',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Subheader Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Links Hover under subheader section.', 'vamico' ),
			'id'   => 'vamico_subheaderlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Link Color', 'vamico' ),
			'desc' => esc_html__( 'Footer containing links under widget or text widget, (link color).', 'vamico' ),
			'id'   => 'vamico_footerlink',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Footer content containing any links under widget or text widget, (link hover color).', 'vamico' ),
			'id'   => 'vamico_footerlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Copyright Link Color', 'vamico' ),
			'desc' => esc_html__( 'Copyright content containing any links color. (link color).', 'vamico' ),
			'id'   => 'vamico_copyrightlink',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Copyright Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Copyright content containing any links color. (link color).', 'vamico' ),
			'id'   => 'vamico_copyrightlinkhover',
			'std'  => '',
			'type' => 'color',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Typography', 'vamico' ),
			'type' => 'subnav',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Google Font', 'vamico' ),
			'desc' => wp_kses( __( '<br>Select the fonts you wish to use for the website fonts or google webfonts. If you select the headings font it will replace all the heading font family for the whole theme including footer and sidebar widget titles.', 'vamico' ), $options_array_allowed_html ),
			'type' => 'subsection',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name'    => esc_html__( 'Body Font Family', 'vamico' ),
			'desc'    => esc_html__( 'Select a Font Family for Body Content.', 'vamico' ),
			'id'      => 'vamico_bodyfont',
			'class'   => '',
			'options' => $vamico_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'vamico' ),
				'size' => '15px',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Headings Font Family', 'vamico' ),
			'desc'    => esc_html__( 'Select a Font Family for Headings ( h1, h2, h3, h4, h5, h6 ).', 'vamico' ),
			'id'      => 'vamico_headingfont',
			'class'   => '',
			'options' => $vamico_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'This is how your heading looks like!', 'vamico' ),
				'size' => '36px',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Menu Font Family', 'vamico' ),
			'desc'    => esc_html__( 'Select a Font Family for Top Navigation Menu.', 'vamico' ),
			'id'      => 'vamico_mainmenufont',
			'class'   => '',
			'options' => $vamico_fontface,
			'type'    => 'custom_google_fonts',
			'preview' => array(
				'text' => esc_html__( 'This is how your menu font looks like', 'vamico' ),
				'size' => '26px',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'CountDown Font Family', 'vamico' ),
			'desc'    => esc_html__( 'Select a Font for the CountDown Shortcode.', 'vamico' ),
			'id'      => 'vamico_countdown_font',
			'class'   => '',
			'type'    => 'custom_google_fonts',
			'options' => $vamico_fontface,
			'preview' => array(
				'text' => esc_html__( '0123456789 - DAYS - MONTHS - MIN - SECS', 'vamico' ),
				'size' => '36px',
			),
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Various Font Properties', 'vamico' ),
			'desc' => wp_kses( __( '<br>Select the front properties like font size, line-height, font-style and font-weight for various elements used in the theme.', 'vamico' ), $options_array_allowed_html ),
			'type' => 'subsection',
		);
		//---------------------------------------------------------------------------------------------------
		$vamico_options[] = array(
			'name' => esc_html__( 'Body', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Body Font.', 'vamico' ),
			'id'   => 'vamico_bodyp',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H1', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H1 Heading.', 'vamico' ),
			'id'   => 'vamico_h1',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H2', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H2 Heading.', 'vamico' ),
			'id'   => 'vamico_h2',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H3', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H3 Heading.', 'vamico' ),
			'id'   => 'vamico_h3',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H4', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H4 Heading.', 'vamico' ),
			'id'   => 'vamico_h4',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H5', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H5 Heading.', 'vamico' ),
			'id'   => 'vamico_h5',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'H6', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for H6 Heading.', 'vamico' ),
			'id'   => 'vamico_h6',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Sidebar Widget Titles', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Sidebar Widget Titles.', 'vamico' ),
			'id'   => 'vamico_sidebar_widget_title',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Widget Titles', 'vamico' ),
			'desc' => esc_html__( 'Select the Color and Font Properties for Footer Widget Titles.', 'vamico' ),
			'id'   => 'vamico_footer_widget_title',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Text', 'vamico' ),
			'desc' => esc_html__( 'Select the Color &amp; Font Properties for Footer Section.', 'vamico' ),
			'id'   => 'vamico_footer_widget_text',
			'type' => 'typography',
			'std'  => array(
				'color'       => '',
				'size'        => '',
				'style'       => '',
				'lineheight'  => '',
				'fontvariant' => '',
			),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Copyright Text', 'vamico' ),
			'desc' => esc_html__( 'Select the Color &amp; Font Properties for Copyright Section.', 'vamico' ),
			'id'   => 'vamico_copyright_text',
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
		$vamico_options[] = array(
			'name' => esc_html__( 'Sliders', 'vamico' ),
			'icon' => 'fa-sliders',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Frontpage Slider', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Slider.', 'vamico' ),
			'id'   => 'vamico_slidervisble',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Select Slider Type', 'vamico' ),
			'desc'    => esc_html__( 'Select which Slider you want to use for the Frontpage of the theme.', 'vamico' ),
			'id'      => 'vamico_slider',
			'std'     => 'owl_slider',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => $vamico_theme_ob->vamico_get_vars( 'slider_type' ),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Slider Image Size', 'vamico' ),
			'desc'    => esc_html__( 'Below are the size names that are images cropped For the sizes added in theme check documentation.', 'vamico' ),
			'id'      => 'vamico_slider_img_size',
			'std'     => 'vamico-extra-large',
			'class'   => 'select300 iva_of_sliders owl_slider',
			'type'    => 'select',
			'options' => array(
				'vamico-extra-large'      => esc_html__( 'Default', 'vamico' ),
				'vamico-large-horizontal' => esc_html__( 'Large Horizontal', 'vamico' ),
				'vamico-large-vertical'   => esc_html__( 'Large Vertical', 'vamico' ),
				'vamico-large-square'     => esc_html__( 'Large Square', 'vamico' ),
				'vamico-medium-horizontal'     => esc_html__( 'Medium Horizontal', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Slider Post(s) From', 'vamico' ),
			'id'      => 'vamico_slider_post_from',
			'std'     => 'cat_names',
			'class'   => 'select300 iva_of_sliders owl_slider',
			'type'    => 'select',
			'options' => array(
				'cat_names' => esc_html__( 'Category', 'vamico' ),
				'post_ids'  => esc_html__( 'Post ID(s)', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Category Names', 'vamico' ),
			'desc'    => esc_html__( 'Select Post Categories to hold the slides from.', 'vamico' ),
			'id'      => 'vamico_slider_cat',
			'class'   => 'slider_post_from cat_names iva_of_sliders owl_slider',
			'std'     => 'postslider',
			'type'    => 'multiselect',
			'options' => $vamico_theme_ob->vamico_get_vars( 'posts' ),
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Post ID(s)', 'vamico' ),
			'desc'      => esc_html__( 'Comma separated list of post ID(s) you wish to display.', 'vamico' ),
			'id'        => 'vamico_slider_post_ids',
			'class'     => 'slider_post_from post_ids iva_of_sliders owl_slider',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Owl Slider Type', 'vamico' ),
			'desc'    => esc_html__( 'Select Slider Type.', 'vamico' ),
			'id'      => 'vamico_owl_slider_type',
			'class'   => 'iva_of_sliders owl_slider select300',
			'std'     => 'center',
			'type'    => 'select',
			'options' => array(
				'center'   => esc_html__( 'Center', 'vamico' ),
				'large'    => esc_html__( 'Large', 'vamico' ),
				'boxed'    => esc_html__( 'Boxed', 'vamico' ),
				'multiple' => esc_html__( 'Mulitple', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Number of Visible Slides', 'vamico' ),
			'desc'    => esc_html__( 'Select Number of Visible Slides.', 'vamico' ),
			'id'      => 'vamico_owl_slides_number',
			'class'   => 'select300 iva_of_sliders owl_slider_type owl_slider multiple',
			'std'     => '3',
			'type'    => 'select',
			'options' => vamico_range( 1, 4 ),
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Carousel Limits', 'vamico' ),
			'desc'      => esc_html__( 'Enter the limit for Slides you want to hold on the Slider', 'vamico' ),
			'id'        => 'vamico_owlslider_limit',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider center boxed multiple large',
			'type'      => 'text',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Slider Width', 'vamico' ),
			'desc'      => esc_html__( 'Enter the custom width of the slider, recommended width: 1200px for a wide slider and 1100px for center slider.', 'vamico' ),
			'id'        => 'vamico_owlslider_width',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider center boxed',
			'type'      => 'text',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Slider Height', 'vamico' ),
			'desc'      => esc_html__( 'Enter the custom height of the slider, recommended height: 600px.', 'vamico' ),
			'id'        => 'vamico_owlslider_height',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider multiple center boxed',
			'type'      => 'text',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Caption Overlay', 'vamico' ),
			'desc'      => esc_html__( 'Check this if  you wish to display caption below the image.', 'vamico' ),
			'id'        => 'vamico_owlslider_capoverlay',
			'std'       => '',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider multiple center boxed',
			'type'      => 'checkbox',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Autoplay', 'vamico' ),
			'desc'    => esc_html__( 'Selec the Autoplay option to play the carousel automatically', 'vamico' ),
			'id'      => 'vamico_owlslide_autoplay',
			'class'   => 'select300 iva_of_sliders owl_slider_type owl_slider center boxed multiple large',
			'std'     => 'true',
			'type'    => 'select',
			'options' => array(
				'true'  => esc_html__( 'True', 'vamico' ),
				'false' => esc_html__( 'False', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Autoplay Interval', 'vamico' ),
			'desc'    => esc_html__( 'Autoplay interval timeout for the slides. where 1000 = 1 sec', 'vamico' ),
			'id'      => 'vamico_owlslide_timeout',
			'std'     => '5000',
			'class'   => 'iva_of_sliders owl_slider_type owl_slider center boxed multiple large select300',
			'type'    => 'select',
			'options' => vamico_range( 1000, 10000, 1000 ),
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Item spacings', 'vamico' ),
			'desc'      => esc_html__( 'enter the margins between the slider images. Enter using pixels', 'vamico' ),
			'id'        => 'vamico_owlslide_margin',
			'std'       => '0',
			'class'     => 'iva_of_sliders owl_slider_type owl_slider center multiple',
			'type'      => 'text',
			'inputsize' => '',
		);

		$vamico_options[] = array(
			'name'    => esc_html__( 'Caption Default Position', 'vamico' ),
			'desc'    => esc_html__( 'Select the caption position for the page, Left, Right or Center.', 'vamico' ),
			'id'      => 'vamico_slider_caption_pos',
			'class'   => 'iva_of_sliders owl_slider_type owl_slider center multiple boxed large',
			'std'     => 'is-center',
			'type'    => 'images',
			'options' => array(
				'is-left' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'    => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		);

		$vamico_options[] = array(
			'name'  => esc_html__( 'Static Image', 'vamico' ),
			'desc'  => esc_html__( 'Upload the image size 1920 x 750 pixels to display on the homepage instead of slider.', 'vamico' ),
			'id'    => 'vamico_static_image_upload',
			'std'   => '',
			'class' => 'iva_of_sliders static_image',
			'type'  => 'upload',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Custom Slider', 'vamico' ),
			'desc'      => esc_html__( 'Use in your Custom Slider Plugin Shortcodes. Example : [revslider id="1"]', 'vamico' ),
			'id'        => 'vamico_customslider',
			'std'       => '',
			'class'     => 'iva_of_sliders customslider',
			'type'      => 'textarea',
			'inputsize' => '',
		);
		/*---------------------------------------------------- */
		/* Post Options                                        */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Post Options', 'vamico' ),
			'icon' => 'fa-newspaper-o',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Post Featured Image Location', 'vamico' ),
			'desc'    => esc_html__( 'Select the featured image position inside the post or outside', 'vamico' ),
			'id'      => 'vamico_featured_img_pos',
			'std'     => 'inside_post',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'inside_post'  => esc_html__( 'Inside Post', 'vamico' ),
				'outside_post' => esc_html__( 'Outside Post', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Post Featured Image Types', 'vamico' ),
			'desc'    => esc_html__( 'Select the post featured image style you wish to display', 'vamico' ),
			'id'      => 'vamico_featured_img_type',
			'std'     => 'default',
			'class'   => 'select300 inside_post vamico_featured_img_type',
			'type'    => 'select',
			'options' => array(
				'default'   => esc_html__( 'Default', 'vamico' ),
				'standard'  => esc_html__( 'Standard', 'vamico' ),
				'fullwidth' => esc_html__( 'Full Width', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Slider Background Color', 'vamico' ),
			'desc'  => esc_html__( 'This will apply Color to the slider Area.', 'vamico' ),
			'id'    => 'vamico_slider_bg_color',
			'class' => 'vamico_slider_bg_color wide',
			'std'   => '',
			'type'  => 'color',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Blog Styles', 'vamico' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the posts layout', 'vamico' ),
			'id'      => 'vamico_blog_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'post_standard_style'      => esc_html__( 'Full Post Layout', 'vamico' ),
				'post_grid_style'          => esc_html__( 'Grid Post Layout', 'vamico' ),
				'post_list_style'          => esc_html__( 'List Post Layout', 'vamico' ),
				'post_standard_grid_style' => esc_html__( '1 Full Post then Grid Layout', 'vamico' ),
				'post_standard_list_style' => esc_html__( '1 Full Post then List Layout', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Archive Styles', 'vamico' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the archive page', 'vamico' ),
			'id'      => 'vamico_archive_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'archive_standard_style' => esc_html__( 'Full Post Layout', 'vamico' ),
				'archive_grid_style'     => esc_html__( 'Grid Post Layout', 'vamico' ),
				'archive_list_style'     => esc_html__( 'List Post Layout', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Author Styles', 'vamico' ),
			'desc'    => esc_html__( 'Select the style you wish to display for the author archive page', 'vamico' ),
			'id'      => 'vamico_author_style',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				''        => esc_html__( 'Default', 'vamico' ),
				'center'  => esc_html__( 'Centered', 'vamico' ),
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Blog Page Categories', 'vamico' ),
			'desc'    => esc_html__( 'Selected Categories will hold the posts to display in Blog Page Template. ( template : template_blog.php)', 'vamico' ),
			'id'      => 'vamico_blog_cats',
			'std'     => '',
			'type'    => 'multicheck',
			'options' => $vamico_theme_ob->vamico_get_vars( 'categories' ),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Featured Image from top of Post', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the featured image from top of the post.', 'vamico' ),
			'id'   => 'vamico_hide_featured_img',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Categories', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable categories from the post.', 'vamico' ),
			'id'   => 'vamico_hide_categories',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Date', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable date from the post.', 'vamico' ),
			'id'   => 'vamico_hide_date',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Author Name', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable author name from the post.', 'vamico' ),
			'id'   => 'vamico_hide_author_name',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Share Button', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable share button from the post.', 'vamico' ),
			'id'   => 'vamico_hide_share_btns',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Likes', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable likes from the post.', 'vamico' ),
			'id'   => 'vamico_hide_likes',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Views', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable views from the post.', 'vamico' ),
			'id'   => 'vamico_hide_views',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Readtime', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable read time from the post.', 'vamico' ),
			'id'   => 'vamico_hide_read_time',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Tags', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable date from the post.', 'vamico' ),
			'id'   => 'vamico_hide_tags',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Hide Comment link', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable Comment links from the post.', 'vamico' ),
			'id'   => 'vamico_hide_comment_link',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'About Author', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Author Info in Post Single Page.', 'vamico' ),
			'id'   => 'vamico_about_author',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Related Posts', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Related Posts in Post Single Page (based on tags).', 'vamico' ),
			'id'   => 'vamico_relatedposts',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name'      => esc_html__( 'Related Posts limit', 'vamico' ),
			'desc'      => esc_html__( 'Enter the no.of posts to display.', 'vamico' ),
			'id'        => 'vamico_related_limit',
			'std'       => '',
			'type'      => 'text',
			'inputsize' => '',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Slides Speed', 'vamico' ),
			'desc'    => esc_html__( 'Select the slide speed you want to set where 1000 = 1 sec', 'vamico' ),
			'id'      => 'vamico_related_owl_speed',
			'std'     => '3000',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => vamico_range( 1000, 10000, 1000 ),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Carousel Slides Per View', 'vamico' ),
			'desc'    => esc_html__( 'Enter number of slides to display at the same time in related posts carousel slider', 'vamico' ),
			'id'      => 'vamico_related_owl_itemslimit',
			'std'     => '',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => vamico_range( 2, 6 ),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Slides Speed', 'vamico' ),
			'desc'    => esc_html__( 'Select the slide speed you want to set in post gallery format where 1000 = 1 sec', 'vamico' ),
			'id'      => 'vamico_post_gallery_owl_speed',
			'std'     => '3000',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => vamico_range( 1000, 10000, 1000 ),
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Post Pagination', 'vamico' ),
			'desc' => wp_kses( __( 'Check this if you wish to disable <strong>Next/Previous</strong> Post Pagination.', 'vamico' ), $options_array_allowed_html ),
			'id'   => 'vamico_singlenavigation',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Blog Post Meta', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable Meta Data in Blog Posts and Single Page.', 'vamico' ),
			'id'   => 'vamico_postmeta',
			'std'  => '',
			'type' => 'checkbox',
		);

		$vamico_options[] = array(
			'name' => esc_html__( 'Posts Boxed Style', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to use the boxed style for the posts.', 'vamico' ),
			'id'   => 'vamico_post_boxed',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Posts Bordered Style', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to use the border style for the posts. Make sure the Posts Boxed Style is selected above.', 'vamico' ),
			'id'   => 'vamico_post_radius',
			'std'  => '',
			'type' => 'checkbox',
		);

		/*---------------------------------------------------- */
		/* Sidebar Options                                     */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Sidebars', 'vamico' ),
			'icon' => 'fa-columns',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Custom Sidebars', 'vamico' ),
			'desc' => esc_html__( 'Create the custom sidebars and go to <strong>Appearance > Widgets</strong> to see the newly sidebar you have created. After assigning the widgets in the prefered sidebar you can assign specific sidebar to specific pages/posts in Options below the WordPress content editor of each page/post.', 'vamico' ),
			'id'   => 'vamico_customsidebar',
			'std'  => '',
			'type' => 'customsidebar',
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Sidebars Layout', 'vamico' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the page, Left Sidebar, Right Sidebar or Full Width.', 'vamico' ),
			'id'      => 'vamico_defaultlayout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => VAMICO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Archive page Layout', 'vamico' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the archive page, Left Sidebar, Right Sidebar or Full Width.', 'vamico' ),
			'id'      => 'vamico_archive_layout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => VAMICO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		$vamico_options[] = array(
			'name'    => esc_html__( 'Author page Layout', 'vamico' ),
			'desc'    => esc_html__( 'Select the Layout Style you wish to use for the author page, Left Sidebar, Right Sidebar or Full Width.', 'vamico' ),
			'id'      => 'vamico_author_layout',
			'std'     => 'rightsidebar',
			'type'    => 'images',
			'options' => array(
				'rightsidebar' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => VAMICO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		);
		/*---------------------------------------------------- */
		/* Footer Options                                      */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer', 'vamico' ),
			'icon' => 'fa-columns',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Ads Before Footer', 'vamico' ),
			'desc' => esc_html__( 'The content displays before footer widgets', 'vamico' ),
			'id'   => 'vamico_ads_content',
			'std'  => '',
			'type' => 'textarea',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Sidebar', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Sidebar.', 'vamico' ),
			'id'   => 'vamico_footer_sidebar',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Widget Layout', 'vamico' ),
			'desc' => esc_html__( 'Select the Footer Columns for Widgets. If you choose 4 columns drag only 4 Widgets in Footer Widgets Section', 'vamico' ),
			'id'   => 'vamico_footer_widget_layout',
			'std'  => '',
			'type' => 'add_uislider',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Top Enable / Disable', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Area Top.', 'vamico' ),
			'id'   => 'vamico_footer_area_top',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Top Background Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Top of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_top_bg_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Top Text Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Top of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_top_text_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Top Link Color', 'vamico' ),
			'desc' => esc_html__( 'Footer Area Top content containing any links color. (link color)..', 'vamico' ),
			'id'   => 'vamico_footer_area_top_link_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Top Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Footer Area Top content containing any links hover color. (link color)..', 'vamico' ),
			'id'   => 'vamico_footer_area_top_link_hover_color',
			'std'  => '',
			'type' => 'color',
		);
		// Footer Area Bottom
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Enable / Disable', 'vamico' ),
			'desc' => esc_html__( 'Check this if you wish to disable the Footer Area Bottom.', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Background Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Bottom of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom_bg_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Text Color', 'vamico' ),
			'desc' => esc_html__( 'This will apply Color to the Footer Area Bottom of theme.', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom_text_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Link Color', 'vamico' ),
			'desc' => esc_html__( 'Footer Area Bottom content containing any links color. (link color)..', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom_link_color',
			'std'  => '',
			'type' => 'color',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Footer Area Bottom Link Hover Color', 'vamico' ),
			'desc' => esc_html__( 'Footer Area Bottom content containing any links hover color. (link color)..', 'vamico' ),
			'id'   => 'vamico_footer_area_bottom_link_hover_color',
			'std'  => '',
			'type' => 'color',
		);
		/*---------------------------------------------------- */
		/* Sociables                                           */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Sociables', 'vamico' ),
			'icon' => 'fa-share-alt',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Sociables', 'vamico' ),
			'desc' => esc_html__( 'Click Add New to add Sociables where you can add / delete. If you wish to use in widgets then use the shortcode as [sociable color="black/white"].', 'vamico' ),
			'id'   => 'vamico_social_bookmark',
			'std'  => '',
			'type' => 'custom_socialbook_mark',
		);
		/*---------------------------------------------------- */
		/* Share links Options                                 */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Sharelinks', 'vamico' ),
			'icon' => 'fa-share',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Google+', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Google+ Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_google_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Facebook', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Facebook Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_facebook_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'LinkedIn', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable LinkedIn Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_linkedIn_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Digg', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Digg Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_digg_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'StumbleUpon', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable StumbleUpon Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_stumbleupon_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Pinterest', 'vamico' ),
			'desc'  => esc_html__( 'Check this to enable Pinterest Icon for Post Sharing.', 'vamico' ),
			'id'    => 'vamico_pinterest_enable',
			'class' => 'pinterest_sharing',
			'std'   => '',
			'type'  => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Twitter', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Twitter Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_twitter_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Tumblr', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Tumblr Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_tumblr_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Email', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Email Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_email_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Reddit', 'vamico' ),
			'desc' => esc_html__( 'Check this to enable Reddit Icon for Post Sharing.', 'vamico' ),
			'id'   => 'vamico_reddit_enable',
			'std'  => '',
			'type' => 'checkbox',
		);
		/*---------------------------------------------------- */
		/* Import and Export                                   */
		/*---------------------------------------------------- */
		$vamico_options[] = array(
			'name' => esc_html__( 'Options Backup', 'vamico' ),
			'icon' => 'fa-floppy-o',
			'type' => 'heading',
		);
		$vamico_options[] = array(
			'name' => esc_html__( 'Options Backup', 'vamico' ),
			'desc' => esc_html__( 'Import,Export Backup options.', 'vamico' ),
			'type' => 'subsection',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Export Backup Options', 'vamico' ),
			'desc'  => esc_html__( 'This will Export Backup Options.', 'vamico' ),
			'id'    => 'vamico_export_backup_options',
			'std'   => '',
			'class' => 'atp-backup-options',
			'type'  => 'export_backupoptions',
		);
		$vamico_options[] = array(
			'name'  => esc_html__( 'Import Backup Options', 'vamico' ),
			'desc'  => esc_html__( 'This will Import Backup Options you saved. Location theme/framework/admin/options-importer/export_options/.', 'vamico' ),
			'id'    => 'vamico_import_backup_options',
			'std'   => '',
			'class' => 'atp-backup-options',
			'type'  => 'import_backupoptions',
		);
		// Additional Theme Options from Niche Theme Folder
		$vamico_options = apply_filters( 'custompost_themeoptions', $vamico_options );
		// Custom Additional Localization Options
		$vamico_options = apply_filters( 'customlocalization_themeoptions', $vamico_options );

		return $vamico_options;
	}
} // End if().

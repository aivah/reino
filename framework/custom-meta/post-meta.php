<?php
//
//--------------------------------------------------------
$reino_sidebar_widget = get_option( 'reino_customsidebar' );
$reino_sidebar_layout = get_option( 'reino_defaultlayout' ) ? get_option( 'reino_defaultlayout' ) : 'rightsidebar';
$this->meta_box[]     = array(
	'id'       => 'post-formats-meta-box',
	'title'    => esc_html__( 'Post Format Options', 'reino' ),
	'page'     => array( 'post' ),
	'context'  => 'normal',
	'priority' => 'core',
	'fields'   => array(
		//  Link Format
		array(
			'name'  => esc_html__( 'The URL', 'reino' ),
			'desc'  => esc_html__( 'Insert the URL you wish to link to. Including http://', 'reino' ),
			'class' => 'postformat-mb-link',
			'id'    => 'reino_link_url',
			'std'   => '',
			'type'  => 'text',
		),
		// Quote Format
		array(
			'name'  => esc_html__( 'The Quote', 'reino' ),
			'desc'  => esc_html__( 'Write your text for your quote here.', 'reino' ),
			'id'    => 'reino_quote_text',
			'class' => 'postformat-mb-quote',
			'std'   => '',
			'type'  => 'textarea',
		),
		// Audio Format
		array(
			'name'  => esc_html__( 'MP3 File URL', 'reino' ),
			'desc'  => esc_html__( 'The URL to the .mp3 file.', 'reino' ),
			'id'    => 'reino_audio_mp3',
			'class' => 'postformat-mb-audio',
			'std'   => '',
			'type'  => 'text',
		),
		array(
			'name'  => esc_html__( 'OGA File URL', 'reino' ),
			'desc'  => esc_html__( 'The URL to the .oga or .ogg audio file.', 'reino' ),
			'id'    => 'reino_audio_ogg',
			'class' => 'postformat-mb-audio',
			'std'   => '',
			'type'  => 'text',
		),
		array(
			'name'  => esc_html__( 'Embeded Code', 'reino' ),
			'desc'  => esc_html__( 'If you\'re not using any of the audio formats above or self hosted videos then you can add embeded code here.', 'reino' ),
			'id'    => 'reino_audio_embed',
			'class' => 'postformat-mb-audio',
			'std'   => '',
			'type'  => 'textarea',
		),
		// Video Format
		array(
			'name'  => esc_html__( 'M4V File URL', 'reino' ),
			'desc'  => esc_html__( 'The URL to the .m4v video file', 'reino' ),
			'id'    => 'reino_video_m4v',
			'class' => 'postformat-mb-video',
			'std'   => '',
			'type'  => 'text',
		),
		array(
			'name'  => esc_html__( 'OGV File URL', 'reino' ),
			'desc'  => esc_html__( 'The URL to the .ogv video file', 'reino' ),
			'id'    => 'reino_video_ogv',
			'class' => 'postformat-mb-video',
			'std'   => '',
			'type'  => 'text',
		),
		array(
			'name'  => esc_html__( 'Poster Image', 'reino' ),
			'desc'  => esc_html__( 'The preivew image before the video plays.', 'reino' ),
			'id'    => 'reino_video_poster',
			'class' => 'postformat-mb-video',
			'std'   => '',
			'type'  => 'text',
		),
		array(
			'name'  => esc_html__( 'Embeded Code', 'reino' ),
			'desc'  => esc_html__( 'If you\'re not using any of the video formats above or self hosted videos then you can add embeded code here.', 'reino' ),
			'id'    => 'reino_video_embed',
			'class' => 'postformat-mb-video',
			'std'   => '',
			'type'  => 'textarea',
		),
		array(
			'name'  => esc_html__( 'Add Gallery', 'reino' ),
			'desc'  => esc_html__( 'Create gallery images', 'reino' ),
			'id'    => 'reino_post_gallery',
			'class' => 'postformat-mb-gallery',
			'std'   => '',
			'type'  => 'post_gallery_meta',
		),
		array(
			'name'    => esc_html__( 'Gallery Layout', 'reino' ),
			'desc'    => esc_html__( 'Select gallery layout style', 'reino' ),
			'id'      => 'reino_post_gallery_layout',
			'class'   => 'postformat-mb-gallery select300',
			'std'     => '',
			'type'    => 'select',
			'options' => array(
				''          => esc_html__( 'None', 'reino' ),
				'slider'    => esc_html__( 'Slider', 'reino' ),
				'justified' => esc_html__( 'Justified', 'reino' ),
			),
		),
	),
);
$this->meta_box[] = array(
	'id'       => 'post-meta-box',
	'title'    => esc_html__( 'Post Options', 'reino' ),
	'page'     => array( 'post' ),
	'context'  => 'normal',
	'priority' => 'core',
	'fields'   => array(
		/**
		* Featured Image Location
		*/
		array(
			'name'    => esc_html__( 'Post Featured Image Position', 'reino' ),
			'desc'    => esc_html__( 'Select the featured image position inside the post or outside', 'reino' ),
			'id'      => 'reino_featured_img_pos',
			'std'     => 'inside_contnet',
			'class'   => 'select300',
			'type'    => 'select',
			'options' => array(
				'inside_post'  => esc_html__( 'Inside Post', 'reino' ),
				'outside_post' => esc_html__( 'Outside Post', 'reino' ),
			),
		),
		/**
		* Featured Image type
		*/
		array(
			'name'    => esc_html__( 'Post Featured Image Style', 'reino' ),
			'desc'    => esc_html__( 'Select the style you wish to display in page-header area or inside the content.', 'reino' ),
			'id'      => 'reino_featured_img_type',
			'std'     => '',
			'class'   => 'select300 inside_post reino_featured_img_type',
			'type'    => 'select',
			'options' => array(
				'default'   => esc_html__( 'Default', 'reino' ),
				'standard'  => esc_html__( 'Standard', 'reino' ),
				'fullwidth' => esc_html__( 'Full Width', 'reino' ),
			),
		),

		/**
		 * Featured content alignment
		 */
		array(
			'name'    => esc_html__( 'Featured Content Alignment', 'reino' ),
			'desc'    => esc_html__( 'Select featured content alignment. Choose between 1, 2 or 3 position layout.', 'reino' ),
			'id'      => 'reino_featured_styling',
			'std'     => 'is-left',
			'class'   => '',
			'type'    => 'layout',
			'options' => array(
				'is-left'   => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center' => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'  => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		),
		/**
		 * sidebar position
		 */
		array(
			'name'    => esc_html__( 'Sidebar Position', 'reino' ),
			'desc'    => esc_html__( 'Select the sidebar position you wish to use for this page, Left Sidebar or Right Sidebar or Full Width.', 'reino' ),
			'id'      => 'reino_sidebar_options',
			'std'     => $reino_sidebar_layout,
			'type'    => 'layout',
			'options' => array(
				'rightsidebar' => REINO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
				'leftsidebar'  => REINO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
				'fullwidth'    => REINO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
			),
		),
		/**
		 * custom sidebar
		 */
		array(
			'name'    => esc_html__( 'Custom Sidebar', 'reino' ),
			'desc'    => esc_html__( 'Select the Sidebar you wish to assign for this page.', 'reino' ),
			'id'      => 'reino_custom_widget',
			'type'    => 'customselect',
			'class'   => 'select300',
			'std'     => '',
			'options' => $reino_sidebar_widget,
		),
		/**
		 * Layout Mode
		 */
		array(
			'name' => esc_html__( 'Layout Mode', 'reino' ),
			'desc' => esc_html__( 'Check this if you wish to use Boxed mode layout for this page.', 'reino' ),
			'id'   => 'reino_page_layout',
			'std'  => 'off',
			'type' => 'checkbox',
		),
		/**
		 * page background
		 */
		array(
			'name'    => esc_html__( 'Page Background', 'reino' ),
			'desc'    => esc_html__( 'Upload the image for the page background. This will apply only if the layout is selected as boxed in options panel', 'reino' ),
			'id'      => 'reino_page_bg_prop',
			'class'   => 'reino_page_bg',
			'std'     => '',
			'type'    => 'background',
			'options' => array(
				'image'      => '',
				'color'      => '',
				'repeat'     => 'repeat',
				'position'   => 'center top',
				'attachment' => 'scroll',
			),
		),
	),
);

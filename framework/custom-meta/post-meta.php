<?php
//
//--------------------------------------------------------
$vamico_sidebar_widget  = get_option( 'vamico_customsidebar' );
$vamico_sidebar_layout  = get_option( 'vamico_defaultlayout' ) ? get_option( 'vamico_defaultlayout' ) : 'rightsidebar';
$this->meta_box[] = array(
	'id'		=> 'post-formats-meta-box',
	'title'		=> esc_html__( 'Post Format Options','vamico' ),
	'page'		=> array( 'post' ),
	'context'	=> 'normal',
	'priority'	=> 'core',
	'fields'	=> array(
		//  Link Format
		array(
			'name' 	=> esc_html__( 'The URL','vamico' ),
			'desc' 	=> esc_html__( 'Insert the URL you wish to link to. Including http://','vamico' ),
			'class' => 'postformat-mb-link',
			'id' 	=> 'vamico_link_url',
			'std' 	=> '',
			'type' 	=> 'text',
		),
		// Quote Format
		array(
			'name' 	=> esc_html__( 'The Quote', 'vamico' ),
			'desc' 	=> esc_html__( 'Write your text for your quote here.', 'vamico' ),
			'id' 	=> 'vamico_quote_text',
			'class'	=> 'postformat-mb-quote',
			'std' 	=> '',
			'type' 	=> 'textarea',
		),
		// Audio Format
		array(
			'name' 	=> esc_html__( 'MP3 File URL', 'vamico' ),
			'desc'	=> esc_html__( 'The URL to the .mp3 file.', 'vamico' ),
			'id' 	=> 'vamico_audio_mp3',
			'class'	=> 'postformat-mb-audio',
			'std' 	=> '',
			'type'  => 'text',
		),
		array(
			'name'	=> esc_html__( 'OGA File URL','vamico' ),
			'desc'	=> esc_html__( 'The URL to the .oga or .ogg audio file.','vamico' ),
			'id'	=> 'vamico_audio_ogg',
			'class'	=> 'postformat-mb-audio',
			'std'	=> '',
			'type'	=> 'text',
		),
		array(
			'name' 	=> esc_html__( 'Embeded Code', 'vamico' ),
			'desc' 	=> esc_html__( 'If you\'re not using any of the audio formats above or self hosted videos then you can add embeded code here.', 'vamico' ),
			'id' 	=> 'vamico_audio_embed',
			'class'	=> 'postformat-mb-audio',
			'std' 	=> '',
			'type' 	=> 'textarea',
		),
		// Video Format
		array(
			'name' 	=> esc_html__( 'M4V File URL', 'vamico' ),
			'desc' 	=> esc_html__( 'The URL to the .m4v video file', 'vamico' ),
			'id' 	=> 'vamico_video_m4v',
			'class'	=> 'postformat-mb-video',
			'std' 	=> '',
			'type' 	=> 'text',
		),
		array(
			'name' 	=> esc_html__( 'OGV File URL', 'vamico' ),
			'desc' 	=> esc_html__( 'The URL to the .ogv video file', 'vamico' ),
			'id' 	=> 'vamico_video_ogv',
			'class'	=> 'postformat-mb-video',
			'std' 	=> '',
			'type' 	=> 'text',
		),
		array(
			'name' 	=> esc_html__( 'Poster Image', 'vamico' ),
			'desc' 	=> esc_html__( 'The preivew image before the video plays.', 'vamico' ),
			'id' 	=> 'vamico_video_poster',
			'class'	=> 'postformat-mb-video',
			'std' 	=> '',
			'type' 	=> 'text',
		),
		array(
			'name' 	=> esc_html__( 'Embeded Code', 'vamico' ),
			'desc' 	=> esc_html__( 'If you\'re not using any of the video formats above or self hosted videos then you can add embeded code here.', 'vamico' ),
			'id' 	=> 'vamico_video_embed',
			'class'	=> 'postformat-mb-video',
			'std' 	=> '',
			'type' 	=> 'textarea',
		),
		array(
			'name' 	=> esc_html__( 'Add Gallery', 'vamico' ),
			'desc' 	=> esc_html__( 'Create gallery images', 'vamico' ),
			'id' 	=> 'vamico_post_gallery',
			'class'	=> 'postformat-mb-gallery',
			'std' 	=> '',
			'type' 	=> 'post_gallery_meta',
		),
		array(
			'name' 	=> esc_html__( 'Gallery Layout', 'vamico' ),
			'desc' 	=> esc_html__( 'Select gallery layout style', 'vamico' ),
			'id' 	=> 'vamico_post_gallery_layout',
			'class'	=> 'postformat-mb-gallery select300',
			'std' 	=> '',
			'type'	=> 'select',
			'options' => array(
				''   => esc_html__( 'None', 'vamico' ),
				'slider'   => esc_html__( 'Slider', 'vamico' ),
				'justified'  => esc_html__( 'Justified','vamico' ),
			),
		),
	),
);
$this->meta_box[] = array(
	'id'		=> 'post-meta-box',
	'title'		=> esc_html__( 'Post Options','vamico' ),
	'page'		=> array( 'post' ),
	'context'	=> 'normal',
	'priority'	=> 'core',
	'fields'	=> array(
		/**
		* Featured Image Location
		*/
		array(
			'name'	=> esc_html__( 'Post Featured Image Position', 'vamico' ),
			'desc'	=> esc_html__( 'Select the featured image position inside the post or outside', 'vamico' ),
			'id'	=> 'vamico_featured_img_pos',
			'std'	=> 'inside_contnet',
			'class' => 'select300',
			'type'	=> 'select',
			'options' => array(
				'inside_post'  => esc_html__( 'Inside Post', 'vamico' ),
				'outside_post' => esc_html__( 'Outside Post', 'vamico' ),
			),
		),
		/**
		* Featured Image type
		*/
		array(
			'name'	=> esc_html__( 'Post Featured Image Style', 'vamico' ),
			'desc'	=> esc_html__( 'Select the style you wish to display in page-header area or inside the content.', 'vamico' ),
			'id'	=> 'vamico_featured_img_type',
			'std'	=> '',
			'class' => 'select300 inside_post vamico_featured_img_type',
			'type'	=> 'select',
			'options' => array(
				'default'   => esc_html__( 'Default', 'vamico' ),
				'standard'  => esc_html__( 'Standard', 'vamico' ),
				'fullwidth' => esc_html__( 'Full Width', 'vamico' ),
			),
		),

		/**
		 * Featured content alignment
		 */
		array(
			'name'  	=> esc_html__( 'Featured Content Alignment','vamico' ),
			'desc'   	=> esc_html__( 'Select featured content alignment. Choose between 1, 2 or 3 position layout.','vamico' ),
			'id' 		=> 'vamico_featured_styling',
			'std' 		=> 'is-left',
			'class'		=> '',
			'type'   	=> 'layout',
			'options'   => array(
				'is-left'   => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		),
		/**
		 * sidebar position
		 */
		array(
			'name'		=> esc_html__( 'Sidebar Position','vamico' ),
			'desc'		=> esc_html__( 'Select the sidebar position you wish to use for this page, Left Sidebar or Right Sidebar or Full Width.','vamico' ),
			'id'		=> 'vamico_sidebar_options',
			'std'		=> $vamico_sidebar_layout,
			'type'		=> 'layout',
			'options'	=> array(
					'rightsidebar'	=> VAMICO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
					'leftsidebar'	=> VAMICO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
					'fullwidth'		=> VAMICO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
				),
		),
		/**
		 * custom sidebar
		 */
		array(
			'name'		=> esc_html__( 'Custom Sidebar','vamico' ),
			'desc' 		=> esc_html__( 'Select the Sidebar you wish to assign for this page.','vamico' ),
			'id' 		=> 'vamico_custom_widget',
			'type' 		=> 'customselect',
			'class'		=> 'select300',
			'std' 		=> '',
			'options'	=> $vamico_sidebar_widget,
		),
		/**
		 * Layout Mode
		 */
		array(
			'name'	=> esc_html__( 'Layout Mode','vamico' ),
			'desc'	=> esc_html__( 'Check this if you wish to use Boxed mode layout for this page.','vamico' ),
			'id'	=> 'vamico_page_layout',
			'std' 	=> 'off',
			'type'	=> 'checkbox',
		),
		/**
		 * page background
		 */
		array(
			'name'	=> esc_html__( 'Page Background','vamico' ),
			'desc'	=> esc_html__( 'Upload the image for the page background. This will apply only if the layout is selected as boxed in options panel','vamico' ),
			'id'	=> 'vamico_page_bg_prop',
			'class'	=> 'vamico_page_bg',
			'std'	=> '',
			'type'	=> 'background',
			'options'	=> array(
						'image'		=> '',
						'color'		=> '',
						'repeat' 	=> 'repeat',
						'position'	=> 'center top',
						'attachment' => 'scroll',
			),
		),
	),
);

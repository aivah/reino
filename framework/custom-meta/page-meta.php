<?php
/**
 * page metabox
 */
$vamico_sidebar_widget  = get_option( 'vamico_customsidebar' );
$vamico_sidebar_layout  = get_option( 'vamico_defaultlayout' ) ? get_option( 'vamico_defaultlayout' ) : 'rightsidebar';
$this->meta_box = array();
$this->meta_box[] = array(
	'id'		=> 'page-meta-box',
	'title'		=> esc_html__( ' Page Options','vamico' ),
	'context'	=> 'normal',
	'page'		=> array( 'page' ),
	'priority'	=> 'core',
	'fields'	=> array(
		/**
		* Featured Image Location
		*/
		array(
			'name'	=> esc_html__( 'Post Featured Image Location', 'vamico' ),
			'desc'	=> esc_html__( 'Select the featured image position inside the post or outside', 'vamico' ),
			'id'	=> 'vamico_featured_img_pos',
			'std'	=> 'inside_post',
			'class' => 'select300',
			'type'	=> 'select',
			'options' => array(
				'inside_post' 	=> esc_html__( 'Inside Post','vamico' ),
				'outside_post'   => esc_html__( 'Outside Post', 'vamico' ),
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
			'class' => 'select300 inside_post vamico_featured_img_type wide',
			'type'	=> 'select',
			'options' => array(
				'default'  => esc_html__( 'Default', 'vamico' ),
				'standard' => esc_html__( 'Standard','vamico' ),
				'wide'	   => esc_html__( 'Wide','vamico' ),
			),
		),
		/**
		 * Featured content alignment
		 */
		array(
			'name'  	=> esc_html__( 'Featured Content Alignment','vamico' ),
			'desc'   	=> esc_html__( 'Select featured content alignment. Choose between 1, 2 or 3 position layout.','vamico' ),
			'id' 		=> 'vamico_featured_styling',
			'std' 		=> 'is-center',
			'class'		=> '',
			'type'   	=> 'layout',
			'options'   => array(
				'is-left'   => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center' => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'  => VAMICO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		),
		/**
		 * Featued custom text
		 */
		array(
			'name'		=> esc_html__( 'Featured Custom Text','vamico' ),
			'desc'		=> esc_html__( 'Type the custom text you wish to display in the Featured section of this page/post. If you wish to use bold text then use strong element example &lt;strong&gt;bold text &lt;/strong&gt;','vamico' ),
			'id'		=> 'vamico_featured_desc',
			'class'		=> '',
			'std'		=> '',
			'type'		=> 'textarea',
		),
		/**
		 * Featured background
		 */
		array(
			'name'		=> esc_html__( 'Featured Background Color','vamico' ),
			'desc'		=> esc_html__( 'Background color works well with inside content wide','vamico' ),
			'id'		=> 'vamico_featured_bgcolor',
			'class'		=> 'inside_post vamico_featured_img_type',
			'std' 		=> '',
			'type'		=> 'color',
		),
		/**
		 * Featured text color
		 */
		array(
			'name'		=> esc_html__( 'Featured Text Color','vamico' ),
			'id'		=> 'vamico_featured_txtcolor',
			'class'		=> 'inside_post vamico_featured_img_type',
			'std'		=> '',
			'type'		=> 'color',
		),
		/**
		 * Sidebar position
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
			'name'		=> esc_html__( 'Layout Mode','vamico' ),
			'desc'		=> esc_html__( 'Check this if you wish to use Boxed mode layout for this page.','vamico' ),
			'id'		=> 'vamico_page_layout',
			'std' 		=> 'off',
			'type'		=> 'checkbox',
		),
		/**
		 * page background
		 */
		array(
			'name'		=> esc_html__( 'Page Background','vamico' ),
			'desc'		=> esc_html__( 'Upload the image for the page background. This will apply only if the layout is selected as boxed in options panel','vamico' ),
			'id'		=> 'vamico_page_bg_prop',
			'class'		=> 'vamico_page_bg',
			'std'		=> '',
			'type'		=> 'background',
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

<?php
/**
 * page metabox
 */
$reino_sidebar_widget  = get_option( 'reino_customsidebar' );
$reino_sidebar_layout  = get_option( 'reino_defaultlayout' ) ? get_option( 'reino_defaultlayout' ) : 'rightsidebar';
$this->meta_box = array();
$this->meta_box[] = array(
	'id'		=> 'page-meta-box',
	'title'		=> esc_html__( ' Page Options','reino' ),
	'context'	=> 'normal',
	'page'		=> array( 'page' ),
	'priority'	=> 'core',
	'fields'	=> array(
		/**
		* Featured Image Location
		*/
		array(
			'name'	=> esc_html__( 'Post Featured Image Location', 'reino' ),
			'desc'	=> esc_html__( 'Select the featured image position inside the post or outside', 'reino' ),
			'id'	=> 'reino_featured_img_pos',
			'std'	=> 'inside_post',
			'class' => 'select300',
			'type'	=> 'select',
			'options' => array(
				'inside_post' 	=> esc_html__( 'Inside Post','reino' ),
				'outside_post'   => esc_html__( 'Outside Post', 'reino' ),
			),
		),
		/**
		* Featured Image type
		*/
		array(
			'name'	=> esc_html__( 'Post Featured Image Style', 'reino' ),
			'desc'	=> esc_html__( 'Select the style you wish to display in page-header area or inside the content.', 'reino' ),
			'id'	=> 'reino_featured_img_type',
			'std'	=> '',
			'class' => 'select300 inside_post reino_featured_img_type wide',
			'type'	=> 'select',
			'options' => array(
				'default'  => esc_html__( 'Default', 'reino' ),
				'standard' => esc_html__( 'Standard','reino' ),
				'wide'	   => esc_html__( 'Wide','reino' ),
			),
		),
		/**
		 * Featured content alignment
		 */
		array(
			'name'  	=> esc_html__( 'Featured Content Alignment','reino' ),
			'desc'   	=> esc_html__( 'Select featured content alignment. Choose between 1, 2 or 3 position layout.','reino' ),
			'id' 		=> 'reino_featured_styling',
			'std' 		=> 'is-center',
			'class'		=> '',
			'type'   	=> 'layout',
			'options'   => array(
				'is-left'   => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-left.png',
				'is-center' => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-center.png',
				'is-right'  => REINO_FRAMEWORK_URI . 'admin/images/columns/sh-right.png',
			),
		),
		/**
		 * Featued custom text
		 */
		array(
			'name'		=> esc_html__( 'Featured Custom Text','reino' ),
			'desc'		=> esc_html__( 'Type the custom text you wish to display in the Featured section of this page/post. If you wish to use bold text then use strong element example &lt;strong&gt;bold text &lt;/strong&gt;','reino' ),
			'id'		=> 'reino_featured_desc',
			'class'		=> '',
			'std'		=> '',
			'type'		=> 'textarea',
		),
		/**
		 * Featured background
		 */
		array(
			'name'		=> esc_html__( 'Featured Background Color','reino' ),
			'desc'		=> esc_html__( 'Background color works well with inside content wide','reino' ),
			'id'		=> 'reino_featured_bgcolor',
			'class'		=> 'inside_post reino_featured_img_type',
			'std' 		=> '',
			'type'		=> 'color',
		),
		/**
		 * Featured text color
		 */
		array(
			'name'		=> esc_html__( 'Featured Text Color','reino' ),
			'id'		=> 'reino_featured_txtcolor',
			'class'		=> 'inside_post reino_featured_img_type',
			'std'		=> '',
			'type'		=> 'color',
		),
		/**
		 * Sidebar position
		 */
		array(
			'name'		=> esc_html__( 'Sidebar Position','reino' ),
			'desc'		=> esc_html__( 'Select the sidebar position you wish to use for this page, Left Sidebar or Right Sidebar or Full Width.','reino' ),
			'id'		=> 'reino_sidebar_options',
			'std'		=> $reino_sidebar_layout,
			'type'		=> 'layout',
			'options'	=> array(
					'rightsidebar'	=> REINO_FRAMEWORK_URI . 'admin/images/columns/rightsidebar.png',
					'leftsidebar'	=> REINO_FRAMEWORK_URI . 'admin/images/columns/leftsidebar.png',
					'fullwidth'		=> REINO_FRAMEWORK_URI . 'admin/images/columns/fullwidth.png',
				),
		),
		/**
		 * custom sidebar
		 */
		array(
			'name'		=> esc_html__( 'Custom Sidebar','reino' ),
			'desc' 		=> esc_html__( 'Select the Sidebar you wish to assign for this page.','reino' ),
			'id' 		=> 'reino_custom_widget',
			'type' 		=> 'customselect',
			'class'		=> 'select300',
			'std' 		=> '',
			'options'	=> $reino_sidebar_widget,
		),
		/**
		 * Layout Mode
		 */
		array(
			'name'		=> esc_html__( 'Layout Mode','reino' ),
			'desc'		=> esc_html__( 'Check this if you wish to use Boxed mode layout for this page.','reino' ),
			'id'		=> 'reino_page_layout',
			'std' 		=> 'off',
			'type'		=> 'checkbox',
		),
		/**
		 * page background
		 */
		array(
			'name'		=> esc_html__( 'Page Background','reino' ),
			'desc'		=> esc_html__( 'Upload the image for the page background. This will apply only if the layout is selected as boxed in options panel','reino' ),
			'id'		=> 'reino_page_bg_prop',
			'class'		=> 'reino_page_bg',
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

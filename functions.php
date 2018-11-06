<?php
/**
 * register and enqueue scripts.
 */
if ( ! function_exists( 'reino_theme_enqueue_scripts' ) ) {
	function reino_theme_enqueue_scripts() {

		$reino_theme_data    = wp_get_theme();
		$reino_theme_version = $reino_theme_data->get( 'Version' );

		global $post;
		// Enqueue scripts.
		wp_enqueue_script( 'superfish', REINO_THEME_JS . '/superfish.js', array( 'jquery' ), '', true );

		if ( is_singular( 'post' ) || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gallery' ) ) ) {
			wp_enqueue_script( 'prettyPhoto', REINO_THEME_JS . '/jquery.prettyPhoto.js', '', '', true );
			wp_enqueue_style( 'reino-prettyPhoto', REINO_THEME_CSS . '/prettyPhoto.css', array(), $reino_theme_version, false );
		}
		wp_enqueue_script( 'reino-masonry', REINO_THEME_JS . '/masonry.pkgd.js', array( 'jquery' ), $reino_theme_version, true );
		wp_enqueue_script( 'reino-customjs', REINO_THEME_JS . '/reino-custom.js', array( 'jquery' ), $reino_theme_version, true );

		// AJAX URL
		$reino_data['ajaxurl'] = esc_url( admin_url( 'admin-ajax.php' ) );

		// HOME URL
		$reino_data['home_url'] = esc_url( get_home_url() );

		// Directory URI
		$reino_data['directory_uri'] = get_theme_file_uri();

		// Pass data to javascript
		$reino_params = array(
			'l10n_print_after' => 'reino_localize_script_param = ' . wp_json_encode( $reino_data ) . ';',
		);
		wp_localize_script( 'jquery', 'reino_localize_script_param', $reino_params );

		// Enqueue styles.
		wp_enqueue_style( 'reino-theme', get_stylesheet_uri() );
		wp_enqueue_style( 'font-awesome', REINO_THEME_CSS . '/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'reino-animate', REINO_THEME_CSS . '/animate.css' );
		wp_enqueue_style( 'reino-responsive', REINO_THEME_CSS . '/responsive.css' );
	}
	add_action( 'wp_enqueue_scripts', 'reino_theme_enqueue_scripts' );
} // End if().

/**
 * Enqueue colorpicker styles and scripts.
 * - https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 *
 * @return void
 */
function reino_category_colorpicker_enqueue( $taxonomy ) {

	$screen = get_current_screen();
	if ( null !== $screen && 'edit-category' !== $screen->id ) {
		return;
	}

	// Colorpicker Scripts
	wp_enqueue_script( 'wp-color-picker' );
	// Colorpicker Styles
	wp_enqueue_style( 'wp-color-picker' );

}
add_action( 'admin_enqueue_scripts', 'reino_category_colorpicker_enqueue' );

/**
 * Print javascript to initialize the colorpicker
 * - https://developer.wordpress.org/reference/hooks/admin_print_scripts/
 *
 * @return void
 */
function reino_colorpicker_init_inline() {

	$screen = get_current_screen();
	if ( null !== $screen && 'edit-category' !== $screen->id ) {
		return;
	}
	?>
<script>
	jQuery( document ).ready( function( $ ) {
		$( '.colorpicker' ).wpColorPicker();
	}); // End Document Ready JQuery
</script>
	<?php
}
add_action( 'admin_print_scripts', 'reino_colorpicker_init_inline', 20 );

/* Enqueue comment-reply.js for Threaded Comments
*/
function reino_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'reino_enqueue_comments_reply' );

if ( ! function_exists( 'reino_owl_carousel_enqueue_scripts' ) ) {
	add_action( 'reino_theme_owlslider', 'reino_owl_carousel_enqueue_scripts' );
	function reino_owl_carousel_enqueue_scripts() {

		$owl_post_gallery_speed  = get_option( 'reino_post_gallery_owl_speed' )
								? get_option( 'reino_post_gallery_owl_speed' )
								: '3000';
		$owl_navigation          = get_option( 'reino_related_owl_nav' )
								? get_option( 'reino_related_owl_nav' )
								: 'true';
		$owl_autoplay            = get_option( 'reino_owlslide_autoplay' )
								? get_option( 'reino_owlslide_autoplay' )
								: 'true';

		$owl_timeout = get_option( 'reino_owlslide_timeout' ) ? get_option( 'reino_owlslide_timeout' ) : '5000';
		$owl_margin  = get_option( 'reino_owlslide_margin' ) ? get_option( 'reino_owlslide_margin' ) : '20';

		$owlcarousel_args = array(
			'galleryspeed' => $owl_post_gallery_speed,
			'navigation'   => $owl_navigation,
			'autoplay'     => $owl_autoplay,
			'timeout'      => $owl_timeout,
			'margin'       => $owl_margin,
		);

		wp_enqueue_script( 'owlcarousel', REINO_THEME_JS . '/owl.carousel.js', array( 'jquery' ), '', true );
		wp_localize_script( 'owlcarousel', 'owlcarousel_args', $owlcarousel_args );
		wp_enqueue_style( 'owl-style', REINO_THEME_CSS . '/owl.carousel.css' );
		wp_enqueue_style( 'owl-theme', REINO_THEME_CSS . '/owl.theme.css' );
	}
}

/**
 * Flex Slider Enqueue Scripts
 */
if ( ! function_exists( 'reino_flexslider_enqueue_scripts' ) ) {
	add_action( 'reino_flexslider_scripts','reino_flexslider_enqueue_scripts' );
	function reino_flexslider_enqueue_scripts() {
		$fs_slidespeed 	= get_option( 'storeup_flexslidespeed' ) ? get_option( 'storeup_flexslidespeed' ) : '3000';
		$fs_slideeffect = get_option( 'storeup_flexslideeffect' ) ? get_option( 'storeup_flexslideeffect' ) : 'fade';
		$fs_slidednav 	= get_option( 'storeup_flexslidednav' ) ? get_option( 'storeup_flexslidednav' ) : 'true';
		$flexslider_args = array(
							'slideeffect' => $fs_slideeffect,
							'slidespeed'  => $fs_slidespeed,
							'slidednav'	  => $fs_slidednav,
						);
		wp_enqueue_script( 'flexslider', REINO_THEME_JS . '/flexslider.js', array( 'jquery' ), '', true );
		wp_localize_script( 'flexslider', 'flexslider_args', $flexslider_args );
		wp_enqueue_style( 'flexslider-style', REINO_THEME_CSS . '/flexslider.css' );
	}
}

// Theme functions for common usage
require_once( get_parent_theme_file_path() . '/theme-functions.php' );

require_once( get_parent_theme_file_path() . '/framework/common/class-ct-meta-fields.php' );

// load Post Likes function file
require_once( get_parent_theme_file_path() . '/framework/common/iva-post-like.php' );

/* loads Theme Options Importer File */
require_once( get_parent_theme_file_path() . '/framework/admin/options-importer/ob-import-export.php' );

/**
 * Reino_Theme_Functions class.
 */
if ( ! class_exists( 'Reino_Theme_Functions' ) ) {

	class Reino_Theme_Functions {

		public $reino_meta_box;

		public function __construct() {
			$this->reino_theme_constants();
			$this->reino_theme_support();
			$this->reino_theme_admin_scripts();
			$this->reino_theme_admin_interface();
			$this->reino_theme_custom_widgets();
			$this->reino_theme_custom_meta();
			$this->reino_theme_meta_generator();
			$this->reino_theme_extras();
		}

		function reino_theme_constants() {
			/**
			 * Set the file path based on whether the Options
			 * Framework is in a parent theme or child theme
			 * Directory Structure
			 */
			define( 'REINO_FRAMEWORK', '1.0' );
			define( 'REINO_THEME_NAME', 'Reino' );
			define( 'REINO_THEME_URI', get_theme_file_uri() );
			define( 'REINO_THEME_DIR', get_theme_file_path() );
			define( 'REINO_THEME_JS', REINO_THEME_URI . '/js' );
			define( 'REINO_THEME_CSS', REINO_THEME_URI . '/css' );
			define( 'REINO_FRAMEWORK_DIR', REINO_THEME_DIR . '/framework/' );
			define( 'REINO_FRAMEWORK_URI', REINO_THEME_URI . '/framework/' );
			define( 'REINO_ADMIN_URI', REINO_FRAMEWORK_URI . 'admin' );
			define( 'REINO_ADMIN_DIR', REINO_FRAMEWORK_DIR . 'admin' );
			define( 'REINO_THEME_WIDGETS', REINO_FRAMEWORK_DIR . 'widgets/' );
			define( 'REINO_THEME_CUSTOM_META', REINO_FRAMEWORK_DIR . 'custom-meta/' );
		}

		/**
		 * allows a theme to register its support of a certain features
		 */
		function reino_theme_support() {
			// Add post formats
			add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery', 'image' ) );

			// Add HTML5 markup for captions
			// http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
			add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

			// Add post thumbnails
			add_theme_support( 'post-thumbnails' );

			// Automatic Feed Links
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'editor-style.css' );
			// Enable plugins to manage the document title
			// http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
			add_theme_support( 'title-tag' );
			// Add excerpts on pages
			add_post_type_support( 'page', 'excerpt' );

			// Register wp_nav_menu() menus
			// http://codex.wordpress.org/Function_Reference/register_nav_menus
			register_nav_menus(
				array(
					'primary-menu'   => esc_html__( 'Primary Menu', 'reino' ),
					'secondary-menu' => esc_html__( 'Secondary Menu', 'reino' ),
					'footer-menu'    => esc_html__( 'Footer Menu', 'reino' ),
				)
			);
			// Define content width.
			if ( ! isset( $content_width ) ) {
				$content_width = 1140;
			}
		}

		/**
		 * scripts and styles enqueue .
		 */
		function reino_theme_admin_scripts() {
			require_once( REINO_FRAMEWORK_DIR . 'common/admin-scripts.php' );
		}

		/**
		 * admin interface .
		 */
		function reino_theme_admin_interface() {
			require_once( REINO_FRAMEWORK_DIR . 'common/iva-googlefont.php' );
			require_once( REINO_FRAMEWORK_DIR . 'admin/admin-interface.php' );
			require_once( REINO_FRAMEWORK_DIR . 'admin/theme-options.php' );
		}

		/**
		 * widgets .
		 */
		function reino_theme_custom_widgets() {
			require_once( REINO_THEME_WIDGETS . '/register-widget.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-aboutme.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-recent-posts.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-popular-posts.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-sociable.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-facebook-like.php' );
			require_once( REINO_THEME_WIDGETS . '/iva-wg-author-contribute.php' );
		}

		/** load meta generator templates
		 * @files slider, Menus, page, posts,
		 */
		function reino_theme_custom_meta() {
			require_once( REINO_THEME_CUSTOM_META . '/page-meta.php' );
			require_once( REINO_THEME_CUSTOM_META . '/post-meta.php' );
		}

		function reino_theme_meta_generator() {
			require_once( REINO_THEME_CUSTOM_META . '/meta-generator.php' );
		}

		/**
		 * theme functions
		 * @uses skin generator
		 * @uses pagination
		 * @uses sociables
		 * @uses Aqua imageresize // Credits : http://aquagraphite.com/
		 * @uses plugin activation class
		 */
		function reino_theme_extras() {
			require_once( REINO_THEME_DIR . '/css/skin.php' );
			require_once( REINO_FRAMEWORK_DIR . 'common/iva-generator.php' );
			require_once( REINO_FRAMEWORK_DIR . 'includes/class-activation.php' );
			require_once( REINO_FRAMEWORK_DIR . 'includes/custom-gallery.php' );
		}

		/**
		 * custom switch case for fetching
		 * posts, post-types, custom-taxonomies, tags
		 */
		function reino_get_vars( $type ) {
			$reino_tax_options = array();
			switch ( $type ) {
				/**
				 * get page titles.
				 */
				case 'pages':
					$reino_get_pages = get_pages( 'sort_column=post_parent,menu_order' );
					if ( ! empty( $reino_get_pages ) && ! is_wp_error( $reino_get_pages ) ) {
						foreach ( $reino_get_pages as $page ) {
							$reino_tax_options[ $page->ID ] = $page->post_title;
						}
					}
					break;
				/**
				 * get posts slug and name.
				 */
				case 'posts':
					$reino_post_cats = get_categories( 'hide_empty=0' );
					if ( ! empty( $reino_post_cats ) && ! is_wp_error( $reino_post_cats ) ) {
						foreach ( $reino_post_cats as $cat ) {
							$reino_tax_options[ $cat->slug ] = $cat->name;
						}
					}
					break;
				/**
				 * get categories slug and name.
				 */
				case 'categories':
					$reino_post_cats = get_categories( 'hide_empty=true' );
					if ( ! empty( $reino_post_cats ) && ! is_wp_error( $reino_post_cats ) ) {
						foreach ( $reino_post_cats as $cat ) {
							$reino_tax_options[ $cat->term_id ] = $cat->name;
						}
					}
					break;
				/**
				 * get taxonomy tags.
				 */
				case 'tags':
					$reino_tags = get_tags(array(
						'taxonomy' => 'post_tag',
					));
					if ( ! empty( $reino_tags ) && ! is_wp_error( $reino_tags ) ) {
						foreach ( $reino_tags as $tags ) {
							$reino_tax_options[ $tags->slug ] = $tags->name;
						}
					}
					break;
				/**
				 * slider arrays for theme options.
				 */
				case 'slider_type':
					$reino_tax_options = array(
						''             => esc_html__( 'Select Slider', 'reino' ),
						'owl_slider'   => esc_html__( 'Owl Carousel Slider', 'reino' ),
						'flex_slider'  => esc_html__( 'Advanced Flexslider', 'reino' ),
						'flex_slider2'  => esc_html__( 'Advanced Flexslider 2', 'reino' ),
						'static_image' => esc_html__( 'Static Image', 'reino' ),
						'customslider' => esc_html__( 'Custom Slider', 'reino' ),
					);
					break;
			} // End switch().
			return $reino_tax_options;
		}
	}
} // End if().

$reino_theme_ob = new Reino_Theme_Functions();

/**
 * function reino_theme_setup()
 */
if ( ! function_exists( 'reino_theme_setup' ) ) {

	function reino_theme_setup() {
		// Make theme available for translation
		load_theme_textdomain( 'reino', get_theme_file_uri() . '/languages' );
		add_filter( 'posts_where', 'reino_multi_tax_terms' );
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Add custom image sizes
		add_image_size( 'reino-extra-large', 1920, '', false );
		add_image_size( 'reino-large-horizontal', 1280, 720, true );
		add_image_size( 'reino-large-vertical', 920, 1280, true );
		add_image_size( 'reino-large-square', 1280, 1280, true );
		add_image_size( 'reino-medium-uncropped', 720, '', false );
		add_image_size( 'reino-medium-horizontal', 720, 280, true );
		add_image_size( 'reino-medium-vertical', 540, 720, true );
		add_image_size( 'reino-medium-square', 720, 720, true );
		add_image_size( 'reino-small-square', 150, 150, true );
	}
	add_action( 'after_setup_theme', 'reino_theme_setup' );
}

/**
* generates the html pingback head tag
* @return string the pingback head tag
*/
if ( ! function_exists( 'reino_set_pingback_tag' ) ) {
	function reino_set_pingback_tag( $echo = true ) {
		$output = apply_filters( 'reino_pingback_head_tag', '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '" />' . "\n" );
		echo wp_kses( $output, array(
			'link' => array(
				'href' => true,
				'rel'  => true,
			),
		));
	}
	add_action( 'wp_head', 'reino_set_pingback_tag', 10, 0 );
}

/**
 * Multiple taxonomies
 */
if ( ! function_exists( 'reino_multi_tax_terms' ) ) {
	function reino_multi_tax_terms( $where ) {
		global $wp_query, $wpdb;

		if ( isset( $wp_query->query_vars['term'] ) && ( strpos( $wp_query->query_vars['term'], ', ' ) !== false && strpos( $where, 'AND 0' ) !== false ) ) {

			/**
			 * Get the terms
			 */
			$reino_term_array = explode( ',', $wp_query->query_vars['term'] );
			foreach ( $reino_term_array as $term_item ) {
				$reino_terms[] = get_terms( $wp_query->query_vars['taxonomy'], array(
					'slug' => $term_item,
				));
			}

			/**
			 * get the id of posts with that term in that taxonomy.
			 */
			foreach ( $reino_terms as $term ) {
				if ( $term ) {
					$reino_term_ids[] = $term[0]->term_id;
				}
			} // End foreach().

			$reino_post_ids = get_objects_in_term( $reino_term_ids, $wp_query->query_vars['taxonomy'] );

			if ( ! is_wp_error( $reino_post_ids ) && count( $reino_post_ids ) ) {
				// Build the new query
				$reino_postids_where = " AND $wpdb->posts.ID IN ('. implode(', ', $reino_post_ids) . ') ";
				$where                = str_replace( 'AND 0', $reino_postids_where, $where );
			}
		} // End if().

		return $where;
	}
} // End if().

/**
 * function reino_get_attachment_id_from_src()
 */
if ( ! function_exists( 'reino_get_attachment_id_from_src' ) ) {
	function reino_get_attachment_id_from_src( $image_src ) {
		global $wpdb;
		$id = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid = %s", $image_src ) );
		return $id;
	}
}


/**
 * Theme Demo Importer
 */
function reino_ocdi_import_files() {
	return array(
		array(
			'import_file_name'         => esc_html__( 'Reino Demo', 'reino' ),
			'local_import_file'        => trailingslashit( get_theme_file_path() ) . '/theme-demo/main-demo/Sample-Data.xml',
			'local_import_widget_file' => trailingslashit( get_theme_file_path() ) . '/theme-demo/main-demo/widget_data.wie',
			'import_preview_image_url' => trailingslashit( get_theme_file_uri() ) . 'screenshot.png',
			'import_notice'            => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'reino' ),
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'reino_ocdi_import_files' );

function reino_ocdi_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'primary-menu' => $main_menu->term_id,
	) );

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Front page' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'reino_ocdi_after_import_setup' );

/**
 * Registers an editor stylesheet for the theme.
 */
function reino_theme_add_editor_styles() {
	add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'reino_theme_add_editor_styles' );

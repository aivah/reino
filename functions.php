<?php
/**
 * register and enqueue scripts.
 */
if ( ! function_exists( 'vamico_theme_enqueue_scripts' ) ) {
	function vamico_theme_enqueue_scripts() {

		$vamico_theme_data    = wp_get_theme();
		$vamico_theme_version = $vamico_theme_data->get( 'Version' );

		global $post;
		// Enqueue scripts.
		wp_enqueue_script( 'superfish', VAMICO_THEME_JS . '/superfish.js', array( 'jquery' ), '', true );

		if ( is_singular( 'post' ) || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gallery' ) ) ) {
			wp_enqueue_script( 'prettyPhoto', VAMICO_THEME_JS . '/jquery.prettyPhoto.js', '', '', true );
			wp_enqueue_style( 'vamico-prettyPhoto', VAMICO_THEME_CSS . '/prettyPhoto.css', array(), $vamico_theme_version, false );
		}
		wp_enqueue_script( 'vamico-masonry', VAMICO_THEME_JS . '/masonry.pkgd.js', array( 'jquery' ), $vamico_theme_version, true );
		wp_enqueue_script( 'vamico-customjs', VAMICO_THEME_JS . '/vamico-custom.js', array( 'jquery' ), $vamico_theme_version, true );

		// AJAX URL
		$vamico_data['ajaxurl'] = esc_url( admin_url( 'admin-ajax.php' ) );

		// HOME URL
		$vamico_data['home_url'] = esc_url( get_home_url() );

		// Directory URI
		$vamico_data['directory_uri'] = get_theme_file_uri();

		// Pass data to javascript
		$vamico_params = array(
			'l10n_print_after' => 'vamico_localize_script_param = ' . wp_json_encode( $vamico_data ) . ';',
		);
		wp_localize_script( 'jquery', 'vamico_localize_script_param', $vamico_params );

		// Enqueue styles.
		wp_enqueue_style( 'vamico-theme', get_stylesheet_uri() );
		wp_enqueue_style( 'font-awesome', VAMICO_THEME_CSS . '/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'vamico-animate', VAMICO_THEME_CSS . '/animate.css' );
		wp_enqueue_style( 'vamico-responsive', VAMICO_THEME_CSS . '/responsive.css' );
	}
	add_action( 'wp_enqueue_scripts', 'vamico_theme_enqueue_scripts' );
} // End if().

/**
 * Enqueue colorpicker styles and scripts.
 * - https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 *
 * @return void
 */
function vamico_category_colorpicker_enqueue( $taxonomy ) {

	$screen = get_current_screen();
	if ( null !== $screen && 'edit-category' !== $screen->id ) {
		return;
	}

	// Colorpicker Scripts
	wp_enqueue_script( 'wp-color-picker' );
	// Colorpicker Styles
	wp_enqueue_style( 'wp-color-picker' );

}
add_action( 'admin_enqueue_scripts', 'vamico_category_colorpicker_enqueue' );

/**
 * Print javascript to initialize the colorpicker
 * - https://developer.wordpress.org/reference/hooks/admin_print_scripts/
 *
 * @return void
 */
function vamico_colorpicker_init_inline() {

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
add_action( 'admin_print_scripts', 'vamico_colorpicker_init_inline', 20 );

/* Enqueue comment-reply.js for Threaded Comments
*/
function vamico_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'vamico_enqueue_comments_reply' );

if ( ! function_exists( 'vamico_owl_carousel_enqueue_scripts' ) ) {
	add_action( 'vamico_theme_owlslider', 'vamico_owl_carousel_enqueue_scripts' );
	function vamico_owl_carousel_enqueue_scripts() {

		$owl_post_gallery_speed  = get_option( 'vamico_post_gallery_owl_speed' )
								? get_option( 'vamico_post_gallery_owl_speed' )
								: '3000';
		$owl_related_speed       = get_option( 'vamico_related_owl_speed' )
								? get_option( 'vamico_related_owl_speed' )
								: '3000';
		$owl_related_items_limit = get_option( 'vamico_related_owl_itemslimit' )
								? get_option( 'vamico_related_owl_itemslimit' )
								: '4';
		$owl_navigation          = get_option( 'vamico_related_owl_nav' )
								? get_option( 'vamico_related_owl_nav' )
								: 'true';
		$owl_autoplay            = get_option( 'vamico_owlslide_autoplay' )
								? get_option( 'vamico_owlslide_autoplay' )
								: 'true';

		$owl_timeout = get_option( 'vamico_owlslide_timeout' ) ? get_option( 'vamico_owlslide_timeout' ) : '5000';
		$owl_margin  = get_option( 'vamico_owlslide_margin' ) ? get_option( 'vamico_owlslide_margin' ) : '20';

		$owlcarousel_args = array(
			'relateditems' => $owl_related_items_limit,
			'relatedspeed' => $owl_related_speed,
			'galleryspeed' => $owl_post_gallery_speed,
			'navigation'   => $owl_navigation,
			'autoplay'     => $owl_autoplay,
			'timeout'      => $owl_timeout,
			'margin'       => $owl_margin,
		);

		wp_enqueue_script( 'owlcarousel', VAMICO_THEME_JS . '/owl.carousel.js', array( 'jquery' ), '', true );
		wp_localize_script( 'owlcarousel', 'owlcarousel_args', $owlcarousel_args );
		wp_enqueue_style( 'owl-style', VAMICO_THEME_CSS . '/owl.carousel.css' );
		wp_enqueue_style( 'owl-theme', VAMICO_THEME_CSS . '/owl.theme.css' );
	}
}

// Theme functions for common usage
require_once( get_parent_theme_file_path() . '/theme-functions.php' );

// load Post Likes function file
require_once( get_parent_theme_file_path() . '/framework/common/iva-post-like.php' );

/* loads Theme Options Importer File */
require_once( get_parent_theme_file_path() . '/framework/admin/options-importer/ob-import-export.php' );

/**
 * Vamico_Theme_Functions class.
 */
if ( ! class_exists( 'Vamico_Theme_Functions' ) ) {

	class Vamico_Theme_Functions {

		public $vamico_meta_box;

		public function __construct() {
			$this->vamico_theme_constants();
			$this->vamico_theme_support();
			$this->vamico_theme_admin_scripts();
			$this->vamico_theme_admin_interface();
			$this->vamico_theme_custom_widgets();
			$this->vamico_theme_custom_meta();
			$this->vamico_theme_meta_generator();
			$this->vamico_theme_extras();
		}

		function vamico_theme_constants() {
			/**
			 * Set the file path based on whether the Options
			 * Framework is in a parent theme or child theme
			 * Directory Structure
			 */
			define( 'VAMICO_FRAMEWORK', '1.0' );
			define( 'VAMICO_THEME_NAME', 'Vamico' );
			define( 'VAMICO_THEME_URI', get_theme_file_uri() );
			define( 'VAMICO_THEME_DIR', get_theme_file_path() );
			define( 'VAMICO_THEME_JS', VAMICO_THEME_URI . '/js' );
			define( 'VAMICO_THEME_CSS', VAMICO_THEME_URI . '/css' );
			define( 'VAMICO_FRAMEWORK_DIR', VAMICO_THEME_DIR . '/framework/' );
			define( 'VAMICO_FRAMEWORK_URI', VAMICO_THEME_URI . '/framework/' );
			define( 'VAMICO_ADMIN_URI', VAMICO_FRAMEWORK_URI . 'admin' );
			define( 'VAMICO_ADMIN_DIR', VAMICO_FRAMEWORK_DIR . 'admin' );
			define( 'VAMICO_THEME_WIDGETS', VAMICO_FRAMEWORK_DIR . 'widgets/' );
			define( 'VAMICO_THEME_CUSTOM_META', VAMICO_FRAMEWORK_DIR . 'custom-meta/' );
		}

		/**
		 * allows a theme to register its support of a certain features
		 */
		function vamico_theme_support() {
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
			register_nav_menus( array(
				'primary-menu'   => esc_html__( 'Primary Menu', 'vamico' ),
				'secondary-menu' => esc_html__( 'Secondary Menu', 'vamico' ),
				'footer-menu'    => esc_html__( 'Footer Menu', 'vamico' ),
			));
			// Define content width.
			if ( ! isset( $content_width ) ) {
				$content_width = 1140;
			}
		}

		/**
		 * scripts and styles enqueue .
		 */
		function vamico_theme_admin_scripts() {
			require_once( VAMICO_FRAMEWORK_DIR . 'common/admin-scripts.php' );
		}

		/**
		 * admin interface .
		 */
		function vamico_theme_admin_interface() {
			require_once( VAMICO_FRAMEWORK_DIR . 'common/iva-googlefont.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'admin/admin-interface.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'admin/theme-options.php' );
		}

		/**
		 * widgets .
		 */
		function vamico_theme_custom_widgets() {
			require_once( VAMICO_THEME_WIDGETS . '/register-widget.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-sociable.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-recentpost.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-aboutme.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-facebook-like.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-promo-banner.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-custom-ads.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-author-contribute.php' );
			require_once( VAMICO_THEME_WIDGETS . '/iva-wg-most-views.php' );
		}

		/** load meta generator templates
		 * @files slider, Menus, page, posts,
		 */
		function vamico_theme_custom_meta() {
			require_once( VAMICO_THEME_CUSTOM_META . '/page-meta.php' );
			require_once( VAMICO_THEME_CUSTOM_META . '/post-meta.php' );
		}

		function vamico_theme_meta_generator() {
			require_once( VAMICO_THEME_CUSTOM_META . '/meta-generator.php' );
		}

		/**
		 * theme functions
		 * @uses skin generator
		 * @uses pagination
		 * @uses sociables
		 * @uses Aqua imageresize // Credits : http://aquagraphite.com/
		 * @uses plugin activation class
		 */
		function vamico_theme_extras() {
			require_once( VAMICO_THEME_DIR . '/css/skin.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'includes/mega-menu.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'common/iva-generator.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'includes/class-activation.php' );
			require_once( VAMICO_FRAMEWORK_DIR . 'includes/custom-gallery.php' );
		}

		/**
		 * custom switch case for fetching
		 * posts, post-types, custom-taxonomies, tags
		 */
		function vamico_get_vars( $type ) {
			$vamico_tax_options = array();
			switch ( $type ) {
				/**
				 * get page titles.
				 */
				case 'pages':
					$vamico_get_pages = get_pages( 'sort_column=post_parent,menu_order' );
					if ( ! empty( $vamico_get_pages ) && ! is_wp_error( $vamico_get_pages ) ) {
						foreach ( $vamico_get_pages as $page ) {
							$vamico_tax_options[ $page->ID ] = $page->post_title;
						}
					}
					break;
				/**
				 * get posts slug and name.
				 */
				case 'posts':
					$vamico_post_cats = get_categories( 'hide_empty=0' );
					if ( ! empty( $vamico_post_cats ) && ! is_wp_error( $vamico_post_cats ) ) {
						foreach ( $vamico_post_cats as $cat ) {
							$vamico_tax_options[ $cat->slug ] = $cat->name;
						}
					}
					break;
				/**
				 * get categories slug and name.
				 */
				case 'categories':
					$vamico_post_cats = get_categories( 'hide_empty=true' );
					if ( ! empty( $vamico_post_cats ) && ! is_wp_error( $vamico_post_cats ) ) {
						foreach ( $vamico_post_cats as $cat ) {
							$vamico_tax_options[ $cat->term_id ] = $cat->name;
						}
					}
					break;
				/**
				 * get taxonomy tags.
				 */
				case 'tags':
					$vamico_tags = get_tags(array(
						'taxonomy' => 'post_tag',
					));
					if ( ! empty( $vamico_tags ) && ! is_wp_error( $vamico_tags ) ) {
						foreach ( $vamico_tags as $tags ) {
							$vamico_tax_options[ $tags->slug ] = $tags->name;
						}
					}
					break;
				/**
				 * slider arrays for theme options.
				 */
				case 'slider_type':
					$vamico_tax_options = array(
						''             => esc_html__( 'Select Slider', 'vamico' ),
						'owl_slider'   => esc_html__( 'Owl Carousel Slider', 'vamico' ),
						'static_image' => esc_html__( 'Static Image', 'vamico' ),
						'customslider' => esc_html__( 'Custom Slider', 'vamico' ),
					);
					break;
			} // End switch().
			return $vamico_tax_options;
		}
	}
} // End if().

$vamico_theme_ob = new Vamico_Theme_Functions();

/**
 * function vamico_theme_setup()
 */
if ( ! function_exists( 'vamico_theme_setup' ) ) {

	function vamico_theme_setup() {
		// Make theme available for translation
		load_theme_textdomain( 'vamico', get_theme_file_uri() . '/languages' );
		add_filter( 'posts_where', 'vamico_multi_tax_terms' );
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Add custom image sizes
		add_image_size( 'vamico-extra-large', 1920, '', false );
		add_image_size( 'vamico-large-horizontal', 1280, 720, true );
		add_image_size( 'vamico-large-vertical', 920, 1280, true );
		add_image_size( 'vamico-large-square', 1280, 1280, true );
		add_image_size( 'vamico-medium-uncropped', 720, '', false );
		add_image_size( 'vamico-medium-horizontal', 720, 280, true );
		add_image_size( 'vamico-medium-vertical', 540, 720, true );
		add_image_size( 'vamico-medium-square', 720, 720, true );
		add_image_size( 'vamico-small-square', 150, 150, true );
	}
	add_action( 'after_setup_theme', 'vamico_theme_setup' );
}

/**
* generates the html pingback head tag
* @return string the pingback head tag
*/
if ( ! function_exists( 'vamico_set_pingback_tag' ) ) {
	function vamico_set_pingback_tag( $echo = true ) {
		$output = apply_filters( 'vamico_pingback_head_tag', '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '" />' . "\n" );
		echo wp_kses( $output, array(
			'link' => array(
				'href' => true,
				'rel'  => true,
			),
		));
	}
	add_action( 'wp_head', 'vamico_set_pingback_tag', 10, 0 );
}

/**
 * Multiple taxonomies
 */
if ( ! function_exists( 'vamico_multi_tax_terms' ) ) {
	function vamico_multi_tax_terms( $where ) {
		global $wp_query, $wpdb;

		if ( isset( $wp_query->query_vars['term'] ) && ( strpos( $wp_query->query_vars['term'], ', ' ) !== false && strpos( $where, 'AND 0' ) !== false ) ) {

			/**
			 * Get the terms
			 */
			$vamico_term_array = explode( ',', $wp_query->query_vars['term'] );
			foreach ( $vamico_term_array as $term_item ) {
				$vamico_terms[] = get_terms( $wp_query->query_vars['taxonomy'], array(
					'slug' => $term_item,
				));
			}

			/**
			 * get the id of posts with that term in that taxonomy.
			 */
			foreach ( $vamico_terms as $term ) {
				if ( $term ) {
					$vamico_term_ids[] = $term[0]->term_id;
				}
			} // End foreach().

			$vamico_post_ids = get_objects_in_term( $vamico_term_ids, $wp_query->query_vars['taxonomy'] );

			if ( ! is_wp_error( $vamico_post_ids ) && count( $vamico_post_ids ) ) {
				// Build the new query
				$vamico_postids_where = " AND $wpdb->posts.ID IN ('. implode(', ', $vamico_post_ids) . ') ";
				$where                = str_replace( 'AND 0', $vamico_postids_where, $where );
			}
		} // End if().

		return $where;
	}
} // End if().

/**
 * function vamico_get_attachment_id_from_src()
 */
if ( ! function_exists( 'vamico_get_attachment_id_from_src' ) ) {
	function vamico_get_attachment_id_from_src( $image_src ) {
		global $wpdb;
		$id = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid = %s", $image_src ) );
		return $id;
	}
}


/**
 * Theme Demo Importer
 */
function vamico_ocdi_import_files() {
	return array(
		array(
			'import_file_name'         => esc_html__( 'Vamico Demo', 'vamico' ),
			'local_import_file'        => trailingslashit( get_theme_file_path() ) . '/theme-demo/main-demo/Sample-Data.xml',
			'local_import_widget_file' => trailingslashit( get_theme_file_path() ) . '/theme-demo/main-demo/widget_data.wie',
			'import_preview_image_url' => trailingslashit( get_theme_file_uri() ) . 'screenshot.png',
			'import_notice'            => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'vamico' ),
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'vamico_ocdi_import_files' );

function vamico_ocdi_after_import_setup() {
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
add_action( 'pt-ocdi/after_import', 'vamico_ocdi_after_import_setup' );

/**
 * Registers an editor stylesheet for the theme.
 */
function vamico_theme_add_editor_styles() {
	add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'vamico_theme_add_editor_styles' );

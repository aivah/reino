<?php
if ( ! class_exists( 'Vamico_Generator_Class' ) ) {
	class Vamico_Generator_Class {

		// P R I M A R Y   M E N U
		//--------------------------------------------------------
		function vamico_primary_menu() {
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu(array(
					'container'     => false,
					'theme_location' => 'primary-menu',
					'menu_class'    => 'sf-menu menu menubar',
					'menu_id'       => '',
					'echo'          => true,
					'before'        => '',
					'after'         => '',
					'link_before'   => '',
					'link_after'    => '',
					'depth'         => 0,
					'walker'        => new Vamico_Custom_Menu_Walker(),
				));
			} else {
				echo '<ul class="iva_menu sf-menu"><li><a href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">' . esc_html__( 'Primary Menu is not assigned or created.', 'vamico' ) . '</a></li></ul>';
			}
		}
		// S E C O N D A R Y   M E N U
		//--------------------------------------------------------
		function vamico_secondary_menu() {
			if ( has_nav_menu( 'secondary-menu' ) ) {
				wp_nav_menu(array(
					'container'     => false,
					'theme_location' => 'secondary-menu',
					'menu_class'    => 'sec-menu',
					'menu_id'       => '',
					'echo'          => true,
					'before'        => '',
					'after'         => '',
					'link_before'   => '',
					'link_after'    => '',
					'depth'         => 0,
					'walker'        => new Vamico_Custom_Menu_Walker(),
				));
			} else {
				echo '<ul class="iva_menu sf-menu"><li><a href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">' . esc_html__( 'Secondary Menu is not assigned or created.', 'vamico' ) . '</a></li></ul>';
			}
		}
		function vamico_mobile_menu() {
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu(array(
					'container'     => 'div',
					'container_class' => 'iva-mobile-menu',
					'theme_location' => 'primary-menu',
					'menu_class' => '',
					'echo'          => true,
					'before'        => '',
					'after'         => '',
					'link_before'   => '',
					'link_after'    => '',
					'depth'         => 0,
					'walker'        => new Vamico_Mobile_Custom_Menu_Walker(),
				));
			}
		}

		// L O G O   G E N E R A T O R
		//--------------------------------------------------------
		function vamico_logo( $vamico_logoid ) {
			$vamico_logo = get_option( 'vamico_logo' );
			if ( 'logo' == $vamico_logo ) {
				$vamico_img_attachment_id = vamico_get_attachment_id_from_src( get_option( $vamico_logoid ) );
				$vamico_image_attributes  = wp_get_attachment_image_src( $vamico_img_attachment_id , 'full' ); // returns an array
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" class="iva-logo-link">
					<img src="<?php echo esc_url( $vamico_image_attributes[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"  width="<?php echo esc_attr( $vamico_image_attributes[1] ); ?>" height="<?php echo esc_attr( $vamico_image_attributes[2] ); ?>" />
				</a>
				<?php
			} else { ?>
				<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 id="site-description"><?php echo bloginfo( 'description' ); ?></h2>
				<?php
			}
		}
		// S I D E B A R   P O S I T I O N S
		//--------------------------------------------------------
		function vamico_sidebar_option( $postid ) {
			// Get sidebar class and adds sub class to pagemid block layout
			$vamico_sidebar_layout = get_option( 'vamico_defaultlayout' ) ? get_option( 'vamico_defaultlayout' ) : 'rightsidebar';
			$vamico_archive_layout = get_option( 'vamico_archive_layout' ) ? get_option( 'vamico_archive_layout' ) : 'rightsidebar';
			$vamico_author_layout  = get_option( 'vamico_author_layout' ) ? get_option( 'vamico_author_layout' ) : 'rightsidebar';
			$vamico_sidebaroption  = get_post_meta( $postid, 'vamico_sidebar_options', true ) ? get_post_meta( $postid, 'vamico_sidebar_options', true ) : $vamico_sidebar_layout;

			switch ( $vamico_sidebaroption ) {
				case 'rightsidebar':
					$vamico_sidebaroption = 'rightsidebar';
					break;
				case 'leftsidebar':
					$vamico_sidebaroption = 'leftsidebar';
					break;
				case 'fullwidth':
					$vamico_sidebaroption = 'fullwidth';
					break;
				default:
					$vamico_sidebaroption = $vamico_sidebaroption;
			}

			if ( is_archive() ) {
				$vamico_sidebaroption = $vamico_archive_layout;
			}
			if ( is_404() ) {
				$vamico_sidebaroption = 'fullwidth';
			}

			if ( is_author() ) {
				$vamico_sidebaroption = $vamico_author_layout;
			}
			return $vamico_sidebaroption;
		}

		/***
		 * P O S T   L I N K   T Y P E
		 *--------------------------------------------------------
		 * vamico_post_link_to - generates URL based on link type
		 * @param - string link_type - Type of link
		 * @return - string URL
		 *
		 */
		function vamico_post_link_to( $vamico_link_type ) {

			global $post;

			//use switch to generate URL based on link type
			switch ( $vamico_link_type ) {
				case 'linkpage':
					return get_page_link( get_post_meta( $post->ID, 'vamico_linkpage', true ) );
					break;
				case 'linktocategory':
					return get_category_link( get_post_meta( $post->ID, 'vamico_linktocategory', true ) );
					break;
				case 'linktopost':
					return get_permalink( get_post_meta( $post->ID, 'vamico_linktopost', true ) );
					break;
				case 'linkmanually':
					return esc_url( get_post_meta( $post->ID, 'vamico_linkmanually', true ) );
					break;
				case 'nolink':
					return 'nolink';
					break;
			}
		}

		// A B O U T   A U T H O R
		//--------------------------------------------------------
		function vamico_about_author() {
			$vamico_author_style = get_option( 'vamico_author_style' ) ? get_option( 'vamico_author_style' ) : '';
			if ( '' !== get_the_author_meta( 'description' ) ) { ?>
				<div class="post__author <?php echo esc_attr( $vamico_author_style ); ?>">
					<div class="author__avatar"><?php echo get_avatar( get_the_author_meta( 'email' ), $size = '100', $default = '' ); ?></div>
					<div class="author__description">
						<div class="author__label"><?php echo esc_html__( 'Posted By', 'vamico' ); ?></div>
						<h4><?php echo the_author_posts_link(); ?></h4>
						<?php
						echo '<ul class="at__social">';
						if ( get_the_author_meta( 'facebook' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://facebook.com/' . esc_url( get_the_author_meta( 'facebook' ) ) . '"><i class="fa fa-facebook"></i></a></li>';
						endif;
						if ( get_the_author_meta( 'twitter' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://twitter.com/' . esc_url( get_the_author_meta( 'twitter' ) ) . '"><i class="fa fa-twitter"></i></a></li>';
						endif;
						if ( get_the_author_meta( 'instagram' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://instagram.com/' . esc_url( get_the_author_meta( 'instagram' ) ) . '"><i class="fa fa-instagram"></i></a></li>';
						endif;
						if ( get_the_author_meta( 'google' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://plus.google.com/' . esc_url( get_the_author_meta( 'google' ) ) . '?rel=author"><i class="fa fa-google-plus"></i></a></li>';
						endif;
						if ( get_the_author_meta( 'pinterest' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://pinterest.com/' . esc_url( get_the_author_meta( 'pinterest' ) ) . '"><i class="fa fa-pinterest"></i></a></li>';
						endif;
						if ( get_the_author_meta( 'tumblr' ) ) :
							echo '<li><a target="_blank" class="author__social" href="http://' . esc_url( get_the_author_meta( 'tumblr' ) ) . '.tumblr.com/"><i class="fa fa-tumblr"></i></a></li>';
						endif;
						echo '</ul>';
						?>
						<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
					</div>
				</div>
				<?php
			}
		}
		// Navigation for single posts
		//--------------------------------------------------------
		function vamico_single_navigation() {
			$previous_post = get_previous_post();
			$next_post = get_next_post();
			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'vamico' ),
				) );
			}
			if ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav">' . __( 'Next Article:', 'vamico' ) . '</span>%title',
					'prev_text' => '<span class="meta-nav">' . __( 'Previous Article:', 'vamico' ) . '</span>%title',
				) );
			}
		}

		// R E L A T E D   P O S T S
		//--------------------------------------------------------
		function vamico_related_posts() {

			global $post;

			do_action( 'vamico_theme_owlslider', $post->ID );

			$vamico_related_limit = get_option( 'vamico_related_limit' )
									? get_option( 'vamico_related_limit' )
									: 3;

			$exclude_post = $post->ID;
			// Array to store post IDs that will be used to stop duplicates
			// SRC: http://wpengineer.com/1719/filter-duplicate-posts-in-the-loop/
			$do_not_duplicate = array();

			// Get all the categories for the current post
			$post_categories = wp_get_post_categories( $post->ID );

			$vamico_post_args = array(
				'category__in'   => $post_categories,
				'post_type'      => array( 'post' ),
				'posts_per_page' => 12,
				'post_status'    => 'publish',
				// Don't show the current post
				'post__not_in'   => array( $exclude_post ),
			);

			$vamico_related_query = new WP_Query( $vamico_post_args );

			if ( $vamico_related_query->have_posts() ) {
				echo '<h3 class="related__posts-title">' . esc_html__( 'You might also like', 'vamico' ) . '</h3>';
				echo '<div class="owl-carousel post__related" id="owl-carousel-related">';
				while ( $vamico_related_query->have_posts() ) {
					$vamico_related_query->the_post();
					// Check var $do_not_duplicate array for duplicate IDs
					if ( !in_array( $post->ID, $do_not_duplicate ) ) {

						// Add post ID to var $do_not_duplicate array
						$do_not_duplicate[] = $post->ID;

						if ( has_post_thumbnail() ) {
							echo '<article id="post-' . $post->ID . '" class="' . join( ' ', get_post_class( 'post__related-item' ) ) . '">';
							if ( has_post_thumbnail() ) {
								echo '<div class="post__thumbnail">';
								echo get_the_post_thumbnail( $post->ID, 'vamico-small-square' );
								echo '<div class="post__thumbnail-meta">';
								vamico_the_post_meta( array( 'readtime', 'views' ), true );
								echo '</div>';//.post__thumbnail-meta
								echo '<a class="hover__link" href="' . esc_url( get_permalink( $post->ID ) ) . '"></a>';
								echo '</div>';//.post__thumbnail
							}
							echo '<h2 class="entry-title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . get_the_title() . '</a></h2>';
							if ( get_option( 'vamico_postmeta' ) !== 'on' ) {
								vamico_the_post_meta( array( 'date' ) );
							}
							echo '</article>';
						}
					}
				}
				echo '</div>'; //.post__related
			}
			wp_reset_postdata();
		}
	}
	// end class
}

/**
* Description Walker Class for Custom Menu
*/
//http://code.tutsplus.com/tutorials/understanding-the-walker-class--wp-25401
class Vamico_Custom_Menu_Walker extends Walker_Nav_Menu {

	// columns
	var $columns  = 0;
	var $max_columns = 0;
	// rows
	var $rows   = 1;
	var $arows   = array();
	// mega menu
	var $vamico_megamenu = 0;

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );

		if ( $depth == 0 && $this->iva_megamenu ) {
			 $output .= "\n$indent<div class=\"sf-mega\"><div class=\"sf-mega-wrap\">\n";
		} else {
			$output .= "\n$indent<ul>\n";
		}
	}


	function end_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );

		if ( $depth == 0 && $this->iva_megamenu ) {
			$output .= "$indent</div></div>\n";
		} else {
			$output .= "$indent</ul>\n";
		}

		if ( $depth == 0 ) {

			if ( $this->iva_megamenu ) {
				$output = str_replace( '{menu_ul_class}', ' sf-mega-section mmcol-' . $this->max_columns, $output );
				foreach ( $this->arows as $row => $columns ) {
					$output = str_replace( '{menu_li_class_' . $row . '}', 'sf-mega-section mmcol-' . $columns, $output );
				}

				$this->columns = 0;
				$this->max_columns = 0;
				$this->arows = array();
			} else {
				$output = str_replace( '{menu_ul_class}', '', $output );
			}
		}
	}

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

		global $wp_query;

		$object_output = $column_class = $li_text_block_class = '';

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		$class = array();

		if ( $depth == '0' ) {
			$this->iva_megamenu	= get_post_meta( $object->ID, 'menu-item-iva-megamenu', true );
			if ( $this->iva_megamenu == 'on' ) {
				$li_text_block_class = 'iva-megamenu ';
			}
		}

		if ( $depth == 1 && $this->iva_megamenu ) {

			$this->columns ++;
			$this->arows[ $this->rows ] = $this->columns;

			if ( $this->max_columns < $this->columns ) {$this->max_columns = $this->columns;}

			$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
			$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
			$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
			$attributes .= ! empty( $object->url ) ? ' href="' . esc_url( $object->url ) . '"' : '';

			$prepend = $append = $description = '';

			$description  = ! empty( $object->attr_title ) ? '<span class="menu-info">' . esc_attr( $object->attr_title ) . '</span>' : '';

			if ( $depth != 0 ) {
				$description = $append = $prepend = '';
			}
			$object_output = $args->before;
			$object_output .= '<a' . $attributes . ' class="col_title">';
			$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
			$object_output .= $description . $args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;
			$column_class = ' {menu_li_class_' . $this->rows . '}';
		} else {
			$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
			$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
			$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
			$attributes .= ! empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';

			$prepend = $append = $description = '';

			$description  = ! empty( $object->attr_title ) ? '<span class="menu-info">' . esc_attr( $object->attr_title ) . '</span>' : '';

			if ( $depth != 0 ) {
				 $description = $append = $prepend = '';
			}
			$object_output = $args->before;
			$object_output .= '<a ' . $attributes . '>';
			$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
			$object_output .= $description . $args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;
		}

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$class_names = apply_filters( 'nav_menu_css_class', array_filter( $classes ) );

		foreach ( $class_names as $key => $values ) {
			if ( $key != '0' ) {
				$class[] .= $values;
			}
		}

		$class[] .= $classes['0'];
		$class_names = join( ' ',$class );
		$class_names = ' class="' . $li_text_block_class . esc_attr( $class_names ) . $column_class . '"';

		if ( $depth == 1 && $this->iva_megamenu ) {
			$output .= $indent . '<div id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
		} else {
			$output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
		}
		$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
	}

	function end_el( &$output, $object, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );
		if ( $depth == 1 && $this->iva_megamenu ) {
			$output .= "$indent</div>\n";
		} else {
			$output .= "$indent</li>\n";
		}
	}
}


/**
 * Description Walker Class for Mobile Menu
 */
class Vamico_Mobile_Custom_Menu_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $object, $depth = 4, $args = array(), $current_object_id = 0 ) {

		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;
		$class = array();
		$class_names = apply_filters( 'nav_menu_css_class', array_filter( $classes ) );

		foreach ( $class_names as $key => $values ) {
			if ( $key != '0' ) {
				$class[] .= $values;
			}
		}
		$custommneu_class = join( ' ',$class );
		$class_menu = ' class="' . esc_attr( $custommneu_class ) . '"';
		$output .= $indent . '<li id="mobile-menu-item-' . $object->ID . '"' . $value . $class_menu . '>';

		$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
		$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
		$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
		$attributes .= ! empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';

		$prepend = $append = '';

		$description  = ! empty( $object->attr_title ) ? '<span class="msubtitle">' . esc_attr( $object->attr_title ) . '</span>' : '';

		if ( $depth != 0 ) {
			 $description = $append = $prepend = '';
		}

		$object_output = $args->before;
		$object_output .= '<a' . $attributes . '>';

		if ( $classes['0'] != '' ) {
			$object_output .= '<i class="iva_menuicon fa ' . $classes['0'] . ' fa-lg"></i>';
		}

		$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
		$object_output .= $description . $args->link_after;

		if ( 'primary-menu' == $args->theme_location ) {
			$submenus = 0 == $depth || (1 == $depth || 2 == $depth ) ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $object->ID, 'fields' => 'ids' ) ) ) ) : false;
			$object_output .= ! empty( $submenus ) ? ( 0 == $depth ? '<span class="iva-children-indenter"><i class="fa fa-angle-down"></i></span>' : '<span class="iva-children-indenter"><i class="fa fa-angle-down"></i></span>' ) : '';
		}

		$object_output .= '</a>';
		$object_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
	}
}
// W R I T E   G E N E R A T O R
//--------------------------------------------------------

/**
 * function vamico_generator()
 * link @ http://php.net/manual/en/function.call-user-func-array.php
 * link @ http://php.net/manual/en/function.func-get-args.php
 */
function vamico_generator( $function ) {

	global $vamico_generator;

	$vamico_generator = new Vamico_Generator_Class;
	$vamico_args = array_slice( func_get_args(), 1 );

	return call_user_func_array( array( &$vamico_generator, $function ), $vamico_args );
}

// C U S T O M   C O M M E N T   T E M P L A T E
//--------------------------------------------------------

function vamico_custom_comment( $comment, $args, $depth ) {

	global $post;

	switch ( $comment->comment_type ) :
		case 'pingback':
		case 'trackback':
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php esc_html_e( 'Pingback:', 'vamico' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'vamico' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
			break;
		default:
			// Proceed with normal comments.
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<header class="comment-meta comment-author vcard">
					<?php
						echo get_avatar( $comment, 60 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . esc_html__( 'Post author', 'vamico' ) . '</span>' : ''
						);
						echo '<div class="comment-metadata">';
						printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( esc_html__( '%1$s at %2$s', 'vamico' ), get_comment_date(), get_comment_time() )
						);

						edit_comment_link( esc_html__( 'Edit', 'vamico' ), '<span class="edit-link">', '</span>' );
						echo '</div>';
					?>
				</header><!-- .comment-meta -->
				<div class="comment-content">
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'vamico' ); ?></p>
					<?php endif; ?>
					<?php comment_text(); ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</div><!-- .comment-content -->
			</div><!-- #comment-## -->
			<?php
			break;
	endswitch; // end comment_type check
}

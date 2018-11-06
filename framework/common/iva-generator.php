<?php

// Commonly used functions Class

if ( ! class_exists( 'Reino_Generator_Class' ) ) {
	class Reino_Generator_Class {

		// Primary Meun Customization
		public function reino_primary_menu() {
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu(
					array(
						'container'      => false,
						'theme_location' => 'primary-menu',
						'menu_class'     => 'sf-menu menu menubar',
						'menu_id'        => '',
						'echo'           => true,
						'before'         => '',
						'after'          => '',
						'link_before'    => '',
						'link_after'     => '',
						'depth'          => 0,
						'walker'         => new Reino_Custom_Menu_Walker(),
					)
				);
			} else {
				echo '<ul class="iva_menu sf-menu"><li><a href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">' . esc_html__( 'Primary Menu is not assigned or created.', 'reino' ) . '</a></li></ul>';
			}
		}
		// S E C O N D A R Y   M E N U
		//--------------------------------------------------------
		public function reino_secondary_menu() {
			if ( has_nav_menu( 'secondary-menu' ) ) {
				wp_nav_menu(
					array(
						'container'      => false,
						'theme_location' => 'secondary-menu',
						'menu_class'     => 'sec-menu',
						'menu_id'        => '',
						'echo'           => true,
						'before'         => '',
						'after'          => '',
						'link_before'    => '',
						'link_after'     => '',
						'depth'          => 0,
						'walker'         => new Reino_Custom_Menu_Walker(),
					)
				);
			} else {
				echo '<ul class="sec-menu sf-menu"><li><a href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">' . esc_html__( 'Secondary Menu is not assigned or created.', 'reino' ) . '</a></li></ul>';
			}
		}
		public function reino_mobile_menu() {
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu(array(
					'container'       => 'div',
					'container_class' => 'iva-mobile-menu',
					'theme_location'  => 'primary-menu',
					'menu_class'      => '',
					'echo'            => true,
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'depth'           => 0,
					'walker'          => new Reino_Mobile_Custom_Menu_Walker(),
				));
			}
		}

		// L O G O   G E N E R A T O R
		//--------------------------------------------------------
		public function reino_logo( $reino_logoid ) {
			$reino_logo = get_option( 'reino_logo' );
			if ( 'logo' === $reino_logo ) {
				$reino_img_attachment_id = reino_get_attachment_id_from_src( get_option( $reino_logoid ) );
				$reino_image_attributes  = wp_get_attachment_image_src( $reino_img_attachment_id, 'full' ); // returns an array
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" class="iva-logo-link">
					<img src="<?php echo esc_url( $reino_image_attributes[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"  width="<?php echo esc_attr( $reino_image_attributes[1] ); ?>" height="<?php echo esc_attr( $reino_image_attributes[2] ); ?>" />
				</a>
				<?php
			} else {
				?>
				<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 id="site-description"><?php echo bloginfo( 'description' ); ?></h2>
				<?php
			}
		}
		// S I D E B A R   P O S I T I O N S
		//--------------------------------------------------------
		public function reino_sidebar_option( $postid ) {
			// Get sidebar class and adds sub class to pagemid block layout
			$reino_sidebar_layout = get_option( 'reino_defaultlayout' ) ? get_option( 'reino_defaultlayout' ) : 'rightsidebar';
			$reino_archive_layout = get_option( 'reino_archive_layout' ) ? get_option( 'reino_archive_layout' ) : 'rightsidebar';
			$reino_author_layout  = get_option( 'reino_author_layout' ) ? get_option( 'reino_author_layout' ) : 'rightsidebar';
			$reino_sidebaroption  = get_post_meta( $postid, 'reino_sidebar_options', true ) ? get_post_meta( $postid, 'reino_sidebar_options', true ) : $reino_sidebar_layout;

			switch ( $reino_sidebaroption ) {
				case 'rightsidebar':
					$reino_sidebaroption = 'rightsidebar';
					break;
				case 'leftsidebar':
					$reino_sidebaroption = 'leftsidebar';
					break;
				case 'fullwidth':
					$reino_sidebaroption = 'fullwidth';
					break;
				default:
					$reino_sidebaroption = $reino_sidebaroption;
			}

			if ( is_archive() ) {
				$reino_sidebaroption = $reino_archive_layout;
			}
			if ( is_404() ) {
				$reino_sidebaroption = 'fullwidth';
			}

			if ( is_author() ) {
				$reino_sidebaroption = $reino_author_layout;
			}
			return $reino_sidebaroption;
		}

		/***
		 * P O S T   L I N K   T Y P E
		 *--------------------------------------------------------
		 * reino_post_link_to - generates URL based on link type
		 * @param - string link_type - Type of link
		 * @return - string URL
		 *
		 */
		public function reino_post_link_to( $reino_link_type ) {

			global $post;

			//use switch to generate URL based on link type
			switch ( $reino_link_type ) {
				case 'linkpage':
					return get_page_link( get_post_meta( $post->ID, 'reino_linkpage', true ) );
					break;
				case 'linktocategory':
					return get_category_link( get_post_meta( $post->ID, 'reino_linktocategory', true ) );
					break;
				case 'linktopost':
					return get_permalink( get_post_meta( $post->ID, 'reino_linktopost', true ) );
					break;
				case 'linkmanually':
					return esc_url( get_post_meta( $post->ID, 'reino_linkmanually', true ) );
					break;
				case 'nolink':
					return 'nolink';
					break;
			}
		}

		// A B O U T   A U T H O R
		//--------------------------------------------------------
		public function reino_about_author() {
			$reino_author_style = get_option( 'reino_author_style' ) ? get_option( 'reino_author_style' ) : '';
			if ( '' !== get_the_author_meta( 'description' ) ) {
				?>
				<div class="post__author <?php echo esc_attr( $reino_author_style ); ?>">
				<div class="post__author-meta">
					<?php
					echo get_avatar(
						get_the_author_meta( 'email' ),
						$size    = '100',
						$default = ''
					);
					?>
					<div class="author__label"><?php echo esc_html__( 'Posted By', 'reino' ); ?></div>
					<h4><?php echo the_author_posts_link(); ?></h4>
					<?php
					$protocol = ( is_ssl() ) ? 'https://' : 'http://';

					echo '<ul class="at__social is-rounded">';
					if ( get_the_author_meta( 'facebook' ) ) :
						echo '<li class="facebook"><a target="_blank" href="' . $protocol . 'facebook.com/' . esc_url( get_the_author_meta( 'facebook' ) ) . '"><i class="fa fa-fw fa-facebook"></i></a></li>';
					endif;
					if ( get_the_author_meta( 'twitter' ) ) :
						echo '<li class="twitter"><a target="_blank" href="' . $protocol . 'twitter.com/' . esc_url( get_the_author_meta( 'twitter' ) ) . '"><i class="fa fa-fw fa-twitter"></i></a></li>';
					endif;
					if ( get_the_author_meta( 'instagram' ) ) :
						echo '<li class="instagram"><a target="_blank" href="' . $protocol . 'instagram.com/' . esc_url( get_the_author_meta( 'instagram' ) ) . '"><i class="fa fa-fw fa-instagram"></i></a></li>';
					endif;
					if ( get_the_author_meta( 'google' ) ) :
						echo '<li class="google-plus"><a target="_blank" href="' . $protocol . 'plus.google.com/' . esc_url( get_the_author_meta( 'google' ) ) . '?rel=author"><i class="fa fa-fw fa-google-plus"></i></a></li>';
					endif;
					if ( get_the_author_meta( 'pinterest' ) ) :
						echo '<li class="pinterest-p"><a target="_blank" href="' . $protocol . 'pinterest.com/' . esc_url( get_the_author_meta( 'pinterest' ) ) . '"><i class="fa fa-fw fa-pinterest-p"></i></a></li>';
					endif;
					if ( get_the_author_meta( 'tumblr' ) ) :
						echo '<li class="tumblr"><a target="_blank" href="' . $protocol . esc_url( get_the_author_meta( 'tumblr' ) ) . '.tumblr.com/"><i class="fa fa-fw fa-tumblr"></i></a></li>';
					endif;
					echo '</ul>';
					?>
					</div>
					<div class="post__author-desc">
						<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
					</div>
				</div>
				<?php
			}
		}
		// Navigation for single posts
		//--------------------------------------------------------
		public function reino_single_navigation() {
			$previous_post = get_previous_post();
			$next_post     = get_next_post();
			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'reino' ),
				) );
			}
			if ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav">' . __( 'Next Article:', 'reino' ) . '</span>%title',
					'prev_text' => '<span class="meta-nav">' . __( 'Previous Article:', 'reino' ) . '</span>%title',
				) );
			}
		}

		// R E L A T E D   P O S T S
		//--------------------------------------------------------
		public function reino_related_posts() {

			global $post;

			$reino_related_limit = get_option( 'reino_related_limit' )
								? get_option( 'reino_related_limit' )
								: 3;

			$exclude_post = $post->ID;
			// Array to store post IDs that will be used to stop duplicates
			// SRC: http://wpengineer.com/1719/filter-duplicate-posts-in-the-loop/
			$do_not_duplicate = array();

			// Get all the categories for the current post
			$tags = wp_get_post_tags( $post->ID );
			// If the post has tags, run the related post tag query
			if ( $tags ) {
				$tag_ids = array();
				foreach ( $tags as $individual_tag ) {
					$tag_ids[] = $individual_tag->term_id;
				}
				// Build our tag related custom query arguments
				$reino_post_args = array(
					'tag__in'        => $tag_ids, // Select posts with related tags
					'posts_per_page' => 4, // Number of related posts to display
					'post__not_in'   => array( $post->ID ), // Ensure that the current post is not displayed
					'orderby'        => 'rand', // Randomize the results
				);
			} else {
				// If the post does not have tags, run the standard related posts query
				// Get all the categories for the current post
				$post_categories = wp_get_post_categories( $post->ID );

				$reino_post_args = array(
					'category__in'   => $post_categories,
					'post_type'      => array( 'post' ),
					'posts_per_page' => 12,
					'post_status'    => 'publish',
					// Don't show the current post
					'post__not_in'   => array( $exclude_post ),
				);
			}

			$reino_related_query = new WP_Query( $reino_post_args );

			if ( $reino_related_query->have_posts() ) {
				echo '<h3 class="related__posts-title">' . esc_html__( 'You might also like', 'reino' ) . '</h3>';
				echo '<div class="related__post">';
				while ( $reino_related_query->have_posts() ) {
					$reino_related_query->the_post();
					// Check var $do_not_duplicate array for duplicate IDs
					if ( ! in_array( $post->ID, $do_not_duplicate ) ) {

						// Add post ID to var $do_not_duplicate array
						$do_not_duplicate[] = $post->ID;

						echo '<article id="post-' . esc_attr( $post->ID ) . '" class="' . join( ' ', get_post_class() ) . '">';
						echo '<div class="related__post-item">';
						if ( has_post_thumbnail() ) {
							echo '<div class="related__post-thumb post__thumbnail">';
							echo get_the_post_thumbnail( $post->ID, 'reino-small-square' );
							echo '</div>';//.post__thumbnail
						}
						echo '<div class="related__post-details">';
						echo '<h2 class="entry-title"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . get_the_title() . '</a></h2>';
						if ( get_option( 'reino_postmeta' ) !== 'on' ) {
							reino_the_post_meta( array( 'date', 'readtime', 'views' ), false );
						}
						echo '</div>';
						echo '</div>';
						echo '</article>';
					}
				}
				echo '</div>'; //.related__post
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
class Reino_Custom_Menu_Walker extends Walker_Nav_Menu {

	// columns
	var $columns      = 0;
	var $max_columns  = 0;
	// rows
	var $rows         = 1;
	var $arows        = array();
	// mega menu
	var $iva_megamenu = 0;

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth && $this->iva_megamenu ) {
			$output .= "\n$indent<div class=\"sf-mega\"><div class=\"sf-mega-wrap\">\n";
		} else {
			$output .= "\n$indent<ul>\n";
		}
	}


	public function end_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth && $this->iva_megamenu ) {
			$output .= "$indent</div></div>\n";
		} else {
			$output .= "$indent</ul>\n";
		}

		if ( 0 === $depth ) {

			if ( $this->iva_megamenu ) {
				$output = str_replace( '{menu_ul_class}', ' sf-mega-section mmcol-' . $this->max_columns, $output );
				foreach ( $this->arows as $row => $columns ) {
					$output = str_replace( '{menu_li_class_' . $row . '}', 'sf-mega-section mmcol-' . $columns, $output );
				}

				$this->columns     = 0;
				$this->max_columns = 0;
				$this->arows       = array();
			} else {
				$output = str_replace( '{menu_ul_class}', '', $output );
			}
		}
	}

	public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

		global $wp_query;

		$object_output       = '';
		$column_class        = '';
		$li_text_block_class = '';

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		$class = array();

		if ( 0 === $depth ) {
			$this->iva_megamenu = get_post_meta( $object->ID, 'menu-item-iva-megamenu', true );
			if ( 'on' === $this->iva_megamenu ) {
				$li_text_block_class = 'iva-megamenu ';
			}
		}

		if ( 1 === $depth && $this->iva_megamenu ) {

			$this->columns ++;
			$this->arows[ $this->rows ] = $this->columns;

			if ( $this->max_columns < $this->columns ) {
				$this->max_columns = $this->columns;
			}

			$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
			$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
			$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
			$attributes .= ! empty( $object->url ) ? ' href="' . esc_url( $object->url ) . '"' : '';

			$prepend     = '';
			$append      = '';
			$description = '';

			$description = ! empty( $object->attr_title ) ? '<span class="menu-info">' . esc_attr( $object->attr_title ) . '</span>' : '';

			if ( 0 !== $depth ) {
				$description = '';
				$append      = '';
				$prepend     = '';
			}
			$object_output  = $args->before;
			$object_output .= '<a' . $attributes . ' class="col_title">';
			$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
			$object_output .= $description . $args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;
			$column_class   = '{menu_li_class_' . $this->rows . '}';
		} else {
			$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
			$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
			$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
			$attributes .= ! empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';

			$prepend     = '';
			$append      = '';
			$description = '';

			$description = ! empty( $object->attr_title ) ? '<span class="menu-info">' . esc_attr( $object->attr_title ) . '</span>' : '';

			if ( 0 !== $depth ) {
				$description = '';
				$append      = '';
				$prepend     = '';
			}
			$object_output  = $args->before;
			$object_output .= '<a ' . $attributes . '>';
			$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
			$object_output .= $description . $args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;
		}

		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = '';
		$value       = '';
		$class_names = apply_filters( 'nav_menu_css_class', array_filter( $classes ) );

		foreach ( $class_names as $key => $values ) {
			if ( 0 !== $key ) {
				$class[] .= $values;
			}
		}

		$class[]    .= $classes['0'];
		$class_names = join( ' ', $class );
		$class_names = ' class="' . $li_text_block_class . esc_attr( $class_names ) . $column_class . '"';

		if ( 1 === $depth && $this->iva_megamenu ) {
			$output .= $indent . '<div id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
		} else {
			$output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
		}
		$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );
	}

	public function end_el( &$output, $object, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );
		if ( 1 === $depth && $this->iva_megamenu ) {
			$output .= "$indent</div>\n";
		} else {
			$output .= "$indent</li>\n";
		}
	}
}


/**
 * Description Walker Class for Mobile Menu
 */
class Reino_Mobile_Custom_Menu_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $object, $depth = 4, $args = array(), $current_object_id = 0 ) {

		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = '';
		$value       = '';

		$classes     = empty( $object->classes ) ? array() : (array) $object->classes;
		$class       = array();
		$class_names = apply_filters( 'nav_menu_css_class', array_filter( $classes ) );

		foreach ( $class_names as $key => $values ) {
			if ( 0 !== $key ) {
				$class[] .= $values;
			}
		}
		$custommneu_class = join( ' ', $class );
		$class_menu       = ' class="' . esc_attr( $custommneu_class ) . '"';
		$output          .= $indent . '<li id="mobile-menu-item-' . $object->ID . '"' . $value . $class_menu . '>';

		$attributes  = ! empty( $object->attr_title ) ? ' title="' . esc_attr( $object->attr_title ) . '"' : '';
		$attributes .= ! empty( $object->target ) ? ' target="' . esc_attr( $object->target ) . '"' : '';
		$attributes .= ! empty( $object->xfn ) ? ' rel="' . esc_attr( $object->xfn ) . '"' : '';
		$attributes .= ! empty( $object->url ) ? ' href="' . esc_attr( $object->url ) . '"' : '';

		$prepend = '';
		$append  = '';

		$description = ! empty( $object->attr_title ) ? '<span class="msubtitle">' . esc_attr( $object->attr_title ) . '</span>' : '';

		if ( 0 !== $depth ) {
			$description = '';
			$append      = '';
			$prepend     = '';
		}

		$object_output  = $args->before;
		$object_output .= '<a' . $attributes . '>';

		if ( '' !== $classes['0'] ) {
			$object_output .= '<i class="iva_menuicon fa ' . $classes['0'] . ' fa-lg"></i>';
		}

		$object_output .= $args->link_before . $prepend . apply_filters( 'the_title', $object->title, $object->ID ) . $append;
		$object_output .= $description . $args->link_after;

		if ( 'primary-menu' === $args->theme_location ) {
			$submenus = 0 == $depth || ( 1 == $depth || 2 == $depth ) ? get_posts( array('post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $object->ID, 'fields' => 'ids')))) : false;

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
 * function reino_generator()
 * link @ http://php.net/manual/en/function.call-user-func-array.php
 * link @ http://php.net/manual/en/function.func-get-args.php
 */
function reino_generator( $function ) {

	global $reino_generator;

	$reino_generator = new Reino_Generator_Class;
	$reino_args      = array_slice( func_get_args(), 1 );

	return call_user_func_array( array( &$reino_generator, $function ), $reino_args );
}

// C U S T O M   C O M M E N T   T E M P L A T E
//--------------------------------------------------------

function reino_custom_comment( $comment, $args, $depth ) {

	global $post;

	switch ( $comment->comment_type ) :
		case 'pingback':
		case 'trackback':
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php esc_html_e( 'Pingback:', 'reino' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'reino' ), '<span class="edit-link">', '</span>' ); ?></p>
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
					printf(
						'<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . esc_html__( 'Post author', 'reino' ) . '</span>' : ''
					);
					echo '<div class="comment-metadata">';
					printf(
						'<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( esc_html__( '%1$s at %2$s', 'reino' ), get_comment_date(), get_comment_time() )
					);

					edit_comment_link( esc_html__( 'Edit', 'reino' ), '<span class="edit-link">', '</span>' );
					echo '</div>';
					?>
				</header><!-- .comment-meta -->
				<div class="comment-content">
					<?php if ( 0 === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'reino' ); ?></p>
					<?php endif; ?>
					<?php comment_text(); ?>
					<div class="reply">
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => 'comment',
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								)
							)
						);
						?>
					</div><!-- .reply -->
				</div><!-- .comment-content -->
			</div><!-- #comment-## -->
			<?php
			break;
	endswitch; // end comment_type check
}

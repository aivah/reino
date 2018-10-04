<?php
/*
 * Saves new field to postmeta for navigation
 */
add_action( 'wp_update_nav_menu_item', 'vamico_custom_nav_update',10, 3 );
function vamico_custom_nav_update( $menu_id, $menu_item_db_id, $args ) {

	if ( ! isset( $_REQUEST['menu-item-iva-megamenu'][ $menu_item_db_id ] ) ) {
		$_REQUEST['menu-item-iva-megamenu'][ $menu_item_db_id ] = '';
	}

	$custom_value = $_REQUEST['menu-item-iva-megamenu'][ $menu_item_db_id ];
	update_post_meta( $menu_item_db_id, 'menu-item-iva-megamenu', $custom_value );
}

/*
 * Adds value of new field to $object object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */
add_filter( 'wp_setup_nav_menu_item','vamico_custom_nav_item' );
function vamico_custom_nav_item( $menu_item ) {
	$menu_item->custom = get_post_meta( $menu_item->ID, 'menu-item-iva-megamenu', true );
	return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'vamico_custom_nav_edit_walker',10,2 );
function vamico_custom_nav_edit_walker( $walker, $menu_id ) {
	return 'Vamico_Walker_Nav_Menu_Edit_Custom';
}

/**
 * Copied from Walker_Nav_Menu_Edit class in core
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Vamico_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {

	}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $object Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

		global $_wp_nav_menu_max_depth;

		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$object_id = esc_attr( $object->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';

		if ( 'taxonomy' == $object->type ) {
			$original_title = get_term_field( 'name', $object->object_id, $object->object, 'raw' );
			if ( is_wp_error( $original_title ) ) {
				$original_title = false;
			}
		} elseif ( 'post_type' == $object->type ) {
			$original_object = get_post( $object->object_id );
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $object->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $object_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $object->title;

		if ( ! empty( $object->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( esc_html__( '%s (Invalid)', 'vamico' ), $object->title );
		} elseif ( isset( $object->post_status ) && 'draft' == $object->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__( '%s (Pending)', 'vamico' ), $object->title );
		}

		$title = empty( $object->label ) ? $title : $object->label;

		?>
		<li id="menu-item-<?php echo esc_attr( $object_id ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $object->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $object_id,
										),
										remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e( 'Move up', 'vamico' ); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $object_id,
										),
										remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e( 'Move down', 'vamico' ); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr( $object_id ); ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'vamico' ); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $object_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $object_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $object_id ) ) );
						?>"><?php esc_html_e( 'Edit Menu Item', 'vamico' ); ?></a>
					</span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $object_id ); ?>">
				<?php if ( 'custom' == $object->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr( $object_id ); ?>">
							<?php esc_html_e( 'URL','vamico' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $object_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'Navigation Label','vamico' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $object_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'Title Attribute','vamico' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $object_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr( $object_id ); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $object_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $object_id ); ?>]"<?php checked( $object->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab','vamico' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'CSS Classes (optional)','vamico' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $object_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( implode( ' ', $object->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)','vamico' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $object_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'Description','vamico' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr( $object_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $object_id ); ?>]"><?php echo esc_html( $object->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e( 'The description will be displayed in the menu if the current theme supports it.', 'vamico' ); ?></span>
					</label>
				</p>
				<?php
				if ( 0 == $depth ) :
					 /*
					 * This is the added field
					 */
				?>
				<p class="field-custom description description-wide">
					<label for="edit-menu-item-iva-megamenu-<?php echo esc_attr( $object_id ); ?>">
						<?php esc_html_e( 'Mega Menu' ,'vamico' ); ?><br />
						<?php
						  $value = get_post_meta( $object_id, 'menu-item-iva-megamenu', true );
						if ( $value != '' ) {
							$value = "checked='checked'";
						}
						?>
						<input type="checkbox" id="edit-menu-item-iva-megamenu-<?php echo esc_attr( $object_id ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-iva-megamenu[<?php echo esc_attr( $object_id ); ?>]" <?php echo esc_attr( $value ); ?> />  <?php esc_html_e( 'Activate Mega Menu','vamico' ); ?>
					</label>
				</p>
				<?php

				/*
				 * end added field
				 */
				 endif;
				?>
				<div class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $object->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( esc_html__( 'Original: %s', 'vamico' ), '<a href="' . esc_url( $object->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $object_id ); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $object_id,
							),
							remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
						),
						'delete-menu_item_' . $object_id
					); ?>"><?php esc_html_e( 'Remove', 'vamico' ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $object_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $object_id, 'cancel' => time() ), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo esc_attr( $object_id ); ?>"><?php esc_html_e( 'Cancel', 'vamico' ); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object_id ); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $object_id ); ?>]" value="<?php echo esc_attr( $object->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
}

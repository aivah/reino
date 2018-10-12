<?php
// CUSTOM META BOXES
//--------------------------------------------------------
if ( ! class_exists( 'Reino_MetaBox_Fields' ) ) {
	class Reino_MetaBox_Fields {

		function __construct( $reino_meta_box ) {

			$this->_meta_box = $reino_meta_box;
			add_action( 'admin_menu', array( &$this, 'reino_metabox' ) );
			add_action( 'save_post', array( &$this, 'reino_metabox_save' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( &$this, 'reino_metabox_scripts' ) );
			//
			add_action( 'wp_ajax_rwmb_attach_file', array( &$this, 'reino_wp_ajax_attach_file' ) );
			add_action( 'print_media_templates', array( &$this, 'reino_print_templates' ) );
			add_action( 'wp_ajax_rwmb_delete_file', array( &$this, 'reino_wp_ajax_delete_file' ) );
			add_action( 'wp_ajax_rwmb_reorder_files', array( &$this, 'reino_wp_ajax_reorder_files' ) );
		}

		// Add meta box
		function reino_metabox() {
			foreach ( $this->_meta_box['page'] as $page ) {
				add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array( &$this, 'reino_show_metabox' ), $page, $this->_meta_box['context'], $this->_meta_box['priority'] );
			}
		}

		//  Media Library
		function reino_metabox_scripts() {
			wp_enqueue_media();
			wp_enqueue_script( 'reino-file-advance', REINO_FRAMEWORK_URI . 'admin/js/reino-file-advance.js', array( 'jquery-ui-sortable', 'wp-ajax-response' ) );
			wp_localize_script( 'reino-file-advance', 'rwmbFileAdvanced', array(
				'frameTitle' => esc_html__( 'Select Files', 'reino' ),
			) );
		}
		function reino_wp_ajax_attach_file() {
			$post_id        = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : 0;
			$field_id       = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$attachment_ids = isset( $_POST['attachment_ids'] ) ? (array) $_POST['attachment_ids'] : array();

			check_ajax_referer( 'rwmb-attach-file_{$field_id}', '_nonce' );
			foreach ( $attachment_ids as $attachment_id ) {
				add_post_meta( $post_id, $field_id, $attachment_id, false );
			}
			wp_send_json_success();
		}
		function reino_print_templates() {
			$i18n_delete = apply_filters( 'rwmb_file_delete_string', esc_html_x( 'Delete', 'file upload', 'reino' ) );
			$i18n_edit   = apply_filters( 'rwmb_file_edit_string', esc_html_x( 'Edit', 'file upload', 'reino' ) );
			?>
			<script id="tmpl-rwmb-file-advanced" type="text/html">
				<# _.each( attachments, function( attachment ) { #>
				<li class="media-item" id="item_{{{ attachment.id }}}">
					<img src="<# if ( attachment.type == 'image' ){ #>{{{ attachment.sizes.thumbnail.url }}}<# } else { #>{{{ attachment.icon }}}<# } #>">
					<div class="iva-media-item">
						<div class="iva-media-title">ID# {{{ attachment.id }}}</div></div>
						<div class="iva-media-act">
						<a class="iva-media-edt" title="<?php echo esc_attr( $i18n_edit ); ?>" href="{{{ attachment.editLink }}}" target="_blank"><?php echo esc_html( $i18n_edit ); ?></a> |
						<a title="<?php echo esc_attr( $i18n_delete ); ?>" class="rwmb-delete-file iva-media-del" href="#" data-attachment-id="{{{ attachment.id }}}"><?php echo esc_html( $i18n_delete ); ?></a>
					</div>
				</li>
				<# } ); #>
			</script>
		<?php
		}
		function reino_wp_ajax_delete_file() {
			global $post;

			$post_id       = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
			$field_id      = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;
			$force_delete  = isset( $_POST['force_delete'] ) ? $_POST['force_delete'] : '';

			check_ajax_referer( "rwmb-delete-file_{$field_id}" );

			delete_post_meta( $post_id, $field_id, $attachment_id );

			$ok = $force_delete ? wp_delete_attachment( $attachment_id ) : true;

			if ( $ok ) {
				wp_send_json_success();
			} else {
				wp_send_json_error( esc_html__( 'Error: Cannot delete file', 'reino' ) );
			}
		}
		function reino_wp_ajax_reorder_files() {

			$field_id = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$order    = isset( $_POST['order'] ) ? $_POST['order'] : '';
			$post_id  = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;

			check_ajax_referer( "rwmb-reorder-files_{$field_id}" );

			parse_str( $order, $items );

			delete_post_meta( $post_id, $field_id );

			foreach ( $items['item'] as $item ) {
				add_post_meta( $post_id, $field_id, $item, false );
			}
			wp_send_json_success();
		}
		function reino_get_uploaded_files( $files, $field ) {

			$reorder_nonce = wp_create_nonce( "rwmb-reorder-files_{$field['id']}" );
			$delete_nonce  = wp_create_nonce( "rwmb-delete-file_{$field['id']}" );

			$classes = array( 'rwmb-file', 'rwmb-uploaded' );

			$max_file_uploads = isset( $field['max_file_uploads'] ) ? $field['max_file_uploads'] : '100';
			$mime_type        = isset( $field['mime_type'] ) ? $field['mime_type'] : '';
			$force_delete     = ( isset( $field['force_delete'] ) && true === $field['force_delete'] ) ? 1 : 0;

			if ( count( $files ) <= 0 ) {
				$classes[] = 'hidden';
			}

			$ol = '<ul class="%s iva-media-list" data-field-id="%s" data-delete-nonce="%s" data-reorder-nonce="%s" data-force-delete="%s" data-max-file-uploads="%s" data-mime-type="%s">';

			$html = sprintf(
				$ol,
				implode( ' ', $classes ),
				$field['id'],
				$delete_nonce,
				$reorder_nonce,
				$force_delete,
				$max_file_uploads,
				$mime_type
			);
			foreach ( $files as $attachment_id ) {
				$attach_image = wp_attachment_is_image( $attachment_id );
				if ( $attach_image ) {
					$html .= $this->reino_file_html( $attachment_id );
				}
			}
			$html .= '</ul>';
			$html .= '<div class="clear"></div>';
			return $html;
		}

		function reino_file_html( $attachment_id ) {
			$i18n_delete = apply_filters( 'rwmb_file_delete_string', esc_html_x( 'Delete', 'file upload', 'reino' ) );
			$i18n_edit   = apply_filters( 'rwmb_file_edit_string', esc_html_x( 'Edit', 'file upload', 'reino' ) );
			$li          = '
			<li id="item_%s" class="media-item">
				%s
				<div class="iva-media-item">
					<div class="iva-media-title">ID# ' . $attachment_id . '</div>
				</div>
				<div class="iva-media-act">
					<a title="%s" href="%s" class="iva-audio-edt iva-media-edit" target="_blank">%s</a> |
					<a title="%s" class="rwmb-delete-file iva-audio-del iva-media-delete" href="#" data-attachment-id="%s">%s</a>
				</div>
			</li>';

			$mime_type = get_post_mime_type( $attachment_id );
			return sprintf(
				$li,
				$attachment_id,
				wp_get_attachment_image( $attachment_id, 'thumbnail', true, '', '' ),
				wp_get_attachment_url( $attachment_id ),
				get_edit_post_link( $attachment_id ),
				$i18n_edit,
				get_the_title( $attachment_id ),
				$attachment_id,
				$i18n_delete,
				$attachment_id,
				$i18n_delete
			);
		}

		// Callback function to show fields in meta box
		function reino_show_metabox() {

			global $page_layout, $post,$reino_meta_box;
			// Defines custom sidebar widget based on custom option
			$reino_sidebar_widget = get_option( 'reino_customsidebar' );
			$reino_page_nonce     = wp_create_nonce( 'meta-nonce' );
			// Use nonce for verification
			echo '<input type="hidden" name="page_page_layout_nonce" value="' . esc_attr( $reino_page_nonce ) . '" />';

			// M E T A B O X   W R A P
			//--------------------------------------------------------
			echo '<div class="atp_meta_options">';

			foreach ( $this->_meta_box['fields'] as $field ) {

				// get current post meta data
				$meta = get_post_meta( $post->ID, $field['id'], true );

				if ( '' === $meta ) {
					$meta = $field['std'];
				}

				if ( ! isset( $field['class'] ) ) {
					$field['class'] = '';
				}
				if ( ! isset( $field['desc'] ) ) {
					$field['desc'] = '';
				}

				// M E T A B O X   O P T I O N S
				//--------------------------------------------------------
				echo '<div class="atp_options_box ' . esc_attr( $field['class'] ) . '">',
					'<div class="atp_label"><label>' . esc_attr( $field['name'] ) . '</label>',
					'<p class="desc">',wp_kses_post( $field['desc'] ),'</p></div>',
					'<div class="atp_inputs">';
				switch ( $field['type'] ) {
					case 'text':
						echo '<input type="text" name="', esc_attr( $field['id'] ), '" id="', esc_attr( $field['id'] ), '" value="', esc_attr( $meta ) != '' ? esc_attr( $meta ) : esc_attr( $field['std'] ), '" size="30" />';
						break;
					case 'color':
						echo '<div class="meta_page_selectwrap"><input class="color"  name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" type="text" value="', esc_attr( $meta ) ? esc_attr( $meta ) : esc_attr( $field['std'] ), '"  />';
						?>
						<div id="<?php echo esc_attr( $field['id'] ); ?>_color" class="wpcolorSelector"><div></div></div></div>
						<?php
						break;
					case 'rgbacolor':
						echo '<div class="meta_page_selectwrap"><input class="iva-color-control" data-default-color="" data-palette="true" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="', $meta ? esc_attr( $meta ) : esc_attr( $field['std'] ), '" />';
						?>
						<div id="<?php echo esc_attr( $field['id'] ); ?>_color" class="iva-color-control1"><div></div></div></div>
						<?php
						break;
					case 'textarea':
						echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? esc_attr( $meta ) : esc_attr( $field['std'] ), '</textarea>';
						break;
					case 'select':
						echo '<div class="select_wrapper ', esc_attr( $field['class'] ), '"><select class="select" name="', $field['id'], '" id="', $field['id'], '">';
						foreach ( $field['options'] as $key => $value ) {
							echo '<option value="' . esc_attr( $key ) . '"', $meta == $key ? ' selected="selected"' : '', '>', $value, '</option>';
						}
						echo '</select></div>';
						break;
					case 'post_gallery_meta':
						$reino_image_gallery = '';
						echo '<div id="reino_images_container">';
						echo '<ul class="reino_images">';
						if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
							$reino_image_gallery = get_post_meta( $post->ID, $field['id'], true );
						}
						$attachments = array_filter( explode( ',', $reino_image_gallery ) );
						if ( $attachments ) {
							foreach ( $attachments as $attachment_id ) {
								echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
								<li><a href="#" class="delete tips" data-tip="' . esc_html__( 'Delete image', 'reino' ) . '">' . esc_html__( 'Delete', 'reino' ) . '</a></li>
								</ul>
								</li>';
							}
						}
						echo '</ul>';
						echo '<input type="hidden" id="reino_image_gallery" name="' . $field['id'] . '" value="' . esc_attr( $reino_image_gallery ) . '" />';
						echo '</div>';
						echo '<p class="add_reino_images hide-if-no-js">';
						echo '<a href="#" data-choose="' . esc_html__( 'Add Images to Reino Gallery', 'reino' ) . '" data-update="' . esc_html__( 'Add to gallery', 'reino' ) . '" data-delete="' . esc_html__( 'Delete image', 'reino' ) . '" data-text="' . esc_html__( 'Delete', 'reino' ) . '">' . esc_html__( 'Add reino gallery images', 'reino' ) . '</a>';
						echo '</p>';
						break;
					case 'multiselect':
						echo '<div class="select_wrapper2">';
						$count = count( $field['options'] );
						if ( $count > 0 ) {
							echo '<select multiple="multiple"  class="' , $field['id'] , '" name="' , $field['id'] , '[]" id="', $field['id'] , '[]">';
							foreach ( $field['options'] as $key => $value ) {
								echo '<option value="' . esc_attr( $key ) . '"',  ( is_array( $meta ) && in_array( $key, $meta ) ) ? ' selected="selected"' : '', '>',esc_html( $value ), '</option>';
							}
							echo '</select>';
							echo '<div class="clear"></div>';
							echo '<span class="iva_select_all button red-button button-primary button-large" data-id="' . esc_attr( $field['id'] ) . '">' . esc_html__( 'Select All', 'reino' ) . '</span>';
						} else {
							echo '<strong>' . esc_html__( 'No Posts IN Categories', 'reino' ) . '</strong>';
						}
						echo '</div>';
						break;
					case 'customselect':
						echo '<div class="select_wrapper ',esc_attr( $field['class'] ), '"><select class="select" name="', $field['id'], '" id="', $field['id'], '">';
						echo '<option value="">' . esc_html__( 'Select', 'reino' ) . '</option>';
						if ( '' !== $reino_sidebar_widget ) {
							foreach ( $field['options'] as $key => $value ) {
								echo '<option value="' . esc_attr( $value ) . '"', $meta == $value ? ' selected="selected"' : '', '>' , esc_html( $value ) , '</option>';
							}
						}
						echo '</select></div>';
						break;
					case 'upload':
						echo'<input name="' . $field['id'] . '" id="' . esc_attr( $field['id'] ) . '"  type="hidden" class="custom_upload_image" value="' . esc_attr( wp_kses_stripslashes( get_post_meta( $post->ID, $field['id'], true ) ) ) . '" />';
						echo'<input name="' . $field['id'] . '" id="' . $field['id'] . '" class="custom_upload_image_button button button-primary button-large clearfix" type="button" value="' . esc_attr__( 'Choose Image', 'reino' ) . '" />';
						echo'<div id="iva_imagepreview-' . $field['id'] . '" class="iva-screenshot">';
						if ( get_post_meta( $post->ID, $field['id'], true ) ) {

							$reino_img     = get_post_meta( $post->ID, $field['id'], true );
							$attachments_id = reino_get_attachment_id_from_src( $bg_image );

							$alt_text = get_post_meta( $attachments_id, '_wp_attachment_image_alt', true );
							if ( empty( $alt_text ) ) { // If not, Use the Caption
								$attachment = get_post( $attachments_id );
								$alt_text   = trim( strip_tags( $attachment->post_excerpt ) );
							}
							if ( empty( $alt_text ) ) { // Finally, use the title
								$attachment = get_post( $attachments_id );
								$alt_text   = trim( strip_tags( $attachment->post_title ) );
							}

							$image_attributes = wp_get_attachment_image_src( reino_get_attachment_id_from_src( $reino_img ) );
							if ( '' !== $image_attributes[0] ) {
								echo '<img src="' . esc_url( $image_attributes[0] ) . '"  class="custom_preview_image" alt="' . esc_attr( $alt_text ) . '" />';
								echo '<a href="#" class="cimage_remove button button-primary">x</a>';
							} else {
								echo '<img src="' . esc_url( $reino_img ) . '"  class="custom_preview_image" alt="' . esc_attr( $alt_text ) . '" />';
								echo '<a href="#" class="cimage_remove button button-primary">x</a>';
							}
						}
						echo '</div>';
						break;
					case 'layout':
						$i = 0;
						$select_value = $meta;
						foreach ( $field['options'] as $key => $value ) {
							$i++;
							$checked = $selected = '';
							if ( $select_value != '' ) {
								if ( $select_value == $key ) {
									$checked = ' checked';
									$selected = 'iva-radio-option-selected';
								}
							} else {
								if ( $meta == $key ) {
									$checked = ' checked';
									$selected = 'iva-radio-option-selected';
								} elseif ( $i == 1  && ! isset( $select_value ) ) {
									$checked = ' checked';
									$selected = 'iva-radio-option-selected';
								} elseif ( $i == 1  && $meta == '' ) {
									$checked = ' checked';
									$selected = 'iva-radio-option-selected';
								} else { $checked = 'checked'; }
							}
							echo '<div class="layout"><input value="' . $key . '"  class="checkbox iva-radio-img-radio" type="radio" id="' . $field['id'] . $i . '" name="' . $field['id'] . '"' . $checked . ' />';
							echo '<img src="' . esc_url( $value ) . '" alt="' . $key . '" class="iva-radio-option ' . $selected . '"  data-id="' . $field['id'] . $i . '" /><span class="label">' . $key . '</span></div>';
						}
						break;

					case 'checkbox':
						$meta != '' ? 'on' : 'off';
						echo '<input  type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta == 'on' ? ' checked="checked"' : '', ' />
						<label for="',esc_attr( $field['id'] ),'">',$field['desc'],'</label>';
						break;
					case 'background':
						$bg_color = '';
						if ( is_array( $meta ) ) {
							if ( ! empty( $meta ) ) {
								$bg_image       = $meta['0']['image'];
								$bg_color       = $meta['0']['color'];
								$bg_repeat      = $meta['0']['repeat'];
								$bg_position    = $meta['0']['position'];
								$bg_attachement = $meta['0']['attachement'];
							}
						} else {
							$bg_image = $meta;
						}

						// Position Properties Array
						$positionarray = array(
							'left top'      => esc_html__( 'Left Top', 'reino' ),
							'left center'   => esc_html__( 'Left Center', 'reino' ),
							'left bottom'   => esc_html__( 'Left Bottom', 'reino' ),
							'right top'     => esc_html__( 'Right Top', 'reino' ),
							'right center'  => esc_html__( 'Right Center', 'reino' ),
							'right bottom'  => esc_html__( 'Right Bottom', 'reino' ),
							'center top'    => esc_html__( 'Center Top', 'reino' ),
							'center center' => esc_html__( 'Center Center', 'reino' ),
							'center bottom' => esc_html__( 'Center Bottom', 'reino' ),
						);

						// Repeat Properties Array
						$repeatarray = array(
							'repeat'    => esc_html__( 'Repeat', 'reino' ),
							'no-repeat' => esc_html__( 'No-Repeat', 'reino' ),
							'repeat-x'  => esc_html__( 'Repeat-X', 'reino' ),
							'repeat-y'  => esc_html__( 'Repeat-Y', 'reino' ),
						);

						// Attachment Properties Array
						$attacharray = array(
							'scroll' => esc_html__( 'Scroll', 'reino' ),
							'fixed'  => esc_html__( 'Fixed', 'reino' ),
						);

						echo '<div class="section section-background">';

						// Upload Field
						echo '<div class="atp-background-upload clearfix">';
						echo '<input type="text"  name="' . $field['id'] . '_image" id="' . $field['id'] . '_image" class="custom_upload_image" value="' . $bg_image . '" />';
						echo '<input type="button" name="' . $field['id'] . '_image" class="custom_upload_image_button button button-primary button-large" value="' . esc_html__( 'Choose Image', 'reino' ) . '" />';
						echo '<div class="clear"></div>';
						echo '<div id="iva_imagepreview-' . $field['id'] . '_image" class="iva-screenshot">';
						if ( '' !== $bg_image ) {

							$attachments_id = reino_get_attachment_id_from_src( $bg_image );

							$alt_text = get_post_meta( $attachments_id, '_wp_attachment_image_alt', true );
							if ( empty( $alt_text ) ) { // If not, Use the Caption
								$attachment = get_post( $attachments_id );
								$alt_text   = trim( strip_tags( $attachment->post_excerpt ) );
							}
							if ( empty( $alt_text ) ) { // Finally, use the title
								$attachment = get_post( $attachments_id );
								$alt_text   = trim( strip_tags( $attachment->post_title ) );
							}

							$image_attributes = wp_get_attachment_image_src( reino_get_attachment_id_from_src( $bg_image ) );

							if ( '' !== $image_attributes[0] ) {
								echo '<img src="' . esc_url( $image_attributes[0] ) . '"  class="custom_preview_image" alt="' . esc_attr( $alt_text ) . '" />';
								echo '<a href="#" class="cimage_remove button button-primary">x</a>';
							} else {
								echo '<img src="' . esc_url( $bg_image ) . '"  class="custom_preview_image" alt="' . esc_attr( $alt_text ) . '" />';
								echo '<a href="#" class="cimage_remove button button-primary">x</a>';
							}
						}
						echo '</div></div>';

						// Color Input
						echo '<div class="atp-background-color">';
						echo '<input class="color"  name="' . $field['id'] . '_color" id="' . $field['id'] . '_color" type="text" value="' . $bg_color . '">';
						echo '<div id="' . $field['id'] . '_color" class="wpcolorSelector"><div></div></div>';
						echo '</div>';

						// Background Repeat Options Input
						echo '<div class="atp-background-repeat">';
						echo '<div class="select_wrapper">';
						echo '<select class="select" name="' . $field['id'] . '_repeat" id="' . $field['id'] . '_repeat">';
						foreach ( $repeatarray as $key => $value ) {
							$selected = ($key == $bg_repeat) ? ' selected="selected"' : '';
							echo'<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						}
						echo '</select>';
						echo '</div></div>';

						// Background Position Options Input
						echo '<div class="atp-background-position"><div class="select_wrapper">';
						echo '<select class="select" name="' . $field['id'] . '_position" id="' . $field['id'] . '_position">';
						foreach ( $positionarray as $key => $value ) {
							$selected = ( $key == $bg_position ) ? ' selected="selected"' : '';
							echo'<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						}
						echo '</select>';
						echo '</div></div>';

						// Background Attachement Options Input
						echo '<div class="atp-background-attachment"><div class="select_wrapper">';
						echo '<select class="select" name="' . $field['id'] . '_attachement" id="' . $field['id'] . '_attachement">';
						foreach ( $attacharray as $key => $value ) {
							$selected = ( $key == $bg_attachement ) ? ' selected="selected"' : '';
							echo'<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						}
						echo '</select>';
						echo '</div></div>';

						echo '</div>';
						break;
					case 'multicheckbox':
						foreach ( $field['options'] as $key => $value ) {
							echo '<div><input  type="checkbox"  ' ,( isset( $meta[ $key ] ) === $key ) ? ' checked="checked"' : '','  name="' , esc_attr( $field['id'][ $key ] ),'"    value="' , esc_attr( $key ) , '" id="' , esc_attr( $value ) , '"  /> ';
							echo '<label for="' , esc_attr( $value ) , '">' , $value , '</label></div>';
						}
						break;
					case 'default_editor':
						$editor_settings = array(
							'wpautop' 		=> true,
							'media_buttons' => true,
							'editor_class'	=> '',
							'textarea_rows' => 5,
							'tabindex' 		=> 4,
							'teeny' 		=> true,
						);
						$reino_meta_box_value = $meta ? $meta : $field['std'];
						wp_editor( $reino_meta_box_value, $field['id'],$editor_settings );
						break;
					// Media Library
					case 'medialibrary':
						global $post;
						$i18n_title   = apply_filters( 'rwmb_file_advanced_select_string', esc_html_x( 'Select or Upload Files', 'file upload', 'reino' ), $field['id'] );
						$attach_nonce = wp_create_nonce( "rwmb-attach-file_{$field['id']}" );

						// Uploaded files
						$meta = get_post_meta( $post->ID, $field['id'] );
						$medial_html = $this->reino_get_uploaded_files( $meta, $field );

						// Show form upload
						$classes = array( 'button', 'rwmb-file-advanced-upload', 'hide-if-no-js', 'new-files' );
						if ( ! empty( $field['max_file_uploads'] ) && count( $meta ) >= (int) $field['max_file_uploads'] )
						$classes[] = 'hidden';
						$classes = implode( ' ', $classes );
						$medial_html .= "<a href='#' class='{$classes}' data-attach-file-nonce={$attach_nonce}>{$i18n_title}</a>";
						echo wp_kses( $medial_html, array(
							'a'  => array(
								'class' => true,
								'title' => true,
								'href'  => true,
								'data-attach-file-nonce' => true,
								'data-attachment-id' => true,
								'target' => true,
							),
							'img' => array(
								'src'   => true,
								'alt'   => true,
								'class' => true,
								'width' => true,
								'height' => true,
							),
							'li' => array(
								'id'    => true,
								'class' => true,
							),
							'ul' => array(
								'id' => true,
								'class' => true,
								'data-field-id' => true,
								'data-delete-nonce' => true,
								'data-reorder-nonce' => true,
								'data-force-delete' => true,
								'data-mime-type' => true,
								'data-max-file-uploads' => true,
							),
							'div' => array(
								'id' => true,
								'class' => true,
							),
						));
						break;
				} // End switch().
				echo '</div><div class="clear"></div>';
				echo '</div>';
			} // End foreach().
			echo '</div>';
		}
		// E N D  - SHOW METABOX

		// S A V E   M E T A   D A T A
		//--------------------------------------------------------
		function reino_metabox_save( $post_id, $post ) {

			/* Verify the nonce before proceeding. */
			if ( ! isset( $_POST['page_page_layout_nonce'] ) || ! wp_verify_nonce( $_POST['page_page_layout_nonce'], 'meta-nonce' ) ) {
				return $post_id;
			}

			/* Get the post type object. */
			$post_type = get_post_type_object( $post->post_type );

			/* Check if the current user has permission to edit the post. */
			if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
				return $post_id;
			}
			// Is the user allowed to edit the post or page?
			foreach ( $this->_meta_box['fields'] as $field ) {

				$field_type = $field['type'] ;

				if ( $field_type == 'background' ) {
					if ( isset( $field['id'] ) && $field['id'] != '' ) {
						$bg_props = array();
						$bg_props[] = array(
							'image' 		=> isset( $_POST[ $field['id'] . '_image' ] ) ? $_POST[ $field['id'] . '_image' ]:'',
							'color' 		=> isset( $_POST[ $field['id'] . '_color' ] ) ? $_POST[ $field['id'] . '_color' ]:'',
							'repeat'		=> isset( $_POST[ $field['id'] . '_repeat' ] ) ? $_POST[ $field['id'] . '_repeat' ]:'',
							'position'		=> isset( $_POST[ $field['id'] . '_position' ] ) ? $_POST[ $field['id'] . '_position' ]:'',
							'attachement'	=> isset( $_POST[ $field['id'] . '_attachement' ] ) ? $_POST[ $field['id'] . '_attachement' ]:'',
						);
						if ( get_post_meta( $post_id, $field['id'],true ) == '' ) {
							add_post_meta( $post_id, $field['id'], $bg_props, true );
						} elseif ( $bg_props != get_post_meta( $post_id, $field['id'], true ) ) {
							update_post_meta( $post_id, $field['id'], $bg_props );
						}
					}
				}
				elseif ( $field_type == 'post_gallery_meta' ) {
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$attachment_ids = array_filter( explode( ',', sanitize_text_field( $_POST[ $field['id'] ] ) ) );
						if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {
							update_post_meta( $post_id, $field['id'], implode( ',', $attachment_ids ) );
						}
					}
				} else {
					$old = get_post_meta( $post_id, $field['id'], true );
					$new = isset( $_POST[ $field['id'] ] )? $_POST[ $field['id'] ]:'';
					if ( $field['type'] != 'medialibrary' ) {
						if ( $new != '' && $new != $old ) {
							update_post_meta( $post_id, $field['id'], $new );
						} elseif ( '' == $new && $old ) {
							delete_post_meta( $post_id, $field['id'], $old );
						}
					}
				}
			}
		}
	}
} // End if().
foreach ( $this->meta_box as $reino_meta_box ) {
	$reino_customfields = new Reino_MetaBox_Fields( $reino_meta_box );
}

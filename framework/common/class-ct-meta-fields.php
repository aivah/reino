<?php

if ( ! class_exists( 'Class_CT_Meta_Fields' ) ) {

	class Class_CT_Meta_Fields {
		public function __construct() {
			//
		}

		/*
		* Initialize the class and start calling our hooks and filters
		* @since 1.0.0
		*/
		public function init() {
			add_action( 'category_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			add_action( 'created_category', array( $this, 'save_category_image' ), 10, 2 );
			add_action( 'category_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			add_action( 'edited_category', array( $this, 'updated_category_image' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
			add_action( 'admin_footer', array( $this, 'add_script' ) );
		}

		public function load_media() {
			wp_enqueue_media();
		}

		/*
		* Add a form field in the new category page
		* @since 1.0.0
		*/
		public function add_category_image( $taxonomy ) { ?>
			<div class="form-field term-colorpicker-wrap">
				<label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'reino' ); ?></label>
				<input name="category_bg_color" value="" class="colorpicker" id="term-colorpicker" />
				<p><?php esc_html_e( 'Select the category background-color which displays in background of the Category Text.', 'reino' ); ?></p>
			</div>
			<div class="form-field term-group">
				<label for="category_image_id"><?php esc_attr( 'Category Image', 'reino' ); ?></label>
				<input type="hidden" id="category_image_id" name="category_image_id" class="custom_media_url" value="">
				<div id="category-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr( 'Add Image', 'reino' ); ?>" />
					<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr( 'Remove Image', 'reino' ); ?>" />
				</p>
				<p class="description"><?php esc_html_e( 'Select the category image which will be used in various places.', 'reino' ); ?></p>
			</div>
		<?php
		}

		/*
		* Save the form field
		* @since 1.0.0
		*/
		public function save_category_image( $term_id, $tt_id ) {

			// Save term color if possible
			if ( isset( $_POST['category_bg_color'] ) && ! empty( $_POST['category_bg_color'] ) ) {
				update_term_meta( $term_id, 'category_bg_color', sanitize_hex_color_no_hash( $_POST['category_bg_color'] ) );
			} else {
				delete_term_meta( $term_id, 'category_bg_color' );
			}

			if ( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ) {
				$image = $_POST['category_image_id'];
				add_term_meta( $term_id, 'category_image_id', $image, true );
			}
		}

		/*
		* Edit the form field
		* @since 1.0.0
		*/
		public function update_category_image( $term, $taxonomy ) {

			$color = get_term_meta( $term->term_id, 'category_bg_color', true );
			$color = ( ! empty( $color ) ) ? "#{$color}" : '';
			?>
			<tr class="form-field term-colorpicker-wrap">
				<th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'reino' ); ?></label></th>
				<td>
					<input name="category_bg_color" value="<?php echo esc_attr( $color ); ?>" class="colorpicker" id="term-colorpicker" />
					<p class="description"><?php esc_html_e( 'Select the category color which will be used in various places.', 'reino' ); ?></p>
				</td>
			</tr>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category_image_id"><?php esc_html_e( 'Category Image', 'reino' ); ?></label>
				</th>
				<td>
					<?php $image_id = get_term_meta( $term->term_id, 'category_image_id', true ); ?>
					<input type="hidden" id="category_image_id" name="category_image_id" value="<?php echo esc_attr( $image_id ); ?>">
					<div id="category-image-wrapper">
						<?php if ( $image_id ) { ?>
							<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
						<?php } ?>
					</div>
					<p>
						<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr( 'Add Image', 'hero-theme' ); ?>" />
						<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr( 'Remove Image', 'hero-theme' ); ?>" />
					</p>
					<p class="description"><?php esc_html_e( 'Select the category image which will be used in various places.', 'reino' ); ?></p>
				</td>
			</tr>
		<?php
		}

		/*
		* Update the form field value
		* @since 1.0.0
		*/
		public function updated_category_image( $term_id, $tt_id ) {

			// Save bgcolor term color if possible
			if ( isset( $_POST['category_bg_color'] ) && ! empty( $_POST['category_bg_color'] ) ) {
				update_term_meta( $term_id, 'category_bg_color', sanitize_hex_color_no_hash( $_POST['category_bg_color'] ) );
			} else {
				delete_term_meta( $term_id, 'category_bg_color' );
			}

			// Save image term if possible
			if ( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ) {
				$image = $_POST['category_image_id'];
				update_term_meta( $term_id, 'category_image_id', $image );
			} else {
				update_term_meta( $term_id, 'category_image_id', '' );
			}
		}

		/*
		* Add script
		* @since 1.0.0
		*/
		public function add_script() {
			?>
			<script>
			jQuery(document).ready( function($) {
				function ct_media_upload(button_class) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('body').on('click', button_class, function(e) {
						var button_id = '#'+$(this).attr('id');
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(button_id);
						_custom_media = true;
						wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('#category_image_id').val(attachment.id);
								$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
								$('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
							} else {
								return _orig_send_attachment.apply( button_id, [props, attachment] );
							}
						}
						wp.media.editor.open(button);
						return false;
					});
				}
				ct_media_upload('.ct_tax_media_button.button');
				$('body').on('click','.ct_tax_media_remove',function(){
					$('#category_image_id').val('');
					$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
				});
				// Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
				$(document).ajaxComplete(function(event, xhr, settings) {
					var queryStringArr = settings.data.split('&');
					if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
						var xml = xhr.responseXML;
						$response = $(xml).find('term_id').text();
						if($response!=""){
							// Clear the thumb image
							$('#category-image-wrapper').html('');
						}
					}
				});
			});
			</script>
			<?php
		}
	}

	$class_ct_meta_fields = new Class_CT_Meta_Fields();
	$class_ct_meta_fields->init();
}

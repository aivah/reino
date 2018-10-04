/** Handle Post Formats Custom Meta boxes **/
function postformat_meta() {

	//show metat box based on selection of post format
	var postformat_type_grp = jQuery('#post-formats-select input');

	jQuery('#post-formats-select input').change(function () {
		//hide all the post format meta boxes
		if(jQuery(this).is(':checked') === true) { 
			jQuery('div[class*="postformat-mb-"]').hide();
			jQuery('.postformat-mb-'+jQuery(this).val()).show();
		}
	}).change();
}
styleSelect = {
	init: function () {
		jQuery('.select_wrapper').each(function () {
			jQuery(this).prepend('<span>' + jQuery(this).find('.select option:selected').text() + '</span>');
		});
		jQuery('.select').live('change', function () {
			jQuery(this).prev('span').replaceWith('<span>' + jQuery(this).find('option:selected').text() + '</span>');
		});
		jQuery('.select').bind(jQuery.browser.msie ? 'click' : 'change', function(event) {
			jQuery(this).prev('span').replaceWith('<span>' + jQuery(this).find('option:selected').text() + '</span>');
		});
	}
};
(function($){
	"use strict";
	jQuery(document).ready(function($) {

		jQuery('.iva-radio-option').click(function(){
			var iva_option_id = jQuery(this).attr('data-id');
			jQuery( '#'+iva_option_id ).attr('checked', 'checked');
			jQuery(this).parent().parent().find('.iva-radio-option').removeClass('iva-radio-option-selected');
			jQuery(this).addClass('iva-radio-option-selected');
		});

		jQuery('.iva-radio-option').show();
		jQuery('.iva-radio-img-label').hide();
		jQuery('.iva-radio-img-radio').hide();

		postformat_meta();
		styleSelect.init();

		jQuery('#vamico_featured_img_pos').change( function(){
			jQuery(".vamico_featured_img_type").hide();
			var selected_option = jQuery("#vamico_featured_img_pos option:selected").val();
			jQuery( '.' + selected_option ).show();
		}).change();

		jQuery('#vamico_featured_img_type').change( function(){
			jQuery(".vamico_slider_bg_color").hide();
			var selected_option = jQuery("#vamico_featured_img_type option:selected").val();
			jQuery( '.' + selected_option ).show();
		}).change();

		/*-- postlinkurl selection--*/
		jQuery("#vamico_postlinktype_options").change(function () {
			jQuery(".linkoption").hide();
			var selected_ptoption = jQuery("#vamico_postlinktype_options option:selected").val();
			jQuery("."+selected_ptoption).show();
		}).change();

		/*-- custom Logo option selection--*/
		jQuery("#vamico_logo").change(function () {
			jQuery(".title").slideUp();
			jQuery(".logo").slideUp();
			var selected_teaser = jQuery("#vamico_logo option:selected").val();
			jQuery("."+selected_teaser).slideDown();
		}).change();

		/*-- Custom Slider Selection--*/
		jQuery("#vamico_slider").change(function () {
			jQuery(".iva_of_sliders").hide();
			jQuery(".subtoggle").hide();
			var selected_slider = jQuery("#vamico_slider option:selected").val();
			if(selected_slider != "") {
				jQuery("."+selected_slider).show();
			}
		}).change();

		//
		jQuery("#vamico_owl_slider_type").change(function () {
			jQuery(".owl_slider_type").hide();
			var selected_slider = jQuery("#vamico_owl_slider_type option:selected").val();
			if(selected_slider != "") {
				jQuery("."+selected_slider).show();
			}
		}).change();

		//
		jQuery("#vamico_slider_post_from").change(function () {
			jQuery(".slider_post_from").hide();
			var selected_slider = jQuery("#vamico_slider_post_from option:selected").val();
			if(selected_slider != "") {
				jQuery("."+selected_slider).show();
			}
		}).change();

		//Header
		jQuery("#vamico_headerstyle").change(function () {
			jQuery(".iva_of_headerstyle").hide();
			var selected_headerstyle = jQuery("#vamico_headerstyle option:selected").val();
			if( selected_headerstyle !== '' ) {
				jQuery("."+selected_headerstyle).show();
			}
		}).change();

		jQuery('#media-items').bind('DOMNodeInserted',function(){
			jQuery('input[value="Insert into Post"]').each(function(){
				jQuery(this).attr('value','Use This Image');
			});
		});

		/*-- Upload Image Remove-*/
		 jQuery('.cimage_remove').live('click', function(event) {
		   var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
		   jQuery(this).parent().siblings('.custom_upload_image').val('');
		   jQuery(this).parent('.iva-screenshot').slideUp();
		   return false;
		});

		/*-- layout mode selection--*/
		jQuery("#vamico_page_layout").change(function(){
			if(jQuery('#vamico_page_layout').is(':checked') != true) {
				jQuery(".vamico_page_bg").hide();
			}else{
				jQuery(".vamico_page_bg").show();
			}
		}).change();

		var custom_uploader,clickedID ,formfield = '';
		jQuery('.custom_upload_image_button').click(function() {
			clickedID = jQuery(this).attr('id');
			formfield = jQuery(this).prev( 'input').attr( 'id' );
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose This',
				button: {
					text: 'Choose This'
				},
				multiple: false
			});
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				var image = /(^.*\.jpg|jpeg|png|gif*)/gi;
				if(typeof(attachment.sizes.thumbnail)  === "undefined") {
					if (attachment.url.match(image)) {
					  var  btnContent = '<img src="'+attachment.url+'" alt="" />';
					  btnContent += '<a href="javascript:(void);" class="cimage_remove button button-primary">x</a>';
					}
				}else if (attachment.sizes.thumbnail.url.match(image)) {
					var  btnContent = '<img src="'+attachment.sizes.thumbnail.url+'" alt="" />';
					btnContent += '<a href="javascript:(void);" class="cimage_remove button button-primary">x</a>'
				}

				jQuery( '#' + formfield).val(attachment.url);
				jQuery( '#' + formfield).siblings( '#iva_imagepreview-'+clickedID).slideDown().html(btnContent);
			});
			//Open the uploader dialog
			custom_uploader.open();
			return false;
		});
		jQuery(window).load(function() {
			jQuery('.page_load').fadeOut(800);
		});
		jQuery('.repeatable-remove').click(function(){
			jQuery(this).parent().remove();
			return false;
		});
		// Color Picker
		jQuery('.wpcolorSelector').each(function(){
			var Othis = this; //cache a copy of the this variable for use inside nested function
			var initialColor = jQuery(Othis).prev('input').attr('value');
			var initialColorid = jQuery(Othis).prev('input').attr('id');
			jQuery(Othis).children('div').css('backgroundColor', initialColor);
			jQuery('#' + initialColorid).wpColorPicker({
				color: initialColor,
				onShow: function (colpkr) {
					jQuery(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					jQuery(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					jQuery(Othis).children('div').css('backgroundColor', '#' + hex);
					jQuery(Othis).prev('input').attr('value','#' + hex);
				}
			});
		});
		//end color picker
		function GoogleFontSelect( slctr, mainID ){
			var _selected = $(slctr).val(); 						//get current value - selected and saved
			var _linkclass = 'style_link_'+ mainID;
			var _previewer = mainID +'_ggf_previewer';

			if( _selected ){ //if var exists and isset

				$('.'+ _previewer ).fadeIn();

				//Check if selected is not equal with "Select a font" and execute the script.
				if ( _selected !== ' ' ) {

					//remove other elements crested in <head>
					$( '.'+ _linkclass ).remove();
					var arr = [ "Arial", "Verdana", "Tahoma", "Sans-serif", "Lucida Grande" , "Georgia,serif", "Trebuchet MS, Tahoma, sans-serif", "Times New Roman, Geneva, sans-serif", "Palatino,Palatino Linotyp,serif","Helvetica Neue, Helvetica, sans-serif" ];
					if ($.inArray(_selected, arr) !== -1){

					}else{
						//replace spaces with "+" sign
						var the_font = _selected.replace(/\s+/g, '+');

						//add reference to google font family
						$('head').append('<link href="http://fonts.googleapis.com/css?family='+ the_font +'" rel="stylesheet" type="text/css" class="'+ _linkclass +'">');
					}
					//show in the preview box the font
					$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );
				}else{
					//if selected is not a font remove style "font-family" at preview box
					$('.'+ _previewer ).css('font-family', '' );
					$('.'+ _previewer ).fadeOut();
				}
			}
		}

		//init for each element
		jQuery( '.google_font_select' ).each(function(){
			var mainID = jQuery(this).attr('id');
			GoogleFontSelect( this, mainID );
		});

		//init when value is changed
		jQuery( '.google_font_select' ).change(function(){
			var mainID = jQuery(this).attr('id');
			GoogleFontSelect( this, mainID );
		});

		jQuery('.iva_select_all').toggle( function(){
			  var iva_attr_id = jQuery(this).attr( 'data-id' );
			  jQuery('.' +iva_attr_id+ ' option').prop( 'selected',true );
			},function(){
				var iva_attr_id = jQuery( this ).attr( 'data-id' );
			    jQuery('.' +iva_attr_id+ ' option' ).prop( 'selected',false);
		});

		Color.prototype.toString = function(remove_alpha) {
			if (remove_alpha == 'no-alpha') {
				return this.toCSS('rgba', '1').replace(/\s+/g, '');
			}
			if (this._alpha < 1) {
				return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
			}
			var hex = parseInt(this._color, 10).toString(16);
			if (this.error) return '';
			if (hex.length < 6) {
				for (var i = 6 - hex.length - 1; i >= 0; i--) {
					hex = '0' + hex;
				}
			}
			return '#' + hex;
		};

		$('.iva-color-control').each(function() {
			var $control = $(this),
				value = $control.val().replace(/\s+/g, '');
			// Manage Palettes
			var palette_input = $control.attr('data-palette');
			if (palette_input == 'false' || palette_input == false) {
				var palette = false;
			} else if (palette_input == 'true' || palette_input == true) {
				var palette = true;
			} else {
				var palette = $control.attr('data-palette').split(",");
			}
			$control.wpColorPicker({ // change some things with the color picker
				 clear: function(event, ui) {
				// TODO reset Alpha Slider to 100
				 },
				change: function(event, ui) {

					// send ajax request to wp.customizer to enable Save & Publish button
					var _new_value = $control.val();

					// change the background color of our transparency container whenever a color is updated
					var $transparency = $control.parents('.wp-picker-container:first').find('.transparency');

					// we only want to show the color at 100% alpha
					$transparency.css('backgroundColor', ui.color.toString('no-alpha'));
				},
				palettes: palette // remove the color palettes
			});
			$('<div class="iva-alpha-container"><div class="slider-alpha"></div><div class="transparency"></div></div>').appendTo($control.parents('.wp-picker-container'));
			var $alpha_slider = $control.parents('.wp-picker-container:first').find('.slider-alpha');

			// if in format RGBA - grab A channel value
			if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
				var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
				var alpha_val = parseInt(alpha_val);
			} else {
				var alpha_val = 100;
			}

			$alpha_slider.slider({
				slide: function(event, ui) {
					$(this).find('.ui-slider-handle').text(ui.value); // show value on slider handle
					// send ajax request to wp.customizer to enable Save & Publish button
					var _new_value = $control.val();
				},
				create: function(event, ui) {
					var v = $(this).slider('value');
					$(this).find('.ui-slider-handle').text(v);
				},
				value: alpha_val,
				range: "max",
				step: 1,
				min: 1,
				max: 100
			}); // slider

			$alpha_slider.slider().on('slidechange', function(event, ui) {
				var new_alpha_val = parseFloat(ui.value),
					iris = $control.data('a8cIris'),
					color_picker = $control.data('wpWpColorPicker');
					iris._color._alpha = new_alpha_val / 100.0;
					$control.val(iris._color.toString());
					color_picker.toggler.css({
					backgroundColor: $control.val()
				});
				// fix relationship between alpha slider and the 'side slider not updating.
				var get_val = $control.val();
				$($control).wpColorPicker('color', get_val);
			});
		}); // each

	// Icon Box Widget
	jQuery('.vamico-font-icon-name').each(function() {
		jQuery(this).click( function(){
			var w_data_id = jQuery(this).closest('.widget').attr('id');
			var icon_name =jQuery(this).attr('data-icon');
			jQuery('#'+w_data_id+' .icon-input').val(icon_name);
		});
	});

	// Dynamic Footer script with ui sider
	var cols = jQuery('.slider_result_db_cols').val();
	jQuery('#vamico_footer_widget_layout_number').change(function () {
			var columns = jQuery(this).val();
			var slider_values = widget_slider( columns, cols );
	}).change();

	function widget_slider( columns, cols ) {
		var slider_values = jQuery('.slider_result_db_values').val();
		slider_values = slider_values.split(",");
		if (columns ==  null || columns != cols) {
			slider_values = [2,5,7,10];
			if( columns == '6' ) {
				slider_values =  [2,4,6,8,10];
			}
			if( columns == '5' ) {
				slider_values =  [2,5,7,10];
			}
			if( columns == '4' ) {
				slider_values =  [3,6,9];
			}
			if( columns == '3' ) {
				slider_values =  [4,8];
			}
			if( columns == '2' ) {
				slider_values =  [6];
			}
			if( columns == '1' ) {
				slider_values =  [12];
			}
		}

		if ( undefined !== jQuery("#vamico_ui_slider").slider( 'instance' ) ) {
			jQuery("#vamico_ui_slider").slider( 'destroy' );
		}
		var setSlider = function ( values ) {
			jQuery("#vamico_ui_slider").slider({
				values: values,
				min: 0,
				max: 12,
				step: 1,
				change: function( event, ui ) {
					$(".slider_result").val( values );
				},
				slide: function(event, ui) {
					$(".slider_result").val( values );
				}
			});
		};

		var val = slider_values;
		setSlider( val );
		var values = $( "#vamico_ui_slider" ).slider( "values" );
		$(".slider_result").val( values );
	}
});

})(jQuery);

// Post Gallery Metabox  starts here
jQuery( function( $ ){

	// Product gallery file uploads
	var vamico_gallery_frame;
	var $image_gallery_ids = $('#vamico_image_gallery');
	var $vamico_images = $('#vamico_images_container ul.vamico_images');
	jQuery('.add_vamico_images').on( 'click', 'a', function( event ) {
		var $el = $(this);
		var attachment_ids = $image_gallery_ids.val();
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( vamico_gallery_frame ) {
			vamico_gallery_frame.open();
			return;
		}
		// Create the media frame.
		vamico_gallery_frame = wp.media.frames.vamico_gallery = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),
			button: {
				text: $el.data('update'),
			},
			states : [
				new wp.media.controller.Library({
					title: $el.data('choose'),
					filterable :	'all',
					multiple: true,
				})
			]
		});
		// When an image is selected, run a callback.
		vamico_gallery_frame.on( 'select', function() {
			var selection = vamico_gallery_frame.state().get('selection');
			// jQuery('.delete').click(function(event){ event.preventDefault();});
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.id ) {
				attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
				$vamico_images.append('\
					<li class="image" data-attachment_id="' + attachment.id + '">\
						<img src="' + attachment.sizes.thumbnail.url + '" />\
						<ul class="actions">\
							<li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
						</ul>\
					</li>');
				}
			});
			$image_gallery_ids.val( attachment_ids );
		});
		// Finally, open the modal.
		vamico_gallery_frame.open();
	});
	// Image ordering
	$vamico_images.sortable({
		items: 'li.image',
		cursor: 'move',
		scrollSensitivity:40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'rh-metabox-sortable-placeholder',
		start:function(event,ui){
			ui.item.css('background-color','#f6f6f6');
		},
		stop:function(event,ui){
			ui.item.removeAttr('style');
		},
		update: function(event, ui) {
			var attachment_ids = '';
			$('#vamico_images_container ul li.image').css('cursor','default').each(function() {
				var attachment_id = jQuery(this).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});
			$image_gallery_ids.val( attachment_ids );
		}
	});
	// Remove images
	$('#vamico_images_container').on( 'click', 'a.delete', function() {
		$(this).closest('li.image').remove();
		var attachment_ids = '';
		$('#vamico_images_container ul li.image').css('cursor','default').each(function() {
			var attachment_id = jQuery(this).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});
		$image_gallery_ids.val( attachment_ids );

		return false;
	});
});
// Vamico metabox gallery ends here
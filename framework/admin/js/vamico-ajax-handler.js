jQuery(document).ready(function(){
	'use strict';
	jQuery('.group').hide();
	jQuery('.group:first').fadeIn();

	jQuery('#atp-nav li a').click( function( evt ){
		jQuery('#atp-nav li').removeClass('current');
		jQuery(this).parent().addClass('current');

		var clicked_class = jQuery(this).attr('class');
		if( clicked_class == 'parent'){
			clicked_group=jQuery(this).parent().find( '.sub-menu li a:first' ).attr('href');
			jQuery('.group').hide();
			jQuery(clicked_group).fadeIn();
		}else{
			var clicked_group = jQuery(this).attr('href');
			jQuery('.group').hide();
			jQuery(clicked_group).fadeIn();
			//evt.preventDefault();
		}
		evt.preventDefault();
	});

	var querystring_reset = '';
	if( querystring_reset!= ''){
		var reset_popup = jQuery('#atp-popup-reset');
			reset_popup.fadeIn();
			window.setTimeout(function(){
			reset_popup.fadeOut();
		}, 2000);
	}

	//Update Message popup
	jQuery.fn.center = function () {
		this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
		this.css({"left":'50%','margin-left':'-136px'});
		return this;
	}

	jQuery('#atp-popup-save').center();
	jQuery('#atp-popup-reset').center();

	jQuery(window).scroll(function() {
		jQuery('#atp-popup-save').center();
		jQuery('#atp-popup-reset').center();
	});
	// Resetoption confirm box Message
	jQuery( '#atpform-reset' ).on("submit", function() {
		return confirm( vamico_admin_js_param.themeoption_reset );
	});
	//Save everything else
	jQuery('#atpform').submit(function(){
		function newValues() {
			var serializedValues = jQuery("#atpform").serialize();
			return serializedValues;
		}

		jQuery(":checkbox, :radio").click(newValues);
		jQuery("select").change(newValues);
		jQuery('.ajax-loading-img').fadeIn();
		var serializedReturn = newValues();

		var ajax_url = admin_ajax_url;

		if(querystring_page == 'optionsframework') {
			var data = {
				type: 'options',
				action: 'vamico_ajax_upload',
				data: serializedReturn
			};
		}
		jQuery.post(ajax_url, data, function(response) {
			var success = jQuery('#atp-popup-save');
			var loading = jQuery('.ajax-loading-img');
			loading.fadeOut();
			success.fadeIn();
			window.setTimeout(function(){
			   success.fadeOut();
			}, 2000);
		});
		return false;
	});
	sidemenu();
	
	// Sociables
	jQuery('.sys_social_item_delete').click(function() {
    	jQuery(this).closest('tr').remove();
    });

    jQuery('.button-primary').click(function() {
		var sys_social_data = '';
    	jQuery('#sys_socialbookmark tr').each(function() {
			var social1 = jQuery(this).find('.sys_social_title').val();
			var social2 = jQuery(this).find('.sys_social_file_icon').val();
			var social3 = jQuery(this).find('.sys_social_account_url').val();

			if (social1 !== undefined) {
				social1 = social1.replace(/#;/g, '').replace(/#\|/g, '');
				social2 = social2.replace(/#;/g, '').replace(/#\|/g, '');
				social3 = social3.replace(/#;/g, '').replace(/#\|/g, '');
				sys_social_data =  sys_social_data + social1 + '#|' + social2 + '#|' + social3 + '#;';
			}
		});
		sys_social_data = sys_social_data.substr(0, sys_social_data.length - 2);
		if(sys_social_data != ''){
			document.getElementById('vamico_social_bookmark').value = sys_social_data;
		}
	});
    var iva_social_icon_names = '';
    jQuery.each( sociables_args, function( i, val ) {
    	iva_social_icon_names +='<option value='+i+'>'+val+'</option>';
    });
	// handle ADD action
	jQuery('#sys_add_social_item').click(function() {
		jQuery('#sys_socialbookmark tr:last').after('' +
		'<tr><td width="50"><select class="sys_social_file_icon" name="sys_social_file_icon" >' + iva_social_icon_names +
		'<td width="70"><input type="text"  class="sys_social_account_url"/></td>' +
		'<td width="50"><input type="text"  class="sys_social_title" /></td>' +
		'<td align="center" width="70"><a href="#" class="sys_social_item_delete button-primary red-button">Delete</a></td>' +
		'</tr>'
	);
	    jQuery('.sys_social_item_delete').click(function() {
			jQuery(this).closest('tr').remove();
				return false;
		});
	});
	
	// data import options
	jQuery(".import_options_btn").click(function(){
		 var import_ob_input_value = jQuery(".import_ob_input").val();
		 var iva_admin_url = jQuery(this).attr("data-url");

		 if( import_ob_input_value == "" ){
			alert("Enter content from a txt file.");
			return false;
		 }
		 if( import_ob_input_value ){
			jQuery.ajax({
				type: "POST",
				url:ajaxurl,
				data: {
					action: "vamico_import_ob_from_file" ,
					"import_ob_file": import_ob_input_value,
					},
				success: function( response ){

					jQuery(".iva_import_ob_msg").html( vamico_admin_js_param.importer_success );
					jQuery(".iva_import_ob_msg").css( "display", "block" );

					window.location = iva_admin_url;
					window.location.reload(true);
				}
			});
		}
	});
	// importer data delete
	jQuery(".ob_delete").click(function(){
		var ob_delete_file = jQuery(this).attr("data-delete");
		var iva_admin_url = jQuery(this).attr("data-url");
		if( confirm( vamico_admin_js_param.importer_delete_confirm ) ){
			jQuery(this).parent().parent().parent().remove();
			jQuery.ajax({
				type: "POST",
				url:ajaxurl,
				data: {
					action: "vamico_delete_ob" ,
					"delete_file": ob_delete_file,
					},
				success: function( response ){

					jQuery(".iva_import_ob_msg").html( vamico_admin_js_param.importer_delete_success );
					jQuery(".iva_import_ob_msg").css( "display", "block" );

					window.location = iva_admin_url;
					window.location.reload(true);
				}
			});
		}
	});
	// backup import
	jQuery(".ob_import").click(function(){
		var iva_admin_url = jQuery(this).attr("data-url");
		var iva_ob_import = jQuery(this).attr("data-import");

		jQuery.ajax({
			type: "POST",
			url:ajaxurl,
			data: {
				action: "vamico_import_ob" ,
				"ob_import":iva_ob_import,
			},
			success: function( response ){
				jQuery(".iva_import_ob_msg").html( vamico_admin_js_param.ob_import_success );
				jQuery(".iva_import_ob_msg").css( "display", "block" );
				setInterval(function(){
					jQuery(".iva_import_ob_msg").css( "display", "none" );
				},2000);
				window.location = iva_admin_url;
				window.location.reload(true);
			}
		});
	});
	// custom sidebar
	jQuery('.iva_custom_sidebar').click(function(){
		var iva_sidebar_widget = jQuery(this).attr('id');
		jQuery('#custom_widget_table' ).append('<tr><td><input type="text" name="'+iva_sidebar_widget+'" value="" size="30" style="width:97%" /></td><td><span class="button red-button iva_custom_siderbar_del">Delete</span></td></tr>' );
		iva_custom_sidebar_del();
	});
	iva_custom_sidebar_del();
	function iva_custom_sidebar_del() {
		jQuery('span.iva_custom_siderbar_del').click(function(){
			jQuery(this).parent().parent().remove();
		});
	}
	jQuery(".export-data-btn").click(function(){
		var iva_admin_url = jQuery(this).attr("data-url");
		jQuery.ajax({
			type: "POST",
			url:ajaxurl,
			data: { action: "vamico_export_ob" },
			success: function( response ){
				jQuery(".iva_export_ob_msg").html("Export Options Backup Successfully Please wait a few seconds untill reload the page");
				jQuery(".iva_export_ob_msg").css( "display", "block" );
				window.location = iva_admin_url;
				window.location.reload(true);
			}
		});
	});
});
function sidemenu() {
	'use strict';
	jQuery("#atp-nav li ul").hide(); // Hide all sub menus
	jQuery("#atp-nav li a.current").parent().find("ul").slideToggle("slow");
	jQuery("#atp-nav li a.parent").click( function () {
		jQuery(this).parent().siblings().find("ul").slideUp("normal");
		jQuery(this).next().slideToggle("normal");
		return false;
	});
}
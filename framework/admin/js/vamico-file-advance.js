jQuery( function ( $ ){
	'use strict';
var template = $( '#tmpl-rwmb-file-advanced' ).html();
var rwmbFile = {"maxFileUploadsSingle":"You may only upload maximum %d file","maxFileUploadsPlural":"You may only upload maximum %d files"};
var rwmbFileAdvanced = {"frameTitle":"Select Files"};

	$( 'body' ).on( 'click', '.rwmb-file-advanced-upload', function ( e ){
	e.preventDefault();

	var $uploadButton = $( this ),
		$fileList = $uploadButton.siblings( '.rwmb-uploaded' ),
		maxFileUploads = $fileList.data( 'max-file-uploads' ),
		mimeType = $fileList.data( 'mime-type' ),
		msg = maxFileUploads > 1 ? rwmbFile.maxFileUploadsPlural : rwmbFile.maxFileUploadsSingle,
		frame,
		frameOptions = {
			className: 'media-frame rwmb-file-frame',
			multiple : true,
			title    : rwmbFileAdvanced.frameTitle
		};

	msg = msg.replace( '%d', maxFileUploads );

	// Create a media frame
	if ( mimeType ){
		frameOptions.library = {
			type: mimeType
		};
	}
	frame = wp.media( frameOptions );

		// Open media uploader
		frame.open();

		// Remove all attached 'select' event
		frame.off( 'select' );

		// Handle selection
		frame.on( 'select', function (){
			// Get selections
			var selection = frame.state().get( 'selection' ).toJSON(),
				uploaded = $fileList.children().length,
				ids;

			if ( maxFileUploads > 0 && ( uploaded + selection.length ) > maxFileUploads )
			{
				if ( uploaded < maxFileUploads )
				{
					selection = selection.slice( 0, maxFileUploads - uploaded );
				}
				alert( msg );
			}

			// Get only files that haven't been added to the list
			// Also prevent duplication when send ajax request
			selection = _.filter( selection, function ( attachment ){
				return $fileList.children( 'li#item_' + attachment.id ).length === 0;
			});
			ids = _.pluck( selection, 'id' );

			if ( ids.length > 0 ){
				// Attach attachment to field and get HTML
				var data = {
					action        : 'rwmb_attach_file',
					post_id       : $( '#post_ID' ).val(),
					field_id      : $fileList.data( 'field-id' ),
					attachment_ids: ids,
					_ajax_nonce   : $uploadButton.data( 'attach-file-nonce' )
				};
				$.post( ajaxurl, data, function ( r ){
					if ( r.success ){
						$fileList
							.append( _.template( template, { attachments: selection }, {
								evaluate   : /<#([\s\S]+?)#>/g,
								interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
								escape     : /\{\{([^\}]+?)\}\}(?!\})/g
							} ) )
							.trigger( 'update.rwmbFile' );
					}
				}, 'json' );
			}
		});
	});

	// Delete file via Ajax
	$( '.rwmb-uploaded' ).on( 'click', '.rwmb-delete-file', function (){
		var $this = $( this ),
			$parent = $this.parents( 'li' ),
			$container = $this.closest( '.rwmb-uploaded' ),
			data = {
				action       : 'rwmb_delete_file',
				_ajax_nonce  : $container.data( 'delete-nonce' ),
				post_id      : $( '#post_ID' ).val(),
				field_id     : $container.data( 'field-id' ),
				attachment_id: $this.data( 'attachment-id' ),
				force_delete : $container.data( 'force-delete' )
			};

		$.post( ajaxurl, data, function ( r ){
			if ( !r.success ){
				alert( r.data );
				return;
			}

			$parent.addClass( 'removed' );

			// If transition events not supported
			var div = document.createElement( 'div' );
			if (
				!( 'ontransitionend' in window ) &&
				( 'onwebkittransitionend' in window ) && !( 'onotransitionend' in div || navigator.appName === 'Opera' )
			){
				$parent.remove();
				$container.trigger( 'update.rwmbFile' );
			}
			$( '.rwmb-uploaded' ).on( 'transitionend webkitTransitionEnd otransitionend', 'li.removed', function (){
				$( this ).remove();
				$container.trigger( 'update.rwmbFile' );
			});
		}, 'json' );

		return false;
	});

	//Remove deleted file
	$( '.rwmb-uploaded' ).on( 'transitionend webkitTransitionEnd otransitionend', 'li.removed', function (){
		$( this ).remove();
	} );

	$( 'body' ).on( 'update.rwmbFile', '.rwmb-uploaded', function (){
		var $fileList = $( this ),
			maxFileUploads = $fileList.data( 'max-file-uploads' ),
			$uploader = $fileList.siblings( '.new-files' ),
			numFiles = $fileList.children().length;

		if ( numFiles > 0 ){
			$fileList.removeClass( 'hidden' );
		}
		else{
			$fileList.addClass( 'hidden' );
		}

		// Return if maxFileUpload = 0
		if ( maxFileUploads === 0 ){
			return false;
		}

		// Hide files button if reach max file uploads
		if ( numFiles >= maxFileUploads )
		{
			$uploader.addClass( 'hidden' );
		}
		else
		{
			$uploader.removeClass( 'hidden' );
		}

		return false;
	});

	// Reorder images
	$( '.rwmb-file' ).each( function (){
		var $this = $( this ),
			data = {
				action     : 'rwmb_reorder_files',
				_ajax_nonce: $this.data( 'reorder-nonce' ),
				post_id    : $( '#post_ID' ).val(),
				field_id   : $this.data( 'field-id' )
			};
			$this.sortable({
			placeholder: 'ui-state-highlight',
			items      : 'li',
			update     : function (){
				data.order = $this.sortable( 'serialize' );
				$.post( ajaxurl, data );
			}
		});
	});
});
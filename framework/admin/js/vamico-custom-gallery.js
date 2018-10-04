jQuery(document).ready(function () {
		// add your shortcode attribute and its default value to the
		// gallery settings list; $.extend should work as well...
		 _.extend(wp.media.gallery.defaults, {
		    type: 'grid'
		});

		// join default gallery settings template with yours -- store in list
		if (!wp.media.gallery.templates) wp.media.gallery.templates = ['gallery-settings'];
			wp.media.gallery.templates.push('custom-gallery-type');

		  // loop through list -- allowing for other templates/settings
		wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
		    template: function (view) {
				var output = '';
				for (var i in wp.media.gallery.templates) {
					output += wp.media.template(wp.media.gallery.templates[i])(view);
				}
				return output;
		    }
		});
    });
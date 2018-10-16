
(function ($) {
    "use strict";

    // Define your library strictly...
    jQuery(document).ready(function($) {

        $(".single-post .pagemid  > .inner").waypoint(function(b) {
			"down" === b ? $(".post__pagination").addClass("post__pagination-visible") : $(".post__pagination").removeClass("post__pagination-visible")
		});
		/* ShareLinls popup       */
		/* ====================== */
		$('.meta-share .customer.share').on("click", function(e) {
		  $(this).reino_share_popup(e);
		});

		/* Justified Gallery      */
		/* ====================== */
		if ( $.isFunction($.fn.justifiedGallery) ) {
			jQuery(".gallery-justified").justifiedGallery({
				border: 0,
				margins: 10,
				lastRow: 'justify',
				rowHeight: 300,
				selector: 'figure',
				captions: true,
				maxRowHeight: '200%',
				cssAnimation: true,
				captionSettings: {
					animationDuration: 100,
					visibleOpacity: 1.0,
					nonVisibleOpacity: 0.0
				}
			});
		}
		/* Pretty Photo           */
		/* ====================== */
		if ( $.isFunction($.fn.prettyPhoto) ) {
			$("a[data-rel^='prettyPhoto']").prettyPhoto({
				theme: 'pp_default',
				social_tools: false,
				deeplinking : false
			});
		}
		/* Footer Branches        */
		/* ====================== */
		$('.footer-branches').hide();
		$( ".at-footer-branches" ).on('click', function(e) {
			e.preventDefault();
 			$(this).toggleClass('at-toggleOpen');
			$( ".footer-branches" ).slideToggle(500);
		  	$('html, body').animate({
          		scrollTop: $(document).height()
      		}, 500);
		});
		/* Vidoe Resize Fitvids   */
		/* ====================== */
		if ( $.fn.fitVids) {
			$('.post__video,.video-frame,.boxcontent,.video-stage,.video,.post').fitVids();
		}

		/* BacktoTop Scroll       */
		/* ====================== */
		$("#back-top").hide();
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$('#back-top').fadeIn();
				} else {
					$('#back-top').fadeOut();
				}
			});

			// scroll body to 0px on click
			$('#back-top a').on('click', function () {
				$('body,html').animate({
					scrollTop: 0
				}, 800);

			   return false;
			});
		});

		/* Fixed Header           */
		/* ====================== */
		var $aSelected = $('#wrapper').find('header');
		var $wpAdminBar = $('#wpadminbar');
		var fh = $('.header-fixed');
		var fhh = $('.header-fixed').outerHeight();
		var eh = $('.header-fixed-empty');
		var ehh = $('.header-fixed-empty').css('height', fhh );
		var tb = $('.topbar-wrap');
		var tbh = $('.topbar-wrap').outerHeight();

		if ( $wpAdminBar.length && tb.length ) {
			fh.css('top', tbh + $wpAdminBar.height()+'px');
			eh.css({
				'top': -($wpAdminBar.height()+'px'),
				'height': ehh,
			});
		} else if ( $wpAdminBar.length ) {
			fh.css('top', $wpAdminBar.height()+'px');
			eh.css({
				'height': ehh,
			});
		} else {
			fh.css('top', 0 );
			eh.css('height', ehh );
		}

		if( $aSelected.is('.header-fixed') ){

			var stickyHeaderTop = $('.topbar-wrap').offset().top;

			$( window ).scroll(function(){
				if( $( window ).scrollTop() > stickyHeaderTop ) {
					fh.addClass('header-sticky');
					if ( $wpAdminBar.length && tb.length ) {
						fh.css('top', $wpAdminBar.height() );
					} else if ( $wpAdminBar.length ) {
						fh.css('top', $wpAdminBar.height() );
					}

					if ( jQuery(window).width() > 1024) {
						$('.logo img').css({
							'transform':'scale(0.7)',
							'transform-origin':'left',
						});
					}
				} else {
					fh.removeClass('header-sticky');
					if ( $wpAdminBar.length && tb.length ) {
						fh.css('top', $wpAdminBar.height() + tbh );
					} else if( $wpAdminBar.length ) {
						fh.css('top', $wpAdminBar.height() );
					}
					if ( jQuery(window).width() > 1024) {
						$('.logo img').css({'transform':'scale(1)'});
					}
				}
			});
		}

		$(".sf-menu").superfish({
			cssArrows: false,
		});

		/* Masonry Desandro       */
		/* ====================== */
		if ( $.isFunction($.fn.masonry) ) {

		}

		/* Owl Carousel           */
		/* ====================== */
		if ( $.isFunction($.fn.owlCarousel) ) {

			if ( typeof owlcarousel_args != "undefined" ) {
				var owl_navigation = owlcarousel_args.navigation == 'true' ? true : false;
				var owl = $('.owl-carousel');
				// Related  Post Carousel
				$("#owl-carousel-related").owlCarousel({
					autoplay: owlcarousel_args.relatedspeed,
					nav: false,
					touchDrag: true,
					stopOnHover: true,
					autoHeight:true,
                    dots: true,
					margin:20,
					items : owlcarousel_args.relateditems,
					responsive:{
						320  :{
				            items:1,
				        },
				        480 :{
				            items:1,
				        },
				        768 :{
				            items:2,
				        },
						1024 :{
				            items:4,
				        },
						1199 :{
				            items:4,
				        }
				    },
				});
				// Post Gallery  Carousel
				$("#reino_postformat_gallery").owlCarousel({
					autoplay: owlcarousel_args.galleryspeed,
					pagination: owl_navigation,
					nav: true,
					loop: true,
					navText: [ "<div class='owl-btn'><i class='fa fa-angle-left'></i></div>", "<div class='owl-btn'><i class='fa fa-angle-right'></i></div>"],
					dots:true,
					touchDrag: true,
					stopOnHover: true,
					autoHeight:true,
					items : 1,
					itemsDesktop : [1199,1],
					itemsDesktopSmall : [1024,1],
					itemsTablet : [768,1],
					itemsMobile : [479,1]
				});
				// center
				var owl_autoplay = owlcarousel_args.autoplay == 'true' ? true : false;

				jQuery('.owl-fullscreen').owlCarousel({
					nav : true,
					navText: [ "<div class='owl-btn'><i class='fa fa-angle-left'></i></div>", "<div class='owl-btn'><i class='fa fa-angle-right'></i></div>"],
					pagination : false,
					dots: true,
					items: 1,
					autoplay: owl_autoplay,
                    autoplayTimeout : 3000000,
					// autoplayTimeout : parseInt(owlcarousel_args.timeout),
					margin : 0,
					loop: true,
					transitionStyle : "fade",
					onInitialized:owl_large,
				});
				function owl_large(){
					var k = window.innerHeight;
					var  c = jQuery('#wpadminbar').innerHeight(),
					b = jQuery("header").outerHeight(),
					d = jQuery(".owl__post img");
					jQuery(".featured_slider").css("margin-top", -c - b + "px"),
					k >= 600 ? jQuery(".owl__post img").css("height", k) : jQuery(".owl__post img").css("height", "600px");
				}

                // Owl Slider Columns
				var owl_columns = $(".owl-columns").data("slidesnumber");
				$('.owl-columns').owlCarousel({
                    items: owl_columns,
					nav : true,
					dots : true,
                    loop: true,
                    stagePadding: 0,
                    autoplay: owl_autoplay,
					autoplayTimeout : 3000000,
					//autoplayTimeout : parseInt(owlcarousel_args.timeout),
					margin : parseInt(owlcarousel_args.margin),
                    navText: [
                        "<div class='owl-btn'><i class='fa fa-angle-left'></i></div>",
                        "<div class='owl-btn'><i class='fa fa-angle-right'></i></div>"
                    ],
					responsive: {
						0: {
							items: 1
						},
						992: {
							items: 2
						},
						1200: {
							stagePadding: 0,
						}
					},
				});

			}
		}

		// Mobile Menu Jquery
		$('.iva-hamburger').on('click', function(){
			$(this).toggleClass('open');
			$('.iva-mobile-menu').slideToggle(500);
			return false;
		});

		// Social Share
		jQuery('#close__share').on( 'click', function() {
			jQuery('#socials__modal').removeClass('show opened');
			jQuery('modal-box-wrapper').css('visibility', 'hidden');
		});
		jQuery('.post__share').on('click', function(){
			jQuery('#socials__modal').addClass('show opened');
			jQuery('modal-box-wrapper').css('visibility', 'visible');
		});

		// Ajax Search
		jQuery('.search__icon').on( 'click', function() {
			jQuery('body').toggleClass('overflow__hidden');
			jQuery('#search__modal').toggleClass('show');
			jQuery('#close__search').addClass('opened');
			jQuery('#search__modal').find('#search__form').find('#search_input').focus();
		});

		jQuery('#close__search').on( 'click', function() {
			jQuery('body').removeClass('overflow__hidden');
			jQuery(this).removeClass('opened');
			jQuery('#search__modal').removeClass('show');
		});

        // Customized Flexslider

	jQuery('.flex-img').flexslider({
		animation: "slide",
		animationSpeed: 500,
		slideshow: false,
		direction: "vertical",
		reverse: true,
		startAt: 0,
		slideToStart: 0,
		start: function(slider) {
			jQuery('a.slide_thumb').click(function() {
				jQuery('.active').removeClass('active');
				jQuery(this).addClass('active');
				jQuery('.flexslider').show();
				var slideTo = $(this).attr("rel"); //Grab rel value from link;
				var slideToInt = parseInt(slideTo); //Make sure that this value is an integer;
				if (slider.currentSlide != slideToInt); {
					slider.flexAnimate(slideToInt); //move the slider to the correct slide (Unless the slider is also already showing the slide we want);
				}
			});
			jQuery('.flex-prev').click(function(e) {
				e.preventDefault();
				jQuery('.active').removeClass('active');
				jQuery('.flexslider').show();
				var c = slider.currentSlide;
				if(c!=0) {
					c--;
					slider.flexAnimate(c);
					jQuery('.slide_thumb[rel='+c+']').addClass('active');
				} else {
					slider.flexAnimate(3);
					jQuery('.slide_thumb[rel=3]').addClass('active');
				}
			})
			jQuery('.flex-next').click(function(e) {
				e.preventDefault();
				jQuery('.active').removeClass('active');
				jQuery('.flexslider').show();
				var c = slider.currentSlide;
			 if(c!=3) {
					c++;
					slider.flexAnimate(c);
					jQuery('.slide_thumb[rel='+c+']').addClass('active');
				} else {
					slider.flexAnimate(0);
					jQuery('.slide_thumb[rel=0]').addClass('active');
				}
				if(c!=4) {
					c++;
				jQuery('.slide-numbers .current-slide-numb').empty().append('0' + c);//remove previous value and append current slide value
				}
			})
		},

	});

	jQuery('.flex-details').flexslider({
		slideshow: false,
		direction: "vertical",
		reverse: true,
		startAt: 0,
		slideToStart: 0,
		start: function(slider) {

			var c = slider.currentSlide;

			if(c != slider.count) {
				c++;
				jQuery('.slide-numbers .current-slide-numb').append('0'+c);
				jQuery('.slide_thumb[rel=0]').addClass('active');
			}

			jQuery('a.slide_thumb').click(function() {
				jQuery('.active').removeClass('active');
				jQuery(this).addClass('active');
				jQuery('.flexslider').show();
				var slideTo = jQuery(this).attr("rel") //Grab rel value from link;
				var slideToInt = parseInt(slideTo) //Make sure that this value is an integer;

				var x = slideTo++;
				var y = 1;
				var z = x + y;
				jQuery('.current-slide-numb').empty().append('0' + z);

				startAnimation();
				function startAnimation(){
							jQuery(".timeline span").removeClass('clicked');
							setTimeout(function(){
							jQuery(".timeline span").addClass('clicked')
							},1);
						}
				if (slider.currentSlide != slideToInt) {
					slider.flexAnimate(slideToInt) //move the slider to the correct slide (Unless the slider is also already showing the slide we want);
				}
			});

		jQuery('.flex-prev').click(function(e) {
			e.preventDefault();
			jQuery('.active').removeClass('active');
			jQuery('.flexslider').show();
			startAnimation();
			function startAnimation(){
				jQuery(".timeline span").removeClass('clicked');
				setTimeout(function(){
					jQuery(".timeline span").addClass('clicked')
				},1);
			}
			var c = slider.currentSlide;
			if(c!=0) {
				c--;
				slider.flexAnimate(c);
				jQuery('.current-slide-numb').empty().append('0' + c);

				jQuery('.slide_thumb[rel='+c+']').addClass('active');
			} else {
				slider.flexAnimate(slider.count);
				jQuery('.current-slide-numb').empty().append('0' + slider.pagingCount);
				jQuery('.slide_thumb[rel=3]').addClass('active');
			}
		})

			jQuery('.flex-next').click(function(e) {
				e.preventDefault();
				jQuery('.active').removeClass('active');
				jQuery('.flexslider').show();
				startAnimation();
				function startAnimation() {
					jQuery(".timeline span").removeClass('clicked');
					setTimeout(function(){
						jQuery(".timeline span").addClass('clicked')
					},1);
				}
				var c = slider.currentSlide;
				 if(c != slider.count) {
					c++;
					slider.flexAnimate(c);
					jQuery('.slide_thumb[rel='+c+']').addClass('active');
				} else {
					slider.flexAnimate(c);
					jQuery('.slide_thumb[rel=0]').addClass('active');
				}

				if(c != slider.count) {
					c++;
				jQuery('.slide-numbers .current-slide-numb').empty().append('0' + c);//remove previous value and append current slide value
				} else{
					c = 1;
					jQuery('.slide-numbers .current-slide-numb').empty().append('0' + c);//remove previous value and append current slide value
					jQuery('.slide_thumb[rel=0]').addClass('active');
				}
			})
			var n = jQuery( '.custom-direction-nav a' ).length;//defining a variable to store length of slides
			jQuery('.slide-numbers .total-slide-numb').append('0' + n);//append the total value to the html
		},
		before: function(slider){
			jQuery('.flex-caption.flex-active-slide').addClass("animated slideInUp");
			jQuery('.flex-caption.flex-active-slide').attr('style','display: block !important');
			jQuery('.flex-caption').hide();
		},
		after: function(slider){
			jQuery('.flex-caption.flex-active-slide').addClass("animated slideInUp");
			jQuery('.flex-caption.flex-active-slide').attr('style','display: block !important');
		},
	});


		//  Ajax Search Autocomplete
		$('#search_input').on('input', function() {
			$('.loading-wrapper').addClass('loading');
			$.ajax({
				url:reino_localize_script_param .ajaxurl,
				type:'POST',
				data:'action=reino_post_ajax_search&s='+jQuery('#search_input').val(),
				success:function(results) {
					$("#autocomplete").html(results);
					$('.loading-wrapper').removeClass('loading');
					if ( results != '' ){
						$("#autocomplete").addClass('visible');
						$("#autocomplete").show();
					}else{
						$("#autocomplete").hide();
					}
				}
			})
		});


		// Child Menu Toggle
		jQuery('.iva-children-indenter').on('click', function(){
			$(this).parent().parent().toggleClass('iva-menu-open');
			$(this).parent().parent().find('> ul').slideToggle();

			return false;
		});


		// Aivah Post Like
		$(document).on('click','.iva-love', function() {
			var $loveLink = $(this);
			var $id = $(this).attr('id');
			if($loveLink.hasClass('loved')) return false;
			var $sendTheData = {
				action: 'reino-love',
				loves_id: $id
			}
			$.post(ivaLove.ajaxurl, $sendTheData, function(data){
				$loveLink.find('span').html(data);
				$loveLink.addClass('loved').attr('title', ivaLove.youLikedit);
				$loveLink.find('span').css({'opacity': 1,'width':'auto'});
			});
			return false;
		});
	});


	jQuery(window).on('load', function($) {
		jQuery('.post-masonry-grid').masonry({
			itemSelector: '.item-grid',
			columnWidth: '.grid-sizer',
            percentPosition: true,
            fitWidth: true
		});
	});

})();

//Wait for window load
jQuery(window).load(function() {
	jQuery('.reino_page_loader').fadeOut(800);
});

/*!
 * Justified Gallery - v3.6.4
 * http://miromannino.github.io/Justified-Gallery/
 * Copyright (c) 2016 Miro Mannino
 * Licensed under the MIT license.
 */
!function(a){function b(){return a("body").height()>a(window).height()}var c=function(b,c){this.settings=c,this.checkSettings(),this.imgAnalyzerTimeout=null,this.entries=null,this.buildingRow={entriesBuff:[],width:0,height:0,aspectRatio:0},this.lastFetchedEntry=null,this.lastAnalyzedIndex=-1,this["yield"]={every:2,flushed:0},this.border=c.border>=0?c.border:c.margins,this.maxRowHeight=this.retrieveMaxRowHeight(),this.suffixRanges=this.retrieveSuffixRanges(),this.offY=this.border,this.rows=0,this.spinner={phase:0,timeSlot:150,$el:a('<div class="spinner"><span></span><span></span><span></span></div>'),intervalId:null},this.checkWidthIntervalId=null,this.galleryWidth=b.width(),this.$gallery=b};c.prototype.getSuffix=function(a,b){var c,d;for(c=a>b?a:b,d=0;d<this.suffixRanges.length;d++)if(c<=this.suffixRanges[d])return this.settings.sizeRangeSuffixes[this.suffixRanges[d]];return this.settings.sizeRangeSuffixes[this.suffixRanges[d-1]]},c.prototype.removeSuffix=function(a,b){return a.substring(0,a.length-b.length)},c.prototype.endsWith=function(a,b){return-1!==a.indexOf(b,a.length-b.length)},c.prototype.getUsedSuffix=function(a){for(var b in this.settings.sizeRangeSuffixes)if(this.settings.sizeRangeSuffixes.hasOwnProperty(b)){if(0===this.settings.sizeRangeSuffixes[b].length)continue;if(this.endsWith(a,this.settings.sizeRangeSuffixes[b]))return this.settings.sizeRangeSuffixes[b]}return""},c.prototype.newSrc=function(a,b,c,d){var e;if(this.settings.thumbnailPath)e=this.settings.thumbnailPath(a,b,c,d);else{var f=a.match(this.settings.extension),g=null!==f?f[0]:"";e=a.replace(this.settings.extension,""),e=this.removeSuffix(e,this.getUsedSuffix(e)),e+=this.getSuffix(b,c)+g}return e},c.prototype.showImg=function(a,b){this.settings.cssAnimation?(a.addClass("entry-visible"),b&&b()):(a.stop().fadeTo(this.settings.imagesAnimationDuration,1,b),a.find("> img, > a > img").stop().fadeTo(this.settings.imagesAnimationDuration,1,b))},c.prototype.extractImgSrcFromImage=function(a){var b="undefined"!=typeof a.data("safe-src")?a.data("safe-src"):a.attr("src");return a.data("jg.originalSrc",b),b},c.prototype.imgFromEntry=function(a){var b=a.find("> img");return 0===b.length&&(b=a.find("> a > img")),0===b.length?null:b},c.prototype.captionFromEntry=function(a){var b=a.find("> .caption");return 0===b.length?null:b},c.prototype.displayEntry=function(b,c,d,e,f,g){b.width(e),b.height(g),b.css("top",d),b.css("left",c);var h=this.imgFromEntry(b);if(null!==h){h.css("width",e),h.css("height",f),h.css("margin-left",-e/2),h.css("margin-top",-f/2);var i=h.attr("src"),j=this.newSrc(i,e,f,h[0]);h.one("error",function(){h.attr("src",h.data("jg.originalSrc"))});var k=function(){i!==j&&h.attr("src",j)};"skipped"===b.data("jg.loaded")?this.onImageEvent(i,a.proxy(function(){this.showImg(b,k),b.data("jg.loaded",!0)},this)):this.showImg(b,k)}else this.showImg(b);this.displayEntryCaption(b)},c.prototype.displayEntryCaption=function(b){var c=this.imgFromEntry(b);if(null!==c&&this.settings.captions){var d=this.captionFromEntry(b);if(null===d){var e=c.attr("alt");this.isValidCaption(e)||(e=b.attr("title")),this.isValidCaption(e)&&(d=a('<div class="caption">'+e+"</div>"),b.append(d),b.data("jg.createdCaption",!0))}null!==d&&(this.settings.cssAnimation||d.stop().fadeTo(0,this.settings.captionSettings.nonVisibleOpacity),this.addCaptionEventsHandlers(b))}else this.removeCaptionEventsHandlers(b)},c.prototype.isValidCaption=function(a){return"undefined"!=typeof a&&a.length>0},c.prototype.onEntryMouseEnterForCaption=function(b){var c=this.captionFromEntry(a(b.currentTarget));this.settings.cssAnimation?c.addClass("caption-visible").removeClass("caption-hidden"):c.stop().fadeTo(this.settings.captionSettings.animationDuration,this.settings.captionSettings.visibleOpacity)},c.prototype.onEntryMouseLeaveForCaption=function(b){var c=this.captionFromEntry(a(b.currentTarget));this.settings.cssAnimation?c.removeClass("caption-visible").removeClass("caption-hidden"):c.stop().fadeTo(this.settings.captionSettings.animationDuration,this.settings.captionSettings.nonVisibleOpacity)},c.prototype.addCaptionEventsHandlers=function(b){var c=b.data("jg.captionMouseEvents");"undefined"==typeof c&&(c={mouseenter:a.proxy(this.onEntryMouseEnterForCaption,this),mouseleave:a.proxy(this.onEntryMouseLeaveForCaption,this)},b.on("mouseenter",void 0,void 0,c.mouseenter),b.on("mouseleave",void 0,void 0,c.mouseleave),b.data("jg.captionMouseEvents",c))},c.prototype.removeCaptionEventsHandlers=function(a){var b=a.data("jg.captionMouseEvents");"undefined"!=typeof b&&(a.off("mouseenter",void 0,b.mouseenter),a.off("mouseleave",void 0,b.mouseleave),a.removeData("jg.captionMouseEvents"))},c.prototype.prepareBuildingRow=function(a){var b,c,d,e,f,g=!0,h=0,i=this.galleryWidth-2*this.border-(this.buildingRow.entriesBuff.length-1)*this.settings.margins,j=i/this.buildingRow.aspectRatio,k=this.settings.rowHeight,l=this.buildingRow.width/i>this.settings.justifyThreshold;if(a&&"hide"===this.settings.lastRow&&!l){for(b=0;b<this.buildingRow.entriesBuff.length;b++)c=this.buildingRow.entriesBuff[b],this.settings.cssAnimation?c.removeClass("entry-visible"):(c.stop().fadeTo(0,.1),c.find("> img, > a > img").fadeTo(0,0));return-1}for(a&&!l&&"justify"!==this.settings.lastRow&&"hide"!==this.settings.lastRow&&(g=!1,this.rows>0&&(k=(this.offY-this.border-this.settings.margins*this.rows)/this.rows,g=k*this.buildingRow.aspectRatio/i>this.settings.justifyThreshold)),b=0;b<this.buildingRow.entriesBuff.length;b++)c=this.buildingRow.entriesBuff[b],d=c.data("jg.width")/c.data("jg.height"),g?(e=b===this.buildingRow.entriesBuff.length-1?i:j*d,f=j):(e=k*d,f=k),i-=Math.round(e),c.data("jg.jwidth",Math.round(e)),c.data("jg.jheight",Math.ceil(f)),(0===b||h>f)&&(h=f);return this.buildingRow.height=h,g},c.prototype.clearBuildingRow=function(){this.buildingRow.entriesBuff=[],this.buildingRow.aspectRatio=0,this.buildingRow.width=0},c.prototype.flushRow=function(a){var b,c,d,e=this.settings,f=this.border;if(c=this.prepareBuildingRow(a),a&&"hide"===e.lastRow&&-1===c)return void this.clearBuildingRow();if(this.maxRowHeight&&(this.maxRowHeight.isPercentage&&this.maxRowHeight.value*e.rowHeight<this.buildingRow.height?this.buildingRow.height=this.maxRowHeight.value*e.rowHeight:this.maxRowHeight.value>=e.rowHeight&&this.maxRowHeight.value<this.buildingRow.height&&(this.buildingRow.height=this.maxRowHeight.value)),"center"===e.lastRow||"right"===e.lastRow){var g=this.galleryWidth-2*this.border-(this.buildingRow.entriesBuff.length-1)*e.margins;for(d=0;d<this.buildingRow.entriesBuff.length;d++)b=this.buildingRow.entriesBuff[d],g-=b.data("jg.jwidth");"center"===e.lastRow?f+=g/2:"right"===e.lastRow&&(f+=g)}for(d=0;d<this.buildingRow.entriesBuff.length;d++)b=this.buildingRow.entriesBuff[d],this.displayEntry(b,f,this.offY,b.data("jg.jwidth"),b.data("jg.jheight"),this.buildingRow.height),f+=b.data("jg.jwidth")+e.margins;this.galleryHeightToSet=this.offY+this.buildingRow.height+this.border,this.$gallery.height(this.galleryHeightToSet+this.getSpinnerHeight()),(!a||this.buildingRow.height<=e.rowHeight&&c)&&(this.offY+=this.buildingRow.height+e.margins,this.rows+=1,this.clearBuildingRow(),this.$gallery.trigger("jg.rowflush"))};var d=!1;c.prototype.checkWidth=function(){this.checkWidthIntervalId=setInterval(a.proxy(function(){var a=parseFloat(this.$gallery.width());b()===d?Math.abs(a-this.galleryWidth)>this.settings.refreshSensitivity&&(this.galleryWidth=a,this.rewind(),this.startImgAnalyzer(!0)):(d=b(),this.galleryWidth=a)},this),this.settings.refreshTime)},c.prototype.isSpinnerActive=function(){return null!==this.spinner.intervalId},c.prototype.getSpinnerHeight=function(){return this.spinner.$el.innerHeight()},c.prototype.stopLoadingSpinnerAnimation=function(){clearInterval(this.spinner.intervalId),this.spinner.intervalId=null,this.$gallery.height(this.$gallery.height()-this.getSpinnerHeight()),this.spinner.$el.detach()},c.prototype.startLoadingSpinnerAnimation=function(){var a=this.spinner,b=a.$el.find("span");clearInterval(a.intervalId),this.$gallery.append(a.$el),this.$gallery.height(this.offY+this.buildingRow.height+this.getSpinnerHeight()),a.intervalId=setInterval(function(){a.phase<b.length?b.eq(a.phase).fadeTo(a.timeSlot,1):b.eq(a.phase-b.length).fadeTo(a.timeSlot,0),a.phase=(a.phase+1)%(2*b.length)},a.timeSlot)},c.prototype.rewind=function(){this.lastFetchedEntry=null,this.lastAnalyzedIndex=-1,this.offY=this.border,this.rows=0,this.clearBuildingRow()},c.prototype.updateEntries=function(b){var c;return b&&null!=this.lastFetchedEntry?c=a(this.lastFetchedEntry).nextAll(this.settings.selector).toArray():(this.entries=[],c=this.$gallery.children(this.settings.selector).toArray()),c.length>0&&(a.isFunction(this.settings.sort)?c=this.sortArray(c):this.settings.randomize&&(c=this.shuffleArray(c)),this.lastFetchedEntry=c[c.length-1],this.settings.filter?c=this.filterArray(c):this.resetFilters(c)),this.entries=this.entries.concat(c),!0},c.prototype.insertToGallery=function(b){var c=this;a.each(b,function(){a(this).appendTo(c.$gallery)})},c.prototype.shuffleArray=function(a){var b,c,d;for(b=a.length-1;b>0;b--)c=Math.floor(Math.random()*(b+1)),d=a[b],a[b]=a[c],a[c]=d;return this.insertToGallery(a),a},c.prototype.sortArray=function(a){return a.sort(this.settings.sort),this.insertToGallery(a),a},c.prototype.resetFilters=function(b){for(var c=0;c<b.length;c++)a(b[c]).removeClass("jg-filtered")},c.prototype.filterArray=function(b){var c=this.settings;if("string"===a.type(c.filter))return b.filter(function(b){var d=a(b);return d.is(c.filter)?(d.removeClass("jg-filtered"),!0):(d.addClass("jg-filtered").removeClass("jg-visible"),!1)});if(a.isFunction(c.filter)){for(var d=b.filter(c.filter),e=0;e<b.length;e++)-1===d.indexOf(b[e])?a(b[e]).addClass("jg-filtered").removeClass("jg-visible"):a(b[e]).removeClass("jg-filtered");return d}},c.prototype.destroy=function(){clearInterval(this.checkWidthIntervalId),a.each(this.entries,a.proxy(function(b,c){var d=a(c);d.css("width",""),d.css("height",""),d.css("top",""),d.css("left",""),d.data("jg.loaded",void 0),d.removeClass("jg-entry");var e=this.imgFromEntry(d);e.css("width",""),e.css("height",""),e.css("margin-left",""),e.css("margin-top",""),e.attr("src",e.data("jg.originalSrc")),e.data("jg.originalSrc",void 0),this.removeCaptionEventsHandlers(d);var f=this.captionFromEntry(d);d.data("jg.createdCaption")?(d.data("jg.createdCaption",void 0),null!==f&&f.remove()):null!==f&&f.fadeTo(0,1)},this)),this.$gallery.css("height",""),this.$gallery.removeClass("justified-gallery"),this.$gallery.data("jg.controller",void 0)},c.prototype.analyzeImages=function(b){for(var c=this.lastAnalyzedIndex+1;c<this.entries.length;c++){var d=a(this.entries[c]);if(d.data("jg.loaded")===!0||"skipped"===d.data("jg.loaded")){var e=this.galleryWidth-2*this.border-(this.buildingRow.entriesBuff.length-1)*this.settings.margins,f=d.data("jg.width")/d.data("jg.height");if(e/(this.buildingRow.aspectRatio+f)<this.settings.rowHeight&&(this.flushRow(!1),++this["yield"].flushed>=this["yield"].every))return void this.startImgAnalyzer(b);this.buildingRow.entriesBuff.push(d),this.buildingRow.aspectRatio+=f,this.buildingRow.width+=f*this.settings.rowHeight,this.lastAnalyzedIndex=c}else if("error"!==d.data("jg.loaded"))return}this.buildingRow.entriesBuff.length>0&&this.flushRow(!0),this.isSpinnerActive()&&this.stopLoadingSpinnerAnimation(),this.stopImgAnalyzerStarter(),this.$gallery.trigger(b?"jg.resize":"jg.complete"),this.$gallery.height(this.galleryHeightToSet)},c.prototype.stopImgAnalyzerStarter=function(){this["yield"].flushed=0,null!==this.imgAnalyzerTimeout&&clearTimeout(this.imgAnalyzerTimeout)},c.prototype.startImgAnalyzer=function(a){var b=this;this.stopImgAnalyzerStarter(),this.imgAnalyzerTimeout=setTimeout(function(){b.analyzeImages(a)},.001)},c.prototype.onImageEvent=function(b,c,d){if(c||d){var e=new Image,f=a(e);c&&f.one("load",function(){f.off("load error"),c(e)}),d&&f.one("error",function(){f.off("load error"),d(e)}),e.src=b}},c.prototype.init=function(){var b=!1,c=!1,d=this;a.each(this.entries,function(e,f){var g=a(f),h=d.imgFromEntry(g);if(g.addClass("jg-entry"),g.data("jg.loaded")!==!0&&"skipped"!==g.data("jg.loaded"))if(null!==d.settings.rel&&g.attr("rel",d.settings.rel),null!==d.settings.target&&g.attr("target",d.settings.target),null!==h){var i=d.extractImgSrcFromImage(h);if(h.attr("src",i),d.settings.waitThumbnailsLoad===!1){var j=parseFloat(h.attr("width")),k=parseFloat(h.attr("height"));if(!isNaN(j)&&!isNaN(k))return g.data("jg.width",j),g.data("jg.height",k),g.data("jg.loaded","skipped"),c=!0,d.startImgAnalyzer(!1),!0}g.data("jg.loaded",!1),b=!0,d.isSpinnerActive()||d.startLoadingSpinnerAnimation(),d.onImageEvent(i,function(a){g.data("jg.width",a.width),g.data("jg.height",a.height),g.data("jg.loaded",!0),d.startImgAnalyzer(!1)},function(){g.data("jg.loaded","error"),d.startImgAnalyzer(!1)})}else g.data("jg.loaded",!0),g.data("jg.width",g.width()|parseFloat(g.css("width"))|1),g.data("jg.height",g.height()|parseFloat(g.css("height"))|1)}),b||c||this.startImgAnalyzer(!1),this.checkWidth()},c.prototype.checkOrConvertNumber=function(b,c){if("string"===a.type(b[c])&&(b[c]=parseFloat(b[c])),"number"!==a.type(b[c]))throw c+" must be a number";if(isNaN(b[c]))throw"invalid number for "+c},c.prototype.checkSizeRangesSuffixes=function(){if("object"!==a.type(this.settings.sizeRangeSuffixes))throw"sizeRangeSuffixes must be defined and must be an object";var b=[];for(var c in this.settings.sizeRangeSuffixes)this.settings.sizeRangeSuffixes.hasOwnProperty(c)&&b.push(c);for(var d={0:""},e=0;e<b.length;e++)if("string"===a.type(b[e]))try{var f=parseInt(b[e].replace(/^[a-z]+/,""),10);d[f]=this.settings.sizeRangeSuffixes[b[e]]}catch(g){throw"sizeRangeSuffixes keys must contains correct numbers ("+g+")"}else d[b[e]]=this.settings.sizeRangeSuffixes[b[e]];this.settings.sizeRangeSuffixes=d},c.prototype.retrieveMaxRowHeight=function(){var b={};if("string"===a.type(this.settings.maxRowHeight))this.settings.maxRowHeight.match(/^[0-9]+%$/)?(b.value=parseFloat(this.settings.maxRowHeight.match(/^([0-9]+)%$/)[1])/100,b.isPercentage=!1):(b.value=parseFloat(this.settings.maxRowHeight),b.isPercentage=!0);else{if("number"!==a.type(this.settings.maxRowHeight)){if(this.settings.maxRowHeight===!1||null===this.settings.maxRowHeight||"undefined"==typeof this.settings.maxRowHeight)return null;throw"maxRowHeight must be a number or a percentage"}b.value=this.settings.maxRowHeight,b.isPercentage=!1}if(isNaN(b.value))throw"invalid number for maxRowHeight";return b.isPercentage&&b.value<100&&(b.value=100),b},c.prototype.checkSettings=function(){this.checkSizeRangesSuffixes(),this.checkOrConvertNumber(this.settings,"rowHeight"),this.checkOrConvertNumber(this.settings,"margins"),this.checkOrConvertNumber(this.settings,"border");var b=["justify","nojustify","left","center","right","hide"];if(-1===b.indexOf(this.settings.lastRow))throw"lastRow must be one of: "+b.join(", ");if(this.checkOrConvertNumber(this.settings,"justifyThreshold"),this.settings.justifyThreshold<0||this.settings.justifyThreshold>1)throw"justifyThreshold must be in the interval [0,1]";if("boolean"!==a.type(this.settings.cssAnimation))throw"cssAnimation must be a boolean";if("boolean"!==a.type(this.settings.captions))throw"captions must be a boolean";if(this.checkOrConvertNumber(this.settings.captionSettings,"animationDuration"),this.checkOrConvertNumber(this.settings.captionSettings,"visibleOpacity"),this.settings.captionSettings.visibleOpacity<0||this.settings.captionSettings.visibleOpacity>1)throw"captionSettings.visibleOpacity must be in the interval [0, 1]";if(this.checkOrConvertNumber(this.settings.captionSettings,"nonVisibleOpacity"),this.settings.captionSettings.nonVisibleOpacity<0||this.settings.captionSettings.nonVisibleOpacity>1)throw"captionSettings.nonVisibleOpacity must be in the interval [0, 1]";if(this.checkOrConvertNumber(this.settings,"imagesAnimationDuration"),this.checkOrConvertNumber(this.settings,"refreshTime"),this.checkOrConvertNumber(this.settings,"refreshSensitivity"),"boolean"!==a.type(this.settings.randomize))throw"randomize must be a boolean";if("string"!==a.type(this.settings.selector))throw"selector must be a string";if(this.settings.sort!==!1&&!a.isFunction(this.settings.sort))throw"sort must be false or a comparison function";if(this.settings.filter!==!1&&!a.isFunction(this.settings.filter)&&"string"!==a.type(this.settings.filter))throw"filter must be false, a string or a filter function"},c.prototype.retrieveSuffixRanges=function(){var a=[];for(var b in this.settings.sizeRangeSuffixes)this.settings.sizeRangeSuffixes.hasOwnProperty(b)&&a.push(parseInt(b,10));return a.sort(function(a,b){return a>b?1:b>a?-1:0}),a},c.prototype.updateSettings=function(b){this.settings=a.extend({},this.settings,b),this.checkSettings(),this.border=this.settings.border>=0?this.settings.border:this.settings.margins,this.maxRowHeight=this.retrieveMaxRowHeight(),this.suffixRanges=this.retrieveSuffixRanges()},a.fn.justifiedGallery=function(b){return this.each(function(d,e){var f=a(e);f.addClass("justified-gallery");var g=f.data("jg.controller");if("undefined"==typeof g){if("undefined"!=typeof b&&null!==b&&"object"!==a.type(b)){if("destroy"===b)return;throw"The argument must be an object"}g=new c(f,a.extend({},a.fn.justifiedGallery.defaults,b)),f.data("jg.controller",g)}else if("norewind"===b);else{if("destroy"===b)return void g.destroy();g.updateSettings(b),g.rewind()}g.updateEntries("norewind"===b)&&g.init()})},a.fn.justifiedGallery.defaults={sizeRangeSuffixes:{},thumbnailPath:void 0,rowHeight:120,maxRowHeight:!1,margins:1,border:-1,lastRow:"nojustify",justifyThreshold:.9,waitThumbnailsLoad:!0,captions:!0,cssAnimation:!0,imagesAnimationDuration:500,captionSettings:{animationDuration:500,visibleOpacity:.7,nonVisibleOpacity:0},rel:null,target:null,extension:/\.[^.\\/]+$/,refreshTime:200,refreshSensitivity:0,randomize:!1,sort:!1,filter:!1,selector:"a, div:not(.spinner)"}}(jQuery);
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/
!function(t){"use strict";t.fn.fitVids=function(e){var i={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var r=document.head||document.getElementsByTagName("head")[0],a=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}",d=document.createElement("div");d.innerHTML='<p>x</p><style id="fit-vids-style">'+a+"</style>",r.appendChild(d.childNodes[1])}return e&&t.extend(i,e),this.each(function(){var e=['iframe[src*="player.vimeo.com"]','iframe[src*="youtube.com"]','iframe[src*="youtube-nocookie.com"]','iframe[src*="kickstarter.com"][src*="video.html"]',"object","embed"];i.customSelector&&e.push(i.customSelector);var r=".fitvidsignore";i.ignore&&(r=r+", "+i.ignore);var a=t(this).find(e.join(","));a=a.not("object object"),a=a.not(r),a.each(function(){var e=t(this);if(!(e.parents(r).length>0||"embed"===this.tagName.toLowerCase()&&e.parent("object").length||e.parent(".fluid-width-video-wrapper").length)){e.css("height")||e.css("width")||!isNaN(e.attr("height"))&&!isNaN(e.attr("width"))||(e.attr("height",9),e.attr("width",16));var i="object"===this.tagName.toLowerCase()||e.attr("height")&&!isNaN(parseInt(e.attr("height"),10))?parseInt(e.attr("height"),10):e.height(),a=isNaN(parseInt(e.attr("width"),10))?e.width():parseInt(e.attr("width"),10),d=i/a;if(!e.attr("name")){var o="fitvid"+t.fn.fitVids._count;e.attr("name",o),t.fn.fitVids._count++}e.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*d+"%"),e.removeAttr("height").removeAttr("width")}})})},t.fn.fitVids._count=0}(window.jQuery||window.Zepto);

/*!
 * hoverIntent v1.8.1 // 2014.08.11 // jQuery v1.9.1+
 * http://briancherne.github.io/jquery-hoverIntent/
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2014 Brian Cherne
 */

/* hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):jQuery&&!jQuery.fn.hoverIntent&&e(jQuery)}(function(e){"use strict";var t,n,o={interval:100,sensitivity:6,timeout:0},i=0,u=function(e){t=e.pageX,n=e.pageY},r=function(e,o,i,v){return Math.sqrt((i.pX-t)*(i.pX-t)+(i.pY-n)*(i.pY-n))<v.sensitivity?(o.off(i.event,u),delete i.timeoutId,i.isActive=!0,e.pageX=t,e.pageY=n,delete i.pX,delete i.pY,v.over.apply(o[0],[e])):(i.pX=t,i.pY=n,i.timeoutId=setTimeout(function(){r(e,o,i,v)},v.interval),void 0)},v=function(e,t,n,o){return delete t.data("hoverIntent")[n.id],o.apply(t[0],[e])};e.fn.hoverIntent=function(t,n,a){var s=i++,d=e.extend({},o);e.isPlainObject(t)?(d=e.extend(d,t),e.isFunction(d.out)||(d.out=d.over)):d=e.isFunction(n)?e.extend(d,{over:t,out:n,selector:a}):e.extend(d,{over:t,out:t,selector:n});var f=function(t){var n=e.extend({},t),o=e(this),i=o.data("hoverIntent");i||o.data("hoverIntent",i={});var a=i[s];a||(i[s]=a={id:s}),a.timeoutId&&(a.timeoutId=clearTimeout(a.timeoutId));var f=a.event="mousemove.hoverIntent.hoverIntent"+s;if("mouseenter"===t.type){if(a.isActive)return;a.pX=n.pageX,a.pY=n.pageY,o.off(f,u).on(f,u),a.timeoutId=setTimeout(function(){r(n,o,a,d)},d.interval)}else{if(!a.isActive)return;o.off(f,u),a.timeoutId=setTimeout(function(){v(n,o,a,d.out)},d.timeout)}};return this.on({"mouseenter.hoverIntent":f,"mouseleave.hoverIntent":f},d.selector)}});

/*!
Waypoints - 4.0.1
Copyright © 2011-2016 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blob/master/licenses.txt
*/
!function(){"use strict";function t(o){if(!o)throw new Error("No options passed to Waypoint constructor");if(!o.element)throw new Error("No element option passed to Waypoint constructor");if(!o.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+e,this.options=t.Adapter.extend({},t.defaults,o),this.element=this.options.element,this.adapter=new t.Adapter(this.element),this.callback=o.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=t.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=t.Context.findOrCreateByElement(this.options.context),t.offsetAliases[this.options.offset]&&(this.options.offset=t.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),i[this.key]=this,e+=1}var e=0,i={};t.prototype.queueTrigger=function(t){this.group.queueTrigger(this,t)},t.prototype.trigger=function(t){this.enabled&&this.callback&&this.callback.apply(this,t)},t.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete i[this.key]},t.prototype.disable=function(){return this.enabled=!1,this},t.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},t.prototype.next=function(){return this.group.next(this)},t.prototype.previous=function(){return this.group.previous(this)},t.invokeAll=function(t){var e=[];for(var o in i)e.push(i[o]);for(var n=0,r=e.length;r>n;n++)e[n][t]()},t.destroyAll=function(){t.invokeAll("destroy")},t.disableAll=function(){t.invokeAll("disable")},t.enableAll=function(){t.Context.refreshAll();for(var e in i)i[e].enabled=!0;return this},t.refreshAll=function(){t.Context.refreshAll()},t.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},t.viewportWidth=function(){return document.documentElement.clientWidth},t.adapters=[],t.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},t.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=t}(),function(){"use strict";function t(t){window.setTimeout(t,1e3/60)}function e(t){this.element=t,this.Adapter=n.Adapter,this.adapter=new this.Adapter(t),this.key="waypoint-context-"+i,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},t.waypointContextKey=this.key,o[t.waypointContextKey]=this,i+=1,n.windowContext||(n.windowContext=!0,n.windowContext=new e(window)),this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}var i=0,o={},n=window.Waypoint,r=window.onload;e.prototype.add=function(t){var e=t.options.horizontal?"horizontal":"vertical";this.waypoints[e][t.key]=t,this.refresh()},e.prototype.checkEmpty=function(){var t=this.Adapter.isEmptyObject(this.waypoints.horizontal),e=this.Adapter.isEmptyObject(this.waypoints.vertical),i=this.element==this.element.window;t&&e&&!i&&(this.adapter.off(".waypoints"),delete o[this.key])},e.prototype.createThrottledResizeHandler=function(){function t(){e.handleResize(),e.didResize=!1}var e=this;this.adapter.on("resize.waypoints",function(){e.didResize||(e.didResize=!0,n.requestAnimationFrame(t))})},e.prototype.createThrottledScrollHandler=function(){function t(){e.handleScroll(),e.didScroll=!1}var e=this;this.adapter.on("scroll.waypoints",function(){(!e.didScroll||n.isTouch)&&(e.didScroll=!0,n.requestAnimationFrame(t))})},e.prototype.handleResize=function(){n.Context.refreshAll()},e.prototype.handleScroll=function(){var t={},e={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var i in e){var o=e[i],n=o.newScroll>o.oldScroll,r=n?o.forward:o.backward;for(var s in this.waypoints[i]){var a=this.waypoints[i][s];if(null!==a.triggerPoint){var l=o.oldScroll<a.triggerPoint,h=o.newScroll>=a.triggerPoint,p=l&&h,u=!l&&!h;(p||u)&&(a.queueTrigger(r),t[a.group.id]=a.group)}}}for(var c in t)t[c].flushTriggers();this.oldScroll={x:e.horizontal.newScroll,y:e.vertical.newScroll}},e.prototype.innerHeight=function(){return this.element==this.element.window?n.viewportHeight():this.adapter.innerHeight()},e.prototype.remove=function(t){delete this.waypoints[t.axis][t.key],this.checkEmpty()},e.prototype.innerWidth=function(){return this.element==this.element.window?n.viewportWidth():this.adapter.innerWidth()},e.prototype.destroy=function(){var t=[];for(var e in this.waypoints)for(var i in this.waypoints[e])t.push(this.waypoints[e][i]);for(var o=0,n=t.length;n>o;o++)t[o].destroy()},e.prototype.refresh=function(){var t,e=this.element==this.element.window,i=e?void 0:this.adapter.offset(),o={};this.handleScroll(),t={horizontal:{contextOffset:e?0:i.left,contextScroll:e?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:e?0:i.top,contextScroll:e?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};for(var r in t){var s=t[r];for(var a in this.waypoints[r]){var l,h,p,u,c,d=this.waypoints[r][a],f=d.options.offset,w=d.triggerPoint,y=0,g=null==w;d.element!==d.element.window&&(y=d.adapter.offset()[s.offsetProp]),"function"==typeof f?f=f.apply(d):"string"==typeof f&&(f=parseFloat(f),d.options.offset.indexOf("%")>-1&&(f=Math.ceil(s.contextDimension*f/100))),l=s.contextScroll-s.contextOffset,d.triggerPoint=Math.floor(y+l-f),h=w<s.oldScroll,p=d.triggerPoint>=s.oldScroll,u=h&&p,c=!h&&!p,!g&&u?(d.queueTrigger(s.backward),o[d.group.id]=d.group):!g&&c?(d.queueTrigger(s.forward),o[d.group.id]=d.group):g&&s.oldScroll>=d.triggerPoint&&(d.queueTrigger(s.forward),o[d.group.id]=d.group)}}return n.requestAnimationFrame(function(){for(var t in o)o[t].flushTriggers()}),this},e.findOrCreateByElement=function(t){return e.findByElement(t)||new e(t)},e.refreshAll=function(){for(var t in o)o[t].refresh()},e.findByElement=function(t){return o[t.waypointContextKey]},window.onload=function(){r&&r(),e.refreshAll()},n.requestAnimationFrame=function(e){var i=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||t;i.call(window,e)},n.Context=e}(),function(){"use strict";function t(t,e){return t.triggerPoint-e.triggerPoint}function e(t,e){return e.triggerPoint-t.triggerPoint}function i(t){this.name=t.name,this.axis=t.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),o[this.axis][this.name]=this}var o={vertical:{},horizontal:{}},n=window.Waypoint;i.prototype.add=function(t){this.waypoints.push(t)},i.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},i.prototype.flushTriggers=function(){for(var i in this.triggerQueues){var o=this.triggerQueues[i],n="up"===i||"left"===i;o.sort(n?e:t);for(var r=0,s=o.length;s>r;r+=1){var a=o[r];(a.options.continuous||r===o.length-1)&&a.trigger([i])}}this.clearTriggerQueues()},i.prototype.next=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints),o=i===this.waypoints.length-1;return o?null:this.waypoints[i+1]},i.prototype.previous=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints);return i?this.waypoints[i-1]:null},i.prototype.queueTrigger=function(t,e){this.triggerQueues[e].push(t)},i.prototype.remove=function(t){var e=n.Adapter.inArray(t,this.waypoints);e>-1&&this.waypoints.splice(e,1)},i.prototype.first=function(){return this.waypoints[0]},i.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},i.findOrCreate=function(t){return o[t.axis][t.name]||new i(t)},n.Group=i}(),function(){"use strict";function t(t){this.$element=e(t)}var e=window.jQuery,i=window.Waypoint;e.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],function(e,i){t.prototype[i]=function(){var t=Array.prototype.slice.call(arguments);return this.$element[i].apply(this.$element,t)}}),e.each(["extend","inArray","isEmptyObject"],function(i,o){t[o]=e[o]}),i.adapters.push({name:"jquery",Adapter:t}),i.Adapter=t}(),function(){"use strict";function t(t){return function(){var i=[],o=arguments[0];return t.isFunction(arguments[0])&&(o=t.extend({},arguments[1]),o.handler=arguments[0]),this.each(function(){var n=t.extend({},o,{element:this});"string"==typeof n.context&&(n.context=t(this).closest(n.context)[0]),i.push(new e(n))}),i}}var e=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=t(window.jQuery)),window.Zepto&&(window.Zepto.fn.waypoint=t(window.Zepto))}();

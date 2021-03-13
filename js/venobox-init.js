(function($){
	if ( ! venoboxVars.disabled ) {
		$(document).ready(function($){

			// legacy data attributes mark up change if checked.
			if(venoboxVars.ng_vb_legacy_markup) {
				$('a[data-type="youtube"]').removeAttr( "data-type", "youtube" ).attr("data-vbtype","video");
				$('a[data-type="vimeo"]').removeAttr( "data-type", "vimeo" ).attr("data-vbtype","video");
				$('a[data-type="iframe"]').removeAttr( "data-type", "iframe" ).attr("data-vbtype","iframe");
				$('a[data-type="inline"]').removeAttr( "data-type", "inline" ).attr("data-vbtype","inline");
				$('a[data-type="ajax"]').removeAttr( "data-type", "ajax" ).attr("data-vbtype","ajax");
			}

			// Init main Venobox
			if(venoboxVars.ng_all_images) {
				imagesVeno();
				galleryVeno();
			}
			if(venoboxVars.ng_all_videos) {
				videoVeno();
			}
			defaultVeno();
		});

		// Detects the end of an ajax request being made for Search & Filter Pro
		if(venoboxVars.ng_vb_searchfp) {
			$(document).on('sf:ajaxfinish', '.searchandfilter', function() {
				if(venoboxVars.ng_all_images) {
					imagesVeno();
					galleryVeno();
				}
				if(venoboxVars.ng_all_videos) {
					videoVeno();
				}
				defaultVeno();
			});
		}

		// Detects the end of an ajax request being made for Facet WP
		if(venoboxVars.ng_vb_facetwp) {
			$(document).on('facetwp-loaded', function() {
				if(venoboxVars.ng_all_images) {
					imagesVeno();
					galleryVeno();
				}
				if(venoboxVars.ng_all_videos) {
					videoVeno();
				}
				defaultVeno();
			});
		}

		// Images
		function imagesVeno() {
			var boxlinks = $('a[href]').filter(function(){
				return /[.](png|gif|jpg|jpeg|webp)$/.test(this.href.toLowerCase());
			});

			$(boxlinks).each(function() {
				if (this.href.indexOf('?') < 0) {
					boxlinks.addClass('venobox');
					// Dont replace the data-gall if already set
					if( !$(this).attr('data-gall') ) {
						$(this).attr('data-gall', 'gallery' );
					}
					// Set Title from one of three options
					if(venoboxVars.ng_title_select == 1) {
						$(this).attr("title", $(this).find("img").attr("alt"));
					}
					else if (venoboxVars.ng_title_select == 2){
						$(this).attr("title", $(this).find("img").attr("title"));
					}
					else if (venoboxVars.ng_title_select == 3){
						$(this).attr("title", $(this).closest('.wp-caption, .gallery-item').find(".wp-caption-text").text());
					}
					else {
						return;
					}
				}
			});
		}

		// Galleries
		function galleryVeno() {
			// Set galleries to have unique data-gall sets
			$('div[id^="gallery"], .gallery-row').each(function(index) {
				$(this).find('a').attr('data-gall', 'venoset-'+index);
			});
			// Jetpacks caption as title
			$('.tiled-gallery-item a').each( function() {
				if (venoboxVars.ng_title_select == 3) {
				$(this).attr("title", $(this).parent('.tiled-gallery-item').find(".tiled-gallery-caption").text());
				}

			});
		}

		// Videos
		function videoVeno() {
			var vidlinks =  $('a[href]').filter('[href*="//vimeo.com"], [href*="//youtu"]');
			$(vidlinks).each(function() {
				vidlinks.addClass('venobox').attr( 'data-vbtype', 'video');
				// Dont replace the data-gall if already set
				if(!$(this).attr('data-gall')) {
					$(this).attr('data-gall', 'gallery' );
				}
			});
		}

		// Convert values from 0/1 to false/true
		var ng_numeratio = false, ng_infinigall = false, ng_autoplay = false, ng_arrows = false;
		if (venoboxVars.ng_numeratio ) {
			ng_numeratio = true;
		}
		if (venoboxVars.ng_infinigall ) {
			ng_infinigall = true;
		}
		if (venoboxVars.ng_autoplay ) {
			ng_autoplay = true;
		}
		if (venoboxVars.ng_arrows ) {
			ng_arrows = true;
		}
		// Default settings
		function defaultVeno() {
			$('.venobox').venobox({
				noArrows: ng_arrows, // default: false
				border: venoboxVars.ng_border_width,
				bgcolor: venoboxVars.ng_border_color,
				numeratio: ng_numeratio, // default: false
				numerationPosition: venoboxVars.ng_numeratio_position,
				infinigall: ng_infinigall, // default: false
				autoplay: ng_autoplay, // default: false
				overlayColor: venoboxVars.ng_overlay,
				closeBackground: 'transparent',
				numerationBackground: 'transparent',
				titleBackground:  venoboxVars.ng_nav_elements_bg,
				spinner: venoboxVars.ng_preloader,
				titlePosition: venoboxVars.ng_title_position,
				arrowsColor: venoboxVars.ng_nav_elements,
				closeColor: venoboxVars.ng_nav_elements,
				numerationColor: venoboxVars.ng_nav_elements,
				titleColor: venoboxVars.ng_nav_elements,
				spinColor: venoboxVars.ng_nav_elements,
				share: venoboxVars.ng_vb_share
			});
		}
	} // end if disabled
})(jQuery);
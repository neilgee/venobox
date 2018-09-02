jQuery(document).ready(function($){
	
    // detects the end of an ajax request being made
    $(document).on("sf:ajaxfinish", ".searchandfilter", function(){
        

	//Images
	$('a[href]').filter('[href$=".png"], [href$=".gif"], [href$=".jpg"], [href$=".jpeg"]').each(function() {

			var boxlinks =  $('a[href]').filter('[href$=".png"], [href$=".gif"], [href$=".jpg"], [href$=".jpeg"]');

		if (this.href.indexOf('?') < 0) {
			if(venoboxVars.ng_venobox.ng_all_images) {
			  boxlinks.addClass('venobox');
			}

			// Dont replace the data-gall if already set
			if(venoboxVars.ng_venobox.ng_all_lightbox && !$(this).attr('data-gall')) {
			$(this).attr('data-gall', 'gallery' );
			}

			// Set Title from one of three options
			if(venoboxVars.ng_venobox.ng_title_select == 1) {
			  $(this).attr("title", $(this).find("img").attr("alt"));
			}
			else if (venoboxVars.ng_venobox.ng_title_select == 2){
			  $(this).attr("title", $(this).find("img").attr("title"));
			}
			else if (venoboxVars.ng_venobox.ng_title_select == 3){
			  $(this).attr("title", $(this).closest('.wp-caption, .gallery-item').find(".wp-caption-text").text());
			}
			else {
				return;
			}

		}

	});

	// Videos
	$('a[href]').filter('[href*="//vimeo.com"], [href*="//youtu"]').each(function() {

	var vidlinks =  $('a[href]').filter('[href*="//vimeo.com"], [href*="//youtu"]');

	 if(venoboxVars.ng_venobox.ng_all_videos) {
	    vidlinks.addClass('venobox').filter('[href*="//vimeo.com"]').attr( 'data-vbtype', 'video');
		vidlinks.filter('[href*="//youtu"]').attr( 'data-vbtype', 'video');
	}
	// Dont replace the data-gall if already set
	if(!$(this).attr('data-gall')) {
	 $(this).attr('data-gall', 'gallery' );
	}

	});


  // default settings
  $('.venobox').venobox({
   // border: venoboxVars.ng_venobox.ng_border_width, doing this in CSS
   // framewidth: '1600px',   // default: ''
   // frameheight: '1000px',  // default: ''
   // bgcolor: venoboxVars.ng_venobox.ng_border_color, doing this in CSS
    numeratio: venoboxVars.ng_venobox.ng_numeratio,	// default: false
	numerationPosition: venoboxVars.ng_venobox.ng_numeratio_position,
   //gallItems: false,
    infinigall: venoboxVars.ng_venobox.ng_infinigall,	// default: false
    autoplay: venoboxVars.ng_venobox.ng_autoplay,	// default: false
    overlayColor: venoboxVars.ng_venobox.ng_overlay,
    closeBackground: 'transparent',
    numerationBackground: 'transparent',
    titleBackground:  venoboxVars.ng_venobox.ng_overlay,
    spinner: venoboxVars.ng_venobox.ng_preloader,
    titlePosition: venoboxVars.ng_venobox.ng_title_position,
    arrowsColor: venoboxVars.ng_venobox.ng_nav_elements,
    closeColor: venoboxVars.ng_venobox.ng_nav_elements,
    numerationColor: venoboxVars.ng_venobox.ng_nav_elements,
    titleColor: venoboxVars.ng_venobox.ng_nav_elements,
    spinColor: venoboxVars.ng_venobox.ng_nav_elements,
  });



	 // Set galleries to have unique data-gall sets
	 $('div[id^="gallery"]').each(function(index) {
	    $(this).find('a').attr('data-gall', 'venoset-'+index);
	 });

	$('.gallery-row').each(function(index) {
		$(this).find('a').attr('data-gall', 'venoset-jp-'+index);
	});

	// Jetpacks caption as title
	$('.tiled-gallery-item a').each( function() {
		if (venoboxVars.ng_venobox.ng_title_select == 3) {
		$(this).attr("title", $(this).parent('.tiled-gallery-item').find(".tiled-gallery-caption").text());
		}
	
	});


 
     });
     
});
	    
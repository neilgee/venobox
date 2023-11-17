var VenoboxWP = (function(){
    "use strict";

	// Convert values from 0/1 to false/true
	var ng_numeratio = false, ng_infinigall = false, ng_autoplay = false, ng_arrows = true, ng_nav_keyboard = true, ng_nav_touch = true;
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
		ng_arrows = false;
	}
	if (venoboxVars.ng_nav_keyboard ) {
		ng_nav_keyboard = false;
	}
	if (venoboxVars.ng_nav_touch ) {
		ng_nav_touch = false;
	}

	// Detects the end of an ajax request being made for Search & Filter Pro
	if(venoboxVars.ng_vb_searchfp) {
		document.addEventListener('sf:ajaxfinish', enableVenoBox);
		document.addEventListener('.searchandfilter', enableVenoBox);
	}

	// Detects the end of an ajax request being made for Facet WP
	if(venoboxVars.ng_vb_facetwp) {
		document.addEventListener('facetwp-loaded', enableVenoBox);
	}

	function checkURL(url) {
	    return(url.match(/\.(jpeg|jpg|gif|png|webp)$/) != null);
	}

	// Images
	function imagesVeno() {
		var linklist = [];
		var boxlinks = document.querySelectorAll('a[href]');

		for (var i=0,l=boxlinks.length; i<l; i++) {
			if (boxlinks[i].getAttribute('href')) {
				if ( checkURL(boxlinks[i].getAttribute('href')) ) {
					linklist.push(boxlinks[i]);
				}
			}
		}

		Array.prototype.forEach.call(linklist, function(el, i){

			if (el.href.indexOf('?') < 0) {
				el.classList.add('venobox');

				var imgSelector = el.querySelector("img");

				if ( ! el.hasAttribute('data-gall') ) {
					el.dataset.gall = 'gallery';
				}

				// Set Title from one of three options
				switch (venoboxVars.ng_title_select) {
					case 1:
				    	el.setAttribute("title", imgSelector.getAttribute("alt"));
				    	break;
					case 2:
						el.setAttribute("title", imgSelector.getAttribute("title"));
				  		break;
					case 3:
						var gallItem = el.closest('.wp-caption, .gallery-item');
						if (gallItem) {
							var caption = gallItem.querySelector(".wp-caption-text").innerText;
							if (caption) {
								el.setAttribute("title", caption);
							}
						}
				    break;
						default:
				    return;
				}
			}
		});
	}

	// Galleries
	function galleryVeno() {

		// Set galleries to have unique data-gall sets
		var galleries = document.querySelectorAll('div[id^="gallery"], .gallery-row');
		
		Array.prototype.forEach.call(galleries, function(gall, i){
			var links = gall.querySelectorAll('a');
			Array.prototype.forEach.call(links, function(link, i){
				link.dataset.gall = 'venoset-'+i;
			});
		});

		// Jetpacks caption as title
		if (venoboxVars.ng_title_select == 3) {
			var tiledgalleries = document.querySelectorAll('.tiled-gallery-item a');
			Array.prototype.forEach.call(tiledgalleries, function(tiledgall, i){
				var gallItem = tiledgall.closest('.tiled-gallery-item');
				if (gallItem) {
					var caption = gallItem.querySelector(".tiled-gallery-caption").innerText;
					if (caption) {
						tiledgall.setAttribute("title", caption);
					}
				}
			});
		}
	}

	function checkURLvid(url) {
		var regYt = /(https?:\/\/)?((www\.)?(youtube(-nocookie)?|youtube.googleapis)\.com.*(v\/|v=|vi=|vi\/|e\/|embed\/|user\/.*\/u\/\d+\/)|youtu\.be\/)([_0-9a-z-]+)/i;
		var regVim = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
	    if (
	    	url.search(/.+\.mp4|og[gv]|webm/) !== -1 || 
	    	url.match(regYt) || url.match(regVim)
	    ) {
	    	return true;
	    }
	    return false;
	}

	// Videos
	function videoVeno() {

		var vidlist = [];
		var vidlinks = document.querySelectorAll('a[href]');

		for (var i=0,l=vidlinks.length; i<l; i++) {
		
			if (vidlinks[i].getAttribute('href')) {
				if ( checkURLvid(vidlinks[i].getAttribute('href')) ) {
					vidlist.push(vidlinks[i]);
				}
			}
		}
		Array.prototype.forEach.call(vidlist, function(el, i){
			el.classList.add('venobox');
			el.dataset.vbtype = 'video';
			// Dont replace the data-gall if already set
			if ( ! el.hasAttribute('data-gall')) {
				el.dataset.gall = 'gallery';
			}
		});
	}

	// Default settings
	function defaultVeno() {
		new VenoBox({
			maxWidth: venoboxVars.ng_max_width,
			navigation: ng_arrows, // default: false
			navKeyboard: ng_nav_keyboard,
			navTouch: ng_nav_touch,
			navSpeed: venoboxVars.ng_nav_speed,
			titleStyle: venoboxVars.ng_title_style,
			shareStyle: venoboxVars.ng_share_style,
			toolsBackground: venoboxVars.ng_nav_elements_bg, // 'transparent'
			toolsColor: venoboxVars.ng_nav_elements,
			bgcolor: venoboxVars.ng_border_color,
			border: venoboxVars.ng_border_width,
			numeration: ng_numeratio, // default: false
			infinigall: ng_infinigall, // default: false
			autoplay: ng_autoplay, // default: false
			overlayColor: venoboxVars.ng_overlay,
			spinner: venoboxVars.ng_preloader,
			titlePosition: venoboxVars.ng_title_position,
			spinColor: venoboxVars.ng_nav_elements,
			share: venoboxVars.ng_vb_share
		});
	}

	function enableVenoBox(){
		if (venoboxVars.ng_all_images) {
			imagesVeno();
			galleryVeno();
		}
		if (venoboxVars.ng_all_videos) {
			videoVeno();
		}
		defaultVeno();
	}

	function setNewDataGall(selectors, type){
		Array.prototype.forEach.call(selectors, function(el, i){
			el.dataset.vbtype = type;
		});
	}

	function init(){
		// legacy data attributes mark up change if checked.
		if (venoboxVars.ng_vb_legacy_markup) {
			var datayt = document.querySelectorAll('a[data-type="youtube"]');
			setNewDataGall(datayt, 'video');

			var datavimeo = document.querySelectorAll('a[data-type="vimeo"]');
			setNewDataGall(datavimeo, 'video');

			var dataiframe = document.querySelectorAll('a[data-type="iframe"]');
			setNewDataGall(dataiframe, 'iframe');

			var datainline = document.querySelectorAll('a[data-type="inline"]');
			setNewDataGall(datainline, 'inline');

			var dataajax = document.querySelectorAll('a[data-type="ajax"]');
			setNewDataGall(dataajax, 'ajax');
		}

		enableVenoBox();
		// Init main Venobox
	}

	return {
        init
    };
})();
	
if ( ! venoboxVars.disabled ) {
	VenoboxWP.init();
}

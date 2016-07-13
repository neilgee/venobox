jQuery(document).ready(function($){

  $('a[href]').filter('[href$=".png"], [href$=".gif"], [href$=".jpg"], [href$=".jpeg"]').not('.novenobox a[href]').each(function() {
      if (this.href.indexOf('?') < 0) {
        if(venoboxVars.ng_venobox.ng_all_images) {
          $(this).addClass('venobox');
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
        else {
          $(this).attr("title", $(this).closest('.wp-caption, .gallery-item').find(".wp-caption-text").text());
        }
      }
  });

  /* default settings */
  $('.venobox').venobox({
    border: venoboxVars.ng_venobox.ng_border_width,
    // framewidth: '1600px',        // default: ''
    // frameheight: '1000px',       // default: ''
    bgcolor: venoboxVars.ng_venobox.ng_border_color,
    numeratio: venoboxVars.ng_venobox.ng_numeratio,            // default: false
    infinigall: venoboxVars.ng_venobox.ng_infinigall            // default: false
  });

    /* auto-open #firstlink on page load */
    // $("#firstlink").venobox().trigger('click');

  $('.gallery').each(function(index) {
    $(this).find('a').attr('data-gall', 'venoset-'+index);
  });

  $('.gallery-row').each(function(index) {
    $(this).find('a').attr('data-gall', 'venoset-jp-'+index);
  });

});
// http://stackoverflow.com/questions/14582724/jquery-to-add-a-class-to-image-links-without-messing-up-when-the-link-passes-var
// http://stackoverflow.com/questions/11247658/use-alt-value-to-dynamically-set-title

jQuery(document).ready(function($){

    $('a[href*=".png"], a[href*=".gif"], a[href*=".jpg"]').each(function() {
        if (this.href.indexOf('?') < 0) {
          if(venoboxVars.ng_venobox.ng_all_images) {
            $(this).addClass('venobox');
          }
          if(venoboxVars.ng_venobox.ng_all_lightbox) {
          $(this).attr('data-gall', 'gallery' );
          }
          if(venoboxVars.ng_venobox.ng_all_titles) {
          $(this).attr("title", $(this).find("img").attr("alt"));
           }
        }
    });

    /* default settings */
    $('.venobox').venobox({
      border: '0',
      // framewidth: '1600px',        // default: ''
      // frameheight: '1000px',       // default: ''
      // bgcolor: '#5dff5e',
      numeratio: venoboxVars.ng_venobox.ng_numeratio,            // default: false
      infinigall: venoboxVars.ng_venobox.ng_infinigall            // default: false

    });


    /* custom settings */
    $('.venobox_custom').venobox({
        framewidth: '400px',        // default: ''
        frameheight: '300px',       // default: ''
        border: '10px',             // default: '0'
        bgcolor: '#5dff5e',         // default: '#fff'
        titleattr: 'data-title',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true            // default: false
    });

    /* auto-open #firstlink on page load */
    // $("#firstlink").venobox().trigger('click');
});
// http://stackoverflow.com/questions/14582724/jquery-to-add-a-class-to-image-links-without-messing-up-when-the-link-passes-var
// http://stackoverflow.com/questions/11247658/use-alt-value-to-dynamically-set-title

jQuery(document).ready(function($){
    /* default settings */
    $('.venobox').venobox({
      border: '0',
      numeratio: true,          // default: false
      infinigall: true,         // default: false
      autoplay: true           // default: false
    });
    /* custom settings */
    $('.venobox_custom').venobox({
        framewidth: '400px',        // default: ''
        frameheight: '300px',       // default: ''
        border: '10px',             // default: '0'
        bgcolor: '#5dff5e',         // default: '#fff'
        titleattr: 'data-title',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true,          // default: false
        autoplay: true             // default: false
    });

    /* Call the Color Picker */
    $( ".color-picker" ).wpColorPicker();
});

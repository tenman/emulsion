jQuery(function ($) {
    
    var userAgent = window.navigator.userAgent.toLowerCase( );

    if (userAgent.match(/Edge\/\d+/i)) {

        jQuery('body').addClass('agent-edge');

    } else if (userAgent.match(/Trident/i) && userAgent.match(/rv:11/i) || userAgent.match(/msie/i)) {
         $('body').hide();
        jQuery('body').addClass('agent-ie11');

        // follow when page is cached serverside.
        if ($('style[id="emulsion-inline-css"]').length) {
            $('#emulsion-inline-css').remove();
        }
        if ($('style[id="custom-background-css"]').length) {
            $('#custom-background-css').remove();
        }
        if ($('link[id="emulsion-common-css"]').length) {
            $('#emulsion-common-css').remove();
        }
        if ($('.template-part-widget-footer.footer-widget-area').length) {
            $('.template-part-widget-footer.footer-widget-area').remove();
        }
        if ($('.sidebar-widget-area').length) {
            $('.sidebar-widget-area').remove();
        }
        if ($('.header-layer-nav-menu').length) {
            $('.header-layer-nav-menu').remove();
        }
       
        $('body').show();

    }
});
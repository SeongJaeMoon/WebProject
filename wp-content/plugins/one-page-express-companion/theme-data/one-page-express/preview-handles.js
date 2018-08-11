(function ($) {
    liveUpdate('onepage_builder_header_gradient', function (to) {
        $('.header-homepage').attr('class','header-homepage ' + to);
        $('.header-homepage').attr('style','');
    });

})(jQuery);
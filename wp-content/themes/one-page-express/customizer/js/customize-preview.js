(function ($) {
    wp.customize('one_page_express_full_height', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').css('min-height', "100vh");
            } else {
                $('.header-homepage').css('min-height', "");
            }
        });
    });

    wp.customize('one_page_express_header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').addClass('color-overlay');
            } else {
                $('.header-homepage').removeClass('color-overlay');
            }
        });
    });
    wp.customize('one_page_express_header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.header-top.fixto-fixed').css('background-color', newval);
            }
            var transparent = JSON.parse(wp.customize('one_page_express_header_nav_transparent').get());
            if (!transparent) {
                $('.homepage.header-top').css('background-color', newval);
            }
        });
    });
    wp.customize('one_page_express_header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.header-top').removeClass('coloured-nav');
            } else {
                $('.homepage.header-top').css('background-color', '');
                $('.homepage.header-top').addClass('coloured-nav');
            }
        });
    });
    wp.customize('one_page_express_inner_header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-top:not(.homepage).fixto-fixed').css('background-color', newval);
            }

            var transparent = JSON.parse(wp.customize('one_page_express_inner_header_nav_transparent').get());
            if (!transparent) {
                $('.header-top:not(.homepage)').css('background-color', newval);
            }
        });
    });
    wp.customize('one_page_express_inner_header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-top:not(.homepage)').removeClass('coloured-nav');
            } else {
                $('.header-top:not(.homepage)').addClass('coloured-nav');
            }
        });
    });
    wp.customize('one_page_express_inner_header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header').addClass('color-overlay');
            } else {
                $('.header').removeClass('color-overlay');
            }
        });
    });

    wp.customize('one_page_express_header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header-homepage').removeClass(oldval);
            $('.header-homepage').addClass(newval);
        });
    });

    wp.customize('one_page_express_inner_header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header').removeClass(oldval);
            $('.header').addClass(newval);
        });
    });
})(jQuery);

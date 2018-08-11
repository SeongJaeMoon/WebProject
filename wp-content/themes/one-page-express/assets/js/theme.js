if ("ontouchstart" in window) {
    document.documentElement.className = document.documentElement.className + " touch-enabled";
}
if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/i)) {
    document.documentElement.className = document.documentElement.className + " no-parallax";
}
jQuery(document).ready(function ($) {


    if (window.one_page_express_backstretch) {

        window.one_page_express_backstretch.duration = parseInt(window.one_page_express_backstretch.duration);
        window.one_page_express_backstretch.transitionDuration = parseInt(window.one_page_express_backstretch.transitionDuration);

        var images = one_page_express_backstretch.images;

        if (!images) {
            return;
        }

        jQuery('.header-homepage, .header').backstretch(images, one_page_express_backstretch);
    }


    var masonry = $(".post-list-c");
    if (masonry.length) {
        masonry.masonry({
            itemSelector: '.post-list-item',
            percentPosition: true,
        });


    }

    $('.header-homepage-arrow-c').click(function () {
        scrollToSection($('body').find('[data-id]').first());
    });
});


(function ($) {
    var masonry = $(".post-list-c");

    var images = masonry.find('img');
    var loadedImages = 0;

    function imageLoaded() {
        loadedImages++;
        if (images.length === loadedImages) {
            masonry.data().masonry.layout();
        }
    }

    images.each(function () {
        $(this).on('load', imageLoaded);
    });

    var morphed = $("[data-text-effect]");
    if (morphed.length && JSON.parse(one_page_express_settings.header_text_morph)) {
        morphed.each(function () {
            $(this).empty();
            $(this).typed({
                strings: JSON.parse($(this).attr('data-text-effect')),
                typeSpeed: parseInt(one_page_express_settings.header_text_morph_speed),
                loop: true
            });

        });
    }
})(jQuery);
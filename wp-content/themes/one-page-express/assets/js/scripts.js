window.scrollEffects = {
    "RevealFX111": {
        "effect": "slide",
        "parameters": {
            "from": "left",
            "distance": "50px",
            "opacity": "0",
            "start": "2"
        },
        "over": "800ms",
        "defaultDelay": "500ms",
        "easing": "ease-out",
        "viewportFactor": "0",
        "preset": "custom",
        "init": "false",
        "play-easing": "ease-out"
    },
    "RevealFX112": {
        "effect": "slide",
        "parameters": {
            "from": "bottom",
            "distance": "50px",
            "opacity": "0",
            "start": "2"
        },
        "over": "800ms",
        "defaultDelay": "500ms",
        "easing": "ease-out",
        "viewportFactor": "0",
        "preset": "custom",
        "init": "false",
        "play-easing": "ease-out"
    },
    "RevealFX113": {
        "effect": "slide",
        "parameters": {
            "from": "right",
            "distance": "50px",
            "opacity": "0",
            "start": "2"
        },
        "over": "800ms",
        "defaultDelay": "500ms",
        "easing": "ease-out",
        "viewportFactor": "0",
        "preset": "custom",
        "init": "false",
        "play-easing": "ease-out"
    }
};
window.contentSwap = {
    "ContentSwap103": {
        "effectType": "",
        "contentType": "overlay",
        "overflowEnabled": "false",
        "effectDelay": "800",
        "effectEasing": "Ease",
        "overlayColor": "490A3D",
        "innerColor": "ffffff",
        "openPage": "same",
        "name": "",
        "captionType": "490A3D",
        "operationType": "edit",
        "hasls": "true",
        "additionalWrapperClasses": "",
        "direction": "bottom",
        "useSameTemplate": "true"
    },
    "ContentSwap104": {
        "effectType": "",
        "contentType": "overlay",
        "overflowEnabled": "false",
        "effectDelay": "800",
        "effectEasing": "Ease",
        "overlayColor": "490A3D",
        "innerColor": "ffffff",
        "openPage": "same",
        "name": "",
        "captionType": "490A3D",
        "operationType": "edit",
        "hasls": "true",
        "additionalWrapperClasses": "",
        "direction": "bottom",
        "useSameTemplate": "true"
    },
    "ContentSwap102": {
        "effectType": "",
        "contentType": "overlay",
        "overflowEnabled": "false",
        "effectDelay": "800",
        "effectEasing": "Ease",
        "overlayColor": "490A3D",
        "innerColor": "ffffff",
        "openPage": "same",
        "name": "",
        "captionType": "490A3D",
        "operationType": "edit",
        "hasls": "true",
        "additionalWrapperClasses": "",
        "direction": "bottom",
        "useSameTemplate": "true"
    }
};




jQuery(document).ready(function($) {

    // scrollEffects
    jQuery('[reveal-fx]').each(function() {
        var element = jQuery(this);
        element.removeAttr('data-scrollreveal-initialized');
        element.removeAttr('data-scrollreveal-complete');
        if (!window.scrollEffects.hasOwnProperty(element.attr("reveal-fx"))) {
            element.show();
            return;
        }
        for (var prop in scrollEffects) {
            if (element.attr("reveal-fx") == prop) {
                element.attr("data-scrollReveal", prop);
                element.hide();
            }
        }
    });
    if (window.extendScrollReveal) {
        window.extendScrollReveal.init();
    }

    // hoverfx

    var contentSwapTimeout = setTimeout(function() {
        if (window.initHoverFX) {
            initHoverFX(window.contentSwap);
        }
    }, 10);
    jQuery(window).resize(function(e) {
        clearTimeout(contentSwapTimeout);
        contentSwapTimeout = setTimeout(function() {
            if (window.initHoverFX) {
                initHoverFX(window.contentSwap, null, e);
            }
        }, 150);

    });



    // background image

    var isMobile = function() {
        var viewportWidth = window.innerWidth,
            maxWidth = 767;

        var deviceMatch = (/iphone|ipod|android|blackberry|mini|windows\sce|windows\sphone|iemobile|palm|webos|series60|symbianos|meego/i.test(navigator.userAgent));
        var sizeMatch;
        if (window.matchMedia) {
            sizeMatch = window.matchMedia("(max-width:" + (maxWidth) + "px)").matches;
        } 
        return deviceMatch || sizeMatch;
    };


    var isTablet = function() {

        var viewportWidth = window.innerWidth,
            minWidth = 768,
            maxWidth = 1024;
        var is_touch_device = 'ontouchstart' in document.documentElement;

        var deviceMatch = (/ipad|Win64|tablet/i.test(navigator.userAgent));
        var sizeMatch;
    
        if ( window.matchMedia) {
            sizeMatch = window.matchMedia("(max-width:" + (maxWidth) + "px) and (min-width:" + (minWidth + 1) + "px)").matches;
        } else {
            sizeMatch = viewportWidth <= maxWidth && viewportWidth >= minWidth;
        }
        return is_touch_device && (deviceMatch || sizeMatch);
    };

    if (isMobile() || isTablet()) {

        function setBackgrounds() {
            $('[data-bg="transparent"]').each(function(index, el) {
                var topPosition = ($(this).offset().top + (window.innerHeight - $(this).height()) / 2) / $('body').height() * 100;
                var bgHeight = Math.max(window.innerHeight,$(this).outerHeight());

                $(this).css({
                    'background-image': $('body').css('background-image'),
                    'background-size': 'auto ' + bgHeight + 'px',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center top ' + topPosition + '%'
                });
            });
        }

        $([window, document]).on('resize', function() {
            setBackgrounds();
        });

        setBackgrounds();

    }

});
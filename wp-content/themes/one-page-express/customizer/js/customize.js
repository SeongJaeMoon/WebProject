(function () {
    var $preview;

    if (!top.OnePageExpress) {
        top.OnePageExpress = {};
    }

    function openMediaBrowser(type, callback, data) {
        var cb;
        if (callback instanceof jQuery) {
            cb = function (response) {

                if (!response) {
                    return;
                }

                var value = response[0].url;
                if (data !== "multiple") {
                    if (type == "icon") {
                        value = response[0].fa
                    }
                    callback.val(value).trigger('change');
                }
            }
        } else {
            cb = callback;
        }

        switch (type) {
            case "image":
                openMultiImageManager('Change image', cb, data);
                break;
        }
    }

    function openMultiImageManager(title, callback, single) {
        var node = false;
        var interestWindow = window.parent;
        var custom_uploader = interestWindow.wp.media.frames.file_frame = interestWindow.wp.media({
            title: title,
            button: {
                text: 'Choose Images'
            },
            multiple: !single
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').toJSON();
            callback(attachment);
        });
        custom_uploader.off('close.cp').on('close.cp', function () {
            callback(false);
        });
        //Open the uploader dialog
        custom_uploader.open();

        custom_uploader.content.mode('browse');
        // Show Dialog over layouts frame
        interestWindow.jQuery(interestWindow.wp.media.frame.views.selector).parent().css({
            'z-index': '16000000'
        });
    }

    top.OnePageExpress.openMediaBrowser = openMediaBrowser;

    if (window.wp && window.wp.customize) {
        wp.customize.controlConstructor['radio-html'] = wp.customize.Control.extend({

            ready: function () {

                'use strict';

                var control = this;

                // Change the value
                this.container.on('click', 'input', function () {
                    control.setting.set(jQuery(this).val());
                });

            }

        });

    }
})();

// fix selectize opening
(function ($) {

    $(document).on('mouseup', '.selectize-input', function () {
        if ($(this).parent().height() + $(this).parent().offset().top > window.innerHeight) {
            $('.wp-full-overlay-sidebar-content').scrollTop($(this).parent().height() + $(this).parent().offset().top)
        }
    });

    $(document).on('change', '.customize-control-kirki-select select', function () {
        $(this).focusout();
    });


    $(function () {
        var linkMods = null;

        if (window.CP_Customizer && window.CP_Customizer.onModChange) {
            linkMods = CP_Customizer.onModChange.bind(CP_Customizer);
        } else {
            linkMods = function (mod, callback) {
                wp.customize(mod, function () {
                    this.bind(callback)
                });
            }
        }


        function setTextWidth(newValue) {
            if (newValue === "content-on-right" || newValue === "content-on-left") {
                var setting = wp.customize('one_page_express_header_content_width');

                if (setting.get() == 100) {
                    setting.set(50);
                    wp.customize.previewer.refresh();
                    kirkiSetSettingValue('one_page_express_header_content_width', 50);
                }

            }
        }

        linkMods('ope_header_content_layout', function (newValue, oldValue) {
            setTextWidth(newValue);
        });

        linkMods('one_page_express_header_content_partial', function (newValue, oldValue) {
            setTextWidth(newValue);
        });
    });
})(jQuery);

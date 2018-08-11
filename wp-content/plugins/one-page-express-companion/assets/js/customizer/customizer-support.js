(function ($) {
    CP_Customizer.addModule(function () {
        var used = false;
        CP_Customizer.bind(CP_Customizer.events.PREVIEW_LOADED, function () {

            if (used) {
                return;
            }
            used = true;

            var $activatePageCard = $('.reiki-needed-container[data-type="activate"]');
            var $openPageCard = $('.reiki-needed-container[data-type="select"]');
            var $makeEditable = $('.reiki-needed-container[data-type="edit-this-page"]');

            var data = CP_Customizer.preview.data();
            var toAppend;

            var canMaintainThis = CP_Customizer.options('isMultipage', false) && (data.pageID !== false);

            if (data.maintainable) {

            } else {
                if (canMaintainThis) {

                    toAppend = $makeEditable.clone().show();
                    wp.customize.panel('page_content_panel').container.eq(0).find('.sections-list-reorder').empty().append(toAppend);

                } else {

                    if (!data.hasFrontPage) {
                        toAppend = $activatePageCard.clone().show();
                        wp.customize.panel('page_content_panel').container.eq(0).find('.sections-list-reorder').empty().append(toAppend);
                    } else {
                        if (!data.isFrontPage) {
                            toAppend = $openPageCard.clone().show();
                            wp.customize.panel('page_content_panel').container.eq(0).find('.sections-list-reorder').empty().append(toAppend);

                        }
                    }
                }
            }

        });
    });
})(jQuery);

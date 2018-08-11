(function () {
    window.CP_Customizer.addModule(function (CP_Customizer) {

        // normal texts panel
        CP_Customizer.addContainerDataHandler(CP_Customizer.TEXT_ELEMENTS, function ($el) {
            var result = [

                {
                    label: "Text",
                    type: "text",
                    value: $el.text().trim()
                }
            ];

            if ($el.parent().is('a') || $el.is('.fa')) {
                return [];
            }

            return result;

        }, function ($el, value, type, field) {
            switch (type) {
                case "text":
                    var html = $el.html().replace(field.value, value);
                    $el.html(html);
                    break;
            }
        });

        // containers selector
        CP_Customizer.preview.addDataContainerSelector('[hover-fx]');

        // link panel;
        CP_Customizer.addContainerDataHandler('a', function ($el) {
            var linkIsShortcode = $el.is('[data-attr-shortcode^="href:"]');

            var hasClass = ($el.attr('class') || "").trim().length > 0;

            var result = [

                {
                    label: (hasClass ? "Button" : "Link") + " Text",
                    type: "text",
                    value: $el.text().trim()
                }
            ];

            if (!linkIsShortcode) {
                result.push({
                    label: "Link",
                    type: "link",
                    value: {
                        link: CP_Customizer.preview.cleanURL($el.attr('href') || ""),
                        target: $el.attr('target') || "_self"
                    }
                });
            }

            return result;

        }, function ($el, value, type, field) {
            switch (type) {
                case "link":
                    $el.attr('href', value.link);
                    $el.attr('target', value.target);
                    break;
                case "text":
                    var html = $el.html().replace(field.value, value);
                    $el.html(html);
                    break;
            }
        });


        // list panel;
        CP_Customizer.addContainerDataHandler('ul', function ($el) {
            var items = $el.children('li');
            var result = [];

            items = items.map(function (index, item) {
                return {
                    "label": "Item " + index,
                    "value": jQuery(item).html(),
                    "id": "item_" + index
                }
            })

            var result = {
                label: "List items",
                type: "list",
                value: items,
                getValue: function ($control) {
                    var items = [];
                    $control.children().each(function () {
                        items.push(jQuery(this).find('.item-editor').val());
                    })
                    return items;
                }
            }

            return result;

        }, function ($el, items, type) {

            var orig = $el.children().eq(0).clone();
            $el.empty();

            for (var i = 0; i < items.length; i++) {
                var $item = orig.clone();
                $item.html(items[i]);
                $el.append($item);
            }
        });

        // image link panel
        CP_Customizer.addContainerDataFilter(function ($el) {
            if ($el.is('a') && $el.children().is('img')) {
                return false;
            }

            return true;
        });

        CP_Customizer.addContainerDataHandler('img', function ($el) {

            var mediaType = "image",
                mediaData = false;

            if ($el.attr('data-size')) {
                mediaType = "cropable";
                var size = $el.attr('data-size').split('x');
                mediaData = {
                    width: size[0],
                    height: size[1]
                };
            }


            var image = [{
                label: "Image",
                mediaType: mediaType,
                mediaData: mediaData,
                type: "image",
                value: $el[0].currentSrc || $el.attr('src')
            }];

            if ($el.parent().is('a')) {
                image.push({
                    label: "Link",
                    type: "link",
                    value: {
                        link: CP_Customizer.preview.cleanURL($el.parent().attr('href') || ""),
                        target: $el.parent().attr('target') || "_self"
                    }
                });
            }
            return image;

        }, function ($el, value, type) {
            switch (type) {
                case 'image':
                    $el.attr("src", value);
                    $el.removeAttr('srcset');
                    $el.removeAttr('src-orig');
                    $el.removeAttr('width');
                    $el.removeAttr('height'); 
                    break;
                case 'link':
                    $el.parent().attr('href', value.link);
                    $el.parent().attr('target', value.target);
                    break;
            }
        });

        // data-bg=[image]

        function getLinkFromBgImageValue(value) {
            value = value.replace(/url\((.*)\)/, "$1");
            return CP_Customizer.utils.phpTrim(value, "\"'");
        }

        CP_Customizer.addContainerDataHandler('[data-bg=image]', function ($el) {

            var mediaType = "image",
                mediaData = false;

            if ($el.attr('data-size')) {
                mediaType = "cropable";
                var size = $el.attr('data-size').split('x');
                mediaData = {
                    width: size[0],
                    height: size[1]
                };
            }


            var image = [{
                label: "Background Image",
                mediaType: mediaType,
                mediaData: mediaData,
                type: "image",
                value: getLinkFromBgImageValue($el.css('background-image'))
            }];


            return image;

        }, function ($el, value, type) {
            switch (type) {
                case 'image':
                    $el.css("background-image", 'url("' + value + '")');
                    break;
            }
        });


        // font awesomeicon with link

        CP_Customizer.addContainerDataFilter(function ($el) {
            if ($el.children().is('i.fa') && $el.is('a')) {
                return false;
            }
            return true;
        });

        var faIconRegexp = /fa\-[a-z\-]+/ig;

        CP_Customizer.addContainerDataHandler('a i.fa', function ($el) {

            var mediaType = "icon",
                mediaData = false;

            var result = [{
                label: "Font Awesome Icon",
                mediaType: mediaType,
                mediaData: mediaData,
                canHide: true,
                type: "linked-icon",
                value: {
                    icon: $el.attr('class').match(faIconRegexp).pop(),
                    link: CP_Customizer.preview.cleanURL($el.parent().attr('href') || ""),
                    target: $el.parent().attr('target') || "_self",
                    visible: $el.parent().attr('data-reiki-hidden') ? false : true
                }
            }];

            return result;


        }, function ($el, value, type) {

            if (type == "linked-icon") {
                var classValue = $el.attr('class');
                classValue = classValue.replace(/fa\-[a-z\-]+/ig, "") + " " + value.icon;
                $el.attr('class', classValue);

                $el.parent().attr('href', value.link);
                $el.parent().attr('target', value.target);

                value.visible = _.isUndefined(value.visible) ? true : value.visible;

                if (value.visible) {
                    $el.parent().removeAttr('data-reiki-hidden');
                } else {
                    $el.parent().attr('data-reiki-hidden', true);
                }
            }

        });


        CP_Customizer.addContainerDataHandler('i.fa', function ($el) {

            var mediaType = "icon",
                mediaData = false;

            var result = [{
                label: "Font Awesome Icon",
                mediaType: mediaType,
                mediaData: mediaData,
                canHide: true,
                type: "icon",
                value: {
                    icon: $el.attr('class').match(faIconRegexp).pop(),
                    visible: $el.attr('data-reiki-hidden') ? false : true
                }
            }];

            return result;


        }, function ($el, value, type, prop) {
            
           
            if (type == "icon") {
                var classValue = $el.attr('class');
                classValue = classValue.replace(/fa\-[a-z\-]+/ig, "") + " " + value.icon;
                $el.attr('class', classValue);

                value.visible = _.isUndefined(value.visible) ? true : value.visible;

                if (value.visible) {
                    $el.removeAttr('data-reiki-hidden');
                } else {
                    $el.attr('data-reiki-hidden', true);
                }
            }

        });


    });
})();

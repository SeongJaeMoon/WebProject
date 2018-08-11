(function ($) {

    var listItemTemplate = _.template(
        '<li class="full_row item" data-id="<%= sectionID %>">' +
        '       <div class="reorder-handler"></div>' +
        '       <div class="label-wrapper">' +
        '  <input class="item-label" value="<%= label %>" />' +
        '  <div class="anchor-info">' +
        '      #<%= id.replace(/#/,\'\') %>' +
        '  </div>' +
        '       </div>' +
        '     <div class="item-hover">' +
        '  <span title="Delete section from page" class="item-remove"></span>' +
        '   <% if(setting) { %>' +
        '      <span title="Edit section settings" data-setting="<%= setting %>" class="item-settings"></span>' +
        '  <%  } %>' +
        '  <span title="Toggle visibility in primary menu" class="item-menu-visible <%= (inMenu?\'active\':\'\') %>"></span>' +
        '       </div>' +
        ' </li>'
    );

    window.CP_Customizer.addModule(function (CP_Customizer) {
        var control = wp.customize.panel('page_content_panel');

        if (!control) {
            return;
        }

        var $contentLi = control.container.eq(0);
        // remove default events
        $contentLi.children('h3').andSelf().off();

        $sectionsSidebarTogglers = $contentLi.find('.add-section-plus').add($contentLi.find('.cp-add-section'));

        var sectionID = 'page_content_section';
        $sectionsSidebarTogglers.click(function (event) {
            event.preventDefault();
            event.stopPropagation();


            if (CP_Customizer.isRightSidebarVisible(sectionID)) {
                CP_Customizer.hideRightSidebar();
                $sectionsSidebarTogglers.removeClass('active');
            } else {
                CP_Customizer.openRightSidebar(sectionID);
                $sectionsSidebarTogglers.addClass('active');
            }
        });

        CP_Customizer.focusContentSection = function (toFocus) {
            CP_Customizer.openRightSidebar("page_content_section", {
                focus: '[data-category=' + toFocus + ']'
            })
        }

        var $sectionsList = $("#page_full_rows");

        $sectionsList.sortable({
            scroll: true,
            appendTo: "body",
            axis: 'y',
            handle: '.reorder-handler',
            start: function (event, ui) {
                ui.placeholder.width(ui.item[0].offsetWidth);
                ui.placeholder.height(ui.item[0].offsetHeight);
                startPosition = ui.item.index();
            },
            sort: function (event, ui) {
                ui.helper.css({
                    'left': '18px',
                    'position': 'fixed',
                    'top': event.clientY
                });

            },
            stop: function (event, ui) {
                var node = CP_Customizer.preview.getRootNode().children('[data-id="' + ui.item.data('id') + '"]');
                var nodes = CP_Customizer.preview.getRootNode().children('[data-id]').not(node);
                var newPos = ui.item.index();

                if (newPos < nodes.length) {
                    nodes.eq(newPos).before(node);
                } else {
                    nodes.last().after(node);
                }

                CP_Customizer.setContent();
            }
        });

        $sectionsList.on('click', '.full_row .item-remove', function (event) {
            event.preventDefault();
            var sectionID = $(this).parents('.item').data('id');
            var node = CP_Customizer.preview.getSectionByDataId(sectionID);
            $(this).parents('.item').fadeOut(200);
            CP_Customizer.hooks.doAction('before_section_remove', $(node));
            $(node).remove();
            $(this).parents('.item').remove();
            $('[data-type="row-list-control"] [data-name="page_content"] [data-id="' + sectionID + '"]').removeClass('already-in-page');
            CP_Customizer.updateState();
        });


        var labelChange = _.debounce(function () {
            var $item = $(this).closest('.full_row');
            var node = CP_Customizer.preview.getSectionByDataId($item.data('id'));
            var oldValue = node.attr('data-label');
            var value = this.value.trim();

            if (value === oldValue) {
                return;
            }

            if (value.length === 0) {
                value = oldValue;
                this.value = oldValue;
            }

            node.attr('data-label', value);
            node.data('label', value);

            var slug = CP_Customizer.getSlug(value);

            if (!slug) {
                return;
            }

            if (CP_Customizer.preview.getRootNode().find('[id="' + slug + '"]').length) {
                var found = false,
                    index = 1;
                while (!found) {
                    if (CP_Customizer.preview.getRootNode().find('[id="' + slug + '-' + index + '"]').length === 0) {
                        slug += '-' + index;
                        found = true;
                    } else {
                        index++;
                    }
                }
            }
            var oldId = node.attr('id');
            node.attr('id', slug);
            $(this).siblings('.anchor-info').text('#' + slug);

            if (CP_Customizer.menu.anchorExistsInPrimaryMenu(oldId)) {
                CP_Customizer.menu.updatePrimaryMenuAnchor(oldId, {
                    anchor: slug,
                    title: value
                });
            }

            CP_Customizer.setContent();
        }, 500);


        $sectionsList.on('keyup', '.full_row input', labelChange);

        $sectionsList.on('dblclick', '.anchor-info', function () {
            this.contentEditable = true;
        });

        $sectionsList.on('keypress', '.anchor-info', function (event) {

            if (event.which === 13) {
                event.preventDefault();
                event.stopPropagation();
                this.contentEditable = false;
            }

        });

        $sectionsList.on('focusout', '.anchor-info', function () {
            var slug = $(this).text();
            slug = CP_Customizer.getSlug(slug);
            $(this).text('#' + slug);

            var $item = $(this).closest('.full_row');
            var node = CP_Customizer.preview.getSectionByDataId($item.data('id'));
            var oldId = node.attr('id');
            node.attr('id', slug);
            node.attr('id', slug);
            if (CP_Customizer.menu.anchorExistsInPrimaryMenu(oldId)) {
                CP_Customizer.menu.updatePrimaryMenuAnchor(oldId, {
                    anchor: "#" + slug,
                    title: $item.find('input.item-label').val()
                });
            }

            this.contentEditable = false;
            CP_Customizer.setContent();
        });


        $sectionsList.on('click', '.full_row .item-menu-visible', function (event) {
            event.stopPropagation();
            event.preventDefault();
            event.stopImmediatePropagation();

            var $item = $(this).closest('.full_row'),
                $node = CP_Customizer.preview.getSectionByDataId($item.data('id'));

            if (false === CP_Customizer.menu.getPrimaryMenuID()) {
                CP_Customizer.menu.createPrimaryMenu();
            }

            var anchor = $node.attr('id');
            var label = $node.attr('data-label');

            if (CP_Customizer.menu.anchorExistsInPrimaryMenu(anchor)) {
                CP_Customizer.menu.removeAnchorFromPrimaryMenu(anchor);
                $(this).removeClass('active');
            } else {
                CP_Customizer.menu.addAnchorToPrimaryMenu(anchor, label);
                $(this).addClass('active');
            }
        });

        function focusSection(item) {

            var section = CP_Customizer.preview.getSectionByDataId($(item).data('id'));

            CP_Customizer.preview.find('html,body').animate({
                scrollTop: section.offset().top
            }, 500);

            $(item).addClass('focused').siblings().removeClass('focused');
        }

        $sectionsList.on('click', '.full_row .item-settings', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var customizerSection = $(this).attr('data-setting');

            var section = CP_Customizer.preview.getSectionByDataId($(this).closest('.full_row').data('id'));

            if (CP_Customizer.isRightSidebarVisible(customizerSection)) {
                CP_Customizer.hideRightSidebar();
            }

            CP_Customizer.openRightSidebar(customizerSection, {
                floating: CP_Customizer.hooks.applyFilters('content_section_setting_float', true),
                y: $(this).offset().top,
                section: section
            });

            focusSection($(this).closest('.full_row'));

        });


        $sectionsList.on('click', '.full_row', function () {

            var section = CP_Customizer.preview.getSectionByDataId($(this).data('id'));

            if (!section.length) {
                return;
            }

            focusSection($(this));

            CP_Customizer.hideRightSidebar();


        });

        var skipableKeyCodes = [8, 46, 16, 17, 18];
        var labelValidaton = function (event) {

            if (skipableKeyCodes.indexOf(event.keyCode) === -1 && event.key.length === 1) {
                if (!event.key.match(/[A-Za-z0-9\s]/)) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }
        };
        $sectionsList.on('keydown', '.full_row input', labelValidaton);

        function getListModel(elem) {
            var $node = $(elem),
                label = $node.attr('data-label') || $node.attr('id'),
                id = $node.attr('id') || "",
                sectionID = $node.attr('data-id'),
                inMenu = CP_Customizer.menu.anchorExistsInPrimaryMenu(id),
                setting = $node.attr('data-setting') ? $node.attr('data-setting') : false;
            setting = CP_Customizer.hooks.applyFilters('content_section_setting', setting);

            return {
                label: label,
                id: id,
                setting: setting,
                sectionID: sectionID,
                inMenu: inMenu
            };
        }

        CP_Customizer.bind('PREVIEW_LOADED', function () {
            var data = CP_Customizer.preview.getRootNode().children().map(function (index, elem) {
                return getListModel(elem);
            });

            $sectionsList.children('.item.full_row').remove();

            var availableRowsList = $('[data-type="row-list-control"] [data-name="page_content"]');
            var $controlItems = availableRowsList.find('li.available-item');
            var allowMultiple = (availableRowsList.closest('[data-selection="multiple"]').length > 0);

            data.each(function (index, _data) {

                // ignor elements injected by plugins and that do not match the companion structure
                if (!_data.sectionID) {
                    return;
                }

                $sectionsList.children('.empty').before(listItemTemplate(_data));


                if (allowMultiple && !data.once) {
                    return;
                }

                $controlItems.filter('[data-id="' + _data.sectionID + '"]').addClass('already-in-page');
            });


            availableRowsList.parent().off('cp.item.click').on('cp.item.click', function (event, itemID, enabled) {
                var $ = CP_Customizer.preview.jQuery();
                var data = CP_Customizer.pluginOptions.contentSections[itemID];

                if (data['pro-only']) {

                    CP_Customizer.popUpInfo('This item requires PRO theme',
                        '<h3>This item is available only in the PRO version</h3>' +
                        '<p>Please upgrade to the PRO version to use this item and many others.</p>' +
                        '<br/>' +
                        '<a href="https://extendthemes.com/go/one-page-express-upgrade/" class="button button-orange" target="_blank">Upgrade to PRO</a> '
                    );

                    return;
                }

                if (data) {
                    $content = $(data.content);
                    var nodeId = data.elementId;

                    if (CP_Customizer.preview.find('#' + nodeId).length) {
                        var base = nodeId.replace(/\d+/, '');
                        var newIdIndex = 1;

                        while (CP_Customizer.preview.find('#' + base + newIdIndex).length) {
                            newIdIndex++;
                        }

                        nodeId = base + newIdIndex;
                    }


                    $content.attr('id', nodeId);


                    var dataId = $content.attr('data-id');

                    if (CP_Customizer.preview.find('[data-id="' + dataId + '"]').length) {
                        var base = dataId.replace(/\d+/, '');
                        var newDataIndex = 1;

                        while (CP_Customizer.preview.find('[data-id="' + newDataIndex + '"]').length) {
                            newDataIndex++;
                        }

                        dataId = CP_Customizer.utils.phpTrim(base, '-') + '-' + newIdIndex;
                    }

                    $content.attr('data-id', dataId);
                    $content.addClass(dataId);

                    var index;

                    if (data.prepend === true) {
                        index = 0;
                    }

                    CP_Customizer.preview.insertContentSection($content, index);
                    var _data = getListModel($content);

                    var $listChildren = $sectionsList.children().not('.empty')
                    if (!_.isUndefined(index) && $listChildren.length) {
                        $listChildren.eq(index).before(listItemTemplate(_data));
                    } else {
                        $sectionsList.children('.empty').before(listItemTemplate(_data));
                    }
                }
            });

        });

        CP_Customizer.bind(CP_Customizer.events.RIGHT_SECTION_CLOSED, function (ev, sidebar) {
            $contentLi.find('.cp-add-section.active').removeClass('active');
        });

        CP_Customizer.bind('content.section.hovered', function (event, $el) {
            var sectionId = $el.attr('data-id');
            var $item = $sectionsList.find('[data-id="' + sectionId + '"]');
            $item.addClass('focused').siblings().removeClass('focused');

            if (!$item.length) {
                return;
            }

            $item[0].scrollIntoViewIfNeeded();
        });

    });
})(jQuery);

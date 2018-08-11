;(function ($) {
    $(document).ready(function () {
        $(document).on('submit', 'form[name="export-courses"]', function () {
            var $form = $(this),
                step = $form.find('[name="step"]').val();
            if (step === 3) {
                $form.find('#export-step-2-options').hide();
                $form.find('#exporting').show();
                $form.append('<input type="hidden" name="reimport-url" value="' + $form.serialize() + '" />');
                // submit to download
                if ($form.find('input[name="download_export"]').is(':checked')) {
                    //return true;
                }
            }
            $.ajax({
                url: $form.attr('action'),
                data: $form.serialize(),
                dataType: 'html',
                success: function (res) {
                    var $newHtml = $(res).contents().find('form[name="export-courses"]');
                    $form.replaceWith($newHtml);
                }
            });
            return false;
        }).on('click', '#lpie-export-again', function (e) {
            var $form = $('form[name="export-courses"]');
            $('#exporting, #exported').toggle();
            $form.submit();
            return false;
        });
    });


    function parseJSON(data) {
        var m = data.match(/<!-- LPR?_AJAX_START -->(.*)<!-- LPR?_AJAX_END -->/);
        try {
            if (m) {
                data = $.parseJSON(m[1]);
            } else {
                data = $.parseJSON(data);
            }
        } catch (e) {
            console.log(e);
            data = {};
        }
        return data;
    }

    var LP_Export_LearnPress_Model = window.LP_Export_LearnPress_Model = Backbone.Model.extend({
        url: function () {
            return this.urlRoot;
        },
        urlRoot: null,
        initialize: function () {
            this.urlRoot = LearnPress_Import_Export_Settings.ajax;
        },
        submit: function (args) {
            var that = this;
            args = $.extend({
                complete: null,
                data: {}
            }, args || {});

            var start = this.get('start'),
                limit = this.get('limit'),
                length = this.get('courses');
            this.fetch({
                data: $.extend({
                    action: 'learn_press_export',
                    export_nonce: this.get('export_nonce'),
                    exporter: this.get('exporter'),
                    start: this.get('start'),
                    limit: this.get('limit')
                }, args.data || {}),
                type: 'post',
                complete: (function (e) {
                    var response = parseJSON(e.responseText)
                    $.isFunction(args.complete) && args.complete.call(this, response);
                })
            });
        }
    });

    var LP_Export_LearnPress_View = window.LP_Export_LearnPress_View = Backbone.View.extend({
        model: null,
        el: 'body',
        ajaxResponse: null,
        initialize: function (model) {
            _.bindAll(this, 'completePart');

            this.model = model;
            this._init();
            this.listenTo(this.model, "change", this.render);
        },
        _init: function () {
            this.model.set('limit', 1);
        },
        doExport: function () {
            this.run(0, this.completePart);
        },
        doImport: function (args) {
            $.ajax({
                url: LearnPress_Import_Export_Settings.ajax,
                data: $.extend({
                    action: 'learn_press_import'
                }, args),
                success: function (response) {
                    console.log(response);
                }
            })
        },
        run: function (start, callback) {
            this.model.set('start', start);
            this.model.submit({
                complete: callback
            });
        },
        completePart: function (response) {
            var courses = this.model.get('courses'),
                length = courses.length,
                start = this.model.get('start'),
                limit = this.model.get('limit'),
                completed = start + limit;
            this.ajaxResponse = response;
            if (completed >= length) {
                this.model.set('finish', true);
                if ((response.download == 1) && response.download_url) {
                    var url = response.download_url,
                        name = url.replace(/^.*[\\\/]/, '');
                    this.download(url, name);
                }
                completed = completed > length ? length : completed;
            } else {
                //this.model.set('start', completed);
                this.run(completed, this.completePart)
            }
            this.model.set('completed', completed);

        },
        render: function () {
            var courses = this.model.get('courses'),
                length = courses.length,
                start = this.model.get('start'),
                end = start + this.model.get('limit');
            if (end > length) {
                end = length;
            }
            if (this.model.get('finish')) {
                this.$('#exporting').remove();
                this.$('#complete').removeClass('hide-if-js');
                if (this.ajaxResponse.download_url) {
                    var url = this.ajaxResponse.download_url,
                        name = url.replace(/^.*[\\\/]/, '');
                    this.$('#complete .complete').html('<a href="' + url + '">' + name + '</a>');
                } else {
                    this.autoRedirect();
                }
            } else {
                this.$('#exporting .exporting').html((start + 1) + ' to ' + (end));
            }
            this.$('#exported-courses .exported-courses').html(end);
        },
        download: function (url, name) {
            $('<a>').attr({href: url, download: name})[0].click();
        },
        autoRedirect: function () {

        }
    });

    $(document).ready(function () {
        $(document).on('change', '#learn-press-import-export-select-all', function () {
            var $all = $(this).closest('table').find('input[type="checkbox"]').not(this);
            this.checked ? $all.attr('checked', 'checked') : $all.removeAttr('checked');
            $all.trigger('change');
        }).on('change', '.list-export-courses input[type="checkbox"]', function () {
            var selected = $('.list-export-courses input[type="checkbox"]:not(#learn-press-import-export-select-all):checked').length;
            $('#button-export-next').prop('disabled', !selected);
            $('#lpie-no-course-selected').toggle(!selected);
            $('#learn-press-import-export-select-all').attr('checked', selected == $('.list-export-courses input[type="checkbox"]:not(#learn-press-import-export-select-all)').length)
        }).on('change', '.check-file', function () {
            var $chks = $('.check-file'),
                all = $chks.length,
                checked = $chks.filter(':checked').length;
            $('#learn-press-remove-files')
                .toggleClass('hide-if-js', !checked)
                .html(function () {
                    return $(this).attr('data-text') + (checked ? ' (+' + checked + ')' : '')
                });
            if (all == checked) {
                $('#learn-press-check-all-files').prop('checked', true);
            } else if (checked == 0) {
                $('#learn-press-check-all-files').prop('checked', false);
            }
        }).on('click', '#learn-press-check-all-files', function () {
            $('.check-file').prop('checked', this.checked).trigger('change');
        }).on('click', '#learn-press-remove-files', function (e) {
            e.preventDefault();
            var $a = $(this);
            window.location.href = $a.attr('data-url') + '' + $('.check-file:checked').map(function () {
                return this.value
            }).get().join(',');
        }).on('click', '#lpie-button-back-step', function () {
            var $form = $(this.form),
                $step = $form.find('input[name="step"]'),
                step = parseInt($step.val());
            $step.val(step - 2);
            $form.submit();
        }).on('click', '#lpie-button-cancel', function () {
            var $form = $(this.form);
            $form.find('input[name="step"]').val(0);
            $form.submit();
        });

        var $form = $('form[name="export-courses"]');
    })
})(jQuery);
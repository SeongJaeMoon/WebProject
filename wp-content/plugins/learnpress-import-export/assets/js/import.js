;(function ($) {
    window.LP_Importer = {
        init    : function (args) {
            var uploader = new plupload.Uploader({
                runtimes      : 'html5,flash,silverlight,html4',
                browse_button : 'import-uploader-select',
                container     : $('#import-uploader').get(0),
                url           : args.url,
                filters       : {
                    max_file_size: '10mb',
                    mime_types   : [
                        {title: "XML", extensions: "xml"}
                    ]
                },
                file_data_name: 'lpie_import_file',
                init          : {
                    PostInit: function () {
                        $(document).on('click', '#import-start-upload', function () {
                            uploader.setOption('multipart_params', $('#import-form').serializeJSON());
                            uploader.start();
                            return false;
                        });
                    },

                    FilesAdded: function (up, files) {
                        up.files.splice(0, up.files.length - 1);
                        plupload.each(files, function (file) {
                            $('#import-uploader-select').addClass('has-file').html('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <strong></strong></div>');
                            $('#import-start-upload').addClass('has-file');
                        });
                    },

                    UploadProgress: function (up, file) {
                        $('#' + file.id + ' strong').html(file.percent + "%");
                    },

                    FileUploaded: function (up, file, info) {
                        $('#import-form').replaceWith($(info.response).contents().find('#import-form'))
                    },

                    Error: function (up, err) {
                        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                    }
                }
            });
            uploader.init();

            $(document).on('submit', 'form[name="import-form"]', function () {
                var $form = $(this),
                    step = $form.find('[name="step"]').val();

                $.ajax({
                    url     : $form.attr('action'),
                    data    : $form.serialize(),
                    dataType: 'html',
                    success : function (res) {
                        var $newHtml = $(res).contents().find('form[name="import-form"]');
                        $form.replaceWith($newHtml);
                    }
                });
                return false;
            })
        },
        doImport: function (url) {
            jQuery.ajax({
                url    : url,
                success: function () {
                }
            });
        }
    };

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

    var LP_Import_LearnPress_Model = window.LP_Import_LearnPress_Model = Backbone.Model.extend({
        url       : function () {
            return this.urlRoot;
        },
        urlRoot   : null,
        initialize: function () {
            this.urlRoot = LearnPress_Import_Export_Settings.ajax;
        },
        submit    : function (args) {
            var that = this;
            args = $.extend({
                complete: null,
                data    : {}
            }, args || {});

            var start = this.get('start'),
                limit = this.get('limit'),
                length = this.get('courses');
            this.fetch({
                data    : $.extend({
                    action      : 'learn_press_export',
                    export_nonce: this.get('export_nonce'),
                    exporter    : this.get('exporter'),
                    start       : this.get('start'),
                    limit       : this.get('limit')
                }, args.data || {}),
                type    : 'post',
                complete: (function (e) {
                    var response = parseJSON(e.responseText);
                    $.isFunction(args.complete) && args.complete.call(this, response);
                })
            });
        }
    });

    var LP_Import_LearnPress_View = window.LP_Import_LearnPress_View = Backbone.View.extend({
        model           : null,
        ///el          : 'form#import-form',
        ajaxResponse    : null,
        el              : 'body',
        events          : {
            'change select.instructor_map': 'toggleInputState'
        },
        initialize      : function (model) {
        },
        toggleInputState: function (e) {
            var $select = $(e.target);
            if ($select.val() === 0) {
                $select.closest('tr').find('input.new_instructor').removeAttr('readonly')
            } else {
                $select.closest('tr').find('input.new_instructor').attr('readonly', 'readonly').val('')
            }
        },
        doImport        : function (args) {
            var that = this;
            $.ajax({
                url    : LearnPress_Import_Export_Settings.ajax,
                data   : $.extend({
                    action: 'learn_press_import'
                }, args),
                type   : 'post',
                success: function (response) {
                    that.$('#importing').html('Done')
                }
            })
        }
    });

    $(document).ready(function () {
        $('#learn-press-import-export-select-all').change(function () {
            var $all = $(this).closest('ul').find('input[type="checkbox"]').not(this)

            this.checked ? $all.attr('checked', 'checked') : $all.removeAttr('checked');
        });
    })
})(jQuery);
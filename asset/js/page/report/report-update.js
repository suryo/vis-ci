$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+s', function assets() {
        $('#btn_save').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        $('#btn_cancel').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+d', function assets() {
        $('.btn_save_back').trigger('click');
        return false;
    });

    CKEDITOR.config.height = 400;
    CKEDITOR.config.extraAllowedContent = 'style';
    CKEDITOR.replace('content', {
        height: 400,
        contentsCss: ['https://cdn.ckeditor.com/4.8.0/full-all/contents.css', `${BASE_URL}asset/css/report.css`],
        bodyClass: 'document-editor',
        format_tags: 'p;h1;h2;h3;pre',
        removeDialogTabs: 'image:advanced;link:advanced',

    });

    var content = CKEDITOR.instances.content;

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_report = $('#form_report');
        var data_post = form_report.serializeArray();
        var save_type = $(this).attr('data-stype');
        var mode = $(this).attr('data-mode');
        var plate = $('.win-content ul').html();

        data_post.push({
            name: 'save_type',
            value: save_type
        });
        data_post.push({
            name: 'content',
            value: content.getData()
        });
        data_post.push({
            name: 'plate',
            value: plate
        });
        data_post.push({
            name: 'report_controller',
            value: $('#report_controller').val()
        });
        data_post.push({
            name: 'report_view',
            value: $('#report_view').val()
        });

        data_post.push({
            name: 'report_style',
            value: $('#report_style').val()
        });

        data_post.push({
            name: 'report_header',
            value: $('#report_header').val()
        });

        data_post.push({
            name: 'report_footer',
            value: $('#report_footer').val()
        });



        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/report/edit_save/' + window.reportid,
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    if (mode == 'advance') {
                        toastr['success']('Success save report')
                    }
                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();
                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                }
            })
            .fail(function () {
                $('.message').printMessage({
                    message: 'Error save data',
                    type: 'warning'
                });
            })
            .always(function () {
                $('.loading').hide();
            });

        return false;
    }); /*end btn save*/

    /*load editors*/
    loadEditors();

    /*adding holder on canvas*/
    addHolderOnCanvas();

    /*load spectrum*/
    loadSpectrum();

    /*load spectrum*/
    updateLayoutType();

}); /*end doc ready*/
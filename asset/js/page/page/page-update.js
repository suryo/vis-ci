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

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_page = $('#form_page');
        var data_post = form_page.serializeArray();
        var save_type = $(this).attr('data-stype');

        var content = '';
        var plate = $('.win-content ul').html();

        $(document).find('.win-content ul li.block-item').each(function () {
            content += $(this).find(' .block-content').html();
        });

        data_post.push({
            name: 'save_type',
            value: save_type
        });
        data_post.push({
            name: 'content',
            value: content
        });
        data_post.push({
            name: 'plate',
            value: plate
        });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/page/edit_save/' + window.pageid,
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();
                    $('.chosen option').prop('selected', false).trigger('chosen:updated');
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
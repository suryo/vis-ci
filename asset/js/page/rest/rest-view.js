$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+e', function assets() {
        $('#btn_edit').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        $('#btn_back').trigger('click');
        return false;
    });

    var x_api_key = null;
    var x_token = null;

    $(document).ajaxComplete(function (event, xhr, settings) {
        if (typeof xhr.responseJSON == 'object') {
            if (typeof xhr.responseJSON.message != 'undefined') {
                var message = xhr.responseJSON.message.trim().toLowerCase();
                if (message == 'invalid api key') {
                    swal({
                        title: 'API Key Is not valid!',
                        text: 'if you do not have key, get the key by visiting <a href="' + BASE_URL + 'administrator/keys" target="blank">this page</a>',
                        html: true
                    });
                    return false;
                } else if (message == 'wrong number of segments') {
                    swal({
                        title: 'Token Is not valid!',
                        text: 'following <a href="' + BASE_URL + 'administrator/rest/tool/get-token" target="blank">this URL</a> guide to get a token ',
                        html: true
                    });
                    return false;
                }
            }
        }
    });

    $('.btn-call-page-test').on('click', function () {
        $('.message').hide();
        $('.loading').show();

        x_api_key = $('#x_api_key').val();
        x_token = $('#x_token').val();

        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
        })
            .done(function (res) {
                if (res.success) {
                    $('.rest-page-test').html(res.html);
                    $('#x_api_key').val(x_api_key);
                    $('#x_token').val(x_token);

                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                    $('.message').fadeIn();
                }

            })
            .fail(function () {
                $('.message').printMessage({
                    message: 'Error getting data',
                    type: 'warning'
                });
            })
            .always(function () {
                $('.loading').hide();
            });

    }); /*end btn save*/

    $('.btn_save').on('click', function () {
        $('.message').hide();

        var form_rest = $('#form_rest');
        var data_post = form_rest.serialize();
        var save_type = $(this).attr('data-stype');

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/rest/edit_save/' + window.rest.id,
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

                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                    $('.message').fadeIn();
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
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 3000);
            });

        return false;
    }); /*end btn save*/
}); /*end doc ready*/
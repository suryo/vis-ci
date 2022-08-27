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

    $('#btn_cancel').on('click', function () {
        swal({
            title: cclang('are_you_sure'),
            text: cclang('data_to_be_deleted_can_not_be_restored'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: cclang('yes_delete_it'),
            cancelButtonText: cclang('no_cancel_plx'),
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = BASE_URL + 'administrator/permission';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_permission = $('#form_permission');
        var data_post = form_permission.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        $.ajax({
            url: form_permission.attr('action'),
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
                }, 1000);
            });

        return false;
    }); /*end btn save*/

}); /*end doc ready*/
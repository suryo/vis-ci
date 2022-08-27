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
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = BASE_URL + 'administrator/keys';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_keys = $('#form_keys');
        var data_post = form_keys.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/keys/add_save',
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
                    resetForm();
                    $('.chosen').val('').trigger('chosen:updated');

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
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
            });

        return false;
    }); /*end btn save*/

}); /*end doc ready*/
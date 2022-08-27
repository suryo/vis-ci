$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+a', function assets() {
        window.location.href = BASE_URL + '/administrator/permission/add';
        return false;
    });

    $('*').bind('keydown', 'Ctrl+s', function assets() {
        $('#btn_save').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        if ($('#btn_undo').is(":visible")) {
            $('#btn_undo').trigger('click');
        }
        return false;
    });

    $('.selectpicker').selectpicker({
        style: 'btn-block btn-flat',
        size: 4
    });

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_setting = $('#form_setting');
        var data_post = form_setting.serialize();

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/setting/save',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();
                    $('.btn_undo').hide();

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


    var params = {};
    params[csrf] = token;

    $('#setting_attachment_galery').fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: BASE_URL + '/administrator/setting/upload_attachment_file',
            params: params
        },
        deleteFile: {
            enabled: true, // defaults to false
            endpoint: BASE_URL + '/administrator/setting/delete_attachment_file'
        },
        thumbnails: {
            placeholders: {
                waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
            }
        },
        session: {
            endpoint: BASE_URL + 'administrator/setting/get_attachment_file',
            refreshOnRequest: true
        },
        multiple: false,
        validation: {
            allowedExtensions: ["jpg", "png", "jpeg"],
            sizeLimit: 0,
        },
        showMessage: function (msg) {
            toastr['error'](msg);
        },
        callbacks: {
            onComplete: function (id, name, xhr) {
                if (xhr.success) {
                    var uuid = $('#setting_attachment_galery').fineUploader('getUuid', id);
                    $('#setting_attachment_uuid').val(uuid);
                    $('#setting_attachment_name').val(xhr.uploadName);
                } else {
                    toastr['error'](xhr.error);
                }
            },
            onSubmit: function (id, name) {
                var uuid = $('#setting_attachment_uuid').val();
                $.get(BASE_URL + '/administrator/setting/delete_attachment_file/' + uuid);
            },
            onDeleteComplete: function (id, xhr, isError) {
                if (isError == false) {
                    $('#setting_attachment_uuid').val('');
                    $('#setting_attachment_name').val('');
                }
            }
        }
    }); /*end attachment galey*/



}); /*end doc ready*/
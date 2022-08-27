
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
                    window.location.href = BASE_URL + 'administrator/user';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_user = $('#form_user');
        var data_post = form_user.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        data_post.group = $('#group').chosen().val();

        $.ajax({
            url: BASE_URL + '/administrator/user/add_save',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    var id = $('#user_avatar_galery').find('li').attr('qq-file-id');

                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();
                    $('form input[type != hidden], form textarea, form select').val('');
                    $('.chosen').val('').trigger('chosen:updated');
                    $('#user_avatar_galery').fineUploader('deleteFile', id);

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

    var params = {}
    params[csrf] = token;
    $('#user_avatar_galery').fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: BASE_URL + '/administrator/user/upload_avatar_file',
            params: params
        },
        deleteFile: {
            enabled: true,
            endpoint: BASE_URL + '/administrator/user/delete_avatar_file'
        },
        thumbnails: {
            placeholders: {
                waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
            }
        },
        multiple: false,
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
        },
        showMessage: function (msg) {
            toastr['error'](msg);
        },
        callbacks: {
            onComplete: function (id, name) {
                var uuid = $('#user_avatar_galery').fineUploader('getUuid', id);
                $('#user_avatar_uuid').val(uuid);
                $('#user_avatar_name').val(name);
            },
            onSubmit: function (id, name) {
                var uuid = $('#user_avatar_uuid').val();
                $.get(BASE_URL + '/administrator/user/delete_avatar_file/' + uuid);
            }
        }
    }); /*end image galey*/
}); /*end doc ready*/
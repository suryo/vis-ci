
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

    $(document).on('keyup', '#title', function (event) {
        var link = $(this).val().replaceAll(/[^0-9a-z]/gi, '-').replaceAll(/_+/g, '-').toLowerCase();
        var title = $(this).val().replaceAll(/[^0-9a-z\.\? ]/gi, ' ').toLowerCase().replaceAll(/ +/g, ' ').toLowerCase();

        $('.blog-slug').html(link);
        $('#title').val(title);
    });


    $(document).on('focusout', '.blog-slug', function (event) {
        var link = $(this).html().replaceAll(/[^0-9a-z]/gi, '-').replaceAll(/-+/g, '-').toLowerCase();

        $('.blog-slug').html(link);
    });


    CKEDITOR.replace('content');
    var content = CKEDITOR.instances.content;

    $('#btn_cancel').on('click', function () {
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
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
                    window.location.href = BASE_URL + 'administrator/blog';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();
        $('#content').val(content.getData());

        var form_blog = $('#form_blog');
        var data_post = form_blog.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({ name: 'save_type', value: save_type });
        data_post.push({ name: 'slug', value: $('.blog-slug').html() });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/blog/add_save',
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

                    $('.message').printMessage({ message: res.message });
                    $('.message').fadeIn();
                    resetForm();
                    $('#blog_image_galery').find('li').each(function () {
                        $('#blog_image_galery').fineUploader('deleteFile', $(this).attr('qq-file-id'));
                    });
                    $('.chosen option').prop('selected', false).trigger('chosen:updated');
                    content.setData('');

                } else {
                    $('.message').printMessage({ message: res.message, type: 'warning' });
                }

            })
            .fail(function () {
                $('.message').printMessage({ message: 'Error save data', type: 'warning' });
            })
            .always(function () {
                $('.loading').hide();
                $('html, body').animate({ scrollTop: $(document).height() }, 2000);
            });

        return false;
    }); /*end btn save*/



    var params = {};
    params[csrf] = token;

    $('#blog_image_galery').fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: BASE_URL + '/administrator/blog/upload_image_file',
            params: params
        },
        deleteFile: {
            enabled: true,
            endpoint: BASE_URL + '/administrator/blog/delete_image_file',
        },
        thumbnails: {
            placeholders: {
                waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ["jpg", "jpeg", "png"],
            sizeLimit: 0,

        },
        showMessage: function (msg) {
            toastr['error'](msg);
        },
        callbacks: {
            onComplete: function (id, name, xhr) {
                if (xhr.success) {
                    var uuid = $('#blog_image_galery').fineUploader('getUuid', id);
                    $('#blog_image_galery_listed').append('<input type="hidden" class="listed_file_uuid" name="blog_image_uuid[' + id + ']" value="' + uuid + '" /><input type="hidden" class="listed_file_name" name="blog_image_name[' + id + ']" value="' + xhr.uploadName + '" />');
                } else {
                    toastr['error'](xhr.error);
                }
            },
            onDeleteComplete: function (id, xhr, isError) {
                if (isError == false) {
                    $('#blog_image_galery_listed').find('.listed_file_uuid[name="blog_image_uuid[' + id + ']"]').remove();
                    $('#blog_image_galery_listed').find('.listed_file_name[name="blog_image_name[' + id + ']"]').remove();
                }
            }
        }
    }); /*end image galery*/
}); /*end doc ready*/
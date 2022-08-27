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


    var parent = window.parentid;

    if (parent) {
        $('#parent').val(parent);
    }

    $('input[type="radio"].flat-green').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });


    $('.btn-select-icon').on('click', function (event) {
        event.preventDefault();

        $('#modalIcon').modal('show');
    });

    $('.icon-container').on('click', function (event) {
        $('#modalIcon').modal('hide');
        var icon = $(this).find('.icon-class').html();

        icon = $.trim(icon);

        $('#icon').val(icon);

        $('.icon-preview-item .fa').attr('class', 'fa fa-lg ' + icon);
    });

    $('#icon_color').on('change', function (event) {
        $('.icon-preview-item').attr('class', 'icon-preview-item ' + $(this).val());
    });

    function group_select() {
        var type = $('#category-icon-filter').val();
        $('.category-icon').hide();
        $('.category-icon#' + type).show();

        if (type == 'all') {
            $('.category-icon').show();
        }
    }

    $('#find-icon').keyup(function (event) {
        $('.icon-container').hide();
        $('.category-icon').show();
        $('#category-icon-filter').val('all')
        var search = $(this).val();

        $('.icon-class').each(function (index, el) {
            var str = $(this).html();
            var patt = new RegExp(search);
            var res = patt.test(str);

            if (res) {
                $(this).parent('.icon-container').show();
            }
        });
        $('.category-icon').each(function (index, el) {
            if ($(this).find('.icon-container:visible').length) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

    });

    $('.category-icon').each(function (index) {
        $('#category-icon-filter').append('<option value="' + $(this).attr('id') + '">' + $(this).attr('id') + '</option>');
    });

    $('#category-icon-filter').on('change', function (event) {
        group_select();
    });

    /*end*/

    var menu_type = $('.menu_type');

    menu_type.on('ifClicked', function (event) {
        var type = $(this).val();
        updateMenuType(type);
    });

    function updateMenuType(type) {
        if (type == 'menu') {
            $('.menu-only').show();
        } else {
            $('.menu-only').hide();
        }
    }

    $('#btn_cancel').on('click', function () {
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = HTTP_REFERER;
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').hide();

        var form_menu = $('#form_menu');
        var data_post = form_menu.serialize();
        var save_type = $(this).attr('data-stype');

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/menu/add_save',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    var id = $('#menu_avatar_galery').find('li').attr('qq-file-id');

                    if (save_type == 'back') {
                        window.location.href = BASE_URL + 'administrator/menu?act=save&res=success&id=' + res.id;
                        return;
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();
                    $('form input[type!=hidden], form textarea, form select').val('');
                    $('.chosen').val('').trigger('chosen:updated');

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
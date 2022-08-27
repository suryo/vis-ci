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

    $('#find-icon').keyup(function (event) {
        $('.icon-container').hide();
        var search = $(this).val();

        $('.icon-class').each(function (index, el) {
            var str = $(this).html();
            var patt = new RegExp(search);
            var res = patt.test(str);

            if (res) {
                $(this).parent('.icon-container').show();
            }
        });
    });

    $('.category-icon').each(function (index) {
        $('#category-icon-filter').append('<option value="' + $(this).attr('id') + '">' + $(this).attr('id') + '</option>');
    });

    $('#category-icon-filter').on('change', function (event) {
        var type = $('#category-icon-filter').val();
        $('.category-icon').hide();
        $('.category-icon#' + type).show();

        if (type == 'all') {
            $('.category-icon').show();
        }
    });

    /*end*/

    $('input[type="radio"].flat-green').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    var menu_type = $('.menu_type');

    updateMenuType($('.menu_type[checked]').val());

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
                    window.location.href = BASE_URL + 'administrator/menu';
                }
            });

        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_menu = $('#form_menu');
        var data_post = form_menu.serialize();
        var save_type = $(this).attr('data-stype');

        $('.loading').show();

        $.ajax({
            url: form_menu.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    if (save_type == 'back') {
                        window.location.href = BASE_URL + 'administrator/menu?act=save&res=success&id=' + res.id;
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
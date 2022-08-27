$(function () {

    "use strict";

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
})
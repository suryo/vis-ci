$(function () {
    'use strict';

    function addField() {
        var field = $('.field-wrapper-template .table-field-item').clone()

        field = field[0].outerHTML.replaceAll('{id}', getUnixId())

        $(field).appendTo('.table-field-wrapper');
    }

    $(document).on('focus', '.table-field-wrapper:not(.table-edit) .table-field-item:last .name', function () {
        addField();
    })

    $(document).on('click', '.btn-remove-field', function (event) {
        event.preventDefault();

        $(this).parents('.table-field-item').remove();
    })

    $(document).on('change', '.table-default', function () {
        if ($(this).val() == 'as_defined') {
            $(this).parents('td').find('.defined-value-wrapper').show();
        } else {
            $(this).parents('td').find('.defined-value-wrapper').hide();
        }
    })
    $(document).on('change', '.field-auto-type', function () {
        if ($(this).val() == 'ENUM') {
            $(this).parents('tr').find('.field-auto-length').val("'',''");
        } else {
            $(this).parents('tr').find('.field-auto-length').val('');
        }
    })

    addField();

})
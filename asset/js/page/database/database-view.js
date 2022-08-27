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

    $('.remove-data').on('click', function () {

        var url = $(this).attr('data-href');

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
                    document.location.href = url;
                }
            });

        return false;
    });



    $(document).find("table tbody").sortable({
        helper: fixHelperModified,
        handle: '.fa-bars',
        start: function () {
            $(this).addClass('target-area');
        },
        stop: function (event, ui) {
            var position = '';
            var target = '';
            var field = $(ui.item[0]).data('field-name');


            var fields = [];
            $('table tbody tr').each(function () {
                fields.push($(this).data('field-name'))
            })

            if (fields.indexOf(field) == 0) {
                position = 'before';
                target = fields[fields.indexOf(field) + 1]
            } else {
                position = 'after';
                target = fields[fields.indexOf(field) - 1]
            }
            $.ajax({
                type: "GET",
                url: BASE_URL + 'administrator/database/move_column/' + table_name + '/?',
                data: {
                    position: position,
                    target: target,
                    field: field,
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.message.length) {
                        toastr['error'](response.message)
                    }

                    if (response.success !== true) {
                        toastr['error']('Error when move field')
                    }
                }
            });
        }
    });

    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    function renumber_table(tableID) {
        var count = 0;

        $(tableID + " tr").each(function () {
            count = $(this).parent().children().index($(this)) + 1;
            $(this).find('.priority').val(count);
        });
    }

});
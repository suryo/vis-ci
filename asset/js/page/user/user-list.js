$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+a', function assets() {
        window.location.href = BASE_URL + '/administrator/user/add';
        return false;
    });

    $('*').bind('keydown', 'Ctrl+f', function assets() {
        $('#sbtn').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        $('#reset').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+b', function assets() {
        $('#reset').trigger('click');
        return false;
    });

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $('.user-switch-status').switchButton({
        labels_placement: 'right',
        on_label: cclang('active'),
        off_label: cclang('inactive')
    });

    $(document).on('change', 'input.user-switch-status', function () {
        var status = 'inactive';
        var id = $(this).attr('data-user-id');
        var data = [];

        if ($(this).prop('checked')) {
            status = 'active';
        }

        data.push({
            name: csrf,
            value: token
        });
        data.push({
            name: 'status',
            value: status
        });
        data.push({
            name: 'id',
            value: id
        });

        $.ajax({
            url: BASE_URL + '/administrator/user/set_status',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        })
            .done(function (data) {
                if (data.success) {
                    toastr['success'](data.message);
                } else {
                    toastr['warning'](data.message);
                }

            })
            .fail(function () {
                toastr['error']('Error update status');
            });
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

    $('#apply').on('click', function () {

        var bulk = $('#bulk');
        var serialize_bulk = $('#form_user').serialize();

        if (bulk.val() == 'delete') {

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

        } else if (bulk.val() == '') {
            swal({
                title: "Upss",
                text: cclang('please_choose_bulk_action_first'),
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Okay!",
                closeOnConfirm: true,
                closeOnCancel: true
            });

            return false;
        }

        return false;

    }); /*end appliy click*/

    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function (event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function (event) {
        if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
    initSortable('user', $('table.dataTable'));

}); /*end doc ready*/
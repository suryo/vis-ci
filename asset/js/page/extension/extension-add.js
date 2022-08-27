$(document).ready(function () {

    "use strict";

    $(window).on('beforeunload', function () {
        return 'Are you sure you want to leave?';
    });

    $('.btn-install-extension, .btn-update-extension ').on('click', function (event) {
        event.preventDefault();
        $(this).btnSpinner();

        var btn = $(this);
        var targetUrl = $(this).data('href');

        btn.parentsUntil('.box-extension').find('.progress-download-extension').show();

        btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
            width: '100%'
        },
            800, rollOutLoading);

        function rollOutLoading() {
            btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
                width: '0%'
            },
                700, rolloverLoading);
        }

        function rolloverLoading() {
            btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
                width: '100%'
            },
                800, rollOutLoading);
        }

        $.ajax({
            url: targetUrl,
            dataType: 'JSON',
        })
            .done(function (res) {
                if (res.success) {
                    toastr['success']('Success', res.message)
                    btn.hide();
                    if (btn.hasClass('btn-install-extension')) {
                        btn.parentsUntil('.box-extension').find('.btn-active-extension').show();
                    } else {
                        btn.parentsUntil('.box-extension').find('.btn-update-extension').show();
                    }
                } else {
                    toastr['warning']('Warning', res.message)
                }
            })
            .fail(function () {
                toastr['warning']('Warning', 'Extension can\'t installed')
            })
            .always(function () {
                btn.btnSpinner('hide');
                btn.parentsUntil('.box-extension').find('.progress-download-extension').hide();
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
        var serialize_bulk = $('#form_extension').serialize();

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
                        document.location.href = BASE_URL + '/administrator/extension/delete?' + serialize_bulk;
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

}); /*end doc ready*/
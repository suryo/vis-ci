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

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $('#search').on('keyup', function () {
        var filter = $(this).val();
        var regex = new RegExp(filter, "gi");

        $(document).find('#container_permission li').hide();
        $(document).find('#container_permission li').filter(function () {

            if ($(this).text().match(regex)) {
                return true;
            }
            return false;
        }).show();
    });
    //check all
    var checkAll = $('#check_all');
    var checkboxes = $(document);

    checkAll.on('ifChecked ifUnchecked', function (event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    $(document).on('click', 'label.toggle-select-all-access', function (event) {
        var checkgroup = $(document).find($(this).attr('data-target'));
        var state = $(this).data('state');

        switch (state) {
            case 1:
            case undefined:
                $(this).data('state', 2);
                checkgroup.iCheck('check');
                break;
            case 2:
                $(this).data('state', 1);
                checkgroup.iCheck('uncheck');
                break;
        }
    });

    checkboxes.on('ifChanged', 'input.check', function (event) {
        if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

    /*load access from server*/
    function refresh_access(group_id) {
        $('.loading').show();
        $.ajax({
            url: BASE_URL + 'administrator/access/get_access_group/' + group_id,
            type: 'GET',
            dataType: 'JSON',
        })
            .done(function (res) {
                $('#container_permission').html(res.html);
                $('.check').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                $('.loading').hide();
            });
    }

    refresh_access(id_group);

    $('.tab_group').on('click', function () {
        var id = $(this).attr('data-id');
        $('#group_id').val(id);
        $('.loading').show();
        $('#btn_undo').hide();

        refresh_access(id);
    });

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_access = $('#form_access');
        var data_post = form_access.serialize();

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/access/save',
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

    $('#btn_undo').on('click', function () {
        var btn_undo = $('#btn_undo');
        var group_id = $('.nav-tabs .active a').attr('data-id');

        swal({
            title: "Are you sure?",
            text: "data not saved and data will be restored as before!",
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
                    refresh_access(group_id);
                    btn_undo.hide();
                }
            });
    }); /*end btn undo*/

    /*if check clicked, btn undo is show*/
    checkboxes.on('ifChanged', 'input.check', function (event) {
        $('.btn_undo').fadeIn();
    }); /*end btn check*/


}); /*end doc ready*/
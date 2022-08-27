$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+a', function assets() {
        window.location.href = BASE_URL + '/administrator/menu/add/' + '<?= $this->uri->segment(4); ?>';
        return false;
    });

    $('*').bind('keydown', 'Ctrl+r', function assets() {
        window.location.href = BASE_URL + '/administrator/menu_type/add/';
        return false;
    });

    $('*').bind('keydown', 'Ctrl+s', function assets() {
        $('#btn_save').trigger('click');
        return false;
    });

    $('.remove-data').on('click', function () {
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "data to be deleted can not be restored!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function (isConfirm) {
                if (isConfirm) {
                    document.location.href = url;
                }
            });

        return false;
    }); /*end remove data click*/

    var timeout;
    $('.dd').on('change', function () {
        clearTimeout(timeout);
        timeout = setTimeout(updateOrderMenu, 2000);
    });

    function updateOrderMenu(ignoreMessage) {
        $('.loading').removeClass('loading-hide');
        var shownotif = true;
        var menu = $('.dd').nestable('serialize');

        if (typeof shownotif == 'undefined') {
            var shownotif = true;
        }

        if (typeof ignoreMessage == 'undefined') {
            var ignoreMessage = false;
        }

        var data = {};
        data['menu'] = menu
        data[csrf] = token

        $.ajax({
            url: BASE_URL + 'administrator/menu/save_ordering',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        })
            .done(function (res) {
                if (res.success) {
                    $('.sidebar-menu').html(res.menu);
                    if (shownotif) {
                        if (!ignoreMessage) {
                            toastr['success'](res.message);
                        }
                    }
                } else {
                    if (shownotif) {
                        if (!ignoreMessage) {
                            toastr['warning'](res.message);
                        }
                    }
                }
            })
            .fail(function () {
                if (!ignoreMessage) {
                    toastr['warning']('Error save data please try again later');
                }
            })
            .always(function () {
                $('.loading').addClass('loading-hide');
            });
    }

    $('#nestable').nestable({
        group: 1
    });

    $('.clickable').on('click', function () {
        var href = $(this).attr('data-href');

        window.location.href = href;

        return false;
    }); /*end clickable click*/

    $(".m_switch_check:checkbox").mSwitch({
        onRender: function (elem) {
            changeSharingDashboard(elem.val(), 'dont_update');
            if (elem.val() == 0) {
                $.mSwitch.turnOff(elem);
            } else {
                $.mSwitch.turnOn(elem);
            }
        },
        onTurnOn: function (elem) {
            changeSharingDashboard(1, 'update');
        },
        onTurnOff: function (elem) {
            changeSharingDashboard(0, 'update');
        }
    });

    function setMenuActive(id, status) {
        var data = [];

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
            url: BASE_URL + '/administrator/menu/set_status',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        })
            .done(function (data) {
                if (data.success) {
                    toastr['success'](data.message);
                    updateOrderMenu(true)
                } else {
                    toastr['warning'](data.message);
                }

            })
            .fail(function () {
                toastr['error']('Error update status');
            });
    }


    $('.menu-toggle-activate').dblclick(function (event) {
        event.stopPropagation();
        var status = $(this).data('status');
        var id = $(this).data('id');

        switch (status) {
            case undefined: case 0:
                $(this).removeClass('menu-toggle-activate_inactive');
                $(this).data('status', 1)
                setMenuActive(id, 1);
                break;
            case 1:
                $(this).addClass('menu-toggle-activate_inactive');
                $(this).data('status', 0)
                setMenuActive(id, 0);
                break;
        }
    });

    $('.dd3-item').on('mouseover', function () {
        $('.dropdown').removeClass('open')

        $(this).find('.dropdown:first').addClass('open')
    });

}); /*end doc ready*/
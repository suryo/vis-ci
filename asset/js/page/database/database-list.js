$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+a', function assets() {
        window.location.href = BASE_URL + '/administrator/Database/add';
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


    $('.tree-table').each(function () {

        var tree = new Tree(this, {
            navigate: true // allow navigate with ArrowUp and ArrowDown
        });
        tree.on('open', e => function (e) {

        });

        var table_name = $(this).data('name')
        var table_name_crypt = $(this).data('name-crypt')

        tree.on('action', function (e, f) {
            console.log(e, f)
            window.location.href = BASE_URL + '/administrator/database/change_field/' + table_name_crypt + '?field=' + e.node.name
        });

        tree.on('fetch', (folder) => {


            $.ajax({
                type: "GET",
                url: BASE_URL + 'administrator/database/get_field',
                data: {
                    table_name: $(folder).html()
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $.each(response.data, function (indexInArray, val) {
                            tree.file({
                                name: val.name
                            }, folder);
                        });
                    }
                }
            });

            folder.resolve();
        });

        var structure = [{
            name: $(this).data('name'),
            type: Tree.FOLDER,
            asynced: true
        }];
        // keep track of the original node objects
        tree.on('created', (e, node) => {
            e.node = node;
        });
        tree.json(structure);
    })


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
        var serialize_bulk = $('#form_database').serialize();

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
                        document.location.href = BASE_URL + '/administrator/database/delete?' + serialize_bulk;
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

    });/*end appliy click*/

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
    initSortable('database', $('table.dataTable'));
}); /*end doc ready*/
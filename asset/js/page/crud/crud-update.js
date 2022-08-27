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

    $('.btn-remove-field').on('click', function (event) {

        var btn = $(this);
        swal({
            title: cclang('are_you_sure'),
            text: cclang('data_to_be_deleted_can_not_be_restored'),
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
                    btn.parents('tr').fadeOut(function () {
                        $(this).remove();
                    });
                }
            });

        return false;
    });
    $('.input_type').trigger('chosen:updated');

    //update validation
    $(document).find('table tr .input_type').each(function () {
        updateValidation($(this));
    });

    //Make diagnosis table sortable
    $(document).find("#diagnosis_list tbody").sortable({
        helper: fixHelperModified,
        handle: '.fa-bars',
        start: function () {
            $(this).addClass('target-area');
        },
        stop: function (event, ui) {
            renumber_table('#diagnosis_list');
        }
    });

    $(document).find("#diagnosis_list tbody").sortable({
        helper: fixHelperModified,
        stop: function (event, ui) {
            renumber_table('#diagnosis_list')
        },
    });

    /*frezee thead row*/
    $(document).find('table#diagnosis_list').floatThead({
        useAbsolutePositioning: true,
    });

    $('.btn_save').on('click', function () {
        $('.message').hide();

        var form_crud = $('#form_crud');
        var data_post = form_crud.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });
        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/crud/edit_save/' + window.crud.id,
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {

                    if (save_type == 'back') {
                        window.location.href = res.redirect;
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
                }, 3000);
            });

        return false;
    }); /*end btn save*/

    //Helper function to keep table row from collapsing when being sorted
    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    //Renumber table rows
    function renumber_table(tableID) {
        var count = 0;

        $(tableID + " tr").each(function () {
            count = $(this).parent().children().index($(this)) + 1;
            $(this).find('.priority').val(count);
        });
    }
}); /*end doc ready*/
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

    $('.not-working').hide();
    $('#table_name').val('').trigger('chosen:updated');

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
            url: BASE_URL + '/administrator/crud/add_save',
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

    $('#table_name').on('change', function () {
        var table = $(this).val();
        $('.loading2').show();
        $.ajax({
            url: BASE_URL + '/administrator/crud/get_field_data/' + table,
            type: 'GET',
            dataType: 'JSON',
        })
            .done(function (res) {
                if (res.success) {

                    $('#subject, #title').val(res.subject);
                    $('.wrapper-crud').html(res.html);
                    var config = {
                        '.chosen-select': {},
                        '.chosen-select-deselect': {
                            allow_single_deselect: true
                        },
                        '.chosen-select-no-single': {
                            disable_search_threshold: 10
                        },
                        '.chosen-select-no-results': {
                            no_results_text: 'Oops, nothing found!'
                        },
                        '.chosen-select-width': {
                            width: "95%"
                        }
                    }
                    for (var selector in config) {
                        $(document).find(selector).chosen(config[selector]);
                    }
                    $(document).find('.tip').tooltip();
                    //Make diagnosis table sortable
                    $(document).find("#diagnosis_list tbody").sortable({
                        helper: fixHelperModified,
                        handle: '.dragable',
                        start: function () {
                            $(this).addClass('target-area');
                        },
                        stop: function (event, ui) {
                            renumber_table('#diagnosis_list');
                        }
                    });

                    //check all
                    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                        checkboxClass: 'icheckbox_minimal-red',
                        radioClass: 'iradio_minimal-red'
                    });

                    $(document).find("#diagnosis_list tbody").sortable({
                        helper: fixHelperModified,
                        stop: function (event, ui) {
                            renumber_table('#diagnosis_list')
                        }
                    });

                    /*update validation*/
                    $(document).find('table tr .input_type').each(function () {
                        updateValidation($(this));
                    });

                    /*frezee thead row*/
                    $(document).find('table#diagnosis_list').floatThead({
                        useAbsolutePositioning: true,
                    });

                    /*added devfault validation rules*/
                    $(document).find('table tr .validation').each(function () {

                        var parent = $(this).parents('tr');
                        var id = parent.find('#crud-id').val();
                        var name = parent.find('#crud-name').val();
                        var data_type = parent.find('#crud-data-type').val();
                        var primarykey = parent.find('#crud-primarykey').val();
                        var max_length = parent.find('#crud-max-length').val();

                        if (primarykey != 1) {
                            addValidation($(this), id, name, 'required', 'no');

                            if (max_length != 0) {
                                addValidation($(this), id, name, 'max_length', 'yes', max_length);
                            }
                        }

                        if (data_type == 'number') {
                            addValidation($(this), id, name, 'number', 'no');
                        }

                    });

                } /*end response success*/

            })
            .fail(function () {
                $('.message').printMessage({
                    message: 'Error getting data',
                    type: 'warning'
                });
            })
            .always(function () {
                $('.loading2').hide();
            });

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

}); /*end doc ready*/

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


    $('#id').val('');

    $(document).find("#diagnosis_list tbody").sortable({
        helper: fixHelperModified,
        handle: 'td:first',
        start: function () {
            $(this).addClass('target-area');
            updatePlaceHolder();
        },
        stop: function (event, ui) {
            renumber_table('#diagnosis_list');
            updatePlaceHolder();
        }
    });

    $(document).on('change', 'input.switch-button', function () {
        if ($(this).prop('checked')) {
            $(this).parents('.box-setting').find('.input_setting').fadeOut('easeInOutQuart');
        } else {
            $(this).parents('.box-setting').find('.input_setting').focus().fadeIn('easeInOutQuart');
        }
    });

    $(document).find(".trash").sortable({
        connectWith: $(document).find("#diagnosis_list tbody"),
    });

    $("#tools tbody").sortable({
        connectWith: $(document).find("#diagnosis_list tbody"),
        helper: 'clone',
        placeholder: "ui-state-highlight",
        start: function (ui, event) {
            $('.toolbox-form').css('overflow', '');
            $('.toolbox-form').css('overflow-y', '');
            updatePlaceHolder();
        },
        remove: function (event, ui) {
            ui.item.enableSelection().clone().prependTo($(".toolbox-form .tool-wrapper table tbody"));
            $('.toolbox-form').css('overflow-y', 'auto');
            updatePlaceHolder();
            renumber_table('#diagnosis_list');
            var id_field = getUnixId();
            var tpl = ui.item.html()
                .replaceAll('{field_name}', 'field_' + id_field)
                .replaceAll('{field_id}', id_field);

            ui.item.replaceWith('<tr class="new-item-sortable">' + tpl + '</tr>');

            var new_item_sortable = $('.new-item-sortable');

            new_item_sortable.find('.chosen-select').chosen('destroy');
            new_item_sortable.find('#input_type_chosen, #validation_chosen,#relation_table_chosen, #relation_value_chosen, #relation_label_chosen').remove();
            new_item_sortable.find('.chosen-select').chosen();

            /*added default validation rules*/
            new_item_sortable.find('.validation').each(function () {
                var id = $(this).parents('tr').find('#form-id').val();
                var name = $(this).parents('tr').find('#form-name').val();

                addValidation($(this), id, name, 'required', 'no');
            });

            new_item_sortable.find('.switch-button').switchButton({
                labels_placement: 'right',
                on_label: 'yes',
                off_label: 'no'
            });

            $('.new-item-sortable').removeClass('new-item-sortable');


        }
    }).disableSelection();

    function updatePlaceHolder() {
        if ($('.table-form tr[class!="sort-placeholder"]').length <= 0) {
            $('.table-form .sort-placeholder').show();
        } else {
            $('.table-form .sort-placeholder').hide();
        }
    }

    /*update validation*/
    $(document).find('table tr .input_type').each(function () {
        updateValidation($(this));

        var relation = $(this).find('option:selected').attr('relation');
        var custom_value = $(this).find('option:selected').attr('custom-value');
        var table_relation = $(this).parents('td').find('.relation_table');
        var custom_option_container = $(this).parents('td').find('.custom-option-container');

        if (relation == 1) {
            table_relation.val('').trigger('chosen:updated').parents('.form-group').show();

        } else {
            $(this).parents('td').find('.relation_field').parents('.form-group').hide();
            $(this).parents('td').find('.relation_field').val('');
        }

        if (custom_value == 1) {
            custom_option_container.show();

        } else {
            custom_option_container.hide();
        }
    });

    $('input[type="checkbox"].preview').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $('.btn-tool').on('click', function (event) {
        $('.toolbox-form').css('overflow-y', 'auto');

        return false;
    });

    $('.btn-form-designer').on('click', function (event) {
        $('.control-sidebar').addClass('control-sidebar-open');
        buttonToggleSideBarClose($('.btn-round-element'));
    });

    var preview = $('#preview');

    $('.btn-form-preview').on('click', function () {
        if ($('.table-form tr[class!="sort-placeholder"]').length <= 0) {
            $('.control-sidebar').addClass('control-sidebar-open');
            toastr['warning']('Please make form first');
            buttonToggleSideBarOpen($('.btn-round-element'));
            return false;
        }
        $('.control-sidebar').removeClass('control-sidebar-open');
        $('.loading3').show();

        var form_form = $('#form_form');
        var data_post = form_form.serialize();
        $('.preview-form').html('');

        $.ajax({
            url: BASE_URL + '/administrator/form/preview',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                $('.message').html('');
                if (res.success) {
                    $('.preview-form').html(res.html);
                    $('.preview-form').show();
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
                    message: 'Error getting data',
                    type: 'warning'
                });
            })
            .always(function () {
                $('.loading3').hide();
            });
    });

    $('.btn_save').on('click', function () {
        $('.message').hide();

        var form_form = $('#form_form');
        var data_post = form_form.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/form/add_save',
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

                    if (typeof res.id != 'undefined') {
                        $('#id').val(res.id);
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
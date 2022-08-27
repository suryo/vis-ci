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

    $('#table_name').val('').trigger('chosen:updated');

    $('.btn_save').on('click', function () {
        $('.message').hide();

        var form_rest = $('#form_rest');
        var data_post = form_rest.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/rest/add_save',
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
            url: BASE_URL + '/administrator/rest/get_field_data/' + table,
            type: 'GET',
            dataType: 'JSON',
        })
            .done(function (res) {
                if (res.success) {
                    $('#subject, #title').val(res.subject);
                    $('.wrapper-rest').html(res.html);
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

                    //check all
                    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                        checkboxClass: 'icheckbox_minimal-red',
                        radioClass: 'iradio_minimal-red'
                    });

                    /*update validation*/
                    $(document).find('table tr .input_type').each(function () {
                        updateValidation($(this));
                    });


                    /*added devfault validation rules*/
                    $(document).find('table tr .validation').each(function () {

                        var parent = $(this).parents('tr');
                        var id = parent.find('#rest-id').val();
                        var name = parent.find('#rest-name').val();
                        var data_type = parent.find('#rest-data-type').val();
                        var primarykey = parent.find('#rest-primarykey').val();
                        var max_length = parent.find('#rest-max-length').val();

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

}); /*end doc ready*/
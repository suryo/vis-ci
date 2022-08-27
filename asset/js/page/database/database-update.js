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

    var selected = $('.table-field-item');
    selected.find('.field-auto-name').val(field.name);
    selected.find('.field-auto-type').val(field.type.toUpperCase());
    var value = String(field.detail.Type).match(/\w\(([\w\W]+)\)/);

    if (value != null) {
        selected.find('.field-auto-length').val(value[1]);
    }


    selected.find('.field-auto-null').prop('checked', field.detail.Null != 'NO')
    if (field.detail.Default != null) {
        selected.find('.table-default').val('as_defined').trigger('change')
        selected.find('.defined-value').val(field.detail.Default)
    } else {
        selected.find('.table-default').val(field.detail.Default)
    }
    selected.find('.field-auto-increment').prop('checked', field.detail.Extra == 'auto_increment')


    $('#btn_cancel').on('click', function () {

        window.location.href = BASE_URL + 'administrator/database/view/' + table_name;


        return false;
    }); /*end btn cancel*/

    $('.btn_save').on('click', function () {
        $('.message').fadeOut();

        var form_database = $('#form_database');
        var data_post = form_database.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({ name: 'save_type', value: save_type });
        data_post.push({ name: 'field_before', value: field.name });

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/database/change_field_save/' + table_name,
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                $('form').find('.form-group').removeClass('has-error');
                $('.steps li').removeClass('error');
                $('form').find('.error-input').remove();
                if (res.success) {

                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }

                    $('.message').printMessage({ message: res.message });
                    $('.message').fadeIn();
                    resetForm();
                    $('.chosen option').prop('selected', false).trigger('chosen:updated');

                } else {
                    if (res.errors) {

                        $.each(res.errors, function (index, val) {
                            $('form #' + index).parents('.form-group').addClass('has-error');
                            $('form #' + index).parents('.form-group').find('small').prepend(`
                    <div class="error-input">`+ val + `</div>
                    `);
                        });
                        $('.steps li').removeClass('error');
                        $('.content section').each(function (index, el) {
                            if ($(this).find('.has-error').length) {
                                $('.steps li:eq(' + index + ')').addClass('error').find('a').trigger('click');
                            }
                        });
                    }
                    $('.message').printMessage({ message: res.message, type: 'warning' });
                }

            })
            .fail(function () {
                $('.message').printMessage({ message: 'Error save data', type: 'warning' });
            })
            .always(function () {
                $('.loading').hide();
                $('html, body').animate({ scrollTop: $(document).height() }, 2000);
            });

        return false;
    }); /*end btn save*/

}); /*end doc ready*/
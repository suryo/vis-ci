$(function () {

    "use strict";

    $('[name="action"]').on('change', function () {
        var action = $(this).val()

        $('.layout-icon-wrapper').removeClass('active');
        $(this).parents('.layout-icon-wrapper').addClass('active');

        changeAction(action);
    })

    function changeAction(action) {
        $('.action-form-wrapper').html('')

        $.ajax({
            url: BASE_URL + '/administrator/crud/get_action_form/' + action,
            type: 'GET',
            dataType: 'json',
        })
            .done(function (res) {
                if (res.success) {
                    $('.action-form-wrapper').html(res.html)
                } else {

                }

            })
            .fail(function () {

            })
            .always(function () {

            });

        return false;

    }

    $(document).on('click', 'a.remove-action-item', function (event) {
        event.preventDefault();

        var parent = $(this).parents('.action-item');

        $.ajax({
            url: BASE_URL + '/administrator/crud/remove_action/' + parent.data('id'),
            type: 'GET',
            dataType: 'json',
        })
            .done(function (res) {
                if (res.success) {
                    $(`.action-item[data-id="${parent.data('id')}"]`).remove();
                    toastr['success'](`Action removed `)
                } else {
                    toastr['error'](res.message)
                }

            })
            .fail(function () {

            })
            .always(function () {

            });
    });

    $(document).on('click', 'a.btn-select-icon', function (event) {
        event.preventDefault();

        $('#modalIcon').modal('show');
    });


    $('.btn-save-action').on('click', function () {
        $('.message').hide();

        var form_action = $('#form_action');
        var data_post = form_action.serialize();

        $('.loading').show();

        $.ajax({
            url: BASE_URL + '/administrator/crud/save_action',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function (res) {
                if (res.success) {
                    $('.modal-add-action').modal('hide')

                    var html = ` 
                <div class="action-item" data-id="${res.action.id}">
                   ${res.action.action}
                   <a href="" class="remove-action-item"><i class="fa fa-trash"></i> </a>
                   <a href="" class="update-action-item"><i class="fa fa-edit"></i> </a>
                </div>`;

                    $('.action-item-wrapper').append(html)
                    toastr['success']('Action created')

                } else {
                    toastr['error'](res.message)

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

            });

        return false;
    }); /*end btn save*/

})
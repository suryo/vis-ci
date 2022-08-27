$(document).ready(function () {

    "use strict";

    var fileInput = $('.file-styling :file');

    fileInput.change(function () {
        $this = $(this);
        $(this).parent().find('.info-file').text($this.val());
    });

    var form = $('.form-add');

    form.on('submit', function () {
        $('.loading').show();
        var submitButton = $(this).find('input[type=submit]');
        var defaultValue = submitButton.val();

        submitButton.val('Submitting');

        $('.url-api').html(form.attr('action') + '?' + decodeURIComponent(form.serialize()))
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            dataType: 'JSON',
            data: form.serialize(),
            headers: {
                'X-Api-Key': $('#x_api_key').val(),
                'X-Token': $('#x_token').val(),
            }
        })
            .fail(function (response) {
                toastr['error']('Error API Request');
            })
            .always(function (response, status, xhr) {
                $('.loading').hide();
                submitButton.val(defaultValue);
                var responseReff = response;

                if (typeof xhr == 'object') {
                    responseReff = xhr;
                }

                if (typeof responseReff.statusText == 'undefined') {
                    responseReff.statusText = 'OK';
                }

                $('.status').html(responseReff.status + ' ' + responseReff.statusText);
                $('.result-json').JSONView(responseReff.responseJSON);
                $('.status').addClass('response-' + responseReff.status);

                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
            });

        return false;
    });


    $.each(rest_fields, function (idx, item) {
        $('#rest_field').append(`
          <option value="${item.field_name}">${item.field_name}</option>
       `)
        $('#sort_field').append(`
          <option value="${item.field_name}">${item.field_name}</option>
       `)
    })

    var increment = 0;

    function addFilter() {
        var filter = $('.filter-item-template').html();
        filter = filter.replaceAll('{idx}', increment++)

        $('.filters-item-wrapper').append(filter);

    }
    $('.btn-add-filter').unbind('click')
    $('.btn-remove-filter').unbind('click')
    $(document).on('click', 'a.btn-add-filter', function (event) {
        event.preventDefault();
        addFilter();
    })
    $(document).on('click', 'a.btn-remove-filter', function (event) {
        event.preventDefault();
        $(this).parent().remove()
    })

    addFilter();

})
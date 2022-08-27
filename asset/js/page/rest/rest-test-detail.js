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
            .always(function (response) {
                if (typeof response.responseJSON == 'undefined') {
                    $('.result-json').JSONView(response);
                    $('.status').html('200 OK');
                    $('.status').addClass('response-200');
                } else {
                    $('.result-json').JSONView(response.responseJSON);
                    $('.status').html(response.status + ' ' + response.statusText);
                    $('.status').addClass('response-' + response.status);
                }

                submitButton.val(defaultValue);
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
                $('.loading').hide();
            });

        return false;
    });
})
$(function () {

    "use strict";

    $.fn.printMessage = function (opsi) {
        var opsi = $.extend({
            type: 'success',
            message: 'Success',
            timeout: 500000
        }, opsi);

        $(this).hide();
        $(this).html(' <div class="col-md-12 message-alert" ><div class="callout callout-' + opsi.type + '"><h4>' + opsi.type + '!</h4>' + opsi.message + '</div></div>');
        $(this).slideDown('slow');
        setTimeout(function () {
            $('.message-alert').slideUp('slow');
        }, opsi.timeout);
    };
    $('.refresh-captcha').on('click', function () {
        var capparent = $(this);

        $.ajax({
            url: BASE_URL + '/captcha/reload/' + capparent.parent('.captcha-box').attr('data-captcha-time'),
            dataType: 'JSON',
        })
            .done(function (res) {
                capparent.parent('.captcha-box').find('.box-image').html(res.image);
                capparent.parent('.captcha-box').attr('data-captcha-time', res.captcha.time);
            })
            .fail(function () {
                $('.message').printMessage({
                    message: 'Error getting captcha',
                    type: 'warning'
                });
            })
            .always(function () { });
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
});
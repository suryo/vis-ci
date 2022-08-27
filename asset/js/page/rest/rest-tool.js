$(document).ready(function () {

    "use strict";

    if (segment == 'get-token') {
        $('#url').val('{api_endpoint}user/request_token');
        addHeaderRequest('X-Api-Key', '');
        addBodyRequest('username', '');
        addBodyRequest('password', '');

        swal({
            title: 'Introduction',
            text: '<p style="text-align:left; line-height:25px;" align="left"><b>1)</b> fill <span class="text-green">username / email</span> and <span class="text-green">password</span> in request body<br> <b>2)</b> switch to tab header and fill <span class="text-green">x-api-key</span> header <br> <b>3)</b> and then click send button.</p>',
            html: true
        });

        $(document).ajaxComplete(function (event, xhr, settings) {
            if (typeof xhr.responseJSON == 'object') {
                if (typeof xhr.responseJSON.message != 'undefined') {
                    var message = xhr.responseJSON.message.trim().toLowerCase();
                    if (message == 'invalid api key') {
                        swal({
                            title: 'API Key Is not valid!',
                            text: 'if you do not have key, get the key by visiting <a href="' + BASE_URL + 'administrator/keys" target="blank">this page</a>',
                            html: true
                        });
                        return false;
                    } else if (message == 'wrong number of segments') {
                        swal({
                            title: 'Token Is not valid!',
                            text: 'following <a href="' + BASE_URL + 'administrator/rest/tool/get-token" target="blank">this URL</a> guide to get a token ',
                            html: true
                        });
                        return false;
                    }
                }
            }
        });
    }

    $('#url').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: BASE_URL + 'administrator/rest/get_resource',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        }
    });
});
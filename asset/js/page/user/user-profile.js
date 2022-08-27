$(document).ready(function () {

    "use strict";

    $('*').bind('keydown', 'Ctrl+e', function assets() {
        $('#btn_edit').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        window.location.href = BASE_URL + '/administrator/user';
        return false;
    });

}); /*end doc ready*/
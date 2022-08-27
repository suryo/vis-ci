function cclang(key, params) {
    if (typeof _lang[key] != 'undefined') {
        var lang = _lang[key];
        if (typeof params != 'undefined') {
            if (typeof params == 'object') {
                var num_param = 1;
                $.each(params, function (index, val) {
                    lang = lang.replace('$' + num_param, val);
                    num_param++;
                });
            } else {
                lang = lang.replace('$1', params);
            }
        }
        return lang;
    } else {
        console.log('langkey ' + key + ' not found')
    }
}
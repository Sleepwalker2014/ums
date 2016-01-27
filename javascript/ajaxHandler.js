function ajaxCall (url, par, json) {
    var options = {type: 'POST',
                   url: url,
                   data: par};

    if (json) {
        options.dataType = "json";
    }

    var jqxhr = $.ajax(options);
    return jqxhr;
}

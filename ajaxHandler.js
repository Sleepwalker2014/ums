function ajaxCall (url, par) {
    var jqxhr = $.ajax({
                    type: 'POST',
                    url: url,
                    data: par
                });
    return jqxhr;
}

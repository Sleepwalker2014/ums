function ajaxCall (url) {
    var jqxhr = $.ajax(url)
                 .done(function() {
                     alert( "success" );
                 })
                 .fail(function() {
                     alert( "error" );
                 })
                 .always(function() {
                     alert( "complete" );
                 });
    return jqxhr;
}

$(document).ready(function() {
    $("a").click(function() {
        var navContent = $($(this).attr('href'));
        var postData = {
            'actionCode' : "17",
        };
        ajaxCall('php/routingHandler.php', postData).always(function(result) {
            navContent.html(result);
        });
    });
});
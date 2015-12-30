$(document).ready(function() {
    $(".nav-tabs li a").click(function() {
        var navContent = $($(this).attr('href'));
        var postData = {
            'actionCode' : "17",
        };
        ajaxCall('php/routingHandler.php', postData).always(function(result) {
            navContent.html(result);
        });
    });
});
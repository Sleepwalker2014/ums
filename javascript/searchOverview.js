$(document).ready(function() {
    $(".removeNotification").click(function() {
        var notificationDiv = $(this).closest('.notification');
    
        var postData = {
            'actionCode' : "18",
    		'notification' : notificationDiv.data("notification")
        };

        ajaxCall('php/routingHandler.php', postData).always(function(result) {
    		notificationDiv.remove();
        });
    });
});
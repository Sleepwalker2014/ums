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
    
    $(".editSearch").click(function() {
        var postData = {
    		'notificationId' : $(this).data('notification'),
            'actionCode' : "20"
        };

        ajaxCall('php/routingHandler.php', postData).always(function(result) {
        	$('#content').html(result);
        });
    });
});
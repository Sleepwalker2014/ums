$(document).ready(function() {
    ajaxCall('php/routingHandler.php', null, true).success(function(result) {
        $('#mainContent').html(result.templateData);
    });
});
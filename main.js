$(document).ready(function() {
    $("[data-serverAction]").click(function() {
        ajaxCall('php/routingHandler.php', {'actionCode': $(this).attr("data-serverAction")}).success(function(result) {
            $('#mainContainer').html(result);
        });
    });
});

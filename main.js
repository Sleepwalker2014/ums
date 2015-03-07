$(document).ready(function() {
    ajaxCall('http://localhost/marcel/ums/index.php?action=1', {'actionm': 2}).success(function(result) {
        $('#contentPlaceHolder').html(result);
    });

    $("[data-serverAction]").click(function() {
        ajaxCall('php/routingHandler.php', {'actionCode': $(this).attr("data-serverAction")}).success(function(result) {
            $('#mainContainer').html(result);
        });
    });
});

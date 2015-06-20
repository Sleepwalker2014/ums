$(document).ready(function() {
    $("#logoutBtn").click(function() {
        logoutUser();
    });

    $(".mapAction").click(function() {
        alert("ok");
    });

    $("#settingsBtn").click(function() {
        ajaxCall('php/routingHandler.php', {'actionCode': "8"}).done(function(result) {
            $('#content').html(result);
        });
    });

    $("#editAnimalsBtn").click(function() {
        ajaxCall('php/routingHandler.php', {'actionCode': "9"}).done(function(result) {
            $('#content').html(result);
        });
    });
});

function logoutUser () {
    ajaxCall('php/routingHandler.php', {'actionCode': "7"});
}
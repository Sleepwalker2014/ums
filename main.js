$(document).ready(function() {
    $("#logoutBtn").click(function() {
        logoutUser();
    });
});

function logoutUser () {
    ajaxCall('php/routingHandler.php', {'actionCode': "7"});
}
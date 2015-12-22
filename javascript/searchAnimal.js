$(document).ready(function() {
    $('#missingDate').datetimepicker({
        locale : 'de-DE',
        format : 'DD.MM.YYYY'
    });

    $("#saveMissingAnnounce").click(function() {
        var postData = {
            'actionCode' : "16",
            'reward' : $('#reward').val(),
            'missingDate' : $('#missingDate').val(),
            'additionalInfo' : $('#additionalInfo').val(),
            'animalId' : $('#animalId').val()
        };
        ajaxCall('php/routingHandler.php', postData).always(function(result) {
            $('#content').html(result);
        });
    });
});
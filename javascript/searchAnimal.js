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
			'missingLocation' : $('#missingLocation').val(),
			'additionalInfo' : $('#additionalInfo').val(),
			'animalId' : $('#animalId').val()
		};
		ajaxCall('php/routingHandler.php', postData).always(function(result) {
			$('#content').html(result);
		});
	});

	initialize();
});

var autocomplete;
function initialize() {
	autocomplete = new google.maps.places.Autocomplete((document
			.getElementById('missingLocation')), {
		types : [ 'geocode' ]
	});
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
	});
}
function addMarker (map, position, title) {
    marker = new google.maps.Marker({
        position: position,
        map: map,
        title: title
    });

    google.maps.event.addListener(marker,'click',function() {
        map.setZoom(19); 
        map.setCenter(marker.getPosition());
        ajaxCall('php/routingHandler.php', {'actionCode': "34"}).success(function(result) {
            $('#modalPlaceHolder').html(result);
            $('#markerModal').modal('show');
        });
    });
}

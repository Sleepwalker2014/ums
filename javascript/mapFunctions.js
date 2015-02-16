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

function setAllMarkers () {
    ajaxCall('php/routingHandler.php', {'actionCode': "2"}).success(function(result) {
     });
}

function googleMap () {
    var map;
    var mapOptions = {
        zoom : 4,
        center : new google.maps.LatLng(-34.397, 150.644),
        mapTypeId: google.maps.MapTypeId.SATELLITE
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
                                                     var pos = new google.maps.LatLng(position.coords.latitude,
                                                                                      position.coords.longitude);

                                                     var infowindow = new google.maps.InfoWindow({map : map,
                                                                                                  position : pos,
                                                                                                  content : 'Sie sind hier'
                                                                                                });

                                                     map.setCenter(pos);
                                                 },
                                                 function() {
                                                     handleNoGeolocation(true);
                                                 });
    } else {
        handleNoGeolocation(false);
    }

    googleMap.prototype.addMarker = function (googleMarker) { googleMarker.marker.setMap (map); googleMarker.map = map };
}

function googleMarker (position, title) {
    this.marker = new google.maps.Marker({
                                             position: position,
                                             title: title
                                        });
    this.map    = null;

    googleMarker.prototype.setIcon        = function (iconPath) { this.marker.setIcon(iconPath); return this };
    google.maps.event.addListener(this.marker, 'click', function () { this.map.setZoom(19); 
                                                                      this.map.setCenter(position);
                                                                      ajaxCall('php/routingHandler.php', {'actionCode': "1"}).success(function(result) {
                                                                                                                                         $('#modalPlaceHolder').html(result);
                                                                                                                                         $('#markerModal').modal('show');
                                                                                                                                                          });
   });
}


function initMap() {
    // Create a map object and specify the DOM element for display.
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 25.649268, lng: -100.289174},
        scrollwheel: false,
        zoom: 25
    });
	
	var lat = document.getElementById('lat0');
	var lng = document.getElementById('lng0');
	
	var Latlng = new google.maps.LatLng(25.649268,-100.289174);
	
	var marker = new google.maps.Marker({
    position: Latlng,
    title:"Hello World!"
	});

// To add the marker to the map, call setMap();
	marker.setMap(map);
}
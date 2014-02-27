function initialize() {
	var mapOptions = {
		center: new google.maps.LatLng(40.62567,22.96212),
		zoom: 13
	};
	var map = new google.maps.Map(document.getElementById("map-canvas"),
			mapOptions);
}
google.maps.event.addDomListener(window, 'load', initialize);
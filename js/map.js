function initialize() {
	var mapOptions = {
		center: new google.maps.LatLng(40.62567,22.96212),
		zoom: 13
	};
	
	MAP = new google.maps.Map(document.getElementById("map-canvas"),
			mapOptions);
}

$( document ).ready(function() {
	initialize();
});

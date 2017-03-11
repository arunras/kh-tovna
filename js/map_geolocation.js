/*=================
	Map GeoLocation
==================*/
var map;
var iw;
var markers = [];

function initialize() {
	var myOptions = {
		zoom: 13,
		mapTypeControl: true,
		navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('mapCanvas'),myOptions);
	
	// Try HTML5 geolocation
	getMyLocation();
	
}

/*getMyLocation*/
function getMyLocation(){
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			var infowindow = new google.maps.InfoWindow({
				map: map,
				position: latLng,
				content: 'Location found using HTML5.'
			});
			var marker = new google.maps.Marker({
			      position: latLng, 
			      map: map, 
			      title:"You are here!"
			});
			map.setCenter(latLng);
			}, function() {
					handleNoGeolocation(true);
				});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
    }
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
    	var content = 'Error: The Geolocation service failed.';
    } else {
    	var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
      map: map,
      position: new google.maps.LatLng(60, 105),
      content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}
/*END getMyLocation*/

google.maps.event.addDomListener(window, 'load', initialize);
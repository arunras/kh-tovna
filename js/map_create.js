/*=================
	Map GeoLocation
==================*/
var mymap;
var geocoder = new google.maps.Geocoder();

function initialize() {
	var myOptions = {
		zoom: 13,
		mapTypeControl: true,
		navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};
	mymap = new google.maps.Map(document.getElementById('imap'),myOptions);
	
	// Try HTML5 geolocation
	getMyLocation();
}

/*getMyLocation*/
function getMyLocation(){
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			/*
			var infowindow = new google.maps.InfoWindow({
				map: map,
				position: latLng,
				content: 'Location found using HTML5.'
			});
			*/
			var marker = new google.maps.Marker({
			      position: latLng, 
			      map: mymap,
			      draggable: true,
			      title:"You are here!"
			});
			mymap.setCenter(latLng);
			
			//===
			// Update current position info.
			updateMarkerPosition(latLng);
			geocodePosition(marker.getPosition());
			
			// Add dragging event listeners.
			google.maps.event.addListener(marker, 'dragstart', function() {
				updateMarkerAddress('Dragging...');
			});
			
			google.maps.event.addListener(marker, 'drag', function() {
				//updateMarkerStatus('Dragging...');
				updateMarkerPosition(marker.getPosition());
			});
			
			google.maps.event.addListener(marker, 'dragend', function() {
				//updateMarkerStatus('Drag ended');
				geocodePosition(marker.getPosition());
			});
			//===
			
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
      map: mymap,
      position: new google.maps.LatLng(60, 105),
      content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    mymap.setCenter(options.position);
}
/*END getMyLocation*/

/*Update Marker*/
//Set Position
function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      //updateMarkerAddress(responses[0].formatted_address);
	  updateMarkerAddress(responses[0].formatted_address);
	  //aaaaaaaaaaaaaaa
	  for (var i = 0; i < responses[0].address_components.length; i++)
		{
			var addr = responses[0].address_components[i];
			// check if this entry in address_components has a type of country
			if (addr.types[0] == "administrative_area_level_1"){
				//alert (addr.short_name);
				document.getElementById('icity').value = addr.long_name;
			}
			if (addr.types[0] == "country"){
				//alert (addr.short_name);
				document.getElementById('icountry').value = addr.long_name;
			}
		}
	  //aaaaaaaaaaaaaaaa
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}
//update Marker Status
function updateMarkerStatus(str) {
  	document.getElementById('imarkerStatus').value = str;
}
//update Marker Position
function updateMarkerPosition(latLng) {
  	document.getElementById('ilatitude').value = latLng.lat();//.toFixed(5);
	document.getElementById('ilongitude').value = latLng.lng();//.toFixed(5);
}
//update Marker Adress
function updateMarkerAddress(str) {
  document.getElementById('iaddress').value = str;
}
/*End Update Marker*/

//google.maps.event.addDomListener(window, 'load', initialize);
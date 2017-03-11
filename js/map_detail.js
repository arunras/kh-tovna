/*Global Variable*/
var mapDetail;
var iwDetail;
var pbDetail;
var markerDetail;
var geocoder = new google.maps.Geocoder();
var lat = json.card[0].latitude; //11.567826;
var lng = json.card[0].longitude; //104.916687;
var city, country;
var currentCenter;

var latLng = new google.maps.LatLng(lat, lng);

/*Global Variable*/
//initializeDetail();
function initializeDetail() {
	var mapOptions = {
		center: latLng,
		zoom: 15,
		mapTypeControl: true,
		navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};
	mapDetail = new google.maps.Map(document.getElementById('mapCanvasDetail'), mapOptions);
	currentCenter = mapDetail.getCenter();
	
	markerDetail = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
		optimized: false,
		draggable: isOwner(),
		icon: json.card[0].cardmarker,
			//animation: google.maps.Animation.DROP
	});
	markerDetail.setMap(mapDetail);
	google.maps.event.addListener(markerDetail, 'click', showInfoBoxDetail());
	google.maps.event.trigger(markerDetail,'click');
	
	//Marker Update===
	// Update current position info.
	updateMarkerPosition(latLng);
	geocodePosition(markerDetail.getPosition());
	
	// Add dragging event listeners.
	google.maps.event.addListener(markerDetail, 'dragstart', function() {
		updateMarkerAddress('Dragging...');
		clearInfoWindow();
	});
	
	google.maps.event.addListener(markerDetail, 'drag', function() {
		//updateMarkerStatus('Dragging...');
		updateMarkerPosition(markerDetail.getPosition());
		geocodePosition(markerDetail.getPosition());
	});
	
	google.maps.event.addListener(markerDetail, 'dragend', function() {
		//updateMarkerStatus('Drag ended');
		//geocodePosition(markerDetail.getPosition());
		clickMarker();
		updateLocation();
	});
	google.maps.event.addListener(markerDetail, 'mouseup', function() {
		//updateLocation();
	});
	//end Marker Update===
	
	initProgressBar();
}
//clearInfoWindow:
function clearInfoWindow(){
	if(iwDetail){
		iwDetail.close();
		iwDetail = null;
    }
}
function showInfoWindowDetail() {
	var infoOptions = {
        	content: getIWContentDetail(),
        	maxWidth: 500,
        	pixelOffset: new google.maps.Size(0,15)
    };
	return function() {
        clearInfoWindow();
		iwDetail = new google.maps.InfoWindow(infoOptions);
		iwDetail.open(mapDetail, markerDetail);
    };
}
function showInfoBoxDetail() {
    var infoOptions = {
             content: getIWContentDetail()
            ,disableAutoPan: false
            ,maxWidth: 0
            ,pixelOffset: new google.maps.Size(-140, 0)
            ,zIndex: 1000000
            ,boxStyle: { 
              background: "url('"+location.protocol+"//"+location.host+"/images/tipbox.gif') no-repeat"
            	  //location.protocol+"//"+location.host+
              ,opacity: 0.80
              ,width: "280px"
              ,marginTop: "-8px"
             }
            ,closeBoxMargin: "10px 2px 2px 2px"
            ,closeBoxURL: location.protocol+"//"+location.host+"/images/close.gif"
            ,infoBoxClearance: new google.maps.Size(1, 1)
            ,isHidden: false
            ,pane: "floatPane"
            ,enableEventPropagation: false
    };
	return function() {
	   clearInfoWindow();
	   iwDetail = new InfoBox(infoOptions);
	   iwDetail.open(mapDetail, markerDetail);
       /*iw = new google.maps.InfoWindow({content: getIWContent(i)});iw.open(map, markers[i]);*/
   };
}
//getIWContent: get card content
function getIWContentDetail() {
	//alert(json.card.cardid);
	var locationText='';
	var cardid = json.card[0].cardid;
	var title = json.card[0].title;
	var cardimage = json.card[0].cardimage;;
	var locationname = json.card[0].locationname;
	var city = json.card[0].city;
	var country = json.card[0].country;
	var categoryname = json.card[0].categoryname;
	var username = json.card[0].username;
	var userUrl = window.location.protocol+"//"+location.host+"/profile/show/"+username;
	//var cardUrl = cardid;
	
    if(locationname!='' || locationname!=null) {locationText = locationname;}
    if(city!='' || city!=null ){locationText += ', '+city;}
    if(country!='' || country!=null) {locationText += ', '+country;}
    
    var infoContent = "<div id='infoBox'>";
	infoContent += "<table>";
	infoContent += "<tr><td rowspan='3' class='tdImg'><img src='"+cardimage+"' class='cardImg'/></td>";
	infoContent += "<td class='subject'>"+title+"<span class='userName'>by:<a href='"+userUrl+"' class='userName'>"+username+"</a></span></td></tr>";
	infoContent += "<tr><td class='location'>"+locationText+"</td></tr>";
	//infoContent += "<tr><td><div class='category'><img src='"+path+"' class='category_icon'/><span>"+mcolle.cards[i].categoryname+"</span></div></td></tr>";
	infoContent += "<tr><td><div class='category'><div class='categoryColor color"+categoryname+"'></div><div class='categoryName name"+categoryname+"'>"+categoryname+"</div></div></td></tr>";
	infoContent += "</table>";
	infoContent += "</div>";

	return infoContent;
}
function clickMarker() {
    //google.maps.event.trigger(markerDetail, "click");
	mapDetail.panTo(markerDetail.getPosition());
}


/*Update Marker==*/
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
				city = addr.long_name;
				document.getElementById('icity').value = city;
			}
			if (addr.types[0] == "country"){
				//alert (addr.short_name);
				country = addr.long_name;
				document.getElementById('icountry').value = country;
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
	lat = latLng.lat();
	lng = latLng.lng();
	document.getElementById('ilatitude').value = lat;//.toFixed(5);
	document.getElementById('ilongitude').value = lng;//.toFixed(5);
}
//update Marker Adress
function updateMarkerAddress(str) {
document.getElementById('iaddress').value = str;
}

function updateLocation(){
	var urlUpdate = location.protocol+"//"+location.host+"/browse/UpdateCardLocation?cardid="+json.card[0].cardid+"&latitude="+lat+"&longitude="+lng+"&city="+city+"&country="+country;
	jQuery.ajax({
		url: urlUpdate,
		success: function(data){
			getProgressBar();
		}
	});
}
function setMarkerToCenterMap(){
	google.maps.event.trigger(mapDetail, 'resize');
	mapDetail.setCenter(currentCenter);
}
/*End Update Marker==*/

function getCurrentUser(){
    urlUserID = location.protocol+"//"+location.host+"/user/getCurrentUser";
    return $.ajax({
			url: urlUserID,
			async : false,
    }).responseText;
}
function isOwner(){
	if(getCurrentUser()==json.card[0].userid){return true;}
	else{ return false;}
}

//setProgressBar
function initProgressBar(){
	pbOption = {
			height:		'1.3em',
			width:		'16px',
			background: 'rgba(250,200,200,0.2)',
			colorBar: 	'#F3A1A1',
			opacity:	'0.5',
			border:		'0px solid #555',
			text:		'',
			loadingImg:	'../images/loading_update.gif'
	};
	pbDetail = new progressBar(pbOption);
	mapDetail.controls[google.maps.ControlPosition.RIGHT].push(pbDetail.getDiv());
}
//getProgressBar
function getProgressBar(i){
	pbDetail.start(1);
	pbDetail.updateBar();
	setTimeout(pbDetail.hide, '1000');
}

//google.maps.event.addDomListener(window, 'load', initializeDetail);
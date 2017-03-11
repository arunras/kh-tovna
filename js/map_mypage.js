/*Map: load cards*/
var selectType = 'myCard';

function initialize() {
    var myLatlng = new google.maps.LatLng(11.560342, 104.917545);
    var myOptions = {
      zoom: 13,
      zIndex: 1,
      center: myLatlng,
      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('mapCanvasMypage'), myOptions);
    google.maps.event.addListener(map, 'tilesloaded', tilesLoaded);
    getMyLocation();
    initProgressBar();
}

/*RUN function*/
//search: search card near by
function search(){
	//clearResults();
    clearMarkers();
    clearModelCarousel();
    //clearInfoWindow();
    var bounds = map.getBounds();
    var swLat = bounds.getSouthWest().lat();
    var swLng = bounds.getSouthWest().lng();
    var neLat = bounds.getNorthEast().lat();
    var neLng = bounds.getNorthEast().lng();
    /*
    var centerLat = map.getCenter().lat();
    var centerLng = map.getCenter().lng();
    */
    //var urlCard = location.protocol+"//"+location.host+"/card/getCardJsonData?centerLat="+centerLat+"&centerLng="+centerLng;
    var urlCard;
    switch (selectType){
    	case 'myCard': urlCard = location.protocol+"//"+location.host+"/card/getMyCardJsonData?swLat="+swLat+"&swLng="+swLng+"&neLat="+neLat+"&neLng="+neLng; break;
    	case 'myFriend': urlCard = location.protocol+"//"+location.host+"/card/getMyFriendCardJsonData?swLat="+swLat+"&swLng="+swLng+"&neLat="+neLat+"&neLng="+neLng; break;
    	case 'wantVisit': urlCard = location.protocol+"//"+location.host+"/card/getWantVisitCardJsonData?swLat="+swLat+"&swLng="+swLng+"&neLat="+neLat+"&neLng="+neLng; break;
    	case 'beenHere': urlCard = location.protocol+"//"+location.host+"/card/getBeenHereCardJsonData?swLat="+swLat+"&swLng="+swLng+"&neLat="+neLat+"&neLng="+neLng; break;
    	default: urlCard = location.protocol+"//"+location.host+"/card/getMyCardJsonData?swLat="+swLat+"&swLng="+swLng+"&neLat="+neLat+"&neLng="+neLng;
    }
  	$.getJSON(urlCard, function(json){
  		mcolle = json;
  		totalCard = mcolle.cards.length;
  		// loop through the posts here
		for(var i = 0; i < totalCard; i++) {
			id = json.cards[i].cardid;
			createMarker(i, id);
  		}
		modelCarousel.size(totalCard);
	});
}
/*end RUN function*/

google.maps.event.addDomListener(window, 'load', initialize);
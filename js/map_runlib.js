/*runlib use for TOP page and MYPAGE*/

/*Global Variable*/
var map, iw, pb;
var markers = [];
var markerList = [];
var highestZIndex = 0;
var mcolle;
var totalCard = 0;
/*end Global Variable*/

//tilesLoaded: map event load card
function tilesLoaded() {
    google.maps.event.clearListeners(map, 'tilesloaded');
    google.maps.event.addListener(map, 'zoom_changed', search);
    google.maps.event.addListener(map, 'dragend', search);
    //google.maps.event.addListener(map, 'idle', search);
    search();
}
/*==CREATE==========================================================================*/
//createMarker: creat marker
function createMarker(i, id){
	//id = mcolle.cards[i].cardid;
	title = mcolle.cards[i].title;
	cardimage = mcolle.cards[i].cardimage;
	cardcategory = mcolle.cards[i].categoryname;
		markers[id] = new google.maps.Marker({
			id: id,
		position: new google.maps.LatLng(mcolle.cards[i].latitude, mcolle.cards[i].longitude),
		//zIndex: i, //// important!
		optimized: false,
		title: mcolle.cards[i].title,
		icon: mcolle.cards[i].cardmarker,
			//animation: google.maps.Animation.DROP
        });
		// assign a custom variable to this markers[id] containing the zIndex  
	    markers[id].set("myZIndex", markers[id].getZIndex());
	    // add mouseover and mouseout events to first marker
	    google.maps.event.addListener(markers[id], "click", function() {  
        getHighestZIndex(id);  
        this.setOptions({zIndex:highestZIndex});  
    });
	    google.maps.event.addListener(markers[id], "mouseover", function() {  
	        getHighestZIndex(id);  
	        this.setOptions({zIndex:highestZIndex});  
	    });  
	    google.maps.event.addListener(markers[id], "mouseout", function() {  
	        this.setOptions({zIndex:this.get("myZIndex")});  
	    });
		
		google.maps.event.addListener(markers[id], 'click', showInfoWindow(i,id));//getDetails(mcolle.cards[i].name, i));//
		setTimeout(dropMarker(id), i * 0);
    //addResult(mcolle.cards[i].cardid, i);
		
    modelCarousel.add(i, getCardType(id,title,cardimage, cardcategory));
}

//dropMarker: put marker to map
function dropMarker(i) {
	return function() {
		//getProgressBar(i);
		markers[i].setMap(map);
		if(!markerList[i]){
			markerList[i] = markers[i];
		}
    };
}
//addResult: make sidebar thumbnail
function addResult(result, i) {
	var results = document.getElementById('results');
	var li = document.createElement('li');
	var name = document.createTextNode(result);
	li.style.float = "left";
	li.style.marginLeft = "10px";
	li.onclick = function(){
		google.maps.event.trigger(markers[i],'click');
	};
	li.appendChild(name);
	results.appendChild(li);
}
/*==endCREATE==========================================================================*/
/*==CLEAR==========================================================================*/
//clearResults: clear sidebar thumbnail
function clearResults() {
    var results = document.getElementById('results');
    while (results.childNodes[0]) {
      results.removeChild(results.childNodes[0]);
    }
  }
//clearMarker: clear all marker
function clearMarkers() {
	for (var i = 0; i < markers.length; i++) {
      if (markers[i]) {
        markers[i].setMap(null);
        markers[i] == null;
      }
    }
}
//clearMarker: clear all marker
function removeMarker(i) {
	markerList[i].setMap(null);
    markerList[i] == null;
    alert('removed_'+i);
}
function isInViewport(i) {
    return map.getBounds().contains(markerList[i].getPosition());
}
//clearMarker: clear all marker
function clearMarkersOutOfViewPort() {
	$.each(markerList, function(index, value) {
		if(!isInViewport){
			markerList[index].setMap(null);
	        markerList[index] == null;
	        alert(index + ': ' + markers[index]);
		};
	});
}
//clearInfoWindow
function clearInfoWindow(){
	if(iw){
        iw.close();
        iw = null;
    }
}
/*==endCLEAR==========================================================================*/
/*==GETSHOW==========================================================================*/
//showInfoWindow
function showInfoWindow(i, id) {
	var infoOptions = {
        	content: getIWContent(i, id),
        	maxWidth: 500,
        	pixelOffset: new google.maps.Size(0,15)
    };
	return function() {
        //clearInfoWindow();
		if(iw){
	        iw.close();
	        iw = null;
	    }
	    iw = new google.maps.InfoWindow(infoOptions);
	    iw.open(map, markers[id]);
        /*iw = new InfoBox(infoOptions);iw.open(map, markers[i]);*/
    };
}
//showInfoBox
function showInfoBox(i) {
    var infoOptions = {
             content: getIWContent(i)
            ,disableAutoPan: false
            ,maxWidth: 0
            ,pixelOffset: new google.maps.Size(-140, 0)
            ,zIndex: 1000000
            ,boxStyle: { 
              background: "url('images/tipbox.gif') no-repeat"
              ,opacity: 0.80
              ,width: "280px"
              ,marginTop: "-8px"
             }
            ,closeBoxMargin: "10px 2px 2px 2px"
            ,closeBoxURL: "images/close.gif"
            ,infoBoxClearance: new google.maps.Size(1, 1)
            ,isHidden: false
            ,pane: "floatPane"
            ,enableEventPropagation: false
    };
	return function() {
       clearInfoWindow();
       iw = new InfoBox(infoOptions);
       iw.open(map, markers[i]);
       /*iw = new google.maps.InfoWindow({content: getIWContent(i)});iw.open(map, markers[i]);*/
   };
}
//getIWContent: get card content
function getIWContent(i, id) {
	
	var locationText='';
	var cardid = mcolle.cards[i].cardid;
	var title = mcolle.cards[i].title;
	var cardimage = mcolle.cards[i].cardimage;
	var locationname = mcolle.cards[i].locationname;
	var city = mcolle.cards[i].city;
	var country = mcolle.cards[i].country;
	var categoryname = mcolle.cards[i].categoryname;
	var username = mcolle.cards[i].username;
	var userurl = window.location.protocol+"//"+location.host+"/profile/show/"+username;
	
    if(locationname!='' || locationname!=null) {
    	locationText = locationname;
    }
    if(city!='' || city!=null ){
    	locationText += ', '+city;
    }
    if(country!='' || country!=null) {
    	locationText += ', '+country;
    }
	/*
	var path = "data/card/thum/test_thumbnail.jpg";
	var subject = "	Trip to Ratanakiri";
	//var locationText = "Ratanakiri Province, Ratanakiri, Cambodia";
	var category = "category";
	*/
    
	var infoContent = "<div id='infoWindow'>";
	infoContent += "<table>";
	infoContent += "<tr><td rowspan='3' class='tdImg'><img src='"+cardimage+"' class='cardImg' onclick='clickCard("+cardid+")'/></td>";
	infoContent += "<td class='subject'><span class='title' onclick='clickCard("+cardid+")'>"+title+"</span><span class='userName'>by:<a href='"+userurl+"' class='userName'>"+username+"</a></span></td></tr>";
	infoContent += "<tr><td class='location'>"+locationText+"</td></tr>";
	//infoContent += "<tr><td><div class='category'><img src='"+path+"' class='category_icon'/><span>"+mcolle.cards[i].categoryname+"</span></div></td></tr>";
	infoContent += "<tr><td><div class='category'><div class='categoryColor color"+categoryname+"'></div><div class='categoryName name"+categoryname+"'>"+categoryname+"</div></div></td></tr>";
	infoContent += "</table>";
	infoContent += "</div>";

	return infoContent;
}
//getMyLocation: get current location
function getMyLocation(){
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			var myMarker = new google.maps.Marker({
			      position: latLng, 
			      map: map,
			      zIndex: 1,   
			      //animation: google.maps.Animation.BOUNCE,
			      icon: 'images/mylocation.png',
			      title:"You are here!"
			});
			google.maps.event.addListener(myMarker, "mouseover", function() {  
  		        this.setOptions({zIndex:1000000});  
  		    });  
  		    google.maps.event.addListener(myMarker, "mouseout", function() {  
  		        this.setOptions({zIndex:1});  
  		    });
			
			var myiw = new google.maps.InfoWindow({
				content: 'Location found using HTML5.',
			});
			//google.maps.event.addListener(myMarker,'click', function(){ return myiw.open(map, myMarker);});
			//myiw.open(map, myMarker);
			/*
			google.maps.event.addListener(myMarker, 'click', function() { 
				  if (this.getAnimation() != null) { this.setAnimation(null); } 
				  else { this.setAnimation(google.maps.Animation.BOUNCE); } });
			*/
			map.setCenter(latLng);
			}, function() {
					handleNoGeolocation(true);
				});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
    }
}
//handleNoGeolocation
function handleNoGeolocation(errorFlag) {
	var content;
    if (errorFlag) {
    	content = 'Error: The Geolocation service failed.';
    } else {
    	content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
      map: map,
      position: new google.maps.LatLng(60, 105),
      content: content
    };
    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}
//getHighestZIndex: Marker to front on hover
function getHighestZIndex(id){  
    
    // if we haven't previously got the highest zIndex  
    // save it as no need to do it multiple times  
    if (highestZIndex==0) {  
        if (markers.length>0) {  
            // loop through markers  
            //for (var i=0; i<markers.length; i++) {
                tempZIndex = markers[id].getZIndex();  
                // if this zIndex is the highest so far  
                if (tempZIndex>highestZIndex) {  
                    highestZIndex = tempZIndex;  
                }  
            //}  
        }  
    }  
    return highestZIndex;     
}
//setProgressBar
function initProgressBar(){
	pbOption = {
			height:		'1.3em',
			width:		'108px',
			background: 'rgba(250,200,200,0.2)',
			colorBar: 	'#F3A1A1',
			opacity:	'0.5',
			border:		'1px solid #CCC'
	};
	pb = new progressBar(pbOption);
	map.controls[google.maps.ControlPosition.RIGHT].push(pb.getDiv());
}
//getProgressBar
function getProgressBar(i){
	pb.start(totalCard);
	if(i<totalCard-1){pb.updateBar(i+1);}
	else{pb.hide();}
}
/*==endGETSHOW==========================================================================*/
/*Menu Event*/
//var card_type: retrieve from file map.js to use in map search
$(document).ready(function(){
	getCarousel();	
	
	$('#imycard').click(function(e){
		selectType = 'myCard';
		//ajax_getData("all");
		/*
		e.preventDefault();
		card_type = 'All';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
		*/
		search();
	});
	$('#imyfriend').click(function(e){
		selectType = 'myFriend';
		search();
	});
	$('#iwantvisit').click(function(e){
		selectType = 'wantVisit';
		search();
	});
	$('#ibeenhere').click(function(e){
		selectType = 'beenHere';
		search();
	});
});

/*end Menu Evnent*/
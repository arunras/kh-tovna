/*Menu Event*/
//var card_type: retrieve from file map.js to use in map search
$(document).ready(function(){
	
	$('.item a.all').css('background-image','url("../images/btn_all_ON.png")');
	$('.item a').live('click', function(e){
		
		$('.item a').css('background-image','');	
		if ($(this).attr('class') == 'eat') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_eat_ON.png")');
		}
		else if ($(this).attr('class') == 'event') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_event_ON.png")');
		}
		else if ($(this).attr('class') == 'stay') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_stay_ON.png")');
		}
		else if ($(this).attr('class') == 'beauty') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_beauty_ON.png")');
		}
		else if ($(this).attr('class') == 'travel') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_travel_ON.png")');
		}
		else if ($(this).attr('class') == 'purchase') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_purchase_ON.png")');
		}
		else if ($(this).attr('class') == 'etc') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_etc_ON.png")');
		}
		else if ($(this).attr('class') == 'all') {
			e.preventDefault();
			$(this).css('background-image','url("../images/btn_all_ON.png")');
		}
		
	});
	
	getCarousel();
	$('#all').click(function(e){
		//ajax_getData("all");
		e.preventDefault();
		card_type = 'All';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#eat').click(function(e){
		e.preventDefault();
		//ajax_getData("eat");
		card_type = 'Eat';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#event').click(function(e){
		//ajax_getData("event");
		e.preventDefault();
		card_type = 'Event';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();	
	});
	$('#travel').click(function(e){
		e.preventDefault();
		//ajax_getData("travel");
		card_type = 'Travel';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#stay').click(function(e){
		e.preventDefault();
		//ajax_getData("stay");
		card_type = 'Stay';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#purchase').click(function(e){
		//ajax_getData("purchase");
		e.preventDefault();
		card_type = 'Purchase';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#beauty').click(function(e){
		//ajax_getData("beauty");
		e.preventDefault();
		card_type = 'Beauty';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#etc').click(function(e){
		e.preventDefault();
		//ajax_getData("etc");
		card_type = 'Etc';
		search();
		clearInfoWindow();
		
		clearModelCarousel();
		getCarousel();
	});
	$('#thum').click(function(e){
		return true;
	});
	$('#map').click(function(e){
		//ajax_getData("map");
	});
	
});

/*end Menu Evnent*/
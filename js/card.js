$(document).ready(function(){
	
	$('.card-top-btn a').live('click', function(e){
		e.preventDefault();
		
		$('.card-top-btn a').css('background-image','');
		$(".btn-eat input").val("OFF");
		$(".btn-event input").val("OFF");
		$(".btn-stay input").val("OFF");
		$(".btn-beauty input").val("OFF");
		$(".btn-travel input").val("OFF");
		$(".btn-purchase input").val("OFF");
		$(".btn-etc input").val("OFF");
		
		if ($(this).attr('class') == 'btn-eat') {
			$(this).css('background-image','url("../images/btn_eat_ON.png")');
			$(".btn-eat input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-event') {
			$(this).css('background-image','url("../images/btn_event_ON.png")');
			$(".btn-event input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-stay') {
			$(this).css('background-image','url("../images/btn_stay_ON.png")');
			$(".btn-stay input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-beauty') {
			$(this).css('background-image','url("../images/btn_beauty_ON.png")');
			$(".btn-beauty input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-travel') {
			$(this).css('background-image','url("../images/btn_travel_ON.png")');
			$(".btn-travel input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-purchase') {
			$(this).css('background-image','url("../images/btn_purchase_ON.png")');
			$(".btn-purchase input").val("ON");
		}
		else if ($(this).attr('class') == 'btn-etc') {
			$(this).css('background-image','url("../images/btn_etc_ON.png")');
			$(".btn-etc input").val("ON");
		}
	});
});
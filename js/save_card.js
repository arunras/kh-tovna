$(document).ready(function(){
	$(".card-bottom-btn .btn-save").live('click', function(e){
		e.preventDefault();
		var categorySeleted = false;
		for(var i=0; i<$('.card-top-btn').find('input').length;i++) {
			if($('.card-top-btn').find('input')[i].value == 'ON') {
				categorySeleted = true;
				break;
			}
		}
		if($(".card-top-date input#date").val() == ""){
			alert('Please select the date you are creating card!');
		}
		else if(!categorySeleted){
			alert('Please select a category of card(eat, event, stay...!)');
			
		}		
		else if($(".card-top-place input#place").val() == ""){
			alert('Please fill the textbox "What are you doing here?"');
			$(".card-top-place input#place").focus();
		}
		else if($(".card-top-map input#place-name").val() == ""){
			alert('Please fill the textbox "What is the name of this place?"');
			$(".card-top-map input#place-name").focus();
		}	
		else {$('#form_createcard').submit();}
	});
});
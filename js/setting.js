
$(document).ready(function(){
	$('#profile-button-save input').live('click', function(e){
		e.preventDefault();
		var new_passwd = $('input#new-password').val();
		var confirm_passwd = $('input#confirm-password').val();
		var old_passwd = $('input#old-password').val(); 
		if(confirm_passwd != '' && new_passwd == ''){
			$('.content .val-error').append('<p>Please enter the new password.</p>');
		}
		else if(new_passwd != '' && confirm_passwd == ''){
			$('.content .val-error').append('<p>Please confirm the password.</p>');
		}
		else if((new_passwd != '' && confirm_passwd != '') && (new_passwd != confirm_passwd)){
			$('.content .val-error').append('<p>Confirm password not match.</p>');
		}
		else if(new_passwd != '' && old_passwd == '') {
			$('.content .val-error').append('<p>Please enter the correct old password.</p>');
		}
		else {
			$('#profile-save').submit();
		}
	});
	
});
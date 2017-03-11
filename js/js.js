$(document).ready(function(){
	$('.profile-name').mousemove(function(e){
		showProfileMenu(e);
	});
	$('#nav-pro-logged a.friend').click(function(e){
		e.preventDefault();
		showFriendNotification(e);
	});
	$('#nav-pro-logged a.notification').click(function(e){
		e.preventDefault();
		showNotification(e);
	});
});
$(document).click(function(){
	$('#pop_profilemenu').css('visibility','hidden');
	$('#pop-profilechanger').css('visibility','hidden');
	$('#pop_notification').css('visibility','hidden');
});
function showFriendNotification(e){
	$.ajax({
		url: location.protocol+"//"+location.host + "/notification/showFriendNotification",
		success:function(msg){
			$('#pop_notification').html(msg);
			var profiletag = $('#nav-pro-logged a.friend');
			var x = profiletag.offset().left;
			var y = profiletag.offset().top;
			$('#pop_notification').css('visibility','visible');
			$('#pop_notification').css('left',x-90);
			$('#pop_notification').css('top',y+20);
			$('#pop_profilemenu').css('visibility','hidden');
		}
	});
}
function showNotification(){
	$.ajax({
		url: location.protocol+"//"+location.host + "/notification/showNotification",
		success:function(msg){
			$('#pop_notification').html(msg);
			var profiletag = $('#nav-pro-logged a.friend');
			var x = profiletag.offset().left;
			var y = profiletag.offset().top;
			$('#pop_notification').css('visibility','visible');
			$('#pop_notification').css('left',x-120);
			$('#pop_notification').css('top',y+20);
			$('#pop_profilemenu').css('visibility','hidden');
		}
	});
}
function showProfileMenu(e){
	var profiletag = $('.profile-name');
	var x = profiletag.offset().left;
	var y = profiletag.offset().top;
	$('#pop_profilemenu').css('visibility','visible');
	$('#pop_profilemenu').css('left',x);
	$('#pop_profilemenu').css('top',y+12);
	$('#pop_notification').css('visibility','hidden');
}
function add_friend(a,nu){
	
	$.ajax({
		url:location.protocol + "//" + location.host + "/friend/addFriend/" + nu,
		success:function(msg){
			location.reload();
		}
	});
	return false;
}
function remove_notification(a,ni){
	$.ajax({
		url:location.protocol + "//" + location.host + "/notification/remove_notification",
		data:{ni:ni},
		type:'post',
		success:function(msg){
			//alert(msg);
			location.reload();
		}
	});
	return false;
}
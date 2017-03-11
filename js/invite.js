var base_url;
$(document).ready(function(){
	base_url = location.protocol + "//" + location.host;
	$('div.invite-friend').click(function(e){
		e.preventDefault();
		getAllFriendFromFacebook();
	});
});

function getAllFriendFromFacebook(){
	var url = location.toString();
	var state="";
	tem = url.split("?");
	if(tem.length==2){
		//alert(tem[1]);
		state = tem[1];
	}	
	//return false;
	$.ajax({
		url: base_url + "/invite/getAllFriendFromFacebook?"+state,
		type:'POST',
		dataType:'json',
		success:function (data,status){
			if(data.status=="error_login"){
				if(confirm("This invitation need to login in Facebook. Do you want to continue and login Facebook?")){
					//window.location=data.msg;
					pop_upAskPermissionFacebook(data.msg);
				}
			}
			else if(data.status=="error"){
				alert("Error: " + data.msg);
				window.location.reload();
			}
			else if(data.status=="success"){
				
				$('#pop-profileuploader').html(data.msg);
				
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
				$('#mask').css({'width':maskWidth,'height':maskHeight});
				$('#mask').fadeIn(1000);
				$('#mask').fadeTo('slow',0.8);
				
				var winH = $(window).height();
				var winW = $(window).width();
				var id = $('#pop-profileuploader');
				id.css('top',(winH/2)-(id.height()/2));
				id.css('left',(winW/2)-(id.width()/2));
				id.fadeIn(1000);
			}
		}
	});
}
function pop_upAskPermissionFacebook(url){
	var winH = $(window).height();
	var winW = $(window).width();
	var x = winW/2-(940/2);
	var y = winH/2-(480/2);
	window.open(base_url + '/invite/pop_facebookRequest', '', 'height=480,width=940,resizable=no,scroolbars=no,location=no,toolbar=no,screenX='+x+',screenY='+y, false);
}
function invite_friend(fid){
	$.ajax({
		url: base_url + "/invite/invite_friend?state=",
		data:{fid:fid},
		type:'POST',
		dataType:'json',
		success:function(data,status){
			if(data.status=="error_login"){
				if(confirm("This invitation need to login in Facebook. Do you want to continue and login Facebook?")){
					window.location=data.msg;
				}
			}
			else if(data.status=="error"){
				alert("Error: " + data.msg);
			}
			else{
				alert('The invitation have been post in his/her wall');
			}
		}
	});
	return false;
}
function searchMyCard(){
	var txt = $('#search_cancel');
	triggerMarker(10);
}
var page=1;
$(document).ready(function() {
	
	$(window).scroll(function() {    
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
        	load_more();
        }
	});
	
	$('div#col-btn a.btn-add').click(function(e){
		e.preventDefault();
		//alert($(this).attr('href'));
		addFriend($(this));
	});
	$('div#col-btn a.btn-remove').click(function(e){
		e.preventDefault();
		removeFriend($(this));
	});
	$('div#col-btn a.btn-cancel-friend').click(function(e){
		e.preventDefault();
		cancelRequestFriend($(this));
	});
	$('div#col-btn a.btn-confirm-friend').click(function(e){
		e.preventDefault();
		confirmRequest($(this));		
	});
});
function confirmRequest(a){
	$.ajax({
		url:location.protocol+"//"+ location.host+"/friend/confirmRequest",
		type:'post',
		data:{friendid:a.attr('href')},
		success:function(msg){
			//alert(msg);
			location.reload();
		}
	});
}
function cancelRequestFriend(a){
	$.ajax({
		url:location.protocol+"//"+ location.host+"/friend/cancelRequestFriend",
		type:'post',
		data:{friendid:a.attr('href')},
		success:function(msg){
			//alert(msg);
			location.reload();
		}
	});
}
function addFriend(a){
	$.ajax({
		url:location.protocol+"//"+ location.host+"/friend/addFriendRequest",
		type:'post',
		data:{friendid:a.attr('href')},
		success:function(msg){
			//alert(msg);
			location.reload();
		}
	});
}
function removeFriend(a){
	$.ajax({
		url:location.protocol+"//"+ location.host+"/friend/unfriend",
		type:'post',
		data:{friendid:a.attr('href')},
		success:function(msg){
			//alert(msg);
			location.reload();
		}
	});
}
function unfriend(userid){
			var checkConfirm = confirm('Do you really want to remove your friend?');
			if(checkConfirm == true) {
				$.ajax({
					url: 'friend/unfriend',
					type: 'post',
					cache: false,
					data: {friendid:userid},
					success:function(msg){
						location.reload();
					}
					
				});
				return false;
			}
			else {
				return false;
			}
}
function load_more() {
	var total = $('div.div_paginate').find('input.total_page').val();
	var new_bottom = $('div.news_bottom');
    page = page+1;
    $('div.div_paginate').find('input.page').val(page);
    if(page <= total){
    	new_bottom.addClass("loading");
    }
    else {
        $('span.load_more').show();
    }
    
    $.ajax({
    	type: 'POST',
    	url: 'friend/loadMore',
    	cache: false,
    	data: {
    		page: page,
    	},
    	success: function(msg) {
    		$('div#rows').append(msg);
    		new_bottom.removeClass('loading');
        }
    });
}
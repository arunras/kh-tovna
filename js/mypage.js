$(document).ready(function(){
	$('div.profile-image').mouseover(function(){
		var profileimage = $('div.profile-image');
		var x = profileimage.offset().left;
		var y = profileimage.offset().top;
		$('#pop-profilechanger').css('left',x+5);
		$('#pop-profilechanger').css('top',y+70);
		
		$('#pop-profilechanger').css('visibility','visible');
		$('#pop-profilechanger').slideDown('slow', function(){
			$('#pop-profilechanger').css('visibility','visible');
		});
			
		
	});
	$('div.profile-image').mouseleave(function(){
		$('#pop-profilechanger').delay(1000).fadeOut(500);
	});
	
});
function pop_profilechanger(filename){
	//alert(location.protocol+"//"+location.host);
	$.ajax({
		url: location.protocol+"//"+location.host + "/profile/changeProfile?filename="+filename,
		success:function(msg){
			$('#pop-profileuploader').html(msg);
			
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			$('#mask').fadeIn(1000);
			$('#mask').fadeTo('slow',0.8);
			
			var winH = $(window).height();
			var winW = $(window).width();
			var id = $('#pop-profileuploader');
			id.css('top',(winH/2)-(id.height()/2));
			id.css('left',(winH/2)-(id.width()/2)+320);
			id.fadeIn(1000);
		}
	});
	return false;
}
function close_upload_form(){
	$('#pop-profileuploader').fadeOut(500);
	$('#mask').hide();
	return false;
}
function ajax_upload(){
	$.ajaxFileUpload({
		url:location.protocol+"//"+location.host + "/profile/uploadPicture",
        secureuri:false,
        fileElementId:'userfile',
        dataType:'json',
        success: function (data, status)
        {
           if(data.status == 'error')
           {
              $('#error').html(data.msg);
           }
           else{
               //$('#error').html(location.protocol+"//"+location.host + "/upload/" + data.msg);
               var filename = location.protocol+"//"+location.host + "/data/profiles/" + data.msg;
               /*
               var img_target = $('img#target');
               img_target.attr({src: filename});
               
               var img_pre = $('img#preview');
        	   img_pre.attr({src: filename}) ;
        	   
        	   var img_holder = $('div.jcrop-holder img');
        	   
        	   var real_width =0;
        	   var real_height = 0;
        	   
        	   var img_tem = new Image();
        	   img_tem.onload = function(){
        		   real_width = (this.width);
        		   real_height = this.height;
        		   //alert(real_width);
        	   };
        	   img_tem.src=filename;
        	   
        	   $('.jcrop-holder').removeAttr('style');  
        	   $('.jcrop-holder').attr('style','width: 200px; height: 200px; position: relative; background-color: black;');
        	   
        	   $('.jcrop-tracker').removeAttr('style');
        	   $('.jcrop-tracker').attr('style','width: 200px; height: 200px; position: absolute; top: -2px; left: -2px; z-index: 290; cursor: crosshair;')
        	   /*
        	   $('.jcrop-tracker').css('width',real_width);  width: 250px; height: 324px; position: absolute; top: -2px; left: -2px; z-index: 290; cursor: crosshair;
        	   $('.jcrop-tracker').css('height',real_height);
        	   $('.jcrop-holder').css('width',real_width);
        	   $('.jcrop-holder').css('height',real_height);
        	   
        	   img_holder.attr({src: filename}); //display: block; visibility: visible; width: 246px; height: 320px; border: medium none; margin: 0px; padding: 0px; position: absolute; top: 0px; left: 0px;
        	   img_holder.removeAttr('style');
        	   img_holder.attr('style','display: block; visibility: visible; width: 200px; height: 200px; border: medium none; margin: 0px; padding: 0px; position: absolute; top: 0px; left: 0px;');
        	   */
        	   
        	   $('input#filename').val(filename);
        	   close_upload_form();
        	   pop_profilechanger(filename);
        	   
           }
        }
     });
	return false;
}

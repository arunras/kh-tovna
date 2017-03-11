// For expand map on card detail
//loadScript("js/jquery.min.js");
jQuery(document).ready(function () {
	var mapTimer;
	jQuery('#ibtnMapExpand').click(function(){
		mapTimer = setInterval(setMarkerToCenterMap, 0);
	});
	jQuery('#ibtnMapExpand').toggle(
		function(){
			jQuery('div#mapCanvasDetail').animate({height:'320px'}, 300, 'linear', function(){clearInterval(mapTimer);});
			//jQuery('div#mapCanvasDetail').animate({height:'320px'}, 300, 'linear', setMarkerToCenterMap);
			
			jQuery('#iexpandCollapseIcon').css('background-image','url(../images/btn_map_expand.png)');
		}, 
		function(){
			jQuery('div#mapCanvasDetail').animate({height:'160px'}, 300, 'linear', function(){clearInterval(mapTimer);});
			//jQuery('div#mapCanvasDetail').animate({height:'160px'}, 300, 'linear', setMarkerToCenterMap);
			
			jQuery('#iexpandCollapseIcon').css('background-image','url(../images/btn_map_collapse.png)');
		}
	);
});
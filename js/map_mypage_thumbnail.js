
var modelCarousel = null;
function mycarousel_itemLoadCallback(carousel, state)
{
	modelCarousel = carousel;
};

function getCarousel(){
	jQuery('#mycarousel').jcarousel({
		itemLoadCallback: mycarousel_itemLoadCallback
    });
}
function clearModelCarousel() {
    modelCarousel.reset();
} 
function getCardType(i,title, url, category){
	type = category.toLowerCase();
	var	content = '<div class="cardBox" title="'+title+'" onclick="triggerMarker('+i+')">';
		content += '<div class="bg_base_top"></div>';
		content += '<div class="bg_base_middle">';
			content += '<div class="bg_'+type+'_top"></div>';
			content += '<div class="bg_'+type+'_middle">';
				content += '<img src="' + url + '" width="65px" height="65px"/>';
			content += '</div>';
			content += '<div class="bg_'+type+'_bottom"></div>';
		content += '</div>';
		content += '<div class="bg_base_bottom"></div>';
		content += '</div>';
	return content;
}
function triggerMarker(i){
	google.maps.event.trigger(markers[i],'click');
};














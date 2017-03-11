
var modelCarousel = null;
function mycarousel_itemLoadCallback(carousel, state)
{
	modelCarousel = carousel;
    // Check if the requested items already exist
	/*
    if (carousel.has(carousel.first, carousel.last)) {
        return;
    }
    jQuery.get(
    	location.protocol+"//"+location.host+"/home/getCardCarousel?cardtype="+card_type,
        {
            first: carousel.first,
            last: carousel.last
        },
        function(xml) {
            mycarousel_itemAddCallback(carousel, carousel.first, carousel.last, xml);
        },
        'xml'
    );
    */
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
	var content = '<div class="cardBox" title="'+title+'" onclick="triggerMarker('+i+')">';
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


/*
 
function mycarousel_itemAddCallback(carousel, first, last, xml)
{
	//carousel.reset();
    carousel.size(parseInt(jQuery('total', xml).text()));
	jQuery('card', xml).each(function(i) {
		var cardid = $(this).find('cardid').text();
		var cardimage = $(this).find('cardimage').text();
		var categoryname = $(this).find('categoryname').text();
		
        //carousel.add(first + i, mycarousel_getItemHTML(jQuery(this).text()));
		carousel.add(first + i, mycarousel_getItemHTML(cardid, cardimage, categoryname));
    });
};
function mycarousel_getItemHTML(id, url, category)
{
	return getCardType(id, url, category);
};
*/












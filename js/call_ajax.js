//var category=null;
//category = card_type; 
var modelCarousel = null;
function mycarousel_itemLoadCallback(carousel, state)
{
	modelCarousel = carousel;
    // Check if the requested items already exist
    if (carousel.has(carousel.first, carousel.last)) {
        return;
    }
    //category='Travel';
	//alert(category);
    jQuery.get(
		//location.protocol+"//"+location.host+"/home/displayPicture?pa=va1&pa2=val2&pa3=va3",
    		//location.protocol+"//"+location.host+"/home/displayPicture?cardtype="+category,
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
};

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

function getCarousel(){
	jQuery('#mycarousel').jcarousel({
		itemLoadCallback: mycarousel_itemLoadCallback
    });
}
function clearModelCarousel() { 
    modelCarousel.reset();
    /* 
    theModelCarousel.add(0,someImageURL1); 
    theModelCarousel.add(1,someImageURL2); 
    theModelCarousel.size(2); 
    */
} 
function infoB(id){
	alert(id);	
}
/*function getJson(carousel,first,last){
$.getJSON(
	llocation.protocol+"//"+location.host+"/home/jsonData",
	function(jsonData){
		$.each(jsonData,function(key,value){								
			carousel.add(first+key,getHtml(value));	
		});
	}
);	
}
function getHtml(value){
alert(value);
//return value;
}*/
function getCardType(id, url, category){
	type = category.toLowerCase();
	var	content = '<div class="bg_base_top"></div>';
		content += '<div class="bg_base_middle">';
			content += '<div class="bg_'+type+'_top"></div>';
			content += '<div class="bg_'+type+'_middle">';
				content += '<a href="#'+id+'" onclick="triggerMarker('+id+')"><img src="' + url + '" width="65px" height="65px"/></a>';
			content += '</div>';
			content += '<div class="bg_'+type+'_bottom"></div>';
		content += '</div>';
		content += '<div class="bg_base_bottom"></div>';
	return content;
}
function triggerMarker(i){
	google.maps.event.trigger(markers[i],'click');
};















function clickCard(cardid){
    //var timestamp = Number(new Date());
    var timestamp = cardid;
    var urlcard = location.protocol + "//" + location.host + "/browse/popcarddetail/" + timestamp;
    $.ajax({
        type: "post",
        url:location.protocol + "//" + location.host + "/browse/popcarddetail/" + timestamp,
        data: { cardid : cardid,
                urlcard :urlcard 
            },
        cache: false,
        success:function(msg){

            jQuery('#pop_card_detail').html(msg);
                var maskHeight = jQuery(document).height();
                var maskWidth = jQuery(document).width();


                var winH = jQuery(window).height();
                var winW = jQuery(document).width();

                jQuery('#mask_detail').css({'width':maskWidth,'height':maskHeight});
                jQuery('#mask_detail').fadeIn(1000);
                jQuery('#mask_detail').fadeTo('slow',0.8);

            var id = jQuery('#pop_card_detail');
            var id_width = id.width();
            var id_height = id.height();

            var x = (winW/2) - (id_width/2);
            var y = (winH/2) - (id_height/2);

            id.css('top',10);
            id.css('left',x);
            id.fadeIn(1000);
                }
		});
}
function close_detail(){
    jQuery('#pop_card_detail').fadeOut(500);
  //  jQuery('#mask_detail').html('');
    jQuery('#mask_detail').hide();
    return false;
}
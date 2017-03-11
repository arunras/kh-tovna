
$(document).ready(function(){
    jQuery('div#footer').css('display','none');
    
    /* refresh */
    var cate_hash = window.location.hash;
    if(cate_hash !=""){
        cate_hash = cate_hash.split("#");
    
        if(cate_hash[1] == "eat") {
             show_filter(1);
        }
        else if(cate_hash[1] == "event") {
             show_filter(2);
        }
        else if(cate_hash[1] == "stay") {
              show_filter(4);
        }
        else if(cate_hash[1] == "beauty") {
              show_filter(6);
        }
        else if(cate_hash[1] == "travel") {
             show_filter(3);
        }
        else if(cate_hash[1] == "purchase") {
             show_filter(5);
        }
        else if(cate_hash[1] == "etc") {
             show_filter(7);
        }
        else {
            show_filter(0);
        }
    }
    else {
        show_filter(0);
    }
   
 // click load more
            jQuery('span.load_more').click(function(){
                
                var total = jQuery('div.div_paginate').find('input.total_page').val();
                var page = jQuery('div.div_paginate').find('input.page').val();
                
                var hash = window.location.hash;
                hash = hash.split("#");
                var categoryid = get_categoryid(hash[1]);
                
                jQuery.ajax({
                    type: 'post',
                    url:location.protocol + "//" + location.host + "/browse/morecards",
                    data: {
                        categoryid: categoryid,
                        page: page,
                        total_page: total
                    },
                    success:function(msg){
                       // alert(msg);
                        page = parseInt(page)+1;
                        jQuery('div#browse').find('div.div_wrap').append(msg);
                        jQuery('div.div_paginate').find('input.page').val(page);
                        if(page == total){
                            jQuery('span.load_more').hide();
                        }
                        else {
                            jQuery('span.load_more').show();
                        }
                        // click each card
                        
                    }
               });
            });
    
});

jQuery(window).hashchange(function() { 
   // updateState(location.hash);
    var cate_hash = window.location.hash;
    if(cate_hash !=""){
        cate_hash = cate_hash.split("#");
    
        if(cate_hash[1] == "eat") {
             show_filter(1);
        }
        else if(cate_hash[1] == "event") {
             show_filter(2);
        }
        else if(cate_hash[1] == "stay") {
              show_filter(4);
        }
        else if(cate_hash[1] == "beauty") {
              show_filter(6);
        }
        else if(cate_hash[1] == "travel") {
             show_filter(3);
        }
        else if(cate_hash[1] == "purchase") {
             show_filter(5);
        }
        else if(cate_hash[1] == "etc") {
             show_filter(7);
        }
        else {
            show_filter(0);
        }
    }
    else {
        show_filter(0);
    }
});

function get_categoryid(cat_name){
    var cat = 0;
    if(cat_name == "eat"){
        cat = 1;
    }
    else if(cat_name == "event"){
        cat = 2;
    }
    else if(cat_name == "stay"){
        cat = 4;
    }
    else if(cat_name == "beauty"){
        cat = 6;
    }
    else if(cat_name == "travel"){
        cat = 3;
    }
    else if(cat_name == "purchase"){
        cat = 5;
    }
    else if(cat_name == "etc"){
        cat = 7;
    }
    else {
        cat = 0;
    }
    return cat;
}
function click_card(cardid){
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

function show_filter(categoryid){
   
   jQuery.ajax({
       type: 'post',
       url:location.protocol + "//" + location.host + "/browse/cardsbycategory",
       data: {
         categoryid: categoryid
       },
       success:function(data){
            jQuery('div#browse').find('div.div_wrap').html('');
            jQuery('div#browse').find('div.div_wrap').html(data);
            jQuery('div#footer').css('display','block');
            
            var total_page = jQuery('div.ajax_paginate').find('input.total_page').val();
            jQuery('div.div_paginate').find('input.total_page').val(total_page);
            jQuery('div.div_paginate').find('input.page').val(1);
            
            if(total_page == 1 || total_page == jQuery('div.div_paginate').find('input.page').val()) {
                jQuery('div.div_more').find('span.load_more').css('display', 'none');
            }
            else {
                jQuery('div.div_more').find('span.load_more').css('display','block');
            }
            // click on each card    
       }
   });
   
}
function show_popup(url){
    window.open(url,'','menubar=0,toolbar=0,status=0,width=640,height=320');
    return false;
}
function close_detail(){
    jQuery('#pop_card_detail').fadeOut(500);
  //  jQuery('#mask_detail').html('');
    jQuery('#mask_detail').hide();
    return false;
}
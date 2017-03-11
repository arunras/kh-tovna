
$(document).ready(function(){
    // show big pic
    jQuery('img.thumb').click(function(){
        var img_src = jQuery(this).attr('src')
        //alert(img_src);
       // alert(jQuery('div.block_2 div.big_pic').html());
        jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src',img_src);
    });
    // edit title & location name
    jQuery('span.edit').click(function(){
        var start = jQuery('div.left_side div.c_info');
        start.find('div.title').hide();
        start.find('div.location').hide();
        start.find('div.c_date').hide();
        start.find('div.edit_card').show();
    });
    // save edit
    jQuery('input#btn_save').click(function(){
        
        var start = jQuery('div.left_side div.c_info');
        
        var cardid = jQuery('div.popup').find('input#current_cardid').val();
        var title = start.find('div.edit_card input.txt_title').val();
        var locationname = start.find('div.edit_card input.txt_location').val();
       
        if(title == ""){
            start.find('label.red_star1').css('color','red');
            return;
        }
        else {
            start.find('label.red_star1').css('color','white');
        }
        
        if(locationname == ""){
            start.find('label.red_star2').css('color','red');
            return;
        }
        else {
            start.find('label.red_star2').css('color','white');
        }
        
        jQuery.ajax({
                    type: 'post',
                    url:location.protocol + "//" + location.host + "/browse/updateTitle",
                    data: {
                        cardid: cardid,
                        title: title,
                        locationname:locationname
                    },
                    success:function(){
                        //alert(data);
                        start.find('div.edit_card').hide();
                        start.find('div.title').html(title);
                        start.find('div.title').show();
                        start.find('div.location').html(locationname);
                        start.find('div.location').show();
                        start.find('div.c_date').show();
                       
                    }
               }); 
    });
    // cancel
    jQuery('input#btn_cancel').click(function(){
        
        var start = jQuery('div.left_side div.c_info');
            start.find('div.edit_card').hide();
                        
            start.find('div.title').show();
            start.find('div.location').show();
            start.find('div.c_date').show();
        
     });
    
    
    
   // interest
   jQuery('div.interest').click(function(){
       
       var cur_num = parseInt(jQuery(this).find('span.num_want').html());
       var cardid = jQuery('div.popup').find('input#current_cardid').val();
       var re_value = 0;
       if(jQuery(this).find('img').hasClass('wanttovisit_on')) {
           jQuery(this).find('img').removeClass('wanttovisit_on');
           jQuery(this).find('img').addClass('wanttovisit');
           jQuery(this).find('img').attr('src','../images/btn_wanttovisit.png');
           jQuery(this).find('span.num_want').html(cur_num + 1);
           re_value = 1;
       }
       else {
           jQuery(this).find('img').removeClass('wanttovisit');
           jQuery(this).find('img').addClass('wanttovisit_on');
           jQuery(this).find('img').attr('src','../images/btn_wanttovisit_on.png');
           if(cur_num > 0){
               jQuery(this).find('span.num_want').html(cur_num - 1);
           }
           else {re_value = 0};
       }
       
           jQuery.ajax({
                    type: 'post',
                    url:location.protocol + "//" + location.host + "/browse/reviews",
                    data: {
                        cardid: cardid,
                        re_value: re_value,
                        fieldname:'want'
                    },
                    success:function(){
                    }
               }); 
   });
   // beenhere
   jQuery('div.beenhere').click(function(){
       
       var current_num = parseInt(jQuery(this).find('span.num_havebeen').html());
       //alert(current_num);
       var cardid = jQuery('div.popup').find('input#current_cardid').val();
       var re_value = 0;
       if(jQuery(this).find('img').hasClass('Ivbeenhere_on')) {
           jQuery(this).find('img').removeClass('Ivbeenhere_on');
           jQuery(this).find('img').addClass('Ivbeenhere');
           jQuery(this).find('img').attr('src','../images/btn_Ivbeenhere.png');
           jQuery(this).find('span.num_havebeen').html(current_num + 1);
           re_value = 1;
       }
       else {
           jQuery(this).find('img').removeClass('Ivbeenhere');
           jQuery(this).find('img').addClass('Ivbeenhere_on');
           jQuery(this).find('img').attr('src','../images/btn_Ivbeenhere_on.png');
           if(current_num > 0){
               jQuery(this).find('span.num_havebeen').html(current_num - 1);
           }
           else {
               re_value = 0;
           }
       }
           jQuery.ajax({
                    type: 'post',
                    url:location.protocol + "//" + location.host + "/browse/reviews",
                    data: {
                        cardid: cardid,
                        re_value: re_value,
                        fieldname:'beenhere'
                    },
                    success:function(){
                    }
               }); 
   });
   
   // delete photos
   
   jQuery('span.delete_img').click(function(){
       var picid = jQuery(this).siblings('input[type=hidden]').val();
       var src_delete = jQuery(this).siblings('img').attr('src');
       var src_big = jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src');
       var a_delete = jQuery(this).parent('a');
       if(confirm('Are you sure want to delete?')) {
           jQuery.ajax({
               type: 'post',
               url: location.protocol + "//" + location.host + "/browse/deletephoto",
               data: {picid : picid},
               success: function(){
                    a_delete.remove(); 
                    if(src_delete == src_big){
                        var new_src = "";
                        jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src','');

                        new_src = jQuery('div.jTscroller').first('a').find('img.thumb').attr('src');
                        if(new_src != null){
                            jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src', new_src);
                        }
                   }
               }
           });
       }
       else {return;}
       
   });
   
});






